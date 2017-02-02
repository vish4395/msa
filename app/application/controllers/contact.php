<?php
class Contact extends CI_Controller{

	function Contact(){
		parent::__construct();
		$this->load->database();
		$this->load->model('user_model');
		$this->load->model('contact_model');
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                header('Access-Control-Allow-Origin: *');
	}

    function addContact() {
        $formdata = $this->input->post();
        if ($formdata['secret'] && $formdata['name']) {
            $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
            $user_id = $userdata['pr'];
            if ($formdata['contact_id']) {
                $update_array = array(
                    'name' => $formdata['name'],
                    'phone' => $formdata['phone'],
                    'email' => $formdata['email'],
                    'address' => $formdata['address']
                );
                $this->db->where('id', $formdata['contact_id']);
                $this->db->update('contact', $update_array);
                $response_data['msg'] = "Updated Successfully";
                $response_data['success'] = true;
                echo json_encode($response_data);
            } else {
                $insert_array = array(
                    'name' => $formdata['name'],
                    'phone' => $formdata['phone'],
                    'email' => $formdata['email'],
                    'address' => $formdata['address'],
                    'user_id' => $user_id
                );
                $this->db->insert('contact', $insert_array);
                $response_data['msg'] = "Inserted Successfully";
                $response_data['success'] = true;
                echo json_encode($response_data);
            }
        } else {
            $response_data['msg'] = "Unauthorized Request";
            $response_data['success'] = false;
            echo json_encode($response_data);
        }
    }

    function deleteContact() {
        $formdata = $this->input->post();
        $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
        if ($userdata['pr'] != "") {
            if ($formdata['contact_id']) {
                $this->db->delete('contact', array('id' => $formdata['contact_id']));

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

    public function getAllContacts() {
        $response_data = array();
        if ($this->input->post()) {
            $formdata = $this->input->post();
            $userdata = $this->user_model->getDataByApiKey($formdata['secret']);
            // echo '<pre>'; print_r($userdata);exit;
            if ($userdata['pr'] != "") {
                $this->load->model('contact_model');
                $data = $this->contact_model->getAllContact($userdata['pr']);
                $response_data['contacts'] = $data;
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
}