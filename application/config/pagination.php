<?php 

//$this->load->database();

$config_main = array(
    'base_url' => base_url('/main/shop/'),
    //'total_rows' => $this->db->count_all("products"),
    'per_page' => 8,
    'uri_segment' => 3,
    'first_link' => false,
    'last_link' => false,
    'full_tag_open' => "<ul class='pagination'>", 
    'full_tag_close' => "</ul>", 
    'cur_tag_open' => "<li class='page-item'><span class='page-link'>",
    'cur_tag_close' => "</span></li>",
    'num_tag_open' => "<li class='page-item'>",
    'num_tag_close' => "</li>",
    'attributes' => array('class' => 'page-link')
);

$pagination_search = array (
    'base_url' => base_url('/products/search/'),
    //'total_rows' => $query->num_rows(),
    'per_page' => 8,
    'uri_segment' => 3,
    'first_link' => false,
    'last_link' => false,
    'full_tag_open' => "<ul class='pagination'>", 
    'full_tag_close' => "</ul>", 
    'cur_tag_open' => "<li class='page-item'><span class='page-link'>",
    'cur_tag_close' => "</span></li>",
    'num_tag_open' => "<li class='page-item'>",
    'num_tag_close' => "</li>",
    'attributes' => array('class' => 'page-link') //anchor tags
);
    


?>