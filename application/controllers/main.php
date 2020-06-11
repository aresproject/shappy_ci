<?php

Class Main extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index(){
        $view_data['page_title'] = "Login/Register";
        $this->load->view('header/header', $view_data)
                   ->view('login')
                   ->view('footer/admin_helper')
                   ->view('footer/footer');
    }

    public function login(){
        $this->load->model('users_model');
        if($this->users_model->valid_login()) {
            $this->users_model->has_active_cart();
            redirect('/main/shop');
        } else {
            $this->session->set_flashdata('notice', "Invalid email and password");
            redirect('/main');
        }
        
    }

    public function shop() {
        $this->load->model('products_model');
        $view_formats['page_title'] = "Shopping Page";


        //put this in a configuration file
        $pconfig['base_url'] = base_url('/main/shop/');
        $pconfig['total_rows'] = $this->db->count_all("products");
        $pconfig['per_page'] = 8;
        $pconfig['uri_segment'] = 3;
        $pconfig['first_link'] = false;
        $pconfig['last_link'] = false;
        $pconfig['full_tag_open'] = "<ul class='pagination'>"; 
        $pconfig['full_tag_close'] = "</ul>"; 
        $pconfig['cur_tag_open'] = "<li class='page-item'><span class='page-link'>";
        $pconfig['cur_tag_close'] = "</span></li>";
        $pconfig['num_tag_open'] = "<li class='page-item'>";
        $pconfig['num_tag_close'] = "</li>";
        $pconfig['attributes'] = array('class' => 'page-link'); //anchor tags

        $this->pagination->initialize($pconfig);
        $page_group = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $view_data['products'] = $this->products_model->fetch_products($pconfig["per_page"], $page_group, null);
        $view_data['filters'] = $this->products_model->get_categories();
        $view_data['pager'] = $this->pagination->create_links();
        
        //$view_data['mainpage'] = "shop";
        
        $this->load->view('header/header',$view_formats)
                   ->view('header/main_nav')
                   ->view('features/product_search')
                   ->view('shop', $view_data)
                   ->view('footer/admin_helper')
                   ->view('footer/footer');
                   
    }

    public function logout() {
        //destroy session routine
        $this->session->sess_destroy();
        redirect('/main');
    }

}

?>