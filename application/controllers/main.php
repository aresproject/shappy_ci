<?php

Class Main extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index(){
        $view_data['page_title'] = "Login/Register";
        $this->load->view('header/header', $view_data)
                   ->view('login')
                   ->view('footer/footer');
    }

    public function login(){
        $this->load->model('Users_model');
        if($this->Users_model->valid_login()) {
            $this->Users_model->has_active_cart();
            if($_SESSION['store_id'] > 0) {
                redirect('/store');
            } 
            else {
                redirect('/main/shop');
            }     
        } 
        else {
            $this->session->set_flashdata('login_notice', "Invalid email and password");
            redirect('/main');
        } 
    }

    public function shop($category = null) {

        if ( ! $this->session->userdata('logged_email'))
        { 
            redirect('/main');
        }
        
        $this->load->model('products_model');
        $view_formats['page_title'] = "Shopping Page";

        $pagination_main = array(
            'base_url' => base_url('/main/shop/'),
            'total_rows' => $this->db->count_all("products"),
            'per_page' => 8,
            'uri_segment' => 3,
            'first_link' => false,
            'last_link' => false,
            'full_tag_open' => "<ul class='pagination'>", 
            'full_tag_close' => "</ul>", 
            'cur_tag_open' => "<li class='page-item'><span class='page-link'>",
            'cur_tag_close' => "</span></li>",
            'num_tag_open' => "<li class='page-item'>",
            'num_tag_close' => "</li>",
            'attributes' => array('class' => 'page-link')
        ); 
        $this->pagination->initialize($pagination_main);

        $page_group = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $view_data['products'] = $this->products_model->fetch_products($pagination_main["per_page"], $page_group, null, $category);
       
        $view_data['filters'] = $this->products_model->get_categories();
        $view_data['pager'] = $this->pagination->create_links();
        
        //$view_data['mainpage'] = "shop";
        
        $this->load->view('header/header',$view_formats)
                   ->view('header/main_nav')
                   ->view('features/product_search')
                   ->view('shop', $view_data)
                   ->view('footer/admin_helper')
                   ->view('footer/footer');
                   $this->output->enable_profiler(TRUE);
    }

    public function sign_up(){
        $this->form_validation->set_rules('fname', 'First Name', 'required|min_length[2]');
        $this->form_validation->set_rules('lname', 'Last Name', 'required|min_length[2]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('cpassword', 'Password Confirmation', 'trim|required|matches[password]');
        $this->form_validation->set_rules('phone', 'Phone number', 'required');
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');

        if($this->form_validation->run()){
            if($this->user_model->create_user()) {
                redirect('/main/');
            }
        } else {
            $this->session->set_flashdata('notice', validation_errors());
            $view_data['page_title'] = "Login/Register";
            $this->load->view('header/header', $view_data)
                   ->view('login')
                   ->view('footer/footer');
        }
    }

    public function logout() {
        //destroy session routine
        $this->session->sess_destroy();
        redirect('/main');
    }

    public function test(){
        $person = array(
            "name" => "Alex",
            "age" => 33
        );
        echo json_encode($person);
    }
        
}

?>