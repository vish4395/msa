<?php

class Students_model extends CI_Model {

    CONST TABLE = "students";
    CONST PRIMARY = "id";

    public $table_course = "course";
    public $table_faculty = "faculty";
    public $table_organization = "organization";
    public $table_students = "students";
    public $table_users = "users";
    public $table_transport = "transport";

    public function getStudent($studentId) {
        $sql = "select * from " . self::TABLE . " a where a.id=" . $studentId;
        $query = $this->db->query($sql);
        return $result = $query->result_array();
    }

    public function get_fee_student($orgID, $courseID, $year, $month) {
        $sql = "select * from students where course_id=" . $courseID . " and org_id=" . $orgID . "";
        $query = $this->db->query($sql);
        $students = $query->result_array();
        $final_array = array();
        foreach ($students as $student) {
            $student_id = $student["id"];
            $sql_fee = "select * from fee_status where int_student_id=" . $student_id . " and int_month=" . $month . " and int_year=" . $year . "";
            $query_fee = $this->db->query($sql_fee);
            $data = $query_fee->result_array();
            if (count($data) > 0) {
                $student["deposit_date"] = $data[0]["payment_date"];
            } else {
                $student["deposit_date"] = "";
            }
            $final_array[] = $student;
        }

        return $final_array;
    }

    public function delete_fee_status($student_id, $year, $month) {
        $sql = "delete from fee_status where int_student_id=" . $student_id . " and int_year=" . $year . " and int_month=" . $month . "";
        $query = $this->db->query($sql);
        return true;
    }

    public function get_subjects($orgid) {
        $sql_fee = "select a.*,b.id,b.course_name from subject as a left join course as b on a.course_id=b.id WHERE b.org_id=$orgid";
        $query_fee = $this->db->query($sql_fee);
        $data = $query_fee->result_array();
        return $data;
    }

    public function delete_subject($id) {
        $sql = "delete from subject where subject_id=" . $id . "";
        $query = $this->db->query($sql);
        return true;
    }

    public function delete_assignment($assignment_id) {
        $sql = "delete from tab_assignment where int_unique=" . $assignment_id . "";
        $query = $this->db->query($sql);
        return true;
    }

    public function getAllSubjects($course_id) {
        $sql_subject = "select * from subject where course_id=" . $course_id . "";
        $query_subject = $this->db->query($sql_subject);
        $data = $query_subject->result_array();
        return $data;
    }

    public function get_assignments($org_id) {
        $sql_fee = "select a.*,b.course_name,c.subject_name from tab_assignment as a,course as b,subject as c where a.int_course_id=b.id and a.int_subject_id=c.subject_id AND b.org_id=$org_id";
        $query_fee = $this->db->query($sql_fee);
        $data = $query_fee->result_array();
        return $data;
    }

    public function get_indv_assignment($student_id) {
        $sql_student = "select * from students where id=" . $student_id . "";
        $query_student = $this->db->query($sql_student);
        $data_student = $query_student->result_array();
        $course_id = $data_student[0]["course_id"];
        $sql_fee = "select a.*,b.course_name,c.subject_name from tab_assignment as a,course as b,subject as c where a.int_course_id=b.id and a.int_subject_id=c.subject_id and a.int_course_id=" . $course_id . "";
        $query_fee = $this->db->query($sql_fee);
        $data = $query_fee->result_array();
        return $data;
    }

    public function getFeestatus($student_id) {
        $sql = "select * from fee_status where int_student_id=" . $student_id . " AND int_year=Year(Now())";
        $query = $this->db->query($sql);
        $data = $query->result_array();
        return $data;
    }

}
