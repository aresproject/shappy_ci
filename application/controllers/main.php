<?php

Class Main extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index(){
        $view_data['page_title'] = "Login/Register";
        $this->load->view('header/header', $view_data)->view('login')->view('footer/footer');
    }

    public function login(){
        $this->load->view('header/header')->view('login')->view('footer/footer');
    }

    public function shop() {
        $this->load->library('pagination');
        $this->load->model('products_model');
        $view_formats['page_title'] = "Shopping Page";

        
        $pconfig['base_url'] = base_url('/main/shop/');
        //$config['total_rows'] = 30;
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
        $pager = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $view_data['products'] = $this->products_model->fetch_products($pconfig["per_page"], $pager);
        $view_data['nav'] = $this->pagination->create_links();//create the link for pagination
        $view_data['mainpage'] = "shop";
        $this->load->view('header/header',$view_formats)
                   ->view('shop', $view_data)
                   ->view('footer/footer');
                   

    

        /* $view_formats['page_title'] = "Shopping Page";
        $this->load->model('products_model');
        $view_data['products'] = $this->products_model->shopping(null, 100);
        $this->load->view('header/header',$view_formats)
                    ->view('/features/navigation')
                    ->view('/features/product_search')
                    ->view('shop', $view_data)
                    ->view('footer/footer'); */
    }

}

?>