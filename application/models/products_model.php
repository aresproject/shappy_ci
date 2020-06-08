<?PHP

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

    public function get_related_products($pid) {
        
        $sql_tags = "SELECT b.id, b.product_name, b.ratings, b.price, a.product_tag_id, c.tag_name FROM tagged_products as A
                LEFT JOIN products AS b ON b.id = a.product_id
                LEFT JOIN product_tags AS c on c.id = a.product_tag_id";

        $sql_tags .= " WHERE b.id = {$pid}";
        
        $query = $this->db->query($sql_tags);
        $x = $this->db->last_query();
        $product['tags'] = $query->result_array();

        foreach($product['tags'] as $tags) {
            $rel_tags['tag'] = $tags['product_tag_id'];
        }
        
        $bb = array('1', '2', '3');

        $related_products = "SELECT b.id, b.product_name, b.ratings, b.price, a.product_tag_id, c.tag_name FROM tagged_products as A
                LEFT JOIN products AS b ON b.id = a.product_id
                LEFT JOIN product_tags AS c on c.id = a.product_tag_id";

        $related_products .= " WHERE a.product_tag_id IN (" . implode(",", $bb) . ")";
        $related_products .= " LIMIT 3";

        $query = $this->db->query($related_products);
        $x2 = $this->db->last_query();
        return $query->result_array();

        
    }

    public function get_product_tags(){

    }

    public function add_to_cart(){

    }

    public function view_cart(){
        
    }


}


?>