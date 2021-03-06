<?php

Class Store extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Stores_model');
        if ( ! $this->session->userdata('logged_email'))
        { 
            redirect('/main');
        }
    }

    public function index(){
        $view_formats['page_title'] = "Store Page";
        $this->Stores_model->get_store_data();
        $view_data['orders'] = $this->Stores_model->get_pending_orders();
        //$view_data['products'] = $this->Stores_model->get_stores_products();
        $this->load->view('header/header',$view_formats)
                    ->view('header/main_nav')
                    ->view('store', $view_data)
                    ->view('footer/footer');
        
        //$this->output->enable_profiler(TRUE);
    }

    public function delete_item(){
        $item_id = $this->input->post('id');
		$this->Stores_model->delete_prod($item_id);	
    }

    public function remove_item(){
        $this->Stores_model->deactivate_item($id);	
    }

    public function fetch_product(){
        if ($this->input->is_ajax_request()) {
            $this->load->model('products_model');
            $item_id = $this->input->post('id');

            if ($view_data['product'] = $this->products_model->get_product($item_id)) {
				$data = array('response' => 'success', 'post' => $view_data['product']);
			}
        }
    }

    public function store_products() {
        $items = $this->Stores_model->get_stores_products();
        $line = 1;
        foreach($items as $record) {
            echo "<tr>";
            echo "<td> {$line} </td>";
            echo "<td> {$record->product_name} </td>";
            echo "<td> {$record->price} </td>";
            echo "<td> {$record->ratings} </td>";
            echo "<td> <button type='button' class='btn btn-success btn-edit
            ' data-id='{$record->id}' data-toggle='modal' data-target='#product_update'>
            Edit</button> | 
                <button  type='button' class='btn btn-danger btn-delete' 
                data-id='{$record->id}'>Delete</button> </td>"; 
            echo "</tr>";
            $line++;
        }
    }
}

?>