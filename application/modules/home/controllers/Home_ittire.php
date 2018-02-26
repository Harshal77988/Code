<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'libraries/Stripe/lib/Stripe.php');

class Home extends MY_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->library('pagination');
        $this->load->library('Ajax_pagination');
        $this->perPage = 12;

        //Paypal Payment gateway
        $this->load->library('paypal_lib');
        $this->load->library('pagination');
        $this->load->model(array('users', 'common_model', 'backend/section_model', 'backend/payment'));
        $this->load->model(array('users', 'backend/orders_summary', 'backend/orders_details', 'backend/review_model'));

        $this->flexi = new stdClass;

        $this->load->library('flexi_cart', 'flexi_cart_admin');
        $this->load->model(array('users', 'backend/pages_model', 'enquiry_model', 'order_summary'));

        $this->load->helper(array('url', 'language'));
        $this->load->model(array('users', 'backend/product_category', 'backend/product_sub_category', 'backend/product', 'testimonial', 'backend/blog_category', 'backend/site_section'));
        $this->load->model(array('country', 'state', 'city', 'tax'));
        /* Load Product model */
        $this->load->model(array('backend/product_attribute', 'backend/product', 'backend/product_images'));
        $this->load->model(array('users', 'backend/group_model', 'backend/pattribute', 'backend/pattribute_sub'));
        $this->load->model(array('users', 'backend/product_category', 'backend/product_sub_category'));
        /* Load Master model */
        $this->load->model(array('master/mst_make', 'master/mst_model', 'master/mst_year', 'master/mst_model_size'));
        $this->data['cart_items'] = $this->flexi_cart->cart_items();
        $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];

        /* Cart Library */
        $this->load->library('flexi_cart_admin');
        $this->load->model('demo_cart_model');
        $this->data['model_id'] = null;

//        $this->load->model(array('flexi_cart_admin'));
        $user_id = $this->session->userdata('user_id');
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $sql_where = array(
            $this->flexi_cart->db_column('db_cart_data', 'user') => 0,
            $this->flexi_cart->db_column('db_cart_data', 'user') => $user_id,
            $this->flexi_cart->db_column('db_cart_data', 'readonly_status') => 0
        );

        // Get a list of all saved carts that match the SQL WHERE statement.
        $this->data['saved_cart_data'] = $this->flexi_cart_admin->get_db_cart_data_array(FALSE, $sql_where);

        if (isset($this->data['saved_cart_data'][0]['cart_data_array'])) {
            $cart_data = unserialize($this->data['saved_cart_data'][0]['cart_data_array']);

            $_SESSION['flexi_cart']['items'] = $cart_data['items'];
            $_SESSION['flexi_cart']['summary'] = $cart_data['summary'];
            $this->data['cart_items'] = $_SESSION['flexi_cart']['items'];
            $this->data['cart_summary'] = $_SESSION['flexi_cart']['summary'];
        } else {
            $this->data['cart_items'] = $this->flexi_cart->cart_items();
        }

//        $_SESSION['flexi_cart'] = $data[''];
//        echo '<pre>', print_r($data[]);die;
        $this->lang->load('auth');
        /* Code Commented */
        $cart_data = $this->flexi_cart_admin_model->unserialize_cart_data(true);



//        $_SESSION['flexi_cart']['items'] = $cart_data['items'];
//        $_SESSION['flexi_cart']['summary'] = $cart_data['summary'];
//        $this->data['cart_items'] = $_SESSION['flexi_cart']['items'];
//        $this->data['cart_summary'] = $_SESSION['flexi_cart']['summary'];
        /* Code Commented */

        $this->data['cart_items'] = $this->session->userdata('flexi_cart')['items'];
        $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
//        $this->data['cart_items'] = $_SESSION['flexi_cart']['items'];
//        $this->data['cart_summary'] = $_SESSION['flexi_cart']['summary'];

        if (isset($this->session->userdata('flexi_cart')['items'])) {
            foreach ($this->session->userdata('flexi_cart')['items'] as $key => $cData) {
                $_SESSION['flexi_cart']['items'][$key]['stock_quantity'] = $this->product->get_stock_detail($cData['id']);
                $_SESSION['flexi_cart']['items'][$key]['internal_price'] = $this->product->get_updated_price($cData['id']);
            }
        }

        date_default_timezone_set('America/Los_Angeles');


//        if (!$this->ion_auth->logged_in()) {
//            // redirect them to the login page
//            redirect('auth/login', 'refresh');
//        }
    }

// redirect if needed, otherwise display the user list
    public function index() {
        $categoryOptions = array();
        $itmCnt = count($this->data['cart_items']);
        if ($itmCnt > 0)
            $this->session->set_userdata('cart_url', base_url() . 'home/cart');

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }

        $this->data['slider'] = $this->section_model->get_slider();
        $this->data['product_feature_details'] = $this->product->get_feature_product();

        $this->data['pages'] = $this->pages_model->as_array()->get_all();

        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');


        foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {
            foreach ($categoryDp['sub_attibutes'] as $subAttr)
                if ($subAttr['parent_id'] > 0) {
                    $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
                }
        }

        $this->data['product_filter_category'] = $this->data['product_category'] + $categoryOptions;

//        $this->data['product_details'] = $this->product->get_products();
//        foreach ($this->data['product_details'] as $key => $value)
//            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
//
//        foreach ($this->data['product_details'] as $key => $value)
//            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($value['id']);


        $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['product_year'] = array('' => 'Select Year'); //+ $this->mst_year->dropdown('name');
        $this->data['product_model'] = array('' => 'Select Model'); // + $this->mst_model->dropdown('name');

        /* Tire Size Array */
        $allSize = $this->mst_model_size->get_all_size();
        $sizeOption1 = array();
        $sizeOption2 = array();
        $sizeOption3 = array();
        foreach ($allSize as $sizeData) {
            $sizeOption1[$sizeData['size1']] = $sizeData['size1'];
            $sizeOption2[$sizeData['size2']] = $sizeData['size2'];
            $sizeOption3[$sizeData['size3']] = $sizeData['size3'];
        }
        ksort($sizeOption1);
        ksort($sizeOption2);
        ksort($sizeOption3);
        $this->data['size1'] = array_unique($sizeOption1);
        $this->data['size2'] = array_unique($sizeOption2);
        $this->data['size3'] = array_unique($sizeOption3);
        /* Tire Size Array */

        $this->data['testi_monial'] = $this->testimonial->get_testimonial();
        $this->data['blog'] = $this->testimonial->get_blog_home();

        $this->data['product_offer_details'] = array();
        $this->data['testi_monial'] = $this->testimonial->get_testimonial();
        $offerDatat = $this->product->get_all_offer_product();

//        echo '<pre>', print_r($offerDatat);die;
        if (isset($offerDatat) && !empty($offerDatat)) {
            foreach ($offerDatat as $key => $value) {
                if (!empty($offerDatat[$key]['category_id'])) {
                    $offerDatat[$key]['category_id'] = $value['category_id'];
                    $offerDatat[$key]['category_name'] = $this->product_category->get_category_name_by_id($value['category_id']);
                    $offerDatat[$key]['description'] = $value['description'];
                    $offerDatat[$key]['offer_product_thumb'] = $this->product->get_product_by_category_id($value['category_id'], NULL, '0', 3, 1);
//                $offerDatat[$key]['offer_product_thumb'] = $this->product->get_all_offer_product();
                } else
                    unset($offerDatat[$key]);
            }
        } else
            $offerDatat = NULL;

        $this->data['product_offer_details'] = $offerDatat;
//        echo '<pre>', print_r($offerDatat);die;
        //cms content


        $this->data['home_section'] = $this->site_section->home_page_sction();

        //print_r( $this->data['home_section']);

        $this->data = $this->_get_all_data();
        $this->data = $this->getTireBrands();
