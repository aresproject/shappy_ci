<?php

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('products_model');
        $this->load->helper('url_helper');
    }

    public function search(){
          
        $view_formats['page_title'] = "Search Results";
        if(!empty($this->input->post('product_search'))) {
            $this->session->set_flashdata('tempvar', $this->input->post('product_search'));
            $view_data['products'] = $this->products_model->shopping($this->input->post('product_search'));
            $this->load->view('header/header',$view_formats)
                    ->view('/features/navigation')
                    ->view('/features/product_search')
                    ->view('shop', $view_data)
                    ->view('footer/footer');
            unset($_POST['product_search']);
        } else {
            redirect('/main/shop');
        }
       
    }

}

?>