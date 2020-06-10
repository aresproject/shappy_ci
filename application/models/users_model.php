<?php

Class Users_model extends CI_Model {
    
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function valid_login() {
        $user_data['email'] = $this->input->post('login_email');
        $user_data['password'] = $this->input->post('login_password');
        $query = $this->db->get_where('users', array('email' => $user_data['email'], "password" =>  $user_data['password']));
        $row = $query->row();
        if($query->num_rows() > 0){
            $this->session->set_userdata('logged_email', $row->email);
            $this->session->set_userdata('logged_fname', $row->first_name);
            $this->session->set_userdata('logged_userid', $row->id);
            return true;
        } else {
            return false;
        }

    }

    public function get_user_data($pid){
        $sql = "SELECT * FROM users WHERE ID = {$pid}";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

}

?>