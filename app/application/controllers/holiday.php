<?php

class Holiday extends CI_Controller {

    function Holiday() {
        parent::__construct();
        $this->load->database();
        $this->load->model('user_model');
        $this->load->model('organisation_model');
        $this->load->model('holiday_model');
        $this->load->model('students_model');
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        header('Access-Control-Allow-Origin: *');
    }

    public function getAllHoliday() {
        $response = array();
        if ($this->input->post()) {
            $formdata = $this->input->post();
            $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
            if ($userdata['code'] == "admin") {
                $data = $this->holiday_model->getAllHoliday($userdata['user_code']);
                $response_data['holiday'] = $data;
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

    public function addHoliday() {
        $response_data = array();
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('start_date', 'start_date', 'required');
        if ($this->input->post()) {
            $formdata = $this->input->post();
            $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
            if ($userdata['code'] == "admin") {
                if ($this->form_validation->run()) {
                    $data = array(
                        'title' => $formdata['title'],
                        'start_date' => $formdata['start_date'],
                        'end_date' => $formdata['end_date'],
                        'org_id' => $userdata['user_code']
                    );

                    if ($formdata['holiday_id']) {
                        $this->db->where('id', $formdata['holiday_id']);
                        $this->db->update('holiday', $data);
                    } else {
                        $this->db->insert('holiday', $data);
                    }

                    // $response_data['data']=$data;
                    $response_data['msg'] = "Success";
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
        } else {
            $response_data['msg'] = "Unauthorized Request";
            $response_data['success'] = false;
            echo json_encode($response_data);
        }
    }

    function deleteHoliday() {
        $formdata = $this->input->post();
        $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
        if ($userdata['code'] == "admin") {
            if ($formdata['holiday_id']) {
                $this->db->delete('holiday', array('id' => $formdata['holiday_id']));

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

    public function getHolidayStudent() {
        $response = array();
        if ($this->input->post()) {
            $formdata = $this->input->post();
            $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
            $studentId=$userdata['user_code'];
            $data=$this->students_model->getStudent($studentId);
            $orgId=$data[0]['org_id'];
            $data = $this->holiday_model->getAllHoliday($orgId);
            $response_data['holiday'] = $data;
            $response_data['msg'] = "Success";
            $response_data['success'] = true;
            echo json_encode($response_data);
        }
    }

}
