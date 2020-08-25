<?php

Class Stores_model extends CI_Model {
    
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function get_store_data(){
        $sql = "SELECT * FROM stores WHERE id = {$_SESSION['store_id']}";
        $query = $this->db->query($sql);
        $row = $query->row();
        if($query->num_rows() > 0) {
            $this->session->set_userdata('store_name', $row->store_name);
            $this->session->set_userdata('store_email', $row->email);
            $this->session->set_userdata('store_phone', $row->phone_number);
        }
    }

    public function get_pending_orders() {
        $sql = "SELECT b.store_name, a.id, x.orderid, a.product_name, a.price, x.quantity, x.line_price, x.status_name  FROM products AS a
        LEFT JOIN stores AS b ON b.id = a.store_id
        RIGHT JOIN (
            SELECT a.id AS orderid, a.user_id, c.status_name, c.is_pending, b.product_id, b.item_price, b.quantity, b.line_price  
            FROM orders AS a
            LEFT JOIN order_items AS b ON b.order_id = a.id
            LEFT JOIN order_status AS c ON c.order_id = a.id
            LEFT JOIN users AS d ON d.id = a.user_id 
            WHERE c.status_name = 'ON PROCESS' ) AS x ON x.product_id = a.id
        WHERE b.id = {$_SESSION['store_id']}";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_stores_products() {
        $sql = "SELECT id, store_id, description, price, product_name, ratings, is_active 
        FROM products 
        where store_id = {$_SESSION['store_id']}";

        $query = $this->db->query($sql);
        return $query->result();

    }

    public function delete_item($item_id){
    $query="DELETE FROM products WHERE id= {$item_id}";
		$this->db->query($query);
    }


}
?>