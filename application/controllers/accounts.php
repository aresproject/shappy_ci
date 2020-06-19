<?php

Class Accounts extends CI_Controller{

    public function __construct(){
        parent::__construct();
    }

    public function myprofile(){
        $this->load->model('users_model');
        $view_formats['page_title'] = "User Profile";
        $view_data['user_data'] = $this->users_model->get_user_data("id = {$_SESSION['logged_userid']}");
        $view_data['address_data'] = $this->users_model->get_user_address($_SESSION['logged_userid']);
        $this->load->view('header/header',$view_formats)
                    ->view('header/main_nav')
                    ->view('content/user_account', $view_data)
                    ->view('footer/admin_helper')
                    ->view('footer/footer');
    }

}


?>