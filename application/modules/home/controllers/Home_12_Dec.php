<?php defined('BASEPATH') OR exit('No direct script access allowed');

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
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->language(array('product_lang'));
        $this->load->library(array('pagination', 'Ajax_pagination'));
        $this->perPage = 10;

        /* Load Backend model */
        $this->load->model(array('users', 'contact', 'group_model', 'pattribute', 'pattribute_sub', 'payment', 'demo_cart_model', 'common_model'));
        $this->load->model(array('product_category', 'product_sub_category', 'wishlist', 'Blog_model', 'country', 'state', 'orders_summary'));

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
    }

    // default function for home controller
    public function index() {

        // get the user id from session
        $user_id = $this->session->userdata('user_id');

        $this->data['product_details'] = array();

        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['product_details_count'] = $this->product->count_by(array('id'));

        // $this->data['product_details'] = $this->product->get_products();
        $this->data['bestseller_product'] = $this->product->get_best_seller_products();

        // get the feature products
        $this->data['featured_products'] = $this->product->get_feature_product();

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

        // load the services page view
        // set the parameters for rendering view
        // $this->data['product_details'] = $this->product->get_products();

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
            $this->data['category_description'] = "It all begins right here at ITires Online. Test results, Consumer ratings and reviews. Super-fast shipping. The best of the best brands.";
        }

        if ($category_id != '') {
            $this->data['product_count'] = $this->product->count_by(array('category_id' => $category_id));

            $total_row = ($this->data['product_count']);
        } else {
            $this->data['product_count'] = $this->product->count_all();
            $total_row = ($this->data['product_count']);
        }
        
        /* Ajax Pagination */
        $config['uri_segment'] = 4;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'home/ajaxPaginationData';
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilterProduct';
        $this->ajax_pagination->initialize($config);

        /* Ajax Pagination */
        $this->data['product_category_id'] = $category_id;
        $this->data['product_details'] = $this->product->get_product_by_category_subcategory($category_id, $subcategory_id, $config["per_page"]);
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
        
        if(!empty($this->data['product_details'])) {
            // get the related products
            $this->data['related_product'] = $this->product->getRelatedProductCategory($this->data['product_details'][0]['category_id'], $product_id);
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

    /**
     * contact us page view
     * @author      Harshal Borse <harshalb@rebelute.com>
     * @return      contact us page
     */
    public function contact_us() {

        // load the services page view
        // set the parameters for rendering view
        $this->data = null;
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
            $message = 'Hi,<br><br>';
            $message .= 'Find below the enquiry details.<br><br>';
            $message .= 'Name - ' . $this->input->post('author') . '<br><br>';
            $message .= 'Email address - ' . $this->input->post('email') . '<br><br>';
            $message .= 'Enquiry - ' . $this->input->post('comment') . '<br><br>';
            $message .= 'Thank You';
            $subject = 'Buy Sell Rent - Contact Us';

            // $this->email($this->input->post('email'), $message, $subject);
            $this->common_model->sendEmail($this->input->post('email'), $message, $subject);

            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('status' => '1', 'message' => 'Your enquiry details are successfully sent. We will get back to you soon'));
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
        $pageTitle = 'Buy Sell Rent | About Us';
        $renderTo = 'about_us';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * Blog page with list of blogs
     * @author      Harshal B <harshalb@rebelute.com>
     * @return      blog page view
     */
    public function blog($pg = ''){
        // load the services page view
        // set the parameters for rendering view
        $this->data = null;
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['get_blogs_result'] = $this->Blog_model->getAllBlog('*', '', '', '', '', 0);

        // get the blog categories
        // $this->data['category_result'] = $this->Blog_model->getCategories('', '', '', '', 0, $lang_id = '17');
        $this->data['cat_data'] = $this->common_model->getRecords('tbl_mst_categories', '*',array('status' => '1'), $order_by = 'category_id DESC', $limit = '', $debug = 0);
       
        $this->data['blog_posts_one'] = $this->Blog_model->getAllBlog('', '');
       // echo '<pre>';print_R($this->data['get_blogs_result']);die;
       
       
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

        /* Pagination end here */
//        foreach ($this->data['blog_posts_two'] as $key => $value) {
//            $this->data['blog_posts'][$key] = $value;
//            $result = $this->getPostComments($value['post_id']);
//            $this->data['blog_posts'][$key]['comment_count'] = count($result);
//        }


        $pageTitle = 'Buy Sell Rent | Blog Posts';
        $renderTo = 'blog';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
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
        //echo $category_id;die;
        $arr_cat_data = ($this->common_model->getRecords('tbl_mst_categories', 'category_name',array("category_id" => $category_id,"status" => '1'), $order_by = 'category_id DESC', $limit = '', $debug = 0));
       //echo '<pre>';print_R($arr_cat_data);die;
        if(count($arr_cat_data) < 1){
            redirect(base_url().'blog');
        }
        //$this->data = null;
         $this->data['category_name'] =$arr_cat_data[0]['category_name'];
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $condition_to_pass = array("b.status" => '1',"b.blog_category" => $category_id);
        $this->data['get_blogs_result'] = $this->Blog_model->getAllBlogCategories('*', $condition_to_pass, '', '', '', 0);

        // get the blog categories
        // $this->data['category_result'] = $this->Blog_model->getCategories('', '', '', '', 0, $lang_id = '17');
        $this->data['cat_data'] = $this->common_model->getRecords('tbl_mst_categories', '*', array('status' => '1'), $order_by = 'category_id DESC', $limit = '', $debug = 0);
       
        $this->data['blog_posts_one'] = $this->Blog_model->getAllBlogCategories('', $condition_to_pass);
       // echo '<pre>';print_R($this->data['get_blogs_result']);die;
       
       
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
        //echo '<pre>';print_r($this->data['blog_posts_one']);die;
        /* Pagination end here */
//        foreach ($this->data['blog_posts_two'] as $key => $value) {
//            $this->data['blog_posts'][$key] = $value;
//            $result = $this->getPostComments($value['post_id']);
//            $this->data['blog_posts'][$key]['comment_count'] = count($result);
//        }


        $pageTitle = 'Buy Sell Rent | Blog Categories';
        $renderTo = 'blog_categories';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    public function blogDetails($blog_id='') {

        // load the services page view
        // set the parameters for rendering view
        
        $this->data['cat_data'] = $this->common_model->getRecords('tbl_mst_categories', '*',array('status' => '1'), $order_by = 'category_id DESC', $limit = '', $debug = 0);
        $condition_to_pass = array("b.status" => '1', "post_id" => $blog_id);
        $this->data['blog'] = $this->Blog_model->getAllBlog('', $condition_to_pass, '', '', '', 0);
        //echo '<pre>';print_R($this->data['blog']);die;
        //$this->data = null;
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

        // check if user is already logged in
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        // get the cart item from session
        $this->data['cart_items'] = $this->flexi_cart->cart_items();

        foreach ($this->data['cart_items'] as $key => $cData) {
            $this->data['cart_items'][$key]['sub_attributes'] = $this->pattribute_sub->get_sub_attributes_at_id($cData['category_id']);
        }

        // get the user id from session
        $user_id = trim($this->session->userdata('user_id'));

        // get all user data from session
        $this->data['dataHeader'] = $this->users->get_allData($user_id);       

                
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

        // get the cart item from session
        $this->data['cart_items'] = $this->flexi_cart->cart_items();

        foreach ($this->data['cart_items'] as $key => $cartData) {
            $productname .= $cartData['name'] . ',';
        }

        if (isset($this->session->userdata('flexi_cart')['summary']))
            $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];

        $user_id = $this->session->userdata('user_id');
        $returnURL = base_url() . 'home/paypal_success'; // payment success url
        $cancelURL = base_url() . 'home/paypal_cancel'; // payment cancel url
        $notifyURL = base_url() . 'home/ipn'; // ipn url

        $logo = base_url() . 'assets/images/logo.png';
        $ship = $this->session->userdata('flexi_cart')['summary']['shipping_total'] != '' ? $this->session->userdata('flexi_cart')['summary']['shipping_total'] : '0';
        // $grossTotal = (float) ($this->session->userdata('flexi_cart')['summary']['item_summary_total'] + $this->session->userdata('flexi_cart')['summary']['tax_total'] + $ship);
        $grossTotal = (float) ($this->session->userdata('flexi_cart')['summary']['item_summary_total'] + $ship);

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
    * @date   : 17 Nov 2017
    * Paypal payment gateway integration - success page after payment is successfully done
    */
    public function paypal_success() {

        // get the user id from session
        $user_id = $this->session->userdata('user_id');
        $userData = $this->users->get_allData($user_id);

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
                'add_01' => $_SESSION['flexi_cart']['summary']['address'],
                'add_02' => ($_SESSION['flexi_cart']['summary']['address']) ? $_SESSION['flexi_cart']['summary']['address'] : '',
                'city' => $_SESSION['flexi_cart']['summary']['city'],
                'state' => $_SESSION['flexi_cart']['summary']['state'],
                'post_code' => $_SESSION['flexi_cart']['summary']['zip_code'],
                'country' => "US",
            );
            
            $orderData['checkout']['shipping'] = array(
                'name' => $userData['first_name'] . ' ' . $userData['last_name'],
                'company' => '',
                'add_01' => $_SESSION['flexi_cart']['summary']['address'],
                'add_02' => ($_SESSION['flexi_cart']['summary']['address']) ? $_SESSION['flexi_cart']['summary']['address'] : '',
                'city' => $_SESSION['flexi_cart']['summary']['city'],
                'state' => $_SESSION['flexi_cart']['summary']['state'],
                'post_code' => $_SESSION['flexi_cart']['summary']['zip_code'],
                'country' => "US",
            );

            $orderData['checkout']['email'] = $userData['email']; //$userData['email'];
            $this->data = $orderData;
            $orderData['checkout']['phone'] = $userData['phone'];
            $orderData['checkout']['comments'] = 'Paypal Payment';

            $_SESSION['flexi_cart']['tax']['data']['item_total_tax'] = $_SESSION['flexi_cart']['summary']['tax_total'];
//            $orderData['checkout']['tax_percentage'] = $_SESSION['flexi_cart']['summary']['tax_percentage'];
            $ret = $this->demo_cart_model->demo_save_order($orderData);
            
            $order_number_last = $_SESSION['flexi_cart']['settings']['configuration']['order_number'];            
            // $this->order_summary->update_tax($order_number_last, $_SESSION['flexi_cart']['summary']);
        

            /* Order */
            //send email
            $this->data = $orderData;
            $this->data['payment_type'] = "Paypal";
            $this->data['user_name'] = $userData['first_name'] . ' ' . $userData['last_name'];
            $this->data['phone'] = $userData['phone'];
            $this->data['order_id'] = $order_number_last;
            $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
            $this->data['cart_items'] = $this->flexi_cart->cart_items();
            $order_success = $this->load->view('paypal_success', $this->data, TRUE);

            $email = $userData['email'];
            $message = $order_success;
            $subject = 'Buy Sell Rent | Your order was placed successfully!';
            $sentTo = "harshalb@rebelute.com";

            // $this->email($email, $message, $subject, $sentTo);
            $this->common_model->sendEmail($sentTo, $message, $subject);
            //send email
//            $ret = $this->demo_cart_model->demo_save_order($orderData);
        } else {
            redirect('home/paypal_cancel');
        }
        
        if ($this->session->userdata('user_id')) {
            $user_id = $this->session->userdata('user_id');
            $this->db->delete('cart_data', array('cart_data_user_fk' => $user_id));
        }

        $this->clear_cart();
        redirect('home/paypal_success');

            



        //     $message = $this->load->view('paypal_success', $this->data, TRUE);
        //     $subject = 'Buy Sell Rent | Order successfully placed';
        //     $this->common_model->sendEmail($orderData['checkout']['email'], $message, $subject);

        // } else {

        //     echo "here i am"; die;
        //     redirect('home/paypal_cancel');
        // }



        // echo "here i am not"; die;
        
        // $this->flexi_cart->empty_cart(TRUE);

        // $this->session->set_flashdata('success', 'Payment Successfully Done');
        // $_SESSION['payment_status'] = 'paypal_success';
        // redirect('payment_status');
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

        $data_array = array(
            $company => trim($this->input->post('company')),
            $address => trim($this->input->post('address')),
            $city => trim($this->input->post('city')),
            $state => trim($this->input->post('state')),
            $postcode => trim($this->input->post('postcode')),
            $phone => trim($this->input->post('phones')),
        );

        $this->db->where('id', $user_id);
        $this->db->update('users', $data_array);

        echo $this->db->last_query(); die;
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
        
        // if (isset($_POST) && !empty($_POST)) {

            $dataPayment = array(
                'user_id' => $user_id,
                'txn_id' => $this->input->post('txn_id'),
                'payment_gross' => $this->input->post('payment_gross'),
                'currency_code' => $this->input->post('mc_currency'),
                'payer_email' => $this->input->post('payer_email'),
                'payment_status' => $this->input->post('payment_status'),
            );

            echo "<hr /><h1>DEBUG</h1><pre>";
            print_r($dataPayment);
            echo "</pre>";
            die();
            
            foreach ($this->data['cart_items'] as $key => $cartData) {
                $dataPayment['row_id'] = $cartData['row_id'];
                $dataPayment['product_id'] = $cartData['id'];
                $dataPayment['payment_gross'] = $cartData['internal_price'];
                $dataPayment['payment_via'] = 'paypal';
                $this->payment->insert($dataPayment);
            }
        // }

        $this->session->set_flashdata('message', 'Your last transaction is cancelled');
        redirect('home/paypal_cancel');
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

        // get all user data from session
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        // get the cart item from flexi cart 
        $this->data['cart_items'] = $this->flexi_cart->cart_items();

        // set the country list and state list in to the dropdown
        $this->data['country_list'] = (array('' => 'Select Country')) + $this->country->dropdown('countryname');
        $this->data['state_list'] = (array('' => 'Select State')) + $this->state->dropdown('statename');

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

        $pageTitle = 'Buy Sell Rent | My Orders';
        $renderTo = 'my_orders';

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

        $this->data = null;
        // check if the user is logged in
        if (!empty($this->session->userdata('user_id'))) {
            $user_id = $this->session->userdata('user_id');
            // get the user details
            $this->data['account_details'] = $this->users->get_allData($user_id);
            $pageTitle = 'Buy Sell Rent | My Account';
            $renderTo = 'my_account';

            // call the render view function here
            $this->_renders_view($pageTitle, $renderTo, $this->data);
        } else {
            // redirect to the login
            redirect('login', 'refresh');
        }
    }


    /**
     * filter product view
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       string  filter parameters
     * @return      filtered product view
     */
    public function filterProductList() {

        $start_price = trim($this->input->post('start_price'));
        $end_price = trim($this->input->post('end_price'));
        $category_id = trim($this->input->post('category_id'));
        $subcategory_id = trim($this->input->post('subcategory_id'));

        // echo $category_id .' '. $subcategory_id .' '. $start_price .' '. $end_price; die;
        // execute the query for filter products from product table
        $this->data['product_details'] = $this->product->filterProductsByPrice($category_id, $subcategory_id, $start_price, $end_price);
        
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
                $st .= '<option value="' . $state['id'] . '">' . $state['statename'] . '</option>';
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

        foreach ($this->data['product_categories_level'] as $k => $pData) {
            $this->data['product_categories_level'][$k]['sub_categories'] = $this->product_sub_category->get_sub_categories($pData['id']);
            foreach ($this->data['product_categories_level'][$k]['sub_categories'] as $key => $third_level_list) {
                $this->data['product_categories_level'][$k]['sub_categories'][$key]['third_level'] = $this->product_sub_category->get_sub_categories($third_level_list['id']);
            }
        }        

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    /**
     * Render views
     * @author      Mayur V <mayurv@rebelute.com>
     * @param       string  $pageTitle, string $renderTo, string $viewData
     * @return      renders to view
     */
    public function _renders_view($pageTitle, $renderTo, $viewData) {

        $user_id = $this->session->userdata('user_id');
        $this->data['page_title'] = $pageTitle;

        // get the cart item from session
        $this->data['cart_items'] = $this->flexi_cart->cart_items();

        $get_record = $this->db->get_where('tbl_wishlist', array('user_id' => $user_id));
        $result = $get_record->result();
        
        // check if email id is already exists
        $this->data['wishlist_count'] = count($result);

        // set the tax total variable value in session
        $_SESSION['flexi_cart']['summary']['tax_total'] = ceil(($_SESSION['flexi_cart']['summary']['item_summary_total'] * 7) / 100);

        if (isset($this->session->userdata('flexi_cart')['summary']))
            $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
        foreach ($this->data['cart_items'] as $key => $cData) {
            $this->data['cart_items'][$key]['stock_quantity'] = $this->product->get_stock_detail($cData['id']);
        }

        $this->data['product_categories'] = $this->product_category->get_all_categories();

        foreach ($this->data['product_categories'] as $k => $pData) {
            $this->data['product_categories'][$k]['sub_categories'] = $this->product_sub_category->get_sub_categories($pData['id']);
            foreach ($this->data['product_categories'][$k]['sub_categories'] as $key => $third_level_list) {
                $this->data['product_categories'][$k]['sub_categories'][$key]['third_level'] = $this->product_sub_category->get_sub_categories($third_level_list['id']);
            }
        }   

        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
            foreach ($this->data['prodcut_cat_detail'][$k]['sub_attibutes'] as $subAttributes) {
                if ($subAttributes['is_brand'] == 1)
                    $this->data['prodcut_cat_detail'][$k]['brands_details'] = $this->pattribute_sub->get_sub_attributes_at_id($subAttributes['p_sub_category_id']);
                if ($subAttributes['parent_id'] > 0) {
                    $this->data['prodcut_cat_detail'][$k]['p_a_details'] = $this->pattribute_sub->get_sub_attributes_at_id($subAttributes['p_sub_category_id']);
                }
            }
        }

        // set the 5 latest footer categories 
        $this->data['footer_categories'] = $this->product_category->limit(5)->order_by('id', 'DESC')->as_array()->get_all();        

        // set master template
        $this->template->set_master_template('front_template.php');
        $this->template->write_view('top_header', 'front_snippets/top_header', $this->data);
        $this->template->write_view('main_menu', 'front_snippets/main_menu', $this->data);
        $this->template->write_view('content', $renderTo, $viewData);
        $this->template->write_view('footer', 'front_snippets/footer', $this->data);
        $this->template->render();
    }

    /**
     * Renders Landing views
     * @author      Mayur V <mayurv@rebelute.com>
     * @param       string  $pageTitle, string $renderTo, string $viewData
     * @return      renders to view
     */
    public function _renders_landing_view($pageTitle, $renderTo, $viewData) {

        $user_id = $this->session->userdata('user_id');
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
            $this->data['cart_items'][$key]['stock_quantity'] = $this->product->get_stock_detail($cData['id']);
        }

        $this->data['product_categories'] = $this->product_category->get_all_categories();

        foreach ($this->data['product_categories'] as $k => $pData) {
            $this->data['product_categories'][$k]['sub_categories'] = $this->product_sub_category->get_sub_categories($pData['id']);
            foreach ($this->data['product_categories'][$k]['sub_categories'] as $key => $third_level_list) {
                $this->data['product_categories'][$k]['sub_categories'][$key]['third_level'] = $this->product_sub_category->get_sub_categories($third_level_list['id']);
            }
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


        // set the 5 latest footer categories 
        $this->data['footer_categories'] = $this->product_category->limit(5)->order_by('id', 'DESC')->as_array()->get_all();        

        // set master template
        $this->template->set_master_template('front_template.php');
        $this->template->write_view('top_header', 'front_snippets/top_header', $this->data);
        $this->template->write_view('main_menu', 'front_snippets/main_menu', $this->data);
        $this->template->write_view('slider', 'front_snippets/slider', $this->data);
        // $this->template->write_view('banner', 'front_snippets/banner', $this->data);
        $this->template->write_view('content', $renderTo, $viewData);
        $this->template->write_view('footer', 'front_snippets/footer', $this->data);
        $this->template->render();
    }

}
