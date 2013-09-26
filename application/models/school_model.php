<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* School model
* 
* @package      School app
* @category     Model
* @author       Nino Eclarin | neclarin@stratpoint.com
* @copyright    Copyright (c) 2013, nino eclarin.
* @version      Version 1.0
* 
*/

class School_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}	
	public function isValidSchoolCode($sc){
		$query = $this->db->get_where('school', array('school_code' => $sc))->result_object();
		if(count($query) == 1){
			return TRUE;
		}
		return FALSE;
	}

}