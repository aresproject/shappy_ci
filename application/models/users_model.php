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

    public function get_user_data($args){
        $query = $this->db->get_where('users', $args);
        return $query->row_array();
    }

    public function create_user(){
        $query = $this->db->get_where('users', array('email' => $this->input->post('email')));
        if($query->num_rows() > 0 ){
            $this->session->set_flashdata('notice', "{$this->input->post('email')} is already associated with a registered user... Please use different email");
            return false;
        } else {
            $users= array(
                'first_name' => $this->input->post('fname'),
                'last_name' => $this->input->post('lname'),
                'password' => $this->input->post('password'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'created_at' => date("Y-m-d H:i:s")
            );
            if($this->db->insert('users', $users)) {
                $x = $this->db->last_query();
                $this->session->set_flashdata('notice', 'User registered... ');
                return true;
            } else {
                $x = $this->db->last_query();
                $this->session->set_flashdata('notice', 'Please try again later');
                return false;
            }
        }
    }

    public function get_user_address($pid){
        $sql = "SELECT * FROM user_addresses AS a
                LEFT JOIN countries AS b ON a.address_country_id = b.id
                LEFT JOIN states AS c ON a.address_state_id = c.id
                LEFT JOIN cities AS d ON a.address_city_id = d.id
                WHERE a.user_id = {$pid}";
                
                //and a.is_active = 1";

        $query = $this->db->query($sql);
        return $query->row_array(); 
    }

}

?>