//        echo '<pre>', print_r($this->data['brands_dtails']);die;

        $this->data['cart_items'] = $this->flexi_cart->cart_items();
        $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
        $this->data['service_category'] = $this->product_category->service_category();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home/main_content', $this->data, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function about_us() {

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $this->data = $this->_get_all_data();
        $this->data['about_section'] = $this->site_section->about_page_sction();
        $this->data['home_section'] = $this->site_section->home_page_sction();

        $brand_attr_id = 2;
        if ($brand_attr_id != null)
            $this->data['brands_dtails'] = $this->pattribute_sub->get_sub_attributes_at_id(2);
        else
            $this->data['brands_dtails'] = null;

        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('content', 'home/about_us', $this->data, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function contact_us() {
        $this->data['contact_section'] = $this->site_section->contact_page_sction();

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data = $this->_get_all_data();
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home/contact_us', $this->data, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function sell_car() {

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header_t', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home/sell_car', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function single_post() {


        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $this->data = $this->_get_all_data();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header_t', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home/single_post', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function news_review() {

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header_t', NULL);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home/news_review', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function search_car() {

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header_t', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home/search_car', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function shop($categoryId = NULL, $subCategoryId = NULL) {

        $this->data = array();
        $categoryOptions = array();
        $page = 1;
        $config = array();
        $this->data['testi_monial'] = $this->testimonial->get_testimonial();
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $user_id = $this->session->userdata('user_id');
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->data['product_category_id'] = $categoryId;
        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        if (isset($categoryId)) {
            $details = $this->product_category->get_category_name_by_id($categoryId);
            $this->data['category_title'] = $details['name'];
            $this->data['category_description'] = $details['description'];
        } else {
            $this->data['category_title'] = "Shop";
            $this->data['category_description'] = "It all begins right here at ITires Online. Test results, Consumer ratings and reviews. Super-fast shipping. The best of the best brands.";
        }

        $this->data['testi_monial'] = $this->testimonial->get_testimonial();

        $this->data = $this->_get_all_data();
        $brand_attr_id = null;
//            echo '<pre>', print_r($categoryId);die;
//            echo '<pre>', print_r($this->data['prodcut_cat_detail']);die;
        foreach ($this->data['prodcut_cat_detail'] as $subattr) {

            if ($subattr['id'] == $categoryId) {
                foreach ($subattr['sub_attibutes'] as $subData) {
                    if ($subData['is_brand'] == 1) {
                        $brand_attr_id = $subData['p_sub_category_id'];
                    }
                }
            }
        }
        if ($categoryId == null) {
            $this->data['brands_dtails'] = $this->pattribute_sub->get_sub_attributes_at_id(2);
        }
//        $brand_attr_id = $blog_id = $this->uri->segment(3);
        else if ($brand_attr_id != null)
            $this->data['brands_dtails'] = $this->pattribute_sub->get_sub_attributes_at_id($brand_attr_id);
        else
            $this->data['brands_dtails'] = null;

        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
        $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['product_year'] = array('' => 'Select Year'); // + $this->mst_year->dropdown('name');
        $this->data['product_model'] = array('' => 'Select Model'); // + $this->mst_model->dropdown('name');
        $this->data['cart_items'] = $this->flexi_cart->cart_items();

        if ($categoryId != '') {
            $this->data['product_count'] = $this->product->count_by(array('category_id' => $categoryId));

            $total_row = ($this->data['product_count']);
        } else {
            $this->data['product_count'] = $this->product->count_all();
            $total_row = ($this->data['product_count']);
        }
        if (isset($_POST['search']) && !empty($_POST['search'])) {
            $filterTearm['search_term'] = $_POST['search'];
            $this->data['product_count'] = $this->product->get_filter_product_count(null, null, null, 1, null, null, null, null, $filterTearm);
            $total_row = ($this->data['product_count']);
//            echo $this->data['product_count'];
//            die;
        }


        /* Ajax Pagination */

        $config['uri_segment'] = 3;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'home/ajaxPaginationData';
        $config['total_rows'] = $total_row;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilterProduct';
        $this->ajax_pagination->initialize($config);
//        echo '<pre>', print_r($config);
        /* Ajax Pagination */
//        echo 'here';die;
        $this->data['product_category_id'] = $categoryId;
        if (isset($_POST['search']) && !empty($_POST['search'])) {
//            echo 'here'.$_POST['search'];die;
            $this->data['search_term'] = $_POST['search'];
            $this->data['product_details'] = $this->product->get_product_by_category_id($categoryId, $subCategoryId, $config["per_page"], NULL, NULL, $_POST['search']);
        } else {
            $this->data['product_details'] = $this->product->get_product_by_category_id($categoryId, $subCategoryId, $config["per_page"]);
        }


        foreach ($this->data['product_details'] as $key => $value) {
            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
        }
        //count($this->data['product_details']);
        if ($categoryId != null || $subCategoryId != null)
            $config['base_url'] = base_url() . 'home/shop_pegination';
        else
            $config['base_url'] = base_url() . 'home/shop_pegination';


        /* Product Filter category */
        foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {
            foreach ($categoryDp['sub_attibutes'] as $subAttr)
                if ($subAttr['parent_id'] > 0) {
                    $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
                }
        }
        $this->data['product_filter_category'] = $this->data['product_category'] + $categoryOptions;
        /* Product Filter category */
        $this->data['cart_items'] = $this->flexi_cart->cart_items();
        $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];

        /* Tire Size Array */
        $allSize = $this->mst_model_size->get_all_size();
        $sizeOption1 = array();
        $sizeOption2 = array();
        $sizeOption3 = array();
        foreach ($allSize as $sizeData) {
            $sizeOption1[$sizeData['size1']] = $sizeData['size1'];
            $sizeOption2[$sizeData['size2']] = $sizeData['size2'];
            $sizeOption3[$sizeData['size3']] = $sizeData['size3'];
        }
        ksort($sizeOption1);
        ksort($sizeOption2);
        ksort($sizeOption3);
        $this->data['size1'] = array_unique($sizeOption1);
        $this->data['size2'] = array_unique($sizeOption2);
        $this->data['size3'] = array_unique($sizeOption3);
        /* Tire Size Array */

        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'shop', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function shop_pegination($categoryId = NULL, $start = NULL) {
        $categoryOptions = array();
        $this->data = '';
        $page = 1;
        $config = array();
        $this->data['testi_monial'] = $this->testimonial->get_testimonial();
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $user_id = $this->session->userdata('user_id');
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        if (isset($categoryId)) {
            $details = $this->product_category->get_category_name_by_id($categoryId);
            $this->data['category_title'] = $details['name'];
            $this->data['category_description'] = $details['description'];
        } else {
            $this->data['category_title'] = "Shop";
            $this->data['category_description'] = "It all begins right here at ITires Online. Test results, Consumer ratings and reviews. Super-fast shipping. The best of the best brands.";
        }

        $this->data['testi_monial'] = $this->testimonial->get_testimonial();

        $this->data = $this->_get_all_data();
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
        $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['product_year'] = array('' => 'Select Year'); // + $this->mst_year->dropdown('name');
        $this->data['product_model'] = array('' => 'Select Model'); // + $this->mst_model->dropdown('name');
        $this->data['cart_items'] = $this->flexi_cart->cart_items();
//        $this->data['product_details_page'] = $this->product->get_product_by_category_id();
        if ($categoryId != '') {
            $this->data['product_count'] = $this->product->count_by(array('category_id' => $categoryId));
            $total_row = ($this->data['product_count']);
        } else {
            $this->data['product_count'] = $this->product->count_all();
            $total_row = ($this->data['product_count']);
        }


        $config["total_rows"] = $total_row;
        $config["per_page"] = 6;
        $config['use_page_numbers'] = FALSE;
        $config['num_links'] = $total_row;

        if ($this->uri->segment(4)) {
            $page = ($this->uri->segment(4));
        } else {
            $page = 0;
        }

        $start = $page;

        $limit = $config['per_page'];
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['num_links'] = 3;
        $config['full_tag_open'] = '<ul class="clearfix">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_tag_open'] = '<li  >';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
//        $config['last_tag_open'] = '<li><a href="#" class="page-numbers">';
//        $config['last_tag_close'] = '</a></li>';
        $config['cur_tag_open'] = '<li class="current"><a href="#" class="page-numbers ">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['base_url'] = base_url() . 'home/shop_pegination/' . $categoryId . '/';
        $this->pagination->initialize($config);



        //$this->product->get_product_by_category_page($start, $limit,$this->uri->segment(3));

        $this->data['product_details'] = $this->product->get_product_by_category_page($categoryId, $start, $config["per_page"]);
        foreach ($this->data['product_details'] as $key => $value) {
            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
        }
        if ($categoryId != null || $subCategoryId != null)
            $config['base_url'] = base_url() . 'home/getPage';
        else
            $config['base_url'] = base_url() . 'home/getPage';
//        echo '<pre>', print_r($this->data['product_details']);die;

        /* Product Filter category */
        foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {
            foreach ($categoryDp['sub_attibutes'] as $subAttr)
                if ($subAttr['parent_id'] > 0) {
                    $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
                }
        }
        $this->data['product_filter_category'] = $this->data['product_category'] + $categoryOptions;
        /* Product Filter category */
        $this->data['cart_items'] = $this->flexi_cart->cart_items();
        $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];

        /* Tire Size Array */
        $allSize = $this->mst_model_size->get_all_size();
        $sizeOption1 = array();
        $sizeOption2 = array();
        $sizeOption3 = array();
        foreach ($allSize as $sizeData) {
            $sizeOption1[$sizeData['size1']] = $sizeData['size1'];
            $sizeOption2[$sizeData['size2']] = $sizeData['size2'];
            $sizeOption3[$sizeData['size3']] = $sizeData['size3'];
        }
        ksort($sizeOption1);
        ksort($sizeOption2);
        ksort($sizeOption3);
        $this->data['size1'] = array_unique($sizeOption1);
        $this->data['size2'] = array_unique($sizeOption2);
        $this->data['size3'] = array_unique($sizeOption3);

        /* Tire Size Array */

        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'shop', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function shop_product($produictId = NULL, $productCategoryId = null) {

        $categoryOptions = array();
        $user_id = $this->session->userdata('user_id');
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $this->data['review'] = $this->review_model->get_review($user_id, $produictId);
        $this->data['all_review'] = $this->review_model->get_all_reiview_products($produictId);
//        echo '<pre>', print_r( $this->data['all_review']);die;
        $average_rating = null;

        foreach ($this->data['all_review'] as $rData) {
            $average_rating += $rData['review_total'];
        }
//        echo $average_rating;
        $cnt = count($this->data['all_review']);
        if ($cnt != 0) {
            $average_rating = $average_rating / ($cnt * 5) * 5;
            $this->data['average_rating'] = $average_rating;
        } else {
            $this->data['average_rating'] = 0;
        }


        $this->data['check'] = $this->review_model->check_review_product($produictId, $user_id);
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        $this->data['testi_monial'] = $this->testimonial->get_testimonial();

        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
        $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['product_year'] = array('' => 'Select Year'); // + $this->mst_year->dropdown('name');
        $this->data['product_model'] = array('' => 'Select Model'); // + $this->mst_model->dropdown('name');

        $this->data['product_details'] = $this->product->get_product_by_product_id($produictId);
        $this->data['product_id'] = $produictId;

        $prodcut_cat_detail = $this->product_sub_category->get_product_sub_attribute($productCategoryId);

        $this->data['product_related_count'] = $this->product->count_by(array('category_id' => $productCategoryId)); //$this->product->get_product_by_count($productCategoryId);

        $totalRec = ($this->data['product_related_count']);

        /* Ajax Pagination */

        $config['uri_segment'] = 4;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'home/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilterRel';
        $this->ajax_pagination->initialize($config);
//        echo '<pre>', print_r($config);
        /* Ajax Pagination */

        $this->data['related_product_details'] = $this->product->get_product_by_category_id($productCategoryId);

        foreach ($prodcut_cat_detail as $key => $dataAtt) {
            $prodcut_cat_detail[$key]['sub_attribute_details'] = $this->pattribute_sub->get_sub_attributes_at_id($dataAtt['p_sub_category_id']);
        }

        foreach ($this->data['product_details'] as $key => $value) {
            $this->data['product_details'][$key]['product_images_details'] = $this->product_images->as_array()->get_by_id($produictId);
            $this->data['product_details'][$key]['product_attr_details'] = $prodcut_cat_detail;
            $this->data['product_details'][$key]['prodcut_cat_edit_detail'] = $this->product_attribute->get_details_by_id($produictId);
        }


//        echo '<pre>', print_r($this->data['product_details']);die;

        /* Product Filter category */
        foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {
            foreach ($categoryDp['sub_attibutes'] as $subAttr)
                if ($subAttr['parent_id'] > 0) {
                    $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
                }
        }
        $this->data['product_filter_category'] = $this->data['product_category'] + $categoryOptions;
        /* Product Filter category */
//        $config["total_rows"] = 10;
//        $config["per_page"] = 6;
//        $config['use_page_numbers'] = TRUE;
//        //$config['num_links'] = $total_row;
//        if ($this->uri->segment(3)) {
//            $page = ($this->uri->segment(3));
//        } else {
//            $page = 1;
//        }
//        if ($this->uri->segment(4)) {
//            $page = ($this->uri->segment(4));
//        } else {
//            $page = 1;
//        }
//
//        $start = $page;
//        $limit = $config['per_page'];
//        $config['full_tag_open'] = '<ul class="clearfix">';
//        $config['full_tag_close'] = '</ul>';
//        $config['prev_tag_open'] = '<li  >';
//        $config['prev_tag_close'] = '</li>';
//        $config['next_tag_open'] = '<li>';
//        $config['next_tag_close'] = '</li>';
//        $config['last_tag_open'] = '<li><a href="#" class="page-numbers">';
//        $config['last_tag_close'] = '</a></li>';
//        $config['cur_tag_open'] = '<li class="current"><a href="#" class="page-numbers ">';
//        $config['cur_tag_close'] = '</a></li>';
//        $config['num_tag_open'] = '<li>';
//        $config['num_tag_close'] = '</li>';
//        $config['base_url'] = base_url() . 'home/shop/' . $productCategoryId;
//        $this->pagination->initialize($config);

        /* Tire Size Array */
        $allSize = $this->mst_model_size->get_all_size();
        $sizeOption1 = array();
        $sizeOption2 = array();
        $sizeOption3 = array();
        foreach ($allSize as $sizeData) {
            $sizeOption1[$sizeData['size1']] = $sizeData['size1'];
            $sizeOption2[$sizeData['size2']] = $sizeData['size2'];
            $sizeOption3[$sizeData['size3']] = $sizeData['size3'];
        }
        ksort($sizeOption1);
        ksort($sizeOption2);
        ksort($sizeOption3);
        $this->data['size1'] = array_unique($sizeOption1);
        $this->data['size2'] = array_unique($sizeOption2);
        $this->data['size3'] = array_unique($sizeOption3);
        /* Tire Size Array */


        $this->data['cart_items'] = $this->flexi_cart->cart_items();
        $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home/shop_product', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function element() {
        $this->data['pages'] = $this->pages_model->as_array()->get_all();

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header_t', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home/element', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function home_search() {

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->data['pages'] = $this->pages_model->as_array()->get_all();

        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header_t', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home_search', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function home_shop() {

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['pages'] = $this->pages_model->as_array()->get_all();

        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header_t', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home/home_shop', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function filters($productId = null) {
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $this->data['category_title'] = "Shop";
        $this->data['category_description'] = "It all begins right here at ITires Online. Test results, Consumer ratings and reviews. Super-fast shipping. The best of the best brands.";
        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        $this->data = $this->_get_all_data();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'home/filter', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function cart() {
        $this->data['cart_items'] = $this->flexi_cart->cart_items();

//        die;
        $categoryOptions = array();
        $this->data['pages'] = $this->session->userdata('flexi_cart')['items']; //$this->pages_model->as_array()->get_all();
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

        if (isset($this->session->userdata('flexi_cart')['summary']))
            $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
        foreach ($this->data['cart_items'] as $key => $cData) {
            $this->data['cart_items'][$key]['stock_quantity'] = $this->product->get_stock_detail($cData['id']);
            $this->data['cart_items'][$key]['internal_price'] = $this->product->get_updated_price($cData['id']);
        }
        foreach ($this->data['cart_items'] as $key => $cData) {
            if ($cData['stock_quantity'] > 0) {
                $total += $cData['internal_price'] * $cData['quantity'];
                $rowCnt++;
            }
        }

        $this->data['cart_summary']['item_summary_total'] = $total;
        $this->data['cart_summary']['row_count'] = $rowCnt;
        $_SESSION['flexi_cart']['summary']['total_rows'] = $rowCnt;
        $_SESSION['flexi_cart']['summary']['total_items'] = $rowCnt;
        $_SESSION['flexi_cart']['summary']['item_summary_total'] = $total;
        $_SESSION['flexi_cart']['summary']['tax_total'] = ceil(($total * 7) / 100);
        $_SESSION['flexi_cart']['summary']['total'] = $total;

        $this->data['discounts'] = $this->flexi_cart->summary_discount_data();
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
        $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['product_year'] = array('' => 'Select Year'); // + $this->mst_year->dropdown('name');
        $this->data['product_model'] = array('' => 'Select Model'); // + $this->mst_model->dropdown('name');
        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }

        /* Product Filter category */
        foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {
            foreach ($categoryDp['sub_attibutes'] as $subAttr)
                if ($subAttr['parent_id'] > 0) {
                    $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
                }
        }
        $this->data['product_filter_category'] = $this->data['product_category'] + $categoryOptions;
        /* Product Filter category */
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->data = $this->_get_all_data();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'cart', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function checkout($retrunType = null) {
        if (!$this->ion_auth->logged_in()) {
            redirect('');
        }

        if (empty($this->data['cart_items']) && $retrunType == null) {
            redirect('home/shop/1');
        }
        $this->data['pages'] = $this->pages_model->as_array()->get_all();

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['cart_items'] = $this->flexi_cart->cart_items();
        if (isset($this->data['cart_items'])) {
            foreach ($this->data['cart_items'] as $key => $cData) {
                $this->data['cart_items'][$key]['stock_quantity'] = $this->product->get_stock_detail($cData['id']);
                $this->data['cart_items'][$key]['internal_price'] = $this->product->get_updated_price($cData['id']);
            }
            foreach ($this->data['cart_items'] as $key => $cData) {
                if ($cData['quantity'] > $cData['stock_quantity'] && $cData['stock_quantity'] != 0) {
                    redirect('home/cart');
                }
            }
        }

        $this->data['discounts'] = $this->flexi_cart->summary_discount_data();
        $this->data['country_list'] = $this->country->dropdown('countryname');
        $this->data['state_list'] = (array('' => 'Select State')) + $this->state->dropdown('statename');
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->data = $this->_get_all_data();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'checkout', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function blogs($blogID = null) {

        $this->data['blog_category'] = $this->blog_category->as_array()->get_all();
        $this->data['pages'] = $this->pages_model->as_array()->get_all();

        foreach ($this->data['blog_category'] as $k => $pData) {
            $this->data['blog_category'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        $this->data['testi_monial'] = $this->testimonial->get_testimonial();

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['blog_count'] = $this->testimonial->get_blog();
        $this->data['blog_d'] = $this->testimonial->get_blog_d();
        $config = array();
        $config["base_url"] = base_url() . "home/blogs/";
        $total_row = $this->testimonial->get_blog();

        $config["total_rows"] = $total_row;
        // $config["total_rows"] = 10;
        $config["per_page"] = 3;
        $config['use_page_numbers'] = TRUE;
        //$config['num_links'] = $total_row;
        if ($this->uri->segment(3)) {
            $page = ($this->uri->segment(3));
        } else {
            $page = 1;
        }
        $config['num_links'] = 3;
        $config['full_tag_open'] = '<ul class="clearfix">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_tag_open'] = '<li  >';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li><a href="#" class="page-numbers">';
        $config['last_tag_close'] = '</a></li>';
        $config['cur_tag_open'] = '<li class="current"><a href="#" class="page-numbers ">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
//        $config['base_url'] = base_url() . 'home/blogs/';
        $this->pagination->initialize($config);

        if (isset($blogID))
            $this->data['blog'] = $this->testimonial->blog_details($config["per_page"], $page, $blogID);
        else
            $this->data['blog'] = $this->testimonial->blog_details($config["per_page"], $page);

//        $str_links = $this->pagination->create_links();
//        $this->data["links"] = explode('&nbsp;', $str_links);



        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');

        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {
            foreach ($categoryDp['sub_attibutes'] as $subAttr)
                if ($subAttr['parent_id'] > 0) {
                    $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
                }
        }

        /* Tire Size Array */
        $allSize = $this->mst_model_size->get_all_size();
        $sizeOption1 = array();
        $sizeOption2 = array();
        $sizeOption3 = array();
        foreach ($allSize as $sizeData) {
            $sizeOption1[$sizeData['size1']] = $sizeData['size1'];
            $sizeOption2[$sizeData['size2']] = $sizeData['size2'];
            $sizeOption3[$sizeData['size3']] = $sizeData['size3'];
        }
        ksort($sizeOption1);
        ksort($sizeOption2);
        ksort($sizeOption3);
        $this->data['size1'] = array_unique($sizeOption1);
        $this->data['size2'] = array_unique($sizeOption2);
        $this->data['size3'] = array_unique($sizeOption3);
        /* Tire Size Array */

        $this->data = $this->_get_all_data();
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', '_blogs', $this->data, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function blog_cat($blogID = null) {

        $this->data['blog_category'] = $this->blog_category->as_array()->get_all();
        $this->data['pages'] = $this->pages_model->as_array()->get_all();

        foreach ($this->data['blog_category'] as $k => $pData) {
            $this->data['blog_category'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        $this->data['testi_monial'] = $this->testimonial->get_testimonial();

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['blog_count'] = $this->testimonial->get_blog();
        $this->data['blog_d'] = $this->testimonial->get_blog_d();
        $config = array();

        $config["base_url"] = base_url() . "home/blogs/";
        $total_row = $this->testimonial->get_blog();

        $config["total_rows"] = $total_row;
        // $config["total_rows"] = 10;
        $config["per_page"] = 3;
        $config['use_page_numbers'] = TRUE;
        //$config['num_links'] = $total_row;
        if ($this->uri->segment(3)) {
            $page = ($this->uri->segment(3));
        } else {
            $page = 1;
        }
        $config['num_links'] = 3;
        $config['full_tag_open'] = '<ul class="clearfix">';
        $config['full_tag_close'] = '</ul>';
        $config['prev_tag_open'] = '<li  >';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li><a href="#" class="page-numbers">';
        $config['last_tag_close'] = '</a></li>';
        $config['cur_tag_open'] = '<li class="current"><a href="#" class="page-numbers ">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['base_url'] = base_url() . 'home/blog_cat/';
//        $this->pagination->initialize($config);

        if (isset($blogID))
            $this->data['blog'] = $this->testimonial->blog_cat_detail($blogID);
        //else
        // $this->data['blog'] = $this->testimonial->blog_cat_detail($blogID);
//        if (isset($blogID))
//            $this->data['blog'] = $this->testimonial->blog_cat_detail($blogID);
//      
        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');

        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {
            foreach ($categoryDp['sub_attibutes'] as $subAttr)
                if ($subAttr['parent_id'] > 0) {
                    $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
                }
        }

        /* Tire Size Array */
        $allSize = $this->mst_model_size->get_all_size();
        $sizeOption1 = array();
        $sizeOption2 = array();
        $sizeOption3 = array();
        foreach ($allSize as $sizeData) {
            $sizeOption1[$sizeData['size1']] = $sizeData['size1'];
            $sizeOption2[$sizeData['size2']] = $sizeData['size2'];
            $sizeOption3[$sizeData['size3']] = $sizeData['size3'];
        }
        ksort($sizeOption1);
        ksort($sizeOption2);
        ksort($sizeOption3);
        $this->data['size1'] = array_unique($sizeOption1);
        $this->data['size2'] = array_unique($sizeOption2);
        $this->data['size3'] = array_unique($sizeOption3);
        /* Tire Size Array */

        //$this->data = $this->_get_all_data();
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', '_blogs', $this->data, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function single_blog() {
        $this->data['pages'] = $this->pages_model->as_array()->get_all();

        $blog_id = $this->uri->segment(3);

        $this->data['single_post'] = $this->testimonial->get_single_post($blog_id);
        $this->data['blog_category'] = $this->blog_category->as_array()->get_all();
        foreach ($this->data['blog_category'] as $k => $pData) {
            $this->data['blog_category'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        $blog_id = $this->uri->segment(3);

        $this->data['single_post'] = $this->testimonial->get_single_post($blog_id);

        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        $cid = array();
        foreach ($this->data['single_post'] as $category) {
            $cid[] = $category['category_id'];
        }

        $this->data['related_blog'] = $this->testimonial->get_relative_blog($cid[0]);
//        print_r( $this->data['related_blog']);
//        exit;
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['testi_monial'] = $this->testimonial->get_testimonial();

        $this->data['home_section'] = $this->site_section->home_page_sction();


        $this->data = $this->_get_all_data();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', '_blogs_single', $this->data, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);

        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);

        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function productFilter($method = null, $size = null) {

        $this->data['brands_dtails'] = null;
        $this->data['no_pagination'] = "false";

        $user_id = $this->session->userdata('user_id');
        /* Tire Size Array */
        $allSize = $this->mst_model_size->get_all_size();
        $sizeOption1 = array();
        $sizeOption2 = array();
        $sizeOption3 = array();
        foreach ($allSize as $sizeData) {
            $sizeOption1[$sizeData['size1']] = $sizeData['size1'];
            $sizeOption2[$sizeData['size2']] = $sizeData['size2'];
            $sizeOption3[$sizeData['size3']] = $sizeData['size3'];
        }
        ksort($sizeOption1);
        ksort($sizeOption2);
        ksort($sizeOption3);
        $this->data['size1'] = array_unique($sizeOption1);
        $this->data['size2'] = array_unique($sizeOption2);
        $this->data['size3'] = array_unique($sizeOption3);
        /* Tire Size Array */
        $categoryOptions = array();


        $this->data['product_category_id'] = "1";
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == 'home_filter') {
            $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
            foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
                $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
            }
            if (isset($product_category_id) && $product_category_id != '') {

                $details = $this->product_category->get_category_name_by_id($product_category_id);
                $this->data['category_title'] = $details['name'];
                $this->data['category_description'] = $details['description'];
                if (isset($product_sub_category) && $product_sub_category != '') {
                    $details = $this->product_sub_category->get_sub_category_name_by_id($product_sub_category);
                    $this->data['category_title'] = $details['name'];
                }
            } else {
                $this->data['category_title'] = "Shop";
                $this->data['category_description'] = "It all begins right here at ITires Online. Test results, Consumer ratings and reviews. Super-fast shipping. The best of the best brands.";
            }

            $this->data['testi_monial'] = $this->testimonial->get_testimonial();


            $this->data['dataHeader'] = $this->users->get_allData($user_id);
            $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
            $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
            $this->data['product_year'] = array('' => 'Select Year'); // + $this->mst_year->dropdown('name');
            $this->data['product_model'] = array('' => 'Select Model'); // + $this->mst_model->dropdown('name');


            $this->data['product_details'] = $this->product->get_filter_product(0, 0, 0, 1, null, null, $this->perPage, $offset, null);
            foreach ($this->data['product_details'] as $key => $value) {
                $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
            }
            $this->data['product_count'] = $this->product->get_filter_product_count(0, 0, 0, 1, null, null);

            $this->data['testi_monial'] = $this->testimonial->get_testimonial();
            $this->data['blog'] = $this->testimonial->get_blog_home();

            $this->data['home_section'] = $this->site_section->home_page_sction();
            $this->data['testi_monial'] = $this->testimonial->get_testimonial();
            $this->data['pages'] = $this->pages_model->as_array()->get_all();
            $this->data['brand_category'] = $this->pattribute->get_brands();
            $options = array();
            foreach ($this->data['brand_category'] as $bCat) {
                $options[$bCat['brand_id']] = $bCat['attrubute_value'];
            }
            $this->data['brand_category'] = array('' => 'Select Barand Category') + $options;

            $this->data['product_filter_category'] = $this->data['product_category'] + $categoryOptions;
            $totalRec = ($this->data['product_count']);
            $this->data['product_count'] = $totalRec;

            $config['target'] = '#postList';
            $config['base_url'] = base_url() . 'home/ajaxPaginationData';
            $config['total_rows'] = $totalRec;
            $config['per_page'] = $this->perPage;
            $config['link_func'] = 'searchFilterSize';
            $this->ajax_pagination->initialize($config);
            /* Tire Size Array */
            $allSize = $this->mst_model_size->get_all_size();
            $sizeOption1 = array();
            $sizeOption2 = array();
            $sizeOption3 = array();
            foreach ($allSize as $sizeData) {
                $sizeOption1[$sizeData['size1']] = $sizeData['size1'];
                $sizeOption2[$sizeData['size2']] = $sizeData['size2'];
                $sizeOption3[$sizeData['size3']] = $sizeData['size3'];
            }
            ksort($sizeOption1);
            ksort($sizeOption2);
            ksort($sizeOption3);
            $this->data['size1'] = array_unique($sizeOption1);
            $this->data['size2'] = array_unique($sizeOption2);
            $this->data['size3'] = array_unique($sizeOption3);
            /* Tire Size Array */

            /* Ajax Pagination */
            $this->template->set_master_template('landing_template.php');
            $this->template->write_view('header', 'snippets/header', $this->data);
            $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
            $this->template->write_view('content', 'shop', $this->data, TRUE);
            $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
            $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
            $this->template->write_view('footer', 'snippets/footer', '', TRUE);
            $this->template->render();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == 'bysize') {

            $this->data['product_category_id'] = "1";
            $bysize = $this->input->post('size1') . '/' . $this->input->post('size2') . 'R' . $this->input->post('size3');


            $this->data['size1op'] = $this->input->post('size1');
            $this->data['size2op'] = $this->input->post('size2');
            $this->data['size3op'] = $this->input->post('size3');
            $this->session->set_userdata('sess_bysize', $bysize);
            //$bysize session 
//            $make_id = null, $year_id = null, $model_id = null, $product_category_id = null, $product_sub_category = null, $searchTearm = null, $start = null, $limit = null, $filterTearm = null
            $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
            foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
                $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
            }
            if (isset($product_category_id) && $product_category_id != '') {

                $details = $this->product_category->get_category_name_by_id($product_category_id);
                $this->data['category_title'] = $details['name'];
                $this->data['category_description'] = $details['description'];
                if (isset($product_sub_category) && $product_sub_category != '') {
                    $details = $this->product_sub_category->get_sub_category_name_by_id($product_sub_category);
                    $this->data['category_title'] = $details['name'];
                }
            } else {
                $this->data['category_title'] = "Shop";
                $this->data['category_description'] = "It all begins right here at ITires Online. Test results, Consumer ratings and reviews. Super-fast shipping. The best of the best brands.";
            }


            $this->data['testi_monial'] = $this->testimonial->get_testimonial();


            $this->data['dataHeader'] = $this->users->get_allData($user_id);
            $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
            $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
            $this->data['product_year'] = array('' => 'Select Year'); // + $this->mst_year->dropdown('name');
            $this->data['product_model'] = array('' => 'Select Model'); // + $this->mst_model->dropdown('name');


            $this->data['product_details'] = $this->product->get_filter_product(0, 0, 0, 1, null, null, null, null, null, $bysize);
            foreach ($this->data['product_details'] as $key => $value) {
                $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
            }


            $this->data['brands_dtails'] = $this->pattribute_sub->get_sub_attributes_at_id(2);


            $this->data['product_count'] = $this->product->get_filter_product_count(0, 0, 0, 1, null, null, $bysize);

            $this->data['testi_monial'] = $this->testimonial->get_testimonial();
            $this->data['blog'] = $this->testimonial->get_blog_home();

            $this->data['home_section'] = $this->site_section->home_page_sction();
            $this->data['testi_monial'] = $this->testimonial->get_testimonial();
            $this->data['pages'] = $this->pages_model->as_array()->get_all();
            $this->data['brand_category'] = $this->pattribute->get_brands();
            $options = array();
            foreach ($this->data['brand_category'] as $bCat) {
                $options[$bCat['brand_id']] = $bCat['attrubute_value'];
            }
            $this->data['brand_category'] = array('' => 'Select Barand Category') + $options;

            $this->data['product_filter_category'] = $this->data['product_category'] + $categoryOptions;
            $totalRec = ($this->data['product_count']);
            $this->data['product_count'] = $totalRec;

            $config['target'] = '#postList';
            $config['base_url'] = base_url() . 'home/ajaxPaginationData';
            $config['total_rows'] = $totalRec;
            $config['per_page'] = $this->perPage;
            $config['link_func'] = 'searchFilterSize';
            $this->ajax_pagination->initialize($config);
            /* Tire Size Array */
            $allSize = $this->mst_model_size->get_all_size();
            $sizeOption1 = array();
            $sizeOption2 = array();
            $sizeOption3 = array();
            foreach ($allSize as $sizeData) {
                $sizeOption1[$sizeData['size1']] = $sizeData['size1'];
                $sizeOption2[$sizeData['size2']] = $sizeData['size2'];
                $sizeOption3[$sizeData['size3']] = $sizeData['size3'];
            }
            ksort($sizeOption1);
            ksort($sizeOption2);
            ksort($sizeOption3);
            $this->data['size1'] = array_unique($sizeOption1);
            $this->data['size2'] = array_unique($sizeOption2);
            $this->data['size3'] = array_unique($sizeOption3);
            /* Tire Size Array */

            /* Ajax Pagination */
            $this->data['product_category_id'] = "1";


            $this->template->set_master_template('landing_template.php');
            $this->template->write_view('header', 'snippets/header', $this->data);
            $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
            $this->template->write_view('content', 'shop', $this->data);
            $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
            $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
            $this->template->write_view('footer', 'snippets/footer', '', TRUE);
            $this->template->render();


//            echo '<pre>', print_r($this->data['product_filter_count']);
//            die;
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $user_id = $this->session->userdata('user_id');


            $session_data = array(
                'product_year' => $this->input->post('product_year'),
                'product_model' => $this->input->post('product_model'),
                'product_category' => $this->input->post('product_category'),
            );


            if ($this->input->post('product_make'))
                $session_data['product_make'] = $this->input->post('product_make');
            else
                $session_data['product_make'] = $this->input->post('product_make_recent');

            $this->session->set_userdata('recent_product', $session_data);

            $make_id = $session_data['product_make'];
            $year_id = $this->input->post('product_year');
            $model_id = $this->input->post('product_model');


            $product_category_id = $this->input->post('product_category');
            $product_sub_category = $this->input->post('product_sub_category');
            $this->data['product_category_id'] = $product_category_id;

            if (strstr($product_category_id, '_')) {
                $id = explode('_', $product_category_id);
                $product_category_id = $id[0];
                $product_sub_category = $id[1];
            } else {
                $product_category_id = $product_category_id;
                $product_sub_category = null;
            }





            $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
            foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
                $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
            }
            if (isset($product_category_id) && $product_category_id != '') {

                $details = $this->product_category->get_category_name_by_id($product_category_id);
                $this->data['category_title'] = $details['name'];
                $this->data['category_description'] = $details['description'];
                if (isset($product_sub_category) && $product_sub_category != '') {
                    $details = $this->product_sub_category->get_sub_category_name_by_id($product_sub_category);
                    $this->data['category_title'] = $details['name'];
                }
            } else {
                $this->data['category_title'] = "Shop";
                $this->data['category_description'] = "It all begins right here at ITires Online. Test results, Consumer ratings and reviews. Super-fast shipping. The best of the best brands.";
            }


            $this->data['testi_monial'] = $this->testimonial->get_testimonial();

            $brand_attr_id = null;
//            echo '<pre>', print_r($product_category_id);die;
            foreach ($this->data['prodcut_cat_detail'] as $subattr) {
                if ($subattr['id'] == $product_category_id) {

                    foreach ($subattr['sub_attibutes'] as $subData) {
                        if ($subData['is_brand'] == '1') {

                            $brand_attr_id = $subData['p_sub_category_id'];
                        }
                    }
                }
            }
//            die;
//            $brand_attr_id = $blog_id = $this->uri->segment(3);
            if ($brand_attr_id == null)
                $brand_attr_id = 2;
            if ($brand_attr_id != null)
                $this->data['brands_dtails'] = $this->pattribute_sub->get_sub_attributes_at_id(2);
            else
                $this->data['brands_dtails'] = null;

            $this->data['dataHeader'] = $this->users->get_allData($user_id);
            $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');
            $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
            $this->data['product_year'] = array('' => 'Select Year'); // + $this->mst_year->dropdown('name');
            $this->data['product_model'] = array('' => 'Select Model'); // + $this->mst_model->dropdown('name');
            $this->data['brand_category'] = $this->pattribute->get_brands();

            $options = array();
            foreach ($this->data['brand_category'] as $bCat) {
                $options[$bCat['brand_id']] = $bCat['attrubute_value'];
            }

            $this->data['brand_category'] = array('' => 'Select Barand Category') + $options;
//            echo $product_category_id;die;
            $this->data['product_details'] = array();
//            $this->data['product_details'] = $this->product->get_filter_product($make_id, $year_id, $model_id, $product_category_id, $product_sub_category);

            $this->data['product_count'] = $this->data['product_filter_count'] = $this->product->get_filter_product_count($make_id, $year_id, $model_id, $product_category_id, $product_sub_category);


            /* Product Filter category */
            foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {
                foreach ($categoryDp['sub_attibutes'] as $subAttr)
                    if ($subAttr['parent_id'] > 0) {
                        $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
                    }
            }

            /* Get if category is tire */
            if ($product_category_id == 1) {
                $model_temp_id = $this->input->post('product_model');


                $this->session->set_userdata('modal_id', $model_temp_id);
//                echo $model_temp_id;die;
                //get all available size of model
                $allSizes = array();
                $model_detals = $this->mst_model_size->get_model_size_detail($model_temp_id);
//                echo '<pre>', print_r($model_detals);die;
                if (isset($model_detals) && !empty($model_detals)) {
                    foreach ($model_detals as $modelData) {
                        array_push($allSizes, $modelData['size']);
                    }
                }

                $size_count = count($allSizes);
                if ($method == '' && !isset($_POST['temp_method']) && $size_count > 1) {

                    $this->data['all_sizes'] = $allSizes;
                } else {

                    if ($size_count == 1) {

                        $bysize = $allSizes[0];
                        $this->session->set_userdata('sess_bysize', $bysize);

                        $this->data['current_size'] = $allSizes[0];

                        $current_size = explode('R', $allSizes[0]);
                        $current_size2 = explode('/', $current_size[0]);
                        $size1 = $current_size2[0];
                        $size2 = $current_size2[1];
                        $size3 = $current_size[1];

                        $this->data['size1op'] = $size1;
                        $this->data['size2op'] = $size2;
                        $this->data['size3op'] = $size3;

                        $this->data['product_details'] = $this->product->get_filter_product(0, 0, 0, 1, null, null, null, null, null, $bysize);
                        foreach ($this->data['product_details'] as $key => $value) {
                            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
                        }
//                        echo '<pre>', print_r($this->data['product_details']);die;
                        $this->data['product_count'] = $this->product->get_filter_product_count(0, 0, 0, 1, null, null, $bysize);
//                        $this->product->get_filter_product(0, 0, 0, 1, null, null, null, null, null, null, $allSizes);
                    } else if ($_POST['temp_method'] == 'filter_temp_size') {

                        $bysize = $_POST['size'];
                        /* if ($this->input->post('size') != '') {
                          $size = explode(',', $this->input->post('size'));
                          $bysize = $size[0] . '/' . $size[1] . 'R' . $size[2];
                          } */
                        $this->session->set_userdata('sess_bysize', $bysize);

                        $this->data['current_size'] = $_POST['size'];

                        $current_size = explode('R', $_POST['size']);
                        $current_size2 = explode('/', $current_size[0]);
                        $size1 = $current_size2[0];
                        $size2 = $current_size2[1];
                        $size3 = $current_size[1];

                        $this->data['size1op'] = $size1;
                        $this->data['size2op'] = $size2;
                        $this->data['size3op'] = $size3;

                        $this->data['product_details'] = $this->product->get_filter_product(0, 0, 0, 1, null, null, null, null, null, $bysize);
                        foreach ($this->data['product_details'] as $key => $value) {
                            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
                        }
//                        echo '<pre>', print_r($this->data['product_details']);die;
                        $this->data['product_count'] = $this->product->get_filter_product_count(0, 0, 0, 1, null, null, $bysize);
//                        $this->product->get_filter_product(0, 0, 0, 1, null, null, null, null, null, null, $allSizes);
                    } else {
                        $this->data['product_count'] = $this->product->get_filter_product_count(0, 0, 0, 1, null, null, null, null, null, $allSizes);

                        $this->data['product_details'] = $other_product;

                        $unique_array = array();
                        foreach ($this->data['product_details'] as $pDta) {
                            $hash = $pDta['id'];
                            $unique_array[$hash] = $pDta;
                        }

                        $this->data['product_details'] = $unique_array;
                        foreach ($this->data['product_details'] as $key => $value) {
                            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
                        }
//                echo '<pre>', print_r($this->data['product_details']);die;
                        $this->data['product_count'] = ($this->data['product_count']);
                    }

                    $totalRec = ($this->data['product_count']);
//                echo $totalRec;
//                echo '<pre>',print_r($this->data['product_details']);die();

                    $config['target'] = '#postList';
                    $connfig['base_url'] = base_url() . 'home/ajaxPaginationData';
                    $config['total_rows'] = $totalRec;
                    $config['per_page'] = $this->perPage;
                    $config['link_func'] = 'searchSizeFilterProduct';
                    $this->ajax_pagination->initialize($config);
                }
                /* Ajax Pagination */

//                die;
            }

            /* Get if category is tire */

//            echo $brand_attr_id;die;
            $this->data['pages'] = $this->pages_model->as_array()->get_all();
            $this->data['product_filter_category'] = $this->data['product_category'] + $categoryOptions;
            /* Product Filter category */
//            echo '<pre>', print_r($this->data['product_details'] );die;
            $this->data['home_section'] = $this->site_section->home_page_sction();
            $this->template->set_master_template('landing_template.php');
            $this->template->write_view('header', 'snippets/header', $this->data);
            $this->template->write_view('sidebar', 'snippets/sidebar', NULL);

            if ($method == 'brand_filter') {
//                echo '<pre>', print_r($_POST);die;

                $bysize = null;
                $bid = $this->input->post('brand_id');
                if ($this->input->post('size') != '') {
                    $size = explode(',', $this->input->post('size'));
                    $bysize = $size[0] . '/' . $size[1] . 'R' . $size[2];
                }

                $bid = $this->input->post('brand_id');
//                $make_id = $session_data['product_make'];
                $make_id = $this->input->post('product_make');
                $year_id = $this->input->post('product_year');
                $model_id = $this->input->post('product_model');
                $product_category_id = $this->input->post('product_category_id');

                $filterTearm['brand'] = $bid;

                $this->data['product_details'] = $this->product->get_filter_product($make_id, $year_id, $model_id, $product_category_id, null, null, null, null, $filterTearm);
                foreach ($this->data['product_details'] as $key => $value) {
                    $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
                }

//               echo '<pre>',print_r($this->data['product_details']);die();
                //$product_category_id = '';
                foreach ($this->data['product_details'] as $key => $model) {

                    $this->data['plugin_image'][$key] = $this->product->get_all_plugin_images_by_category($make_id, $year_id, $model_id, $product_category_id, null, $model['id']);
                    $this->data['cover_image'] = $this->mst_model->get_model_images_by_category($model_id);
                }
                $totalRec = count($this->data['product_details']);
//                echo $totalRec;
//                echo '<pre>',print_r($this->data['plugin_image']);die();

                $config['target'] = '#postList';
                $connfig['base_url'] = base_url() . 'home/ajaxPaginationData';
                $config['total_rows'] = $totalRec;
                $config['per_page'] = $this->perPage;
                $config['link_func'] = 'searchFilter';
                $this->ajax_pagination->initialize($config);
                /* Ajax Pagination */

                $content = $this->load->view('product/_filter_result', $this->data, TRUE);
                if (isset($content)) {
                    echo json_encode($content);
                }
                die;
            } else if ($method == 'brand_shop_filter') {

                $bysize = null;
                $bid = null;

                if ($this->input->post('brand_id') != '')
                    $bid = $this->input->post('brand_id');

//                echo '<pre>', print_r($bid);die;
                $filterTearm['brand'] = $bid;
                $price_range = $this->input->post('price_range');
                $filterTearm['price'] = $price_range;

                if ($this->input->post('size') != '') {
                    $size = explode(',', $this->input->post('size'));
                    $bysize = $size[0] . '/' . $size[1] . 'R' . $size[2];
                }


                $this->session->set_userdata('sess_bysize', $bysize);

//                $make_id = $session_data['product_make'];
                $make_id = $this->input->post('product_make');
                $year_id = $this->input->post('product_year');
                $model_id = $this->input->post('product_model');
                $product_category_id = $this->input->post('product_category_id');

                if (isset($model_id) && $model_id != null) {

                    /* Model size */
                    $allSizes = array();
                    $model_detals = $this->mst_model_size->get_model_size_detail($model_id);
//                echo '<pre>', print_r($model_detals);die;
                    if (isset($model_detals) && !empty($model_detals)) {
                        foreach ($model_detals as $modelData) {
                            array_push($allSizes, $modelData['size']);
                        }
                    }

                    $this->data['model_id'] = $model_temp_id;
                    $this->data['all_sizes'] = $allSizes;

                    $this->data['product_details'] = $this->product->get_filter_product(null, null, null, $product_category_id, null, null, null, null, $filterTearm, $bysize, $allSizes);
                    foreach ($this->data['product_details'] as $key => $value) {
                        $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
                    }
                    $this->data['product_count'] = $this->product->get_filter_product_count(null, null, null, $product_category_id, null, null, $bysize, null, $filterTearm, $allSizes);

                    $unique_array = array();
                    foreach ($this->data['product_details'] as $pDta) {
                        $hash = $pDta['id'];
                        $unique_array[$hash] = $pDta;
                    }
                    $this->data['product_details'] = $unique_array;
                    $this->data['product_count'] = ($this->data['product_count']);
                    $totalRec = ($this->data['product_count']);
                    /* Model size */
                } else {
                    $this->data['product_details'] = $this->product->get_filter_product($make_id, $year_id, $model_id, $product_category_id, null, null, null, null, $filterTearm, $bysize);
                    foreach ($this->data['product_details'] as $key => $value) {
                        $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
                    }
                    $this->data['product_count'] = $this->product->get_filter_product_count(null, null, null, $product_category_id, null, null, $bysize, null, $filterTearm);
//                    if (isset($filterTearm['brand']) && !empty($filterTearm['brand']) && isset($bysize)) {
//                        $this->data['no_pagination'] = "true";
//                        $this->data['product_count'] = ($this->data['product_count']);
//                    } else
                    $this->data['product_count'] = $this->product->get_filter_product_count(null, null, null, $product_category_id, null, null, $bysize, null, $filterTearm);
                }


//               echo '<pre>',print_r($this->data['product_details']);die();
                //$product_category_id = '';
                if ($product_category_id == 2) {
                    foreach ($this->data['product_details'] as $key => $model) {

                        $this->data['plugin_image'][$key] = $this->product->get_all_plugin_images_by_category($make_id, $year_id, $model_id, $product_category_id, null, $model['id']);
                        $this->data['cover_image'] = $this->mst_model->get_model_images_by_category($model_id);
                    }
                }


                $totalRec = $this->data['product_count'];
//                echo $totalRec;die;
//                echo '<pre>',print_r($this->data['plugin_image']);die();

                $config['target'] = '#postList';
                $connfig['base_url'] = base_url() . 'home/ajaxPaginationData';
                $config['total_rows'] = $totalRec;
                $config['per_page'] = $this->perPage;
                $config['link_func'] = 'searchFilterByFilter';
                $this->ajax_pagination->initialize($config);
                /* Ajax Pagination */

                $content = $this->load->view('product/ajax_product_view_related', $this->data, TRUE);
                if (isset($content)) {
                    echo json_encode($content);
                }
                die;
            } else if ($method == 'price_shop_filter') {

                $type = null;
                $bid = null;
                $price_range = $this->input->post('price_range');
                if ($this->input->post('brand_id') !== '')
                    $bid = $this->input->post('brand_id');
                $filterTearm['brand'] = $bid;

                if ($this->input->post('tags') && $this->input->post('tags') != '')
                    $filterTearm['search_term'] = $this->input->post('tags');

                $bysize = null;

                if ($this->input->post('size') != '') {
                    $size = explode(',', $this->input->post('size'));
                    $bysize = $size[0] . '/' . $size[1] . 'R' . $size[2];
                }

                $price_range = $this->input->post('price_range');

                $make_id = null;
                $year_id = null;
                $model_id = null;
                if ($this->input->post('product_make'))
                    $make_id = $this->input->post('product_make');
                if ($this->input->post('product_year'))
                    $year_id = $this->input->post('product_year');
                if ($this->input->post('product_model'))
                    $model_id = $this->input->post('product_model');

                $product_category_id = $this->input->post('product_category_id');
                if ($this->input->post('type'))
                    $type = $this->input->post('type');

                $filterTearm['price'] = $price_range;
                $this->data['product_details'] = null;

                if (isset($model_id) && $model_id != null) {

                    /* Model size */
                    $allSizes = array();
                    $model_detals = $this->mst_model_size->get_model_size_detail($model_id);
//                echo '<pre>', print_r($model_detals);die;
                    if (isset($model_detals) && !empty($model_detals)) {
                        foreach ($model_detals as $modelData) {
                            array_push($allSizes, $modelData['size']);
                        }
                    }

                    $this->data['model_id'] = $model_temp_id;
                    $this->data['all_sizes'] = $allSizes;

                    if ($this->input->post('tags') && $this->input->post('tags') != '')
                        $filterTearm['search_term'] = $this->input->post('tags');

                    $this->data['product_details'] = $this->product->get_filter_product(null, null, null, $product_category_id, null, null, null, null, $filterTearm, $bysize, $allSizes);
                    foreach ($this->data['product_details'] as $key => $value) {
                        $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
                    }

                    $this->data['product_count'] = $this->product->get_filter_product_count(null, null, null, $product_category_id, null, null, $bysize, null, $filterTearm, $allSizes);
//                    echo $this->data['product_count'];die;
                    $unique_array = array();
                    foreach ($this->data['product_details'] as $pDta) {
                        $hash = $pDta['id'];
                        $unique_array[$hash] = $pDta;
                    }
                    $this->data['product_details'] = $unique_array;
                    $totalRec = ($this->data['product_count']);
                    /* Model size */
                } else {
                    $this->data['product_details'] = $this->product->get_filter_product(null, null, null, $product_category_id, null, null, null, null, $filterTearm, $bysize);
                    foreach ($this->data['product_details'] as $key => $value) {
                        $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
                    }

//                    if (isset($filterTearm['brand']) && !empty($filterTearm['brand']) && isset($bysize)) {
//                        $this->data['product_details_count'] = count($this->data['product_details']);
//                        
//                        $this->data['no_pagination'] = "true";
//                    } else
                    $this->data['product_details_count'] = $this->product->get_filter_product_count(null, null, null, $product_category_id, null, null, $bysize, null, $filterTearm);


                    $this->data['product_count'] = ($this->data['product_details_count']);
                    $totalRec = ($this->data['product_count']);
                }


//                $this->data['product_count'] = $this->data['product_details_count'];
//                echo $this->data['product_count'];die;
                $totalRec = ($this->data['product_count']);
                $config['target'] = '#postList';
                $config['base_url'] = base_url() . 'home/ajaxPaginationData';
                $config['total_rows'] = $totalRec;
                $config['per_page'] = $this->perPage;
                $config['link_func'] = 'searchFilterByFilter';
                $this->ajax_pagination->initialize($config);
                /* Ajax Pagination */
                $content = $this->load->view('product/ajax_product_view_related', $this->data, TRUE);

                if (isset($content)) {
                    echo json_encode($content);
                }
                die;
            } else if ($method == 'price_filter') {
                $type = null;
                $price_range = $this->input->post('price_range');
                $make_id = null;
                $year_id = null;
                $model_id = null;
                if ($this->input->post('product_make'))
                    $make_id = $this->input->post('product_make');
                if ($this->input->post('product_year'))
                    $year_id = $this->input->post('product_year');
                if ($this->input->post('product_model'))
                    $model_id = $this->input->post('product_model');

                $product_category_id = $this->input->post('product_category_id');
                if ($this->input->post('type'))
                    $type = $this->input->post('type');

                $filterTearm['price'] = $price_range;

                $this->data['product_details'] = $this->product->get_filter_product($make_id, $year_id, $model_id, $product_category_id, null, null, null, null, $filterTearm);
                foreach ($this->data['product_details'] as $key => $value) {
                    $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
                }
//               echo '<pre>',print_r($this->data['product_details']);die();
                if (isset($type) && $type != 'tire') {
                    foreach ($this->data['product_details'] as $model) {

                        $this->data['plugin_image'] = $this->product->get_all_plugin_images_by_category($make_id, $year_id, $model_id, $product_category_id, $filterTearm);
                        $this->data['cover_image'] = $this->mst_model->get_model_images_by_category($model_id);
                    }
                }

//                $this->data['plugin_image'] = $this->product->get_all_plugin_images_by_category($make_id, $year_id, $model_id, $product_category_id);
//                $this->data['cover_image'] = $this->mst_model->get_model_images_by_category($model_id);
                $totalRec = count($this->data['product_details']);
                $config['target'] = '#postList';
                $config['base_url'] = base_url() . 'home/ajaxPaginationData';
                $config['total_rows'] = $totalRec;
                $config['per_page'] = $this->perPage;
                $config['link_func'] = 'searchFilter';
                $this->ajax_pagination->initialize($config);
                /* Ajax Pagination */
                $content = $this->load->view('product/_filter_result', $this->data, TRUE);
                if (isset($content)) {
                    echo json_encode($content);
                }
                die;
            } else if ($method == 'view_on_vehicle') {
                //echo 'KK';DIE;
//                $make_id  $year_id $model_id $product_category_id 
//                $this->data['model_name'] = $this->data['product_year'][$session_data['product_year']] . ' ' . $this->data['product_make'][$session_data['product_make']] . '  ' . $this->data['product_year'][$session_data['product_make']];
                /* Ajax Pagination */

                //echo $product_category_id;
                $brand_attr_id = null;
//            echo '<pre>', print_r($this->data['prodcut_cat_detail']);die;
                foreach ($this->data['prodcut_cat_detail'] as $subattr) {
                    if ($subattr['id'] == $product_category_id) {
                        foreach ($subattr['sub_attibutes'] as $subData) {
                            if ($subData['is_brand'] == 1) {
                                $brand_attr_id = $subData['p_sub_category_id'];
                            }
                        }
                    }
                }
                if ($brand_attr_id != null)
                    $this->data['brands_dtails'] = $this->pattribute_sub->get_sub_attributes_at_id($brand_attr_id);
                else
                    $this->data['brands_dtails'] = null;
//                echo '<pre>', print_r($this->data['brands_dtails']);die;

                $this->data['product_details'] = $this->product->get_filter_product($make_id, $year_id, $model_id, $product_category_id, $product_sub_category, null, null, null);
//               echo '<pre>',print_r($this->data['product_details']);die();
                foreach ($this->data['product_details'] as $model) {
                    $this->data['plugin_image'] = $this->product->get_all_plugin_images_by_category($model['make_id'], $model['year_id'], $model['model_id'], $model['category_id']);
                    $this->data['cover_image'] = $this->mst_model->get_model_images_by_category($model['model_id']);
                }

                $totalRec = ($this->data['product_filter_count']);
                $config['target'] = '#postList';
                $config['base_url'] = base_url() . 'home/ajaxPaginationData';
                $config['total_rows'] = $totalRec;
                $config['per_page'] = $this->perPage;
                $config['link_func'] = 'searchFilter';
                $this->ajax_pagination->initialize($config);
                /* Ajax Pagination */

                /* Best seller product */
                $this->data['best_seller_details'] = $this->product->get_best_seller_products();
//                echo '<pre>', print_r($this->data['best_seller_details']);die;
                /* Best seller product */

                $this->data['plugin_image'] = $this->product->get_all_plugin_images_by_category($make_id, $year_id, $model_id, $product_category_id);
                $this->data['cover_image'] = $this->mst_model->get_model_images_by_category($model_id);

                $this->template->write_view('content', 'filter', $this->data, TRUE);
            } else {
//                echo 'here';die;
                $this->template->write_view('content', 'shop', $this->data, TRUE);
            }
//            $this->template->write_view('content', 'shop', NULL, TRUE);
            $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
            $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
            $this->template->write_view('footer', 'snippets/footer', '', TRUE);
            $this->template->render();
        } else {
            redirect('/home');
        }
    }

    public function search_by_brand($product_category_id = null, $product_sub_category = null) {

        $id = explode("=", $product_sub_category);
        $cnt = substr_count($product_sub_category, "=");
        if ($cnt != 1) {
            redirect('404_override');
        }
        if (isset($id[1])) {
            $this->data['brand_name'] = $id[0];
            $product_sub_category = $id[1];
            $this->config->set_item('website_description', '');
            $this->config->set_item('website_name', $id[0] . ' Tires | ITiresOnline');
        } else {
            $product_sub_category = null;
        }


        if (isset($product_category_id) && $product_category_id != '') {

            $details = $this->product_category->get_category_name_by_id($product_category_id);
            $this->data['category_title'] = $details['name'];
            $this->data['category_description'] = $details['description'];
            if (isset($product_sub_category) && $product_sub_category != '') {
                $details = $this->product_sub_category->get_sub_category_name_by_id($product_category_id);
                $this->data['category_title'] = $details['name'];
            }
        } else {
            $this->data['category_title'] = "Shop";
            $this->data['category_description'] = "It all begins right here at ITires Online. Test results, Consumer ratings and reviews. Super-fast shipping. The best of the best brands.";
        }

        $this->data = $this->_get_all_data();
        $this->data['brand_id'] = $product_sub_category;
//        $this->data['product_category_id'] = $product_category_id;
        $this->data['product_details'] = $this->product->get_filter_product(NULL, NULL, NULL, $product_category_id, $product_sub_category, 'brand');
        foreach ($this->data['product_details'] as $key => $value) {
            $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
        }
        if (isset($product_sub_category))
            $this->data['product_count'] = $this->product_attribute->count_by(array('sub_attribute_dp_id' => $product_sub_category));
        else {
            $this->data['product_count'] = $this->product_attribute->count_by(array('category_id' => $product_category_id));
        }
        $brand_attr_id = null;

        if ($product_category_id == "2")
            $temp_id = "1";
        if ($product_category_id == "5")
            $temp_id = "2";
        foreach ($this->data['prodcut_cat_detail'] as $subattr) {
            if ($subattr['id'] == $temp_id) {
                foreach ($subattr['sub_attibutes'] as $subData) {
                    if ($subData['is_brand'] == 1) {
                        $brand_attr_id = $subData['p_sub_category_id'];
                    }
                }
            }
        }
//        $brand_attr_id = $blog_id = $product_sub_category;
        if ($brand_attr_id != null)
            $this->data['brands_dtails'] = $this->pattribute_sub->get_sub_attributes_at_id($brand_attr_id);
        else
            $this->data['brands_dtails'] = null;
        $totalRec = $this->data['product_count'];
        /* Ajax Pagination */

        $config['uri_segment'] = 3;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'home/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilterBrand';
        $this->ajax_pagination->initialize($config);
//        echo '<pre>', print_r($config);
        /* Ajax Pagination */
        $this->data['product_category_id'] = "1";
        /* Product Filter category */
//            echo '<pre>', print_r($this->data['product_details'] );die;
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'shop');
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    function clear_cart() {
// The 'empty_cart()' function allows an argument to be submitted that will also reset all shipping data if 'TRUE'.
        $this->flexi_cart->empty_cart(TRUE);

// Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());
//        redirect('/home/cart');
        return true;


//        redirect('standard_library/view_cart');
    }

    function clear_cart_all() {
        $this->flexi_cart->empty_cart(TRUE);

        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());
        if ($this->session->userdata('user_id')) {
            $user_id = $this->session->userdata('user_id');
            $this->db->delete('cart_data', array('cart_data_user_fk' => $user_id));
        }
        redirect('/home/cart');
        return true;


//        redirect('standard_library/view_cart');
    }

    function update_cart() {


        $this->data['cart_items'] = $this->flexi_cart->cart_items();

// Load custom demo function to retrieve data from the submitted POST data and update the cart.
        $this->session->set_flashdata('message', "Cart Updated Successfully");
        $this->demo_cart_model->demo_update_cart();
        $this->data['cart_items'] = $_SESSION['flexi_cart']['items'];
//        echo '<pre>', print_r($this->data['cart_items'] );die;


        if ($this->session->userdata('user_id')) {
            $user_id = $this->session->userdata('user_id');
            $data = $_SESSION['flexi_cart'];
            $data = serialize($data);
            $data = array('cart_data_array' => $data);
            $this->db->where('cart_data_user_fk', $user_id);
            $this->db->update('cart_data', $data);
        }


// If the cart update was posted by an ajax request, do not perform a redirect.
        if (!$this->input->is_ajax_request()) {
// Set a message to the CI flashdata so that it is available after the page redirect.
            $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

            redirect('home/cart');
        }
    }

    function delete_item($row_id = FALSE) {
// The 'delete_items()' function can accept an array of row_ids to delete more than one row at a time.
// However, this example only uses the 1 row_id that was supplied via the url link.
        $this->flexi_cart->delete_items($row_id);
        $this->data['cart_items'] = $_SESSION['flexi_cart']['items'];
//        echo '<pre>', print_r($this->data['cart_items'] );die;


        if ($this->session->userdata('user_id')) {
            $user_id = $this->session->userdata('user_id');
            $data = $_SESSION['flexi_cart'];
            $data = serialize($data);
            $data = array('cart_data_array' => $data);
            $this->db->where('cart_data_user_fk', $user_id);
            $this->db->update('cart_data', $data);
        }

// Set a message to the CI flashdata so that it is available after the page redirect.
        $this->session->set_flashdata('message', $this->flexi_cart->get_messages());

//        redirect('standard_library/view_cart');
    }

    function _get_all_data() {
        $categoryOptions = array();
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['prodcut_cat_detail'] = $this->product_category->as_array()->get_all();
        foreach ($this->data['prodcut_cat_detail'] as $k => $pData) {
            $this->data['prodcut_cat_detail'][$k]['sub_attibutes'] = $this->product_sub_category->get_product_sub_attribute($pData['id']);
        }
        $this->data['slider'] = $this->section_model->get_slider();
//        echo '<pre>', print_r($this->data['slider']);die;
        $this->data['product_feature_details'] = $this->product->get_feature_product();

        /**/
        $this->data['product_category'] = array('' => 'Select Category') + $this->product_category->dropdown('name');


        foreach ($this->data['prodcut_cat_detail'] as $categoryDp) {
            foreach ($categoryDp['sub_attibutes'] as $subAttr)
                if ($subAttr['parent_id'] > 0) {
                    $categoryOptions[$subAttr['id'] . '_' . $subAttr['p_sub_category_id']] = $subAttr['attrubute_value'];
                }
        }

        $this->data['product_filter_category'] = $this->data['product_category'] + $categoryOptions;

        $this->data['product_make'] = array('' => 'Select Make') + $this->mst_make->dropdown('name');
        $this->data['product_year'] = array('' => 'Select Year'); //+ $this->mst_year->dropdown('name');
        $this->data['product_model'] = array('' => 'Select Model'); // + $this->mst_model->dropdown('name');



        $this->data['testi_monial'] = $this->testimonial->get_testimonial();
        $this->data['blog'] = $this->testimonial->get_blog_home();

        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->data['testi_monial'] = $this->testimonial->get_testimonial();
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $this->data['brand_category'] = $this->pattribute->get_brands();
        $options = array();
        foreach ($this->data['brand_category'] as $bCat) {
            $options[$bCat['brand_id']] = $bCat['attrubute_value'];
        }
        $this->data['brand_category'] = array('' => 'Select Barand Category') + $options;

        /* Tire Size Array */
        $allSize = $this->mst_model_size->get_all_size();
        $sizeOption1 = array();
        $sizeOption2 = array();
        $sizeOption3 = array();
        foreach ($allSize as $sizeData) {
            $sizeOption1[$sizeData['size1']] = $sizeData['size1'];
            $sizeOption2[$sizeData['size2']] = $sizeData['size2'];
            $sizeOption3[$sizeData['size3']] = $sizeData['size3'];
        }
        ksort($sizeOption1);
        ksort($sizeOption2);
        ksort($sizeOption3);
        $this->data['size1'] = array_unique($sizeOption1);
        $this->data['size2'] = array_unique($sizeOption2);
        $this->data['size3'] = array_unique($sizeOption3);
        /* Tire Size Array */


//        $this->data['flexi_cart'] = $this->session->userdata('flexi_cart');
//        $this->data['product_offer_details'] = $this->product->get_offer_product();
//        echo '<pre>',print_r($this->data['product_offer_details']);die;
        return $this->data;
    }

    function user() {

//        $orderData = array();
//        $orderData['checkout']['billing'] = array(
//            'name' => $this->input->post('first_name') . ' ' . $this->input->post('last_name'),
//            'company' => '',
//            'add_01' => $this->input->post('billing_address'),
//            'add_02' => '',
//            'city' => $this->input->post('billing_city'),
//            'state' => $this->input->post('billing_state'),
//            'post_code' => $this->input->post('billing_zip'),
//            'country' => $this->input->post('billing_country'),
//        );
//        $orderData['checkout']['shipping'] = array(
//            'name' => $this->input->post('first_name') . ' ' . $this->input->post('last_name'),
//            'company' => '',
//            'add_01' => $this->input->post('billing_address'),
//            'add_02' => '',
//            'city' => $this->input->post('billing_city'),
//            'state' => $this->input->post('billing_state'),
//            'post_code' => $this->input->post('billing_zip'),
//            'country' => $this->input->post('billing_country'),
//        );
//        $orderData['checkout']['email'] = $this->input->post('email');
//        $orderData['checkout']['phone'] = $this->input->post('phone');
//        $orderData['checkout']['comments'] = '';
//
//        $response = $this->demo_cart_model->demo_save_order($orderData);

        $_SESSION['flexi_cart']['summary']['address'] = $this->input->post('billing_address');
        $_SESSION['flexi_cart']['summary']['city'] = $this->input->post('billing_city');
        if ($this->session->userdata('user_id')) {
            $user_id = $this->session->userdata('user_id');
            $data = $_SESSION['flexi_cart'];
            $data = serialize($data);
            $data = array('cart_data_array' => $data);
            $this->db->where('cart_data_user_fk', $user_id);
            $this->db->update('cart_data', $data);
        }
    }

    function getState() {
        $data['state_list'] = (array('' => 'Select State')) + $this->state->dropdown('statename');
        return $data['state_list'];
    }

    function getCityList() {

        if (isset($_POST)) {


            $state_id = $_POST['state_id'];


            $cities = $this->city->get_CityListById($state_id);
            $st = '<option>Select</option>';
            foreach ($cities as $city) {
                $st .= '<option value="' . $city['id'] . '">' . $city['cityname'] . '</option>';
            }
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('content' => $st));
        } else {
            $this->output->set_header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array('content' => ''));
        }
    }

    function getStateList() {

        if (isset($_POST)) {

            $country_id = $_POST['country_id'];


            $states = $this->state->get_StateListById($country_id);
//            echo '<pre>', print_r($country_id);die;
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

    public function getSubDropdwon() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $subAttrId = $this->input->post('sub_attribute_id');
            $data = $this->pattribute_sub->get_sub_attributes_at_id($subAttrId);
            $options = array();

            $select = '<div class="form-group"><select class="form-control" name="parent_id[]">';
            if (!empty($data)) {
                foreach ($data as $subData)
                    $select .= '<option value="' . $subData['id'] . '">' . $subData['sub_name'] . '</option>';

                $select .= '</select></div>';
            }
            echo json_encode(array('content' => $select));
            die;
        }
    }

    public function getBrands() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $subAttrId = $this->input->post('sub_attribute_id');
            $data = $this->pattribute_sub->get_sub_attributes_at_id($subAttrId);

            $options = array();

            $this->data['brands_dtails'] = $this->pattribute_sub->get_sub_attributes_at_id($subAttrId);

            $attribute_brand_view = $this->load->view('product/_view_brand_list', $this->data, TRUE);
            echo json_encode(array('content' => $attribute_brand_view));
            die;
        }
    }

    public function getTireBrands() {

        $subAttrId = $this->input->post('sub_attribute_id');
        $data = $this->pattribute_sub->get_sub_attributes_at_id(2);

        $options = array();

        $this->data['brands_dtails'] = $this->pattribute_sub->get_sub_attributes_at_id(2);

        return $this->data;

//        $attribute_brand_view = $this->load->view('product/_view_brand_list', $this->data, TRUE);
//        echo json_encode(array('content' => $attribute_brand_view));
//        die;
    }

    function buy() {
//        echo '<pre>', print_r($this->session->userdata('flexi_cart')['summary']);die;
        //Set variables for paypal form
        if (!$this->ion_auth->logged_in()) {
// redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        $productname = '';
        foreach ($this->data['cart_items'] as $key => $cartData) {
            $productname .= $cartData['name'] . ',';
        }

        $user_id = $this->session->userdata('user_id');
        $returnURL = base_url() . 'home/success'; //payment success url
        $cancelURL = base_url() . 'home/cancel'; //payment cancel url
        $notifyURL = base_url() . 'home/ipn'; //ipn url

        $logo = base_url() . 'assets/images/codexworld-logo.png';

        $this->paypal_lib->add_field('return', $returnURL);
        $this->paypal_lib->add_field('cancel_return', $cancelURL);
        $this->paypal_lib->add_field('notify_url', $notifyURL);
        $this->paypal_lib->add_field('item_name', $productname);
        $this->paypal_lib->add_field('custom', $user_id);
        $this->paypal_lib->add_field('item_number', $this->data['cart_summary']['total_items']);
        $this->paypal_lib->add_field('amount', $this->data['cart_summary']['item_summary_total'] + $this->data['cart_summary']['tax_total']); //$this->data['cart_summary']['item_summary_total']
        $this->paypal_lib->image($logo);

        $this->paypal_lib->paypal_auto_form();
    }

    function stripePay() {
        $this->load->view('stripe_payment');
    }

    function stripePaySubmit() {
//        echo '<pre>', print_r($_POST);die;
        if (!$this->ion_auth->logged_in()) {
// redirect them to the login page
            echo json_encode(array('status' => 500, 'error' => "Unfortunatley session has been lost, please login"));
            exit();
        }

        try {
            if (isset($this->session->userdata('flexi_cart')['summary']))
                $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];

            $user_id = $this->session->userdata('user_id');
            $userData = $this->users->get_allData($user_id);


//            Stripe::setApiKey('sk_test_o6HzXgtL17xC2cUi7QaWpNhp'); // for test
            Stripe::setApiKey('sk_live_kAzQGdFHryi3t59yQ4owgqfr'); // for live
            $charge = Stripe_Charge::create(array(
                        "amount" => round(($this->data['cart_summary']['item_summary_total'] + $this->data['cart_summary']['tax_total']) * 100),
                        "currency" => "USD",
                        "card" => $this->input->post('access_token'),
                        "description" => "Stripe Payment"
            ));

            // this line will be reached if no error was thrown above
            $user_id = $this->session->userdata('user_id');

            $dataPayment = array(
                'user_id' => $user_id,
                'txn_id' => $charge->id,
                'payment_gross' => ($charge->amount / 100),
                'currency_code' => $charge->currency,
                'payment_status' => 'Completed',
            );



//require_once(APPPATH.'third_party/fedex-common.php5');
//            require_once(APPPATH . 'third_party/ShipWebServiceClient.php5');
            //require_once(APPPATH.'third_party/TrackWebServiceClient.php5'); 
            //$response = $this->payment->insert($data);
            if ($dataPayment) {

                foreach ($this->data['cart_items'] as $key => $cartData) {
                    $dataPayment['row_id'] = $cartData['row_id'];
                    $dataPayment['product_id'] = $cartData['id'];
//                $dataPayment['payment_gross'] = $cartData['internal_price'];
//                $dataPayment['payment_gross'] = $charge->amount;
                    $this->payment->insert($dataPayment);
                }

                /* Best Seller Count */
                foreach ($this->data['cart_items'] as $key => $cartData) {
                    $dataPayment['product_sale_count'] = $cartData['quantity'];
                    $dataPayment['product_quantity'] = $cartData['quantity'];
                    $this->product->update_sale_count($cartData['id'], $dataPayment);
                }
                /* Best Seller Count */
//                $this->demo_cart_model->demo_save_order();

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
                $orderData['checkout']['phone'] = $userData['phone'];
                $orderData['checkout']['comments'] = 'Stripe Payment';
                $orderData['checkout']['tax_total'] = $_SESSION['flexi_cart']['summary']['tax_total'];
                $orderData['checkout']['tax_percentage'] = $_SESSION['flexi_cart']['summary']['tax_percentage'];
                $_SESSION['flexi_cart']['setting']['tax']['data']['item_total_tax'] = $_SESSION['flexi_cart']['summary']['tax_total'];
                $this->data['order_summary'] = $this->session->userdata('flexi_cart')['summary'];

                /* Order */
                $ret = $this->demo_cart_model->demo_save_order($orderData);
                $order_number_last = $_SESSION['flexi_cart']['settings']['configuration']['order_number'];
                $this->order_summary->update_tax($order_number_last, $_SESSION['flexi_cart']['summary']);
                //send email

                $this->data = $orderData;
                $this->data['payment_type'] = "Stripe";
                $this->data['user_name'] = $userData['first_name'] . ' ' . $userData['last_name'];
                $this->data['phone'] = $userData['phone'];
                $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
                $this->data['cart_items'] = $this->flexi_cart->cart_items();
                $this->data['order_id'] = $order_number_last;
                $order_success = $this->load->view('product/success_order', $this->data, TRUE);
                $email = $userData['email'];
                $message = $order_success;
                $subject = 'Your order was placed successfully!';
                $sentTo = "order@itiresonline.com";
                $this->email($email, $message, $subject, $sentTo);
                //send email
                if ($this->session->userdata('user_id')) {
                    $user_id = $this->session->userdata('user_id');
                    $this->db->delete('cart_data', array('cart_data_user_fk' => $user_id));
                }
                $this->clear_cart();
                echo json_encode(array('status' => 200, 'success' => 'Payment successfully completed.'));
                exit();
            } else {
                echo json_encode(array('status' => 500, 'error' => 'Something went wrong. Try after some time.'));
                exit();
            }
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

    public function success() {


//        echo '<pre>', print_r($_GET);die;
        //require_once(APPPATH.'third_party/fedex-common.php5');
//        require_once(APPPATH . 'third_party/ShipWebServiceClient.php5');
        //require_once(APPPATH.'third_party/TrackWebServiceClient.php5'); 

        $user_id = $this->session->userdata('user_id');
        $userData = $this->users->get_allData($user_id);

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
            $this->order_summary->update_tax($order_number_last, $_SESSION['flexi_cart']['summary']);
            /* Order */
            //send email
            $this->data = $orderData;
            $this->data['payment_type'] = "Paypal";
            $this->data['user_name'] = $userData['first_name'] . ' ' . $userData['last_name'];
            $this->data['phone'] = $userData['phone'];
            $this->data['order_id'] = $order_number_last;
            $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
            $this->data['cart_items'] = $this->flexi_cart->cart_items();
            $order_success = $this->load->view('product/success_order', $this->data, TRUE);

            $email = $userData['email'];
            $message = $order_success;
            $subject = 'Your order was placed successfully!';
            $sentTo = "order@itiresonline.com";
//            $sentTo = "mayurv@rebelute.com";
            $this->email($email, $message, $subject, $sentTo);
            //send email
//            $ret = $this->demo_cart_model->demo_save_order($orderData);
        } else {
            redirect('home/checkout/cancel');
        }
        if ($this->session->userdata('user_id')) {
            $user_id = $this->session->userdata('user_id');
            $this->db->delete('cart_data', array('cart_data_user_fk' => $user_id));
        }
        $this->clear_cart();
        redirect('home/checkout/success');

//        echo json_encode(array('content' => $_POST));
//        die;
    }

    public function cancel() {

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
        }
        redirect('home/checkout/cancel');
    }

    public function orders() {

        if (!$this->ion_auth->logged_in()) {
// redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['cart_items'] = $this->flexi_cart->cart_items();

        $this->data['country_list'] = (array('' => 'Select Country')) + $this->country->dropdown('countryname');
        $this->data['state_list'] = (array('' => 'Select State')) + $this->state->dropdown('statename');

        $this->data['my_orders'] = $this->orders_summary->get_by_id($user_id);

        $totalRec = $this->orders_summary->count_by(array('ord_user_fk' => $user_id));
        /* Ajax Pagination */

        $config['uri_segment'] = 3;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'home/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilterOrder';
        $this->ajax_pagination->initialize($config);
//        echo '<pre>', print_r($config);
        /* Ajax Pagination */

//        echo '<pre>', print_r($this->data['my_orders']);die;
        $this->data = $this->_get_all_data();
        $this->data['pages'] = $this->pages_model->as_array()->get_all();

        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', 'orders', NULL, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function page($id) {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['cart_items'] = $this->flexi_cart->cart_items();
        $this->data['home_section'] = $this->site_section->home_page_sction();
        $this->data['pages1'] = $this->pages_model->get_record($id);
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
//        echo '<pre>', print_r($this->data['my_orders']);die;
        $this->data = $this->_get_all_data();

        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', '_simple_page', $this->data, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', '', TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', '', TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function invoice($orderId) {


        $this->load->helper(array('dompdf', 'file'));
//        $admin_library/order_details order_invoice
        $this->admin_library->order_details($orderId);
//        $html = $this->load->view('invoice/invoice', $data, true, array(0, 0, 595, 841), 'a4', 'portrait');
        $html = $this->load->view('mng_product/_invoice', $data, true, array(0, 0, 595, 841), 'a4', 'portrait');

//        echo $html;die;
        // Uncomment

        pdf_create($html, 'invoice_' . $orderId, 'a4', 'lanscape');

        file_put_contents('assets/invoice/invoice_' . $orderId . ".pdf", pdf_create($html, 'invoice_' . $orderId, 0, 'a4', 'lanscape'));
    }

    public function our_services() {

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['pages'] = $this->pages_model->as_array()->get_all();
        $this->data = $this->_get_all_data();
        $this->data['ourservices_section'] = $this->site_section->ourservices_page_sction();
        $this->data['home_section'] = $this->site_section->home_page_sction();

        $brand_attr_id = 2;
        if ($brand_attr_id != null)
            $this->data['brands_dtails'] = $this->pattribute_sub->get_sub_attributes_at_id(2);
        else
            $this->data['brands_dtails'] = null;

        $this->data['service_category'] = $this->product_category->service_category();

        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('content', 'home/our_services', $this->data, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();
    }

    public function ajaxPaginationTest() {

        $this->data = $this->_get_all_data();

        //pagination configuration
        $data['posts'] = $this->data['product_details'] = $this->product->get_products();
        $totalRec = $this->product->count_all();

        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'home/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);
//        $this->data = $this->_get_all_data();
        //get the posts data
        //load the view
        $this->load->view('post/index', $data);
    }

    public function product_enquiry($method = null) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == "enquiry") {
            $pro_id = $this->input->post('product_id');
            $cat_id = $this->input->post('category_id');
            $enquiry = array(
                'product_name' => $this->input->post('product_name'),
                'product_id' => $this->input->post('product_id'),
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'description' => $this->input->post('message'),
                'phone' => $this->input->post('phone')
            );
            $message = 'Hi,<br><br>';
            $message .= 'Name :-' . $this->input->post('name') . '<br><br>';
            $message .= 'Product Name :-' . $this->input->post('product_name') . '<br><br>';
            $message .= 'Message :-' . $this->input->post('message') . '<br><br><br>';
            $message .= 'Thank You';
            $subject = 'Enquiry';
            $email = $this->input->post('email');

            $this->email($email, $message, $subject);

            $this->enquiry_model->insert($enquiry);
            $this->session->set_flashdata('message', 'Enquiry has been sent!');
        }

        redirect('home/shop_product/' . $pro_id . '/' . $cat_id);
    }

    public function review_rating($method = null) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == "review") {
            $user_id = $this->session->userdata('user_id');
            $rate = $this->input->post('points');
            $product_id = $this->input->post('product_id');
            $dis = $this->input->post('dis');
            $id = $this->input->post('editid');
            $che = $this->review_model->check_review_product($product_id, $user_id);
            if ($che == true) {

                $arr = array(
//                    'product_id' => $product_id,
                    'discription' => $dis,
                    'review_total' => $rate,
//                    'user_id' => $user_id
                );
//           echo $id;           die()
                $this->review_model->update($id, $arr);
            } else {
                $arr = array(
                    'product_id' => $product_id,
                    'discription' => $dis,
                    'review_total' => $rate,
                    'user_id' => $user_id
                );
                $this->review_model->insert($arr);
            }
            echo json_encode(TRUE);
            //die();
            //redirect('')
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == "edit" || $this->input->post('editid') != '') {

            $pid = $this->input->post('pid');
            $uid = $this->input->post('uid');

            $result = $this->review_model->get_review_edit($uid, $pid);
            if ($result) {
                echo json_encode($result);
            }
        }
//        echo json_encode(TRUE);
//        die();
    }

    public function contact($method = null) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $method == "con") {

            $contact = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'message' => $this->input->post('message'),
                'url' => $this->input->post('url')
            );
            $message = 'Hello Team,<br><br>';
            $message .= 'Customer Name : <b>' . $this->input->post('name') . '</b> has recently make an enquiry<br><br>';
            $message .= '<b> Customer Says, </b><br>' . $this->input->post('message') . '<br><br><br>';
            $message .= 'Thank You';
            $email = $this->input->post('email');
            $subject = 'iTires Online Customer Question';
//
//            $this->common_model->sendEmail($message, $email, $subject);
            if ($this->enquiry_model->contact_us($contact)) {
                $sendTo = "contact@itiresonline.com";
                $this->email($email, $message, $subject, $sendTo);
                $this->session->set_flashdata('message', 'Message has been sent!');
                redirect('home/contact_us');
            }
        }
    }

    public function email($email, $message, $subject, $sendTo = null) {

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'itiresonline.com'; //smtp host name
        $config['smtp_port'] = '587'; //smtp port number
        $config['smtp_user'] = 'contact@itiresonline.com';
        $config['smtp_pass'] = 'blablabla'; //$from_email password
        $config['mailtype'] = 'html';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['newline'] = "\r\n"; //use double quotes
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->set_crlf("\r\n");
        $this->email->from($email); // change it to yours

        if (isset($sendTo))
            $this->email->to($sendTo); // change it to yours
        else
            $this->email->to("info@itiresonline.com"); // change it to yours
        $this->email->subject($subject);
        $this->email->message($message);
        $result = $this->email->send();

        return true;
    }

    function ajaxPaginationData() {

        $conditions = array();

        $filterTearm['search_term'] = null;
        $this->data['no_pagination'] = "false";
        //calc offset number
        $page = $this->input->post('page');

        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }

        $session_data = $this->session->userdata('recent_product');




        if ($this->input->post('product_make'))
            $session_data['product_make'] = $this->input->post('product_make');
        else
            $session_data['product_make'] = $this->input->post('product_make_recent');

        //total rows count
