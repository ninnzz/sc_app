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
	public function get_items($table, $selectable, $where = null,$offset,$limit){
		$this->db->select($selectable);
		if($where != null){
			$this->db->where($where);
		} 
		$query = $this->db->get($table,$offset,$limit);
		return $query->result_array();
	}
	public function delete_item($table, $where){
		return $this->db->delete($table, $where); 
	}

	public function update_item($table,$data,$where = null){
		if($where !== null){
			$this->db->update($table, $data, $where);
		} else{
			return FALSE;
		}
	}

	public function adjust_budget($query){
		$res = $this->db->query($query)->result_array();
		if(count($res>0) && $res[0]['alloted'] != NULL && $res[0]['reserved'] != NULL && $res[0]['in_order'] != NULL && $res[0]['available'] != NULL){
			return array('alloted'=>$res[0]['alloted'],'reserved'=>$res[0]['reserved'],'in_order'=>$res[0]['in_order'],'available'=>$res[0]['available']);
		}
		return array('alloted'=>0,'reserved'=>0,'in_order'=>0,'available'=>0);
		
	}
}