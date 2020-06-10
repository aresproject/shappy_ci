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
        $x = $this->db->last_query();
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

        
    }

  /*   public function get_product_tags(){

    } */

    public function add_to_cart(){
        
       /*  
        1. If customer does not have active cart then create new order -> then insert to order_item
        2. Otherwise open active cart (order that has 'On Cart' status) -> then insert to order_item
        3. User must have the order id as "active cart" -> set to 0 when order is "On Process"
        
        */

        $pid = $_SESSION['current_product_id'];
        $uid = $_SESSION['logged_userid'];
        $qty = $this->input->post('qty');

        $orders = array (
            'user_id' => $uid,
            'payment_mode' => "",
            'total_price' => 0.00,
            'total_tax_price' => 0.00,
            'created_at' => date("Y-m-d H:i:s")
        );
        //CREATE AN ORDER Record
        if($this->db->insert('orders', $orders)) {
            $order_id = $this->db->insert_id();
            $line_price = $_SESSION['current_product_price'] * $qty;
            $order_details = array(
                'order_id' => $order_id,
                'product_id' => $_SESSION['current_product_id'],
                'item_price' => $_SESSION['current_product_price'],
                'line_price' => $line_price,
                'quantity' => $qty
            );
            if($this->db->insert('order_items', $order_details)) {
                unset($_SESSION['current_product_id']);
                unset($_SESSION['current_product_price']);
                $_SESSION['notice'] =  "Item was added to cart";
            } else {
                return false;
            }

            //SET THE ORDER to "on cart" status
            $order_status = array(
                'order_id' => $order_id,
                'status_name' => "ON CART",
                'created_at' => date("Y-m-d H:i:s")
            );

            //Tag the user with the order id to indicate an Active "On Cart" order
            $update_user = "UPDATE users SET active_cart = {$order_id}";
            $_SESSION['active_cart'] = $this->db->insert_id();
        } else {
            return false;
        }        

    }

    public function view_cart() {
        $sql = "SELECT * FROM order_items AS a
                LEFT JOIN orders AS b ON b.id = a.order_id
                LEFT JOIN order_status AS c ON b.id = c.order_id 
                WHERE c.status_name = 'ON CART'";
        
    } 

}


?>