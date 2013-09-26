<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Budget model
* 
* @package      School app
* @category     Model
* @author       Nino Eclarin | neclarin@stratpoint.com
* @copyright    Copyright (c) 2013, nino eclarin.
* @version      Version 1.0
* 
*/

class Budget_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}	
	
	public function insert_item($params,$table){
		$id = null;
		$ret = $this->db->insert($table, $params);
		$id = $this->db->insert_id();
		return $id;
	}
	public function get_item($table, $selectable, $where = null,$offset,$limit){
		
		$this->db->select($selectable);
		if($where != null){
			$this->db->where($where);
		} 
		$query = $this->db->get($table,$offset,$limit);
		return $query->result_array();
	}
	public function delete_item($params, $where){

	}



}