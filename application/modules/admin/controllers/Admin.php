<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->language(array('product_lang'));
        $this->load->library('Ajax_pagination_product');
        $this->perPage = 10;

        /* Load Backend model */
        $this->load->model(array('users', 'group_model', 'pattribute', 'pattribute_sub', 'product_sub_category_map', 'Blog_model', 'blog_comment', 'blog_tags', 'rent_product_cat_subcat_map'));
        $this->load->model(array('product_category', 'product_sub_category', 'orders_summary', 'common_model', 'newsletter', 'footer_cms', 'section_model', 'social_links', 'brands', 'coupon', 'coupon_category', 'coupon_method', 'coupon_method_tax', 'coupon_group', 'tax', 'rent_product_cat_subcat_map'));

        /* Load Master model */
        $this->flexi = new stdClass;

        $this->load->library('flexi_cart');

        /* Load Product model */
        $this->load->model(array('product_attribute', 'product', 'rent_product', 'rent_product_category', 'rent_product_subcategory'));

        $this->load->model(array('users'));

        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
    }

    /**
     * Entry Point
     *
     * @param       null
     * @return      dashboard view
     */
    public function index() {

       if (!$this->ion_auth->logged_in()) {
           // redirect them to the login page
           redirect('auth/login', 'refresh');
       }
       if (!$this->ion_auth->is_admin()) {
           redirect('/home', 'refresh');
       }

       // set the parameters for rendering view
       $this->data = null;

       // total number of orders
       $this->data['total_orders'] = $this->orders_summary->count_all();

       // total number of customers
       $this->data['total_customers'] = $this->users->count_all();

       $this->data['order_amount_total'] = $this->orders_summary->getTotalOrderAmount();

       $this->data['order_status_count'] = $this->orders_summary->getOrderStatus();
       
       $this->data['rent_order_count'] = $this->orders_summary->getRentOrderCount();

       $this->data['orders_this_day'] = $this->orders_summary->getOrdersThisDay();

       $this->data['orders_this_month'] = $this->orders_summary->getOrdersThisMonth();

       $this->data['orders_this_year'] = $this->orders_summary->getOrdersThisYear();

       $pageTitle = 'Buy Sell Rent';
       $renderTo = 'dashboard';

        // call the render view function here
       $this->_renders_view($pageTitle, $renderTo, $this->data);
   }

    /**
     * product list page
     * @author : Harshal B <harshalb@rebelute.com>
     * @param       null
     * @return      product list view
     */
    public function products() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['product_details_count'] = $this->product->count_by(array('id'));

        $this->data['product_details'] = $this->product->get_products();        

        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);


        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Product List';
        $renderTo = 'product_list';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * Add product page
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       null
     * @return      add product view
     */
    public function add_products() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        // set the parameters for rendering view
        $this->data = null;
        $pageTitle = 'Buy Sell Rent | Add Product';
        $renderTo = 'add_products';

        $this->data['product_name'] = array(
            'class' => 'form-control',
            'id' => 'product_name',
            'name' => 'product_name',
            'type' => 'text',
            'placeholder' => 'Product name'
        );

        $this->data['product_shortdescription'] = array(
            'class' => 'form-control',
            'id' => 'short_description',
            'name' => 'short_description',
            'type' => 'text',
            'placeholder' => 'Short description'
        );

        $this->data['product_description'] = array(
            'class' => 'form-control',
            'id' => 'description',
            'name' => 'description',
            'type' => 'text',
            'placeholder' => 'Description'
        );

        $this->data['product_category'] = array(
            'class' => 'form-control',
            'id' => 'product_category',
            'name' => 'product_category',
            'type' => 'text',
            'placeholder' => 'Product Category'
        );

        $this->data['product_quantity'] = array(
            'class' => 'form-control',
            'id' => 'product_quantity',
            'name' => 'product_quantity',
            'type' => 'text',
            'placeholder' => 'Product Quantity'
        );

        $this->data['product_price'] = array(
            'class' => 'form-control',
            'id' => 'product_price',
            'name' => 'product_price',
            'type' => 'text',
            'placeholder' => 'Product price'
        );

        $this->data['product_discounted_price'] = array(
            'class' => 'form-control',
            'id' => 'product_discounted_price',
            'name' => 'product_discounted_price',
            'type' => 'text',
            'placeholder' => 'Discounted Product price'
        );

        $this->data['product_sku'] = array(
            'class' => 'form-control',
            'id' => 'product_sku',
            'name' => 'product_sku',
            'type' => 'text',
            'placeholder' => 'Product SKU',
            'onkeyup' => 'checkSKU()'
        );

        $this->data['product_video'] = array(
            'class' => 'form-control',
            'id' => 'product_video',
            'name' => 'product_video',
            'type' => 'text',
            'placeholder' => 'Ex. Id : xxxxxxxxxxx'
        );

        $this->data['base_price'] = array(
            'class' => 'form-control',
            'id' => 'base_price',
            'name' => 'base_price',
            'type' => 'text',
            'placeholder' => 'Base price'
        );

        $this->data['manufacturer_id'] = array(
            'class' => 'form-control',
            'id' => 'manufacturer_id',
            'name' => 'manufacturer_id',
            'type' => 'text',
            'placeholder' => 'Manufacturer id'
        );


        $this->data['width'] = array(
            'class' => 'form-control',
            'id' => 'width',
            'name' => 'width',
            'type' => 'text',
            'placeholder' => 'Width'
        );

        $this->data['height'] = array(
            'class' => 'form-control',
            'id' => 'height',
            'name' => 'height',
            'type' => 'text',
            'placeholder' => 'Height'
        );

        $this->data['weight'] = array(
            'class' => 'form-control',
            'id' => 'weight',
            'name' => 'weight',
            'type' => 'text',
            'placeholder' => 'Weight'
        );

        $this->data['dimension'] = array(
            'class' => 'form-control',
            'id' => 'dimension',
            'name' => 'dimension',
            'type' => 'text',
            'placeholder' => 'Dimension'
        );

        // get all the product selected category
        $this->data['product_category'] = array('0' => 'Select Category') + $this->product_category->dropdown('name');

        // get all the product categories
        $this->data['product_categories'] = $this->product_category->as_array()->get_all();

        // get all the product brands
        $this->data['product_brands'] = array('' => 'Select brand') + $this->brands->dropdown('brand_name');

        $this->data['attribute_details'] = $this->pattribute->as_array()->get_all();
        $this->data['attt_category'] = array('' => 'Select Parent') + $this->pattribute->dropdown('attrubute_value');

        foreach ($this->data['attribute_details'] as $key => $dataAtt) {
            $this->data['attribute_details'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['id']);
        }

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * Edit product page
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       null
     * @return      edit product view
     */
    public function editBuyProducts($product_id = NULL) {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $this->data = null;
        $this->data['product_details'] = $this->product->getProductById($product_id);        
        
        $this->data['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($product_id);

        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Edit Product';
        $renderTo = 'edit_products';

        $this->data['product_category_levels'] = $this->product_sub_category_map->get_all_product_categories($this->data['product_details'][0]['product_id']);

        for ($i = 0; $i < sizeof($this->data['product_category_levels']); $i++) {
            // $this->data['product_category_'.$i] = array('0' => $this->data['product_category_levels'][$i], 'selected' => 'selected') + $this->product_category->dropdown('name');
            $this->data['product_category_'.$i] = array($this->data['product_category_levels'][$i]['category_id'] => $this->data['product_category_levels'][$i]['name']) + $this->product_category->dropdown('name');
        }

        // $this->data['product_sub_category'] = array('0' => 'Select Category') + $this->product_category->dropdown('name');

        // echo $this->data['product_details'][0]['category_id'];
        // echo $this->data['product_details'][0]['product_id']; die;
        
        // $this->data['product_category_sub'] = $this->product_sub_category_map->get_subcagetories_by_product_cat_id($this->data['product_details'][0]['category_id'], $this->data['product_details'][0]['product_id']);

        // $qry = $this->db->get_where('tbl_subcategories_map', array('category_id' => $this->data['product_details'][0]['category_id'], 'product_id' => $this->data['product_details'][0]['product_id']));

        // $result = $qry->result_array();
        
        // $this->data['product_category'] = $this->product_sub_category_map->get_by(array('category_id' => $this->data['product_details'][0]['category_id'], 'product_id' => $this->data['product_details'][0]['product_id']));

        // echo $this->db->last_query();
        // die();
        
        // $this->data['product_category'] = $this->product_category->dropdown('name');

        // $this->data['product_categories'] = $this->product_category->as_array()->get_all();
        
        // get all the product brands
        $this->data['product_brands'] = array($this->data['product_details'][0]['brand_id'] => $this->data['product_details'][0]['brand']) + $this->brands->dropdown('brand_name');

        // get the attributes
        $this->data['attribute_details'] = $this->pattribute->as_array()->get_all();

        // get all the categories
        $this->data['attt_category'] = array('' => 'Select Parent') + $this->pattribute->dropdown('attrubute_value');

        foreach ($this->data['attribute_details'] as $key => $dataAtt) {
            $this->data['attribute_details'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['id']);
        }

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * update product from ajax call
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       null
     * @return      update product
     */
    public function ajaxUpdateProduct() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        // get the user id if user is logged in
        if ($this->session->userdata('user_id'))
            $user_id = $this->session->userdata('user_id');
        
        $category_array = array();

        if(!empty($this->input->post('product_category'))) {
            array_push($category_array, $this->input->post('product_category'));
        }

        if(!empty($this->input->post('id_select_sub_part2'))) {
            array_push($category_array, $this->input->post('id_select_sub_part2'));
        }

        if(!empty($this->input->post('id_select_sub_part3'))) {
            array_push($category_array, $this->input->post('id_select_sub_part3'));
        }

        if(!empty($this->input->post('id_select_sub_part4'))) {
            array_push($category_array, $this->input->post('id_select_sub_part4'));
        }

        if(!empty($this->input->post('id_select_sub_part5'))) {
            array_push($category_array, $this->input->post('id_select_sub_part5'));
        }

        $product_id = trim($this->input->post('product_id'));

        // set the posted values array
        $product_data_array = array(
            'category_id' => (!empty($this->input->post('product_category')) ? $this->input->post('product_category') :'0'),
            'brand_id' => $this->input->post('product_brands'),
            'sub_cat_id' => (!empty($this->input->post('id_select_sub_part2')) ? $this->input->post('id_select_sub_part2') :'0'),
            'product_name' => trim($this->input->post('product_name')),
            'product_is_feature' => ($this->input->post('is_feature') == 'on' ? '1': '0'),
            'discounted_price' => trim($this->input->post('product_discounted_price')),
            'category_id' => trim($this->input->post('product_category')),
            'quantity' => trim($this->input->post('product_quantity')),
            'price' => trim($this->input->post('product_price')),
            'product_sku' => trim($this->input->post('product_sku')),
            'short_description' => trim($this->input->post('short_description')),
            'additional_information' => trim($this->input->post('inputPostDescription')),
            'product_video' => (!empty($this->input->post('product_video')) ? trim($this->input->post('product_video')) : ''),
            'description' => trim($this->input->post('description')),
            'createdby' => $user_id,
            'createddate' => date('Y-m-d H:m:s'),
        );        
        
        $decode_img_url = array();

        // get the file parameters
        $this->db->select(array('id', 'image_url'));
        $get_images = $this->db->get_where('tbl_products', array('id' => $product_id));
        $result = $get_images->result_array();

        $decode_img_url = json_decode($result[0]['image_url']);        

        /* file upload */
        if (isset($_FILES['product_images']) && !empty($_FILES['product_images'])) {

            $totalImageUploadCnt = count($_FILES['product_images']['name']);

            $targetDir = "/frontend/assets/images/products/";
            for ($i = 0; $i < $totalImageUploadCnt; $i++) {
                $fileName = $_FILES['product_images']['name'][$i];
                $targetFile = $targetDir . $fileName;
                $productSlug = $this->input->post('product_category');
                if(!empty($_FILES['product_images']['name'][$i])) {
                    $uploded_file_path = $this->handleUpload($productSlug, $_FILES['product_images']['name'][$i], $_FILES['product_images']['tmp_name'][$i]);

                    if ($uploded_file_path != '') {
                        $imageData[$i] = $this->input->post('product_category') . '/' . ($fileName);
                    }

                    if(!empty($imageData[$i])) 
                        $decode_img_url[$i] = $imageData[$i];
                }
            }

            $product_data_array['image_url'] = json_encode($decode_img_url);
        }


        // $updateAttributeArray = array();
        // $updateAttributeArray = array();
        // $data = array();
        // $i = 0;

        // $updateAttributeArray['product_id'] = $product_id;
        // $updateAttributeArray['attribute_id'] = $this->input->post('product_attribute');

        // $subattradata = $this->db->get_where('tbl_p_attributes', array('id' => $this->input->post('product_attribute')));
        // $subattradata_result = $subattradata->result_array();        

        // $updateAttributeArray['attribute_value'] = $subattradata_result[0]['attrubute_value'];

        // if(!empty($this->input->post('sub_attribute_id'))) {
        //     for ($i = 0; $i < sizeof($this->input->post('sub_attribute_id')) ; $i++) {
        //         // $updateAttributeArray['sub_attribute_id'] = $this->input->post('sub_attribute_id')[$i];
        //         // $updateAttributeArray['sub_attribute_value'] = $this->input->post('tags')[$i];
        //         $this->db->set('sub_attribute_value', $this->input->post('tags')[$i]);
        //         $this->db->where('id',$this->input->post('sub_attribute_id')[$i]);
        //         $this->db->update('tbl_product_attributes');
        //         // $this->product_attribute->update($updateAttributeArray);                
        //     }
        // }

        // delete the old attributes and insert new attributes
        $this->db->where('product_id', $product_id);
        $this->db->delete('tbl_product_attributes');

        // remove the category map
        $this->db->where('product_id', $product_id);
        $this->db->delete('tbl_subcategories_map');

        foreach ($category_array as $value) {
            $data_subcat_array = array(
                'product_id' => $product_id,
                'category_id' => $value,
            );

            $this->product_sub_category_map->insert($data_subcat_array);
        }


        $updateAttributeArray = array();
        $updateAttributeArray = array();
        $data = array();
        $i = 0;

        $updateAttributeArray['product_id'] = $product_id;
        $updateAttributeArray['category_id'] = end($category_array);

        $updateAttributeArray['attribute_id'] = $this->input->post('product_attribute');
        
        if(!empty($this->input->post('sub_attribute_id'))) {
            $subattradata = $this->db->get_where('tbl_p_sub_attributes', array('attribute_id' => $this->input->post('product_attribute')));
            $subattradata_result = $subattradata->result_array();

            for ($i = 0; $i < sizeof($this->input->post('sub_attribute_id')) ; $i++) {
                $updateAttributeArray['attribute_value'] = $subattradata_result[$i]['sub_name'];
                $updateAttributeArray['sub_attribute_id'] = $this->input->post('sub_attribute_id')[$i];
                $updateAttributeArray['sub_attribute_value'] = $this->input->post('tags')[$i];

                $this->product_attribute->insert($updateAttributeArray);
            }
        }

        /* End of file upload */
        if($this->product->update($product_id, $product_data_array)) {
            // set the session message
            $this->session->set_flashdata('message', 'Product updated successfully');
            redirect('admin/products');
        } else {
            // set the session message
            $this->session->set_flashdata('error', 'Failed to update the Product');
            redirect('admin/products');
        }
    }

    /**
     * Add product from ajax call
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       null
     * @return      add product
     */
    public function ajaxAddProduct() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        // get the user id if user is logged in
        if ($this->session->userdata('user_id'))
            $user_id = $this->session->userdata('user_id');
        
        $category_array = array();

        if(!empty($this->input->post('product_category'))) {
            array_push($category_array, $this->input->post('product_category'));
        }

        if(!empty($this->input->post('id_select_sub_part2'))) {
            array_push($category_array, $this->input->post('id_select_sub_part2'));
        }

        if(!empty($this->input->post('id_select_sub_part3'))) {
            array_push($category_array, $this->input->post('id_select_sub_part3'));
        }

        if(!empty($this->input->post('id_select_sub_part4'))) {
            array_push($category_array, $this->input->post('id_select_sub_part4'));
        }

        if(!empty($this->input->post('id_select_sub_part5'))) {
            array_push($category_array, $this->input->post('id_select_sub_part5'));
        }        

        // set the posted values array
        $product_data_array = array(
            'category_id' => (!empty($this->input->post('product_category')) ? $this->input->post('product_category') :'0'),
            'brand_id' => $this->input->post('product_brands'),
            'sub_cat_id' => (!empty($this->input->post('id_select_sub_part2')) ? $this->input->post('id_select_sub_part2') :'0'),
            'product_name' => trim($this->input->post('product_name')),
            'product_is_feature' => ($this->input->post('is_feature') == 'on' ? '1': '0'),
            'discounted_price' => trim($this->input->post('product_discounted_price')),
            'quantity' => trim($this->input->post('product_quantity')),
            'price' => trim($this->input->post('product_price')),
            'product_sku' => trim($this->input->post('product_sku')),
            
            'base_price' => trim($this->input->post('base_price')),
            'width' => trim($this->input->post('width')),
            'height' => trim($this->input->post('height')),
            'weight' => trim($this->input->post('weight')),
            'dimension' => trim($this->input->post('dimension')),
            'manufacturer_id' => trim($this->input->post('manufacturer_id')),

            'short_description' => trim($this->input->post('short_description')),
            'description' => trim($this->input->post('description')),
            'additional_information' => trim($this->input->post('inputPostDescription')),
            'product_video' => (!empty($this->input->post('product_video')) ? trim($this->input->post('product_video')) : ''),
            'createdby' => $user_id,
            'createddate' => date('Y-m-d H:m:s'),
        );
        
        
        /* file upload */
        if (!empty($_FILES['product_images']['name'][0]) || !empty($_FILES['product_images']['name'][1]) || !empty($_FILES['product_images']['name'][2]) || !empty($_FILES['product_images']['name'][3])) {

            $totalImageUploadCnt = count($_FILES['product_images']['name']);

            $targetDir = "/frontend/assets/images/products/";
            for ($i = 0; $i < $totalImageUploadCnt; $i++) {
                $fileName = $_FILES['product_images']['name'][$i];
                $targetFile = $targetDir . $fileName;
                $productSlug = $this->input->post('product_category');
                $uploded_file_path = $this->handleUpload($productSlug, $_FILES['product_images']['name'][$i], $_FILES['product_images']['tmp_name'][$i]);
                if ($uploded_file_path != '') {
                    $imageData[$i] = $this->input->post('product_category') . '/' . ($fileName);
                }
            }

            $product_data_array['image_url'] = json_encode($imageData);
        }
        
        $product_id = $this->product->insert($product_data_array);

        foreach ($category_array as $value) {

            $data_subcat_array = array(
                'product_id' => $product_id,
                'category_id' => $value,
            );

            $this->product_sub_category_map->insert($data_subcat_array);
        }


        $updateAttributeArray = array();
        $data = array();
        $i = 0;

        $updateAttributeArray['product_id'] = $product_id;
        $updateAttributeArray['category_id'] = end($category_array);

        $updateAttributeArray['attribute_id'] = $this->input->post('product_attribute');
        
        if(!empty($this->input->post('sub_attribute_id'))) {
            $subattradata = $this->db->get_where('tbl_p_sub_attributes', array('attribute_id' => $this->input->post('product_attribute')));
            $subattradata_result = $subattradata->result_array();

            // foreach ($subattradata as $subData) {
            for ($i = 0; $i < sizeof($this->input->post('sub_attribute_id')) ; $i++) {

                $updateAttributeArray['attribute_value'] = $subattradata_result[$i]['sub_name'];
                // if (isset($this->input->post('product_attribute'))) {
                $updateAttributeArray['sub_attribute_id'] = $this->input->post('sub_attribute_id')[$i];
                $updateAttributeArray['sub_attribute_value'] = $this->input->post('tags')[$i];

                $this->product_attribute->insert($updateAttributeArray);
                    // echo $this->db->last_query(); die;
                // }
            }
        }

        /* Prodcut Attributes & Sub Attributes */
        $product_category_id = $this->input->post('product_category');            
        $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);
        foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
            $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
        }
        
        if (isset($this->data['prodcut_cat_detail'])) {

            foreach ($this->data['prodcut_cat_detail'] as $key => $attr_data) {

                //upload png plugin image
                if ($attr_data['attribute_type'] == '2') {
                    if (isset($_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['name']) && !empty($_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['name'])) {
                        $targetDir = "backend/uploads/";

                        $fileName = $_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['name'];
                        $targetFile = $targetDir . $fileName;

                        $uploded_file_path = $this->handleUpload($productSlug, $_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['name'], $_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['tmp_name']);

                        $dataProductAttributeArray = array(
                            'product_id' => $productId,
                            'attribute_id' => $attr_sub_data['attribute_id'],
                            'attribute_type' => '2',
                            'attribute_value' => $attr_data['attrubute_value'],
                            'sub_attribute_id' => $attr_sub_data['id'],
                            'sub_attribute_value' => $uploded_file_path,
                            'createdby' => $user_id,
                            'createddate' => date('Y-m-d H:m:s'),
                        );
                    }

                    $this->product_attribute->insert($dataProductAttributeArray);
                }
                //end upload png plugin image

                if (isset($attr_data['sub_attribute_details'])) {

                    foreach ($attr_data['sub_attribute_details'] as $attr_sub_data) {

                        if ($this->input->post('attr_input_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']) || $this->input->post('attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'])) {

                            if ($attr_data['attribute_type'] == '0') {
                                $dataProductAttributeArray = array(
                                    'product_id' => $product_id,
                                    'attribute_id' => $attr_sub_data['attribute_id'],
                                    'attribute_type' => '0',
                                    'attribute_value' => $attr_data['attrubute_value'],
                                    'sub_attribute_id' => $attr_sub_data['id'],
                                    'sub_attribute_value' => $this->input->post('attr_input_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']),
                                    'createdby' => $user_id,
                                    'createddate' => date('Y-m-d H:m:s'),
                                );
                                
                                $this->product_attribute->insert($dataProductAttributeArray);
                            } else if ($this->input->post('attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id'])) {

                                $dataProductAttributeArray = array(
                                    'product_id' => $product_id,
                                    'attribute_id' => $attr_sub_data['attribute_id'],
                                    'attribute_type' => '1',
                                    'attribute_value' => $attr_data['attrubute_value'],
                                    'sub_attribute_id' => $attr_sub_data['id'],
                                    'sub_attribute_value' => $this->input->post('attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']),
                                    'sub_attribute_dp_id' => $this->input->post('attr_dropdown_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']),
                                    'createdby' => $user_id,
                                    'createddate' => date('Y-m-d H:m:s'),
                                );

                                $this->product_attribute->insert($dataProductAttributeArray);
                            }
                        }
                    }
                }
            }
        }

        /* End of file upload */
        if($product_id) {
            // set the session message
            $this->session->set_flashdata('message', 'Product added successfully');
            redirect('admin/products');
        } else {
            // set the session message
            $this->session->set_flashdata('message', 'Failed to add the product. Try again');
            redirect('admin/products');
        }
    }

    /**
     * get attributes of product
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       null
     * @return      attributes array
     */
    public function getAttributes() {

        $product_category_id = $this->input->post('product_category_id');

        $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_sub_categories($product_category_id);

        // foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
        //     $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
        // }

        $attribute_view = $this->load->view('_div_subcategories', $this->data, TRUE);

        echo json_encode(array('content' => $attribute_view));
        die;
    }


    public function getAttributesById() {

        $product_category_id = $this->input->post('product_category_id');

        $query = $this->db->get_where('tbl_p_sub_attributes', array('attribute_id' => $product_category_id));

        $this->data['prodcut_cat_detail'] = $query->result_array();        

        // foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
        //     $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
        // }
        
        $attribute_view = $this->load->view('_div_attribute_list', $this->data, TRUE);

        echo json_encode(array('content' => $attribute_view));
        die;
    }

    public function getSubSubCategories() {

        $product_category_id = $this->input->post('product_category_id');

        $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_sub_categories($product_category_id);

        $attribute_view = $this->load->view('_div_subsubcategories', $this->data, TRUE);

        echo json_encode(array('content' => $attribute_view));
        die;
    }

    public function getSubSubSubCategories() {

        $product_category_id = $this->input->post('product_category_id');

        $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_sub_categories($product_category_id);

        $attribute_view = $this->load->view('_div_subsubsubcategories', $this->data, TRUE);

        echo json_encode(array('content' => $attribute_view));
        die;
    }


    public function getSubSubSubSubCategories() {

        $product_category_id = $this->input->post('product_category_id');

        $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_sub_categories($product_category_id);

        $attribute_view = $this->load->view('_div_subsubsubsubcategories', $this->data, TRUE);

        echo json_encode(array('content' => $attribute_view));
        die;
    }

    public function getSubCategories() {

        $product_category_id = $this->input->post('product_category_id');

        $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);

        // foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
        //     $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
        // }

        // $this->data['prodcut_cat_detail'];
        $attribute_view = $this->load->view('_div_subcategories', $this->data, TRUE);

        echo json_encode(array('content' => $attribute_view));
        die;
    }

   /**
    * @author      : Harshal Borse <harshalb@rebelute.com>
    * @date        : 22 Nov 2017
    * @param       : id (int) - id of the record to delete
    * @desc        : delete the category from table
    */
    public function ajaxdeleteBuyCategory($id = NULL) {

        // get the posted values of id
        $id = trim($this->input->post('id'));

            // handle the exception here
        try {
                // check if the user is deleted successfully
            if ($this->product_category->delete_cat(trim($id))) {
                    // set the json response array for success message
                $response_array = json_encode(array('status' => '1', 'message' => 'Category deleted successfully'));
                echo $response_array;
                return false;
            } else {
                    // set the json response array failure message
                $response_array = json_encode(array('status' => '0', 'message' => 'Failed to delete the category.'));
                echo $response_array;
                return false;
            }

        } catch (Exception $e) {
                // print the exception if any
            echo $e; die;
        }
    }

    /**
    * @author      : Harshal Borse <harshalb@rebelute.com>
    * @date        : 22 Nov 2017
    * @desc        : add attribute view
    */
    public function addBuyAttribute() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        // set the parameters for rendering view
        $this->data = null;
        $pageTitle = 'Buy Sell Rent | Add Attribute';
        $renderTo = 'admin/add_buy_attribute';

        $this->data['product_category'] = $this->product_category->dropdown('name');

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
    * @author      : Harshal Borse <harshalb@rebelute.com>
    * @date        : 22 Nov 2017
    * @desc        : edit attribute view
    */
    public function ajaxEditBuyAttribute($attribute_id = NULL) {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        
        // set the parameters for rendering view
        $this->data = null;
        $pageTitle = 'Buy Sell Rent | Edit Attribute';
        $renderTo = 'admin/edit_buy_attribute';

        // fetch all product categories
        $this->data['attribute_details'] = $this->pattribute->as_array()->get_many(array('id' => $attribute_id));

        foreach ($this->data['attribute_details'] as $key => $dataAtt) {
            $this->data['attribute_details'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['id']);
        }
        
        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);   
    }

    public function updateBuyAttributes() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        if ($this->session->userdata('user_id'))
            $user_id = $this->session->userdata('user_id');

        $attribute_id = trim($this->input->post('attribute_id'));

        $subattradata = $this->pattribute_sub->get_sub_attributes_at_id($attribute_id);

        $updateAttributeArray = array();
        $updateAttributeArray = array();
        $data = array();
        $i = 0;

        foreach ($subattradata as $subData) {

            if (isset($this->input->post('add_sub_attribute_name')[$subData['id']])) {

                $updateAttributeArray['sub_name'] = $this->input->post('add_sub_attribute_name')[$subData['id']];
                $updateAttributeArray['sub_value'] = $this->input->post('tags')[$subData['id']];

                $this->pattribute_sub->update_subattr($subData['id'], $updateAttributeArray);
            }
        }

        // echo $this->db->last_query(); die;

        $dataAttributeUpdateArray = array(
            'parent_id' => $this->input->post('parent_id'),
            'attrubute_value' => $this->input->post('attribute_value'),
            'attribute_type' => $this->input->post('attribute_type'),
            'modifiedby' => $user_id,
            'modifieddate' => date('Y-m-d H:m:s'),
        );

        $this->pattribute->update($attribute_id, $dataAttributeUpdateArray);

        $dataSubAttributeArray = array(
            'attribute_id' => $attribute_id,
            'modifiedby' => $user_id,
            'modifieddate' => date('Y-m-d H:m:s'),
        );

        /* insert new attrubutes */
        $subAttributeName = $this->input->post('add_sub_attribute_name_new');
        $subAttributeVales = $this->input->post('tags_new');

        $subCount = count($subAttributeName);

        if ($subCount > 0) {
            for ($i = 0; $i < $subCount; $i++) {
                if ($subAttributeName[$i] != NULL) {
                    foreach ($subAttributeName as $key => $val)
                        $dataSubAttributeArray['sub_name'] = $subAttributeName[$i];

                    foreach ($subAttributeVales as $keySub => $valSub)
                        $dataSubAttributeArray['sub_value'] = $subAttributeVales[$i];
                    $this->pattribute_sub->insert($dataSubAttributeArray);
                }
            }
        }

        // set the session message
        $this->session->set_flashdata('message', 'Attribute updated successfully');
        redirect('admin/buy_attributes');
    }


    /**
    * @author      : Harshal Borse <harshalb@rebelute.com>
    * @date        : 22 Nov 2017
    * @desc        : add the attribute
    */
    public function ajaxAddBuyAttribute() {        

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        if ($this->session->userdata('user_id'))
            $user_id = $this->session->userdata('user_id');

        // echo $this->input->post('category_attribute'); die;
        if(!empty($this->input->post('category_attribute'))) {

            $parent_id = $this->input->post('category_attribute');
            // $get_category_name = $this->db->get_where('tbl_product_category', array('id' => $parent_id));
            // $category_name = $get_category_name->result_array();

            $dataAttributeArray = array(
                'attrubute_value' => $this->input->post('attribute_value'),
                'parent_id' => $parent_id,
                'is_brand' => (!empty($this->input->post('is_brand')) ? $this->input->post('is_brand') : 0),
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:m:s'),
            );

        } else {
            $dataAttributeArray = array(
                'attrubute_value' => $this->input->post('attribute_value'),
                'is_brand' => (!empty($this->input->post('is_brand')) ? $this->input->post('is_brand') : 0),
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:m:s'),
            );
        }

        $insertAttrId = $this->pattribute->insert($dataAttributeArray);

        $dataSubAttributeArray = array(
            'attribute_id' => $insertAttrId,
            'createdby' => $user_id,
            'createddate' => date('Y-m-d H:m:s'),
        );


        // $data_sub_cat_arry = array(
        //     'p_category_id' => $parent_id,
        //     'p_sub_category_id' => $insertAttrId,
        //     'createdby' => $user_id,
        //     'createddate' => date('Y-m-d H:m:s'),
        //     'modifieddate' => date('Y-m-d H:m:s'),
        //     'modifiedby' => $user_id,
        //     'isactive' => '0'
        // );

        // $this->product_sub_category->insert($data_sub_cat_arry);            
        // echo $this->db->last_query(); die;

        $subAttributeName = $this->input->post('add_sub_attribute_name');
        $subAttributeVales = $this->input->post('tags');

        $subCount = count($subAttributeName);
        
        if ($subCount > 0) {
            for ($i = 0; $i < $subCount; $i++) {
                if ($subAttributeName[$i] != NULL) {
                    foreach ($subAttributeName as $key => $val)
                        $dataSubAttributeArray['sub_name'] = $subAttributeName[$i];

                    foreach ($subAttributeVales as $keySub => $valSub)
                        $dataSubAttributeArray['sub_value'] = $subAttributeVales[$i];
                    $this->pattribute_sub->insert($dataSubAttributeArray);
                }
            }

            $this->session->set_flashdata("message", "Attribute Added successfully");
            redirect('admin/buy_attributes');
        }
    }

    /**
    * @author      : Harshal Borse <harshalb@rebelute.com>
    * @date        : 22 Nov 2017
    * @param       : id (int) - id of the record to delete
    * @desc        : delete the attribute from table
    */
    public function ajaxdeleteBuyAttribute() {

        // get the posted values of id
        $attr_id = trim($this->input->post('id'));

        // handle the exception here
        try {
            // check if the attribute is deleted successfully

            $attr_deleted = $this->pattribute->delete($attr_id);
            $subattr_deleted = $this->pattribute_sub->delete($attr_id);            

            if ($attr_deleted && $subattr_deleted) {
                // set the json response array for success message
                $response_array = json_encode(array('status' => '1', 'message' => 'Attribute deleted successfully'));
                echo $response_array;
                return false;
            } else {
                // set the json response array failure message
                $response_array = json_encode(array('status' => '0', 'message' => 'Failed to delete the Attribute.'));
                echo $response_array;
                return false;
            }

        } catch (Exception $e) {
            // print the exception if any
            echo $e; die;
        }
    }

    /**
    * @author      : Harshal Borse <harshalb@rebelute.com>
    * @date        : 04 Jan 2018
    * @desc        : add brand view
    */
    public function buyProductBrands() {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        // get the user id from session
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        // fetch all product brands
        $this->data['prodcut_brand_list'] = $this->brands->as_array()->get_all();

        $pageTitle = 'Buy Sell Rent | Buy - Manage Brands';
        $renderTo = 'buy_product_brands';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * order list page
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       null
     * @return      list orders view
     */
    public function orders() {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title'] = 'Orders';
        $this->data['total_users'] = ($this->users->count_by(array('id')));
        $this->data['total_groups'] = count($this->group_model->get_all());
        $this->data['all_orders'] = $this->orders_summary->get_all_orders();        

        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | List Orders';
        $renderTo = 'orders';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * order details page
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       null
     * @return      detail orders view
     */
    public function order_details($order_id = NULL) {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['page_title'] = 'Orders';
        $this->data['total_users'] = ($this->users->count_by(array('id')));
        $this->data['total_groups'] = count($this->group_model->get_all());

        $this->data['all_orders'] = $this->admin_library->demo_update_order_details($order_id);

        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Order Details';
        $renderTo = 'order_details';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * list of product categories
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       $product_id (int)
     * @return      detail product categories
     */
    public function buyProductCategories($product_id = NULL) {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        // get the user id from session
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['total_users'] = ($this->users->count_by(array('id')));
        $this->data['total_groups'] = count($this->group_model->get_all());

        // fetch all product categories
        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();

        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }

        $get_sub_cat = $this->db->get_where('tbl_p_attributes', array('is_brand' => '2'));
        $this->data['attt_sub_category'] = $get_sub_cat->result_array();

        $get_brands = $this->db->get_where('tbl_p_attributes', array('is_brand' => '1'));
        $this->data['attt_brands'] = $get_brands->result_array();

        $get_attrs = $this->db->get_where('tbl_p_attributes', array('is_brand' => '1'));
        $this->data['attt_attributes'] = $get_attrs->result_array();       

        
        // $this->data['attt_category'] = array('' => 'Select Attribute') + $this->pattribute->dropdown('attrubute_value');
        // $this->data['attt_category'] = array('' => 'Select Attribute') + $this->pattribute_sub->dropdown('attrubute_value');
        $this->data['attt_category'] = array('' => 'Select Attribute') + $this->product_category->dropdown('name');
        // $this->data['attt_category'] = $this->product_category->get_categories();
        
        $pageTitle = 'Buy Sell Rent | Buy - Add Category';
        $renderTo = 'buy_product_categories';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * list of product categories
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       $product_id (int)
     * @return      detail product categories
     */
    public function buyProductSubCategories($product_id = NULL) {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        // get the user id from session
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['total_users'] = ($this->users->count_by(array('id')));
        $this->data['total_groups'] = count($this->group_model->get_all());

        $this->data['sub_categories'] = $this->product_sub_category->get_product_sub_categories();
        
        $pageTitle = 'Buy Sell Rent | Buy - Add Category';
        $renderTo = 'buy_product_sub_categories';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }


    /**
     * add category of buy section
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       $product_id (int)
     * @return      add the category
     */
    public function ajaxAddBuyCategory() {

        if (!$this->ion_auth->logged_in() && !$this->ion_auth->is_admin()) {
            // set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '0', 'message' => 'Please login to add the category')); exit;
        } else {

            // get the user id from session
            $user_id = $this->session->userdata('user_id');


            /* file upload */
            if (!empty($_FILES['category_image']['name'][0])) {

                $totalImageUploadCnt = count($_FILES['product_images']['name']);

                $targetDir = "/frontend/assets/images/products/rent_products";
                for ($i = 0; $i < $totalImageUploadCnt; $i++) {
                    $fileName = $_FILES['category_image']['name'][$i];
                    $targetFile = $targetDir . $fileName;
                    $productSlug = 'rent_products';
                    $uploded_file_path = $this->handleCategoryUpload($productSlug, $_FILES['product_images']['name'][$i], $_FILES['product_images']['tmp_name'][$i]);
                    if ($uploded_file_path != '') {
                        $imageData[$i] = 'rent_products' . '/' . ($fileName);
                    }
                }

                $product_data_array['image_url'] = json_encode($imageData);
            }

            // set the array of parameters
            $data_product_category = array(
                'name' => trim($this->input->post('category_name')),
                'description' => trim($this->input->post('category_description')),
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:m:s'),
            );

            $insert_id = $this->product_category->insert($data_product_category);

            $product_sub_cat_array = array(
                'p_category_id' => $insert_id,
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:m:s'),
            );

            $product_sub_cat = trim($this->input->post('category_attribute'));

            if ($product_sub_cat != 0 || $product_sub_cat !== "") {
                $product_sub_cat_array['p_sub_category_id'] = $product_sub_cat;
                $inserted_sub = $this->product_sub_category->insert($product_sub_cat_array);
            }

            // echo $this->db->last_query(); die;

            // foreach ($product_sub_cat as $key => $subData) {
            //     if ($product_sub_cat[$key] != 0) {
            //         $product_sub_cat_array['p_sub_category_id'] = $product_sub_cat[$key];
            //         $inserted_sub = $this->product_sub_category->insert($product_sub_cat_array);
            //     }
            // }

            if($insert_id) {
                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '1', 'message' => 'Category Added successfully')); exit;
            } else {
                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '0', 'message' => 'Failed to process your request')); exit;
            }
        }
        // $this->session->set_flashdata("msg", "Category Added successfully!");
        // redirect('admin/product_category');
    }


    /**
     * edit/update category of buy section
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       $product_id (int)
     * @return      add the category
     */
    public function ajaxEditBuyCategory() {

        if (!$this->ion_auth->logged_in() && !$this->ion_auth->is_admin()) {
            // set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '0', 'message' => 'Please login to update the category')); exit;
        } else {

            // echo "here i am"; die;
            $product_id = trim($this->input->post('product_id'));

            // get the user id from session
            $user_id = $this->session->userdata('user_id');

            $data_category = array(
                'name' => $this->input->post('category_name'),
                'description' => $this->input->post('category_description'),
                'modifiedby' => $user_id,
                'modifieddate' => date('Y-m-d H:m:s'),
            );

            $this->product_category->update($product_id, $data_category);

            // echo $this->db->last_query();

            $product_sub_cat_array = array(
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:m:s'),
            );

            $product_sub_cat = trim($this->input->post('category_attribute'));

            if ($product_sub_cat != 0) {
                $product_sub_cat_array['p_sub_category_id'] = $product_sub_cat;
            }


            $get_sub_cat_id = $this->product_sub_category->as_array()->get_by(array('p_category_id' => $product_id));
            $inserted_sub = $this->product_sub_category->update($get_sub_cat_id['id'], $product_sub_cat_array);

            if($inserted_sub) {
                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '1', 'message' => 'Category Updated successfully')); exit;
            } else {
                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '0', 'message' => 'Failed to process your request')); exit;
            }
        }
        // $this->session->set_flashdata("msg", "Category Added successfully!");
        // redirect('admin/product_category');
    }


    /**
     * add category of buy section
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       $product_id (int)
     * @return      add the category
     */
    public function ajaxAddBuyBrand() {

        if (!$this->ion_auth->logged_in() && !$this->ion_auth->is_admin()) {
            // set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '0', 'message' => 'Please login to add the brand')); exit;
        } else {

            // get the user id from session
            $user_id = $this->session->userdata('user_id');

            // set the array of parameters
            $data_product_brand = array(
                'brand_name' => trim($this->input->post('brand_name')),
            );

            $insert_id = $this->brands->insert($data_product_brand);

            if($insert_id) {
                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '1', 'message' => 'Brand Added successfully')); exit;
            } else {
                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '0', 'message' => 'Failed to process your request')); exit;
            }
        }
    }

    /**
     * edit/update brand of buy section
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       $brand_id (int)
     * @return      update the brand
     */
    public function ajaxEditBuyBrand() {

        if (!$this->ion_auth->logged_in() && !$this->ion_auth->is_admin()) {
            // set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '0', 'message' => 'Please login to update the brand')); exit;
        } else {

            // echo "here i am"; die;
            $brand_id = trim($this->input->post('brand_id'));

            $data_brand = array(
                'brand_name' => $this->input->post('brand_name'),
            );

            if($this->brands->update($brand_id, $data_brand)) {
                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '1', 'message' => 'Brand Updated successfully')); exit;
            } else {
                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '0', 'message' => 'Failed to process your request')); exit;
            }
        }
    }

    /**
     * delete brand from database
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       (int) $brand_id - brand id to delete
     * @return      delete brand message in response
     */

    public function deleteBuyBrand() {

        $brand_id = trim($this->input->post('id'));

        // exception handling
        try {

            // check if the product is deleted
            if ($this->brands->delete_brand($brand_id)) {
                $response_array = json_encode(array('status' => '1', 'message' => 'Brand deleted successfully'));
                echo $response_array;
                return false;
            } else {
                $response_array = json_encode(array('status' => '0', 'message' => 'Failed to delete the brand'));
                echo $response_array;
                return false;
            }
        } catch (Exception $e) {
            $response_array = json_encode(array('status' => '0', 'message' => $e));
            echo $response_array;
            return false;
        }
    }

    /**
     * list of product attributes
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       $product_id (int)
     * @return      detail product attributes
     */
    public function buyProductAttributes() {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        // get the user id from session
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['total_users'] = ($this->users->count_by(array('id')));
        $this->data['total_groups'] = count($this->group_model->get_all());

        // fetch all product categories
        // $this->data['attribute_details'] = $this->pattribute->as_array()->get_all();

        // $this->data['attribute_details'] = $this->pattribute->as_array()->get_by(array('is_brand' => '0'));
        $query_attr = $this->db->get_where('tbl_p_attributes', array('is_brand' => '0', 'isactive' => '0'));
        $this->data['attribute_details'] = $query_attr->result_array();

        $this->data['attt_category'] = array('' => 'Select Parent') + $this->pattribute->dropdown('attrubute_value');

        foreach ($this->data['attribute_details'] as $key => $dataAtt) {
            $this->data['attribute_details'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['id']);
        }

        $pageTitle = 'Buy Sell Rent | Buy - Add Attributes';
        $renderTo = 'buy_product_attributes';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * ccategory image upload
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       null
     * @return      success message
     */
    public function handleCategoryUpload($slug, $upFileName, $upFileTmpName, $category_id) {

        $fileTypes = array('jpeg', 'png', 'jpg'); // File extensions
        $fileParts = pathinfo($upFileName);
        
        // if (!in_array(strtolower($fileParts['extension']), $fileTypes)) {
        //     $this->session->set_flashdata('error', 'File type not supported.');
        //     return false;
        // }

        $ext = pathinfo($upFileName, PATHINFO_EXTENSION);
        $targetURL = '/frontend/assets/images/category/'.$category_id; // Relative to the root
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'category' . DIRECTORY_SEPARATOR . $category_id . DIRECTORY_SEPARATOR . $slug;

        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }

        $tempFile = $upFileTmpName;
        $fileName = $upFileName;
        $fileName = $fileName;
        $path = $targetURL . $slug . '/' . $fileName;
        $targetPath .= DIRECTORY_SEPARATOR . $fileName;
        $upload_status = move_uploaded_file($tempFile, $targetPath);
        $dataDocumentDetail['type'] = $fileParts['extension'];
        if (isset($upload_status))
            return $path;
    }

    /**
     * common function for product image upload
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       null
     * @return      detail orders view
     */
    public function handleUpload($slug, $upFileName, $upFileTmpName) {

        $fileTypes = array('jpeg', 'png', 'jpg'); // File extensions
        $fileParts = pathinfo($upFileName);
        
        // if (!in_array(strtolower($fileParts['extension']), $fileTypes)) {
        //     $this->session->set_flashdata('error', 'File type not supported.');
        //     return false;
        // }

        $ext = pathinfo($upFileName, PATHINFO_EXTENSION);
        $targetURL = '/frontend/assets/images/products/'; // Relative to the root
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR . $slug;

        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }

        $tempFile = $upFileTmpName;
        $fileName = $upFileName;
        $fileName = $fileName;
        $path = $targetURL . $slug . '/' . $fileName;
        $targetPath .= DIRECTORY_SEPARATOR . $fileName;
        $upload_status = move_uploaded_file($tempFile, $targetPath);
        $dataDocumentDetail['type'] = $fileParts['extension'];
        if (isset($upload_status))
            return $path;
    }



    /**
     * common function for product image upload
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       null
     * @return      detail orders view
     */
    public function handleRentUpload($slug, $upFileName, $upFileTmpName) {

        $fileTypes = array('jpeg', 'png', 'jpg'); // File extensions
        $fileParts = pathinfo($upFileName);        

        $ext = pathinfo($upFileName, PATHINFO_EXTENSION);
        $targetURL = '/BuySellRent/frontend/assets/images/rent_products/'; // Relative to the root
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'BuySellRent'. DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'rent_products' . DIRECTORY_SEPARATOR . $slug;

        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }

        $tempFile = $upFileTmpName;
        $fileName = $upFileName;
        $fileName = $fileName;
        $path = $targetURL . $slug . '/' . $fileName;
        $targetPath .= DIRECTORY_SEPARATOR . $fileName;
        // echo $tempFile;
        // echo $targetPath; die;
        $upload_status = move_uploaded_file($tempFile, $targetPath);
        $dataDocumentDetail['type'] = $fileParts['extension'];
        if (isset($upload_status))
            return $path;
    }

    /**
     * delete product from database
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       (int) $product_id - product id to delete
     * @return      delete product message in response
     */

    public function deleteBuyProduct() {

        $product_id = trim($this->input->post('id'));

        // exception handling
        try {

            // check if the product is deleted
            if ($this->product->delete_product($product_id)) {
                $response_array = json_encode(array('status' => '1', 'message' => 'Product deleted successfully'));
                echo $response_array;
                return false;
            } else {
                $response_array = json_encode(array('status' => '0', 'message' => 'Failed to delete the product'));
                echo $response_array;
                return false;
            }
        } catch (Exception $e) {
            $response_array = json_encode(array('status' => '0', 'message' => $e));
            echo $response_array;
            return false;
        }
    }


    /**
     * upload products using csv file
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       string  filter parameters
     * @return      success message for upload product
     */
    public function importProducts() {

        // upload the product view parameters
        $pageTitle = 'Buy Sell Rent | Import Products';
        $renderTo = 'import_products';
        $this->data = NULL;

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * import the csv and display records from csv
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       string  filter parameters
     * @return      success message for upload product
     */
    public function importProductCSV() {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        // $category_id = trim($this->input->post('category_name'));
        $category_id = trim($this->input->post('category_name'));
        $category_array = array();

        if(!empty($this->input->post('category_name'))) {
            array_push($category_array, $this->input->post('category_name'));
        }

        if(!empty($this->input->post('id_select_sub_part2'))) {
            array_push($category_array, $this->input->post('id_select_sub_part2'));
        }

        if(!empty($this->input->post('id_select_sub_part3'))) {
            array_push($category_array, $this->input->post('id_select_sub_part3'));
        }

        if(!empty($this->input->post('id_select_sub_part4'))) {
            array_push($category_array, $this->input->post('id_select_sub_part4'));
        }

        if(!empty($this->input->post('id_select_sub_part5'))) {
            array_push($category_array, $this->input->post('id_select_sub_part5'));
        }

        $subcategory_id = trim($this->input->post('id_select_sub_part2'));

        $fp = fopen($_FILES['import_product_file']['tmp_name'],'r') or die("can't open file");

        $targetPath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR . $category_id;

        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }

        // $this->data['csv_content'] = array();
        $attribute_array = array();

        // $line = fgetcsv($fp);
        while(($line = fgetcsv($fp)) !== FALSE)
        {
            if($line[12] < $line[15]) {
                // set the flash message for success
                $this->session->set_flashdata('message', 'Price will not be less than the discounted price');
                // redirect them to the login page
                redirect('admin/import_products', 'refresh');
            } else {

                // check whether there are duplicate rows of data in database
                // $prevQuery = array(
                //     'product_name'=> $line[0] ,
                //     'product_is_feature' => $line[1] ,
                //     'quantity' => $line[2] ,
                //     'price' => $line[3] ,
                //     'discounted_price' => $line[4],
                //     'product_sku' => $line[5],
                //     'image_url' => $line[6],
                //     'short_description' => $line[7],
                //     'description' => $line[8],
                // );

                // array_push($this->data['csv_content'], $prevQuery);

                // for($i = 0, $j = count($line); $i < $j; $i++) {

                $json_decode_images = json_decode($line[1]);
                $image_array = array();

                for ($i = 0; $i < count($json_decode_images); $i++) {
                    array_push($image_array, $category_id.'/'.$json_decode_images[$i]);
                }

                $json_image_array = json_encode($image_array);

                // get the brand id based on brand name
                $brand_qry = $this->db->get_where('tbl_brands', array('brand_name' => $line[6]));
                $brand_rslt = $brand_qry->result_array();

                $data = array(
                    'category_id' => $category_id,
                    'sub_cat_id' => $subcategory_id,
                    'product_sku' => $line[0],
                    'image_url' => $json_image_array,
                    'product_name'=> $line[2],
                    'quantity' => $line[3],
                    'short_description' => $line[4],
                    'base_price' => $line[5],
                    'brand_id' => $brand_rslt[0]['id'],
                    'brand_uni_id' => $line[7],
                    'weight' => $line[8],
                    'height' => $line[9],
                    'width' => $line[10],
                    'dimension' => $line[11],
                    'price' => $line[12],
                    'description' => $line[13],
                    'product_is_feature' => $line[14],
                    'discounted_price' => $line[15],
                    'product_video' => $line[16],
                    'highlighted' => $line[18],
                    'deals_of_the_week' => $line[19],
                    'on_sale' => $line[20],
                );

                // $data = array(
                //     'category_id' => $category_id,
                //     'sub_cat_id' => $subcategory_id,
                //     'product_name'=> $line[0],
                //     'product_is_feature' => $line[1],
                //     'quantity' => $line[2],
                //     'price' => $line[3],
                //     'discounted_price' => $line[4],
                //     'product_sku' => $line[5],
                //     'image_url' => $json_image_array,
                //     'product_video' => $line[7],
                //     'short_description' => $line[8],
                //     'description' => $line[9],
                //     'additional_information' => $line[10],
                //     'highlighted' => $line[12],
                //     'deals_of_the_week' => $line[13],
                //     'on_sale' => $line[14],
                // );
                

                $data['uploaded_records'] = $this->db->insert('tbl_products', $data);
                
                $last_id = $this->db->insert_id();

                foreach ($category_array as $value) {

                    $data_subcat_array = array(
                        'product_id' => $last_id,
                        'category_id' => $value,
                    );

                    $this->product_sub_category_map->insert($data_subcat_array);
                }

                if($line[12] == '1') {
                    $highlighted_array = array(
                        'product_id' => $last_id,
                        'sale_type' => "Default sale type",
                        'product_title' => $line[0],
                        'price' => $line[3],
                        'img_url' => 'banner-img4.jpg'
                    );

                    $this->product->mark_as_highlighted_product($last_id, $highlighted_array);
                }

                if($line[13] == '1') {

                    $start_date = date('Y-m-d H:i:s');
                    $end_date = date('Y-m-d H:i:s',strtotime('next Sunday'));

                    $dow_array = array('start_date_time' => $start_date, 'end_date_time' => $end_date, 'product_id' => $last_id);
                    $this->product->mark_as_dow_product($last_id, '1',$dow_array);
                }

                // insert the attributes
                $attribute_array = (array) json_decode($line[17]);
                
                foreach ($attribute_array as $key => $value) {

                    $attr_arr = array(
                        'product_id' => $last_id,
                        'attr_key' => $key,
                        'attr_value' => $value
                    );

                    $this->db->insert('tbl_product_features', $attr_arr);


                    $attr_arr_map = array(
                        'product_id' => $last_id,
                        'attribute_id' => '0',
                        'attribute_value' => $key,
                        'sub_attribute_value' => $value
                    );

                    $this->db->insert('tbl_product_attributes', $attr_arr_map);

                }
            }

            // $i++;

            // $prevResult = $this->db->query($q);
        }


        if($_FILES["zip_file"]["name"]) {

            $filename = $_FILES["zip_file"]["name"];
            $source = $_FILES["zip_file"]["tmp_name"];
            $type = $_FILES["zip_file"]["type"];
            
            $name = explode(".", $filename);
            $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
            foreach($accepted_types as $mime_type) {
                if($mime_type == $type) {
                    $okay = true;
                    break;
                } 
            }
            
            $continue = strtolower($name[1]) == 'zip' ? true : false;

            $target = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR . $category_id . DIRECTORY_SEPARATOR . $filename;

            // base_url()."frontend/assets/images/products/".$category_id."/".$filename;  // change this to the correct site path
            if(move_uploaded_file($source, $target)) {
                $zip = new ZipArchive();
                $x = $zip->open($target);
                if ($x === true) {
                    $zip->extractTo($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR . $category_id); // change this to the correct site path
                    $zip->close();

                    unlink($target);
                }
            }
        }

        // set the flash message for success
        $this->session->set_flashdata('message', 'Products uploaded successfully');
        // redirect them to the login page
        redirect('admin/import_products', 'refresh');

        // while(($line = fgetcsv($fp)) !== FALSE)
        // {
        //     //check whether there are duplicate rows of data in database
        //     $prevQuery = array(
        //         'articleno'=> $line[0] ,
        //         'product_description' => $line[1] ,
        //         'cust_name' => $line[2] ,
        //         'size' => $line[3] ,
        //         'colour' => $line[4],
        //         'process_description' => $line[5],
        //         'output' => $line[6],
        //         'material_part' => $line[7],
        //         'printingOutput' => $line[8]
        //     );

        //     $q = $this->db->select('sindi_productprocess_temp', $prevQuery)->where('articleno',$line[0],
        //         'product_description', $line[1] ,
        //         'cust_name' , $line[2] ,
        //         'size', $line[3] ,
        //         'colour' , $line[4],
        //         'process_description' , $line[5],
        //         'output', $line[6],
        //         'material_part', $line[7],
        //         'printingOutput', $line[8]
        //     );

        //     $prevResult = $this->db->query($q);

        //     if($prevResult->num_rows > 0) {
        //         //update process data

        //         $data = array(
        //             'articleno' => $line[0] ,
        //             'product_description' => $line[1] ,
        //             'cust_name' => $line[2] ,
        //             'size' => $line[3] ,
        //             'colour' => $line[4],
        //             'process_description' => $line[5],
        //             'output' => $line[6],
        //             'material_part' => $line[7],
        //             'printingOutput' => $line[8]
        //         );


        //         $this->db->set(
        //             'articleno',$line[0],
        //             'product_description', $line[1] ,
        //             'cust_name' , $line[2] ,
        //             'size', $line[3] ,
        //             'colour' , $line[4],
        //             'process_description' , $line[5],
        //             'output', $line[6],
        //             'material_part', $line[7],
        //             'printingOutput', $line[8]
        //         );

        //         $this->db-where(
        //             'articleno',$line[0],
        //             'product_description', $line[1] ,
        //             'cust_name' , $line[2] ,
        //             'size', $line[3] ,
        //             'colour' , $line[4],
        //             'process_description' , $line[5],
        //             'output', $line[6],
        //             'material_part', $line[7],
        //             'printingOutput', $line[8]
        //         );    

        //         $this->db->update('sindi_productprocess_temp');

        //     } else {

        //         for($i = 0, $j = count($line); $i < $j; $i++) {

        //             $data = array(
        //                 'articleno' => $line[0] ,
        //                 'product_description' => $line[1] ,
        //                 'cust_name' => $line[2] ,
        //                 'size' => $line[3] ,
        //                 'colour' => $line[4],
        //                 'process_description' => $line[5],
        //                 'output' => $line[6],
        //                 'material_part' => $line[7],
        //                 'printingOutput' => $line[8]
        //             );

        //             $data['crane_features']=$this->db->insert('sindi_productprocess_temp', $data);
        //         }
        //         $i++;
        //     }
        // }

        fclose($fp) or die("can't close file");
    }

    
    /**
     * upload brands using csv file
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       string  filter parameters
     * @return      success message for upload brands
     */
    public function importBrands() {

        // upload the product view parameters
        $pageTitle = 'Buy Sell Rent | Import Brands';
        $renderTo = 'import_brands';
        $this->data = NULL;

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * import the csv for brands
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       string  filter parameters
     * @return      success message for upload brands
     */
    public function importBrandsCSV() {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $fp = fopen($_FILES['import_brand_file']['tmp_name'],'r') or die("can't open file");

        // $this->data['csv_content'] = array();
        $attribute_array = array();

        // $line = fgetcsv($fp);
        while(($line = fgetcsv($fp)) !== FALSE)
        {
            $data = array(
                'brand_name'=> trim($line[0])
            );
            
            $data['uploaded_records'] = $this->db->insert('tbl_brands', $data);            
        }

        // set the flash message for success
        $this->session->set_flashdata('message', 'Products brands imported successfully');

        // redirect them to the login page
        redirect('admin/import_brands', 'refresh');
    }

    /**
     * upload categories using csv file
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       string  filter parameters
     * @return      success message for upload categories
     */
    public function importCategories() {

        // upload the product view parameters
        $pageTitle = 'Buy Sell Rent | Import Categories';
        $renderTo = 'import_categories';
        $this->data = NULL;

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * import the csv for categories
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       string  filter parameters
     * @return      success message for upload categories
     */
    public function importCategoriesCSV() {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        // $this->data = file_get_contents($_FILES['import_product_file']);


        if($_FILES["zip_file"]["name"]) {

            $filename = $_FILES["zip_file"]["name"];
            $source = $_FILES["zip_file"]["tmp_name"];
            $type = $_FILES["zip_file"]["type"];

            $name = explode(".", $filename);
            $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
            foreach($accepted_types as $mime_type) {
                if($mime_type == $type) {
                    $okay = true;
                    break;
                } 
            }
            
            $continue = strtolower($name[1]) == 'zip' ? true : false;

            $target = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR. 'BuySellRent' . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'category_images' . DIRECTORY_SEPARATOR . $filename;

            // base_url()."frontend/assets/images/products/".$category_id."/".$filename;  // change this to the correct site path
            if(move_uploaded_file($source, $target)) {
                $zip = new ZipArchive();
                $x = $zip->open($target);
                if ($x === true) {
                    $zip->extractTo($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR. 'BuySellRent' . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'category_images'); // change this to the correct site path
                    $zip->close();

                    unlink($target);
                }
            }
        }

        $fp = fopen($_FILES['import_product_file']['tmp_name'],'r') or die("can't open file");

        // $this->data['csv_content'] = array();
        $attribute_array = array();

        // $line = fgetcsv($fp);
        while(($line = fgetcsv($fp)) !== FALSE)
        {
            $data = array(
                'name'=> $line[0],
                'description' => $line[1],
                'img_url' => $line[2],
            );
            
            $data['uploaded_records'] = $this->db->insert('tbl_product_category', $data);
        }

        // set the flash message for success
        $this->session->set_flashdata('message', 'Products categories uploaded successfully');

        // redirect them to the login page
        redirect('admin/import_categories', 'refresh');
    }

    /**
     * upload attributes using csv file
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       string  filter parameters
     * @return      success message for upload attributes
     */
    public function importAttributes() {

        // upload the product view parameters
        $pageTitle = 'Buy Sell Rent | Import Attributes';
        $renderTo = 'import_attributes';
        $this->data = NULL;

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    public function viewBlogList() { 

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        
        $this->data['blog_data'] = $this->common_model->getBlogList('tbl_mst_blog_posts', '*', '', $order_by = 'post_id DESC', $limit = '', $debug = 0);
        
        
        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Blog List';
        $renderTo = 'blog_list';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }
    
    
    public function viewBlogCategoriesList() { 

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['cat_data'] = $this->common_model->getRecords('tbl_mst_categories', '*', '', $order_by = 'category_id DESC', $limit = '', $debug = 0);
         //echo '<pre>';print_R($this->data['cat_data'] );die;
        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Blog Categories List';
        $renderTo = 'admin/blog_categories_list';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }
    
    
    public function addBlogCategories() { 

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        

        if (trim($this->input->post('category_name')) != '' && trim($this->input->post('category_title') != '')) {
            
            $arr_details = $this->common_model->getRecords('tbl_mst_categories', '*', array('category_name' => trim($this->input->post('category_name'))), $order_by = 'category_id DESC', $limit = '', $debug = 0);

            if(count($arr_details) <1) {

                $arr_to_insert = array(
                    "category_name" => trim($this->input->post('category_name')),
                    "status" => trim($this->input->post('status')),
                    "category_title" => trim($this->input->post('category_title')),
                    'created_on' => date("Y-m-d H:i:s")
                );
        
                $last_insert_main_id = $this->common_model->insertRow($arr_to_insert, "tbl_mst_categories");
                $this->session->set_flashdata('message', 'Blog category added successfully');
                redirect('admin/blog_categories_list', 'refresh');
            }
        }


        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $pageTitle = 'Buy Sell Rent | Add New Blog Category';
        $renderTo = 'blog_categories_add';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }


    public function addBlog() { 

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        if (trim($this->input->post('inputName')) != '' && trim($this->input->post('blog_category') != '')) {
            $arr_details = $this->common_model->getRecords('tbl_mst_blog_posts', '*', array('post_title' => trim($this->input->post('inputName'))), $order_by = 'post_id DESC', $limit = '', $debug = 0);
            $absolute_path = $this->absolutePath();

            $target = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'blogs/';
            $user_id = $this->session->userdata('user_id');
            
            if(count($arr_details) < 1) {
                if ($_FILES['img_file']['name'] != '') {
                    $_FILES['img_file']['name'];
                    $_FILES['img_file']['type'];
                    $_FILES['img_file']['tmp_name'];
                    $_FILES['img_file']['error'];
                    $_FILES['img_file']['size'];
                    $config['file_name'] = time() . rand();
                    $config['upload_path'] = $target;
                    $config['allowed_types'] = 'jpg|jpeg|gif|png';
                    $config['max_size'] = '9000000';
                    $this->load->library('upload');
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('img_file')) {
                        $data['upload_data'] = $this->upload->data();
                               // $ar = list($width, $height) = getimagesize($data['full_path']);
                        $upload_result = $this->upload->data();
                        /* for image */
                        $image_config = array(
                            'source_image' => $upload_result['full_path'],
                            'new_image' =>$target."395x250/",
                            'maintain_ratio' => false,
                            'width' => 395,
                            'height' => 250
                        );
                        $this->load->library('image_lib');
                        $this->image_lib->initialize($image_config);
                        $resize_rc = $this->image_lib->resize();


                        $image_config1 = array(
                            'source_image' => $upload_result['full_path'],
                            'new_image' =>$target."870x545/",
                            'maintain_ratio' => false,
                            'width' => 870,
                            'height' => 545
                        );

                        $this->load->library('image_lib');
                        $this->image_lib->initialize($image_config1);
                        $resize_rc2 = $this->image_lib->resize();

                        /* for image  540x360 */
                        $img_path = $upload_result['file_name'];
                    } else {
                        $error = array('error' => $this->upload->display_errors());
                    }
                    

                    $arr_to_insert = array(
                        "post_title" => $this->input->post('inputName'),
                        "blog_category" => $this->input->post('blog_category'),
                        "blog_image" => $img_path,
                        'post_content' => $this->input->post('inputPostDescription'),
                        'posted_by' => $user_id,
                        'posted_on' => date("Y-m-d H:i:s"),
                        'status' => $this->input->post('blog_status'),
                        'slug' => ''
                    );

                    $last_insert_main_id = $this->common_model->insertRow($arr_to_insert, "tbl_mst_blog_posts");

                    $tags_data_arry = array();

                    if(!empty($this->input->post('tags'))) {

                        $tag_array = explode(',', trim($this->input->post('tags')));

                        foreach ($tag_array as $v) {
                            $tags_data_arry = array(
                                'post_id' => $last_insert_main_id,
                                'tag' => $v,
                            );

                            $this->blog_tags->insert($tags_data_arry);
                        }
                    }

                    $this->session->set_flashdata('message', 'Blog added successfully');
                }

                redirect('admin/blog_list', 'refresh');
            }
        }

        $this->data['category'] = $this->common_model->getRecords('tbl_mst_categories', '*', '', $order_by = 'category_id DESC', $limit = '', $debug = 0);

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $pageTitle = 'Buy Sell Rent | Add New Blog';
        $renderTo = 'blog_add';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
    * @author : Harshal Borse <harshalb@rebelute.com> 
    * @date   : 17 Jan 2018
    * @param  : blog id (integer)
    * view blog page and its comments to approve by admin
    */
    public function viewBlog($blog_id = NULL) {
        
        // check if the user is logged in and user is admin otherwise send user to login page
        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $this->data['blog_detail'] = $this->Blog_model->getPosts('', 'post_id ='.$blog_id);

        foreach ($this->data['blog_detail'] as $key => $value) {
            $this->data['blog_detail'][$key]['blog_comments'] = $this->common_model->getBlogComments($value['post_id']);
        }
        
        $pageTitle = 'Buy Sell Rent | View Blog';
        $renderTo = 'blog_view';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
    * @author : Harshal Borse <harshalb@rebelute.com> 
    * @date   : 17 Jan 2018
    * change the blog comment status (approved/unapproveed)
    */
    public function changeCommentStatus() {

        $comment_id = trim($this->input->post('comment_id'));
        $comment_status = trim($this->input->post('comment_status'));

        if($this->blog_comment->updateCommentStatus($comment_id, $comment_status)) {

            // success message after apporved of comment from admin
            $response_array = json_encode(array('status' => '1', 'message' => 'Comment status changed successfully'));
            echo $response_array;
            return false;

        } else {
            // failure message after failed to apporve of comment from admin
            $response_array = json_encode(array('status' => '0', 'message' => 'failed to approve the comment'));
            echo $response_array;
            return false;
        }
    }

    public function editBlog($edit_id='') { 

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        $this->data['edit_id']=$edit_id;
        $this->data['post_info'] = ($this->common_model->getRecords('tbl_mst_blog_posts', '*', array('post_id' => $edit_id), $order_by = 'post_id DESC', $limit = '', $debug = 0));
            //echo '<pre>';print_R($this->data['post_info']);die;  
        if (trim($this->input->post('inputName')) != '' && trim($this->input->post('blog_category') != '')) {
          $target = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'blogs/';
          $user_id = $this->session->userdata('user_id');
          if(count($this->data['post_info']) > 0){
             if ($_FILES['img_file']['name'] != '') {
                $_FILES['img_file']['name'];
                $_FILES['img_file']['type'];
                $_FILES['img_file']['tmp_name'];
                $_FILES['img_file']['error'];
                $_FILES['img_file']['size'];
                $config['file_name'] = time() . rand();
                $config['upload_path'] = $target;
                $config['allowed_types'] = 'jpg|jpeg|gif|png';
                $config['max_size'] = '9000000';
                $this->load->library('upload');
                $this->upload->initialize($config);

                if ($this->upload->do_upload('img_file')) {
                    $data['upload_data'] = $this->upload->data();
                            //$ar = list($width, $height) = getimagesize($data['full_path']);
                    $upload_result = $this->upload->data();
                    /* for image */
                    $image_config = array(
                        'source_image' => $upload_result['full_path'],
                        'new_image' =>$target."395x250/",
                        'maintain_ratio' => false,
                        'width' => 395,
                        'height' => 250
                    );
                    $this->load->library('image_lib');
                    $this->image_lib->initialize($image_config);
                    $resize_rc = $this->image_lib->resize();
                    /* for image  540x360 */

                    $image_config1 = array(
                        'source_image' => $upload_result['full_path'],
                        'new_image' =>$target."870x545/",
                        'maintain_ratio' => false,
                        'width' => 870,
                        'height' => 545
                    );
                    $this->load->library('image_lib');
                    $this->image_lib->initialize($image_config1);
                    $resize_rc2 = $this->image_lib->resize();

                    $img_path = $upload_result['file_name'];
                } else {
                    $error = array('error' => $this->upload->display_errors());
                            //echo '<pre>';print_R($error);die;
                }
            }else{
                $img_path = $this->input->post('old_img_file');
            }
                $update_data = array(
                    "post_title" => $this->input->post('inputName'),
                    "blog_category" => $this->input->post('blog_category'),
                    "blog_image" => $img_path,
                    'post_content' => $this->input->post('inputPostDescription'),
                    'posted_by' => $user_id,
                    'posted_on' => date("Y-m-d H:i:s"),
                    'status' => $this->input->post('blog_status'),
                    'slug' => ''
                );
                            //echo '<pre>';print_R($arr_to_insert);die;
                $condition = array("post_id" => $edit_id);
                $this->common_model->updateRow('tbl_mst_blog_posts', $update_data, $condition);

                $this->session->set_flashdata('message', 'Blog updated successfully');
            }

            redirect('admin/blog_list', 'refresh');
                //echo '<pre>';print_r($arr_to_insert);die;
        }
        $this->data['category'] = $this->common_model->getRecords('tbl_mst_categories', '*', '', $order_by = 'category_id DESC', $limit = '', $debug = 0);

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $pageTitle = 'Buy Sell Rent | Edit Blog';
        $renderTo = 'blog_edit';

                // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }



    public function editBlogCategories($edit_id='') { 

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $this->data['arr_details'] = $this->common_model->getRecords('tbl_mst_categories', '*', array('category_id' => $edit_id), $order_by = 'category_id DESC', $limit = '', $debug = 0);


        if (trim($this->input->post('category_name')) != '' && trim($this->input->post('category_title') != '')) {
            if(count($this->data['arr_details']) > 0) {
                $arr_to_update = array(
                    "category_name" => trim($this->input->post('category_name')),
                    "category_title" => trim($this->input->post('category_title')),
                    "status" => trim($this->input->post('status')),
                    'created_on' => date("Y-m-d H:i:s")
                );

                $condition_array = array('category_id' => intval($this->input->post('edit_id')));
                
                /* updating the global setttings parameter value into database */
                $this->common_model->updateRow('tbl_mst_categories', $arr_to_update, $condition_array);

                $this->session->set_flashdata('message', 'Blog category updated successfully');
                redirect('admin/blog_categories_list', 'refresh');
            }
        }

        $this->data['edit_id'] = $edit_id;
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $pageTitle = 'Buy Sell Rent | Edit Blog Category';
        $renderTo = 'blog_categories_edit';

                // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
    * @author : Harshal Borse <harshalb@rebelute.com> 
    * @date   : 18 Jan 2018
    * show the rented product view
    */
    public function rentProducts() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['product_details_count'] = $this->rent_product->count_by(array('id'));
        $this->data['product_details'] = $this->rent_product->get_products();

        // foreach ($this->data['product_details'] as $key => $value)
        //     $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);


        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Rent Product List';
        $renderTo = 'rent_product_list';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }


    /**
     * Add rent product
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       null
     * @return      add rent product view
     */
    public function addRentProducts() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        // set the parameters for rendering view
        $this->data = null;
        $pageTitle = 'Buy Sell Rent | Add Rent Product';
        $renderTo = 'add_rent_products';

        $this->data['product_name'] = array(
            'class' => 'form-control',
            'id' => 'product_name',
            'name' => 'product_name',
            'type' => 'text',
            'placeholder' => 'Product name'
        );

        $this->data['product_shortdescription'] = array(
            'class' => 'form-control',
            'id' => 'short_description',
            'name' => 'short_description',
            'type' => 'text',
            'placeholder' => 'Short description'
        );

        $this->data['product_description'] = array(
            'class' => 'form-control',
            'id' => 'description',
            'name' => 'description',
            'type' => 'text',
            'placeholder' => 'Description'
        );

        $this->data['product_category'] = array(
            'class' => 'form-control',
            'id' => 'product_category',
            'name' => 'product_category',
            'type' => 'text',
            'placeholder' => 'Product Category'
        );

        $this->data['product_quantity'] = array(
            'class' => 'form-control',
            'id' => 'product_quantity',
            'name' => 'product_quantity',
            'type' => 'text',
            'placeholder' => 'Product Quantity'
        );

        $this->data['product_price'] = array(
            'class' => 'form-control',
            'id' => 'product_price',
            'name' => 'product_price',
            'type' => 'text',
            'placeholder' => 'Product price'
        );

        $this->data['product_security_deposite'] = array(
            'class' => 'form-control',
            'id' => 'product_security_deposite',
            'name' => 'product_security_deposite',
            'type' => 'text',
            'placeholder' => 'Security Deposite'
        );

        $this->data['rent_per_month'] = array(
            'class' => 'form-control',
            'id' => 'rent_per_month',
            'name' => 'rent_per_month',
            'type' => 'text',
            'placeholder' => 'Product Rent',
        );

        $this->data['product_sku'] = array(
            'class' => 'form-control',
            'id' => 'product_sku',
            'name' => 'product_sku',
            'type' => 'text',
            'placeholder' => 'Product SKU',
            'onkeyup' => 'checkSKU()'
        );

        $this->data['product_video'] = array(
            'class' => 'form-control',
            'id' => 'product_video',
            'name' => 'product_video',
            'type' => 'text',
            'placeholder' => 'Ex. Id : xxxxxxxxxxx'
        );

        // get all the product selected category
        $this->data['product_category'] = array('0' => 'Select Category') + $this->product_category->dropdown('name');

        // get all the product categories
        $this->data['product_categories'] = $this->rent_product_category->as_array()->get_all();

        // get all the product categories
        $this->data['product_subcategories'] = $this->rent_product_subcategory->as_array()->get_all();

        // get all the product brands
        $this->data['product_brands'] = array('' => 'Select brand') + $this->brands->dropdown('brand_name');

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }


    /**
     * Add product from ajax call
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       null
     * @return      add product
     */
    public function ajaxAddRentProduct() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        
        // get the user id if user is logged in
        if ($this->session->userdata('user_id'))
            $user_id = $this->session->userdata('user_id');
        
        $category_array = array();

        if(!empty($this->input->post('product_category'))) {
            $prefix = $category_list = '';
            foreach ($this->input->post('product_category') as $cat_li) {
                $category_list .= $prefix . $cat_li;
                $prefix = ',';
            }
            // array_push($category_array, $this->input->post('product_category'));
        }

        if(!empty($this->input->post('product_subcategory'))) {
            $subprefix = $subcategory_list = '';
            foreach ($this->input->post('product_subcategory') as $subcat_li) {
                $subcategory_list .= $subprefix . $subcat_li;
                $subprefix = ',';
            }
            // array_push($category_array, $this->input->post('product_subcategory'));
        }

        // set the posted values array
        $product_data_array = array(
            'brand_id' => $this->input->post('product_brands'),
            'product_name' => trim($this->input->post('product_name')),
            'quantity' => trim($this->input->post('product_quantity')),
            'rent' => trim($this->input->post('rent_per_month')),
            'plan' => trim($this->input->post('select_plan')),
            'product_sku' => trim($this->input->post('product_sku')),
            'documents' => trim($this->input->post('documents')),
            'short_description' => trim($this->input->post('short_description')),
            'security_deposite' => trim($this->input->post('product_security_deposite')),
            'product_type' => trim($this->input->post('product_type')),
            'description' => trim($this->input->post('description')),
            'additional_information' => trim($this->input->post('inputPostDescription')),
            'product_video' => (!empty($this->input->post('product_video')) ? trim($this->input->post('product_video')) : ''),
            'createdby' => $user_id,
            'createddate' => date('Y-m-d H:m:s'),
            'modifiedby' => $user_id,
            'modifieddate' => date('Y-m-d H:m:s'),
        );
        
        
        /* file upload */
        if (!empty($_FILES['product_images']['name'][0]) || !empty($_FILES['product_images']['name'][1]) || !empty($_FILES['product_images']['name'][2]) || !empty($_FILES['product_images']['name'][3])) {

            $totalImageUploadCnt = count($_FILES['product_images']['name']);

            $targetDir = "/frontend/assets/images/products/rent_products";
            for ($i = 0; $i < $totalImageUploadCnt; $i++) {
                $fileName = $_FILES['product_images']['name'][$i];
                $targetFile = $targetDir . $fileName;
                $productSlug = 'rent_products';
                $uploded_file_path = $this->handleUpload($productSlug, $_FILES['product_images']['name'][$i], $_FILES['product_images']['tmp_name'][$i]);
                if ($uploded_file_path != '') {
                    $imageData[$i] = 'rent_products' . '/' . ($fileName);
                }
            }

            $product_data_array['image_url'] = json_encode($imageData);
        }
        
        $product_id = $this->rent_product->insert($product_data_array);
        // echo $this->db->last_query(); die;

        $data_subcat_array = array(
            'product_id' => $product_id,
            'category_id' => $category_list,
            'subcategory_id' => $subcategory_list,
        );

        $this->rent_product_cat_subcat_map->insert($data_subcat_array);

        /* End of file upload */
        if($product_id) {
            // set the session message
            $this->session->set_flashdata('message', 'Rent Product added successfully');
            redirect('admin/rent_products');
        } else {
            // set the session message
            $this->session->set_flashdata('message', 'Failed to add the product. Try again');
            redirect('admin/rent_products');
        }
    }


    /**
     * Update rent product
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       null
     * @return      update rent product
     */
    public function ajaxUpdateRentProduct() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        // get the user id if user is logged in
        if ($this->session->userdata('user_id'))
            $user_id = $this->session->userdata('user_id');
        
        $category_array = array();

        if(!empty($this->input->post('product_category'))) {
            $prefix = $category_list = '';
            foreach ($this->input->post('product_category') as $cat_li) {
                $category_list .= $prefix . $cat_li;
                $prefix = ',';
            }
            // array_push($category_array, $this->input->post('product_category'));
        }

        if(!empty($this->input->post('product_subcategory'))) {
            $subprefix = $subcategory_list = '';
            foreach ($this->input->post('product_subcategory') as $subcat_li) {
                $subcategory_list .= $subprefix . $subcat_li;
                $subprefix = ',';
            }
            // array_push($category_array, $this->input->post('product_subcategory'));
        }

        $product_id = trim($this->input->post('product_id'));

        // set the posted values array
        $product_data_array = array(
            'brand_id' => $this->input->post('product_brands'),
            'product_name' => trim($this->input->post('product_name')),
            'quantity' => trim($this->input->post('product_quantity')),
            'rent' => trim($this->input->post('product_rent')),
            'plan' => trim($this->input->post('select_plan')),
            'product_sku' => trim($this->input->post('product_sku')),
            'documents' => trim($this->input->post('documents')),
            'short_description' => trim($this->input->post('short_description')),
            'security_deposite' => trim($this->input->post('product_security_deposite')),
            'product_type' => trim($this->input->post('product_type')),
            'description' => trim($this->input->post('description')),
            'additional_information' => trim($this->input->post('inputPostDescription')),
            'product_video' => (!empty($this->input->post('product_video')) ? trim($this->input->post('product_video')) : ''),
            'createdby' => $user_id,
            'createddate' => date('Y-m-d H:m:s'),
            'modifiedby' => $user_id,
            'modifieddate' => date('Y-m-d H:m:s'),
        );

        
        /* file upload */
        if (isset($_FILES['product_images']) && !empty($_FILES['product_images'])) {

            $json_image_array = json_decode($this->input->post('json_image_array'));

            $totalImageUploadCnt = count($_FILES['product_images']['name']);

            $targetDir = "/frontend/assets/images/rent_products/";
            for ($i = 0; $i < $totalImageUploadCnt; $i++) {
                $fileName = $_FILES['product_images']['name'][$i];

                $targetFile = $targetDir . $fileName;
                $productSlug = $product_id;
                if(!empty($_FILES['product_images']['name'][$i])) {
                    $uploded_file_path = $this->handleRentUpload($productSlug, $_FILES['product_images']['name'][$i], $_FILES['product_images']['tmp_name'][$i]);

                    if ($uploded_file_path != '') {
                        $imageData[$i] = $product_id . '/' . ($fileName);
                    }

                    if(!empty($imageData[$i])) 
                        $json_image_array[$i] = $imageData[$i];
                }
            }

            $product_data_array['image_url'] = json_encode($json_image_array);
        }

        
        $update_result = $this->rent_product->update($product_id, $product_data_array);

        $data_subcat_array = array(
            'product_id' => $product_id,
            'category_id' => $category_list,
            'subcategory_id' => $subcategory_list,
        );        

        /* End of file upload */
        if($this->rent_product_cat_subcat_map->update($product_id, $data_subcat_array)) {
            // set the session message
            $this->session->set_flashdata('message', 'Rent Product updated successfully');
            redirect('admin/rent_products');
        } else {
            // set the session message
            $this->session->set_flashdata('message', 'Failed to update the rent product. Try again');
            redirect('admin/rent_products');
        }
    }

    /**
     * delete product from database
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       (int) $product_id - product id to delete
     * @return      delete product message in response
     */

    public function deleteRentProduct() {

        $product_id = trim($this->input->post('id'));

        // exception handling
        try {

            // check if the product is deleted
            if ($this->rent_product->delete_product($product_id)) {
                $response_array = json_encode(array('status' => '1', 'message' => 'Product deleted successfully'));
                echo $response_array;
                return false;
            } else {
                $response_array = json_encode(array('status' => '0', 'message' => 'Failed to delete the product'));
                echo $response_array;
                return false;
            }
        } catch (Exception $e) {
            $response_array = json_encode(array('status' => '0', 'message' => $e));
            echo $response_array;
            return false;
        }
    }

    /**
     * Edit product page
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       null
     * @return      edit product view
     */
    public function editRentProducts($product_id = NULL) {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $this->data = null;
        $this->data['product_details'] = $this->rent_product->getProductById($product_id);

        // get all the product selected category
        $this->data['product_category'] = array('0' => 'Select Category') + $this->product_category->dropdown('name');

        // get all the product categories
        $this->data['product_categories'] = $this->rent_product_category->as_array()->get_all();

        // get all the product categories
        $this->data['product_subcategories'] = $this->rent_product_subcategory->as_array()->get_all();

        $this->data['product_category_levels'] = $this->rent_product_cat_subcat_map->get_all_product_categories($this->data['product_details'][0]['product_id']);
        

        for ($i = 0; $i < sizeof($this->data['product_category_levels']); $i++) { 
            $this->data['product_category_'.$i] = array($this->data['product_category_levels'][$i]['category_id'] => $this->data['product_category_levels'][$i]['name']) + $this->product_category->dropdown('name');
        }
        
        // get all the product brands
        $this->data['product_brands'] = array($this->data['product_details'][0]['brand_id'] => $this->data['product_details'][0]['brand']) + $this->brands->dropdown('brand_name');

        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Edit Rent Product';
        $renderTo = 'edit_rent_products';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }
    

    /**
     * rent products order list page
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       null
     * @return      rented orders list view
     */
    public function rentOrders() {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $this->data['all_orders'] = $this->orders_summary->getAllRentOrders();

        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | List Rent Orders';
        $renderTo = 'rent_orders';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * pre-order products order list page
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       null
     * @return      pre orders list view
     */
    public function preOrders() {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $this->data['all_orders'] = $this->orders_summary->getAllPreOrders();

        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | List Pre-orders';
        $renderTo = 'pre_orders';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * pre-order details page
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       null
     * @return      pre-detail orders view
     */
    public function pre_order_details($order_id = NULL) {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $this->data['all_orders'] = $this->admin_library->demo_update_order_details($order_id);

        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Order Details';
        $renderTo = 'order_details';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**************** Rent product categories start ******************/
    /**
     * list of product categories
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       $product_id (int)
     * @return      detail product categories
     */
    public function rentProductCategories($product_id = NULL) {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        // fetch all product categories
        $this->data['prodcut_cat_detail'] = $this->rent_product_category->as_array()->get_all();
        
        $this->data['attt_category'] = array('' => 'Select Attribute') + $this->product_category->dropdown('name');
        
        $pageTitle = 'Buy Sell Rent | Rent - Add Category';
        $renderTo = 'rent_product_categories';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }


    /**
     * add category of rent section
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       $product_id (int)
     * @return      success message after add rent category
     */
    public function ajaxAddRentCategory() {

        if (!$this->ion_auth->logged_in() && !$this->ion_auth->is_admin()) {
            // set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '0', 'message' => 'Please login to add the category')); exit;
        } else {

            // get the user id from session
            $user_id = $this->session->userdata('user_id');

            $check_exists = $this->rent_product_category->count_by(array('name' => trim($this->input->post('category_name'))));

            if($check_exists > 0) {
                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '0', 'message' => 'Sub-Category already exists')); exit;
            } else {

                // set the array of parameters
                $data_product_category = array(
                    'name' => trim($this->input->post('category_name')),
                    'description' => trim($this->input->post('category_description')),
                    'createdby' => $user_id,
                    'createddate' => date('Y-m-d H:m:s'),
                );

                $insert_id = $this->rent_product_category->insert($data_product_category);            

                if($insert_id) {
                    // set the response message
                    $this->output->set_header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(array('status' => '1', 'message' => 'Category Added successfully')); exit;
                } else {
                    // set the response message
                    $this->output->set_header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(array('status' => '0', 'message' => 'Failed to process your request')); exit;
                }
            }
        }
    }


    /**
     * edit/update category of rent section
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       $product_id (int)
     * @return      success message of update category
    */
    public function ajaxEditRentCategory() {

        if (!$this->ion_auth->logged_in() && !$this->ion_auth->is_admin()) {
            // set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '0', 'message' => 'Please login to update the category')); exit;
        } else {

            // echo "here i am"; die;
            $cat_id = trim($this->input->post('cat_id'));

            // get the user id from session
            $user_id = $this->session->userdata('user_id');

            $data_category = array(
                'name' => $this->input->post('category_name'),
                'description' => $this->input->post('category_description'),
                'modifiedby' => $user_id,
                'modifieddate' => date('Y-m-d H:m:s'),
            );

            if($this->rent_product_category->update($cat_id, $data_category)) {
                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '1', 'message' => 'Category Updated successfully')); exit;
            } else {
                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '0', 'message' => 'Failed to process your request')); exit;
            }
        }
    }


    /**
    * @author      : Harshal Borse <harshalb@rebelute.com>
    * @date        : 18 Jan 2018
    * @param       : id (int) - id of the record to delete
    * @desc        : delete the category from table
    */
    public function ajaxdeleteRentCategory($id = NULL) {

        // get the posted values of id
        $id = trim($this->input->post('id'));

            // handle the exception here
        try {
                // check if the user is deleted successfully
            if ($this->rent_product_category->delete_cat(trim($id))) {
                    // set the json response array for success message
                $response_array = json_encode(array('status' => '1', 'message' => 'Category deleted successfully'));
                echo $response_array;
                return false;
            } else {
                    // set the json response array failure message
                $response_array = json_encode(array('status' => '0', 'message' => 'Failed to delete the category.'));
                echo $response_array;
                return false;
            }

        } catch (Exception $e) {
                // print the exception if any
            echo $e; die;
        }
    }

    /**************** Rent product categories end ******************/


    /**************** Rent product sub-categories start ******************/
    /**
     * list of product Subcategories
     * @author      Harshal B <harshalb@rebelute.com>
     * @return      detail product Subcategories
     */
    public function rentProductSubCategories() {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        // fetch all product categories
        $this->data['prodcut_cat_detail'] = $this->rent_product_subcategory->as_array()->get_all();

        $this->data['attt_category'] = array('' => 'Select Subcategory') + $this->rent_product_category->dropdown('name');
        
        $pageTitle = 'Buy Sell Rent | Rent - Sub-Category List';
        $renderTo = 'rent_product_subcategories';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }


    /**
     * add Subcategory of rent section
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       $product_id (int)
     * @return      success message after add rent Subcategory
     */
    public function ajaxAddRentSubCategory() {

        if (!$this->ion_auth->logged_in() && !$this->ion_auth->is_admin()) {
            // set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '0', 'message' => 'Please login to add the category')); exit;
        } else {

            // get the user id from session
            $user_id = $this->session->userdata('user_id');

            $check_exists = $this->rent_product_subcategory->count_by(array('name' => trim($this->input->post('category_name'))));

            if($check_exists > 0) {
                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '0', 'message' => 'Sub-Category already exists')); exit;
            } else {

                // set the array of parameters
                $data_product_category = array(
                    'parent_id' => trim($this->input->post('rent_parent_category')),
                    'name' => trim($this->input->post('category_name')),
                    'description' => trim($this->input->post('category_description')),
                    'createdby' => $user_id,
                    'createddate' => date('Y-m-d H:m:s'),
                );

                $insert_id = $this->rent_product_subcategory->insert($data_product_category);            

                if($insert_id) {
                    // set the response message
                    $this->output->set_header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(array('status' => '1', 'message' => 'Sub-Category Added successfully')); exit;
                } else {
                    // set the response message
                    $this->output->set_header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(array('status' => '0', 'message' => 'Failed to process your request')); exit;
                }
            }
        }
    }


    /**
     * edit/update Subcategory of rent section
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       $product_id (int)
     * @return      success message of update Subcategory
    */
    public function ajaxEditRentSubCategory() {

        if (!$this->ion_auth->logged_in() && !$this->ion_auth->is_admin()) {
            // set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '0', 'message' => 'Please login to update the category')); exit;
        } else {

            // echo "here i am"; die;
            $subcat_id = trim($this->input->post('subcat_id'));

            // get the user id from session
            $user_id = $this->session->userdata('user_id');

            $data_category = array(
                'name' => $this->input->post('category_name'),
                'description' => $this->input->post('category_description'),
                'modifiedby' => $user_id,
                'modifieddate' => date('Y-m-d H:m:s'),
            );

            if($this->rent_product_subcategory->update($subcat_id, $data_category)) {
                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '1', 'message' => 'Sub-Category Updated successfully')); exit;
            } else {
                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '0', 'message' => 'Failed to process your request')); exit;
            }
        }
    }


    /**
    * @author      : Harshal Borse <harshalb@rebelute.com>
    * @date        : 18 Jan 2018
    * @param       : id (int) - id of the record to delete
    * @desc        : delete the Subcategory from table
    */
    public function ajaxdeleteRentSubCategory($id = NULL) {

        // get the posted values of id
        $id = trim($this->input->post('id'));

            // handle the exception here
        try {
                // check if the user is deleted successfully
            if ($this->rent_product_subcategory->delete_cat(trim($id))) {
                    // set the json response array for success message
                $response_array = json_encode(array('status' => '1', 'message' => 'Sub-Category deleted successfully'));
                echo $response_array;
                return false;
            } else {
                    // set the json response array failure message
                $response_array = json_encode(array('status' => '0', 'message' => 'Failed to delete the category.'));
                echo $response_array;
                return false;
            }

        } catch (Exception $e) {
                // print the exception if any
            echo $e; die;
        }
    }
    /**************** Rent product sub-categories end ******************/

    public function absolutePath($path = '') {
        $abs_path = str_replace('system/', $path, BASEPATH);
        $abs_path = preg_replace("#([^/])/*$#", "\\1/", $abs_path);
        return $abs_path;
    }

    public function chkBlogName(){
        $post_title = trim($this->input->post('inputName'));
        $arr_details = $this->common_model->getRecords('tbl_mst_blog_posts', 'post_title', array('post_title' => $post_title), $order_by = 'post_id DESC', $limit = '', $debug = 0);
           //echo '<pre>';print_R($arr_details);die;
        if($post_title != '' && count($arr_details) < 1){
            echo 'true';
        }else{
           echo 'false'; 
       }
    }

    public function chkBlogNameEdit(){
        $post_title = trim($this->input->post('inputName'));
        $old_inputName = trim($this->input->post('old_inputName'));
        if($post_title == $old_inputName){
            echo 'true';
        }else{
            $arr_details = $this->common_model->getRecords('tbl_mst_blog_posts', 'post_title', array('post_title' => $post_title), $order_by = 'post_id DESC', $limit = '', $debug = 0);
               //echo '<pre>';print_R($arr_details);die;
            if($post_title != '' && count($arr_details) < 1){
                echo 'true';
            }else{
               echo 'false'; 
           }
       }
    }

    public function chkBlogCategoryName(){
        $post_title = trim($this->input->post('category_name'));
        $arr_details = $this->common_model->getRecords('tbl_mst_categories', 'category_name', array('category_name' => $post_title), $order_by = 'category_id DESC', $limit = '', $debug = 0);
          //echo '<pre>';print_R($arr_details);die;
        if($post_title != '' && count($arr_details) < 1){
           echo 'true';
       }else{
           echo 'false'; 
       }
    }

    public function chkBlogCategoryNameEdit(){
        $post_title = trim($this->input->post('category_name'));
        $old_category_name = trim($this->input->post('old_category_name'));
        if($post_title == $old_category_name){
            echo 'true';
        }else{
            $arr_details = $this->common_model->getRecords('tbl_mst_categories', 'category_name', array('category_name' => $post_title), $order_by = 'category_id DESC', $limit = '', $debug = 0);
              //echo '<pre>';print_R($arr_details);die;
            if($post_title != '' && count($arr_details) < 1){
               echo 'true';
           }else{
               echo 'false'; 
           }
       }
    }

    public function deleteBuyBlog() {
        $post_id = trim($this->input->post('id'));
            // exception handling
        try {

                // check if the product is deleted
            if ($post_id) {
                $id = array($post_id);
                $this->common_model->deleteRows($id, "tbl_mst_blog_posts", "post_id");
                $response_array = json_encode(array('status' => '1', 'message' => 'Blog deleted successfully'));
                echo $response_array;
                return false;
            } else {
                $response_array = json_encode(array('status' => '0', 'message' => 'Failed to delete the blog category'));
                echo $response_array;
                return false;
            }
        } catch (Exception $e) {
            $response_array = json_encode(array('status' => '0', 'message' => $e));
            echo $response_array;
            return false;
        }
    }

    public function deleteBuyBlogCategory() {

        $category_id = trim($this->input->post('id'));

            // exception handling
        try {

                // check if the product is deleted
            if ($category_id) {
                $id = array($category_id);
                $this->common_model->deleteRows($id, "tbl_mst_categories", "category_id");
                $response_array = json_encode(array('status' => '1', 'message' => 'Blog category deleted successfully'));
                echo $response_array;
                return false;
            } else {
                $response_array = json_encode(array('status' => '0', 'message' => 'Failed to delete the blog category'));
                echo $response_array;
                return false;
            }
        } catch (Exception $e) {
            $response_array = json_encode(array('status' => '0', 'message' => $e));
            echo $response_array;
            return false;
        }
    }

    /**
     * Manage footer content
     * @param       string  $pageTitle, string $renderTo, string $viewData
     * @return      renders to list of footer content
     */
    public function manageFooterCMS() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $user_id = $this->session->userdata('user_id');

        $this->data['footer_cms'] = $this->common_model->getRecords('tbl_footer_cms','*');

        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Manage Footer CMS';
        $renderTo = 'admin/footer_cms';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * update footer content
     * @param       string  $pageTitle, string $renderTo, string $viewData
     * @return      renders to list of footer content
     */
    public function updateFooterCMS() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $column_content_1 = trim($this->input->post('column_content_1'));
        $column_content_2 = trim($this->input->post('column_content_2'));
        $column_content_3 = trim($this->input->post('column_content_3'));
        $column_content_4 = trim($this->input->post('column_content_4'));

        // echo $column_content_3; die;

        $cms_id = trim($this->input->post('cms_id'));

        $data_array = array(
            'column_content_1' => $column_content_1,
            'column_content_2' => $column_content_2,
            'column_content_3' => $column_content_3,
            'column_content_4' => $column_content_4,
        );

        if($this->footer_cms->update($cms_id, $data_array)) {
            $this->session->set_flashdata('message', 'Footer CMS content updated successfully');
            redirect('admin/manage_footer', 'refresh');
        }
    }

    /**
     * Manage cms pages content dynamically (Privacy policy, terms & condition, return policy, )
     * @param       string  $pageTitle, string $renderTo, string $viewData
     * @return      renders to list of cms pages
     */
    public function manageCMS() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $user_id = $this->session->userdata('user_id');

        $this->data['section'] = $this->section_model->as_array()->get_all();

        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Manage CMS Pages';
        $renderTo = 'admin/manage_cms';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }


    /**
     * @author : Harshal Borse <harshalb@rebelute.com>
     * @date   : 09 Jan 2018
     * Manage the social links located in footer
     */

    public function manageSocialLinks() {

        // check if user is logged in to the system
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {

            // redirect them to the login page
            redirect('auth/login', 'refresh');

        } else {

            // get the user id from session
            $user_id = $this->session->userdata('user_id');

            // get all the data of user based on user id
            $this->data['dataHeader'] = $this->users->get_allData($user_id);

            // get all the social links
            $this->data['social_list'] = $this->social_links->as_array()->get_all();

            // get all the social links which is not used yet
            $this->data['social_list_disabled'] = $this->social_links->getAllDisabled();

            // set the parameters for rendering view
            $pageTitle = 'Buy Sell Rent | Manage Social Links';
            $renderTo = 'admin/manage_social_links';

            // call the render view function here
            $this->_renders_view($pageTitle, $renderTo, $this->data);
        }
    }

    /**
     * @author : Harshal Borse <harshalb@rebelute.com>
     * @date   : 09 Jan 2018
     * add the social link in list
     */
    public function addSocialLink() {

        if (!$this->ion_auth->logged_in() && !$this->ion_auth->is_admin()) {
            // set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '0', 'message' => 'Please login to add the Social Link')); exit;
        } else {

            // get the posted value of social id
            $social_id = trim($this->input->post('social_id'));
            $social_link = trim($this->input->post('social_link'));

            // set the update array
            $dataUpdateArray = array(
                'status' => '0',
                'link' => $social_link
            );

            if ($this->social_links->update($social_id, $dataUpdateArray)) {
                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '1', 'message' => 'Social Link added successfully')); exit;
            } else {
                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '0', 'message' => 'Failed to process your request')); exit;
            }
        }
    }

    /**
     * @author : Harshal Borse <harshalb@rebelute.com>
     * @date   : 09 Jan 2018
     * update the social links
     */
    public function updateAllSocialLinks() {

        // get the posted values
        $link_array = array();
        $link_array = $this->input->post('link_arry');
        $id_array = $this->input->post('id_arry');

        foreach ($id_array as $key => $value) {
            // get the data in array
            $data_array = array('link' => $link_array[$key]);

            // update multiple rows
            $this->social_links->update($value, $data_array);
        }

        $this->session->set_flashdata("msg", "Social Links are updated successfully");
        redirect('admin/manage_social_links');
    }

    /**
     * @author : Harshal Borse <harshalb@rebelute.com>
     * @date   : 09 Jan 2018
     * delete the social links
     */
    public function deleteSocialLinks() {

        $id = trim($this->input->post('id'));

        // delete the social link by id
        if ($this->social_links->delete($id)) {

            // set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '1', 'message' => 'Social Link deleted successfully')); exit;

        } else {
            // set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '0', 'message' => 'Unable to delete the Social Link. Try again.')); exit;
        }
    }

    /**
     * generate the daily reports of no of orders 
     * @author    : Harshal Borse <harshalb@rebelute.com>
     * @param     : string  $pageTitle, string $renderTo, string $viewData
     * @return    : renders to order table view
     */
    public function dailyReports($start_date = NULL) {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        // check if the start date value is posted
        if($this->input->post('start_date')) {
            $start_date = trim($this->input->post('start_date'));
            $start_date = strtotime(str_replace('/', '-', $start_date));
            $start_date = date('Y-m-d', $start_date);
        }

        $this->data['all_report_detail'] = $this->common_model->getAllDailyReports($start_date);

        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Daily Reports';
        $renderTo = 'daily_reports';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * generate the weekly reports of no of orders 
     * @author    : Harshal Borse <harshalb@rebelute.com>
     * @param     : string  $pageTitle, string $renderTo, string $viewData
     * @return    : renders to order table view
     */
    public function weeklyReports() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $this->data['all_report_detail'] = $this->common_model->getAllWeeklyReports();

        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Weekly Reports';
        $renderTo = 'weekly_reports';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }
    
    /**
     * generate the mpnthly reports of no of orders 
     * @author    : Harshal Borse <harshalb@rebelute.com>
     * @param     : string  $pageTitle, string $renderTo, string $viewData
     * @return    : renders to order table view
     */
    public function monthlyReports() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $this->data['all_report_detail'] = $this->common_model->getAllMonthlyReports();

        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Monthly Reports';
        $renderTo = 'monthly_reports';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * generate the quarter reports of no of orders 
     * @author    : Harshal Borse <harshalb@rebelute.com>
     * @param     : string  $pageTitle, string $renderTo, string $viewData
     * @return    : renders to order table view
     */
    public function quarterlyReports() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $this->data['all_report_detail'] = $this->common_model->getAllQuarterlyReports();

        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Quarterly Reports';
        $renderTo = 'quarterly_reports';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * generate the yearly reports of no of orders 
     * @author    : Harshal Borse <harshalb@rebelute.com>
     * @param     : string  $pageTitle, string $renderTo, string $viewData
     * @return    : renders to order table view
     */
    public function yearlyReports() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $this->data['all_report_detail'] = $this->common_model->getAllYearlyrRports();

        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Yearly Reports';
        $renderTo = 'yearly_reports';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * generate the sales reports of no of orders 
     * @author    : Harshal Borse <harshalb@rebelute.com>
     * @param     : string  $pageTitle, string $renderTo, string $viewData
     * @return    : renders to order table view
     */
    public function salesReport($start_date = NULL) {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        // check if the start date value is posted
        if($this->input->post('start_date')) {
            $start_date = trim($this->input->post('start_date'));
            $start_date = strtotime(str_replace('/', '-', $start_date));
            $start_date = date('Y-m-d', $start_date);
        }

        $this->data['all_report_detail'] = $this->common_model->getAllSalesReports($start_date);

        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Sales Reports';
        $renderTo = 'sales_reports';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * manage the notifications
     * @author    : Harshal Borse <harshalb@rebelute.com>
     * @param     : string  $pageTitle, string $renderTo, string $viewData
     * @return    : notification options
     */
    public function sendOutOfStockNotification()
    {

    }

    /**
     * manage the taxes and its values based on the zipcode
     * @author    : Harshal Borse <harshalb@rebelute.com>
     * @param     : string  $pageTitle, string $renderTo, string $viewData
     * @return    : render the taxes list with zipcode
     */

    public function manageTaxes() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $this->data['all_tax_data'] = $this->tax->get_tax_data();
        $this->data['tax_count'] = $this->tax->count_all();

        /* Ajax Pagination */
        // $config['uri_segment'] = 4;
        // $config['target'] = '#postList';
        // $config['base_url'] = base_url() . 'admin/ajaxPeginationTax';
        // $config['total_rows'] = $this->data['tax_count'];
        // $config['per_page'] = $this->perPage;
        // $config['link_func'] = 'searchTaxFilter';
        // $this->ajax_pagination_product->initialize($config);

        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Manage Taxes';
        $renderTo = 'taxes';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    // function ajaxPeginationTax() {

    //     $page = $this->input->post('page');

    //     if (!$page) {
    //         $offset = 0;
    //     } else {
    //         $offset = $page;
    //     }

    //     $this->data['all_tax_data'] = $this->tax->get_tax_data($offset, $this->perPage);
    //     $this->data['tax_count'] = $this->tax->count_all();

    //     /* Ajax Pagination */
    //     $config['uri_segment'] = 3;
    //     $config['target'] = '#postList';
    //     $config['base_url'] = base_url() . 'admin/ajaxPaginationData';
    //     $config['total_rows'] = $this->data['tax_count'];
    //     $config['per_page'] = $this->perPage;
    //     $config['link_func'] = 'searchTaxFilter';
    //     $this->ajax_pagination_product->initialize($config);
    //     /* Ajax Pagination */

    //     $this->load->view('ajax_tax_view', $this->data, false);
    // }



    public function ajax_list()
    {
        // $list = $this->customers->get_datatables();
        $list = $this->tax->get_datatables();
        
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $customers) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $customers->state;
            $row[] = $customers->zip_code;
            $row[] = $customers->region_name;
            $row[] = $customers->state_rate;
            $row[] = $customers->country_rate;
            $row[] = $customers->city_rate;
            $row[] = $customers->special_rate;
            $row[] = $customers->combined_rate;
            // $row[] = '<button type="button" class="btn btn-default btn-xs btn-success-outline rippler" data-toggle="modal" data-target=""><i class="fa fa-pencil"></i></button>
            //             <button class="btn btn-default btn-xs btn-danger-outline rippler" onclick="deleteTax()"><i class="fa fa-trash"></i></button>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->tax->count_all(),
            "recordsFiltered" => $this->tax->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function clearTaxesData()
    {
        // handle the exception here
        try {
                // check if the user is deleted successfully
            if ($this->tax->clearAllTaxes()) {
                    // set the json response array for success message
                $response_array = json_encode(array('status' => '1', 'message' => 'All records cleared successfully from Taxes table'));
                echo $response_array;
                return false;
            } else {
                    // set the json response array failure message
                $response_array = json_encode(array('status' => '0', 'message' => 'Failed to clear the taxes table data.'));
                echo $response_array;
                return false;
            }

        } catch (Exception $e) {
                // print the exception if any
            echo $e; die;
        }
    }


    // Export data in CSV format 
    public function exportTaxesCSV() {
        // file name 
        $filename = 'Taxes_'.date('Y_m_d').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");

        // get data 
        $usersData = $this->tax->getAllTaxes();       

        // file creation 
        $file = fopen('php://output', 'w');

        $header = array("Id","State","Zipcode","Region", "State Rate", "Country Rate", "City Rate", "Special Rate", "Combined Rate"); 
        fputcsv($file, $header);

        foreach ($usersData as $key => $line) {
            fputcsv($file,$line); 
        }

        fclose($file); 
        exit; 
    }



    public function importTaxesCSV()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        // $this->data = file_get_contents($_FILES['import_product_file']);

        $fp = fopen($_FILES['import_taxes_file']['tmp_name'],'r') or redirect("admin/taxes");

        // $this->data['csv_content'] = array();
        $attribute_array = array();

        // $line = fgetcsv($fp);
        while(($line = fgetcsv($fp)) !== FALSE)
        {
            $data = array(
                'state'=> $line[0],
                'zip_code' => $line[1],
                'region_name' => $line[2],
                'state_rate' => $line[3],
                'country_rate' => $line[5],
                'city_rate' => $line[6],
                'special_rate' => $line[7],
                'combined_rate' => $line[4],
            );
            
            $data['uploaded_records'] = $this->db->insert('tbl_tax_rates', $data);            
        }

        // set the flash message for success
        $this->session->set_flashdata('message', 'Taxes imported successfully');

        // redirect them to the login page
        redirect('admin/taxes', 'refresh');
    }


    /**
     * change status of the order from backend
     * @author      Harshal Borse <harshalb@rebelute.com>
     * @param       null
     * @return      json response array of success or failure
     */
    public function changeOrderStatus()
    {
        $status = trim($this->input->post('status'));
        $order_id = trim($this->input->post('order_id'));

        // handle the exception here
        try {
            // check if the user is deleted successfully
            if ($this->orders_summary->changeOrderStatus($status, $order_id)) {

                // send the notification email when 
                $message = 'Hi User,<br><br>';
                $message .= 'Your order status has been changed<br><br><hr>';
                $message .= 'Order Id : #'.$order_id.'<br><br>';
                $message .= '<hr>Buy Sell Rent Team<br><br>';
                $subject = 'Buy Sell Rent - Order Status Changed';

                // $this->email($this->input->post('email'), $message, $subject);
                $this->common_model->sendEmail('harshalb@rebelute.com', $message, $subject);

                // set the json response array for success message
                $response_array = json_encode(array('status' => '1', 'message' => 'Order status updated successfully'));
                echo $response_array;
                return false;
            } else {
                    // set the json response array failure message
                $response_array = json_encode(array('status' => '0', 'message' => 'Failed to update the order status.'));
                echo $response_array;
                return false;
            }

        } catch (Exception $e) {
                // print the exception if any
            echo $e; die;
        }
    }

    /**
     * highlight product list page
     * @author : Ranjit Pasale <ranjitp@rebelute.com>
     * @param       null
     * @return      highlight product list view
     */
    public function highlight_products() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $user_id = $this->session->userdata('user_id');

        // $this->data['dataHeader'] = $this->users->get_allData($user_id);
        // $this->data['product_details_count'] = $this->product->count_by(array('id'));

        $this->data['highlighted_product_details'] = $this->product->get_highlighted_products();        

        foreach ($this->data['highlighted_product_details'] as $key => $value)
            $this->data['highlighted_product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['product_id']);

        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Highlight Product List';
        $renderTo = 'highlight_product_list';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }


    public function dow_products() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $user_id = $this->session->userdata('user_id');

        // $this->data['dataHeader'] = $this->users->get_allData($user_id);
        // $this->data['product_details_count'] = $this->product->count_by(array('id'));

        $this->data['dow_product_details'] = $this->product->get_dow_products();        

        foreach ($this->data['dow_product_details'] as $key => $value)
            $this->data['dow_product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['product_id']);

        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Deal of the week Product List';
        $renderTo = 'dow_product_list';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }


    public function landing_page_slider_cms() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $user_id = $this->session->userdata('user_id');

        $site_settings_array = $this->common_model->getRecords('tbl_site_settings','*');
        $login_slider = $this->common_model->getRecords('tbl_site_settings','*',array('type_id' => 2));
        
        foreach ($site_settings_array as $site_array) {
            $site_settings[$site_array['field_key']] = $site_array['field_output_value'];
        }

        $this->data['site_settings'] = $site_settings;
        $this->data['login_slider'] = $login_slider;

        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Highlight Product List';
        $renderTo = 'landing_page_slider_cms';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }


    public function update_landing_page_cms() {

        $this->load->library('upload');
        // if(!empty($_FILES['headerBanner']['name'])){

        // $ss_insert['site_title']=$this->input->post('siteTitle');
        $ss_insert = array();

        $file_name = time() .rand();
        $filecount = 1;
        $config = array('upload_path'=>'backend/assets/img/',
            'allowed_types'=>'gif|jpg|png|jpeg',
            'remove_spaces'=>TRUE,
            'encrypt_name'=>TRUE,
            'overwrite'=>FALSE
        );

        if(!empty($_FILES['headerBanner']['name'])) {
            /*$config['file_name'] = $file_name.$filecount;
            $filecount++;
            $this->upload->initialize($config);

            if($this->upload->do_upload('headerBanner')) {
                $sl_upload_result = $this->upload->data();
                $ss_insert['header_banner']=$sl_upload_result['file_name'];
            } else {
                $error['header_banner'] = $this->upload->display_errors();
            }*/

            $ss_insert['header_banner'] = $this->resize('backend/assets/img/',$_FILES['headerBanner'],847,190);


        } else {
            $ss_insert['header_banner'] = '';
        }

        if(!empty($_FILES['footerBanner']['name'])) {

            /*$config['file_name'] = $file_name.$filecount;
            $filecount++;
            $this->upload->initialize($config);

            if($this->upload->do_upload('footerBanner')) {
                $sl_upload_result = $this->upload->data();
                $ss_insert['footer_banner'] = $sl_upload_result['file_name'];                
            } else {
                $error['footer_banner'] = $this->upload->display_errors();
            }*/
            
            $ss_insert['footer_banner'] = $this->resize('backend/assets/img/',$_FILES['footerBanner'],847,190);

        } else {
            $ss_insert['footer_banner'] = '';
        }

        $this->db->where(array('type_id' => 2));
        $slider_count = $this->db->count_all_results('tbl_site_settings');

        for($i = 1;$i <= $slider_count;$i++) {

            $login_slider = 'login_slider'.$i;

            if(!empty($_FILES[$login_slider]['name'])) {

                /*$config['file_name'] = $file_name.$filecount;
                $filecount++;
                $this->upload->initialize($config);

                if($this->upload->do_upload($login_slider)) {
                    $sl_upload_result = $this->upload->data();
                    $ss_insert[$login_slider] = $sl_upload_result['file_name'];
                } else {
                   $error[$login_slider] = $this->upload->display_errors();
               }*/

                $ss_insert[$login_slider] = $this->resize('backend/assets/img/',$_FILES[$login_slider],1920,610);

            } else {
                $ss_insert[$login_slider] = '';
            }
         }

         $result['status'] = 1;
         $result['msg'] = "Site settings updated";

         foreach($ss_insert as $key => $value) {
            $label1_key = 'label1_'.$key;
            $label2_key = 'label2_'.$key;
            $label3_key = 'label3_'.$key;
            $label4_key = 'label4_'.$key;
            $link_key = 'link_'.$key;

            if($value == "") {
                $update_array = array('label1'=>$this->input->post($label1_key),'label2'=>$this->input->post($label2_key),'label3'=>$this->input->post($label3_key),'label4' => $this->input->post($label4_key),'link'=>$this->input->post($link_key));

                $update[$key] = $this->common_model->updateRow('tbl_site_settings', $update_array,array('field_key'=>$key));

                if($update[$key]){
                    $result['status'] = 1;
                    $result['msg'] = "Site settings updated";
                } elseif ($error) {
                    $result['status'] = 0;
                    $result['msg'] = "Failed to upload site settings";
                }
            } else {
                $update_array = array('field_output_value' => $value,'label1'=>$this->input->post($label1_key),'label2'=>$this->input->post($label2_key),'label3'=>$this->input->post($label3_key),'label4' => $this->input->post($label4_key),'link'=>$this->input->post($link_key));

                $update[$key]=$this->common_model->updateRow('tbl_site_settings', $update_array,array('field_key'=>$key));

                if($update[$key]){
                    $result['status'] = 1;
                    $result['msg'] = "Site settings updated";
                } elseif ($error) {
                    $result['status'] = 0;
                    $result['msg'] = "Failed to upload site settings";
                }
            }
        }

        $this->session->set_flashdata('message', $result['msg']);
        redirect('admin/landing_page_slider_cms');
    }

    /**
    * add coupons view in admin backend
    * @param int $width
    */
    public function addCoupon() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $this->data['coupon_type'] = array('' => 'Select Type') + $this->coupon_category->dropdown('disc_type');
        $this->data['coupon_method'] = array('' => 'Select method') + $this->coupon_method->dropdown('disc_method');
        $this->data['coupon_method_tax'] = array('' => 'Select method tax') + $this->coupon_method_tax->dropdown('disc_tax_method');
        $this->data['coupon_group'] = array('' => 'Select group') + $this->coupon_group->dropdown('disc_group');
        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');

        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Add Coupon';
        $renderTo = 'add_coupon';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
    * Image resize
    * @param int $width
    * @param int $height
    */
    public function resize($path,$fileobj,$width, $height) {
        
        /* Get original image x y*/
        list($w, $h) = getimagesize($fileobj['tmp_name']);
        
        /* calculate new image size with ratio */
        $ratio = max($width/$w, $height/$h);
        $h = ceil($height / $ratio);
        $x = ($w - $width / $ratio) / 2;
        $w = ceil($width / $ratio);
        
        /* new file name */
        $new_img_name=$width.'x'.$height.'_'.$fileobj['name'];
        $path = $path.$new_img_name;
        
        /* read binary data from image file */
        $imgString = file_get_contents($fileobj['tmp_name']);
        
        /* create image from string */
        $image = imagecreatefromstring($imgString);
        $tmp = imagecreatetruecolor($width, $height);
        imagealphablending($tmp, false );
        imagesavealpha($tmp, true );
        imagecopyresampled($tmp, $image,0, 0,$x, 0,$width, $height,$w, $h);

        /* Save image */
        switch ($fileobj['type']) {
            case 'image/jpeg':
                imagejpeg($tmp, $path, 100);
                break;
            case 'image/png':
                imagepng($tmp, $path, 0);
                break;
            case 'image/gif':
                imagegif($tmp, $path);
                break;
            default:
                exit;
                break;
        }

        // return $path;
        return $new_img_name;
        
        /* cleanup memory */
        imagedestroy($image);
        imagedestroy($tmp);
    }


    /**
    * @author      : Harshal Borse <harshalb@rebelute.com>
    * @date        : 28 Dec 2017
    * @desc        : check if the sku number is already used
    */
    public function validateSKUNumber() {

        $sku_number = $this->input->post('sku_number');

        // check if the email is is already in subscription list
        $get_record = $this->product->get_by(array('product_sku' => $sku_number));            

        // check if email id is already exists
        if (count($get_record) >= 1) {
            // return false;
            // echo json_encode(array(
            //     'valid' => false,
            // ));
            // set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '0', 'message' => 'SKU number already exists')); exit;

        } else {
            // echo json_encode(array(
            //     'valid' => true,
            // ));
            // return true;
            // set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '1', 'message' => 'You can use this SKU number')); exit;
        }
    }

    /**
    * @author      : Harshal Borse <harshalb@rebelute.com>
    * @date        : 28 Dec 2017
    * @desc        : newsletter list of all subscribed users
    */
    public function newsletter() {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        // get the user id from session
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        
        $this->data['newsletter_list'] = $this->newsletter->as_array()->get_all();

        $pageTitle = 'Buy Sell Rent | Newsletter';
        $renderTo = 'newsletter';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
    * @author      : Harshal Borse <harshalb@rebelute.com>
    * @date        : 29 Dec 2017
    * @desc        : newsletter email send to all subscribed users
    */
    public function send_newsletter() {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $subject = $this->input->post('email_subject');
        $content = $this->input->post('email_content');

        // get the user id from session
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        
        $this->data['newsletter_list'] = $this->newsletter->as_array()->get_all();
        
        foreach ($this->data['newsletter_list'] as $value) {

            $email_id = $value['email'];

            // send the newsletter email to subscribed users
            $message = $content;
            $subject = 'Buy Sell Rent - '.$subject;

            // $this->email($this->input->post('email'), $message, $subject);
            $this->common_model->sendEmail($email_id, $message, $subject);

        }

        // set the response message
        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array('status' => '1', 'message' => 'Newsletter has been sent successfully')); exit;
                
        // set the session message
        // $this->session->set_flashdata('message', 'Newsletter has been sent successfully');
        // redirect('admin/newsletter');
    }

    /**
    * @author      : Ranjit Pasale <ranjitp@rebelute.com>
    * @date        : 19 Dec 2017
    * @desc        : Edit Highlight Product view
    */
    public function editHighlightedProduct($product_id = NULL) {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }
        
        // set the parameters for rendering view
        $this->data = null;
        $pageTitle = 'Buy Sell Rent | Edit Highlighted Product';
        $renderTo = 'admin/edit_highlight_products';

        // fetch all product categories
        $this->data['highlighted_product_details'] = $this->product->as_array()->get_highlighted_product_details($product_id);
        
        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);   
    }



    public function editDOWProduct($product_id = NULL) {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        // set the parameters for rendering view
        $this->data = null;
        $pageTitle = 'Buy Sell Rent | Edit Highlighted Product';
        $renderTo = 'admin/edit_dow_products';

        // fetch all product categories
        $this->data['dow_product_details'] = $this->product->as_array()->get_dow_product_details($product_id);
        
        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);   
    }



    public function updateHighlightedProduct() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        if ($this->session->userdata('user_id'))
            $user_id = $this->session->userdata('user_id');

        $highlighted_product_id = trim($this->input->post('highlighted_product_id'));
        $product_id = trim($this->input->post('product_id'));

        // echo $highlighted_product_id; die;

        // File upload
        $imageData="";
        if (!empty($_FILES['highlight_product_image']['name'])) {
            $totalImageUploadCnt = count($_FILES['highlight_product_image']['name']);

            $targetDir = "/frontend/assets/images/";

            $fileName = $_FILES['highlight_product_image']['name'];
            $targetFile = $targetDir . $fileName;
            $productSlug = 'highlighted_products/'.$highlighted_product_id;
            $uploded_file_path = $this->handleUpload($productSlug, $_FILES['highlight_product_image']['name'], $_FILES['highlight_product_image']['tmp_name']);

            if ($uploded_file_path != '') {
                $imageData = $highlighted_product_id . '/' . ($fileName);
            }
        }

        $dataUpdate= array(
            'sale_type' => $this->input->post('sale_type'),
            'product_title' => $this->input->post('product_title'),
            'price' => $this->input->post('product_price')
        );

        if($imageData!=""){
            $dataUpdate['img_url']=$imageData;
        }else{
            // $dataUpdate['img_url']='banner-img4.jpg';
        }

        // echo "<pre>"; print_r($dataUpdate); die();

        $this->product->update_highlighted_product_details($product_id,$highlighted_product_id, $dataUpdate);

        // set the session message
        $this->session->set_flashdata('message', 'Highlight Products Details updated successfully');
        redirect('admin/highlight_products');
    }

    public function updatedowProduct() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        if ($this->session->userdata('user_id'))
            $user_id = $this->session->userdata('user_id');

        $dow_product_id = trim($this->input->post('dow_product_id'));

        $dataUpdate= array(
            'start_date_time' => $this->input->post('start_date_time'),
            'end_date_time' => $this->input->post('end_date_time')
        );

        if($this->product->update_dow_product_details($dow_product_id, $dataUpdate)) {
            // set the session message
            $this->session->set_flashdata('message', 'Deals of the Week - Products Details updated successfully');
            redirect('admin/dow_products');
        } else {
            // set the session message
            $this->session->set_flashdata('error', 'Deals of the Week - Failed to update the Products Details');
            redirect('admin/dow_products');
        }
    }


    public function deleteHighlightedProduct() {

        $product_id = trim($this->input->post('product_id'));

        // exception handling
        try {

            // check if the product is deleted
            if ($this->product->remove_highlighted_product($product_id)) {
                $response_array = json_encode(array('status' => '1', 'message' => 'Highlighted Product removed successfully'));
                echo $response_array;
                return false;
            } else {
                $response_array = json_encode(array('status' => '0', 'message' => 'Failed to remove the highlighted product'));
                echo $response_array;
                return false;
            }
        } catch (Exception $e) {
            $response_array = json_encode(array('status' => '0', 'message' => $e));
            echo $response_array;
            return false;
        }
    }


    public function deleteDowProduct() {

        $product_id = trim($this->input->post('product_id'));

        // exception handling
        try {

            // check if the product is deleted
            if ($this->product->remove_dow_product($product_id)) {
                $response_array = json_encode(array('status' => '1', 'message' => 'Deals of the week Product removed successfully'));
                echo $response_array;
                return false;
            } else {
                $response_array = json_encode(array('status' => '0', 'message' => 'Failed to remove the Deals of the week product'));
                echo $response_array;
                return false;
            }
        } catch (Exception $e) {
            $response_array = json_encode(array('status' => '0', 'message' => $e));
            echo $response_array;
            return false;
        }
    }



    public function markAsHighlightedProduct() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        // exception handling
        try {

            if ($this->session->userdata('user_id'))
                $user_id = $this->session->userdata('user_id');

            $highlighted_product_id = trim($this->input->post('highlighted_product_id'));


            if($this->input->post('add_remove_flag')==1){
                $insertData= array(
                    'product_id' => $highlighted_product_id,
                    'sale_type' => $this->input->post('sale_type'),
                    'product_title' => $this->input->post('product_title'),
                    'price' => $this->input->post('price'),
                    'img_url' => $this->input->post('img_url')
                );

                if ($this->product->mark_as_highlighted_product($highlighted_product_id,$insertData)) {
                    $response_array = json_encode(array('status' => '1', 'message' => 'Product marked as Highlighted Product'));
                    echo $response_array;
                    return false;
                } else {
                    $response_array = json_encode(array('status' => '0', 'message' => 'Failed to mark the highlighted product'));
                    echo $response_array;
                    return false;
                }
            }else{
                if ($this->product->remove_highlighted_product($highlighted_product_id)) {
                    $response_array = json_encode(array('status' => '1', 'message' => 'Product removed from Highlighted Product List'));
                    echo $response_array;
                    return false;
                } else {
                    $response_array = json_encode(array('status' => '0', 'message' => 'Failed to remove from highlighted products'));
                    echo $response_array;
                    return false;
                }
            }

        } catch (Exception $e) {
            $response_array = json_encode(array('status' => '0', 'message' => $e));
            echo $response_array;
            return false;
        }

    }

    public function markAsDOW() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        // exception handling
        try {

            if ($this->session->userdata('user_id'))
                $user_id = $this->session->userdata('user_id');

            $dow_product_id = trim($this->input->post('dow_product_id'));

            $start_date=date('Y-m-d H:i:s');
            $end_date=date('Y-m-d H:i:s',strtotime('next Sunday'));

            if($this->input->post('add_remove_flag')==1){
                $insertData=array('start_date_time'=>$start_date,'end_date_time'=>$end_date,'product_id'=>$dow_product_id);

                if ($this->product->mark_as_dow_product($dow_product_id,$this->input->post('add_remove_flag'),$insertData)) {
                    $response_array = json_encode(array('status' => '1', 'message' => 'Product marked as Deal of Week Product'));
                    echo $response_array;
                    return false;
                } else {
                    $response_array = json_encode(array('status' => '0', 'message' => 'Failed to mark the Deal of Week product'));
                    echo $response_array;
                    return false;
                }
            }else{
                if ($this->product->remove_dow_product($dow_product_id)) {
                    $response_array = json_encode(array('status' => '1', 'message' => 'Product removed from Deals of the week Product List'));
                    echo $response_array;
                    return false;
                } else {
                    $response_array = json_encode(array('status' => '0', 'message' => 'Failed to remove from Deals of the week products'));
                    echo $response_array;
                    return false;
                }
            }
        } catch (Exception $e) {
            $response_array = json_encode(array('status' => '0', 'message' => $e));
            echo $response_array;
            return false;
        }

    }

    public function markAsOS() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        // exception handling
        try {

            if ($this->session->userdata('user_id'))
                $user_id = $this->session->userdata('user_id');

            $os_product_id = trim($this->input->post('os_product_id'));

            if ($this->product->mark_as_os_product($os_product_id,$this->input->post('add_remove_flag'))) {
                $response_array = json_encode(array('status' => '1', 'message' => 'Product marked as On Sale Product'));
                echo $response_array;
                return false;
            } else {
                $response_array = json_encode(array('status' => '0', 'message' => 'Failed to mark the On Sale product'));
                echo $response_array;
                return false;
            }

        } catch (Exception $e) {
            $response_array = json_encode(array('status' => '0', 'message' => $e));
            echo $response_array;
            return false;
        }

    }

    /**
     * get the data for bar chart on dashboard
     * @author    : Harshal Borse <harshalb@rebelute.com>
     * @param     : string  $pageTitle, string $renderTo, string $viewData
     * @return    : renders to view
     */
    public function getMonthlyOrdersChartData() {

        // check if the user is logged in and user is admin
        if (!$this->ion_auth->logged_in()) {
            redirect('auth', 'refresh');            
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        // get the records of orders for each month and populate it in to the bar chart
        $this->db->select('count(*) as count, DATE_FORMAT(ord_date, "%m") as month');
        $this->db->group_by('DATE_FORMAT(ord_date, "%m")');
        $this->db->where('YEAR(ord_date) = YEAR(CURRENT_DATE)');
        $get_result = $this->db->get('order_summary');
        $response = $get_result->result_array();        

        // define the static array of the months
        $month_array = array('01','02','03','04','05','06','07','08','09','10','11','12');

        // define the empty arrays
        $date_convert_arry = array();
        $data = array();

        // loop through the each entry in response array
        foreach ($month_array as $key => $date_con_arr) {            
            foreach ($response as $k => $v) {               
                if($v['month'] == $date_con_arr) {
                    $data[$key] = $v['count'];
                }
            }          
        }

        for ($i = 0; $i < 12; $i++) { 
            if(!isset($data[$i])) {
                $data[$i] = '0';
            }
        }   

        // sort the resopnse array by its key
        ksort($data);
        // encode the array in json
        echo json_encode(array("response" => $data)); exit;
    }


    /**
     * Render views
     *
     * @param       string  $pageTitle, string $renderTo, string $viewData
     * @return      renders to view
     */
    public function _renders_view($pageTitle, $renderTo, $viewData) {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        if (!$this->ion_auth->is_admin()) {
            redirect('/', 'refresh');
        }

        $user_id = $this->session->userdata('user_id');

        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');

        $this->data['page_title'] = $pageTitle;
        // set master template
        $this->template->set_master_template('back_template.php');
        $this->template->write_view('top_header', 'back_snippets/top_header', $this->data);
        $this->template->write_view('sidebar', 'back_snippets/sidebar', $this->data);
        $this->template->write_view('content', $renderTo, $viewData);
        $this->template->write_view('footer', 'back_snippets/footer', $this->data);
        $this->template->render();
    }

    public function get_json() {

        $json = file_get_contents('php://input');
        $json_decode = json_decode($json);
        echo "<pre>";
        print_r((array)$json_decode);
        echo $json;
        // print_r(json_decode($_POST));
        die;
    }
}
