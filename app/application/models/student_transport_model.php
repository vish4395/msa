<?php

class Student_transport_model extends CI_Model {

    CONST TABLE = "student_transport";
    CONST PRIMARY = "id";

    public $table_course = "course";
    public $table_faculty = "faculty";
    public $table_organization = "organization";
    public $table_students = "students";
    public $table_users = "users";
    public $table_transport = "transport";

    function saveTransport($data) {
        $sql = "select * from " . self::TABLE . " a where a.student_id=" . $data['student_id'];
        $query = $this->db->query($sql);
        $result = $query->result_array();
//            print_r($result);exit;
        if (empty($result)) {
            $this->db->insert('student_transport', $data);
        } else {
//            array_unshift_assoc($data, 'id', );
			$this->db->where('id', $result[0]['id']);
            $this->db->update('student_transport', $data);
        }
        return 'success';
    }

}
