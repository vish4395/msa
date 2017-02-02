<?php

class Student extends CI_Controller {

    function Student() {
        parent::__construct();
        $this->load->database();
        $this->load->model('user_model');
        $this->load->model('organisation_model');
        $this->load->model('exam_model');
        $this->load->model('attendance_model');
        $this->load->model('notice_model');
        $this->load->model('students_model');
        $this->load->model('result_model');
        header('Access-Control-Allow-Origin: *');
//        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    }

    public function getStudentList() {
        $response = array();
        if ($this->input->post()) {
            $formdata = $this->input->post();
            $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
            if ($userdata['code'] == "admin") {
                $organizationdata = $this->organisation_model->getAllStudentByCourse($userdata['user_code'], $formdata['courseId'], $formdata['date']);
                $response_data['students'] = $organizationdata;
                $response_data['msg'] = "Success";
                $response_data['success'] = true;
                echo json_encode($response_data);
            } else {
                $response_data['msg'] = "Unauthorized Request";
                $response_data['success'] = false;
                echo json_encode($response_data);
            }
        }
    }

    function add() {
        $parent_data = array();
        $formdata = $this->input->post();
        $enroll = preg_replace('/[^A-Za-z0-9]/', '', $formdata['enroll_no']);
//        print_r($enroll);exit;
        $role = $this->user_model->getDataByApiKey($formdata['secret']);
//         $s_username=$role['']
        $p_pass = $formdata['parent_ph_no'];
        if ($role['code'] == 'admin') {
            $org_id = $role['user_code'];
            if ($formdata['studentId'] == '') {
//                 $this->db->select('*');
                $p_query = $this->db->query("select * FROM parents WHERE phone_no = $p_pass");
                $parent_data = $p_query->result_array();
//         print_r($parent_data);die();
                if (empty($parent_data)) {
                    $data_parent = array(
                        'name' => $formdata['father_name'],
                        'phone_no' => $formdata['parent_ph_no'],
                    );
                    $this->db->insert('parents', $data_parent);
                    $parent_id = $this->db->insert_id();
                    $data_parent_user = array(
                        'username' => $formdata['father_name'],
                        'password' => md5($p_pass),
                        'email' => '',//$formdata['parent_email'],
                        'name' => $formdata['father_name'],
                        'user_group' => 3,
                        'address' => $formdata['address'],
                        'phone' => $formdata['parent_ph_no'],
                        'user_code' => $parent_id
                    );
                    $this->db->insert('users', $data_parent_user);
                    $p_id = $this->db->insert_id();
                } else {
                    $parent_id = $parent_data[0]['id'];
                }
            }
            $data_student = array(
                'name' => $formdata['student_name'],
                'father_name' => $formdata['father_name'],
                'mother_name' => $formdata['mother_name'],
                'gender' => $formdata['gender'],
                'dob' => $formdata['student_dob'],
                'course_id' => $formdata['student_course'],
                'enroll_no' => $formdata['enroll_no'],
                'parent_ph_no' => $formdata['parent_ph_no'],
                'org_id' => $org_id
            );
            if ($formdata['studentId'] == '') {
                $data_student['parent_id'] = $parent_id;
                $this->db->insert('students', $data_student);
                $student_id = $this->db->insert_id();
            } else {
                $this->db->where('id', $formdata['studentId']);
                $this->db->update('students', $data_student);
            }

            if ($formdata['studentId'] == '') {
                $s_pass = $formdata['parent_ph_no'];
                $data_student_user = array(
                    'username' => $formdata['student_name'],
                    'password' => md5($s_pass),
                    'email' => $formdata['student_email'],
                    'name' => $formdata['student_name'],
                    'user_group' => 4,
                    'address' => $formdata['address'],
                    'user_code' => $student_id
                );
                $this->db->insert('users', $data_student_user);
                $s_id = $this->db->insert_id();
                $s_username = $role['inl'] . $enroll;
                $this->db->where('id', $s_id);
                $this->db->update('users', array('username' => $s_username));
                if (empty($parent_data)) {
                    $p_username = $role['inl'] . 'p' . $enroll;
                    $this->db->where('id', $p_id);
                    $this->db->update('users', array('username' => $p_username));
                    //$this->sendRegistrationMail($formdata['parent_email'], $p_pass, $p_username);
                }

                $this->sendRegistrationMail($formdata['student_email'], $s_pass, $s_username);
            } else {
                $data_student_user = array(
                    'name' => $formdata['student_name'],
                    'address' => $formdata['address'],
                );
                $this->db->where('user_code', $formdata['studentId']);
                $this->db->where('user_group', 4);
                $this->db->update('users', $data_student_user);
            }
            $response_data['msg'] = "Success";
            $response_data['success'] = true;
            echo json_encode($response_data);
        } else {
            $response_data['msg'] = "Unauthorized Request";
            $response_data['success'] = false;
            echo json_encode($response_data);
        }
    }

    function sendRegistrationMail($email = '', $pass = '', $username = '') {

        $html = "Hello User<br>";
        $html.="Welcome to SchoolApp.You can login to your account with below details.<br>";
        $html.="Username:" . $username . "<br>";
        $html.="Password:" . $pass . "<br>";
        $html.="Regards<br>";
        $subject = "Account Details";
        mail($email, $subject, $html);
    }

    public function addSubject() {
        $formdata = $this->input->post();

        $role = $this->user_model->getDataByApiKey($formdata['secret']);
        if ($role['code'] == 'admin') {
            if (isset($formdata["subject_id"]) && $formdata["subject_id"] != '') {
                $data_student_user = array(
                    'subject_name' => $formdata['subject_name'],
                    'course_id' => $formdata['courses'],
                );
                $this->db->where('subject_id', $formdata['subject_id']);
                $this->db->update('subject', $data_student_user);
            } else {
                $data_student_user = array(
                    'subject_name' => $formdata['subject_name'],
                    'course_id' => $formdata['courses'],
                );
                $this->db->insert('subject', $data_student_user);
            }
        }

        $response_data['msg'] = "Success";
        $response_data['success'] = true;
        echo json_encode($response_data);
    }

    public function getAllSubjects() {
        $formdata = $this->input->post();
        $userdata = $this->user_model->getDataByApiKey($formdata['secret']);

        $subjects = $this->students_model->get_subjects($userdata["user_code"]);
        $response_data['subjects'] = $subjects;
        $response_data['msg'] = "Success";
        $response_data['success'] = true;
        echo json_encode($response_data);
    }

    public function getAllAssignment() {
        $formdata = $this->input->post();
        $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
        $assignments = $this->students_model->get_assignments($userdata["user_code"]);
        $response_data['assignments'] = $assignments;
        $response_data['msg'] = "Success";
        $response_data['success'] = true;
        echo json_encode($response_data);
    }

    public function deleteSubject() {
        $formdata = $this->input->post();
        $subjects = $this->students_model->delete_subject($formdata["subject_id"]);
        $response_data['msg'] = "Success";
        $response_data['success'] = true;
        echo json_encode($response_data);
    }

    public function deleteAssignment() {
        $formdata = $this->input->post();
        $subjects = $this->students_model->delete_assignment($formdata["assignment_id"]);
        $response_data['msg'] = "Success";
        $response_data['success'] = true;
        echo json_encode($response_data);
    }

    public function getMyAssignment() {
        $formdata = $this->input->post();
        $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
        if ($userdata['code'] == "student") {
            $assignments = $this->students_model->get_indv_assignment($userdata['user_code']);
            $response_data['assignments'] = $assignments;
            $response_data['success'] = true;
            echo json_encode($response_data);
        } else {
            $response_data['msg'] = "Unauthorized Request";
            $response_data['success'] = false;
            echo json_encode($response_data);
        }
    }

    function deleteStudent() {
        $formdata = $this->input->post();
        $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
        if ($userdata['code'] == "admin") {
            if ($formdata['student_id']) {
                $this->db->delete('users', array('user_code' => $formdata['student_id']));
                $this->db->delete('students', array('id' => $formdata['student_id']));

                $response_data['msg'] = "Deleted Successfully";
                $response_data['success'] = true;
                echo json_encode($response_data);
            } else {
                $response_data['msg'] = "Validation Failed";
                $response_data['success'] = false;
                echo json_encode($response_data);
            }
        } else {
            $response_data['msg'] = "Unauthorized Request";
            $response_data['success'] = false;
            echo json_encode($response_data);
        }
    }

    function save_attendance() {
        $formdata = $this->input->post();
        $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
        $attendance_data = $this->organisation_model->get_attendance_data($formdata['att_date'], $formdata['courseId']);
        if (count($attendance_data) > 0) {
            $this->organisation_model->delete_attendance($formdata['att_date'], $formdata['courseId']);
        }
        $org_id = $userdata["user_code"];
        foreach ($formdata['att_check'] as $attr) {
            $data = array(
                'org_id' => $org_id,
                'date' => $formdata['att_date'],
                'course_id' => $formdata['courseId'],
                'student_id' => $attr
            );
            $this->db->insert('attendence', $data);
        }
        $response_data['msg'] = "Success";
        $response_data['success'] = true;
        echo json_encode($response_data);
    }

    function getExamResult() {
        $formdata = $this->input->post();
        $data = $this->exam_model->get_student_exam($formdata['courseId'], $formdata['examinationId']);
        $response_data['students'] = $data;
        $response_data['msg'] = "Success";
        $response_data['success'] = true;
        echo json_encode($response_data);
    }

    function save_marks() {
        $formdata = $this->input->post();
        $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
        $exam_id = $formdata["examinationId"];
        for ($i = 1; $i <= $formdata["student_count"]; $i++) {
            $student_id = $formdata["student_id_" . $i . ""];
            $marks = $formdata["marks_student_" . $i . ""];
            $result_data = $this->exam_model->get_result_data($student_id, $exam_id);
            $data = array(
                'exam_id' => $exam_id,
                'student_id' => $student_id,
                'marks' => $marks
            );
            if (count($result_data) > 0) {
                $this->db->where('id', $result_data[0]["id"]);
                $this->db->update('results', $data);
            } else {
                $this->db->insert('results', $data);
            }
        }

        $response_data['msg'] = "Success";
        $response_data['success'] = true;
        echo json_encode($response_data);
    }

    function save_fee() {
        $formdata = $this->input->post();
        $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
        $student_count = $formdata["total_count"];
        $year = $formdata["fee_year"];
        $month = $formdata["fee_month"];
        for ($i = 1; $i <= $student_count; $i++) {
            $student_id = $formdata["student_id" . $i . ""];
            $this->students_model->delete_fee_status($student_id, $year, $month);
            if (isset($formdata['status' . $i . ''])) {
                $data = array(
                    'int_student_id' => $student_id,
                    'int_month' => $month,
                    'int_year' => $year,
                    'payment_date' => $formdata['deposit_date' . $i . ''] != '' ? $formdata['deposit_date' . $i . ''] : date("Y-m-d")
                );
                $this->db->insert('fee_status', $data);
            }
        }
        $response_data['msg'] = "Success";
        $response_data['success'] = true;
        echo json_encode($response_data);
    }

    public function get_attandance() {
        $response = array();
        $formdata = $this->input->post();
        $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
        $studentId = $userdata['user_code'];
        $data = $this->attendance_model->getAttendance($studentId);
        $attendance = array();
        foreach ($data as $value) {
            $attendance[] = array('title' => 'P', 'start' => $value['date'], 'color' => 'green', // a non-ajax option
                'textColor' => 'black');
        }
        echo json_encode($attendance);
    }

    public function getNotice() {
        $response = array();
        $formdata = $this->input->post();
        $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
        $studentId = $userdata['user_code'];
        $data = $this->students_model->getStudent($studentId);
        $orgId = $data[0]['org_id'];
        $courseId = $data[0]['course_id'];
        $noticeData = $this->notice_model->getNoticeStudent($studentId, $orgId, $courseId);
        $response['notice'] = $noticeData;
        echo json_encode($response);
    }

    public function getResult() {
        $response = array();
        $formdata = $this->input->post();
        $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
        $studentId = $userdata['user_code'];
        $data = $this->students_model->getStudent($studentId);
        $orgId = $data[0]['org_id'];
        $courseId = $data[0]['course_id'];
        $resultdata = $this->result_model->getResult($studentId, $courseId);
        echo json_encode($resultdata);
    }

    public function getStudentFees() {
        $response = array();
        if ($this->input->post()) {
            $formdata = $this->input->post();
            $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
            if ($userdata['code'] == "admin") {
                $organizationdata = $this->students_model->get_fee_student($userdata['user_code'], $formdata['courseId'], $formdata['year'], $formdata['month']);
                $response_data['students'] = $organizationdata;
                $response_data['msg'] = "Success";
                $response_data['success'] = true;
                echo json_encode($response_data);
            } else {
                $response_data['msg'] = "Unauthorized Request";
                $response_data['success'] = false;
                echo json_encode($response_data);
            }
        }
    }

    public function addAssignment() {
        $formdata = $this->input->post();
        $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
        if ($userdata['code'] == "admin") {

            if ($_FILES['file']['name'] != '') {
                $ext = explode(".", $_FILES["file"]["name"]);
                $file_name = date("YmdHis") . "." . $ext[count($ext) - 1];
                move_uploaded_file($_FILES['file']['tmp_name'], "upload/documents/" . $file_name);

                $data = array(
                    'int_course_id' => $formdata["assignment_course"],
                    'int_subject_id' => $formdata["assignment_subject"],
                    'int_org_id' => $userdata['user_code'],
                    'txt_assignment_topic' => $formdata["assignment_topic"],
                    'txt_assignment_url' => $file_name,
                    'dt_submission_date' => $formdata["submission_date"],
                    'int_grace_days' => $formdata["grace_days"],
                    'int_max_marks' => $formdata["assignment_marks"]
                );
            } else {
                $data = array(
                    'int_course_id' => $formdata["assignment_course"],
                    'int_subject_id' => $formdata["assignment_subject"],
                    'int_org_id' => $userdata['user_code'],
                    'txt_assignment_topic' => $formdata["assignment_topic"],
                    'dt_submission_date' => $formdata["submission_date"],
                    'int_grace_days' => $formdata["grace_days"],
                    'int_max_marks' => $formdata["assignment_marks"]
                );
            }

            if ($formdata["assignment_id"] != "") {
                $this->db->where('int_unique', $formdata["assignment_id"]);
                $this->db->update('tab_assignment', $data);
            } else {
                $this->db->insert('tab_assignment', $data);
            }
            $response_data['msg'] = "Success";
            $response_data['success'] = true;
            echo json_encode($response_data);
        } else {
            $response_data['msg'] = "Unauthorized Request";
            $response_data['success'] = false;
            echo json_encode($response_data);
        }
    }

    public function getAllTransport() {
        $response = array();
        $formdata = $this->input->post();
        $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
        $studentId = $userdata['user_code'];
        $data = $this->students_model->getStudent($studentId);
        $orgId = $data[0]['org_id'];
        $this->load->model('transport_model');
        $transportData = $this->transport_model->getAllTransports($orgId);
        echo json_encode($transportData);
    }

    public function save_transport() {
        $response = array();
        $formdata = $this->input->post();
        $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
        $studentId = $userdata['user_code'];
        $data = $this->students_model->getStudent($studentId);

        $orgId = $data[0]['org_id'];
        $saveData = array(
            'transport_type' => $formdata['transport_type'],
            'student_id' => $studentId,
            'org_id' => $orgId,
            'transport_id' => isset($formdata['transport_route']) && $formdata['transport_route'] ? $formdata['transport_route'] : '',
            'vehical_no' => isset($formdata['vehical_no']) && $formdata['vehical_no'] ? $formdata['vehical_no'] : '',
        );
        $this->load->model('student_transport_model');
        $transportData = $this->student_transport_model->saveTransport($saveData);
        echo json_encode($transportData);
    }

    public function get_fee_status() {
        $response = array();
        $formdata = $this->input->post();
        $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
        $studentId = $userdata['user_code'];
        $data = $this->students_model->getFeestatus($studentId);
        $html = '';
        $fee_array = array();
        foreach ($data as $value) {
            $fee_array[$value['int_month']] = $value['payment_date'];
        }
        $allData = array();
        ;
        for ($i = 1; $i <= 12; $i++) {
            $dateObj = DateTime::createFromFormat('!m', $i);
            $monthName = $dateObj->format('F');
            $status=array_key_exists($i, $fee_array) ? 'Paid' : 'Due';
            $payDate=array_key_exists($i, $fee_array) ? $fee_array[$i] : '-';
            $allData[$i]['month']=$monthName;
            $allData[$i]['status']=$status;
            $allData[$i]['date']=$payDate;
        }
//        print_r($allData);exit;;
        $html.='<div class="table-responsive no-padding"><table class="table table-striped"';
        $html.='<tr><th>Month</th><th>Status</th><th>Payment Date</th></tr>';
        foreach ($allData as $value) {
            
        $html.='<tr><td>'.$value['month'].'</td><td>' . $value['status'] . '</td><td>' . $value['date'] . '</td></tr>';
        }
//        $html.='<tr><td>Feb</td><td>' . array_key_exists('2', $fee_array) ? 'Paid' : 'Due' . '</td><td>' . array_key_exists('2', $fee_array) ? $fee_array['2'] : '-' . '</td></tr>';
//        $html.='<tr><td>Mar</td><td>' . array_key_exists('3', $fee_array) ? 'Paid' : 'Due' . '</td><td>' . array_key_exists('3', $fee_array) ? $fee_array['3'] : '-' . '</td></tr>';
//        $html.='<tr><td>Apr</td><td>' . array_key_exists('4', $fee_array) ? 'Paid' : 'Due' . '</td><td>' . array_key_exists('4', $fee_array) ? $fee_array['4'] : '-' . '</td></tr>';
//        $html.='<tr><td>May</td><td>' . array_key_exists('5', $fee_array) ? 'Paid' : 'Due' . '</td><td>' . array_key_exists('5', $fee_array) ? $fee_array['5'] : '-' . '</td></tr>';
//        $html.='<tr><td>Jun</td><td>' . array_key_exists('6', $fee_array) ? 'Paid' : 'Due' . '</td><td>' . array_key_exists('6', $fee_array) ? $fee_array['6'] : '-' . '</td></tr>';
//        $html.='<tr><td>Jul</td><td>' . array_key_exists('7', $fee_array) ? 'Paid' : 'Due' . '</td><td>' . array_key_exists('7', $fee_array) ? $fee_array['7'] : '-' . '</td></tr>';
//        $html.='<tr><td>Aug</td><td>' . array_key_exists('8', $fee_array) ? 'Paid' : 'Due' . '</td><td>' . array_key_exists('8', $fee_array) ? $fee_array['8'] : '-' . '</td></tr>';
//        $html.='<tr><td>Sep</td><td>' . array_key_exists('9', $fee_array) ? 'Paid' : 'Due' . '</td><td>' . array_key_exists('9', $fee_array) ? $fee_array['9'] : '-' . '</td></tr>';
//        $html.='<tr><td>Oct</td><td>' . array_key_exists('10', $fee_array) ? 'Paid' : 'Due' . '</td><td>' . array_key_exists('10', $fee_array) ? $fee_array['10'] : '-' . '</td></tr>';
//        $html.='<tr><td>Nov</td><td>' . array_key_exists('11', $fee_array) ? 'Paid' : 'Due' . '</td><td>' . array_key_exists('11', $fee_array) ? $fee_array['11'] : '-' . '</td></tr>';
//        $html.='<tr><td>Dec</td><td>' . array_key_exists('12', $fee_array) ? 'Paid' : 'Due' . '</td><td>' . array_key_exists('12', $fee_array) ? $fee_array['12'] : '-' . '</td></tr>';
        $html.='</table></div>';
        echo $html;
    }

}

//http://localhost:8001/CodeIgniter/index.php/organization/getOrganizationDetails