//        $data['posts'] = $this->data['product_details'] = $this->product->get_products();
//        $totalRec = $this->product->count_all();

        if ($this->input->post('keywords') != 'by_product_price' && $this->input->post('keywords') != 'related_product' && $this->input->post('keywords') != 'by_size' && $this->input->post('keywords') != 'by_brand' && $this->input->post('keywords') != 'by_product' && $this->input->post('keywords') != 'by_order' && $this->input->post('keywords') != 'size_filter') {

            $make_id = isset($session_data['product_make']) ? $session_data['product_make'] : '';
            $year_id = isset($session_data['product_year']) ? $session_data['product_year'] : '';
            $model_id = isset($session_data['product_model']) ? $session_data['product_model'] : '';
        } else {
            $make_id = null;
            $year_id = null;
            $model_id = null;
        }


        $product_category_id = $this->input->post('product_category');
        $product_sub_category = $this->input->post('product_sub_category');
        if (isset($product_category_id) && $product_category_id != '' && $this->input->post('keywords') != 'by_order') {

            $details = $this->product_category->get_category_name_by_id($product_category_id);
            $this->data['category_title'] = $details['name'];
            $this->data['category_description'] = $details['description'];
            if (isset($product_sub_category) && $product_sub_category != '') {
                $details = $this->product_sub_category->get_sub_category_name_by_id($product_sub_category);
                $this->data['category_title'] = $details['name'];
            }
        } else {
            $this->data['category_title'] = "Shop";
            $this->data['category_description'] = "It all begins right here at ITires Online. Test results, Consumer ratings and reviews. Super-fast shipping. The best of the best brands.";
        }

