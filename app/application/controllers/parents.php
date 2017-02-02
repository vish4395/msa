<?php

class Parents extends CI_Controller {

    function Parents() {
        parent::__construct();
        $this->load->database();
        $this->load->model('user_model');
        $this->load->model('organisation_model');
        $this->load->model('exam_model');
        $this->load->model('attendance_model');
        $this->load->model('notice_model');
        $this->load->model('students_model');
        $this->load->model('result_model');
        $this->load->model('parents_model');
        header('Access-Control-Allow-Origin: *');
//        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    }

    public function getChildren() {
        $response = array();
        if ($this->input->post()) {
            $formdata = $this->input->post();
            $childrenDetails = $this->parents_model->getChildren($formdata['user_id']);
//            $childrenDetails = $this->user_model->getSecretByUserCode($formdata['user_id'],4);
            echo json_encode($childrenDetails);
            exit;
        }
    }
    public function getChildrenBySecret() {
        $response = array();
        if ($this->input->post()) {
            $formdata = $this->input->post();
            $childrenDetails = $this->parents_model->getChildrenBySecret($formdata['secret']);
//            $childrenDetails = $this->user_model->getSecretByUserCode($formdata['user_id'],4);
            echo json_encode($childrenDetails);
            exit;
        }
    }

    

    public function get_attandance() {
        $response = array();
        $formdata = $this->input->post();
//        $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
        $studentId = $formdata['childId'];
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
//        $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
        $studentId = $formdata['childId'];
        $data = $this->students_model->getStudent($studentId);
        $orgId = $data[0]['org_id'];
        $courseId = $data[0]['course_id'];
        $noticeData = $this->notice_model->getNoticeStudent($studentId, $orgId, $courseId);
        $response['notice'] = $noticeData;
        echo json_encode($response);
    }

    public function getHoliday() {
        $this->load->model('holiday_model');
        $response = array();
        $formdata = $this->input->post();
//        $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
        $studentId = $formdata['childId'];
        $data = $this->students_model->getStudent($studentId);
        $orgId = $data[0]['org_id'];
        $courseId = $data[0]['course_id'];
        $holidayData = $this->holiday_model->getAllHoliday($orgId);
        $response['holiday'] = $holidayData;
        echo json_encode($response);
    }

    public function getHolidayStudent() {
        $this->load->model('holiday_model');
        $response = array();
        $formdata = $this->input->post();
        $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
        $studentId=$userdata['user_code'];
        $data=$this->students_model->getStudent($studentId);
        $orgId=$data[0]['org_id'];
        $holidayData=$this->holiday_model->getAllHoliday($orgId);
        $response['holiday']=$holidayData;
        echo json_encode($response);
        
    }

    public function getResult() {
        $response = array();
        $formdata = $this->input->post();
        $studentId = $formdata['childId'];
        $data = $this->students_model->getStudent($studentId);
        $orgId = $data[0]['org_id'];
        $courseId = $data[0]['course_id'];
        $resultdata = $this->result_model->getResult($studentId, $courseId);
        echo json_encode($resultdata);
    }

}
