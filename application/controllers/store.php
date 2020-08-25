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
        $view_data['products'] = $this->Stores_model->get_stores_products();
        $this->load->view('header/header',$view_formats)
                    ->view('header/main_nav')
                    ->view('store', $view_data)
                    ->view('footer/footer');
        
        $this->output->enable_profiler(TRUE);
    }

    public function delete_item(){
        if($this->input->post('type')==2)
		{
			$id=$this->input->post('id');
			$this->stores_model->delete_item($id);	
			echo json_encode(array(
				"statusCode"=>200
			));
		} 
    }

    public function store_products() {
        $items = $this->Stores_model->get_stores_products();
        $line = 1;
        foreach($items as $record) {
            echo "<tr>";
            echo "<td> {$line} </td>";
            echo "<td> {$record['product_name']} </td>";
            echo "<td> {$record['price']} </td>";
            echo "<td> {$record['ratings']} </td>";
            echo "<td> <button type='button' class='btn'>Edit</button> | <button  type='button' class='btn btn-danger delete' data-id='{$record['id']}'>Delete</button> </td>"; 
            echo "</tr>";
            $line++;
        }
    }
}

?>