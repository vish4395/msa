<?php

class Result_model extends CI_Model {

    CONST TABLE = "results";
    CONST PRIMARY = "id";

    public $table_course = "course";
    public $table_faculty = "faculty";
    public $table_organization = "organization";
    public $table_students = "students";
    public $table_users = "users";
    public $table_transport = "transport";

    public function getResult($studentId,$courseId) {
        $sql="select a.*,b.name FROM results as a LEFT JOIN examination as b ON a.exam_id = b.id WHERE b.course_id = $courseId AND a.student_id=$studentId";
		$query=$this->db->query($sql);
		return $result=$query->result_array();
    }
}
