<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->model(array('users'));
        $this->load->helper(array('url', 'language'));
        $this->load->library('user_agent');        
        $this->load->model('demo_cart_model');
        $this->load->model('common_model');
        /* Load Master model */
        $this->flexi = new stdClass;

        $this->load->library('flexi_cart');

        $this->load->model(array('users', 'product_category', 'product_sub_category', 'product', 'blog_category', 'social_links', 'footer_cms'));
        $this->load->model(array('group_model', 'pattribute', 'pattribute_sub'));

        $this->lang->load('auth');
    }

    /**
     * Login page 
     * @author      Harshal B <hashalb@rebelute.com>
     * @return      login page view
     * @Date        11 Nov 2017
     */
    public function index() {

        // check if user is logged in
        if ($this->ion_auth->logged_in()) {
            // refresh the page
            redirect('', 'refresh');
        } else {
            // load the services page view
            // set the parameters for rendering view
            $this->data = null;
            $pageTitle = 'Buy Sell Rent | User Login';
            $renderTo = 'login';

            // call the render view function here
            $this->_renders_view($pageTitle, $renderTo, $this->data);
        }
    }

    // log the user in
    public function login() {
        
        if ($this->ion_auth->logged_in()) {
            redirect('/', 'refresh');
        }
        
        $this->data['title'] = $this->lang->line('login_heading');

        $user_id = $this->session->userdata('user_id');

        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->form_validation->set_error_delimiters('<p style="color:#b11e23" class="error">', '</p>');

        //validate form input
        $this->form_validation->set_rules('email', 'Email Address', 'valid_email|required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == TRUE) {

            // check to see if the user is logging in
            // check for "remember me"
            $remember = (bool) $this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'), $remember)) {
                // if the login is successful

                if ($this->ion_auth->is_admin()) {
                    redirect('/auth/customers', 'refresh');
                } else {
                    if (strpos($_SERVER['HTTP_REFERER'], "cart"))
                        redirect('/home/cart', 'refresh');
                    else
                        redirect('/', 'refresh');
                }
            } else {
                // $this->session->set_flashdata('message', $this->ion_auth->messages());
                $this->session->set_flashdata('message', 'Invalid credentials');
                redirect('auth/', 'refresh');
            }
        } else {
            // the user is not logging in so display the login page
            // set the flash data error message if there is one
            $this->data = null;
            $pageTitle = 'Buy Sell Rent | User Login';
            $renderTo = 'login';

            // call the render view function here
            $this->_renders_view($pageTitle, $renderTo, $this->data);
        }
    }

    /**
    * @author : Harshal Borse <harshalb@rebelute.com>
    * login using popup on checkout page
    */
    public function popupLogin() {

        $username = trim($this->input->post('username'));
        $password = trim($this->input->post('password'));

        $remember = (bool) $this->input->post('remember');

        if ($this->ion_auth->login($this->input->post('username'), $this->input->post('password'), $remember)) {
            // set the json response array for success message
            $response_array = json_encode(array('status' => '1', 'message' => 'Login successful'));
            echo $response_array; exit;
        } else {
            // set the json response array for success message
            $response_array = json_encode(array('status' => '0', 'message' => 'Invalid credentials'));
            echo $response_array; exit;
        }

    }

    public function customers() {
        // check if user is logged in
        if (!$this->ion_auth->logged_in()) {
            // refresh the page
            redirect('auth', 'refresh');
        } else {
            // load the services page view
            // set the parameters for rendering view
            $this->data = null;
            // set the page title
            $this->data['page_title'] = 'Buy Sell Rent | Customers';
            $renderTo = 'customers';

            // get the user id from session
            $user_id = $this->session->userdata('user_id');
            
            // get all the users from database
            $this->data['customers'] = $this->ion_auth->users()->result();

            foreach ($this->data['customers'] as $k => $user) {
                $this->data['customers'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
            }

            $user_id = $this->session->userdata('user_id');
            $data['dataHeader'] = $this->users->get_allData($user_id);
            
            // set master template
            $this->template->set_master_template('back_template.php');
            $this->template->write_view('top_header', 'back_snippets/top_header', $this->data);
            $this->template->write_view('sidebar', 'back_snippets/sidebar', $this->data);
            $this->template->write_view('content', $renderTo, $this->data);
            $this->template->write_view('footer', 'back_snippets/footer', $this->data);
            $this->template->render();

            // call the render view function here
            // $this->_renders_view($pageTitle, $renderTo, $this->data);
        }
    }

    // log the user out
    public function logout() {
        $this->data['title'] = "Logout";

        // log the user out
        $logout = $this->ion_auth->logout();

        // redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('', 'refresh');
    }

// change password
    public function change_password() {
        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

//        if (!$this->ion_auth->logged_in()) {
//            redirect('auth/login', 'refresh');
//        }

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() == false) {
// display the form
// set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['old_password'] = array(
                'name' => 'old',
                'id' => 'old',
                'type' => 'password',
                'class' => 'form-control',
                'data-error' => '.regErorr8',
                'placeholder' => 'Old Password'
            );
            $this->data['new_password'] = array(
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                'class' => 'form-control',
                'data-error' => '.regErorr8',
                'placeholder' => 'New Password'
            );
            $this->data['new_password_confirm'] = array(
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                'class' => 'form-control',
                'data-error' => '.regErorr8',
                'placeholder' => 'New Confirm Password'
            );

            $this->data['user_id'] = array(
                'name' => 'user_id',
                'id' => 'user_id',
                'type' => 'hidden',
                'value' => $user->id,
            );

// render
// $this->_render_page('auth/change_password', $this->data);
            $this->template->set_master_template('login_template.php');
            $this->template->write_view('content', 'change_password', (isset($this->data) ? $this->data : NULL), TRUE);
            $this->template->render();
        } else {
            $identity = $this->session->userdata('identity');

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change) {
//if the password was successfully changed
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $this->logout();
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth/change_password', 'refresh');
            }
        }
    }

    // forgot password
    public function forgot_password()
    {
        // show cart items on page
        $this->data['cart_items'] = $this->session->userdata('flexi_cart')['items'];
        $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];

        foreach ($this->data['cart_items'] as $key => $cData) {
            $this->data['cart_items'][$key]['stock_quantity'] = $this->product->getStockDetail($cData['id']);
        }

        // check if user is logged in
        if ($this->ion_auth->logged_in()) {
            // refresh the page
            redirect('', 'refresh');
        } else {

            // set the parameters for rendering view
            $this->data = null;
            // set the page title
            $this->data['page_title'] = 'Buy Sell Rent | Forgot Password';
            $renderTo = 'auth/forgot_password';

            if (!empty($this->input->post('email'))) {                

                $identity_column = $this->config->item('identity', 'ion_auth');
                $identity = $this->ion_auth->where($identity_column, $this->input->post('email'))->users()->row();

                if (empty($identity)) {
                    if ($this->config->item('identity', 'ion_auth') != 'email') {
                        $this->ion_auth->set_error('forgot_password_identity_not_found');
                    } else {
                        $this->ion_auth->set_error('forgot_password_email_not_found');
                    }

                    $this->session->set_flashdata('error', $this->ion_auth->errors());
                    redirect("auth/forgot_password", 'refresh');
                }

                // run the forgotten password method to email an activation code to the user
                $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

                if ($forgotten) {
                    // if there were no errors
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
                } else {
                    $this->session->set_flashdata('error', $this->ion_auth->errors());
                    redirect("auth/forgot_password", 'refresh');
                }
            } else {

                    $this->data['product_categories'] = $this->product_category->get_all_categories();  

                    if(!empty($this->data['product_categories'])) {
                        foreach ($this->data['product_categories'] as $k => $pData) {
                            $this->data['product_categories'][$k]['sub_categories'] = $this->product_sub_category->get_sub_categories($pData['id']);
                            if(!empty($this->data['product_categories'][$k]['sub_attibutes'])) {
                                foreach ($this->data['product_categories'][$k]['sub_categories'] as $key => $third_level_list) {
                                    $this->data['product_categories'][$k]['sub_categories'][$key]['third_level'] = $this->product_sub_category->get_sub_categories($third_level_list['id']);
                                }
                            }
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
                
                // get all the social links
                $this->data['social_links'] = $this->social_links->as_array()->get_all();

                // set master template
                $this->template->set_master_template('front_template.php', $this->data);            
                $this->template->write_view('top_header', 'front_snippets/top_header', $this->data);
                $this->template->write_view('main_menu', 'front_snippets/main_menu', $this->data);
                $this->template->write_view('content', $renderTo, $this->data);
                $this->template->write_view('footer', 'front_snippets/footer', $this->data);
                $this->template->render();
            }
        }
    }

// reset password - final step for forgotten password
    public function reset_password($code = NULL)
    {
        if (!$code) {
            show_404();
        }

        $user = $this->ion_auth->forgotten_password_check($code);
       
        if ($user) {

            // if the code is valid then display the password reset form
            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

            if ($this->form_validation->run() == false) {
                // display the form
                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['new_password'] = array(
                    'name' => 'new',
                    'id' => 'new',
                    'class' => 'form-control',
                    'type' => 'password',
                    'pattern' => '^(?=.*[\d])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])[\w!@#$%^&*]{8,}$',
                    'title' => '8 chars long, atleast 1 lowercase letter, 1 capital letter, 1 number, 1 special character => !@#$%^&'
                );
                $this->data['new_password_confirm'] = array(
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'class' => 'form-control',
                    'type' => 'password',
                    'pattern' => '^(?=.*[\d])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])[\w!@#$%^&*]{8,}$',
                    'title' => '8 chars long, atleast 1 lowercase letter, 1 capital letter, 1 number, 1 special character => !@#$%^&'
                );
                $this->data['user_id'] = array(
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'class' => 'form-control',
                    'value' => $user->id,
                );
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;

                // $this->template->set_master_template('login_template.php');
                // get all the social links
                $this->data['social_links'] = $this->social_links->as_array()->get_all();

                // set master template
                $this->template->set_master_template('front_template.php', $this->data);
            
                $this->template->write_view('top_header', 'front_snippets/top_header', $this->data);
                $this->template->write_view('main_menu', 'front_snippets/main_menu', $this->data);
                $this->template->write_view('content', 'auth/reset_password', (isset($this->data) ? $this->data : NULL), TRUE);
                $this->template->write_view('footer', 'front_snippets/footer', $this->data);
                $this->template->render();
// render
//                $this->_render_page('auth/reset_password', $this->data);
            } else {
// do we have a valid request?
//                 if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

// // something fishy might be up
//                     $this->ion_auth->clear_forgotten_password_code($code);

//                     show_error($this->lang->line('error_csrf'));
//                 } else {
// finally change the password
                    $identity = $user->{$this->config->item('identity', 'ion_auth')};

                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

                    if ($change) {
// if the password was successfully changed
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect("auth/login", 'refresh');
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        $this->template->set_master_template('login_template.php');
                        $this->template->write_view('content', 'auth/reset_password/' . $code, (isset($this->data) ? $this->data : NULL), TRUE);
                        $this->template->render();
//                        redirect('auth/reset_password/' . $code, 'refresh');
                    }
                // }
            }
        } else {
// if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

// activate the user
    public function activate($id, $code = false) {
        if ($code !== false) {
            $activation = $this->ion_auth->activate($id, $code);
        } else if ($this->ion_auth->is_admin()) {
            $activation = $this->ion_auth->activate($id);
        }

        if ($activation) {
// redirect them to the auth page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("auth", 'refresh');
        } else {
// redirect them to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

// deactivate the user
    public function deactivate($id = NULL) {
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
// redirect them to the home page because they must be an administrator to view this
            return show_error('You must be an administrator to view this page.');
        }

        $id = (int) $id;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
        $this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

        if ($this->form_validation->run() == FALSE) {
// insert csrf check
            $this->data['csrf'] = $this->_get_csrf_nonce();
            $this->data['user'] = $this->ion_auth->user($id)->row();
            $user_id = $this->session->userdata('user_id');
            $data['dataHeader'] = $this->users->get_allData($user_id);
            $this->template->set_master_template('template.php');
            $this->template->write_view('header', 'backend/header', (isset($data) ? $data : NULL));
            $this->template->write_view('sidebar', 'backend/sidebar', (isset($this->data) ? $this->data : NULL));
            $this->template->write_view('content', 'deactivate_user', (isset($this->data) ? $this->data : NULL), TRUE);
            $this->template->write_view('footer', 'backend/footer', '', TRUE);
            $this->template->render();

            $this->_render_page('auth/deactivate_user', $this->data);
        } else {
// do we really want to deactivate?
            if ($this->input->post('confirm') == 'yes') {
// do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                    show_error($this->lang->line('error_csrf'));
                }

// do we have the right userlevel?
                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
                    $this->ion_auth->deactivate($id);
                }
            }

// redirect them back to the auth page
            redirect('auth', 'refresh');
        }
    }

//register user
    public function register_user() {

        // show cart items on page
        $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];

        // get the cart item from session
        $this->data['cart_items'] = $this->flexi_cart->cart_items();

        if (isset($this->session->userdata('flexi_cart')['summary']))
            $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
        foreach ($this->data['cart_items'] as $key => $cData) {
            $this->data['cart_items'][$key]['stock_quantity'] = $this->product->getStockDetail($cData['id']);
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

        if (!empty($this->input->post('email'))) {

            $identity_column = $this->config->item('identity', 'ion_auth');
            $this->data['identity_column'] = $identity_column;
            $email = strtolower($this->input->post('email'));
            $identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');


            $additional_data = array(
                'first_name' => $this->input->post('firstname'),
                'last_name' => $this->input->post('lastname'),
                'company' => $this->input->post('company'),
                'phone' => $this->input->post('telephone'),
                'fax' => $this->input->post('fax'),
                'address_1' => $this->input->post('address_1'),
                'city' => $this->input->post('city'),
                'postcode' => $this->input->post('postcode'),
                'country' => $this->input->post('country_id'),
                'city' => $this->input->post('zone_id')
            );


            if ($this->ion_auth->register($identity, $password, $email, $additional_data)) {

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth/login");
            } else {
                 $this->data['message'] = 'Email id already registered';
                $this->session->set_flashdata('message', $this->data['message']);
                redirect("auth/register_user");
            }

        } else {

            $this->db->select('id, name');
            $this->db->from('tbl_countries');
            $query = $this->db->get();
            $this->data['country_list'] = $query->result_array();

            // $this->data['country_list'] = (array('' => 'Select Country')) + $this->country->dropdown('countryname');
            
            // load the layouts if form has not submitted
            $this->data['page_title'] = "Buy Sell Rent | User Registration";
            $renderTo = 'register';

            // get all the social links
            $this->data['social_links'] = $this->social_links->as_array()->get_all();

            // set master template
            $this->template->set_master_template('front_template.php', $this->data);
            $this->template->write_view('top_header', 'front_snippets/top_header', $this->data);
            $this->template->write_view('main_menu', 'front_snippets/main_menu', $this->data);
            $this->template->write_view('content', $renderTo, $this->data);
            $this->template->write_view('footer', 'front_snippets/footer', $this->data);
            $this->template->render();
        }
    }

// create a new user
    public function create_user() {

        $user_id = $this->session->userdata('user_id');
        $data['dataHeader'] = $this->users->get_allData($user_id);
        $this->data['title'] = $this->lang->line('create_user_heading');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth/login#signup', 'refresh');
        }

        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

// validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        if ($identity_column !== 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        } else {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true) {
            $email = strtolower($this->input->post('email'));
            $identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');



            /* Upload profile picture */
            if (isset($_FILES['profile_image']['name']) && $_FILES['profile_image']['name'] != '') {
                $targetDir = "uploads/profile/";
                $fileName = $_FILES['profile_image']['name'];
                $targetFile = $targetDir . $fileName;

                if (!file_exists($targetPath)) {
                    mkdir($targetPath, 0777, true);
                }
                $slug = $this->input->post('name');

                $fileExt = pathinfo($_FILES['profile_image']['name']);
                $dataDocumentDetail['type'] = $fileExt['extension'];


                $uploded_file_path = $this->handleUploadUser($slug);
                if ($uploded_file_path != '')
                    $data['profileimg'] = $targetDir . $uploded_file_path;
            }

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => $this->input->post('company'),
                'phone' => $this->input->post('phone'),
                'profileimg' => $data['profileimg'] ? $data['profileimg'] : '',
                'birth_date' => date('y-m-d', strtotime($this->input->post('birth_date'))),
            );
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data)) {
// check to see if we are creating the user
// redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("auth/login#signup");
        } else {
// display the create user form
// set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['first_name'] = array(
                'name' => 'first_name',
                'id' => 'first_name',
                'class' => 'form-control',
                'data-error' => '.regErorr1',
                'autofocus' => 'autofocus',
                'required' => 'required',
                'type' => 'text',
                'value' => $this->form_validation->set_value('first_name'),
            );
            $this->data['last_name'] = array(
                'name' => 'last_name',
                'id' => 'last_name',
                'class' => 'form-control',
                'data-error' => '.regErorr2',
                'required' => 'required',
                'type' => 'text',
                'value' => $this->form_validation->set_value('last_name'),
            );
            $this->data['identity'] = array(
                'name' => 'identity',
                'id' => 'identity',
                'class' => 'form-control',
                'data-error' => '.regErorr3',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['email'] = array(
                'name' => 'email',
                'id' => 'email',
                'type' => 'email',
                'class' => 'form-control',
                'data-error' => '.regErorr4',
                'value' => $this->form_validation->set_value('email'),
            );
            $this->data['company'] = array(
                'name' => 'company',
                'id' => 'company',
                'type' => 'text',
                'class' => 'form-control',
                'data-error' => '.regErorr5',
                'value' => $this->form_validation->set_value('company'),
            );
            $this->data['phone'] = array(
                'name' => 'phone',
                'id' => 'phone',
                'required' => 'required',
                'type' => 'text',
                'class' => 'form-control',
                'data-error' => '.regErorr6',
                'value' => $this->form_validation->set_value('phone'),
            );
            $this->data['password'] = array(
                'name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'class' => 'form-control',
                'data-error' => '.regErorr7',
                'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array(
                'name' => 'password_confirm',
                'id' => 'password_confirm',
                'type' => 'password',
                'class' => 'form-control',
                'data-error' => '.regErorr8',
                'value' => $this->form_validation->set_value('password_confirm'),
            );
            $this->data['birth_date'] = array(
                'name' => 'birth_date',
                'id' => 'birth_date',
                'type' => 'date',
                'class' => 'form-control has-feedback-left',
                'data-error' => '.regErorr9',
                'value' => $this->form_validation->set_value('birth_date'),
            );
            $this->data['profile_image'] = array(
                'name' => 'profile_image',
                'id' => 'profile_image',
                'type' => 'file',
                'class' => 'form-control',
                'data-error' => '.regErorr10',
                'value' => $this->form_validation->set_value('profile_image'),
            );


            $this->template->set_master_template('template.php');
            $this->template->write_view('header', 'backend/header', (isset($data) ? $data : NULL));
            $this->template->write_view('sidebar', 'backend/sidebar', (isset($this->data) ? $this->data : NULL));
            $this->template->write_view('content', 'create_user', (isset($this->data) ? $this->data : NULL), TRUE);
            $this->template->write_view('footer', 'backend/footer', '', TRUE);
            $this->template->render();
        }
    }

    // edit a user
    public function edit_user($id) {

        $this->data['title'] = $this->lang->line('edit_user_heading');

        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))) {
            redirect('auth', 'refresh');
        }

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $user = $this->ion_auth->user($id)->row();
        $groups = $this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();

        $this->form_validation->set_error_delimiters('<p style="color:#eb0000;margin:-5px 0 15px 0" class="error">', '</p>');

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
        $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
        $this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
            // if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
            //     show_error($this->lang->line('error_csrf'));
            // }

            // update the password if it was posted
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
            }

            if ($this->form_validation->run() === TRUE) {
                $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'company' => $this->input->post('company'),
                    'phone' => $this->input->post('phone'),
                );

                // update the password if it was posted
                if ($this->input->post('password')) {
                    $data['password'] = $this->input->post('password');
                }

                // Only allow updating groups if user is admin
                if ($this->ion_auth->is_admin()) {
                    //Update the groups user belongs to
                    $groupData = $this->input->post('groups');

                    if (isset($groupData) && !empty($groupData)) {

                        $this->ion_auth->remove_from_group('', $id);

                        foreach ($groupData as $grp) {
                            $this->ion_auth->add_to_group($grp, $id);
                        }
                    }
                }

                // check to see if we are updating the user
                if ($this->ion_auth->update($user->id, $data)) {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    if ($this->ion_auth->is_admin()) {
                        redirect('auth/customers', 'refresh');
                    } else {
                        redirect('/', 'refresh');
                    }
                } else {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    if ($this->ion_auth->is_admin()) {
                        redirect('auth/customers', 'refresh');
                    } else {
                        redirect('/', 'refresh');
                    }
                }
            }
        }

        // display the edit user form
        // $this->data['csrf'] = $this->_get_csrf_nonce();

        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        // pass the user to the view
        $this->data['user'] = $user;
        $this->data['groups'] = $groups;
        $this->data['currentGroups'] = $currentGroups;

        $this->data['first_name'] = array(
            'name' => 'first_name',
            'class' => 'form-control',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('first_name', $user->first_name),
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'class' => 'form-control',
            'type' => 'text',
            'value' => $this->form_validation->set_value('last_name', $user->last_name),
        );
        $this->data['company'] = array(
            'name' => 'company',
            'id' => 'company',
            'class' => 'form-control',
            'type' => 'text',
            'value' => $this->form_validation->set_value('company', $user->company),
        );
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'class' => 'form-control',
            'type' => 'text',
            'value' => $this->form_validation->set_value('phone', $user->phone),
        );
        $this->data['password'] = array(
            'name' => 'password',
            'id' => 'password',
            'class' => 'form-control',
            'type' => 'password'
        );
        $this->data['password_confirm'] = array(
            'name' => 'password_confirm',
            'id' => 'password_confirm',
            'class' => 'form-control',
            'type' => 'password'
        );

        $this->template->set_master_template('back_template.php');
        $this->template->write_view('top_header', 'back_snippets/top_header', $this->data);
        $this->template->write_view('sidebar', 'back_snippets/sidebar', $this->data);
        $this->template->write_view('content', 'edit_user', $this->data);
        $this->template->write_view('footer', 'back_snippets/footer', $this->data);
        $this->template->render();
