<?Php

Class Products_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function fetch_products($limit=null, $offset=null, $search_item=null){

        $sql = "SELECT a.id, a.product_name, d.brand_name, b.category_name, c.sub_category_name, a.price, a.ratings 
                FROM products AS a
                LEFT JOIN product_categories AS b ON b.id = a.category_id
                LEFT JOIN sub_categories AS c ON c.id = a.sub_category_id
                LEFT JOIN brands AS d ON d.id = a.brand_id
                LEFT JOIN stores as e ON a.store_id = e.id";

        $sql .= is_null($search_item) ? "" : " WHERE a.product_name LIKE '{$search_item}%'"; 
        $sql .= is_null($limit) ? "" : " LIMIT {$limit}";
        $sql .= is_null($offset) ? "" : " OFFSET {$offset}";

        $query = $this->db->query($sql);
        $x = $this->db->last_query();
        return $query->result_array();
    }

    public function search_products($limit=null, $offset=null, $search_item){

        $sql = "SELECT a.id, a.product_name, d.brand_name, b.category_name, c.sub_category_name, a.price, a.ratings 
                FROM products AS a
                LEFT JOIN product_categories AS b ON b.id = a.category_id
                LEFT JOIN sub_categories AS c ON c.id = a.sub_category_id
                LEFT JOIN brands AS d ON d.id = a.brand_id
                LEFT JOIN stores as e ON a.store_id = e.id";
                //WHERE a.product_name LIKE 'c%' ";

        $sql .= " WHERE a.product_name LIKE '{$search_item}%'"; 
        $sql .= is_null($limit) ? "" : " LIMIT {$limit}";
        $sql .= is_null($offset) ? "" : " OFFSET {$offset}"; 

        $query = $this->db->query($sql);
        $x = $this->db->last_query();
        return $query->result_array();
    }

    public function get_product($pid) {
        $sql = "SELECT * FROM products WHERE id = {$pid}";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_reviews($pid) {
        $sql = "SELECT concat(b.first_name, ' ', b.last_name) AS name, a.* FROM reviews AS a
                LEFT JOIN users AS b ON b.id = a.user_id 
                WHERE product_id = {$pid}";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_categories(){
        $sql = "SELECT * FROM product_categories";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_related_products($pid) {
        
        $sql_tags = "SELECT b.id, b.product_name, b.ratings, b.price, a.product_tag_id, c.tag_name FROM tagged_products as A
                LEFT JOIN products AS b ON b.id = a.product_id
                LEFT JOIN product_tags AS c on c.id = a.product_tag_id";

        $sql_tags .= " WHERE b.id = {$pid}";
        
        $query = $this->db->query($sql_tags);
        //$x = $this->db->last_query();
        
        if($query->num_rows() > 0) {
            $product['tags'] = $query->result_array();
            foreach($product['tags'] as $tags) {
                $rel_tags[] = $tags['product_tag_id'];
            } 

            $related_products = "SELECT b.id, b.product_name, b.ratings, b.price, a.product_tag_id, c.tag_name FROM tagged_products as A
                LEFT JOIN products AS b ON b.id = a.product_id
                LEFT JOIN product_tags AS c on c.id = a.product_tag_id";

            $related_products .= " WHERE a.product_tag_id IN (" . implode(",", $rel_tags) . ")";
            $related_products .= " AND b.id != {$pid}";
            $related_products .= " LIMIT 5";

            $query = $this->db->query($related_products);
            $x2 = $this->db->last_query();
            return $query->result_array();
        } else {
            return false;
        }


        

        
    }

    public function add_to_cart(){
        $pid = $_SESSION['current_product_id'];
        $uid = $_SESSION['logged_userid'];
        $qty = $this->input->post('qty');

        $orders = array (
            'user_id' => $uid,
            'payment_mode' => "",
            'total_price' => 0.00,
            'total_tax_price' => 0.00,
            'is_active' => 1,
            'created_at' => date("Y-m-d H:i:s")
        );

        $this->db->trans_start();
        if(!isset($_SESSION['active_cart'])) { //Check first there is no open cart otherwise create a new one as ON CART
            $this->db->insert('orders', $orders); 
            $x = $this->db->last_query();
            $_SESSION['active_cart'] = $this->db->insert_id();

            $order_status = array(
                'order_id' => $_SESSION['active_cart'],
                'status_name' => "ON CART",
                'is_pending' => 1, 
                'created_at' => date("Y-m-d H:i:s")
            );

            $this->db->insert('order_status', $order_status);
            $x = $this->db->last_query();

        }

        $line_price = $_SESSION['current_product_price'] * $qty;
        $order_details = array(
            'order_id' => $_SESSION['active_cart'],
            'product_id' => $_SESSION['current_product_id'],
            'item_price' => $_SESSION['current_product_price'],
            'line_price' => ($_SESSION['current_product_price'] * $qty),
            'quantity' => $qty,
            'created_at' => date("Y-m-d H:i:s")
        );  
        $this->db->insert('order_items', $order_details); //include the product in the cart (Order id with ON CART status)
        $x = $this->db->last_query();
       
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            $this->session->set_flashdata('notice', "Transaction cannot be processed");
            return false;
        } else {
            return true;
        }

    }

    public function get_cart() {
        $sql = "SELECT a.*, e.product_name FROM order_items AS a
                RIGHT JOIN (SELECT b.id, c.status_name, c.is_pending FROM orders AS b
                LEFT JOIN order_status AS c ON c.order_id = b.id
                WHERE STRCMP(c.status_name, 'ON CART') = 0
                AND c.order_id = {$_SESSION['active_cart']}
                AND c.is_pending = 1
                AND b.user_id = {$_SESSION['logged_userid']}) AS d ON d.id = a.order_id
                LEFT JOIN products AS e ON e.id = a.product_id";

        $query = $this->db->query($sql);
        //$x = $this->db->last_query();
        
        return $query->result_array();
        
    }

    public function checkout($pay_mode){
        $orders = array(
            'payment_mode' => $pay_mode,
            'total_price' => $_SESSION['total_price'],
            'total_tax_price' => 0.00,
            'is_active' => 1
        );

        $order_status_old = array (
            'is_pending' => 0,
            'updated_at' => date("Y-m-d H:i:s")
        );

        $order_status_new = array (
            'order_id' => $_SESSION['active_cart'],
            'status_name' => 'ON PROCESS',
            'is_pending' => 1,
            'created_at' => date("Y-m-d H:i:s")
        );
        
        $this->db->trans_start();
            $this->db->update('orders', $orders, array('id' => $_SESSION['active_cart'], 'user_id' => $_SESSION['logged_userid']));
            //$x = $this->db->last_query();
            
            //Tag the Order ID as Finishing The 'On Cart' Status
            $this->db->update('order_status', $order_status_old, array('order_id' => 
            $_SESSION['active_cart'], 'status_name' => 'ON CART'));
            //$x = $this->db->last_query();
            
            //Tag the Order ID as having the On Processing Status
            $this->db->insert('order_status', $order_status_new);
            //$x = $this->db->last_query();
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE){
            $this->session->set_flashdata('notice', "Transaction cannot be processed");
        } else {
            unset($_SESSION['active_cart']);
            unset($_SESSION['total_price']);
        }

       
    }

    public function write_review() {

    }

}


?>