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
        $this->load->model(array('users', 'group_model', 'pattribute', 'pattribute_sub', 'payment', 'demo_cart_model', 'common_model'));
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
        $this->data['product_details'] = $this->product->get_product_by_category_id($category_id, $subcategory_id, $config["per_page"]);
        // echo $this->db->last_query(); die;
        
        // echo "<hr /><h1>DEBUG</h1><pre>";
        // print_r($this->data);
        // echo "</pre>";
        // die();
        

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

        // get the related products
        $this->data['related_product'] = $this->product->getRelatedProductCategory($this->data['product_details'][0]['category_id'], $product_id);        

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
     * Entry Point
     * @author      Mayur V <mayurv@rebelute.com>
     * @return      dashboard view
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
     * Blog page with list of blogs
     * @author      Harshal B <harshalb@rebelute.com>
     * @return      blog page view
     */
    public function blog() {

        // load the services page view
        // set the parameters for rendering view
        $this->data = null;

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['get_blogs_result'] = $this->Blog_model->getAllBlog('*', '', '', '', '', 0);

        // get the blog categories
        // $this->data['category_result'] = $this->Blog_model->getCategories('', '', '', '', 0, $lang_id = '17');

        $this->data['blog_posts_one'] = $this->Blog_model->getAllBlog('', '');
        $pg = 0;

        $this->load->library('pagination');
        $data['count'] = count($this->data['blog_posts_one']);
        $config['base_url'] = base_url() . 'blog/';
        $config['total_rows'] = count($this->data['blog_posts_one']);
        $config['per_page'] = 2;
        $config['cur_page'] = $pg;
        $data['cur_page'] = $pg;
        $config['num_links'] = 2;
        $config['full_tag_open'] = ' <ul class="pagination pagination-lg">';
        $config['full_tag_close'] = '</ul>';
        $this->pagination->initialize($config);
        $this->data['create_links'] = $this->pagination->create_links();
        $this->data['blog_posts_two'] = $this->Blog_model->getAllBlog('', '', '', $config['per_page'], $pg);
        $data['page'] = $pg; //$pg is used to pass limit 

        /** Pagination end here * */
        foreach ($this->data['blog_posts_two'] as $key => $value) {
            $this->data['blog_posts'][$key] = $value;
            $result = $this->getPostComments($value['post_id']);
            $this->data['blog_posts'][$key]['comment_count'] = count($result);
        }


        $pageTitle = 'Buy Sell Rent | Blog Posts';
        $renderTo = 'blog';

        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    
    /**
     * Blog post comments
     * @author      Harshal B <harshalb@rebelute.com>
     * @return      Blog post comments
     */
    private function getPostComments($post_id) {
        $limit = "10";
        $condition_to_pass = array("post_id" => $post_id, "status" => "1");
        $order = ('comment_on desc');
        $arr_comments = $this->Blog_model->getPostComments("", $condition_to_pass, $order, $limit);
        return $arr_comments;
    }

    /**
     * Blog details page with content of blog
     * @author      Harshal B <harshalb@rebelute.com>
     * @return      blog detail page view
     */
    public function blogDetails() {

        // load the services page view
        // set the parameters for rendering view
        $this->data = null;
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
        // if (!$this->ion_auth->logged_in()) {
        //     redirect('auth/login', 'refresh');
        // }

        // load the services page view
        // set the parameters for rendering view
        $this->data = null;
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
        $grossTotal = (float) ($this->session->userdata('flexi_cart')['summary']['item_summary_total']);

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

            /* Best Seller Count */
            foreach ($this->data['cart_items'] as $key => $cartData) {
                $dataPayment['product_sale_count'] = $cartData['quantity'];
                $dataPayment['product_quantity'] = $cartData['quantity'];
                $this->product->update_sale_count($cartData['id'], $dataPayment);
            }

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

            /* Order */
            // $ret = $this->demo_cart_model->demo_save_order($orderData);
            $this->data['order_summary'] = $this->session->userdata('flexi_cart')['summary'];

            $message = $this->load->view('paypal_success', $this->data, TRUE);
            $subject = 'Buy Sell Rent | Order successfully placed';
            $this->common_model->sendEmail($orderData['checkout']['email'], $message, $subject);

        } else {
            redirect('home/paypal_cancel');
        }
        
        $this->flexi_cart->empty_cart(TRUE);

        $this->session->set_flashdata('success', 'Payment Successfully Done');
        $_SESSION['payment_status'] = 'paypal_success';
        redirect('payment_status');
    }

    /**
    * @author : Harshal Borse <harshalb@rebelute.com>
    * @date   : 17 Nov 2017
    * Paypal payment gateway integration - redirect to the success page
    */
    public function payment_success_status() {

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
                // $dataPayment['payment_gross'] = $cartData['internal_price'];
                $dataPayment['payment_via'] = 'paypal';
                $this->payment->insert($dataPayment);
            }
        }

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

        // categories and sub categories
        $this->data['product_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['product_cat_detail'] as $k => $pData) {
            $this->data['product_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);            
            foreach ($this->data['product_cat_detail'][$k]['sub_attibutes'] as $subAttributes) {
                if ($subAttributes['is_brand'] == 1)
                    $this->data['product_cat_detail'][$k]['brands_details'] = $this->pattribute_sub->get_sub_attributes_at_id($subAttributes['p_sub_category_id']);
                if ($subAttributes['parent_id'] > 0) {
                    $this->data['product_cat_detail'][$k]['p_a_details'] = $this->pattribute_sub->get_sub_attributes_at_id($subAttributes['p_sub_category_id']);
                }
            }
        }

        // echo "<hr /><h1>DEBUG</h1><pre>";
        // print_r($this->data);
        // echo "</pre>";
        // die();
        

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

        // categories and sub categories
        $this->data['product_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['product_cat_detail'] as $k => $pData) {
            $this->data['product_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        //     foreach ($this->data['product_cat_detail'][$k]['sub_attibutes'] as $subAttributes) {
        //         if ($subAttributes['is_brand'] == 1)
        //             $this->data['product_cat_detail'][$k]['brands_details'] = $this->pattribute_sub->get_sub_attributes_at_id($subAttributes['p_sub_category_id']);
        //         if ($subAttributes['parent_id'] > 0) {
        //             $this->data['product_cat_detail'][$k]['p_a_details'] = $this->pattribute_sub->get_sub_attributes_at_id($subAttributes['p_sub_category_id']);
        //         }
        //     }
        // }

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
