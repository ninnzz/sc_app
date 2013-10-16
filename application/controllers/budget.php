<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Budget extends CI_Controller {
	private $allowed_scope = array('director','cheif_of_work');


	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('school_model');		
		$this->load->model('budget_model');
	}

	public function index(){
		$this->user_model->auth();
		$user = $this->session->userdata['user'];
		$service = $this->budget_model->get_items('service','id,name',null,null,null);
		$domain = $this->budget_model->get_items('domain','id,name,service_id',null,null,null);
		$this->load->view('budget',array('user'=>$user,'service_list'=>$service,'domain_list'=>$domain));
	}
	public function get_item(){
		$this->user_model->auth();
		$user = $this->session->userdata['user'];
		if($this->input->get('budget_level')){
			if(in_array($user->scope, $this->allowed_scope)){
				if($this->input->get('budget_level') == "service"){
					$res = $this->budget_model->get_items('service','id,name,alloted,reserved,in_order,available',array('school_code'=>$user->school_code),null,null);
					print_r(json_encode((object)array('status'=>'ok','message'=>'Service items','data'=>$res)));
				} else if($this->input->get('budget_level') == "domain"){
					$res = $this->budget_model->get_items('domain','id,service_id,name,alloted,reserved,in_order,available',array('school_code'=>$user->school_code,'service_id'=>$this->input->get('service_id')),null,null);
					print_r(json_encode((object)array('status'=>'ok','message'=>'Domain items','data'=>$res)));
				} else if($this->input->get('budget_level') == "activity"){
					$res = $this->budget_model->get_items('activity','id,domain_id,service_id,title,alloted,reserved,in_order,available,color,acronym',array('school_code'=>$user->school_code,'domain_id'=>$this->input->get('domain_id')),null,null);
					print_r(json_encode((object)array('status'=>'ok','message'=>'Activity items','data'=>$res)));
				} else{
					print_r((object)array('status'=>'error','message'=>'Invalid budget level'));	
				}
			} else{
				print_r((object)array('status'=>'error','message'=>'Invalid scope for a user'));	
			}
		} else {
			print_r((object)array('status'=>'error','message'=>'Invalid budget level'));	
		}
	}

	public function add_item(){
		$this->user_model->auth();
		$user = $this->session->userdata['user'];
		if(in_array($user->scope, $this->allowed_scope)){					
			if($this->input->post('budget_level')){
				$method = "input_".$this->input->post('budget_level');
				if(method_exists($this, $method)){
					$params = $this->$method();
					$params['school_code'] = $user->school_code;
					$id = $this->budget_model->insert_item($params,$this->input->post('budget_level'));
					if($id){
						//check here kung kelangang dagdagan or adjust yung upper sa kanya

						$params['id'] = $id;
						print_r(json_encode((object)array('status'=>'ok','message'=>'Added item','data'=>(object)$params)));	

					} else{
						print_r((object)array('status'=>'error','message'=>'Unknown budget level'));	
					}

				} else{
					print_r((object)array('status'=>'error','message'=>'Unknown budget level'));
				}
			} else{
				print_r((object)array('status'=>'error','message'=>'Mising paramters'));	
			}

		} else{
			print_r((object)array('status'=>'error','message'=>'Invalid scope for user'));
		}
	}

	public function delete_item(){
		$this->user_model->auth();
		$user = $this->session->userdata['user'];

		if(in_array($user->scope, $this->allowed_scope)){					
			if($this->input->post('budget_level')){
				$t =$this->input->post('budget_level');
				if($t == "service"){
					$s1 = $this->budget_model->delete_item('activity',array('service_id'=>$this->input->post('id')));
					print_r($s1);
					$s2 = $this->budget_model->delete_item('domain',array('service_id'=>$this->input->post('id')));
					print_r($s2);
					$s3 = $this->budget_model->delete_item('service',array('id'=>$this->input->post('id')));
					print_r($s3);
					die();
					print_r(json_encode((object)array('status'=>'deleted','type'=>'service')));
				} else if($t == "domain"){
					$this->budget_model->delete_item('activity',array('domain_id'=>$this->input->post('id')));
					$t = $this->budget_model->delete_item('domain',array('id'=>$this->input->post('id')));
					if($t){
						$data2 = $this->adjust_budget('service',$this->input->post('service_id'));
						$this->budget_model->update_item('service',$data2,array('id'=>$this->input->post('service_id')));
						print_r(json_encode((object)array('status'=>'deleted','type'=>'domain','service'=>(object)array('id'=>$this->input->post('service_id'),'data'=>$data2))));
					} else{
						print_r((object)array('status'=>'error','message'=>'Error occured'));			
					}
					$this->adjust_budget('service',$this->input->post('service_id'));
				} else if($t == "activity"){
					$t = $this->budget_model->delete_item('activity',array('id'=>$this->input->post('id')));
					if($t){
						$data1 = $this->adjust_budget('domain',$this->input->post('domain_id'));
						$this->budget_model->update_item('domain',$data1,array('id'=>$this->input->post('domain_id')));
						$data2 = $this->adjust_budget('service',$this->input->post('service_id'));
						$this->budget_model->update_item('service',$data2,array('id'=>$this->input->post('service_id')));
						print_r(json_encode((object)array('status'=>'deleted','type'=>'activity','domain'=>(object)array('id'=>$this->input->post('domain_id'),'data'=>$data1),'service'=>(object)array('id'=>$this->input->post('service_id'),'data'=>$data2))));
					} else{
						print_r((object)array('status'=>'error','message'=>'Error occured'));			
					}
				} else{
					print_r((object)array('status'=>'error','message'=>'Invalid budget level'));			
				}
			} else{
				print_r((object)array('status'=>'error','message'=>'Invalid budget level'));			
			}
		} else{
			print_r((object)array('status'=>'error','message'=>'Invalid scope for a user'));		
		}

	}

	/*Budgeting functions*/
	private function adjust_budget($budge_type,$id){
		$str = 'select sum(alloted) as alloted, sum(reserved) as reserved, sum(in_order) as in_order, sum(available) as available from ';
		if($budge_type == "service"){
			$str .= "domain where service_id = {$id} ;";
			return $this->budget_model->adjust_budget($str);
		} else if ($budge_type == "domain") {
			$str .= "activity where domain_id = {$id} ;";
			return $this->budget_model->adjust_budget($str);
		} else{
			return false;
		}
	}

	private function input_service(){
		date_default_timezone_set('EST');
		$date = new DateTime();
		$d = $date->getTimestamp();

		$params['name'] = $this->input->post('sname');
		$params['alloted'] = $this->input->post('alloted');
		$params['reserved'] = $this->input->post('reserved');
		$params['in_order'] = $this->input->post('in_order');
		$params['available'] = $this->input->post('alloted');
		$params['date_created'] = $d;
		$params['date_updated'] = $d;
		return $params;
	}
	private function input_domain(){
		date_default_timezone_set('EST');
		$date = new DateTime();
		$d = $date->getTimestamp();

		$params['name'] = $this->input->post('dname');
		$params['alloted'] = $this->input->post('alloted');
		$params['reserved'] = $this->input->post('reserved');
		$params['in_order'] = $this->input->post('in_order');
		$params['available'] = $this->input->post('alloted');
		$params['service_id'] = $this->input->post('service_id');
		$params['date_created'] = $d;
		$params['date_updated'] = $d;
		return $params;
	}
	private function input_activity(){
		date_default_timezone_set('EST');
		$date = new DateTime();
		$d = $date->getTimestamp();

		$params['title'] = $this->input->post('title');
		$params['alloted'] = $this->input->post('alloted');
		$params['reserved'] = $this->input->post('reserved');
		$params['in_order'] = $this->input->post('in_order');
		$params['available'] = $this->input->post('alloted');
		$params['service_id'] = $this->input->post('service_id');
		$params['domain_id'] = $this->input->post('domain_id');
		$params['color'] = $this->input->post('color');
		$params['acronym'] = $this->input->post('acronym');
		$params['date_created'] = $d;
		$params['date_updated'] = $d;
		return $params;
	}


	/*Budgeting functions*/
}