//        $this->_render_page('auth/edit_user', $this->data);
    }

    /**
    * @author      : Harshal Borse <harshalb@rebelute.com>
    * @date        : 13 Nov 2017
    * @param       : id (int) - id of the record to delete
    * @desc        : delete the user from table
    */
    public function delete_user($id = NULL)
    {
        // get the posted values of id
        $id = trim($this->input->post('id'));

        // handle the exception here
        try {
            // check if the user is deleted successfully
            if ($this->users->delete_user_data(trim($id))) {
                // set the json response array for success message
                $response_array = json_encode(array('status' => '1', 'message' => 'User deleted successfully'));
                echo $response_array;
                return false;
            } else {
                // set the json response array failure message
                $response_array = json_encode(array('status' => '0', 'message' => 'Failed to delete the user.'));
                echo $response_array;
                return false;
            }

        } catch (Exception $e) {
            // print the exception if any
            echo $e; die;
        }
    }

// create a new group
    public function create_group() {

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['title'] = $this->lang->line('create_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        // validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');

        if ($this->form_validation->run() == TRUE) {
            $new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
            if ($new_group_id) {
                // check to see if we are creating the group
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth", 'refresh');
            }
        } else {
            // display the create group form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['group_name'] = array(
                'name' => 'group_name',
                'id' => 'group_name',
                'type' => 'text',
                'required' => 'required',
                'class' => 'form-control',
                'value' => $this->form_validation->set_value('group_name'),
            );
            $this->data['description'] = array(
                'name' => 'description',
                'id' => 'description',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $this->form_validation->set_value('description'),
            );


            $this->template->set_master_template('template.php');
            $this->template->write_view('header', 'backend/header', (isset($this->data) ? $this->data : NULL));
            $this->template->write_view('sidebar', 'backend/sidebar', (isset($this->data) ? $this->data : NULL));
            $this->template->write_view('content', 'create_group', (isset($this->data) ? $this->data : NULL), TRUE);
            $this->template->write_view('footer', 'backend/footer', '', TRUE);
            $this->template->render();

//            $this->_render_page('auth/create_group', $this->data);
        }
    }

