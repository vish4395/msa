<?php

class User_model extends CI_Model {

    public $table = "users";
    public $table_user_group = "user_role";
    public $table_user_parent = "parents";
    public $table_user_student = "students";
    public $table_user_organization = "organization";
    public $table_navigation = "navigation";
    public $table_course = "course";
    public $table_faculty = "faculty";
    public $table_attendence = "attendence";
    public $notice_board = "notice_board";

    function user_model() {
        parent::__construct();
    }

    function getUserByEmail($email) {
        $sql = "select * from " . $this->table . " a where a.email='" . $email . "' ";
        $query = $this->db->query($sql);
        return $result = $query->row_array();
    }

    function getUserByUsername($username) {
        $sql = "select * from " . $this->table . " a where a.username='" . $username . "' ";
        $query = $this->db->query($sql);
        return $result = $query->row_array();
    }

    function getSecretByUserCode($userCode, $userGroup) {
        $sql = "select * from " . $this->table . " a where a.user_code='" . $userCode . "' AND a.user_group = '" . $userGroup . "'";
//                        print_r($sql);exit;
        $query = $this->db->query($sql);
        return $result = $query->row_array();
    }

    function getUserByPassword($data) {
        extract($data);
        $password = md5($password);
        $sql = "select a.* from " . $this->table . " a left join " . $this->table_user_group . " b on a.user_group=b.id where a.username='" . $username . "' and a.password='" . $password . "'  ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        // return $query->num_rows();
        return $result;
    }

    function getSummeryDetails($usertype = NULL, $user_code = NULL) {
        if ($usertype == 'superadmin') {
            $sql = "select count(a.id) as organization_count from " . $this->table_user_organization . " a inner join users as b where a.id=b.user_code and  b.user_group=2";
            $query = $this->db->query($sql);
            $organization_count = $query->row_array();
            $sql1 = "select count(a.id) as user_count from " . $this->table . " a where 1 ";
            $query1 = $this->db->query($sql1);
            $user_count = $query1->row_array();
            return array(array('title' => 'No. of Users','link'=>'#', 'count' => $user_count['user_count']), array('title' => 'No. of School','link'=>'organization_report.html', 'count' => $organization_count['organization_count']));
        } else if ($usertype == 'admin') {
            $sql = "select count(a.id) as student_count from " . $this->table_user_student . " a where org_id=" . $user_code;
            $query = $this->db->query($sql);
            $student_count = $query->row_array();
            $sql1 = "select count(a.id) as course_count from " . $this->table_course . " a where org_id=" . $user_code;
            $query1 = $this->db->query($sql1);
            $course_count = $query1->row_array();
            $sql2 = "select count(a.id) as faculty_count from " . $this->table_faculty . " a where org_id=" . $user_code;
            $query2 = $this->db->query($sql2);
            $faculty_count = $query2->row_array();
            $sql3 = "select count(id) as notice_count from " . $this->notice_board . " a where a.org_id=" . $user_code;
            $query3 = $this->db->query($sql3);
            $notice_count = $query3->row_array();
            return array(array('title' => 'No. of Notice','link'=>'notice_report.html', 'count' => $notice_count['notice_count']), array('title' => 'No. of Faculty','link'=>'#', 'count' => $faculty_count['faculty_count']), array('title' => 'No. of Students','link'=>'student_course.html', 'count' => $student_count['student_count']), array('title' => 'No. of Courses','link'=>'course_report.html', 'count' => $course_count['course_count']));
        } else if ($usertype == 'student') {

            $sql = "select * from " . $this->table_user_student . " a where id=" . $user_code;
            $query = $this->db->query($sql);
            $student_detail = $query->row_array();
            //print_r($student_detail);
            $allAttendance = $this->getTotalAttandance($student_detail['org_id'], $student_detail['course_id']);
            $studentAttendance = $this->getStudentAttandance($student_detail['org_id'], $student_detail['course_id'], $student_detail['id']);
            if ($allAttendance > 0)
                $peratt = (count($studentAttendance) / count($allAttendance)) * 100;
            else
                $peratt = 0;
            $peratt=round($peratt,2);

            $result_count=0;
            $sql4 = "select count(*) as result_count from results  where student_id=" . $user_code;
            $query4 = $this->db->query($sql4);
            $result4 = $query4->row_array();

            $assignment_count=0;
            $sql5 = "select count(*) as assignment_count from tab_assignment  where int_course_id=(select course_id from " . $this->table_user_student . " where id=" . $user_code . ")";
            $query5 = $this->db->query($sql5);
            $result5 = $query5->row_array();

            $holiday_count=0;
            $sql6 = "select count(*) as holiday_count from holiday  where org_id=".$student_detail['org_id']."";
            $query6 = $this->db->query($sql6);
            $result6 = $query6->row_array();

            $notices=  $this->getNoticeStudent($student_detail['id'],$student_detail['org_id'],$student_detail['course_id']);
            return array(array('title' => 'Notice','link'=>'student_notice.html', 'count' => count($notices)), array('title' => 'Attendance','link'=>'student_attendance.html', 'count' => $peratt . "%"), array('title' => 'Result','link'=>'student_result.html', 'count' => $result4['result_count']), array('title' => 'Assignment','link'=>'my_assignment.html', 'count' => $result5['assignment_count']), array('title' => 'Holiday','link'=>'student_holiday.html', 'count' => $result6['holiday_count']));
        }
    }

