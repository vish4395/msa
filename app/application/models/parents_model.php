<?php

class Parents_model extends CI_Model {

    CONST TABLE = "parent";
    CONST PRIMARY = "id";

    public $table_course = "course";
    public $table_faculty = "faculty";
    public $table_organization = "organization";
    public $table_students = "students";
    public $table_users = "users";
    public $table_transport = "transport";

    public function getChildren($parentId) {
        $sql="select * from ".  $this->table_students ." a where a.parent_id=".$parentId;
		$query=$this->db->query($sql);
		return $result=$query->result_array();
    }
    public function getChildrenBySecret($secret) {
        
        $sql="select user_code from users a where a.api_key=".$secret;
		$query1=$this->db->query($sql);
		$usercode=$query1->result_array();
                $parentId=$usercode[0]['user_code'];
//                print_r($usercode);exit;
        $sql="select * from ".  $this->table_students ." a where a.parent_id=".$parentId;
		$query=$this->db->query($sql);
		return $result=$query->result_array();
    }
}
