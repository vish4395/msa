<?php
class Contact_model extends CI_Model{

	CONST TABLE = "contact";
	CONST PRIMARY = "id";
	public $table_course="course";
	public $table_faculty="faculty";
	public $table_organization="organization";
	public $table_students="students";
	public $table_users="users";
	public $table_contact="contact";

    function getAllContact($userId){
		$sql="select * from ".  self::TABLE." a where a.user_id=".$userId;
		$query=$this->db->query($sql);
		return $result=$query->result_array();
	}
}