<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'libraries/Stripe/lib/Stripe.php');

/**
 * Home Controller Class for home page
 *
 * @category    Front-end Management
 * @author      Mayur Vachchewar <mayurv@rebelute.com>, Harshal Borse <harshalb@rebelute.com>
 * @copyright   Copyright (c) 2017, http://rebelute.com/
 *
 */
class Home extends MY_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->database();

        $this->CI = & get_instance();
        // $this->load->library(array('USPS/demos/zipcodelookup'));

        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->language(array('product_lang'));
        $this->load->library('pagination');
        // $this->load->library('usps');
        $this->load->library('Ajax_pagination');
        $this->perPage = 16;

        /* Load Backend model */
        $this->load->model(array('users', 'contact', 'group_model', 'pattribute', 'pattribute_sub', 'payment', 'demo_cart_model', 'common_model', 'newsletter', 'blog_comment', 'blog_tags'));
        $this->load->model(array('product_category', 'product_sub_category', 'wishlist', 'Blog_model', 'country', 'state', 'orders_summary', 'addresses', 'review_model', 'product_sub_category_map', 'footer_cms', 'social_links', 'rent_product', 'rent_product_category', 'rent_product_subcategory', 'rent_review_model', 'coupon', 'tax', 'out_of_stock_notify'));

        // include the paypal payment gateway library
        $this->load->library('paypal_lib');

        /* Load Master model */
        $this->flexi = new stdClass;
        $this->load->library('flexi_cart');

        /* Load Product model */
        $this->load->model(array('product_attribute', 'product'));

        $this->load->model(array('users'));

        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');


        // manage cart item from separate browser using database        
        $this->load->library('flexi_cart_admin');
        $this->load->model('demo_cart_model');
        $this->data['model_id'] = null;
        
        //$this->load->model(array('flexi_cart_admin'));
        $user_id = $this->session->userdata('user_id');
        
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $sql_where = array(
            $this->flexi_cart->db_column('db_cart_data', 'user') => 0,
            $this->flexi_cart->db_column('db_cart_data', 'user') => $user_id,
            $this->flexi_cart->db_column('db_cart_data', 'readonly_status') => 0
        );

        // Get a list of all saved carts that match the SQL WHERE statement.
        $this->data['saved_cart_data'] = $this->flexi_cart_admin->get_db_cart_data_array(FALSE, $sql_where);
        $rowCnt = 0;
        $total = 0;
        if (isset($this->data['saved_cart_data'][0]['cart_data_array'])) {
            $cart_data = unserialize($this->data['saved_cart_data'][0]['cart_data_array']);
            $_SESSION['flexi_cart']['items'] = $cart_data['items'];
            $_SESSION['flexi_cart']['summary'] = $cart_data['summary'];
            $this->data['cart_items'] = $_SESSION['flexi_cart']['items'];
            $this->data['cart_summary'] = $_SESSION['flexi_cart']['summary'];
        } else {
            $this->data['cart_items'] = $this->flexi_cart->cart_items();
        }

    }

    // default function for home controller
    public function index() {

        // get the user id from session
        $user_id = $this->session->userdata('user_id');

        // Added by Ranjit Pasale on 20 Dec 2017
        $this->data['highlighted_products'] = $this->product->get_highlighted_products_landing_page();
        $this->data['dow_products'] = $this->product->get_dow_products_landing_page();
        $this->data['os_products'] = $this->product->get_os_products_landing_page();
        $this->data['blog_posts'] = $this->Blog_model->getAllBlog('','','','4');
        // echo "<pre>"; print_r($this->data['dow_products']); die();

        $this->data['product_details'] = array();

        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['product_details_count'] = $this->product->count_by(array('id'));

        // $this->data['product_details'] = $this->product->get_products();
        $this->data['bestseller_product'] = $this->product->get_best_seller_products();

        // get the feature products
        $this->data['featured_products'] = $this->product->get_feature_product();

        $this->data['on_rent_products'] = $this->product->get_onrent_product();

        // $this->data['featured_products_categories'] = $this->product->get_feature_product_categories();

        $site_settings_array = $this->common_model->getRecords('tbl_site_settings','*');
        $login_slider = $this->common_model->getRecords('tbl_site_settings','*',array('type_id'=>2));
        
        foreach ($site_settings_array as $site_array) {
            $site_settings[$site_array['field_key']]=$site_array['field_output_value'];
        }

        $this->data['site_settings'] = $site_settings;
        $this->data['login_slider'] = $login_slider;

        foreach ($this->data['product_details'] as $key => $value)
            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
        
        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Home Page';
        $renderTo = 'landing_page';

        // call the render view function here
        $this->_renders_landing_view($pageTitle, $renderTo, $this->data);        
    }

    /**
     * all products with filters
     * @author      Harshal B <harshalb@rebelute.com>
     * @return      products with all categories filter
     * @param       (int) $category_id, (int) $subcategory_id
     */
    public function product_list($category_id = NULL, $subcategory_id = NULL) {

        // set the parameters for rendering view
        $categoryOptions = array();
        $page = 1;
        $config = array();

        $user_id = $this->session->userdata('user_id');

        if (isset($category_id)) {
            $details = $this->product_category->get_category_name_by_id($category_id);
            $this->data['category_title'] = $details['name'];
            $this->data['category_description'] = $details['description'];
        } else {
            $this->data['category_title'] = "Shop";
            $this->data['category_description'] = "It all begins right here at Buy Sell Rent. Test results, Consumer ratings and reviews. Super-fast shipping. The best of the best brands.";
        }

        if ($category_id != '') {
            
            // total rows count
            $this->data['product_details'] = $this->product->get_product_count_by_category_subcategory($category_id, NULL);
            $total_row = count($this->data['product_details']);

        } else {

            $this->db->select('*');
            $this->db->group_by('product_id');
            $this->db->from('tbl_subcategories_map');
            $records = $this->db->get();
            $this->data['product_count'] = $records->result_array();

            $total_row = count($this->data['product_count']);
        }
        
        /* Ajax Pagination */
        $config['uri_segment'] = 4;
        $config['target'] = '.product_filter';
        $config['base_url'] = base_url() . 'home/ajaxPaginationData/'.$category_id;
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->perPage;
        // $config['link_func'] = 'searchFilterProduct';
        $this->ajax_pagination->initialize($config);

        /* Ajax Pagination */
        $this->data['product_category_id'] = $category_id;
        $this->data['product_details'] = $this->product->get_product_by_category_subcategory($category_id, $subcategory_id, $config["per_page"]);

        $this->data['brands'] = $this->product->getBrandsById();

        $this->data['product_attributes'] = $this->product->getAllAttributes($category_id);
        
        foreach ($this->data['product_attributes'] as $key => $cData) {
            $this->data['product_attributes'][$key]['sub_attributes_values'] = $this->product->getAttributeValuesById($cData['attribute_value'], $category_id);
        }
        
        // $this->data['product_details'] = $this->product->get_product_by_category_id($category_id, $subcategory_id, $config["per_page"]);

        $pageTitle = 'Buy Sell Rent | All Products';
        $renderTo = 'product_list';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * Product details page
     * @author      Harshal B <harshalb@rebelute.com>
     * @return      product details array page by product id
     */
    public function product_detail($product_id = NULL) {

        // get the product details array
        $this->data['product_details'] = $this->product->getProductById($product_id);        

        $this->data['product_attributes'] = $this->product->getProductAttributesById($product_id);
        
        if(!empty($this->data['product_details'])) {
            // get the related products
            $this->data['related_product'] = $this->product->getRelatedProductCategory($this->data['product_details'][0]['category_id'], $product_id);
        }

        $average_rating = null;

        $this->data['product_review'] = $this->review_model->get_all_reiview_products($product_id);
        foreach ($this->data['product_review'] as $rData) {
            $average_rating += $rData['review_total'];
        }

        $cnt = count($this->data['product_review']);
        if ($cnt != 0) {
            $average_rating = $average_rating / ($cnt * 5) * 5;
            $this->data['average_rating'] = $average_rating;
        } else {
            $this->data['average_rating'] = 0;
        }

        // check if the user id logged in
        if($this->ion_auth->logged_in()) {

            // get the user id from session
            $user_id = $this->session->userdata('user_id');

            $check_review_submitted = $this->review_model->count_by(array('user_id' => $user_id, 'product_id' => $product_id));

            if($check_review_submitted <= 0) {
                $this->data['add_review_link'] = '<li><a href="#" data-toggle="modal" data-target="#reviewnew">Add your review</a></li>';
            }
        }

        // load the services page view
        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Product Detail';
        $renderTo = 'product_detail';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * Wishlist view page
     * @author      Harshal Borse <harshalb@rebelute.com>
     * @return      Wishlist view page
     */

    public function wishlist() {

        if($this->ion_auth->logged_in()) {

            // get the user id from session
            $user_id = $this->session->userdata('user_id');

            $this->data['dataHeader'] = $this->users->get_allData($user_id);

            $this->data['wishlist_data'] = $this->product->getWishlistByUserID($user_id);

            // set the parameters for rendering view
            $pageTitle = 'Buy Sell Rent | Your Wishlist';
            $renderTo = 'wishlist';

            // call the render view function here
            $this->_renders_view($pageTitle, $renderTo, $this->data);
        } else {
            redirect('login', 'refresh');
        }
    }

    /**
     * privacy policy view page
     * @author      Jinal Rathod <jinalr@rebelute.com>
     * @return      privacy policy view page
     */

    public function privacy_policy() {

        // get the user id from session
        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['post_info'] = ($this->common_model->getRecords('tbl_mst_cms', '*', array('cms_id' => '3'), $order_by = '', $limit = '', $debug = 0));

        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent |  Privacy Policy';
        $renderTo = 'privacy_policy';
        
        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }


    public function returns_policy() {

        // get the user id from session
        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['post_info'] = ($this->common_model->getRecords('tbl_mst_cms', '*', array('cms_id' => '3'), $order_by = '', $limit = '', $debug = 0));

        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Returns Policy';
        $renderTo = 'returns_policy';
        
        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }


    public function terms() {

        // get the user id from session
        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['post_info'] = ($this->common_model->getRecords('tbl_mst_cms', '*', array('cms_id' => '4'), $order_by = '', $limit = '', $debug = 0));

        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Terms and Conditions';
        $renderTo = 'terms_and_conditions';
        
        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * newsletter subscription
     * @author      Harshal Borse <harshalb@rebelute.com>
     * @return      success or failure response to subscribe newsletter
     */

    public function subscribeNewsletter() {

        // exception handling
        try {

            // get the posted value of email id for subscription
            $email = trim($this->input->post('email'));

            // check if the email is is already in subscription list
            $get_record = $this->newsletter->get_by(array('email' => $email));            

            // check if email id is already exists
            if (count($get_record) >= 1) {
                
                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '0', 'message' => 'You have already subscribed for newsletter')); exit;

            } else {
                // store the email id for subscription
                $data_array = array(
                    'email' => trim($email)
                );

                // check if the record is inserted in to the table
                if($this->newsletter->insert($data_array)) {

                    // send the services email to store
                    $message = 'Hi,<br><br>';
                    $message .= 'You have successfully subscribed newsletter';
                    $subject = 'Buy Sell Rent - Newsletter Subscription';

                    // $this->email($this->input->post('email'), $message, $subject);
                    $this->common_model->sendEmail($email, $message, $subject);

                    // set the response message
                    $this->output->set_header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(array('status' => '1', 'message' => 'You have successfully subscribed for newsletter')); exit;
                } else {
                    // set the response message
                    $this->output->set_header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(array('status' => '0', 'message' => 'Failed to subscribe for newsletter')); exit;
                }
            }

        } catch (Exception $e) {
            // set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '0', 'message' => $e)); exit;
        }
    }


    public function loadFeaturedProductsByCategory() {

        // get the feature products
        // $this->data['featured_products'] = $this->product->get_feature_product();

        $category_id = $this->input->post('category_id');
        // $this->data['bestseller_product'] = $this->product->get_best_seller_products();
        // $this->data['featured_products'] = $this->product->get_product_by_category_subcategory($category_id, NULL, NULL);
        $this->data['featured_products'] = $this->product->get_feature_product_by_category_id($category_id);
        
        $content = $this->load->view('featured_content', $this->data, TRUE);
        // set the response message
        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array('status' => '0', 'content' => $content)); exit;

    }

    public function loadBestsellerProductsByCategory() {

        $category_id = $this->input->post('category_id');
        // $this->data['bestseller_product'] = $this->product->get_product_by_category_subcategory($category_id, NULL, NULL);

        $this->data['bestseller_product'] = $this->product->get_best_seller_products_by_category_id($category_id);
        
        $content = $this->load->view('bestseller_content', $this->data, TRUE);
        // set the response message
        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array('status' => '0', 'content' => $content)); exit;

    }


    /**
     * track order view page
     * @author      Harshal Borse <harshalb@rebelute.com>
     * @return      track order view page
     */

    public function track_order() {

        if($this->ion_auth->logged_in()) {

            // get the user id from session
            $user_id = $this->session->userdata('user_id');

            $this->data['dataHeader'] = $this->users->get_allData($user_id);

            // set the parameters for rendering view
            $pageTitle = 'Buy Sell Rent | Track Order';
            $renderTo = 'track_order';

            // call the render view function here
            $this->_renders_view($pageTitle, $renderTo, $this->data);
        } else {
            redirect('login', 'refresh');
        }
    }

    /**
     * remove product from wishlist
     * @author      Harshal Borse <harshalb@rebelute.com>
     * @return      Wishlist remove product
     */
    public function removeWishListProduct() {
        // exception handling
        try {
            // get the posted value of product id
            $id = trim($this->input->post('product_id'));

            // check if the user id logged in
            if($this->ion_auth->logged_in()) {
                // check if the product is in wishlist 
                $get_record = $this->wishlist->get_by(array('id' => $id, 'user_id' => $this->session->userdata('user_id')));

                // check if email id is already exists
                if (count($get_record) < 1) {
                    // set the response message
                    $this->output->set_header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(array('status' => '0', 'message' => 'Product is not in wishlist')); exit;
                } else {

                    // check if the record is inserted in to the table
                    if($this->wishlist->delete($id)) {
                        // set the response message
                        $this->output->set_header('Content-Type: application/json; charset=utf-8');
                        echo json_encode(array('status' => '1', 'message' => 'Product is removed from wishlist')); exit;
                    } else {
                        // set the response message
                        $this->output->set_header('Content-Type: application/json; charset=utf-8');
                        echo json_encode(array('status' => '0', 'message' => 'Failed to remove product from wishlist')); exit;
                    }
                }
            } else {
                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '0', 'message' => 'Log in to remove product from wishlist')); exit;
            }

        } catch (Exception $e) {
            // set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '0', 'message' => $e)); exit;
        }
    }

    /**
     * product add to the wishlist
     * @author      Harshal Borse <harshalb@rebelute.com>
     * @return      add product to wishlist
     */
    public function addToWishList() {

        // check if the user id logged in
        if($this->ion_auth->logged_in()) {
            // exception handling
            try {
                // check if the product is added in to the wishlist already
                // query for checking the user email id is already subscribed
                $get_record = $this->wishlist->get_by(array('product_id' => $this->input->post('product_id'), 'user_id' => $this->session->userdata('user_id')));

                $get_all_record = $this->wishlist->get_by(array('user_id' => $this->session->userdata('user_id')));

                // check if email id is already exists
                if (count($get_record) >= 1) {
                    // set the response message
                    $this->output->set_header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(array('status' => '0', 'message' => 'Product is already added in wishlist')); exit;
                } else {

                    // get the user id from session and posted values
                    $data_array = array(
                        'user_id' => $this->session->userdata('user_id'),
                        'category_id' => trim($this->input->post('category_id')),
                        'product_id' => trim($this->input->post('product_id'))
                    );

                    // check if the record is inserted in to the table
                    if($this->wishlist->insert($data_array)) {
                        // set the response message
                        $this->output->set_header('Content-Type: application/json; charset=utf-8');
                        echo json_encode(array('status' => '1', 'data' => count($get_all_record) + 1, 'message' => 'Product added to the wishlist')); exit;
                    } else {
                        // set the response message
                        $this->output->set_header('Content-Type: application/json; charset=utf-8');
                        echo json_encode(array('status' => '0', 'message' => 'Failed to add product in wishlist')); exit;
                    }
                }

            } catch (Exception $e) {
                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '0', 'message' => $e)); exit;
            }
        } else {
            // set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '0', 'message' => 'Log in to add the product in wishlist')); exit;
        }
    }



    /**************************** Rent section start ******************************/

    /**
     * all products with filters of rent section
     * @author      Harshal B <harshalb@rebelute.com>
     * @return      products with all categories filter
     * @param       (int) $category_id, (int) $subcategory_id
     */
    public function rent_product_list($category_id = NULL, $subcategory_id = NULL) {

        // set the parameters for rendering view
        $categoryOptions = array();
        $page = 1;
        $config = array();

        $user_id = $this->session->userdata('user_id');
        
        /* Ajax Pagination */
        // $config['uri_segment'] = 4;
        // $config['target'] = '.product_filter';
        // $config['base_url'] = base_url() . 'home/ajaxPaginationData/'.$category_id;
        // $config['total_rows'] = $total_row;
        // $config['per_page'] = $this->perPage;
        // // $config['link_func'] = 'searchFilterProduct';
        // $this->ajax_pagination->initialize($config);

        /* Ajax Pagination */
        $this->data['product_category_name'] = $this->rent_product->getProductCategoryName($subcategory_id);
        
        $this->data['product_details'] = $this->rent_product->get_product_by_category_subcategory($category_id, $subcategory_id, $this->perPage);

        $this->data['brands'] = $this->rent_product->getBrandsById();        

        $pageTitle = 'Buy Sell Rent | All Rent Products';
        $renderTo = 'rent_product_list';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * Product details page
     * @author      Harshal B <harshalb@rebelute.com>
     * @return      product details array page by product id
     */
    public function rent_product_detail($product_id = NULL, $subcategory_id = NULL) {

        // get the product details array
        $this->data['product_details'] = $this->rent_product->getProductById($product_id);
        
        // if(!empty($this->data['product_details'])) {
        //     // get the related products
        //     $this->data['related_product'] = $this->rent_product->getRelatedProductCategory($this->data['product_details'][0]['category_id'], $product_id);
        // }

        $arr = explode(',', $this->data['product_details'][0]['category_id']);
        
        $categories = array();

        foreach ($arr as $key => $product_all_cats) {
            array_push($categories, $this->rent_product->getProductCategories($product_all_cats)[0]);
            $this->data['categories'] = $categories;
        }        

        $this->data['sub_category_name'] = $this->rent_product->getCategoryName($product_id);        

        $average_rating = null;

        $this->data['product_review'] = $this->rent_review_model->get_all_reiview_products($product_id);
        foreach ($this->data['product_review'] as $rData) {
            $average_rating += $rData['review_total'];
        }

        $cnt = count($this->data['product_review']);
        if ($cnt != 0) {
            $average_rating = $average_rating / ($cnt * 5) * 5;
            $this->data['average_rating'] = $average_rating;
        } else {
            $this->data['average_rating'] = 0;
        }

        // check if the user id logged in
        if($this->ion_auth->logged_in()) {

            // get the user id from session
            $user_id = $this->session->userdata('user_id');

            $check_review_submitted = $this->rent_review_model->count_by(array('user_id' => $user_id, 'product_id' => $product_id));

            if($check_review_submitted <= 0) {
                $this->data['add_review_link'] = '<li>'.anchor('#', 'Add your review', array('data-toggle' => 'modal', 'data-target' => '#rentreviewnew', 'title' => 'The best news!')).'</li>';
            }
        }
        
        $this->data['product_category_name'] = $this->rent_product->getProductCategoryName($subcategory_id);
        

        // load the services page view
        // set the parameters for rendering view
        $pageTitle = 'Buy Sell Rent | Rent Product Detail';
        $renderTo = 'rent_product_detail';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }


    /**
     * add reviews to the product of rent section
     * @author      Harshal Borse <harshalb@rebelute.com>
     * @return      product reviews adding success message
     */
    public function addRentProductReview() {

        // check if the user id logged in
        if($this->ion_auth->logged_in()) {

            // exception handling
            try {

                $user_id = $this->session->userdata('user_id');
                $review_name = $this->input->post('review_name');
                $review_message = $this->input->post('review_message');
                $product_id = $this->input->post('product_id');
                $selected_starts = $this->input->post('selected_starts');

                $reviewData = array(
                    'product_id' => $product_id,
                    'review_title' => $review_name,
                    'discription' => $review_message,
                    'review_total' => $selected_starts,
                    'user_id' => $user_id
                );

                if($this->rent_review_model->insert($reviewData)) {
                    $this->output->set_header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(array("status" => "1", "message" => "Your review added successfully")); exit;
                } else {
                    $this->output->set_header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(array("status" => "1", "message" => "Failed to add the reciew. Try again")); exit;
                }

            } catch (Exception $e) {
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '1', 'message' => $e)); 
            }

        } else {
            // set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '0', 'message' => 'Log in to add the review')); exit;
        }
    }

    /**
     * filter product view
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       string  filter parameters
     * @return      filtered product view
     */
    public function filterRentProductList() {

        $start_price = ($this->input->post('start_price') !== '' ? trim($this->input->post('start_price')) : '');
        $end_price = (!empty($this->input->post('end_price')) ? trim($this->input->post('end_price')) : '');
        $category_id = (!empty($this->input->post('category_id')) ? trim($this->input->post('category_id')) : '');
        $subcategory_id = (!empty($this->input->post('subcategory_id')) ? trim($this->input->post('subcategory_id')) : '');

        $search_param = ($this->input->post('attribute_search') !== "" ? trim($this->input->post('attribute_search')) : '');

        // echo $search_param; die;
        $brand_search = (!empty($this->input->post('brand_search')) ? trim($this->input->post('brand_search')) : '');

        // execute the query for filter products from product table
        $this->data['product_details'] = $this->rent_product->filterProductsByPrice($category_id, $subcategory_id, $start_price, $end_price, $search_param, $brand_search);
        
        echo json_encode(array('content' => $this->load->view('home/ajax_rent_product_view', $this->data, TRUE)));
        die;
    }

    /************************ Rent section end *******************************/

    /**
     * contact us page view
     * @author      Harshal Borse <harshalb@rebelute.com>
     * @return      contact us page
     */
    public function contact_us() {

        // load the services page view
        // set the parameters for rendering view
        $this->data = null;

        $this->data['post_info'] = ($this->common_model->getRecords('tbl_mst_cms', '*', array('cms_id' => '2'), $order_by = '', $limit = '', $debug = 0));

        $pageTitle = 'Buy Sell Rent | Contact Us';
        $renderTo = 'contact_us';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * about us submit entery in table
     * @author      Harshal Borse <harshalb@rebelute.com>
     * @return      about us page
     */
    public function addContactUs() {

        // data array for posted values
        $data_arr = array(
            'name' => trim($this->input->post('name')),
            'email' => trim($this->input->post('email')),
            'message' => trim($this->input->post('enquiry'))
        );

        // insert the data in to bid table
        if ($this->contact->insert($data_arr, TRUE)) {

            // send the services email to store
            $subject = 'Buy Sell Rent - Contact Us';

            $this->data['name'] = trim($this->input->post('name'));
            $this->data['message'] = trim($this->input->post('enquiry'));
            $this->data['email'] = trim($this->input->post('email'));                

            // $this->email($this->input->post('email'), $message, $subject);
            if($this->common_model->sendEmail($this->input->post('email'), $this->load->view('contact_us_template', $this->data, true), $subject)) {
                // show the success messag ehere
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '1', 'message' => 'Your enquiry details are successfully sent. We will get back to you soon'));
            }
        } else {
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '1', 'message' => 'Failed to send enquiry detail. Try again'));
        }
    }

    /**
     * about us page view
     * @author      Harshal Borse <harshalb@rebelute.com>
     * @return      about us page
     */
    public function aboutUs() {

        // set the parameters for rendering view
        $this->data = null;

        $this->data['post_info'] = ($this->common_model->getRecords('tbl_mst_cms', '*', array('cms_id' => '1'), $order_by = '', $limit = '', $debug = 0));
        $pageTitle = 'Buy Sell Rent | About Us';
        $renderTo = 'about_us';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * add reviews to the product buy section
     * @author      Harshal Borse <harshalb@rebelute.com>
     * @return      product reviews adding success message
     */
    public function addProductReview() {

        // check if the user id logged in
        if($this->ion_auth->logged_in()) {

            // exception handling
            try {

                $user_id = $this->session->userdata('user_id');
                $review_name = $this->input->post('review_name');
                $review_message = $this->input->post('review_message');
                $product_id = $this->input->post('product_id');
                $selected_starts = $this->input->post('selected_starts');

                $reviewData = array(
                    'product_id' => $product_id,
                    'review_title' => $review_name,
                    'discription' => $review_message,
                    'review_total' => $selected_starts,
                    'user_id' => $user_id
                );

                if($this->review_model->insert($reviewData)) {
                    $this->output->set_header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(array("status" => "1", "message" => "Your review added successfully")); exit;
                } else {
                    $this->output->set_header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(array("status" => "1", "message" => "Failed to add the reciew. Try again")); exit;
                }

            } catch (Exception $e) {
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '1', 'message' => $e)); 
            }

        } else {
            // set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '0', 'message' => 'Log in to add the review')); exit;
        }
    }


    /**
     * Blog page with list of blogs
     * @author      Harshal B <harshalb@rebelute.com>
     * @return      blog page view
     */
    public function blog($pg = '', $archieve = NULL) {

        // load the services page view
        // set the parameters for rendering view
        $this->data = null;

        // if(isset($offset) && !empty($offset)) {
        //     $pg = $_GET['offset'] + 1;
        // }
        // echo $pg; die;

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['get_blogs_result'] = $this->Blog_model->getAllBlog('*', '', '', '', '', 0);

        // get the blog categories
        $this->data['cat_data'] = $this->common_model->getRecords('tbl_mst_categories', '*',array('status' => '1'), $order_by = 'category_id DESC', $limit = '', $debug = 0);

        // $this->data['blog_archieve'] = $this->Blog_model->getAllBlogsByMonths();

        $this->data['blog_archieve_months'] = $this->Blog_model->getBlogsArchieveMonths();

        $this->data['blog_tags'] = $this->blog_tags->getBlogTags();

        $this->data['blog_posts_one'] = $this->Blog_model->getAllBlog('', '');

        $this->load->library('pagination');
        $data['count'] = count($this->data['blog_posts_one']);
        $config['base_url'] = base_url() . 'blog/';
        $config['total_rows'] = count($this->data['blog_posts_one']);
        $config['per_page'] = 8;
        $config['prev_link'] = 'Prev';
        $config['next_link'] = 'Next';
        $config['cur_page'] = $pg;
        $data['cur_page'] = $pg;
        $config['num_links'] = 2;
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        $this->data['create_links'] = $this->pagination->create_links();
        $this->data['blog_posts_two'] = $this->Blog_model->getAllBlog('', '', '', $config['per_page'], $pg);
        $data['page'] = $pg; //$pg is used to pass limit 

        $pageTitle = 'Buy Sell Rent | Blog Posts';
        $renderTo = 'blog';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }
    
    /**
    * @author  : Harshal Borse <harshalb@rebelute.com>
    * @date    : 17 Jan 2018
    * add blog post comment in database
    */
    public function addBlogComment() {

        $blog_comment_array = array(
            'post_id' => trim($this->input->post('post_id')),
            'commented_by' => trim($this->input->post('blog_author')),
            'comment' => trim($this->input->post('blog_comment')),
            'comment_on' => date('Y-m-d H:i:s'),
            'status' => '0',
            'email' => trim($this->input->post('blog_email'))
        );        

        if($this->blog_comment->insert($blog_comment_array)) {
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '1', 'message' => 'Your comment on blog has successfully submitted for Admin approval'));
        } else {
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '0', 'message' => 'failed to submit you comment'));
        }
    }

    public function blogCategoryDetailsMain($category_id = ''){
        if($category_id != ''){
            $this->session->unset_userdata("category_id");
            $this->session->set_userdata("category_id",$category_id);
        }
        $this->blogCategoryDetails();
    }

    public function blogCategoryDetails($pg = '') {

       $category_id= $this->session->userdata("category_id");
       // load the services page view
       // set the parameters for rendering view
       $arr_cat_data = ($this->common_model->getRecords('tbl_mst_categories', 'category_name',array("category_id" => $category_id,"status" => '1'), $order_by = 'category_id DESC', $limit = '', $debug = 0));
       
       if(count($arr_cat_data) < 1){
            redirect(base_url().'blog');
        }

        $this->data['category_name'] =$arr_cat_data[0]['category_name'];
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $condition_to_pass = array("b.status" => '1',"b.blog_category" => $category_id);
        $this->data['get_blogs_result'] = $this->Blog_model->getAllBlogCategories('*', $condition_to_pass, '', '', '', 0);

        // get the blog categories
        $this->data['cat_data'] = $this->common_model->getRecords('tbl_mst_categories', '*', array('status' => '1'), $order_by = 'category_id DESC', $limit = '', $debug = 0);

        $this->data['blog_posts_one'] = $this->Blog_model->getAllBlogCategories('', $condition_to_pass);

        $this->load->library('pagination');
        $data['count'] = count($this->data['blog_posts_one']);
        $config['base_url'] = base_url() . 'blog-category-details/';
        $config['total_rows'] = count($this->data['blog_posts_one']);
        $config['per_page'] = 8;
        $config['prev_link'] = 'Prev';
        $config['next_link'] = 'Next';
        $config['cur_page'] = $pg;
        $data['cur_page'] = $pg;
        $config['num_links'] = 2;
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';
        $this->pagination->initialize($config);
        $this->data['create_links'] = $this->pagination->create_links();
        $this->data['blog_posts_two'] = $this->Blog_model->getAllBlogCategories('', $condition_to_pass, '', $config['per_page'], $pg);
        $data['page'] = $pg; //$pg is used to pass limit 

        $pageTitle = 'Buy Sell Rent | Blog Categories';
        $renderTo = 'blog_categories';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }


    /**
     * blog detail view based on the blog id
     * @author      Harshal B <harshalb@rebelute.com>
     * @return      blog detail view
     */
    public function blogDetails($blog_id = '') {

        // load the services page view
        // set the parameters for rendering view
        $this->data['cat_data'] = $this->common_model->getRecords('tbl_mst_categories', '*',array('status' => '1'), $order_by = 'category_id DESC', $limit = '', $debug = 0);
        $condition_to_pass = array("status" => '1', "post_id" => $blog_id);        

        $this->data['blog_archieve_months'] = $this->Blog_model->getBlogsArchieveMonths();

        $this->data['blog'] = $this->Blog_model->getAllBlog('', $condition_to_pass, '', '', '', 0);

        foreach ($this->data['blog'] as $key => $value) {
            $this->data['blog'][$key]['blog_comments'] = $this->common_model->getBlogComments($value['post_id'], $status = '1');
        }        

        $pageTitle = 'Buy Sell Rent | Blog Details';
        $renderTo = 'blog_details';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * checkout page view
     * @author      Harshal B <harshalb@rebelute.com>
     * @return      checkout page view
     */
    public function checkout() {

        $this->load->library('user_agent');
        // echo substr($this->agent->referrer(), '-4'); die;

        // check if user is already logged in
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        if(substr($this->agent->referrer(), '-4') !== 'cart') {
            redirect('cart');
        }

        // get the cart item from session
        $this->data['cart_items'] = $this->flexi_cart->cart_items();        

        foreach ($this->data['cart_items'] as $key => $cData) {
            $this->data['cart_items'][$key]['sub_attributes'] = $this->pattribute_sub->get_sub_attributes_at_id($cData['category_id']);
        }

        // get the user id from session
        $user_id = trim($this->session->userdata('user_id'));

        $this->db->select('id, name');
        $this->db->from('tbl_countries');
        $query = $this->db->get();
        $this->data['country_list'] = $query->result_array();

        $this->db->select('id, name');
        $this->db->from('tbl_states');
        $this->db->where('country_id', '231');
        $query1 = $this->db->get();
        $this->data['state_list'] = $query1->result_array();

        // get all user data from session
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        // check if the user address is already exists
        $this->data['get_shipping_address'] = $this->addresses->as_array()->get_by(array('user_id' => $user_id)); 

        if(!empty($this->data['get_shipping_address']['s_postcode'])) {

            $this->data['tax_array'] = $this->tax->get_tax_rate($this->data['get_shipping_address']['s_postcode']);            
        
            // $this->session->set_userdata('flexi_cart', );
            $_SESSION['flexi_cart']['summary']['tax_total'] = $this->data['tax_array']['combined_rate'];
            // $this->session->set_userdata('flexi_cart')['summary']['tax_total'] = $this->data['tax_array']['combined_rate'];
        }

        $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];

        // check if the user address is already exists
        $user_qry = $this->db->get_where('users', array('id' => $user_id));         
        $this->data['get_billing_address'] = $user_qry->result_array();        

        // load the services page view
        // set the parameters for rendering view
        // $this->data = null;
        $pageTitle = 'Buy Sell Rent | Cart Checkout';
        $renderTo = 'checkout';

        // call the render view function here

        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * shopping cart page view
     * @author      Harshal B <harshalb@rebelute.com>
     * @return      cart page view
     */
    public function cart() {

        // load the services page view
        // set the parameters for rendering view
        $this->data = null;

        $pageTitle = 'Buy Sell Rent | Cart Details';
        $renderTo = 'cart';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * set the 404 error page view
     * @author      Harshal B <harshalb@rebelute.com>
     * @return      404 error page view
     */
    public function error_404() {

        $this->output->set_status_header('404');
        $this->data = null;
        $pageTitle = 'Buy Sell Rent | 404 - Page not found';
        $renderTo = '404_error_page';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * update the mini cart
     * @author      Harshal B <harshalb@rebelute.com>
     * @return      update the values of mini cart in header
     */
    public function update_header_cart() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // flexi cart data
            $this->data['cart_items'] = $this->flexi_cart->cart_items();
            $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
            
            // load the view and pass the flexi cart data to it
            $mini_cart_view = $this->load->view('home/mini_cart', $this->data, TRUE);
            // return the response in json
            echo json_encode(array('content' => $mini_cart_view));
            die;
        }
    }

    // update the cart quantity
    public function update_cart() {

        $this->data['cart_items'] = $this->flexi_cart->cart_items();

        // Load custom demo function to retrieve data from the submitted POST data and update the cart.
        // $this->demo_cart_model->demo_update_cart();
        // If the cart update was posted by an ajax request, do not perform a redirect.
        if ($this->demo_cart_model->demo_update_cart()) {
            // Set a message to the CI flashdata so that it is available after the page redirect.
            $this->session->set_flashdata('msg', 'Cart values updated successfully');
            redirect('home/cart');
        }
    }

    /**
    * @author : Harshal Borse <harshalb@rebelute.com>
    * @date   : 17 Nov 2017
    * Paypal payment gateway integration
    */
    public function paypal_buy() {

        // set variables for paypal form
        $productname = '';
        $this->data['discounts'] = $this->flexi_cart->summary_discount_data();

        if (isset($this->session->userdata('flexi_cart')['summary']))
            $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];

        /* Step one : Apply discount &  calculation */
        if (isset($this->data['discounts']['total']) && $this->data['discounts']['total']['value_desc']) {
            $dis = $this->data['discounts']['total']['value_desc'];
            $discount_val = ($this->data['cart_summary']['item_summary_total'] * $dis) / 100;
            $this->data['cart_summary']['item_summary_total'] = $this->session->userdata('flexi_cart')['summary']['item_summary_total'] - $discount_val;
            $_SESSION['flexi_cart']['summary']['discount_data']['code'] = $this->data['discounts']['total']['code'];
            $this->data['cart_summary']['discount_data']['code'] = $this->data['discounts']['total']['code'];
            $_SESSION['flexi_cart']['summary']['discount_data']['value_desc'] = $this->data['discounts']['total']['value_desc'];
            $this->data['cart_summary']['discount_data']['value_desc'] = $this->data['discounts']['total']['value_desc'];
        } else {
            $this->data['cart_summary']['discount_data']['code'] = "";
            $_SESSION['flexi_cart']['summary']['discount_data']['code'] = "";
            $_SESSION['flexi_cart']['summary']['discount_data']['value_desc'] = "";
            $this->data['cart_summary']['discount_data']['value_desc'] = "";
        }
        /* Step one : Apply discount &  calculation */
        
        /* Step two : tax calculation */
        $taxAmount = $this->data['cart_summary']['item_summary_total'] * $this->data['cart_summary']['tax_total'] / 100;
        // $_SESSION['flexi_cart']['summary']['tax_total'] = $taxAmount;
        $this->data['cart_summary']['item_summary_total'] = $this->data['cart_summary']['item_summary_total'] + round($taxAmount, 2);
        /* Step two : tax calculation */
        

        // get the cart item from session
        $this->data['cart_items'] = $this->flexi_cart->cart_items();

        $user_id = $this->session->userdata('user_id');

        foreach ($this->data['cart_items'] as $key => $cartData) {
            $productname .= $cartData['name'] . ',';
        }

        $returnURL = base_url() . 'home/paypal_success'; // payment success url
        $cancelURL = base_url() . 'home/paypal_cancel'; // payment cancel url
        $notifyURL = base_url() . 'home/ipn'; // ipn url

        $logo = base_url() . 'assets/images/logo.png';
        
        // to get shipping ammount
        $shipping_amt = isset($_SESSION['shipping_amount']) ? $_SESSION['shipping_amount'] : "0";
        $grossTotal = (float) ($this->data['cart_summary']['item_summary_total'] + $shipping_amt);

        // set the paypal library parameters
        $this->paypal_lib->add_field('return', $returnURL);
        $this->paypal_lib->add_field('cancel_return', $cancelURL);
        $this->paypal_lib->add_field('notify_url', $notifyURL);
        $this->paypal_lib->add_field('item_name', $productname);
        $this->paypal_lib->add_field('custom', $user_id);
        $this->paypal_lib->add_field('item_number', $this->data['cart_summary']['total_items']);
        $this->paypal_lib->add_field('amount', $grossTotal); //$this->data['cart_summary']['item_summary_total']
        $this->paypal_lib->image($logo);

        $this->paypal_lib->paypal_auto_form();
    }


    /**
    * @author : Harshal Borse <harshalb@rebelute.com>
    * @date   : 12 Feb 2018
    * Stripe payment gateway integration
    */
    function stripe_payment() {

        try {
                
            // get the user id from session
            $user_id = $this->session->userdata('user_id');

            $userData = $this->users->get_allData($user_id);
            $userAddressData = $this->addresses->as_array()->get_by(array('user_id' => $user_id));

            // set variables for stripe payment
            $productname = '';
            $this->data['discounts'] = $this->flexi_cart->summary_discount_data();

            if (isset($this->session->userdata('flexi_cart')['summary']))
                $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];

            /* Step one : Apply discount &  calculation */
            if (isset($this->data['discounts']['total']) && $this->data['discounts']['total']['value_desc']) {
                
                $dis = $this->data['discounts']['total']['value_desc'];
                $discount_val = ($this->data['cart_summary']['item_summary_total'] * $dis) / 100;
                $this->data['cart_summary']['item_summary_total'] = $this->session->userdata('flexi_cart')['summary']['item_summary_total'] - $discount_val;
                $_SESSION['flexi_cart']['summary']['discount_data']['code'] = $this->data['discounts']['total']['code'];
                $this->data['cart_summary']['discount_data']['code'] = $this->data['discounts']['total']['code'];
                $_SESSION['flexi_cart']['summary']['discount_data']['value_desc'] = $this->data['discounts']['total']['value_desc'];
                $this->data['cart_summary']['discount_data']['value_desc'] = $this->data['discounts']['total']['value_desc'];
            } else {

                $this->data['cart_summary']['discount_data']['code'] = "";
                $_SESSION['flexi_cart']['summary']['discount_data']['code'] = "";
                $_SESSION['flexi_cart']['summary']['discount_data']['value_desc'] = "";
                $this->data['cart_summary']['discount_data']['value_desc'] = "";
            }
            /* Step one : Apply discount &  calculation */
            
            /* Step two : tax calculation */
            $taxAmount = $this->data['cart_summary']['item_summary_total'] * $this->data['cart_summary']['tax_total'] / 100;
            // $_SESSION['flexi_cart']['summary']['tax_total'] = $taxAmount;
            $this->data['cart_summary']['item_summary_total'] = $this->data['cart_summary']['item_summary_total'] + round($taxAmount, 2);
            /* Step two : tax calculation */
            

            // get the cart item from session
            $this->data['cart_items'] = $this->flexi_cart->cart_items();

            $user_id = $this->session->userdata('user_id');

            foreach ($this->data['cart_items'] as $key => $cartData) {
                $productname .= $cartData['name'] . ',';
            }

            // to get shipping ammount
            $shipping_amt = isset($_SESSION['shipping_amount']) ? $_SESSION['shipping_amount'] : "0";
            $grossTotal = (float) ($this->data['cart_summary']['item_summary_total'] + $shipping_amt);

            // set the api key for stripe
            Stripe::setApiKey('sk_test_TDQIKbTqkLZFBLbp0wbfCZPt'); // for test
            $shipping_amt = isset($_SESSION['shipping_amount']) ? $_SESSION['shipping_amount'] : "0";
            $_SESSION['cart_summary']['shipping_total'] = $shipping_amt;
            

            // set the parameters for stripe
            $charge = Stripe_Charge::create(array(
                "amount" => round($grossTotal),
                "currency" => "usd",
                "card" => $this->input->post('stripeToken'),
                "description" => "Stripe Payment"
            ));

            
            $dataPayment = array(
                'user_id' => $user_id,
                'txn_id' => $charge->id,
                'payment_gross' => $charge->amount,
                'currency_code' => $charge->currency,
                'payment_status' => 'Completed',
            );

            $this->data['cart_items'] = $this->flexi_cart->cart_items();

            foreach ($this->data['cart_items'] as $key => $cartData) {
                $dataPayment['row_id'] = $cartData['row_id'];
                $dataPayment['product_id'] = $cartData['id'];

                $dataPayment['payment_via'] = 'stripe';
                $this->payment->insert($dataPayment);
            }

            /* Best Seller Count */
            foreach ($this->data['cart_items'] as $key => $cartData) {
                $dataPayment['product_sale_count'] = $cartData['quantity'];
                $dataPayment['product_quantity'] = $cartData['quantity'];
                $this->product->update_sale_count($cartData['id'], $dataPayment);
            }

            // echo $this->db->last_query(); die;

            /* Order */
            $orderData = array();
            $orderData['checkout']['billing'] = array(
                'name' => $userData['first_name'] . ' ' . $userData['last_name'],
                'company' => '',
                'add_01' => (!empty($userData['address']) ? $userData['address'] : $_POST['address_name'].$_POST['address_street']),
                'city' => (!empty($userData['city']) ? $userData['city'] : $_POST['address_city']),
                'state' => (!empty($userData['state']) ? $userData['state'] : $_POST['address_state']),
                'post_code' => (!empty($userData['postcode']) ? $userData['postcode'] : $_POST['address_zip']),
                'country' => (!empty($userData['country']) ? $userData['country'] : $_POST['address_state']),
            );

            $orderData['checkout']['shipping'] = array(
                'name' => $userData['first_name'] . ' ' . $userData['last_name'],
                'company' => '',
                'add_01' => (!empty($userAddressData['s_address']) ? $userAddressData['s_address'] : $_POST['address_name'].$_POST['address_street']),
                'add_02' => (!empty($userAddressData['s_address']) ? $userAddressData['s_address'] : $_POST['address_name'].$_POST['address_street']),
                'city' => (!empty($userAddressData['s_city']) ? $userAddressData['s_city'] : $_POST['address_city']),
                'state' => (!empty($userAddressData['s_state_id']) ? $userAddressData['s_state_id'] : $_POST['address_state']),
                'post_code' => (!empty($userAddressData['s_postcode']) ? $userAddressData['s_postcode'] : $_POST['address_zip']),
                'country' => "US",
            );


            $orderData['checkout']['email'] = $userData['email']; //$userData['email'];
            $this->data = $orderData;
            $orderData['checkout']['phone'] = $userData['phone'];
            $orderData['checkout']['comments'] = 'Stripe Payment';

            $order_number_last = $_SESSION['flexi_cart']['settings']['configuration']['order_number'];
            
            $this->data['cart_items'] = $this->flexi_cart->cart_items();

            foreach ($this->data['cart_items'] as $k => $val) {

                if(isset($val['rent_id']) && !empty($val['rent_id']) && $val['rent_id'] == '1') {

                    $time = strtotime(str_replace('/', '-', $val['rent_start_date']));
                    $start_date_formatted = date('Y-m-d',$time);
                    // create the array of values to put in to the database
                    $data_array = array(
                        'user_id' => $user_id,
                        'product_id' => $val['id'],
                        'duration' => $val['rent_duration_val'],
                        'param' => $val['rent_duration_param'],
                        'rent' => $val['rent'],
                        'order_id' => $order_number_last,
                        'start_date' => $start_date_formatted
                    );

                    // $this->db->insert('tbl_order_rent_details', $data_array);
                    if($this->db->insert('tbl_order_rent_details', $data_array)) {

                        // load the view and pass the paypal success message
                        $order_success = '<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">';
                        $order_success .= '<tr><td style="padding:20px;"><b>Hello User, Your rental for product '.$val['name'].' has been accepted.</b></td></tr><tr></tr>
                            <tr>
                                <td class="tablepadding" style="padding:20px;">
                                <table class="" style="border-collapse:collapse;width:100%;">
                                    <thead>
                                        <tr>
                                            <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:7px;color:#222222">Product</td>
                                            <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222">Qty</td>
                                            <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222">Rent</td>
                                            <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222">Total</td>
                                        </tr>
                                    </thead>
                                    <tbody>';
                        if (isset($this->data['cart_items']) && !empty($this->data['cart_items'])) {
                            foreach ($this->data['cart_items'] as $sid => $cData) {
                                $order_success .= '<tr>
                                    <td style="font-size:13px;border-left: 1px solid #dddddd;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px">'.$cData['name'].'<br />
                                    <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">'.$cData['quantity'].'</td>
                                    <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">$'.$cData['internal_price'].'</td>
                                    <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">$'.(floatval($cData['internal_price']) * floatval($cData['quantity'])).'</td>
                                </tr>';
                            }

                            $order_success .= '<tr><td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;font-weight:bold;text-align:right;padding:7px;border-left: 1px solid #dddddd;color:#222222" colspan="3">Start Date</td><td style="font-size:13px;border-right:1px solid #dddddd;border-left: 1px solid #dddddd;border-bottom:1px solid #dddddd;font-weight:bold;text-align:right;padding:7px;color:#222222" colspan="3" colspan="1">'.$start_date_formatted.'</td></tr><tr><td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;font-weight:bold;text-align:right;padding:7px;border-left: 1px solid #dddddd;color:#222222" colspan="3" colspan="3">Rent Duration</td><td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;font-weight:bold;text-align:right;padding:7px;color:#222222" colspan="1">'.$val['rent_duration_val'].' '.$val['rent_duration_param'].'</td></tr>';
                        }
                        
                        $order_success .= '<tr>
                              <td colspan="4">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:13px;color:#555555;font-family:Arial, Helvetica, sans-serif;">
                                  <tbody>
                                    <tr>
                                      <td class="m_2325894079705929180m_-187537962896113558tablepadding" align="center" style="font-size:14px;line-height:22px;padding:20px;border-top:1px solid #ececec;"> Any Questions? Get in touch with our 24x7 Customer Care team.<br>
                                        866-748-4737 | 626-821-9400 | 626-821-9401
                                      </td>
                                      
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>';
                        $order_success .= '</tbody></table></tr></table>';

                        // email parameters
                        $email = 'harshalb@rebelute.com';
                        $message = $order_success;
                        $subject = 'Buy Sell Rent | Your order was placed successfully!';
                        // $sentTo = $userData['email'];
                        $sentTo = 'harshalb@rebelute.com';

                        // $this->email($email, $message, $subject, $sentTo);
                        $this->common_model->sendEmail($sentTo, $message, $subject);
                    }
                }
            }


            /* Step one : Apply discount &  calculation */
            $this->data['discounts'] = $this->flexi_cart->summary_discount_data();

            if (!empty($this->data['discounts']) && isset($this->data['discounts']['total']) && $this->data['discounts']['total']['value_desc']) {
                $dis = $this->data['discounts']['total']['value_desc'];
                $discount_val = ($this->data['cart_summary']['item_summary_total'] * $dis) / 100;
                $orderData['checkout']['ord_reward_voucher_desc'] = $this->data['discounts']['total']['value_desc'];
                $orderData['checkout']['discount_saving_total'] = $discount_val;
            }

            if (isset($this->session->userdata('flexi_cart')['summary']))
                $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];

            if(isset($this->data['cart_summary']['tax_total']) && !empty($this->data['cart_summary']['tax_total'])) {
                
                $_SESSION['flexi_cart']['tax']['data']['item_total_tax'] = ($_SESSION['flexi_cart']['summary']['item_summary_total']/100)*($_SESSION['flexi_cart']['summary']['tax_total']);

                $orderData['checkout']['ord_tax_rate'] = $this->data['cart_summary']['tax_total'];
                $orderData['checkout']['ord_tax_total'] = $_SESSION['flexi_cart']['tax']['data']['item_total_tax'];
            }

            // save the flag of order (pre-order = 2 | rent order = 1 | buy order = 0)
            foreach ($this->data['cart_items'] as $ky => $val) {
                if($val['stock_quantity'] <= 0 && $val['rent_id'] == '0') {
                    $orderData['checkout']['order_type'] = '2';
                } else if ($val['stock_quantity'] > 0 && $val['rent_id'] == '1') {
                    $orderData['checkout']['order_type'] = '1';
                } else {
                    $orderData['checkout']['order_type'] = '0';
                }
            }

            // set the final total value
            $ret = $this->demo_cart_model->demo_save_order($orderData);
            
            /* Step one : Apply discount &  calculation */

            /* Order */
            //send email
            $this->data = $orderData;
            $this->data['order_date'] = date('Y-m-d H:m:s');
            $this->data['payment_type'] = "Stripe";
            $this->data['user_name'] = $userData['first_name'] . ' ' . $userData['last_name'];
            $this->data['phone'] = $userData['phone'];
            $this->data['order_id'] = $order_number_last;
            $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
            $this->data['cart_items'] = $this->flexi_cart->cart_items();
            
            $order_success = $this->load->view('paypal_success', $this->data, TRUE);

            $email = 'harshalb@rebelute.com';
            $message = $order_success;
            $subject = 'Buy Sell Rent | Your order is placed successfully!';
            // $sentTo = $userData['email'];
            $sentTo = 'harshalb@rebelute.com';

            // $this->email($email, $message, $subject, $sentTo);
            $this->common_model->sendEmail($sentTo, $message, $subject);

            $this->clear_cart();
            $this->session->set_flashdata('order_id', $order_number_last);
            $_SESSION['payment_status'] = 'stripe_success';
            redirect('home/paypal_payment_success');

        } catch (Stripe_CardError $e) {
            echo json_encode(array('status' => 500, 'error' => STRIPE_FAILED));
            exit();
        } catch (Stripe_InvalidRequestError $e) {
            // Invalid parameters were supplied to Stripe's API
            echo json_encode(array('status' => 500, 'error' => $e->getMessage()));
            exit();
        } catch (Stripe_AuthenticationError $e) {
            // Authentication with Stripe's API failed
            echo json_encode(array('status' => 500, 'error' => AUTHENTICATION_STRIPE_FAILED));
            exit();
        } catch (Stripe_ApiConnectionError $e) {
            // Network communication with Stripe failed
            echo json_encode(array('status' => 500, 'error' => NETWORK_STRIPE_FAILED));
            exit();
        } catch (Stripe_Error $e) {
            // Display a very generic error to the user, and maybe send
            echo json_encode(array('status' => 500, 'error' => STRIPE_FAILED));
            exit();
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            echo json_encode(array('status' => 500, 'error' => STRIPE_FAILED));
            exit();
        }
    }

    /**
    * @author : Harshal Borse <harshalb@rebelute.com>
    * @date   : 17 Nov 2017
    * Paypal payment gateway integration - success page after payment is successfully done
    */
    public function paypal_success() {
        
        // get the user id from session
        $user_id = $this->session->userdata('user_id');

        $userData = $this->users->get_allData($user_id);
        $userAddressData = $this->addresses->as_array()->get_by(array('user_id' => $user_id));
        
        
        // check if the form is posted
        if (isset($_POST) && !empty($_POST)) {

            $dataPayment = array(
                'user_id' => $user_id,
                'txn_id' => $this->input->post('txn_id'),
                'payment_gross' => $this->input->post('payment_gross'),
                'currency_code' => $this->input->post('mc_currency'),
                'payer_email' => $this->input->post('payer_email'),
                'payment_status' => $this->input->post('payment_status'),
            );
            
            $this->data['cart_items'] = $this->flexi_cart->cart_items();

            foreach ($this->data['cart_items'] as $key => $cartData) {
                $dataPayment['row_id'] = $cartData['row_id'];
                $dataPayment['product_id'] = $cartData['id'];

//            $dataPayment['payment_gross'] = $cartData['internal_price'];
                $dataPayment['payment_via'] = 'paypal';
                $this->payment->insert($dataPayment);
            }

            // echo $this->db->last_query(); die;

            /* Best Seller Count */
            foreach ($this->data['cart_items'] as $key => $cartData) {
                $dataPayment['product_sale_count'] = $cartData['quantity'];
                $dataPayment['product_quantity'] = $cartData['quantity'];
                $this->product->update_sale_count($cartData['id'], $dataPayment);
            }

            /* Order */
            $orderData = array();
            $orderData['checkout']['billing'] = array(
                'name' => $userData['first_name'] . ' ' . $userData['last_name'],
                'company' => '',
                'add_01' => (!empty($userData['address']) ? $userData['address'] : $_POST['address_name'].$_POST['address_street']),
                'city' => (!empty($userData['city']) ? $userData['city'] : $_POST['address_city']),
                'state' => (!empty($userData['state']) ? $userData['state'] : $_POST['address_state']),
                'post_code' => (!empty($userData['postcode']) ? $userData['postcode'] : $_POST['address_zip']),
                'country' => (!empty($userData['country']) ? $userData['country'] : $_POST['address_state']),
            );

            $orderData['checkout']['shipping'] = array(
                'name' => $userData['first_name'] . ' ' . $userData['last_name'],
                'company' => '',
                'add_01' => (!empty($userAddressData['s_address']) ? $userAddressData['s_address'] : $_POST['address_name'].$_POST['address_street']),
                'add_02' => (!empty($userAddressData['s_address']) ? $userAddressData['s_address'] : $_POST['address_name'].$_POST['address_street']),
                'city' => (!empty($userAddressData['s_city']) ? $userAddressData['s_city'] : $_POST['address_city']),
                'state' => (!empty($userAddressData['s_state_id']) ? $userAddressData['s_state_id'] : $_POST['address_state']),
                'post_code' => (!empty($userAddressData['s_postcode']) ? $userAddressData['s_postcode'] : $_POST['address_zip']),
                'country' => "US",
            );

            $orderData['checkout']['email'] = $userData['email']; //$userData['email'];
            $this->data = $orderData;
            $orderData['checkout']['phone'] = $userData['phone'];
            $orderData['checkout']['comments'] = 'Paypal Payment';

            // $_SESSION['flexi_cart']['tax']['data']['item_total_tax'] = $_SESSION['flexi_cart']['summary']['tax_total'];
//            $orderData['checkout']['tax_percentage'] = $_SESSION['flexi_cart']['summary']['tax_percentage'];

            $order_number_last = $_SESSION['flexi_cart']['settings']['configuration']['order_number'];            
            // $this->order_summary->update_tax($order_number_last, $_SESSION['flexi_cart']['summary']);

            // $this->order_summary->insert_custom($order_number_last);

            $user_id = $this->session->userdata('user_id');
            
            $this->data['cart_items'] = $this->flexi_cart->cart_items();

            foreach ($this->data['cart_items'] as $k => $val) {
                if(isset($val['rent_id']) && !empty($val['rent_id']) && $val['rent_id'] == '1') {

                    $time = strtotime(str_replace('/', '-', $val['rent_start_date']));
                    $start_date_formatted = date('Y-m-d',$time);
                    // create the array of values to put in to the database
                    $data_array = array(
                        'user_id' => $user_id,
                        'product_id' => $val['id'],
                        'duration' => $val['rent_duration_val'],
                        'param' => $val['rent_duration_param'],
                        'rent' => $val['rent'],
                        'order_id' => $order_number_last,
                        'start_date' => $start_date_formatted
                    );

                    // $this->db->insert('tbl_order_rent_details', $data_array);
                    if($this->db->insert('tbl_order_rent_details', $data_array)) {

                        // load the view and pass the paypal success message
                        $order_success = '<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">';
                        $order_success .= '<tr><td style="padding:20px;"><b>Hello User, Your rental for product '.$val['name'].' has been accepted.</b></td></tr><tr></tr>
                                            <tr>
                                                <td class="tablepadding" style="padding:20px;">
                                                <table class="" style="border-collapse:collapse;width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:7px;color:#222222">Product</td>
                                                            <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222">Qty</td>
                                                            <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222">Rent</td>
                                                            <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222">Total</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>';
                        if (isset($this->data['cart_items']) && !empty($this->data['cart_items'])) {
                            foreach ($this->data['cart_items'] as $sid => $cData) {
                                    $order_success .= '<tr>
                                            <td style="font-size:13px;border-left: 1px solid #dddddd;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px">'.$cData['name'].'<br />
                                            <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">'.$cData['quantity'].'</td>
                                            <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">$'.$cData['internal_price'].'</td>
                                            <td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">$'.(floatval($cData['internal_price']) * floatval($cData['quantity'])).'</td>
                                        </tr>';
                            }

                            $order_success .= '<tr><td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;font-weight:bold;text-align:right;padding:7px;border-left: 1px solid #dddddd;color:#222222" colspan="3">Start Date</td><td style="font-size:13px;border-right:1px solid #dddddd;border-left: 1px solid #dddddd;border-bottom:1px solid #dddddd;font-weight:bold;text-align:right;padding:7px;color:#222222" colspan="3" colspan="1">'.$start_date_formatted.'</td></tr><tr><td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;font-weight:bold;text-align:right;padding:7px;border-left: 1px solid #dddddd;color:#222222" colspan="3" colspan="3">Rent Duration</td><td style="font-size:13px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;font-weight:bold;text-align:right;padding:7px;color:#222222" colspan="1">'.$val['rent_duration_val'].' '.$val['rent_duration_param'].'</td></tr>';
                        }
                        
                        $order_success .= '<tr>
                              <td colspan="4">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-size:13px;color:#555555;font-family:Arial, Helvetica, sans-serif;">
                                  <tbody>
                                    <tr>
                                      <td class="m_2325894079705929180m_-187537962896113558tablepadding" align="center" style="font-size:14px;line-height:22px;padding:20px;border-top:1px solid #ececec;"> Any Questions? Get in touch with our 24x7 Customer Care team.<br>
                                        866-748-4737 | 626-821-9400 | 626-821-9401
                                      </td>
                                      
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>';
                        $order_success .= '</tbody></table></tr></table>';

                        
                        // email parameters
                        $email = 'harshalb@rebelute.com';
                        $message = $order_success;
                        $subject = 'Buy Sell Rent | Your order was placed successfully!';
                        // $sentTo = $userData['email'];
                        $sentTo = 'harshalb@rebelute.com';

                        // $this->email($email, $message, $subject, $sentTo);
                        $this->common_model->sendEmail($sentTo, $message, $subject);
                    }
                }
            }


            /* Step one : Apply discount &  calculation */
            $this->data['discounts'] = $this->flexi_cart->summary_discount_data();
            
            if (isset($this->data['discounts']['total']) && $this->data['discounts']['total']['value_desc']) {
                $dis = $this->data['discounts']['total']['value_desc'];
                $discount_val = ($this->data['cart_summary']['item_summary_total'] * $dis) / 100;
                $orderData['checkout']['ord_reward_voucher_desc'] = $this->data['discounts']['total']['value_desc'];
                $orderData['checkout']['discount_saving_total'] = $discount_val;
            }

            if (isset($this->session->userdata('flexi_cart')['summary']))
                $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];

            if(isset($this->data['cart_summary']['tax_total']) && !empty($this->data['cart_summary']['tax_total'])) {
                
                $_SESSION['flexi_cart']['tax']['data']['item_total_tax'] = ($_SESSION['flexi_cart']['summary']['item_summary_total']/100)*($_SESSION['flexi_cart']['summary']['tax_total']);

                $orderData['checkout']['ord_tax_rate'] = $this->data['cart_summary']['tax_total'];
                $orderData['checkout']['ord_tax_total'] = $_SESSION['flexi_cart']['tax']['data']['item_total_tax'];
            }

            // save the flag of order (pre-order = 2 | rent order = 1 | buy order = 0)
            foreach ($this->data['cart_items'] as $ky => $val) {
                if($val['stock_quantity'] <= 0 && $val['rent_id'] == '0') {
                    $orderData['checkout']['order_type'] = '2';
                } else if ($val['stock_quantity'] > 0 && $val['rent_id'] == '1') {
                    $orderData['checkout']['order_type'] = '1';
                } else {
                    $orderData['checkout']['order_type'] = '0';
                }
            }

            // set the final total value
            $ret = $this->demo_cart_model->demo_save_order($orderData);
            
            /* Step one : Apply discount &  calculation */

            /* Order */
            //send email
            $this->data = $orderData;
            $this->data['order_date'] = date('Y-m-d H:m:s');
            $this->data['payment_type'] = "Paypal";
            $this->data['user_name'] = $userData['first_name'] . ' ' . $userData['last_name'];
            $this->data['phone'] = $userData['phone'];
            $this->data['order_id'] = $order_number_last;
            $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
            $this->data['cart_items'] = $this->flexi_cart->cart_items();
            
            $order_success = $this->load->view('paypal_success', $this->data, TRUE);

            $email = 'harshalb@rebelute.com';
            $message = $order_success;
            $subject = 'Buy Sell Rent | Your order was placed successfully!';
            // $sentTo = $userData['email'];
            $sentTo = 'harshalb@rebelute.com';

            // $this->email($email, $message, $subject, $sentTo);
            $this->common_model->sendEmail($sentTo, $message, $subject);

            $this->clear_cart();
            $this->session->set_flashdata('order_id', $order_number_last);
            $_SESSION['payment_status'] = 'paypal_success';
            redirect('home/paypal_payment_success');

        } else {

            echo "in paypal cancel block"; die;
            redirect('home/paypal_cancel');
        }
        
        if ($this->session->userdata('user_id')) {
            $user_id = $this->session->userdata('user_id');
            $this->db->delete('cart_data', array('cart_data_user_fk' => $user_id));
        }
    }


    public function paypal_payment_success() {

        // $this->session->unset_userdata('payment_success');

        // $this->data = null;
        // echo $this->session->userdata('order_id'); die;


        // Get an array of all order details related to the above order, filtered by the order number in the url.
        // $sql_where = array($this->flexi_cart_admin->db_column('order_details', 'order_number') => $this->session->usrdata('order_id'));
        // $this->data['item_data'] = $this->flexi_cart_admin->get_db_order_detail_array(FALSE, $sql_where);

        $pageTitle = 'Buy Sell Rent | Payment Success';
        $renderTo = 'paypal_payment_success';
        $viewData = '';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $viewData);
    }


    /**
    * @author : Harshal Borse <harshalb@rebelute.com>
    * @date   : 04 DEC 2017
    * save user adrress entered from checkout page as shipping and billing address
    */
    public function saveCheckoutAddress() {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        // get the user id from session
        $user_id = trim($this->session->userdata('user_id'));

        $data_shipping_array = array(
            's_address' => trim($this->input->post('shippingaddress')),
            's_country_id' => '231',
            's_state_id' => trim($this->input->post('shippingstate')),
            's_city' => trim($this->input->post('shippingcity')),
            's_postcode' => trim($this->input->post('shippingpostcode')),
            's_phone' => trim($this->input->post('shippingtelephone')),
            'user_id' => $user_id
        );

        $data_billing_array = array(
            'address' => trim($this->input->post('billingaddress')),
            'country' => '231',
            'state' => trim($this->input->post('billingstate')),
            'city' => trim($this->input->post('billingcity')),
            'postcode' => trim($this->input->post('billingpostcode')),
            'phone' => trim($this->input->post('billingtelephone')),
        );

        $this->db->where('id', $user_id);
        $this->db->update('users', $data_billing_array);

        // check if the user address is already exists
        $this->data['get_address'] = $this->addresses->get_by(array('user_id' => $user_id));

        if(count($this->data['get_address']) >= 1) {
            $this->db->where('user_id', $user_id);
            $this->db->update('tbl_addresses', $data_shipping_array);
        } else {
            $this->db->insert('tbl_addresses', $data_shipping_array);
        }

        $this->data['tax_array'] = $this->tax->get_tax_rate(trim($this->input->post('shippingpostcode')));
        
        $_SESSION['flexi_cart']['summary']['tax_total'] = $this->data['tax_array']['combined_rate'];        

        // foreach ($this->data['cart_items'] as $key => $cData) {
        //     $this->data['cart_items'][$key]['zipcode_tax_rate'] = $this->tax->get_tax_rate(trim($this->input->post('shippingpostcode')));
        // }

        // set the response message
        $this->output->set_header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array('status' => '1', 'message' => 'Billing & Shipping address is saved successfully')); exit;
    }

    public function clear_cart() {
        // The 'empty_cart()' function allows an argument to be submitted that will also reset all shipping data if 'TRUE'.
        $this->flexi_cart->empty_cart(TRUE);

        // Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());
        return true;
    }

    /**
    * @author : Harshal Borse <harshalb@rebelute.com>
    * @date   : 17 Nov 2017
    * Paypal payment gateway integration - redirect to the success page
    */
    public function payment_success_status() {

        $user_id = $this->session->userdata('user_id');

        if (isset($_POST) && !empty($_POST)) {


            $dataPayment = array(
                'user_id' => $user_id,
                'txn_id' => $this->input->post('txn_id'),
                'payment_gross' => $this->input->post('payment_gross'),
                'currency_code' => $this->input->post('mc_currency'),
                'payer_email' => $this->input->post('payer_email'),
                'payment_status' => $this->input->post('payment_status'),
            );
            
            foreach ($this->data['cart_items'] as $key => $cartData) {
                $dataPayment['row_id'] = $cartData['row_id'];
                $dataPayment['product_id'] = $cartData['id'];

//            $dataPayment['payment_gross'] = $cartData['internal_price'];
                $dataPayment['payment_via'] = 'paypal';
                $this->payment->insert($dataPayment);
            }

            /* Best Seller Count */
            foreach ($this->data['cart_items'] as $key => $cartData) {
                $dataPayment['product_sale_count'] = $cartData['quantity'];
                $dataPayment['product_quantity'] = $cartData['quantity'];
                $this->product->update_sale_count($cartData['id'], $dataPayment);
            }
            /* Best Seller Count */

//            $this->createShip();

            /* Order */
            $orderData = array();
            $orderData['checkout']['billing'] = array(
                'name' => $this->input->post('first_name') . ' ' . $this->input->post('last_name'),
                'company' => '',
                'add_01' => $this->input->post('address_name') . $this->input->post('address_street'),
                'add_02' => '',
                'city' => $this->session->userdata('flexi_cart')['summary']['selected_city'],
                'state' => $this->input->post('address_state'),
                'post_code' => $this->session->userdata('flexi_cart')['summary']['zipcode'],
                'country' => "US",
            );
            $orderData['checkout']['shipping'] = array(
                'name' => $this->input->post('first_name') . ' ' . $this->input->post('last_name'),
                'company' => '',
                'add_01' => $this->input->post('address_name') . $this->input->post('address_street'),
                'add_02' => '',
                'city' => $this->session->userdata('flexi_cart')['summary']['selected_city'],
                'state' => $this->input->post('address_state'),
                'post_code' => $this->session->userdata('flexi_cart')['summary']['zipcode'],
                'country' => "US",
            );
            $orderData['checkout']['email'] = $this->input->post('payer_email');
//            $orderData['checkout']['phone'] = $this->input->post('phone');
//            $orderData['checkout']['comments'] = '';

            /* Order */

            $ret = $this->demo_cart_model->demo_save_order($orderData);
            $this->data['order_summary'] = $this->session->userdata('flexi_cart')['summary'];

            $message = $this->load->view('order_success', $this->data, TRUE);
            $subject = 'Jesupwireless | Order successfully placed';
            $this->email($orderData['checkout']['email'], $message, $subject);

        } else {
            redirect('home/checkout/cancel');
        }

        // unset the payment success session variable
        $this->session->unset_userdata('payment_success');
        
        // render the view
        $this->data = null;
        $pageTitle = 'Buy Sell Rent | Paypal Payment Success';
        $renderTo = 'paypal_success';
        $viewData = '';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $viewData);
    }

    /**
    * @author : Harshal Borse <harshalb@rebelute.com>
    * @date   : 17 Nov 2017
    * Paypal payment gateway integration - calcel page if payment failed or cancel
    */
    public function paypal_cancel() {

        $user_id = $this->session->userdata('user_id');
        
        if (isset($_POST) && !empty($_POST)) {

            $dataPayment = array(
                'user_id' => $user_id,
                'txn_id' => $this->input->post('txn_id'),
                'payment_gross' => $this->input->post('payment_gross'),
                'currency_code' => $this->input->post('mc_currency'),
                'payer_email' => $this->input->post('payer_email'),
                'payment_status' => $this->input->post('payment_status'),
            );
            
            foreach ($this->data['cart_items'] as $key => $cartData) {
                $dataPayment['row_id'] = $cartData['row_id'];
                $dataPayment['product_id'] = $cartData['id'];
                $dataPayment['payment_gross'] = $cartData['internal_price'];
                $dataPayment['payment_via'] = 'paypal';
                $this->payment->insert($dataPayment);
            }
        }

        // render the view
        $this->data = null;
        $pageTitle = 'Buy Sell Rent | Paypal Payment Cancel';
        $renderTo = 'paypal_cancel';
        $viewData = '';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $viewData);

        // $this->session->set_flashdata('message', 'Your last transaction is cancelled');
        // redirect('home/paypal_cancel');
    }

    /**
     * user orders list view page
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       string  $pageTitle, string $renderTo, string $viewData
     * @return      renders to view
     */
    public function orderList() {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        // get the user id from session
        $user_id = trim($this->session->userdata('user_id'));

        $pageTitle = 'Buy Sell Rent | My Orders';
        $renderTo = 'my_orders';


        // get all user data from session
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        // get the cart item from flexi cart 
        $this->data['cart_items'] = $this->flexi_cart->cart_items();
        
        // set the country list and state list in to the dropdown
        // $this->data['country_list'] = (array('' => 'Select Country')) + $this->country->dropdown('name');        
        // $this->data['state_list'] = (array('' => 'Select State')) + $this->state->dropdown('name');

        // get the user orders based on user id
        $this->data['my_orders'] = $this->orders_summary->get_by_id($user_id);

        // count all records fetched from database
        $totalRec = $this->orders_summary->count_by(array('ord_user_fk' => $user_id));

        /* Ajax Pagination */
        $config['uri_segment'] = 3;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'home/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilterOrder';
        $this->ajax_pagination->initialize($config);
        
        // $this->data = $this->_get_all_data();
        // $this->data['pages'] = $this->pages_model->as_array()->get_all();

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }


    /**
     * out of stock notification subscription for rent product section
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       string  $pageTitle, string $renderTo, string $viewData
     * @return      renders to view
     */
    public function outOfStockNotification()
    {        
        if(trim($this->input->post('email')) && !empty($this->input->post('email'))) {

            // check if the already subscribed for notification
            $get_record = $this->out_of_stock_notify->get_by(array('email' => trim($this->input->post('email')), 'product_id' => trim($this->input->post('rent_product_id'))));
            

            // check if email id is already exists
            if (count($get_record) >= 1) {
                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '0', 'message' => 'You already have subscribed for notification'));
            } else {
                $data_array = array(
                    'email' => trim($this->input->post('email')),
                    'product_id' => trim($this->input->post('rent_product_id'))
                );

                if($this->db->insert('tbl_out_of_stock_notification', $data_array)) {
                    $this->output->set_header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(array('status' => '1', 'message' => 'We will notify you once product will be in stock'));
                } else {
                    $this->output->set_header('Content-Type: application/json; charset=utf-8');
                    echo json_encode(array('status' => '0', 'message' => 'Failed to process you request'));
                }
            }
        }
    }


    /**
     * user orders list view page
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       string  $pageTitle, string $renderTo, string $viewData
     * @return      renders to view
     */
    public function myRentedProducts() {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }

        // get the user id from session
        $user_id = trim($this->session->userdata('user_id'));

        $pageTitle = 'Buy Sell Rent | My Rented Products';
        $renderTo = 'my_rented_products';

        // get the user orders based on user id
        $this->data['my_rented_list'] = $this->common_model->getrentedProducts($user_id);

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }


    /**
     * show the order details base on order id
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       string  $order_id
     * @return      Order details section
     */
    public function orderDetails() {

        $this->data = null;
        $pageTitle = 'Buy Sell Rent | My Orders';
        $renderTo = 'order_details';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * show the user account
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       string  $pageTitle, string $renderTo, string $viewData
     * @return      my account section
     */
    public function my_account() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        
        // check if the user is logged in
        if (!empty($this->session->userdata('user_id'))) {

            $user_id = $this->session->userdata('user_id');
            
            $this->data = null;

            // get the user details
            $this->data['get_address'] = $this->addresses->as_array()->get_by(array('user_id' => $user_id));

            $this->data['account_details'] = $this->users->get_allData($user_id);
            
            $pageTitle = 'Buy Sell Rent | My Account';
            $renderTo = 'my_account';

            $this->db->select('id, name');
            $this->db->from('tbl_countries');
            $query = $this->db->get();
            $this->data['country_list'] = $query->result_array();

            $this->db->select('id, name');
            $this->db->from('tbl_states');
            $query = $this->db->get();
            $this->data['state_list'] = $query->result_array();            

            // call the render view function here
            $this->_renders_view($pageTitle, $renderTo, $this->data);
        } else {
            // redirect to the login
            redirect('login', 'refresh');
        }
    }

    /**
     * update the user account details & shipping address
     * @author      Harshal B <harshalb@rebelute.com>
     * @return      my account section view
     */
    public function update_myaccount() {

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        $user_id = $this->session->userdata('user_id');
        $data['dataHeader'] = $this->users->get_allData($user_id);

        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;
        
        $data_arry = array(
            's_first_name' => $this->input->post('shipping_first_name'),
            's_last_name' => $this->input->post('shipping_last_name'),
            's_phone' => $this->input->post('shipping_telephone'),
            's_company' => $this->input->post('shipping_company'),            
            's_address' => $this->input->post('shipping_address'),
            's_city' => $this->input->post('shipping_city'),
            's_country_id' => $this->input->post('shipping_country_id'),
            's_postcode' => $this->input->post('shipping_postcode'),
            's_state_id' => $this->input->post('shipping_zone_id'),
            'user_id' => $user_id,
        );      

        $this->data['get_address'] = $this->addresses->as_array()->get_by(array('user_id' => $user_id));        
        
        if(empty($this->data['get_address'])) {
            // check to see if we are updating the user
            if ($this->addresses->insert($data_arry)) {
                // redirect them back to the admin page if admin, or to the base url if non admin
                $this->session->set_flashdata('message', "Your account information inserted successfully");
                redirect('my_account', 'refresh');
            } else {
                // redirect them back to the admin page if admin, or to the base url if non admin
                $this->session->set_flashdata('error', "Failed to process your request.");
                redirect('my_account', 'refresh');
            }

        } else {

            $condition = array('user_id' => $user_id);

            // check to see if we are updating the user
            if ($this->common_model->updateRow('tbl_addresses', $data_arry, $condition)) {                
                // redirect them back to the admin page if admin, or to the base url if non admin
                $this->session->set_flashdata('message', "Your account information updated successfully");
                redirect('my_account', 'refresh');
            } else {
                // redirect them back to the admin page if admin, or to the base url if non admin
                $this->session->set_flashdata('error', "Failed to process your request.");
                redirect('my_account', 'refresh');
            }
        }
    }

    /**
     * filter product view
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       string  filter parameters
     * @return      filtered product view
     */
    public function filterProductList() {

        $start_price = ($this->input->post('start_price') !== '' ? trim($this->input->post('start_price')) : '');
        $end_price = (!empty($this->input->post('end_price')) ? trim($this->input->post('end_price')) : '');
        $category_id = (!empty($this->input->post('category_id')) ? trim($this->input->post('category_id')) : '');
        $subcategory_id = (!empty($this->input->post('subcategory_id')) ? trim($this->input->post('subcategory_id')) : '');

        $search_param = (!empty($this->input->post('search_param')) ? trim($this->input->post('search_param')) : '');
        $instock_search = (!empty($this->input->post('instock_search')) ? trim($this->input->post('instock_search')) : '');
        $attribute_search = (!empty($this->input->post('attribute_search')) ? trim($this->input->post('attribute_search')) : '');
        $brand_search = (!empty($this->input->post('brand_search')) ? trim($this->input->post('brand_search')) : '');

        // execute the query for filter products from product table
        $this->data['product_details'] = $this->product->filterProductsByPrice($category_id, $subcategory_id, $start_price, $end_price, $search_param, $attribute_search, $instock_search, $brand_search);
        
        echo json_encode(array('content' => $this->load->view('home/ajax_product_view', $this->data, TRUE)));
        die;
    }

    /**
     * get the state list for registration page & checkout page
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       string  filter parameters
     * @return      state list array
     */
    function getStateList() {

        if (isset($_POST)) {

            $country_id = $_POST['country_id'];


            $states = $this->state->get_StateListById($country_id);
            $st = '';
            foreach ($states as $state) {
                $st .= '<option value="' . $state['id'] . '">' . $state['name'] . '</option>';
            }
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('content' => $st));
        } else {
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('content' => ''));
        }
    }

    /**
     * show the user account
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       string  $pageTitle, string $renderTo, string $viewData
     * @return      my account section
     */
    public function categories($category_id = NULL) {

        $this->data = null;

        $user_id = $this->session->userdata('user_id');
        $pageTitle = 'Buy Sell Rent | My Account';
        $renderTo = 'home/all_categories';

        // $this->data['category_list_details'] = $this->product_category->as_array()->get_all();

        $this->data['product_categories_level'] = $this->product_category->get_all_categories_by_level($category_id);
        if(!empty($this->data['product_categories_level'])) {
            foreach ($this->data['product_categories_level'] as $k => $pData) {
                $this->data['product_categories_level'][$k]['sub_categories'] = $this->product_sub_category->get_sub_categories($pData['id']);
                foreach ($this->data['product_categories_level'][$k]['sub_categories'] as $key => $third_level_list) {
                    $this->data['product_categories_level'][$k]['sub_categories'][$key]['third_level'] = $this->product_sub_category->get_sub_categories($third_level_list['id']);
                    foreach ($this->data['product_categories_level'][$k]['sub_categories'][$key]['third_level'] as $key4 => $forth_level_list) {
                        $this->data['product_categories_level'][$k]['sub_categories'][$key]['third_level'][$key4]['forth_level'] = $this->product_sub_category->get_sub_categories($forth_level_list['id']);
                    }
                }
            }
        }
        
        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }


    public function ajaxPaginationData($category_id) {

        $page = $this->input->post('page');

        if(!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        
        // total rows count
        $this->data['product_details'] = $this->product->get_product_count_by_category_subcategory($category_id, NULL);
        $total_row = count($this->data['product_details']);
        
        //pagination configuration
        /* Ajax Pagination */
        $config['uri_segment'] = 4;
        $config['target'] = '.product_filter';
        $config['base_url'] = base_url() . 'home/ajaxPaginationData/'.$category_id;
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->perPage;
        // $config['link_func'] = 'searchFilterProduct';
        $this->ajax_pagination->initialize($config);
        
        // get the posts data
        // $data['posts'] = $this->product->getRows(array('start' => $offset, 'limit' => $this->perPage));
        $this->data['product_details'] = $this->product->get_product_by_category_subcategory($category_id, NULL, $offset, $this->perPage);

        $this->data['product_attributes'] = $this->product->getAllAttributes();
        
        foreach ($this->data['product_attributes'] as $key => $cData) {
            $this->data['product_attributes'][$key]['sub_attributes_values'] = $this->product->getAttributeValuesById($cData['attribute_value']);
        }
        
        // load the view
        $this->load->view('home/ajax_product_view', $this->data, false);
    }

    
    // function USPSParcelRate($weight,$dest_zip) {
    function USPSParcelRate() {

        $this->load->library('USPS');

        $weight = $this->input->post('weight');
        $dest_zip = $this->input->post('zipcode');

        //CREATE AN ARRAY OF ADDRESSES (MAX 5)
        $addresses = array(
            '0' => array(
                'service' => 'PRIORITY',
                'zip_origination' => '44106',
                'zip_destination' => $dest_zip,
                'pounds' => $weight,
                'ounces' => '8',
                'container' => 'NONRECTANGULAR',
                'size' => 'LARGE',
                'width' => '21',
                'length' => '30',
                'height' => '21',
                'girth' => '55'
            ),
        );

        //RUN ZIP CODE LOOKUP   
        // $zip_code_lookup = $this->usps->shipping_rate_lookup($addresses);

        // echo "<pre>";
        // // OUTPUT RESULTS
        // print_r($zip_code_lookup);
        // $final_ship_rate = $zip_code_lookup->Package->Postage->Rate[0];

        // echo $final_ship_rate; die;

        // set the response message
        // $this->output->set_header('Content-Type: application/json; charset=utf-8');
        // echo json_encode(array('status' => '1', 'shipping_cost' => $final_ship_rate)); exit;

        // $weight = $this->input->post('weight');
        // $dest_zip = $this->input->post('zipcode');

        // $packages = array(
        //     'zip_origination' => '33156',
        //     'zip_destination' => $dest_zip,
        //     'pounds' => $weight,
        //     'ounces' => '3.12345678',
        // );

        // $response = $this->usps->shipping_rate_lookup($dest_zip, $weight);

        // echo "<hr /><h1>DEBUG</h1><pre>";
        // print_r($response);
        // echo "</pre>";
        // die();
        

        // $weight = $this->input->post('weight');
        // $dest_zip = $this->input->post('zipcode');

        // // This script was written by Mark Sanborn at http://www.marksanborn.net  
        // // If this script benefits you are your business please consider a donation  
        // // You can donate at http://www.marksanborn.net/donate.  

        // // ========== CHANGE THESE VALUES TO MATCH YOUR OWN ===========

        // $userName = '184IS2PO3734'; // Your USPS Username
        // $orig_zip = '33156'; // Zipcode you are shipping FROM

        // // =============== DON'T CHANGE BELOW THIS LINE ===============

        // $url = "http://production.shippingapis.com/ShippingAPI.dll";

        // $ch = curl_init();

        // // set the target url
        // curl_setopt($ch, CURLOPT_URL,$url);
        // curl_setopt($ch, CURLOPT_HEADER, 1);
        // curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        // // parameters to post
        // curl_setopt($ch, CURLOPT_POST, 1);

        // // $data = "API=RateV4&XML=<RateV4Request USERID=\"$userName\"><Revision>2</Revision><Package ID=\"1ST\"><Service>FIRST CLASS</Service><FirstClassMailType>LETTER</FirstClassMailType><ZipOrigination>$orig_zip</ZipOrigination><ZipDestination>$dest_zip</ZipDestination><Pounds>$weight</Pounds><Ounces>3.12345678</Ounces><Container/>";

        // $data = "API=ZipCodeLookup&XML=<ZipCodeLookupRequest USERID=\"$userName\"><Address ID=\"1\"><Address1></Address1><Address2>8 Wildwood Drive</Address2><City>Old Lyme</City><State>CT</State><Zip5>".$orig_zip."</Zip5><Zip4></Zip4></Address></ZipCodeLookupRequest>";

        // // echo $data; die;
        // // send the POST values to USPS
        // curl_setopt($ch, CURLOPT_POSTFIELDS,$data);

        // $result = curl_exec ($ch);
        // // echo "<hr /><h1>DEBUG</h1><pre>";
        // // print_r($result);
        // // echo "</pre>";
        // // die();
        
        // $data = strstr($result, '<?');
        // // echo '<!-- '. $data. ' -->'; // Uncomment to show XML in comments
        // $xml_parser = xml_parser_create();
        // xml_parse_into_struct($xml_parser, $data, $vals, $index);
        // xml_parser_free($xml_parser);
        // $params = array();
        // $level = array();
        // foreach ($vals as $xml_elem) {
        //     if ($xml_elem['type'] == 'open') {
        //         if (array_key_exists('attributes',$xml_elem)) {
        //             list($level[$xml_elem['level']],$extra) = array_values($xml_elem['attributes']);
        //         } else {
        //         $level[$xml_elem['level']] = $xml_elem['tag'];
        //         }
        //     }
        //     if ($xml_elem['type'] == 'complete') {
        //     $start_level = 1;
        //     $php_stmt = '$params';
        //     while($start_level < $xml_elem['level']) {
        //         $php_stmt .= '[$level['.$start_level.']]';
        //         $start_level++;
        //     }
        //     $php_stmt .= '[$xml_elem[\'tag\']] = $xml_elem[\'value\'];';
        //     eval($php_stmt);
        //     }
        // }
        // curl_close($ch);
        // echo '<pre>'; print_r($params); echo'</pre>'; // Uncomment to see xml tags
        // die;
        // echo $params['RATEV4RESPONSE']['1ST']['1']['RATE']; die;
        // return $params['RATEV4RESPONSE']['1ST']['1']['RATE'];
    }

    /**
     * validate the zipcode from USPS shipping API
     * @author      Harshal Borse <harshalb@rebelute.com>
     * @param       $zipcode
     * @return      validate of zipcode
     */
    public function validateUSPSZipcode() {

        $zipcode = $this->input->post('zipcode');

        echo $zipcode; die;
    }


    /**
    * Shipping Labels
    * @desc Gets PDF generated shipping label and tracking information
    * @docs https://www.usps.com/business/web-tools-apis/usps-tracking-v3-3.htm
    * @parameters $from (array), $to (array), $weight_in_ounces, $service_type, $dimensions (array), $container, $size, $insured_amount
    * $from = array(
    *            'from_name' => 'John Smith',
    *            'from_firm' => 'ABC Inc.',
    *            'from_address1' => '123 Main St.',
    *            'from_address2' => 'Suite 100',
    *            'from_city' => 'Anytown',
    *            'from_state' => 'PA',
    *            'from_zip5' => '12345');
    * 
    *  $to = array(
    *            'to_name' => 'Mike Smith',
    *            'to_firm' => 'XYZ Inc.',
    *            'to_address1' => '456 2nd St.',
    *            'to_address2' => 'Apt B',
    *            'to_city' => 'Othertown',
    *            'to_state' => 'NY',
    *            'to_zip5' => '67890');
    * 
    * $dimensions = array(
    *            'width' => 5.5,
    *            'length' => 11,
    *            'height' => 11,
    *            'girth' => 11);
    * 
    * $service_type can be Priority, First Class, Standard Post, Medial Mail or Library Mail
    * $container can be VARIABLE, RECTANGULAR, NONRECTANGULAR, FLAT RATE ENVELOPE, FLAT RATE BOX, etc.
    * $dimensions array is REQUIRED when SIZE == LARGE
    * @access public
    * @return simple xml object - the <DeliveryConfirmationLabel> node of the response XML is a base64 binary image (the label)
    */
    function get_shipping_label($from, $to, $weight_in_ounces, $service_type, $dimensions = array(), $container = "VARIABLE", $size = "REGULAR", $insured_amount = 0)
    {

        $from = array(
            'from_name' => 'Harshal Borse',
            
        );

        $xml = '<DelivConfirmCertifyV4.0Request USERID="'.$this->user_id.'">';
        $xml .= '<Revision>2</Revision>';
        $xml .= '<ImageParameters />'; //Not yet implemented by this function

        /**
         * The FROM (origination) information
         */
        $xml .= '<FromName>'.$from['from_name'].'</FromName>';
        $xml .= '<FromFirm>'.isset($from['from_firm'])? $from['from_firm'] : ''.'</FromFirm>'; //can be blank
        //Address 1 and Address 2 are reverse from what is typically standard
        $xml .= '<FromAddress1>'.isset($from['from_address2']) ? $from['from_address2'] : ''.'</FromAddress1>';
        $xml .= '<FromAddress2>'.$from['from_address1'].'</FromAddress2>';
        $xml .= '<FromCity>'.$from['from_city'].'</FromCity>';
        $xml .= '<FromState>'.strtoupper($from['from_state']).'</FromState>';
        $xml .= '<FromZip5>'.$from['from_zip5'].'</FromZip5>';
        $xml .= '<FromZip4/>'; //Not yet implemented

        /**
         * The TO (destination) information
         */
        $xml .= '<ToName>'.$to['to_name'].'</ToName>';
        $xml .= '<ToFirm>'.isset($to['to_firm'])? $to['to_firm'] : ''.'</ToFirm>'; //can be blank
        //Address 1 and Address 2 are reverse from what is typically standard
        $xml .= '<ToAddress1>'.isset($to['to_address2']) ? $to['to_address2'] : ''.'</ToAddress1>';
        $xml .= '<ToAddress2>'.$to['to_address1'].'</ToAddress2>';
        $xml .= '<ToCity>'.$to['to_city'].'</ToCity>';
        $xml .= '<ToState>'.strtoupper($to['to_state']).'</ToState>';
        $xml .= '<ToZip5>'.$to['to_zip5'].'</ToZip5>';
        $xml .= '<ToZip4/>'; //Not yet implemented

        /**
         * Container Type, Weight and Size plus requested Service
         */
        $xml .= '<WeightInOunces>'.$weight_in_ounces.'</WeightInOunces>';
        $xml .= '<ServiceType>'.$service_type.'</ServiceType>';
        if ($insured_amount > 0) $xml .= '<InsuredAmount>'.$insured_amount.'</InsuredAmount>';
        $xml .= '<ImageType>PDF</ImageType>'; //Eventually could make this an option in the parameters - either PDF, TIF or GIF is accepted by API
        $xml .= '<Container>'.strtoupper($container).'</Container>';
        $xml .= '<Size>'.strtoupper($size).'</Size>';

        if (!empty($dimensions) || strtoupper($size) == "LARGE") {

            //just in case $dimensions is not set and SIZE is LARGE, some default dimensions are provided to prevent failure
            $xml .= '<Width>'.isset($dimensions['width']) ? $dimensions['width'] : '12'.'</Width>';
            $xml .= '<Length>'.isset($dimensions['length']) ? $dimensions['width'] : '12'.'</Length>';
            $xml .= '<Height>'.isset($dimensions['height']) ? $dimensions['height'] : '12'.'</Height>';
            $xml .= '<Girth>'.isset($dimensions['girth']) ? $dimensions['girth'] : '60'.'</Girth>';
        }

        $xml .= '</DelivConfirmCertifyV4.0Request>';

        return $this->_request('DelivConfirmCertifyV4',$xml);
    }

    /**
     * check the rental duration and send the notifiction to the user 8 hours before end of duration
     * @author      Harshal Borse <harshalb@rebelute.com>
     * @param       $zipcode
     * @return      notification email
     */
    public function sendRentalNotification()
    {
        // get all the users from database
        $this->db->select("usr.email, ord.name, DATEDIFF(STR_TO_DATE(ord.start_date, '%Y-%m-%d'), CURDATE()) AS days, ord.duration, ord.param, ord.rent, ord.order_id, ord.start_date");
        $this->db->join('users usr', 'usr.id = ord.user_id', 'LEFT');
        $qry = $this->db->get('tbl_order_rent_details ord');        
        
        $this->data['rent_orders'] = $qry->result_array();        

        foreach ($this->data['rent_orders'] as $key => $value) {
            // check if the difference is 1 day then send notification to the user
            if($value['days'] == 1) {
                
                // send the notification email when 
                $message = 'Hi User,<br><br>';
                $message .= 'Your rental duration for product <b>'.$value['name'].'</b> is ending tomorrow.'.'<br><br><hr>';
                $message .= 'Order Id : #'.$value['order_id'].'<br><br>';
                $message .= 'Start Date : '.$value['start_date'].'<br><br>';
                $message .= 'Duration : '.$value['duration'].' '.$value['param'].'<br><br>';
                $message .= 'Rent : $'.$value['rent'].'/'.$value['param'].'<br><br>';
                $message .= '<hr>Buy Sell Rent Team<br><br>';
                $subject = 'Buy Sell Rent - Rental Notification';

                // $this->email($this->input->post('email'), $message, $subject);
                if($this->common_model->sendEmail($value['email'], $message, $subject)) {
                    echo "Email sent";
                }
            }
        }    
    }


    /**
     * Render views
     * @author      Mayur V <mayurv@rebelute.com>
     * @param       string  $pageTitle, string $renderTo, string $viewData
     * @return      renders to view
     */
    public function _renders_view($pageTitle, $renderTo, $viewData) {

        $user_id = $this->session->userdata('user_id');
        
        // check if the user id logged in
        if($this->ion_auth->logged_in()) {
            $userData = $this->users->get_allData($user_id);
            $this->data['first_name'] = $userData['first_name'];
            $this->data['last_name'] = $userData['last_name'];
        }

        $this->data['page_title'] = $pageTitle;

        // get the cart item from session
        $this->data['cart_items'] = $this->flexi_cart->cart_items();

        $get_record = $this->db->get_where('tbl_wishlist', array('user_id' => $user_id));
        $result = $get_record->result();
        
        // check if email id is already exists
        $this->data['wishlist_count'] = count($result);

        // set the tax total variable value in session
        $_SESSION['flexi_cart']['summary']['tax_total'] = ceil(($_SESSION['flexi_cart']['summary']['item_summary_total'] * 7) / 100);

        // check if the user address is already exists
        $this->data['get_shipping_address'] = $this->addresses->as_array()->get_by(array('user_id' => $user_id)); 

        if(!empty($this->data['get_shipping_address']['s_postcode'])) {
            $this->data['tax_array'] = $this->tax->get_tax_rate($this->data['get_shipping_address']['s_postcode']);        
            $_SESSION['flexi_cart']['summary']['tax_total'] = $this->data['tax_array']['combined_rate'];
        }

        if (isset($this->session->userdata('flexi_cart')['summary']))
            $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
        
        foreach ($this->data['cart_items'] as $key => $cData) {
            if(isset($cData['rent_id']) && $cData['rent_id'] == 1) {
                $this->data['cart_items'][$key]['stock_quantity'] = $this->product->getStockDetail($cData['id'], '1');
            } else {
                $this->data['cart_items'][$key]['stock_quantity'] = $this->product->getStockDetail($cData['id']);
            }
        }

        if ($this->session->userdata('user_id')) {
            $user_id = $this->session->userdata('user_id');
            $data = $_SESSION['flexi_cart'];
            $data = serialize($data);
            $data = array('cart_data_array' => $data);
            $this->db->where('cart_data_user_fk', $user_id);
            $this->db->update('cart_data', $data);
        }


        $this->data['product_categories'] = $this->product_category->get_all_categories();

        foreach ($this->data['product_categories'] as $k => $pData) {
            $this->data['product_categories'][$k]['sub_categories'] = $this->product_sub_category->get_sub_categories($pData['id']);
            foreach ($this->data['product_categories'][$k]['sub_categories'] as $key => $third_level_list) {
                $this->data['product_categories'][$k]['sub_categories'][$key]['third_level'] = $this->product_sub_category->get_sub_categories($third_level_list['id']);
                foreach ($this->data['product_categories'][$k]['sub_categories'][$key]['third_level'] as $key4 => $forth_level_list) {
                    $this->data['product_categories'][$k]['sub_categories'][$key]['third_level'][$key4]['forth_level'] = $this->product_sub_category->get_sub_categories($forth_level_list['id']);
                }
            }
        }   

        $this->data['rent_product_categories'] = $this->rent_product_category->get_all_categories();
        
        foreach ($this->data['rent_product_categories'] as $k => $pData) {
            $this->data['rent_product_categories'][$k]['sub_categories'] = $this->rent_product_subcategory->get_sub_categories($pData['id']);
        }
        

        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        if(!empty($this->data['product_categories'])) {
            foreach ($this->data['product_categories'] as $k => $pData) {
                if(!empty($this->data['prodcut_cat_detail'][$k]['sub_attibutes'])) {
                    foreach ($this->data['prodcut_cat_detail'][$k]['sub_attibutes'] as $subAttributes) {
                        if ($subAttributes['is_brand'] == 1)
                            $this->data['prodcut_cat_detail'][$k]['brands_details'] = $this->pattribute_sub->get_sub_attributes_at_id($subAttributes['p_sub_category_id']);
                        if ($subAttributes['parent_id'] > 0) {
                            $this->data['prodcut_cat_detail'][$k]['p_a_details'] = $this->pattribute_sub->get_sub_attributes_at_id($subAttributes['p_sub_category_id']);
                        }
                    }
                }
            }
        }        

        // get the dynamic content of footer
        $this->data['footer_content'] = $this->footer_cms->as_array()->get_all();

        // get all the social links
        $this->data['social_links'] = $this->social_links->as_array()->get_all();

        // get all the social links
        $this->data['all_coupons'] = $this->coupon->as_array()->getAllDiscounts();

        // set the 5 latest footer categories 
        $this->data['footer_categories'] = $this->product_category->limit(5)->order_by('id', 'DESC')->as_array()->get_all();

        // set master template
        $this->template->set_master_template('front_template.php', $this->data);
        $this->template->write_view('top_header', 'front_snippets/top_header', $this->data);
        $this->template->write_view('main_menu', 'front_snippets/main_menu', $this->data);
        $this->template->write_view('content', $renderTo, $viewData);
        $this->template->write_view('footer', 'front_snippets/footer', $this->data);
        $this->template->render();
    }

    /**
     * check the orders in cart
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       string  $pageTitle, string $renderTo, string $viewData
     * @return      response in json format
     */
    public function checkOrderInCart()
    {
        // get the cart item from session
        $this->data['cart_items'] = $this->flexi_cart->cart_items();

        $cart_order_array = array();

        if(count($this->data['cart_items']) > 1) {

            foreach ($this->data['cart_items'] as $key => $value) {

                if(isset($value['rent_id']) && !empty($value['rent_id']) && $value['rent_id'] == '1') {
                    array_push($cart_order_array, 'rent');
                    // $cart_order_array['rent_id'] = 'rent';
                } else if(isset($value['stock_quantity']) && !empty($value['stock_quantity']) && $value['stock_quantity'] <= 0) {
                    array_push($cart_order_array, 'pre_order');
                    // $cart_order_array['pre_order'] = 'pre_order';
                } else if(isset($value['rent_id']) && !empty($value['rent_id']) && $value['rent_id'] == '0') {
                    array_push($cart_order_array, 'buy');
                    // $cart_order_array['buy'] = 'buy';
                } else if(isset($value['stock_quantity']) && !empty($value['stock_quantity']) && $value['stock_quantity'] > 0) {
                    array_push($cart_order_array, 'stock_order');
                }
            }

            if(in_array('rent', $cart_order_array) && in_array('pre_order', $cart_order_array) && in_array('buy', $cart_order_array)) {

                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '1', 'message' => 'Your cart containing Rent Item & Pre-order Item & Buy Item. Remove items from cart.')); exit;

            } else if(in_array('rent', $cart_order_array) && in_array('pre_order', $cart_order_array)) {

                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '1', 'message' => 'Your cart containing Rent Item & Pre-order Item. Remove items from cart.')); exit;

            } else if(in_array('buy', $cart_order_array) && in_array('pre_order', $cart_order_array)) {

                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '1', 'message' => 'Your cart containing Buy Item & Pre-order Item. Remove items from cart.')); exit;

            } else if(in_array('buy', $cart_order_array) && in_array('rent', $cart_order_array)) {

                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '1', 'message' => 'Your cart containing Buy Item & Rent Item. Remove items from cart.')); exit;

            } else if(in_array('buy', $cart_order_array) || in_array('rent', $cart_order_array) && in_array('stock_order', $cart_order_array)) {

                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '1', 'message' => 'Your cart containing Buy Item & Rent Item. Remove items from cart.')); exit;

            } else {
                // set the response message
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
                echo json_encode(array('status' => '0', 'message' => 'success')); exit;
            }

        } else {

            // set the response message
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '0', 'message' => '')); exit;
        }
    }

    /**
     * Renders Landing views
     * @author      Mayur V <mayurv@rebelute.com>
     * @param       string  $pageTitle, string $renderTo, string $viewData
     * @return      renders to view
     */
    public function _renders_landing_view($pageTitle, $renderTo, $viewData) {

        $user_id = $this->session->userdata('user_id');
        
        // check if the user id logged in
        if($this->ion_auth->logged_in()) {
            $userData = $this->users->get_allData($user_id);
            $this->data['first_name'] = $userData['first_name'];
            $this->data['last_name'] = $userData['last_name'];
        }

        $this->data['page_title'] = $pageTitle;
        
        $get_record = $this->db->get_where('tbl_wishlist', array('user_id' => $user_id));
        $result = $get_record->result();

        // check if email id is already exists
        $this->data['wishlist_count'] = count($result);

        // get the cart item from session
        $this->data['cart_items'] = $this->flexi_cart->cart_items();

        // set the tax total variable value in session
        $_SESSION['flexi_cart']['summary']['tax_total'] = ceil(($_SESSION['flexi_cart']['summary']['item_summary_total'] * 7) / 100);

        if (isset($this->session->userdata('flexi_cart')['summary']))
            $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
        foreach ($this->data['cart_items'] as $key => $cData) {
            $this->data['cart_items'][$key]['stock_quantity'] = $this->product->getStockDetail($cData['id']);
        }

        // get the product categories & sub-categories for buy section products
        $this->data['product_categories'] = $this->product_category->get_all_categories();

        // foreach ($this->data['product_categories'] as $k => $pData) {
        //     $this->data['product_categories'][$k]['sub_categories'] = $this->product_sub_category->get_sub_categories($pData['id']);
        //     foreach ($this->data['product_categories'][$k]['sub_categories'] as $key => $third_level_list) {
        //         $this->data['product_categories'][$k]['sub_categories'][$key]['third_level'] = $this->product_sub_category->get_sub_categories($third_level_list['id']);
        //     }
        // }  


        foreach ($this->data['product_categories'] as $k => $pData) {
            $this->data['product_categories'][$k]['sub_categories'] = $this->product_sub_category->get_sub_categories($pData['id']);
            foreach ($this->data['product_categories'][$k]['sub_categories'] as $key => $third_level_list) {
                $this->data['product_categories'][$k]['sub_categories'][$key]['third_level'] = $this->product_sub_category->get_sub_categories($third_level_list['id']);
                foreach ($this->data['product_categories'][$k]['sub_categories'][$key]['third_level'] as $key4 => $forth_level_list) {
                    $this->data['product_categories'][$k]['sub_categories'][$key]['third_level'][$key4]['forth_level'] = $this->product_sub_category->get_sub_categories($forth_level_list['id']);
                }
            }
        } 

        // get the product categories for rent section products
        $this->data['rent_product_categories'] = $this->rent_product_category->get_all_categories();
        foreach ($this->data['rent_product_categories'] as $k => $pData) {
            $this->data['rent_product_categories'][$k]['sub_categories'] = $this->rent_product_subcategory->get_sub_categories($pData['id']);
        }        


        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
            foreach ($this->data['prodcut_cat_detail'][$k]['sub_attibutes'] as $subAttributes) {
//                echo '<pre>', print_r($subAttributes['parent_id']);
                if ($subAttributes['is_brand'] == 1)
                    $this->data['prodcut_cat_detail'][$k]['brands_details'] = $this->pattribute_sub->get_sub_attributes_at_id($subAttributes['p_sub_category_id']);
                if ($subAttributes['parent_id'] > 0) {
                    $this->data['prodcut_cat_detail'][$k]['p_a_details'] = $this->pattribute_sub->get_sub_attributes_at_id($subAttributes['p_sub_category_id']);
                }
            }

//            $this->data['prodcut_cat_detail'][$k]['brands_dtails'] = $this->pattribute_sub->get_sub_attributes_at_id(2);
        }

        $this->data['footer_content'] = $this->footer_cms->as_array()->get_all();

        // get all the social links
        $this->data['social_links'] = $this->social_links->as_array()->get_all();

        // set the 5 latest footer categories 
        $this->data['footer_categories'] = $this->product_category->limit(5)->order_by('id', 'DESC')->as_array()->get_all();        

        // set master template
        $this->template->set_master_template('front_template.php', $this->data);
        $this->template->write_view('top_header', 'front_snippets/top_header', $this->data);
        $this->template->write_view('main_menu', 'front_snippets/main_menu', $this->data);
        $this->template->write_view('slider', 'front_snippets/slider', $this->data);
        // $this->template->write_view('banner', 'front_snippets/banner', $this->data);
        $this->template->write_view('content', $renderTo, $viewData);
        $this->template->write_view('footer', 'front_snippets/footer', $this->data);
        $this->template->render();
    }

}
