<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class School extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('school_model');
	}

	public function index(){
		$logged_in = $this->session->userdata('isUserLoggedIn');	
		//choose which template to load base from the session/user info
		$type = 'budget';

		($logged_in)?$this->load->view($type):$this->load->view('login');		
	}

	public function auth(){
		$uname = $this->input->post('username');
		$pword = $this->input->post('password');
		$sc_code = $this->input->post('school_code');
		if($uname && $pword && $sc_code){
			$res = $this->user_model->login($uname,$pword,$sc_code);
			if($res->status){
				$tmp = (object)array(
					'isUserLoggedIn' => 'user_scope',
					'user' => (object)$res->data[0]
					);
				$this->session->set_userdata($tmp);
				$type = 'budget'
				redirect("/$type");
			} else{
				$data = (object)array('status'=>'error','message'=>'Username/Password/School Code does not match..!');
				$this->load->view('login',array('response'=>$data));	
			}
		} else {
			$data = (object)array('status'=>'error','message'=>'Missing username or password');
			$this->load->view('login',array('response'=>$data));
		}
	}
}