    function getNoticeStudent($studentId, $orgId, $courseId) {
        $sql1 = "select * from " . $this->notice_board . " a where a.org_id=" . $orgId . " AND a.notice_type = 1";
//            print_r($sql1);exit;
        $query1 = $this->db->query($sql1);
        $result1 = $query1->result_array();
        $sql2 = "select * from " . $this->notice_board . " a where a.org_id=" . $orgId . " AND a.notice_type = 3 AND a.type_id = $courseId";
        $query2 = $this->db->query($sql2);
        $result2 = $query2->result_array();
        $sql3 = "select * from " . $this->notice_board . " a where a.org_id=" . $orgId . " AND a.notice_type = 2 AND a.type_id = $studentId";
        $query3 = $this->db->query($sql3);
        $result3 = $query3->result_array();
        return array_merge($result1, $result2, $result3);
    }

    function getTotalAttandance($org_id, $course_id) {
        $sql1 = "select count(*) as total_attendance from " . $this->table_attendence . " a where org_id=" . $org_id . " and course_id=" . $course_id . " group by DATE";
        $query = $this->db->query($sql1);
        $allAttendance = $query->result_array();
        return $allAttendance;
    }

    function getStudentAttandance($org_id, $course_id, $student_id) {
        $sql1 = "select count(*) as total_attendance from " . $this->table_attendence . " a where org_id=" . $org_id . " and course_id=" . $course_id . " and student_id=" . $student_id . " group by DATE";
        $query = $this->db->query($sql1);
        $allAttendance = $query->result_array();
        return $allAttendance;
    }

    function getNavigationDetails($user_group_id) {
        $sql = "select a.* from " . $this->table_navigation . " a where a.user_group=" . $user_group_id . " order by int_order";
        $query = $this->db->query($sql);
        return $result = $query->result_array();
    }

    function getDataByApiKey($apikey) {
        $sql = "select a.id as pr,a.username as inl,a.email,a.password as pass,a.phone,a.address,a.city,a.state,a.avtar,a.zipcode,a.user_code,b.id as group_id,a.name,b.code from " . $this->table . " a left join " . $this->table_user_group . " b on a.user_group=b.id where a.api_key=" . $apikey . " ";
        $query = $this->db->query($sql);
        return $result = $query->row_array();
    }

