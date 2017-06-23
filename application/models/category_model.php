<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Category_model extends CI_Model {

    function __construct() {
        parent::__construct();
	}

	function get_all(){
		$records = array();
		$query = $this->db->query('SELECT * FROM category ORDER BY class_sequence');
		foreach ($query->result() as $row){
			$row->children = $this->get_child_num($row->class_id);
			$records[] = $row ;
		}
		return $records ;
	}
	
	function get_child_num($classid){
		$query = $this->db->query("select count(*) as children from category where parent_id='$classid'");
		foreach ($query->result() as $row){
			return $row->children;
		}
	}

	function  get_in_tree($array,$pid=0,$y,&$tdata=array()){
		foreach ($array as $row){
			if($row->parent_id==$pid){
				$n = $y + 1;
				$row->deep = $y;
				$tdata[]=$row;
				$this->get_in_tree($array,$row->class_id,$n,$tdata);
			}
		}
		return $tdata;
	}
	
	function get_category(){
		return $this->get_in_tree($this->get_all(),0,0);
	}
	
	function move_category($from,$to){
		$data = array(
               'parent_id' => $to
        );
		$this->db->where('class_id', $from);
		$this->db->update('category', $data);
		return true;
	}
	
	function insert($data){
		$this->db->insert('category', $data);
	}
	
	function update($classid,$data){
		$this->db->where('class_id',$classid);
		$this->db->update('category', $data);
	}
	
	function del($classid){
		$this->db->where('class_id',$classid);
		$this->db->delete('category');
	}
	

}