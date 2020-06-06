<?php

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('products_model');
        $this->load->helper('url_helper');
    }

    public function search(){  
        //implement pagination here
        $view_formats['page_title'] = "Search Results";
        if(!empty($this->input->post('product_search'))) {
            $this->session->set_flashdata('tempvar', $this->input->post('product_search'));
            $view_data['products'] = $this->products_model->shopping($this->input->post('product_search'));
            $this->load->view('header/header',$view_formats)
                       ->view('header/main_nav')
                       ->view('features/product_search', $view_data)
                       ->view('shop', $view_data)
                       ->view('footer/footer');
            //unset($_POST['product_search']);
        } else {
            redirect('/main/shop');
        }
       
    }

    public function view($pid) {
        $view_data['product'] = $this->products_model->get_product($pid);
        $view_data['reviews'] = $this->products_model->get_reviews($pid);
        
        foreach($view_data['product'] as $item) {
            $view_formats['page_title'] = $item['product_name'];
        }
        $this->load->view('header/header',$view_formats)
                       ->view('header/main_nav')
                       ->view('features/product_search')
                       ->view('content/product_view', $view_data)
                       ->view('footer/footer');
        
    }



}

?>