    function getRoleByApiKey($apikey) {
        $sql = "select b.* from " . $this->table . " a left join " . $this->table_user_group . " b on a.user_group=b.id where a.api_key=" . $apikey . " ";
        $query = $this->db->query($sql);
        return $result = $query->row_array();
    }

    function getProfileDetails($user_code, $user_id) {
        if ($user_code == 'admin') {
            return 0;
        } else if ($user_code == 'admin') {
            $sql = "select b.name,b.image,b.owner from " . $this->table_user_organization . " b where b.id=" . $user_id . " ";
        } else if ($user_code == 'parent') {
            $sql = "select b.name,b.image from " . $this->table_user_parent . " b  where b.id=" . $user_id . " ";
        } else if ($user_code == 'student') {
            $sql = "select b.name,b.image,b.father_name,b.mother_name,b.gender,b.dob from " . $this->table_user_student . " b where b.id=" . $user_id . " ";
        }
        $query = $this->db->query($sql);
        return $result = $query->row_array();
    }

    function updateProfile($formdata, $table = NULL) {
        // extract($data);
        if ($_FILES["file"]["type"] == "image/jpeg" || $_FILES["file"]["type"] == "image/jpg") {
            $ext = explode(".", $_FILES["file"]["name"]);
            $filename = $code . "." . $ext[count($ext) - 1];
            move_uploaded_file($_FILES["file"]["tmp_name"], $table . "/" . $filename);
        }

        $userdata = $this->getDataByApiKey($formdata['secret']);

        $data1 = array(
            'name' => $formdata['name'],
            'phone' => $formdata['phone'],
            'address' => $formdata['address'],
            'city' => $formdata['city'],
            'state' => $formdata['state'],
            'zipcode' => $formdata['zipcode'],
        );
        $this->db->where('api_key', $formdata['secret']);
        $this->db->update('users', $data1);


        if ($table == 'organization') {
            $data = array(
                'name' => $formdata['name'],
                'address' => $formdata['address'],
                'owner' => $formdata['owner']
            );
        } else if ($table == 'parents') {
            $data = array(
                'name' => $formdata['name']
            );
        } else if ($table == 'students') {
            $data = array(
                'name' => $formdata['name'],
                'gender' => $formdata['gender'],
                'father_name' => $formdata['father_name'],
                'mother_name' => $formdata['mother_name'],
                'dob' => $formdata['dob'],
            );
        }
        if (isset($table) && $table != 'superadmin') {
            $this->db->where('id', $userdata['user_code']);
            $this->db->update($table, $data);
        }
    }
    
    public function uploadImage($apikey,$data) {
        $this->db->where('api_key', $apikey);
            $this->db->update($this->table, $data);
    }
    
    public function deleteOrgData($org_id)
    {
        $query_attendance="delete from attendence where org_id=$org_id";
        $query = $this->db->query($query_attendance);
        
        $query_course="delete from course where org_id=$org_id";
        $query = $this->db->query($query_course);
        
        $query_exam="delete from examination where org_id=$org_id";
        $query = $this->db->query($query_exam);
        
        $query_faculty="delete from faculty where org_id=$org_id";
        $query = $this->db->query($query_faculty);
        
        $query_holiday="delete from holiday where org_id=$org_id";
        $query = $this->db->query($query_holiday);
        
        $query_assignment="delete from tab_assignment where int_org_id=$org_id";
        $query = $this->db->query($query_assignment);
        
        $query_transport="delete from transport where org_id=$org_id";
        $query = $this->db->query($query_transport);
		
		$query_parents="delete from users where user_group=3 and user_code IN (Select parents.id from students right join parents ON parents.id=students.parent_id where students.org_id=$org_id)";
        $query_parent = $this->db->query($query_parents);
        
        $query_students="delete from users where user_group=4 and user_code IN (Select id from students where org_id=$org_id)";
        $query_student = $this->db->query($query_students);
		
		
        
    }

}

?>