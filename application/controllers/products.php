<?php

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('products_model');
        $this->load->helper('url_helper');
    }

    public function search(){  
        if(!is_null($this->input->post('product_search'))) {
            $_SESSION['search_item'] = $this->input->post('product_search');
        }
        $query = $this->db->get_where('products', "product_name LIKE '{$_SESSION['search_item']}%'");
        $view_formats['page_title'] = "Search Results";
        $xconfig['base_url'] = base_url('/products/search/');
        //$xconfig['total_rows'] = $this->db->count_all("products");
        $xconfig['total_rows'] = $query->num_rows();
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
       
        $view_data['products'] = $this->products_model->search_products($xconfig['per_page'], $page_grouper, $_SESSION['search_item']);
        $view_data['pager_x'] = $this->pagination->create_links();
        $this->load->view('header/header',$view_formats)
                    ->view('header/main_nav')
                    ->view('features/product_search')
                    ->view('search', $view_data)
                    ->view('footer/admin_helper')
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
                       ->view('footer/admin_helper')
                       ->view('footer/footer');
    }

    public function cart_add(){
        if($this->products_model->add_to_cart()){
            $this->session->set_flashdata('notice', "Item was added to cart");
        } else {
            $this->session->set_flashdata('notice', "<span class='warning'>Adding Item to Cart Failed... Pls Contact Seller</span>");
        }
        redirect($_SERVER['HTTP_REFERER']);      
    }

    public function view_cart() {
        $view_formats['page_title'] = "VIEW CART";
        $view_data['cart_items'] = $this->products_model->get_cart();
        $this->load->view('header/header',$view_formats)
                       ->view('header/main_nav')
                       ->view('features/product_search')
                       ->view('content/cart_items', $view_data)
                       ->view('footer/admin_helper')
                       ->view('footer/footer');
    }

    public function checkout() {
        switch($this->input->get('checkout')) {
            case 'credit':
                $pay_mode = "credit_card";
                redirect('/main/shop');
                break;
            case 'debit':
                $pay_mode = "debit_card";
                redirect('/main/shop');
                break;
            case 'bank':
                $pay_mode = "bank";
                redirect('/main/shop');
                break;
            case 'cod':
                $pay_mode = "cod";
                redirect('/main/shop');
                break;
            default:
                $view_formats['page_title'] = "Checkout";
                $view_data['cart_items'] = $this->products_model->get_cart();
            
                $this->load->model('users_model');
                $view_data['user_data'] = $this->users_model->get_user_data("id = {$_SESSION['logged_userid']}");
                $view_data['address_data'] = $this->users_model->get_user_address($_SESSION['logged_userid']);
            
                $this->load->view('header/header',$view_formats)
                            ->view('header/main_nav')
                            ->view('checkout', $view_data)
                            ->view('footer/admin_helper')
                            ->view('footer/footer');
            break;
        }
        
        
        
    }



}

?>