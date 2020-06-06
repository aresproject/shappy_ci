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

    public function get_product($pid) {
        $sql = "SELECT * FROM products WHERE id = {$pid}";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_reviews($pid) {
        $sql = "SELECT * FROM reviews WHERE product_id = {$pid}";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function add_to_cart(){

    }

    public function view_cart(){
        
    }


}


?>