//        echo $this->input->post('keywords');
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

//        $this->data['product_filter_count'] = $this->product->get_filter_product_count($make_id, $year_id, $model_id, $product_category_id, $product_sub_category);
        if ($this->input->post('keywords') == 'by_size') {

            /* Code Modified 24 November 2017 */
            $bysize = $this->session->userdata('sess_bysize');
            $bysize = $_POST['size'];
            if ($this->input->post('size') != '') {
                $size = explode(',', $this->input->post('size'));
                $bysize = $size[0] . '/' . $size[1] . 'R' . $size[2];
            }
            $this->data['product_details'] = $this->product->get_filter_product(0, 0, 0, 1, null, null, $this->perPage, $offset, null, $bysize);
            foreach ($this->data['product_details'] as $key => $value) {
                $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
            }

            $this->data['product_count'] = $this->product->get_filter_product_count(null, null, null, $product_category_id, null, null, $bysize, null, $filterTearm, $allSizes);
//            $this->data['product_details_count'] = $this->product->get_filter_product_count(null, null, null, $product_category_id, null, null, $bysize);
            $this->data['product_count'] = $this->data['product_count'] = $this->product->get_filter_product_count(0, 0, 0, 1, null, null, $bysize);
            $totalRec = ($this->data['product_count']);
            /* Code Modified 24 November 2017 */
        } else if ($this->input->post('keywords') == 'by_model_size') {
            $model_temp_id = $this->input->post('product_model');
//                echo $model_temp_id;die;
            //get all available size of model
            /* Code Modified 24 November 2017 */
            $bysize = $this->session->userdata('sess_bysize');
            $bysize = $_POST['size'];
            if ($this->input->post('size') != '') {
                $size = explode(',', $this->input->post('size'));
                $bysize = $size[0] . '/' . $size[1] . 'R' . $size[2];
            }
            $this->data['product_details'] = $this->product->get_filter_product(0, 0, 0, 1, null, null, $this->perPage, $offset, null, $bysize);
            foreach ($this->data['product_details'] as $key => $value) {
                $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
            }

            $this->data['product_count'] = $this->product->get_filter_product_count(null, null, null, $product_category_id, null, null, $bysize, null, $filterTearm);
//            $this->data['product_details_count'] = $this->product->get_filter_product_count(null, null, null, $product_category_id, null, null, $bysize);
            $this->data['product_count'] = $this->data['product_count'] = $this->product->get_filter_product_count(0, 0, 0, 1, null, null, $bysize);
            /* Code Modified 24 November 2017 */
            $this->data['product_count'] = ($this->data['product_count']);
            $totalRec = ($this->data['product_count']);
        } else if ($this->input->post('keywords') == 'by_brand') {

            $this->data['product_details'] = $this->product->get_filter_product(NULL, NULL, NULL, $product_category_id, $product_sub_category, 'brand', $this->perPage, $offset);
            foreach ($this->data['product_details'] as $key => $value) {
                $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
            }
            $this->data['product_count'] = $this->product_attribute->count_by(array('sub_attribute_dp_id' => $product_sub_category));
//            $this->data['product_count'] = $this->product->get_filter_product_count(0, 0, 0, 1, null, null, $bysize);
            $totalRec = ($this->data['product_count']);
        } else if ($this->input->post('keywords') == 'by_product') {

            if ($this->input->post('tags') && $this->input->post('tags') != '')
                $filterTearm['search_term'] = $this->input->post('tags');

//            $this->data['product_details'] = $this->product->get_product_by_category_id($categoryId, $subCategoryId, $config["per_page"], NULL, NULL, $_POST['search']);
            $this->data['product_details'] = $this->product->get_filter_product(NULL, NULL, NULL, 1, null, null, $this->perPage, $offset, $filterTearm);
            foreach ($this->data['product_details'] as $key => $value) {
                $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
            }
            $this->data['product_count'] = $this->product->get_filter_product_count(null, null, null, 1, null, null, null, null, $filterTearm);
//            $this->data['product_count'] = $this->product->count_by(array('category_id' => $product_category_id));
            $totalRec = ($this->data['product_count']);
        } else if ($this->input->post('keywords') == 'by_order') {
            $user_id = $this->session->userdata('user_id');
            $this->data['my_orders'] = $this->orders_summary->get_by_id($user_id, $this->perPage, $offset);
            $totalRec = $this->orders_summary->count_by(array('ord_user_fk' => $user_id));
        } else if ($this->input->post('keywords') == 'by_product_price') {
            $user_id = $this->session->userdata('user_id');
            $bysize = null;
            $bid = null;

            if ($this->input->post('brand_id') != '')
                $bid = $this->input->post('brand_id');

            $filterTearm['brand'] = $bid;
            $price_range = $this->input->post('price_range');
            $filterTearm['price'] = $price_range;

            if ($this->input->post('size') != '') {
                $size = explode(',', $this->input->post('size'));
                $bysize = $size[0] . '/' . $size[1] . 'R' . $size[2];
            }


            $price_range = $this->input->post('price_range');
            $filterTearm['price'] = $price_range;
            $this->data['product_details'] = null;
            $model_id = $this->input->post('product_model');
            if (isset($model_id) && $model_id != null) {

                /* Model size */
                $allSizes = array();
                $model_detals = $this->mst_model_size->get_model_size_detail($model_id);
//                echo '<pre>', print_r($model_detals);die;
                if (isset($model_detals) && !empty($model_detals)) {
                    foreach ($model_detals as $modelData) {
                        array_push($allSizes, $modelData['size']);
                    }
                }

                $this->data['model_id'] = $model_temp_id;
                $this->data['all_sizes'] = $allSizes;

                $this->data['product_details'] = $this->product->get_filter_product(null, null, null, $product_category_id, null, null, $this->perPage, $offset, $filterTearm, $bysize, $allSizes);
                foreach ($this->data['product_details'] as $key => $value) {
                    $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
                }
                $this->data['product_count'] = $this->product->get_filter_product_count(null, null, null, $product_category_id, null, null, $bysize, null, $filterTearm, $allSizes);
//                    echo $this->data['product_count'];die;
                $unique_array = array();
                foreach ($this->data['product_details'] as $pDta) {
                    $hash = $pDta['id'];
                    $unique_array[$hash] = $pDta;
                }
                $this->data['product_details'] = $unique_array;
                $totalRec = ($this->data['product_count']);
                /* Model size */
            } else {

                $this->data['product_details'] = $this->product->get_filter_product(null, null, null, $product_category_id, null, null, $this->perPage, $offset, $filterTearm, $bysize);
                foreach ($this->data['product_details'] as $key => $value) {
                    $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
                }
                $this->data['product_details_count'] = $this->product->get_filter_product_count(null, null, null, $product_category_id, null, null, $bysize, null, $filterTearm);
                $this->data['product_count'] = $this->data['product_details_count'];
                $totalRec = ($this->data['product_details_count']);
            }
        } else if ($this->input->post('method') == 'size_filter') {

            $bysize = null;
            $bid = null;

            if ($this->input->post('brand_id') != '')
                $bid = $this->input->post('brand_id');

            $filterTearm['brand'] = $bid;
            $price_range = $this->input->post('price_range');
            $filterTearm['price'] = $price_range;

            if ($this->input->post('size') != '') {
                $size = explode(',', $this->input->post('size'));
                $bysize = $size[0] . '/' . $size[1] . 'R' . $size[2];
            }


            $this->session->set_userdata('sess_bysize', $bysize);

            $user_id = $this->session->userdata('user_id');
            $price_range = $this->input->post('price_range');
            $filterTearm['price'] = $price_range;
            $this->data['product_details'] = null;
            $this->data['product_details'] = $this->product->get_filter_product(null, null, null, $product_category_id, null, null, $this->perPage, $offset, $filterTearm, $bysize);
            foreach ($this->data['product_details'] as $key => $value) {
                $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
            }
            $this->data['product_details_count'] = $this->product->get_filter_product_count(null, null, null, $product_category_id, null, null, $bysize, null, $filterTearm);
            $this->data['product_count'] = $this->data['product_details_count'];
            $totalRec = ($this->data['product_details_count']); //($this->data['product_details_count']);
        } else {
            $this->data['product_details'] = $this->product->get_filter_product($make_id, $year_id, $model_id, $product_category_id, null, null, $this->perPage, $offset);
            foreach ($this->data['product_details'] as $key => $value) {
                $this->data['product_details'][$key]['product_attr_details'] = $this->product_attribute->as_array()->get_by_id($value['id']);
            }
            $totalRec = $this->product->count_by(array('category_id' => $product_category_id)); //count($this->data['product_filter_count']);
        }
        $this->data['product_count'] = $totalRec;
        //pagination configuration
        $config['uri_segment'] = 3;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . 'home/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        if ($this->input->post('keywords') == 'related_product') {
            $config['link_func'] = 'searchFilterRel';
        } else if ($this->input->post('keywords') == 'by_brand') {
            $config['link_func'] = 'searchFilterBrand';
        } else if ($this->input->post('keywords') == 'by_size') {
            $config['link_func'] = 'searchFilterSize';
        } else if ($this->input->post('keywords') == 'by_product') {
            $config['link_func'] = 'searchFilterProduct';
        } else if ($this->input->post('keywords') == 'by_order') {
            $config['link_func'] = 'searchFilterOrder';
        } else if ($this->input->post('keywords') == 'by_product_price') {
            $config['link_func'] = 'searchFilterByFilter';
        } else if ($this->input->post('method') == 'size_filter') {
            $config['link_func'] = 'searchFilterByFilter';
        } else if ($this->input->post('keywords') == 'by_model_size') {
            $config['link_func'] = 'searchSizeFilterProduct';
        } else
            $config['link_func'] = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        //get posts data
        //load the view
        if ($this->input->post('keywords') == 'related_product' || $this->input->post('keywords') == 'by_size' || $this->input->post('keywords') == 'by_brand')
            $this->load->view('product/ajax_product_view_related', $this->data, false);
        else if ($this->input->post('keywords') == 'by_order') {
            $this->load->view('product/_ajax_order_view', $this->data, false);
        } else if ($this->input->post('method') == 'size_filter') {
            $this->load->view('product/ajax_product_view_related', $this->data, false);
        } else
            $this->load->view('product/ajax_product_view', $this->data, false);
    }

    public function createShip() {
        $_POST['test'] = 'data';
        $order_id = $this->session->userdata('order_sess_id');

        $this->session->unset_userdata('order_sess_id');
//        foreach ($this->data['cart_items'] as $key => $cartData) {
//            $dataPayment['row_id'] = $cartData['row_id'];
//            $dataPayment['product_id'] = $cartData['id'];
////            $dataPayment['payment_gross'] = $cartData['internal_price'];
//            $this->payment->insert($dataPayment);
//        }
//        require_once(APPPATH . 'third_party/RateWebServiceClient.php5');
        require_once(APPPATH . 'third_party/ShipWebServiceClient.php5');

        return true;
    }

    public function createShip1() {
        $_POST['test'] = 'data';
        require_once(APPPATH . 'third_party/ShipWebServiceClient.php5');
        die;
    }

    public function trackShip($tackId) {
        $_POST['tackId'] = $tackId;
        $_SESSION['trackId'] = $tackId;

        require_once(APPPATH . 'third_party/TrackWebServiceClient.php5');
    }

    public function deleteDuplicateRecords() {
        $SQL = "SELECT distinct(product_sku),id FROM `it_products` group by product_sku having count(*) > 1";
        $query = $this->db->query($SQL);
        $result = $query->result_array();
        foreach ($result as $dnata) {
            $this->db->where('id', $data['id']);
            $this->db->delete('it_products');
        }
    }

    public function testEmail() {
        $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
        $order_success = $this->load->view('product/success_order', $this->data, TRUE);
        $email = $this->input->post('mayurv@rebelute.com');
        $message = $order_success;
        $subject = 'Your order placed succefully';
        $this->email($email, $message, $subject);
    }

    // set the error 404 page
    public function error_404() {

        $this->output->set_status_header('404');

        $pageTitle = 'iTiresOnline';
        $renderTo = 'product/error_404';

        // call the render view function here
//        $this->_render_view($pageTitle, $renderTo, $this->data);
        $this->data = $this->_get_all_data();
        $this->template->set_master_template('landing_template.php');
        $this->template->write_view('header', 'snippets/header', $this->data);
        $this->template->write_view('sidebar', 'snippets/sidebar', NULL);
        $this->template->write_view('content', $renderTo, $this->data, TRUE);
        $this->template->write_view('ab_btm_sidebar', 'snippets/above_btm_sidebar', $this->data, TRUE);
        $this->template->write_view('btm_sidebar', 'snippets/btm_sidebar', $this->data, TRUE);
        $this->template->write_view('footer', 'snippets/footer', '', TRUE);
        $this->template->render();

        // // Make sure you actually have some view file named 404.php
        // $this->load->view('Error_page');
    }

    public function calculateTax() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $zipcode = $this->input->post('zip_code');
            $data = $this->tax->get_tax_rate($zipcode);


            if (isset($data) && $data != null) {
                if (isset($data['zip_code']))
                    $zipcode = $data['zip_code'];
                else if (isset($data['zipcode']))
                    $zipcode = $data['zipcode'];
                $state = $data['state'];
                $tax_per = $data['combined_rate'];
                $region_name = $data['region_name'];
//                echo "<pre>",print_r( $this->session->userdata('flexi_cart')['summary']['item_summary_total']) ;die;
                $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
                $tax_amont = (($tax_per * $this->session->userdata('flexi_cart')['summary']['item_summary_total']) / 100);
                $_SESSION['flexi_cart']['summary']['tax_total'] = round($tax_amont, 2);
                $_SESSION['flexi_cart']['summary']['tax_percentage'] = $tax_per;
                $_SESSION['flexi_cart']['summary']['zip_code'] = $zipcode;
                $_SESSION['flexi_cart']['summary']['state'] = $state;
                $_SESSION['flexi_cart']['summary']['region'] = $region_name;
                $item_summary_total = round($_SESSION['flexi_cart']['summary']['item_summary_total'], 2);

                echo json_encode(
                        array("status" => "1",
                            "per" => $tax_per,
                            "tax_amount" => round($tax_amont, 2),
                            "item_summary_total" => $item_summary_total,
                            "state" => $state,
                            "region" => $region_name,
                ));
                die;
            } else {
                $_SESSION['flexi_cart']['summary']['tax_total'] = "0";
                $_SESSION['flexi_cart']['summary']['tax_percentage'] = "0";
                $_SESSION['flexi_cart']['summary']['zip_code'] = '';
                $item_summary_total = $_SESSION['flexi_cart']['summary']['item_summary_total'];
                echo json_encode(array("status" => "0", "content" => "Unable to find zip code, please enter a valid zip code", 'item_summary_total' => $item_summary_total));
                die;
            }
        }
    }

}
