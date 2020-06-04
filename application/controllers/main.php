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
        $view_formats['page_title'] = "Shopping Page";
        $this->load->model('products_model');
        $view_data['products'] = $this->products_model->shopping(null, 20);
        $this->load->view('header/header',$view_formats)
                    ->view('/features/navigation')
                    ->view('/features/product_search')
                    ->view('shop', $view_data)
                    ->view('footer/footer');
    }

}

?>