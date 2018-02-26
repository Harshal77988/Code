<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->language(array('product_lang'));
        $this->perPage = 10;

        /* Load Backend model */
        $this->load->model(array('users', 'group_model', 'pattribute', 'pattribute_sub'));
        $this->load->model(array('product_category', 'product_sub_category', 'orders_summary'));

        /* Load Master model */
        $this->flexi = new stdClass;

        $this->load->library('flexi_cart');

        /* Load Product model */
        $this->load->model(array('product_attribute', 'product'));

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
        $pageTitle = 'Buy Rent Sell';
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
        $pageTitle = 'Buy Rent Sell | Product List';
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
        $pageTitle = 'Buy Rent Sell | Add Product';
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
            'placeholder' => 'Product SKU'
        );

        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');

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

        $this->data['product_details'] = $this->product->getProductById($product_id);
        $this->data['product_details']['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($product_id);

        // set the parameters for rendering view
        // $this->data = null;
        $pageTitle = 'Buy Rent Sell | Edit Product';
        $renderTo = 'edit_products';

        $this->data['product_category'] = $this->product_category->dropdown('name');

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
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

        // set the posted values array
        $product_data_array = array(
            'product_name' => trim($this->input->post('product_name')),
            'product_is_feature' => ($this->input->post('is_feature') == 'on' ? '1': '0'),
            'discounted_price' => trim($this->input->post('product_discounted_price')),
            'category_id' => trim($this->input->post('product_category')),
            'quantity' => trim($this->input->post('product_quantity')),
            'price' => trim($this->input->post('product_price')),
            'product_sku' => trim($this->input->post('product_sku')),
            'short_description' => trim($this->input->post('short_description')),
            'description' => trim($this->input->post('description')),
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

                        // echo "<hr /><h1>DEBUG</h1><pre>";
                        // print_r($dataProductAttributeArray);
                        // echo "</pre>";
                        // die();
                        
                        // if ($uploded_file_path != '') {
                        //     $dataProductImagesArray = array(
                        //         'product_id' => $productId,
                        //         'uploded_by' => $user_id,
                        //         'url' => $uploded_file_path,
                        //         'type' => $_FILES['attr_file_' . $attr_sub_data['attribute_id'] . '_' . $attr_sub_data['id']]['type'],
                        //         'is_wheel_plugin' => 1,
                        //         'createdby' => $user_id,
                        //         'createddate' => date('Y-m-d H:m:s'),
                        //     );
                        //     $this->product_images->insert($dataProductImagesArray);
                        // }
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

                                // echo "<hr /><h1>DEBUG</h1><pre>";
                                // print_r($dataProductAttributeArray);
                                // echo "</pre>";
                                // die();
                                
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

                                // echo "<hr /><h1>DEBUG</h1><pre>";
                                // print_r($dataProductAttributeArray);
                                // echo "</pre>";
                                // die();

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
            $this->session->set_flashdata('success', 'Product added successfully');
            redirect('admin/products');
        } else {

        }
    }

    public function getAttributes() {
            
        $product_category_id = $this->input->post('product_category_id');

        $this->data['prodcut_cat_detail'] = $this->product_sub_category->get_product_sub_attribute($product_category_id);

        foreach ($this->data['prodcut_cat_detail'] as $key => $dataAtt) {
            $this->data['prodcut_cat_detail'][$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
        }

        $this->data['prodcut_cat_detail'];
        $attribute_view = $this->load->view('_div_attributes', $this->data, TRUE);

        echo json_encode(array('content' => $attribute_view));
        die;
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

        $product_id = trim($this->input->post('product_id'));

        // set the posted values array
        $product_data_array = array(
            'product_name' => trim($this->input->post('product_name')),
            'product_is_feature' => ($this->input->post('is_feature') == 'on' ? '1': '0'),
            'discounted_price' => trim($this->input->post('product_discounted_price')),
            'category_id' => trim($this->input->post('product_category')),
            'quantity' => trim($this->input->post('product_quantity')),
            'price' => trim($this->input->post('product_price')),
            'product_sku' => trim($this->input->post('product_sku')),
            'short_description' => trim($this->input->post('short_description')),
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
        
        /* End of file upload */
        if($this->product->update($product_id, $product_data_array)) {
            // set the session message
            $this->session->set_flashdata('success', 'Product added successfully');
            redirect('admin/products');
        } else {
            // set the session message
            $this->session->set_flashdata('success', 'Failed to update the Product');
            redirect('admin/products');
        }
    }

    /**
    * @author      : Harshal Borse <harshalb@rebelute.com>
    * @date        : 22 Nov 2017
    * @param       : id (int) - id of the record to delete
    * @desc        : delete the category from table
    */
    public function ajaxdeleteBuyCategory($id = NULL)
    {
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
        $pageTitle = 'Buy Rent Sell | Add Attribute';
        $renderTo = 'admin/add_buy_attribute';

        $this->data['product_category'] = $this->product_category->dropdown('name');

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
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
                'is_brand' => $this->input->post('is_brand'),
                'createdby' => $user_id,
                'createddate' => date('Y-m-d H:m:s'),
            );

        } else {
            $dataAttributeArray = array(
                'attrubute_value' => $this->input->post('attribute_value'),
                'is_brand' => $this->input->post('is_brand'),
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


        $data_sub_cat_arry = array(
            'p_category_id' => $parent_id,
            'p_sub_category_id' => $insertAttrId,
            'createdby' => $user_id,
            'createddate' => date('Y-m-d H:m:s'),
            'modifieddate' => date('Y-m-d H:m:s'),
            'modifiedby' => $user_id,
            'isactive' => '0'
        );

        $this->product_sub_category->insert($data_sub_cat_arry);            
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

            $this->session->set_flashdata("msg", "Attribute Added successfully");
            redirect('admin/buy_attributes');
        }
    }

    /**
    * @author      : Harshal Borse <harshalb@rebelute.com>
    * @date        : 22 Nov 2017
    * @param       : id (int) - id of the record to delete
    * @desc        : delete the attribute from table
    */
    public function ajaxdeleteBuyAttribute()
    {
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
        $pageTitle = 'Buy Rent Sell | List Orders';
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

        echo "<hr /><h1>DEBUG</h1><pre>";
        print_r($this->data);
        echo "</pre>";
        die();

        // set the parameters for rendering view
        $pageTitle = 'Buy Rent Sell | Order Details';
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

        
        $this->data['attt_category'] = array('' => 'Select Attribute') + $this->pattribute->dropdown('attrubute_value');
        // $this->data['attt_category'] = array('' => 'Select Attribute') + $this->pattribute_sub->dropdown('attrubute_value');

        $pageTitle = 'Buy Sell Rent | Buy - Add Category';
        $renderTo = 'buy_product_categories';

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

            if ($product_sub_cat != 0) {
                $product_sub_cat_array['p_sub_category_id'] = $product_sub_cat;
                $inserted_sub = $this->product_sub_category->insert($product_sub_cat_array);
            }
            // foreach ($product_sub_cat as $key => $subData) {
            //     if ($product_sub_cat[$key] != 0) {
            //         $product_sub_cat_array['p_sub_category_id'] = $product_sub_cat[$key];
            //         $inserted_sub = $this->product_sub_category->insert($product_sub_cat_array);
            //     }
            // }

            if($inserted_sub) {
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
        
        if (!$this->ion_auth->logged_in()) {
            // set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '0', 'message' => 'Please login to update the category')); exit;
        } else {

            // echo "here i am"; die;
            // get the user id from session
            $user_id = $this->session->userdata('user_id');

            $data_category = array(
                'name' => $this->input->post('category_name'),
                'description' => $this->input->post('category_description_' . $pId),
                'modifiedby' => $user_id,
                'modifieddate' => date('Y-m-d H:m:s'),
            );

            $this->product_category->update($pId, $data_category);

            $this->product_sub_category->delete_sub_cat($pId);

            $productSubCat = $this->input->post('parent_id');
            $productSubCat = array_unique($productSubCat);

            $data_sub_category = array(
                'p_category_id' => $pId,
                'modifiedby' => $user_id,
                'modifieddate' => date('Y-m-d H:m:s'),
            );

            foreach ($productSubCat as $key => $subData) {
                if ($productSubCat[$key] != 0) {
                    $data_sub_category['p_sub_category_id'] = $productSubCat[$key];
                    $this->product_sub_category->insert($data_sub_category);
                }
            }

            if($inserted_sub) {
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
        $this->data['attribute_details'] = $this->pattribute->as_array()->get_all();
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
     * common function for product image upload
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       null
     * @return      detail orders view
     */
    public function handleUpload($slug, $upFileName, $upFileTmpName) {

        $fileTypes = array('jpeg', 'png', 'jpg'); // File extensions
        $fileParts = pathinfo($upFileName);
        
        if (!in_array(strtolower($fileParts['extension']), $fileTypes)) {
            $this->session->set_flashdata('msg', 'File type not supported.');
            return false;
        }

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
     * Render views
     *
     * @param       string  $pageTitle, string $renderTo, string $viewData
     * @return      renders to view
     */
    public function _renders_view($pageTitle, $renderTo, $viewData) {

        $user_id = $this->session->userdata('user_id');
        $this->data['page_title'] = $pageTitle;
        // set master template
        $this->template->set_master_template('back_template.php');
        $this->template->write_view('top_header', 'back_snippets/top_header', $this->data);
        $this->template->write_view('sidebar', 'back_snippets/sidebar', $this->data);
        $this->template->write_view('content', $renderTo, $viewData);
        $this->template->write_view('footer', 'back_snippets/footer', $this->data);
        $this->template->render();
    }

}
