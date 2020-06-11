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

    public function has_active_cart(){
        $sql = "SELECT c.*, a.id FROM users AS a 
                LEFT JOIN (SELECT b1.user_id, b2.order_id, b2.status_name, b2.is_pending FROM orders AS b1 
                LEFT JOIN order_status AS b2 ON b2.order_id = b1.id 
                WHERE STRCMP(b2.status_name, 'ON CART') = 0
                AND b2.is_pending = 1) AS c ON c.user_id = a.id
                WHERE a.id = {$_SESSION['logged_userid']}";

        $query = $this->db->query($sql);
        $row = $query->row();
        if($query->num_rows() > 0 ) {
            $this->session->set_userdata('active_cart', $row->order_id);
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