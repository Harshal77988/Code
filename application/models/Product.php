<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product extends MY_Model {

    public $_table = 'tbl_products';
    public $primary_key = 'id';
    protected $soft_delete = true;
    protected $soft_delete_key = 'isactive';

    function get_level($group_id) {

        $result = $this->db->get_where('main_groups', array('id' => $group_id))->row();
        return $result->level;
        //echo $this->db->last_query();exit;
    }

    public function getWishlistByUserID($user_id) {
        try {
            $this->db->select('pr.id, wl.id as wid, pr.image_url, pr.category_id, pr.category_id, pr.product_sku, pr.isactive, pr.discounted_price, pr.product_name, pr.price, pr.quantity, wl.user_id, wl.product_id');
            $this->db->from('tbl_wishlist wl');
            $this->db->join('tbl_products pr', 'wl.product_id = pr.id', 'LEFT');
            $this->db->where('wl.user_id', $user_id);

            $query = $this->db->get();

            // echo $this->db->last_query(); die;

            // return the result of the query
            return $query->result_array();

        } catch (Exception $e) {
            echo $e; die;
        }
    }

    // get the featured products to display it on home page carousel
    public function get_feature_product()
    {
        // check the exception 
        try {        
            $this->db->select('ip.id, ip.image_url, pc.name as category_name, ip.category_id, ip.product_sku, ip.isactive, ip.discounted_price, ip.product_name, ip.price, ip.quantity');
            $this->db->from('tbl_products ip');
            $this->db->join('tbl_product_category pc', 'pc.id = ip.category_id', 'LEFT');
            // $this->db->join('tbl_product_review opr', 'opr.product_id = ip.id', 'LEFT');
            $this->db->where('ip.product_is_feature', '1');
            // $this->db->where('ip.product_type', '1');
            $this->db->group_by('ip.id');
            $this->db->order_by('ip.id', 'DESC');
            $this->db->limit(15);
            $query = $this->db->get();

            // return the result of the query
            return $query->result_array();
        } catch (Exception $e) {
            echo $e; die;
        }
    }

    public function get_onrent_product()
    {
        // check the exception 
        try {        
            $this->db->select('ip.id, ip.image_url,ip.plan, ip.product_sku, ip.isactive, ip.product_name, ip.rent, ip.quantity, pcm.subcategory_id as subcategory_id');
            $this->db->from('tbl_rent_products ip');
            $this->db->join('tbl_rent_product_cat_subcat_map pcm', 'pcm.product_id = ip.id', 'LEFT');
            
            // $this->db->join('tbl_product_category pc', 'pc.id = ip.category_id', 'LEFT');
            // $this->db->join('tbl_product_review opr', 'opr.product_id = ip.id', 'LEFT');
            // $this->db->where('ip.product_is_feature', '1');
            // $this->db->group_by('ip.id');
            $this->db->order_by('ip.id', 'DESC');
            $this->db->limit(15);
            $query = $this->db->get();


            // return the result of the query
            return $query->result_array();
        } catch (Exception $e) {
            echo $e; die;
        }        
    }

    function get_best_seller_products()
    {
        // check the exception 
        try {
            $this->db->select('ip.id, ip.image_url, pc.name as category_name, ip.category_id,ip.category_id,ip.product_sku,ip.isactive,ip.discounted_price, ip.product_name,ip.price,ip.quantity');
            $this->db->from('tbl_products ip');
            $this->db->join('tbl_product_category pc', 'pc.id = ip.category_id', 'LEFT');
            // $this->db->join('tbl_product_review opr', 'opr.product_id = ip.id', 'LEFT');
            // $this->db->where('ip.category_id', '2');
            // $this->db->where('ip.product_type', '1');
            $this->db->group_by('ip.id');
            $this->db->order_by('ip.product_sale_count', 'DESC');
            $this->db->limit(15);
            $query = $this->db->get();
            
            // echo $this->db->last_query(); die;

            $sellerData = $query->result_array();
            if (!empty($sellerData))
                return $sellerData;
            else
                return null;
            // return the result of the query as an array
            return $query->result_array();
        } catch (Exception $e) {
            echo $e; die;
        }
    }


    function get_best_seller_products_by_category_id($category_id)
    {
        // check the exception 
        try {
            $this->db->select('ip.id as product_id, ip.image_url, pc.name as category_name, ip.category_id,ip.category_id,ip.product_sku,ip.isactive,ip.discounted_price, ip.product_name,ip.price,ip.quantity');
            $this->db->from('tbl_products ip');
            $this->db->join('tbl_product_category pc', 'pc.id = ip.category_id', 'LEFT');
            // $this->db->join('tbl_product_review opr', 'opr.product_id = ip.id', 'LEFT');
            // $this->db->where('ip.category_id', '2');
            // $this->db->where('ip.product_type', '1');
            $this->db->where('ip.category_id', $category_id);
            $this->db->group_by('ip.id');
            $this->db->order_by('ip.product_sale_count', 'DESC');
            $this->db->limit(15);
            $query = $this->db->get();
            
            // echo $this->db->last_query(); die;

            $sellerData = $query->result_array();
            if (!empty($sellerData))
                return $sellerData;
            else
                return null;
            // return the result of the query as an array
            return $query->result_array();
        } catch (Exception $e) {
            echo $e; die;
        }
    }


    // get the featured products to display it on home page carousel
    public function get_feature_product_by_category_id($category_id)
    {
        // check the exception 
        try {        
            $this->db->select('ip.id, ip.image_url, pc.name as category_name, ip.category_id, ip.category_id, ip.product_sku, ip.isactive, ip.discounted_price, ip.product_name, ip.price, ip.quantity');
            $this->db->from('tbl_products ip');
            $this->db->join('tbl_product_category pc', 'pc.id = ip.category_id', 'LEFT');
            // $this->db->join('tbl_product_review opr', 'opr.product_id = ip.id', 'LEFT');
            $this->db->where('ip.product_is_feature', '1');
            $this->db->where('ip.category_id', $category_id);
            // $this->db->where('ip.product_type', '1');
            $this->db->group_by('ip.id');
            $this->db->order_by('ip.id', 'DESC');
            $this->db->limit(15);
            $query = $this->db->get();

            // return the result of the query
            return $query->result_array();
        } catch (Exception $e) {
            echo $e; die;
        }
    }


    // Added by Ranjit Pasale on 20 Dec 2017 Start
    function get_highlighted_products_landing_page()
    {
        // check the exception 
        try {

            $this->db->select('ip.id as product_id, ip.image_url, ip.category_id,ip.category_id,ip.product_sku,ip.isactive,ip.discounted_price, ip.product_name,ip.price,ip.quantity,hip.id, hip.sale_type, hip.product_title, hip.img_url, hip.price as highlighted_price');
            $this->db->from('tbl_highlighted_products hip');
            $this->db->join('tbl_products ip', 'hip.product_id = ip.id','LEFT');
            $this->db->order_by('hip.id', 'DESC');
            // $this->db->limit(3);
            $query = $this->db->get();
            
            // echo $this->db->last_query(); die;

            $highlightedData = $query->result_array();
            if (!empty($highlightedData))
                return $highlightedData;
            else
                return null;
            // return the result of the query as an array
            return $query->result_array();
        } catch (Exception $e) {
            echo $e; die;
        }

    }


    function get_dow_products_landing_page()
    {
        // check the exception 
        try {

            $current_date_time=date('Y-m-d H:m:s');

            $this->db->select('ip.id as product_id, ip.image_url, ip.category_id,ip.category_id,ip.product_sku,ip.isactive,ip.discounted_price, ip.product_name,ip.price,ip.quantity,dowp.start_date_time,dowp.end_date_time,pc.name as category_name');
            $this->db->from('tbl_dow_products dowp');
            $this->db->join('tbl_products ip', 'dowp.product_id = ip.id','LEFT');
            $this->db->join('tbl_product_category pc', 'ip.category_id = pc.id', 'LEFT');
            $this->db->where('dowp.end_date_time>',$current_date_time);
            $this->db->where('ip.deals_of_the_week','1');
            $this->db->order_by('ip.id', 'DESC');
            $this->db->limit(4);
            $query = $this->db->get();
            
            // echo $this->db->last_query(); die;

            $highlightedData = $query->result_array();
            if (!empty($highlightedData))
                return $highlightedData;
            else
                return null;
            return $query->result_array();
        } catch (Exception $e) {
            echo $e; die;
        }
    }


    function get_os_products_landing_page()
    {
        // check the exception 
        try {

            $this->db->select('ip.id as product_id, ip.image_url, ip.category_id,ip.category_id,ip.product_sku,ip.isactive,ip.discounted_price, ip.product_name,ip.price,ip.quantity,ip.short_description');
            $this->db->from('tbl_products ip');
            $this->db->where('ip.on_sale','1');
            $this->db->order_by('ip.id', 'DESC');
            $this->db->limit(4);
            $query = $this->db->get();
            
            // echo $this->db->last_query(); die;

            $highlightedData = $query->result_array();
            if (!empty($highlightedData))
                return $highlightedData;
            else
                return null;
            return $query->result_array();
        } catch (Exception $e) {
            echo $e; die;
        }
    }

    // Added by Ranjit Pasale on 20 Dec 2017 end


    /**
     * product details by product id
     * @author      Harshal B <harshalb@rebelute.com>
     * @return      product details by product id
     */
    public function getProductById($product_id) {

        try {
            // $this->db->select('ip.id as product_id, ip.category_id, ip.product_sku, ip.isactive, ip.discounted_price, ip.product_name, ip.price, ip.quantity, opr.review_total, ip.image_url, ip.description');
            $this->db->select('ip.id as product_id, ip.product_is_feature, ip.additional_information, ip.product_video, ip.discounted_price, ip.product_sale_count, ip.createddate, ip.category_id, ip.product_sku, ip.isactive, ip.discounted_price, ip.product_name, ip.price, ip.quantity, ip.image_url, ip.short_description, ip.description, pc.name, br.brand_name as brand, br.id as brand_id');
            $this->db->from('tbl_products ip');
            $this->db->join('tbl_product_category pc', 'ip.category_id = pc.id', 'LEFT');
            $this->db->join('tbl_brands br', 'br.id = ip.brand_id', 'LEFT');
            // $this->db->join('tbl_product_attributes pa', 'pa.product_id = ip.id', 'LEFT');
            // $this->db->join('tbl_product_review opr', 'opr.product_id = ip.id', 'LEFT');
            $this->db->where('ip.id', $product_id);
            $this->db->group_by('ip.id');
            $query = $this->db->get();

            // echo $this->db->last_query(); die;
            return $query->result_array();   
        } catch (Exception $e) {
            echo $e; die;
        }
    }
   
    public function getAllAttributes($category_id = NULL) {

        $this->db->select('*');
        $this->db->from('tbl_product_attributes');
        $this->db->where('category_id', $category_id);
        $this->db->group_by('attribute_value');
        $query = $this->db->get();
        // echo $this->db->last_query(); die;
        return $query->result_array();
    }

    public function getAttributeValuesById($attribute_value, $category_id) {

        $this->db->select('*');
        $this->db->from('tbl_product_attributes');
        $this->db->group_by('sub_attribute_value');
        $this->db->where(array('attribute_value'=> $attribute_value, 'category_id' => $category_id, 'sub_attribute_value !=' => ''));
        $query = $this->db->get();
        // echo $this->db->last_query(); die;
        return $query->result_array();
    }

    public function getProductAttributesById($product_id) {

        $this->db->select('*');
        $this->db->from('tbl_product_attributes');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        // echo $this->db->last_query(); die;
        return $query->result_array();
    }


    /**
     * product details by product id
     * @author      Harshal B <harshalb@rebelute.com>
     * @return      product details by product id
     */
    public function getProductDetailById($product_id) {

        $this->db->select('*');
        $this->db->from('tbl_products ip');
        $this->db->where('ip.id', $product_id);
        $this->db->group_by('ip.id');
        $query = $this->db->get();
        $res = $query->result_array();        
        return $res[0];
    }

    /**
     * related product by category id
     * @author      Harshal B <harshalb@rebelute.com>
     * @return      related products array by category id
     */
    public function getRelatedProductCategory($category_id, $product_id) {

        try {
            // $this->db->select('ip.id as product_id, ip.category_id, ip.product_sku, ip.isactive, ip.discounted_price, ip.product_name, ip.price, ip.quantity, opr.review_total, ip.image_url, ip.description');
            $this->db->select('ip.id as product_id, ip.category_id, ip.product_sku, ip.isactive, ip.discounted_price, ip.product_name, ip.price, ip.quantity, ip.image_url, ip.description, pc.name');
            $this->db->from('tbl_products ip');
            $this->db->join('tbl_product_category pc', 'ip.category_id = pc.id', 'LEFT');
            // $this->db->join('tbl_product_review opr', 'opr.product_id = ip.id', 'LEFT');
            $this->db->where('pc.id', $category_id);
            $this->db->where('ip.id !=', $product_id);
            $this->db->group_by('ip.id');
            $query = $this->db->get();
            $result = $query->result_array();
            // echo $this->db->last_query(); die;
            return $result;
        } catch (Exception $e) {
            echo $e; die;
        }
    }

    function get_products_exports() {
        $this->db->cache_on();
//        if (isset($keywords)) {
//            echo '<pre>', print_r($keywords);
//            die;
//        }
        //,pst.sub_name as brand_name
        $this->db->select('ip.id, ip.category_id, ip.discounted_price, ip.product_sku, ip.isactive, ip.product_name, ip.price, ip.quantity, opr.review_total, pst.sub_name as brand_name, ipa.*, ip.image_url');

        $this->db->from('tbl_products ip');
//        $this->db->join('tbl_products_image ipm', 'ipm.product_id = ip.id', 'LEFT');
        $this->db->join('tbl_product_attributes ipa', 'ipa.product_id = ip.id', 'LEFT');
        $this->db->join('tbl_p_sub_attributes pst', 'pst.id = ipa.sub_attribute_dp_id');
        $this->db->join('tbl_product_review opr', 'opr.product_id = ip.id', 'LEFT');

        if (isset($keywords) && $keywords != null) {
            if ($keywords['sortBy'] == 'product_sku') {
                $this->db->where('ip.product_sku', $keywords['value']);
                $this->db->order_by('ip.product_sku', 'DESC');
            }
            if ($keywords['sortBy'] == 'product_name') {
                $this->db->like('ip.product_name', $keywords['value']);
                $this->db->order_by('ip.product_name', 'ASC');
            }
            if ($keywords['sortBy'] == 'size') {
                $this->db->like('ipa.sub_attribute_value', $keywords['value']);
                $this->db->order_by('ipa.sub_attribute_value', 'ASC');
            }
            if ($keywords['sortBy'] == 'price') {
                $price = $keywords['value'];
                $price = (int) $price;
//                ,array($keywords['value'],'5000'
                $this->db->where('ip.price >=', $keywords['value']);
                $this->db->where('ip.price <=', 2000);
                $this->db->order_by('ip.price', 'ASC');
            }
        } else
        $this->db->order_by('ip.id', 'DESC');



        $this->db->group_by('ip.id');

//        if ($start != null && $limit != null)
//            $this->db->limit($limit, $start);
//        else
        $this->db->limit(10, 0);


        $query = $this->db->get();
//        if (isset($keywords) && $keywords != null) {
//            echo $this->db->last_query();
//            die;
//        }
//        echo $this->db->last_query();
//            die;

        $this->db->cache_off();
        return $query->result_array();
    }

    function get_products($start = null, $limit = null, $keywords = null) {

        $this->db->cache_on();

        //,pst.sub_name as brand_name
        $this->db->select('ip.id, ip.category_id, ip.product_sku, ip.product_name, ip.isactive, ip.price, ip.discounted_price, ip.quantity, ip.image_url, ip.highlighted, ip.deals_of_the_week, ip.on_sale');
        $this->db->from('tbl_products ip');
        // $this->db->join('tbl_product_attributes ipa', 'ipa.product_id = ip.id');
        // $this->db->join('tbl_p_sub_attributes pst', 'pst.id = ipa.sub_attribute_dp_id');
        // $this->db->join('tbl_product_review opr', 'opr.product_id = ip.id', 'LEFT');

        if (isset($keywords) && $keywords != null) {
            if ($keywords['sortBy'] == 'product_sku') {
                $this->db->where('ip.product_sku', $keywords['value']);
                $this->db->order_by('ip.product_sku', 'DESC');
            }
            if ($keywords['sortBy'] == 'product_name') {
                $this->db->like('ip.product_name', $keywords['value']);
                $this->db->order_by('ip.product_name', 'ASC');
            }
            if ($keywords['sortBy'] == 'size') {
                $this->db->like('ipa.sub_attribute_value', $keywords['value']);
                $this->db->order_by('ipa.sub_attribute_value', 'ASC');
            }
            if ($keywords['sortBy'] == 'price') {
                $price = $keywords['value'];
                $price = (int) $price;
//                ,array($keywords['value'],'5000'
                $this->db->where('ip.price >=', $keywords['value']);
                $this->db->where('ip.price <=', 2000);
                $this->db->order_by('ip.price', 'ASC');
            }
        } else
        $this->db->order_by('ip.id', 'DESC');

        $this->db->group_by('ip.id');

        // if ($start != null && $limit != null)
        //     $this->db->limit($limit, $start);
        // else
        //     $this->db->limit(50, 0);

        $query = $this->db->get();

        // echo $this->db->last_query(); die;

        $this->db->cache_off();
        return $query->result_array();
    }

    function get_product_by_category_id($categoryId = null, $subCategoryId = null, $start = null, $limit = null) {

//        $this->db->cache_on();

        $this->db->select('ip.category_id, ip.product_sku, ip.discounted_price, ip.product_name, ip.isactive, ip.price, ip.quantity, ip.image_url, ip.description, ip.id as product_id');
        $this->db->from('tbl_products ip');

        if (isset($categoryId) && $categoryId != null && $categoryId != '0') {
            $this->db->where('ip.category_id', $categoryId);
        }
        
        if (isset($subCategoryId) && $subCategoryId != null) {
            $this->db->select('ipa.*');
            $this->db->join('tbl_product_attributes ipa', 'ipa.product_id = ip.id');
            $this->db->where('ipa.attribute_id', $subCategoryId);
        }

//        if ($categoryId = null && $subCategoryId = null)
        $this->db->order_by('ip.id', 'DESC');
        $this->db->where('ip.isactive', 0);

        $this->db->group_by('ip.id');

        if ($start != null && $limit != null) {
            $this->db->limit($limit, $start);
            // $query = $this->db->get();
            // echo $this->db->last_query(); die;        
        } else {
            $this->db->limit(5, 0);
        }


        $query = $this->db->get();
       // echo $this->db->last_query();die;
//        $this->db->cache_off();
        return $query->result_array();
    }

//     function get_product_by_category_subcategory($categoryId = null, $subCategoryId = null, $start = null, $limit = null) {

// //        $this->db->cache_on();

//         $this->db->select('ip.category_id, ip.product_sku, ip.discounted_price, ip.product_name, ip.isactive, ip.price, ip.quantity, ip.image_url, ip.description, ip.id as product_id');
//         $this->db->from('tbl_products ip');

//         if (isset($categoryId) && $categoryId != null && $categoryId != '0') {
//             $this->db->where('ip.category_id', $categoryId);
//         }

//         if (isset($subCategoryId) && $subCategoryId != null && $subCategoryId != '0') {
//             $this->db->where('ip.sub_cat_id', $subCategoryId);
//         }


//         $this->db->order_by('ip.id', 'DESC');
//         $this->db->where('ip.isactive', 0);

//         if ($start != null && $limit != null) {
//             $this->db->limit($limit, $start);
//             // $query = $this->db->get();
//             // echo $this->db->last_query(); die;        
//         } else {
//             $this->db->limit(5, 0);
//         }
//  // echo $this->db->last_query(); die;
//         $query = $this->db->get();
//         return $query->result_array();
//     }


    function get_product_by_category_subcategory($categoryId = null, $subCategoryId = null, $start = null, $limit = null) {

        // echo $start."".$limit; die;
//        $this->db->cache_on();

        $this->db->select('ip.category_id, ip.on_sale, ip.product_sku, pc.name as category_name, pc.description as category_description, ip.discounted_price, ip.product_name, ip.isactive, ip.price, ip.quantity, ip.image_url, ip.description, ip.id as product_id, br.brand_name as brand, br.id as brand_id');

        $this->db->from('tbl_products ip');
        $this->db->join('tbl_product_category pc', 'pc.id = ip.category_id', 'LEFT');
        $this->db->join('tbl_subcategories_map tsm', 'tsm.product_id = ip.id', 'LEFT');
        $this->db->join('tbl_brands br', 'br.id = ip.brand_id', 'LEFT');

        if (isset($categoryId) && $categoryId != null && $categoryId != '0') {
            $this->db->where('tsm.category_id', $categoryId);
        }

        // if (isset($subCategoryId) && $subCategoryId != null && $subCategoryId != '0') {
        //     $this->db->where('ip.sub_cat_id', $subCategoryId);
        // }

        // search by sku number or product name
        if (isset($subCategoryId) && $subCategoryId != null && $subCategoryId != '0' && $categoryId == '0') {

            $this->db->where_in('ip.product_sku', urldecode($subCategoryId));
            $this->db->or_like('ip.product_name', urldecode($subCategoryId));
            // $this->db->where('ip.product_sku', $subCategoryId);
        }


        $this->db->order_by('ip.id', 'DESC');
        $this->db->group_by('tsm.product_id');
        $this->db->where('ip.isactive', 0);

        if ($start != '' && $limit != '') {
            $this->db->limit($limit, $start);
            // $query = $this->db->get();
            // echo $this->db->last_query();       
        } else {
            $this->db->limit(16, 0);
        }
        
        // echo $this->db->last_query();
        $query = $this->db->get();
        return $query->result_array();
    }


    function get_product_count_by_category_subcategory($categoryId = null, $subCategoryId = null) {

        $this->db->select('ip.category_id, ip.on_sale, ip.product_sku, pc.name as category_name, pc.description as category_description, ip.discounted_price, ip.product_name, ip.isactive, ip.price, ip.quantity, ip.image_url, ip.description, ip.id as product_id, br.brand_name as brand, br.id as brand_id');

        $this->db->from('tbl_products ip');
        $this->db->join('tbl_product_category pc', 'pc.id = ip.category_id', 'LEFT');
        $this->db->join('tbl_subcategories_map tsm', 'tsm.product_id = ip.id', 'LEFT');
        $this->db->join('tbl_brands br', 'br.id = ip.brand_id', 'LEFT');

        if (isset($categoryId) && $categoryId != null && $categoryId != '0') {
            $this->db->where('tsm.category_id', $categoryId);
        }


        // search by sku number or product name
        if (isset($subCategoryId) && $subCategoryId != null && $subCategoryId != '0' && $categoryId == '0') {

            $this->db->where_in('ip.product_sku', urldecode($subCategoryId));
            $this->db->or_like('ip.product_name', urldecode($subCategoryId));
        }

        $this->db->order_by('ip.id', 'DESC');
        $this->db->group_by('tsm.product_id');
        $this->db->where('ip.isactive', 0);
        
        // echo $this->db->last_query();
        $query = $this->db->get();
        return $query->result_array();
    }


    // get the barnds for filter on product list page
    public function getBrandsById() {

        $this->db->select('br.*, pr.brand_id');
        $this->db->from('tbl_brands br');
        $this->db->join('tbl_products pr', 'pr.brand_id = br.id', 'INNER');

        $this->db->order_by('br.brand_name', 'ASC');
        $this->db->group_by('pr.brand_id');

        $query = $this->db->get();
        // echo $this->db->last_query(); die;

        return $query->result_array();
    }

    function get_product_by_category_page($categoryId = null, $start = 0, $limit) {
        $this->db->cache_on();
        $this->db->select('ip.id,ip.category_id,ip.category_id,ip.discounted_price,ip.product_sku,ip.product_name,ip.isactive,ip.price,ip.quantity,opr.review_total');
        $this->db->from('tbl_products ip');
//        $this->db->join('tbl_products_image ipm', 'ipm.product_id = ip.id');
        $this->db->join('tbl_product_review opr', 'opr.product_id = ip.id', 'LEFT');

        if (isset($categoryId) && $categoryId != null && $categoryId != 0) {
            $this->db->where('ip.category_id', $categoryId);
        }
        if (isset($subCategoryId) && $subCategoryId != null) {
            $this->db->join('tbl_product_attributes ipa', 'ipa.product_id = ip.id');
            $this->db->where('ipa.attribute_id', $subCategoryId);
        }
//        if ($categoryId = null && $subCategoryId = null)
        $this->db->order_by('ip.id', 'DESC');

        $this->db->where('ip.isactive', 0);

        $this->db->group_by('ip.id');
//        echo $start;die;
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        $this->db->cache_off();
        return $query->result_array();
    }

    public function get_product_by_count($categoryId = null) {
        $this->db->cache_on();
        $this->db->select('count(ip.id)');
        $this->db->from('tbl_products ip');
//        $this->db->join('tbl_products_image ipm', 'ipm.product_id = ip.id');

        if (isset($categoryId) && $categoryId != null && $categoryId != 0) {
            $this->db->where('ip.category_id', $categoryId);
        }
        // if (isset($subCategoryId) && $subCategoryId != null) {
        $this->db->join('tbl_product_attributes ipa', 'ipa.product_id = ip.id');
        //$this->db->where('ipa.attribute_id', $subCategoryId);
        // }
        //if ($categoryId = null && $subCategoryId = null)
        $this->db->order_by('ip.id', 'DESC');

        $this->db->where('ip.isactive', 0);

        $this->db->group_by('ip.id');
//        echo $start;die;
        // $//this->db->limit($limit, $start);
        $query = $this->db->get();
        $this->db->cache_off();
        return $query->num_rows();
    }

    
    /**
     * filter product view
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       string  filter parameters
     * @return      filtered product view
     */

    public function filterProductsByPrice($product_category_id = null, $product_sub_category = null, $start_price = NULL, $end_price = NULL, $search_param = NULL, $attribute_search = NULL, $instock_search = NULL, $brand_search = NULL) {

        // $this->db->select('ip.category_id, ip.product_sku, ip.discounted_price, ip.product_name, ip.isactive, ip.price, ip.quantity, ip.image_url, ip.description, ip.id as product_id');
        // $this->db->from('tbl_products ip');

        // if (isset($product_category_id) && $product_category_id != null && $product_category_id != '0') {
        //     $this->db->where('ip.category_id', $product_category_id);
        // }

        // if (isset($product_sub_category) && $product_sub_category != null) {
        //     $this->db->select('ipa.*');
        //     $this->db->join('tbl_product_attributes ipa', 'ipa.product_id = ip.id');
        //     $this->db->where('ipa.attribute_id', $product_sub_category);
        // }

        // /* filter tearms */
        // if ($start_price != null && $end_price != null) {

        //     // if (isset($filterTearm['price']) && $filterTearm['price'] != '') {
        //     // $price_r = explode(',', $filterTearm['price']);
        //     $this->db->where("ip.discounted_price >= $start_price");
        //     $this->db->where("ip.discounted_price <= $end_price");
        //     $this->db->order_by('ip.price', 'ASC');
        //     // }
        // }

        // $this->db->where('ip.isactive', 0);
        // $this->db->group_by('ip.id');

        // if (isset($start) && $start != NULL)
        //     $this->db->limit($start, $limit);
        // else
        //     $this->db->limit(6);

        // $query = $this->db->get();
        // $result = $query->result_array();

        // // echo $this->db->last_query(); die;

        // if (isset($result)) {
        //     return $result;
        // } else
        //     return null;

        // return $query->result_array();
        // echo "start price : ".$start_price."  end price : ".$end_price; die;

        $this->db->select('ip.category_id, ip.product_sku, pc.name as category_name, ip.discounted_price, ip.product_name, ip.isactive, ip.price, ip.quantity, ip.image_url, ip.description, ip.id as product_id');
        $this->db->from('tbl_products ip');
        $this->db->join('tbl_product_category pc', 'pc.id = ip.category_id', 'LEFT');
        $this->db->join('tbl_subcategories_map tsm', 'tsm.product_id = ip.id', 'LEFT');

        if (isset($product_category_id) && $product_category_id != null && $product_category_id != '0') {
            $this->db->where('tsm.category_id', $product_category_id);
        }

        if (isset($subCategoryId) && $subCategoryId != null && $subCategoryId != '0') {
            $this->db->where('ip.sub_cat_id', $subCategoryId);
        }

        if(isset($instock_search) && $instock_search != null && $instock_search !== '0') {
            $this->db->where('ip.quantity >=', '1');
        }

        if(isset($brand_search) && $brand_search != null && $brand_search !== '') {
            $this->db->where('ip.brand_id', $brand_search);
        }

        if(isset($attribute_search) && $attribute_search != null && $attribute_search != '0') {
            
            $this->db->join('tbl_product_attributes pa', 'pa.product_id = ip.id', 'LEFT');

            $attribute_search_array = explode(',', $attribute_search);
            $attribute_value_array = array();
            $sub_attribute_value_array = array();

            foreach ($attribute_search_array as $key => $value) {
                $search_array_params = explode('_', $value);

                array_push($attribute_value_array, $search_array_params[0]);
                array_push($sub_attribute_value_array, $search_array_params[1]);
            }

            $this->db->where_in('pa.attribute_value', $attribute_value_array);
            $this->db->where_in('pa.sub_attribute_value', $sub_attribute_value_array);
            // $this->db->where('pa.category_id', $product_category_id);
        }

        $this->db->group_by('tsm.product_id');
        $this->db->order_by('ip.id', 'DESC');

        /* filter tearms */
        if ($start_price !== '' && $end_price !== '' && $end_price !== '0') {

            // if (isset($filterTearm['price']) && $filterTearm['price'] != '') {
            // $price_r = explode(',', $filterTearm['price']);
            $this->db->where("ip.discounted_price >= $start_price");
            $this->db->where("ip.discounted_price <= $end_price");
            $this->db->order_by('ip.price', 'ASC');
            // }
        }
        
        $this->db->where('ip.isactive', 0);

        if (isset($start) && $start != NULL)
            $this->db->limit($start, $limit);
        else
            $this->db->limit(10);
        
        
        $query = $this->db->get();
        
        // echo $this->db->last_query(); die;

        return $query->result_array();
    }



    function get_filter_product($product_category_id = null, $product_sub_category = null, $searchTearm = null, $start = null, $limit = null, $filterTearm = null, $bySize = null, $allSizes = null) {
//        if (isset($bySize) && $bySize!=null) {
//            $size = explode('R', $bySize);
//            
//            $bySize = 'R' . $size[1];
//        }
        $flag = 0;
        $this->db->select('ip.id,ip.category_id,ip.category_id,ip.product_sku,ip.discounted_price,ip.product_name,ip.isactive,ip.price,ip.quantity,opr.review_total');
        $this->db->from('tbl_products ip');
//        $this->db->join('tbl_products_image ipm', 'ipm.product_id = ip.id');
        $this->db->join('tbl_product_review opr', 'opr.product_id = ip.id', 'LEFT');
        $this->db->join('tbl_product_attributes ipa', 'ipa.product_id = ip.id', 'LEFT');
        if (isset($product_category_id) && $product_category_id != '' && $searchTearm == null)
            $this->db->where('ip.category_id', $product_category_id);


        if (isset($product_sub_category) && $product_sub_category != '' && $searchTearm == null) {
//            $this->db->join('tbl_product_attributes ipa', 'ipa.product_id = ip.id');
            $this->db->where('ipa.attribute_id', $product_sub_category);
        }
        if (isset($product_sub_category) && $product_sub_category != '' && $searchTearm == 'brand') {
//            $this->db->join('tbl_product_attributes ipa', 'ipa.product_id = ip.id');
            $this->db->where('ipa.sub_attribute_dp_id', $product_sub_category);
        }

        /* filter tearms */
        if ($filterTearm != null) {
            if (isset($filterTearm['price']) && $filterTearm['price'] != '') {

                $price_r = explode(',', $filterTearm['price']);
                $this->db->where("ip.price >= $price_r[0]");
                $this->db->where("ip.price <= $price_r[1]");
                $this->db->order_by('ip.price', 'ASC');
            }
            if (isset($filterTearm['brand']) && $filterTearm['brand'] != '' && isset($bySize)) {
                $brand_id = explode(',', $filterTearm['brand']);
//                $this->db->join('tbl_product_attributes ipa', 'ipa.product_id = ip.id');
//                $this->db->where('ipa.attribute_id', $brand_id);
                $this->db->where_in('ipa.sub_attribute_value', $brand_id);
                $this->db->or_like('ipa.sub_attribute_value', $bySize);
                $flag = 1;
            }
            if (isset($filterTearm['brand']) && $filterTearm['brand'] != '' && $bySize == null) {
                $brand_id = explode(',', $filterTearm['brand']);
//                $this->db->join('tbl_product_attributes ipa', 'ipa.product_id = ip.id');
                $this->db->where_in('ipa.sub_attribute_value', $brand_id);
                $flag = 0;
            }
        } else
        $this->db->order_by('ip.price', 'DESC');

        /* By Size */

        if (isset($allSizes)) {
            $i = 0;
            foreach ($allSizes as $key => $size) {
                if ($i == 0)
                    $this->db->like('ipa.sub_attribute_value', $size);
                else
                    $this->db->or_like('ipa.sub_attribute_value', $size);
                $i++;
            }
        }
        if ($bySize != null && $flag == 0) {
//            $this->db->join('tbl_product_attributes ipa', 'ipa.product_id = ip.id');
            $this->db->like('ipa.sub_attribute_value', $bySize);
        }
        /* By Size */

        $this->db->where('ip.isactive', 0);
        $this->db->group_by('ip.id');

        if (isset($start) && $start != NULL)
            $this->db->limit($start, $limit);
        else
            $this->db->limit(6);
        $query = $this->db->get();
        $result = $query->result_array();
//        echo $this->db->last_query();
        if (isset($result)) {
            return $result;
        } else
        return null;

        return $query->result_array();
    }

    function get_filter_product_count($product_category_id = null, $product_sub_category = null, $searchTearm = null, $bySize = null, $byName = null, $filterTearm = null, $allSizes = null) {
        $this->db->cache_on();
        $flag = 0;
        $this->db->select('count(ip.id)');
        $this->db->from('tbl_products ip');
//        $this->db->join('tbl_products_image ipm', 'ipm.product_id = ip.id', 'LEFT');
        $this->db->join('tbl_product_attributes ipa', 'ipa.product_id = ip.id', 'LEFT');


        if (isset($product_category_id) && $product_category_id != '' && $searchTearm == null)
            $this->db->where('ip.category_id', $product_category_id);

        /* By Name */
        if ($byName != null) {
            $this->db->like('ip.product_name', $byName);
        }
        /* By Name */


        if (isset($product_sub_category) && $product_sub_category != '' && $searchTearm == null) {
//            $this->db->join('tbl_product_attributes ipa', 'ipa.product_id = ip.id', 'LEFT');
            $this->db->where('ipa.attribute_id', $product_sub_category);
        }
        if (isset($product_sub_category) && $product_sub_category != '' && $searchTearm == 'brand') {
//            $this->db->join('tbl_product_attributes ipa', 'ipa.product_id = ip.id', 'LEFT');
            $this->db->where('ipa.sub_attribute_dp_id', $product_sub_category);
        }
        /* filter tearms */

        if ($filterTearm != null) {

            if (isset($filterTearm['price']) && $filterTearm['price'] != '') {

                $price_r = explode(',', $filterTearm['price']);
                $this->db->where("ip.price >= $price_r[0]");
                $this->db->where("ip.price <= $price_r[1]");
//                $this->db->order_by('ip.price', 'ASC');
            }
            if (isset($filterTearm['brand']) && $filterTearm['brand'] != '' && isset($bySize)) {
                $brand_id = explode(',', $filterTearm['brand']);
//                $this->db->join('tbl_product_attributes ipa', 'ipa.product_id = ip.id');
                $this->db->where_in('ipa.sub_attribute_value', $brand_id);
                $this->db->or_like('ipa.sub_attribute_value', $bySize);
                $flag = 1;
            } elseif (isset($filterTearm['brand']) && $filterTearm['brand'] != '') {
                $brand_id = explode(',', $filterTearm['brand']);
//                $this->db->join('tbl_product_attributes ipa', 'ipa.product_id = ip.id');
                $this->db->where_in('ipa.sub_attribute_value', $brand_id);
                $flag = 0;
            }
        }

        /* By Size */

        if (isset($allSizes)) {
            $i = 0;
            foreach ($allSizes as $key => $size) {
                if ($i == 0)
                    $this->db->like('ipa.sub_attribute_value', $size);
                else
                    $this->db->or_like('ipa.sub_attribute_value', $size);
                $i++;
            }
        }

        if ($bySize != null && $flag == 0) {
//            $this->db->join('tbl_product_attributes ipa', 'ipa.product_id = ip.id');
            $this->db->like('ipa.sub_attribute_value', $bySize);
        }
        /* By Size */

        $this->db->order_by('ip.id', 'DESC');

        /* filter tearms */


        $this->db->where('ip.isactive', 0);
        $this->db->group_by('ip.id');
        if (isset($start) && $start != NULL)
            $this->db->limit($start, $limit);
//        else
//            $this->db->limit(6);

        $query = $this->db->get();
//        echo '<pre>',print_r($query->num_rows());
//       echo $this->db->last_query();
        $this->db->cache_off();
        return $query->num_rows();
    }

    function get_product_by_product_id($profuctId) {

        $this->db->select('ip.id as product_id, ip.category_id, ip.product_sku, ip.isactive, ip.discounted_price, ip.product_name, ip.price, ip.quantity, opr.review_total, ip.image_url, ip.description');
        $this->db->from('tbl_products ip');
//        $this->db->join('tbl_products_image ipm', 'ipm.product_id = ip.id', 'LEFT');
        $this->db->join('tbl_product_review opr', 'opr.product_id = ip.id', 'LEFT');
        $this->db->where('ip.id', $profuctId);
        $this->db->group_by('ip.id');
        $query = $this->db->get();
//        echo $this->db->last_query();die;
        return $query->result_array();
    }

    // get the details of auction product by product id
    function get_auction_product_by_product_id($auctionId) {
        try {
            $this->db->select('ip.id,ip.category_id,ip.category_id,ip.product_sku,ip.product_name,ip.isactive,ip.price,ip.discounted_price,ip.quantity,pst.sub_name as brand_name,ip.image_url,ta.*,ip.id as id');
            $this->db->from('tbl_products ip');
            $this->db->join('tbl_product_attributes ipa', 'ipa.product_id = ip.id');
            $this->db->join('tbl_p_sub_attributes pst', 'pst.id = ipa.sub_attribute_dp_id');
            $this->db->join('tbl_auction ta', 'ta.product_id = ip.id');
            // $this->db->join('tbl_bid bd', 'bd.auction_id = ta.id');
            $this->db->where(array('ip.product_type' => 2, 'ta.id' => $auctionId));
            // $this->db->where('ip.id', $profuctId);
            $this->db->order_by('ip.id', 'DESC');
            $this->db->group_by('ip.id');
            $query = $this->db->get();
            $this->db->cache_off();
            // return result as array
            return $query->result_array();
        } catch (Exception $e) {
            echo $e;
        }
    }

    // get the details of auction product by product id
    function get_bids_by_auction_id($auctionId) {
        try {
            $this->db->order_by('id', 'DESC');
            $query = $this->db->get_where('tbl_bid', array('auction_id' => $auctionId));
            $this->db->cache_off();
            // return result as array
            return $query->result_array();
        } catch (Exception $e) {
            echo $e;
        }
    }


    // get the details of auction mainfest
    function get_auction_manifest($auctionId) {
        try {

            // select query to fetch the auction manifest record
            $query = $this->db->get_where('tbl_auction_manifest', array('auction_id' => $auctionId));
            $this->db->cache_off();
            // return result as array
            return $query->result_array();
        } catch (Exception $e) {
            echo $e;
        }
    }

    function get_offer_product($categoryId) {

        $this->db->select('ip.id,ip.category_id,ip.category_id,ip.product_sku,ip.isactive,ip.product_name,ip.price,ip.discounted_price,ip.quantity,opr.review_total,pst.sub_name as brand_name');
        $this->db->from('tbl_products ip');
//        $this->db->join('tbl_products_image ipm', 'ipm.product_id = ip.id'.'LEFT');
        $this->db->join('tbl_product_review opr', 'opr.product_id = ip.id', 'LEFT');
        $this->db->join('tbl_p_sub_attributes pst', 'pst.id = ipa.sub_attribute_dp_id');
        $this->db->where('ip.is_offer_publish', 1);
        $this->db->where('ip.category_id', $categoryId);
        $this->db->group_by('ip.id');
        $this->db->limit(3);
        $query = $this->db->get();
        $offerData = $query->result_array();
        if (!empty($offerData))
            return $offerData;
        else
            return null;
//        echo $this->db->last_query();die;
        return $query->result_array();
    }

    function get_all_offer_product() {

        $this->db->select('ip.id,ip.category_id,ip.category_id,ip.product_sku,ip.isactive,ip.discounted_price,ip.product_name,ip.price,ip.quantity,opr.review_total');
        $this->db->from('tbl_products ip');
//        $this->db->join('tbl_products_image ipm', 'ipm.product_id = ip.id');
        $this->db->join('tbl_product_review opr', 'opr.product_id = ip.id', 'LEFT');
        $this->db->where('ip.is_offer_publish', 1);
//        $this->db->where('ip.category_id', $categoryId);
        $this->db->group_by('ip.category_id');
        $this->db->order_by('ip.category_id', 'DESC');
        $this->db->limit(3);
        $query = $this->db->get();
        $offerData = $query->result_array();
//        echo $this->db->last_query();die;
        if (!empty($offerData))
            return $offerData;
        else
            return null;
//        echo $this->db->last_query();die;
        return $query->result_array();
    }

    function getStockDetail($productId, $is_rent = NULL) {

        if($is_rent == 1) {
            $result = $this->db->get_where('tbl_rent_products', array('id' => $productId))->row();
        } else {
            $result = $this->db->get_where('tbl_products', array('id' => $productId))->row();
        }
        
        if (isset($result->quantity))
            return $result->quantity;
    }

    public function get_product_by_cat_id($id) {
        $q = $this->db->where('category_id', $id)->get('tbl_products');
        return $q->result_array();
    }

    public function delete_product($id) {
        $this->db->where('id', $id)->delete('tbl_products');
        $this->db->where('product_id', $id)->delete('tbl_highlighted_products');
        $this->db->where('product_id', $id)->delete('tbl_dow_products');
        return true;
    }

    public function get_all_inactive_product() {
        $q = $this->db->where('isactive', 1)->get('tbl_products');
        return $q->result_array();
    }

    public function update_sale_count($productId, $data) {

        $this->db->where('id', $productId);
        $this->db->set('product_sale_count', 'product_sale_count + '.$data['product_sale_count'], FALSE);
        $this->db->set('quantity', 'quantity -'.$data['product_quantity'], FALSE);
        $this->db->update('tbl_products');
        return true;
    }

    // public function getProductById($product_id) {

    //     $this->db->select('*');
    //     $this->db->from('tbl_products ip');
    //     $this->db->where('ip.id', $profuctId);
    //     $this->db->group_by('ip.id');
    //     $query = $this->db->get();
    //     $res = $query->result_array();
    //     return $res[0];
    // }


    // Added by ranjit P on 19 Dec 3017 Start
    function get_highlighted_products($start = null, $limit = null, $keywords = null) {

        $this->db->cache_on();

        $this->db->select('ip.id as product_id, ip.category_id, ip.product_sku, ip.product_name, ip.isactive, ip.price, ip.discounted_price, ip.quantity, ip.image_url, hip.id, hip.sale_type, hip.product_title, hip.img_url, hip.price as highlighted_price');
        $this->db->from('tbl_highlighted_products hip');
        $this->db->join('tbl_products ip', 'hip.product_id = ip.id','LEFT');

        if (isset($keywords) && $keywords != null) {
            if ($keywords['sortBy'] == 'product_sku') {
                $this->db->where('ip.product_sku', $keywords['value']);
                $this->db->order_by('ip.product_sku', 'DESC');
            }
            if ($keywords['sortBy'] == 'product_name') {
                $this->db->like('ip.product_name', $keywords['value']);
                $this->db->order_by('ip.product_name', 'ASC');
            }
            if ($keywords['sortBy'] == 'size') {
                $this->db->like('ipa.sub_attribute_value', $keywords['value']);
                $this->db->order_by('ipa.sub_attribute_value', 'ASC');
            }
            if ($keywords['sortBy'] == 'price') {
                $price = $keywords['value'];
                $price = (int) $price;
                $this->db->where('ip.price >=', $keywords['value']);
                $this->db->where('ip.price <=', 2000);
                $this->db->order_by('ip.price', 'ASC');
            }
        } else
        $this->db->order_by('hip.id', 'DESC');

        $this->db->group_by('hip.id');

        $query = $this->db->get();

        $this->db->cache_off();
        return $query->result_array();
    }

    function get_dow_products($start = null, $limit = null, $keywords = null) {

        $this->db->cache_on();

        $this->db->select('ip.id as product_id, ip.category_id, ip.product_sku, ip.product_name, ip.isactive, ip.price, ip.discounted_price, ip.quantity, ip.image_url, dow.id, dow.start_date_time, dow.end_date_time');

        $this->db->from('tbl_dow_products dow');
        $this->db->join('tbl_products ip', 'dow.product_id = ip.id','LEFT');

        if (isset($keywords) && $keywords != null) {
            if ($keywords['sortBy'] == 'product_sku') {
                $this->db->where('ip.product_sku', $keywords['value']);
                $this->db->order_by('ip.product_sku', 'DESC');
            }
            if ($keywords['sortBy'] == 'product_name') {
                $this->db->like('ip.product_name', $keywords['value']);
                $this->db->order_by('ip.product_name', 'ASC');
            }
            if ($keywords['sortBy'] == 'size') {
                $this->db->like('ipa.sub_attribute_value', $keywords['value']);
                $this->db->order_by('ipa.sub_attribute_value', 'ASC');
            }
            if ($keywords['sortBy'] == 'price') {
                $price = $keywords['value'];
                $price = (int) $price;
                $this->db->where('ip.price >=', $keywords['value']);
                $this->db->where('ip.price <=', 2000);
                $this->db->order_by('ip.price', 'ASC');
            }
        } else
        $this->db->order_by('dow.id', 'DESC');

        $this->db->group_by('dow.id');

        $query = $this->db->get();

        $this->db->cache_off();
        return $query->result_array();
    }

    function get_highlighted_product_details($highlighted_product_id = null) {

        $this->db->cache_on();

        $this->db->select('ip.id as product_id, ip.category_id, ip.product_sku, ip.product_name, ip.isactive, ip.price, ip.discounted_price, ip.quantity, ip.image_url, hip.id, hip.sale_type, hip.product_title, hip.img_url');
        $this->db->where('hip.id',$highlighted_product_id);
        $this->db->from('tbl_highlighted_products hip');
        $this->db->join('tbl_products ip', 'hip.product_id = ip.id','LEFT');

        $query = $this->db->get();

        $this->db->cache_off();
        return $query->result_array();
    }

    function get_dow_product_details($dow_product_id = null) {

        $this->db->cache_on();

        $this->db->select('ip.id as product_id, ip.category_id, ip.product_sku, ip.product_name, ip.isactive, ip.price, ip.discounted_price, ip.quantity, ip.image_url, dow.id, dow.start_date_time, dow.end_date_time');
        $this->db->where('dow.id',$dow_product_id);
        $this->db->from('tbl_dow_products dow');
        $this->db->join('tbl_products ip', 'dow.product_id = ip.id','LEFT');

        $query = $this->db->get();

        $this->db->cache_off();
        return $query->result_array();
    }

    function update_highlighted_product_details($product_id = null,$highlighted_product_id = null,$dataUpdate = null) {

        $this->db->select('img_url');
        $this->db->where('id',$highlighted_product_id);
        $query=$this->db->get('tbl_highlighted_products');

        $result=$query->row();

        if(!empty($result->img_url)){
            if($result->img_url!='banner-img4.jpg'){
               // unlink('frontend/assets/images/products/highlighted_products/'.$result->img_url); 
           }
       }

       $this->db->where('id',$highlighted_product_id);
       $this->db->set($dataUpdate);
       $query=$this->db->update('tbl_highlighted_products');


       $this->db->where('id',$product_id);
       $this->db->set('discounted_price',$this->input->post('product_price'));
       $query=$this->db->update('tbl_products');
        // echo $this->db->last_query();die;
       return true;
   }


   function update_dow_product_details($dow_product_id = null,$dataUpdate = null) {

       $this->db->where('id',$dow_product_id);
       $this->db->set($dataUpdate);
       $query = $this->db->update('tbl_dow_products');
       // echo $this->db->last_query();die;
       return true;
   }


   function mark_as_highlighted_product($highlighted_product_id = null,$insertData = null) {

    $this->db->where('id',$highlighted_product_id);
    $this->db->set('highlighted','1');
    $query_up=$this->db->update('tbl_products');

    $query_ins=$this->db->insert('tbl_highlighted_products',$insertData);

    return true;
}

function remove_highlighted_product($highlighted_product_id = null) {

    $this->db->where('id',$highlighted_product_id);
    $this->db->set('highlighted','0');
    $query_up=$this->db->update('tbl_products');

    // echo $this->db->last_query();die;
    $this->db->where('product_id',$highlighted_product_id);
    $query_ins=$this->db->delete('tbl_highlighted_products');
    return true;
}


function remove_dow_product($dow_product_id = null) {

    $this->db->where('id',$dow_product_id);
    $this->db->set('deals_of_the_week','0');
    $query_up=$this->db->update('tbl_products');

    $this->db->where('product_id',$dow_product_id);
    $query_ins=$this->db->delete('tbl_dow_products');
    // echo $this->db->last_query();die;
    return true;
}

//on checkbox on off
function mark_as_dow_product($dow_product_id = null,$add_remove_flag,$insertData) {

    $this->db->where('id',$dow_product_id);
    $this->db->set('deals_of_the_week',$add_remove_flag);
    $query_up=$this->db->update('tbl_products');

    if($add_remove_flag==1){
        $query_ins=$this->db->insert('tbl_dow_products',$insertData);
    }

    return true;
}


function mark_as_os_product($os_product_id = null,$add_remove_flag) {

    $this->db->where('id',$os_product_id);
    $this->db->set('on_sale',$add_remove_flag);
    $query_up=$this->db->update('tbl_products');
        // echo $this->db->last_query();die;
    return true;
}

    /*public function delete_highlighted_product($id) {
        $this->db->where('id', $id)->delete('tbl_highlighted_products');
        return true;
    }*/

    // Added by ranjit P on 19 Dec 3017 End



}

/* End of file Product.php */
/* Location: ./models/backend/Product.php */

