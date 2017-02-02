<?php

class Holiday_model extends CI_Model {

    public $table = "holiday";
    public $table_user_group = "user_role";
    public $table_user_parent = "parents";
    public $table_user_student = "students";
    public $table_user_organization = "organization";
    public $table_user = "users";
    public $table_course = "course";

    function holiday_model() {
        parent::__construct();
    }

    function getAllHoliday($orgId) {
        //$sql = "select * from " . $this->table . " a where Month(start_date)>=Month(Now()) And a.org_id=" . $orgId;
        $sql = "select * from " . $this->table . " a where a.org_id=" . $orgId." order by a.start_date";
        $query = $this->db->query($sql);
        return $result = $query->result_array();
    }

    

}

?>