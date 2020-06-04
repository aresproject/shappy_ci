<?PHP

Class Products_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function shopping($pname = null, $limit = null){
        $sql = "SELECT a.id, a.product_name, d.brand_name, b.category_name, c.sub_category_name, a.price, a.ratings FROM PRODUCTS AS a
        LEFT JOIN product_categories AS b ON b.id = a.category_id
        LEFT JOIN sub_categories AS c ON c.id = a.sub_category_id
        LEFT JOIN brands AS d ON d.id = a.brand_id
        LEFT JOIN stores as e ON a.store_id = e.id";
        
        if($pname != null) {
            $sql .= " WHERE a.product_name LIKE '%{$pname}%'"; 
        }

        $sql .= is_null($limit) ? "" : " LIMIT {$limit}";
        $query = $this->db->query($sql);
        $x = $this->db->last_query();
        return $query->result_array();
    }


}


?>