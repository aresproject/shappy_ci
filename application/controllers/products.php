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

        $xconfig['base_url'] = base_url('/products/search/');
        $xconfig['total_rows'] = $this->db->count_all("products");
        $xconfig['per_page'] = 8;
        $xconfig['uri_segment'] = 3;
        $xconfig['first_link'] = false;
        $xconfig['last_link'] = false;
        $xconfig['full_tag_open'] = "<ul class='pagination'>"; 
        $xconfig['full_tag_close'] = "</ul>"; 
        $xconfig['cur_tag_open'] = "<li class='page-item'><span class='page-link'>";
        $xconfig['cur_tag_close'] = "</span></li>";
        $xconfig['num_tag_open'] = "<li class='page-item'>";
        $xconfig['num_tag_close'] = "</li>";
        $xconfig['attributes'] = array('class' => 'page-link'); //anchor tags

        $this->pagination->initialize($xconfig);
        $page_grouper = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
        $_SESSION['search_item'] = $this->input->post('product_search');
       
        $view_data['products'] = $this->products_model->search_products($xconfig['per_page'], $page_grouper, $_SESSION['search_item']);
        $view_data['pager_x'] = $this->pagination->create_links();
        $this->load->view('header/header',$view_formats)
                    ->view('header/main_nav')
                    ->view('features/product_search')
                    ->view('search', $view_data)
                    ->view('footer/footer');
            //unset($_POST['product_search']);
        
       
    }

    public function view($pid) {
        $view_data['product'] = $this->products_model->get_product($pid);
        $view_data['reviews'] = $this->products_model->get_reviews($pid);
        $view_data['related_products'] = $this->products_model->get_related_products($pid);
        
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