// edit a group
    public function edit_group($id) {
// bail if no group id given
        if (!$id || empty($id)) {
            redirect('auth', 'refresh');
        }

        $user_id = $this->session->userdata('user_id');
        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        $this->data['title'] = $this->lang->line('edit_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }

        $group = $this->ion_auth->group($id)->row();

// validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

        if (isset($_POST) && !empty($_POST)) {
            if ($this->form_validation->run() === TRUE) {
                $group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

                if ($group_update) {
                    $this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
                } else {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                }
                redirect("auth", 'refresh');
            }
        }

// set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

// pass the user to the view
        $this->data['group'] = $group;

        $readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

        $this->data['group_name'] = array(
            'name' => 'group_name',
            'id' => 'group_name',
            'class' => 'form-control',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_name', $group->name),
            $readonly => $readonly,
        );
        $this->data['group_description'] = array(
            'name' => 'group_description',
            'id' => 'group_description',
            'class' => 'form-control',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_description', $group->description),
        );




        $this->template->set_master_template('template.php');
        $this->template->write_view('header', 'backend/header', (isset($this->data) ? $this->data : NULL));
        $this->template->write_view('sidebar', 'backend/sidebar', (isset($this->data) ? $this->data : NULL));
        $this->template->write_view('content', 'edit_group', (isset($this->data) ? $this->data : NULL), TRUE);
        $this->template->write_view('footer', 'backend/footer', '', TRUE);
        $this->template->render();

//        $this->_render_page('auth/edit_group', $this->data);
    }

    public function _get_csrf_nonce() {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    public function _valid_csrf_nonce() {
        $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
        if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function _render_page($view, $data = null, $returnhtml = false) {//I think this makes more sense
        $this->viewdata = (empty($data)) ? $this->data : $data;

        $view_html = $this->load->view($view, $this->viewdata, $returnhtml);

        if ($returnhtml)
            return $view_html; //This will return html on 3rd argument being true
    }

    function handleUploadCommon($slug) {
        $fileTypes = array('jpeg', 'png', 'jpg'); // File extensions
        $fileParts = pathinfo($_FILES['profile_image']['name']);

        if (!in_array(strtolower($fileParts['extension']), $fileTypes)) {
            $this->session->set_flashdata('msg', 'File type not supported.');
//            $data['flashdata'] = array('type' => 'error', 'msg' => 'File type not supported.');
            return false;
        }

        $user_slug = $slug;
        $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $targetURL = '/assets/uploads/clients' . $user_slug . '/profile'; // Relative to the root
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'clients' . DIRECTORY_SEPARATOR . $user_slug . '/profile';

        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }

        $tempFile = $_FILES['profile_image']['tmp_name'];
        $fileName = $_FILES['profile_image']['name'];
        $fileName = $slug . '-profile-' . $fileName;
        $targetPath .= DIRECTORY_SEPARATOR . $fileName;
        $upload_status = move_uploaded_file($tempFile, $targetPath);
        $dataDocumentDetail['type'] = $fileParts['extension'];
        if (isset($upload_status))
            return $fileName;
    }

// if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action = 'edit' && $modal_id) {


    function handleUploadUser($slug) {
        $fileTypes = array('jpeg', 'png', 'jpg'); // File extensions
        $fileParts = pathinfo($_FILES['profile_image']['name']);

        if (!in_array(strtolower($fileParts['extension']), $fileTypes)) {
            $this->session->set_flashdata('msg', 'File type not supported.');
//            $data['flashdata'] = array('type' => 'error', 'msg' => 'File type not supported.');
            return false;
        }

        $user_slug = $slug;
        $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $targetURL = '/assets/uploads/users' . $user_slug . '/profile'; // Relative to the root
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . $user_slug . DIRECTORY_SEPARATOR . 'profile';

        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }

        $tempFile = $_FILES['profile_image']['tmp_name'];
        $fileName = $_FILES['profile_image']['name'];
        $fileName = $slug . '-profile-' . $fileName;
        $targetPath .= DIRECTORY_SEPARATOR . $fileName;
        $upload_status = move_uploaded_file($tempFile, $targetPath);
        $dataDocumentDetail['type'] = $fileParts['extension'];
        if (isset($upload_status))
            return $fileName;
    }

    function ajaxLoginSubmit() {
//validate form input
        $this->form_validation->set_rules('username', str_replace(':', '', $this->lang->line('login_username_label')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

        if ($this->form_validation->run() == true) {
// check to see if the user is logging in
// check for "remember me"
            $remember = (bool) $this->input->post('remember');
            if ($this->ion_auth->login($this->input->post('username'), $this->input->post('password'), FALSE)) {
                echo json_encode(array('status' => '1', 'msg' => 'Login success...Please wait..'));
            } else {
                echo json_encode(array('status' => '0', 'msg' => 'Invalid username or password'));
            }
        } else {
            echo json_encode(array('status' => '0', 'msg' => validation_errors()));
        }
    }

    public function ajaxUserRegisterSubmit() {

        $email_exist = $this->Common_model_marketing->getRecords('users', 'email', array('email' => $this->input->post('email')));

        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;

// validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        if ($identity_column !== 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'required');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        } else {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required');
        }
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true) {
            $email = strtolower($this->input->post('email'));
            $identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');



            /* Upload profile picture */
            if (isset($_FILES['profile_image']['name']) && $_FILES['profile_image']['name'] != '') {
                $targetDir = "uploads/";
                $fileName = $_FILES['profile_image']['name'];
                $targetFile = $targetDir . $fileName;

                $slug = $this->input->post('name');

                $fileExt = pathinfo($_FILES['profile_image']['name']);
                $dataDocumentDetail['type'] = $fileExt['extension'];


                $uploded_file_path = $this->handleUploadUser($slug);
                if ($uploded_file_path != '')
                    $data['profileimg'] = $slug . '/profile/' . $uploded_file_path;
            }
        }
        $password = $this->ion_auth->hash_password($this->input->post('password'));
        $additional_data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'company' => $this->input->post('company'),
            'phone' => $this->input->post('phone'),
            'username' => $this->input->post('email'),
            'password' => $password,
            'active' => '1',
        );
        if (count($email_exist) > 0) {
            $update = $this->Common_model_marketing->updateRow('users', $additional_data, array('email' => $this->input->post('email')));
            $this->ion_auth->login($this->input->post('email'), $this->input->post('password'), FALSE);
            echo json_encode(array('status' => '1', 'msg' => "Registration successfull. We've send you the activation link."));
        } else if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data)) {
            $this->ion_auth->login($identity, $password, FALSE);
// check to see if we are creating the user
// redirect them back to the admin page
            echo json_encode(array('status' => '1', 'msg' => "Registration successfull.We've send you the activation link."));
        } else {
            echo json_encode(array('status' => '0', 'msg' => validation_errors()));
        }
    }

    /**
     * common function to render the views
     * @author      Harshal B <harshalb@rebelute.com>
     * @param       string  $pageTitle, string $renderTo, string $viewData
     * @return      renders to view
     */
    public function _renders_view($pageTitle, $renderTo, $viewData) {

        $user_id = $this->session->userdata('user_id');
        $this->data['page_title'] = $pageTitle;

        $this->data['dataHeader'] = $this->users->get_allData($user_id);

        // get the cart item from session
        $this->data['cart_items'] = $this->flexi_cart->cart_items();

        // set the tax total variable value in session
        $_SESSION['flexi_cart']['summary']['tax_total'] = ceil(($_SESSION['flexi_cart']['summary']['item_summary_total'] * 7) / 100);

        if (isset($this->session->userdata('flexi_cart')['summary']))
            $this->data['cart_summary'] = $this->session->userdata('flexi_cart')['summary'];
        foreach ($this->data['cart_items'] as $key => $cData) {
            $this->data['cart_items'][$key]['stock_quantity'] = $this->product->getStockDetail($cData['id']);
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

        // get the dynamic content of footer
        $this->data['footer_content'] = $this->footer_cms->as_array()->get_all();

        // get all the social links
        $this->data['social_links'] = $this->social_links->as_array()->get_all();

        // set master template
        $this->template->set_master_template('front_template.php', $this->data);
        $this->template->write_view('top_header', 'front_snippets/top_header', $this->data);
        $this->template->write_view('main_menu', 'front_snippets/main_menu', $this->data);
        $this->template->write_view('content', $renderTo, $viewData);
        $this->template->write_view('footer', 'front_snippets/footer', $this->data);
        $this->template->render();
    }
}
