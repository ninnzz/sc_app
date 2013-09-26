<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('school_model');		
	}

	public function index(){
		$this->user_model->auth();

		$user = $this->session->userdata['user'];
		$this->load->view('admin',array('user'=>$user));
	}

	public function register(){		
		if(!isset($_POST['reg'])){
			$this->load->view('reg');

		} else{
			date_default_timezone_set('EST');
			$date = new DateTime();
			$d = $date->getTimestamp();		
			if($_POST['uname'] != "" && $_POST['password'] != "" && $_POST['role'] !=""){
				if($this->user_model->isValidUserName($_POST['uname'])){
					if($this->school_model->isValidSchoolCode($_POST['school_code'])){
						$params['uname'] = $_POST['uname'];
						$params['password'] = md5($_POST['password']);
						$params['scope'] = $_POST['role'];			
						$params['school_code'] = $_POST['school_code'];			
						$params['date_created'] = $d;			
						$params['date_updated'] = $d;			

						$res = $this->user_model->addUser($params);
						if($res){
							$data = (object)array('status'=>'ok','message'=>'User Added :: '.$params['uname'].'.');
							$this->load->view('reg',array('response'=>$data));
						} else{
							$data = (object)array('status'=>'error','message'=>'Something went wrong in the DB, try again.');
							$this->load->view('reg',array('response'=>$data));
						}
					} else{
						$data = (object)array('status'=>'error','message'=>'Invalid School Code');
						$this->load->view('reg',array('response'=>$data));	
					}
				} else{
					$data = (object)array('status'=>'error','message'=>'Username already taken.');
					$this->load->view('reg',array('response'=>$data));	
				}
			} else{
				$data = (object)array('status'=>'error','message'=>'Missing Username/Password/Role parameter.');
				$this->load->view('reg',array('response'=>$data));	
			}
		}
	}
}