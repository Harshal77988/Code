<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// include APPPATH.'admin\controllers\admin.php';
class Manage_Cms extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->language(array('product_lang'));


        $this->perPage = 10;

        /* Load Backend model */
        $this->load->model(array('users', 'group_model', 'pattribute', 'pattribute_sub', 'product_sub_category_map'));
        $this->load->model(array('product_category', 'product_sub_category', 'orders_summary', 'common_model', 'newsletter', 'footer_cms', 'section_model', 'social_links', 'brands'));

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
        // id - 1 is for about page, id-2 is for contact, id-3 is for services ,id-4 is for terms 
// echo $this->uri->segment(3);die;

        if (!empty($this->uri->segment(3))) {
            $id = $this->uri->segment(3);
            if ($id == 1) {
                $pageTitle = 'Buy Sell Rent | About Us';
                $renderTo = 'cms/about_cms';
                $this->data['post_info'] = ($this->common_model->getRecords('tbl_mst_cms', '*', array('cms_id' => '1'), $order_by = '', $limit = '', $debug = 0));
            } else if ($id == 2) {
                $pageTitle = 'Buy Sell Rent | Contact Us ';
                $renderTo = 'cms/contact_us_cms';
                $this->data['post_info'] = ($this->common_model->getRecords('tbl_mst_cms', '*', array('cms_id' => '2'), $order_by = '', $limit = '', $debug = 0));
            } else if ($id == 3) {
                $pageTitle = 'Buy Sell Rent | Policies';
                $renderTo = 'cms/policy_cms';
                $this->data['post_info'] = ($this->common_model->getRecords('tbl_mst_cms', '*', array('cms_id' => '3'), $order_by = '', $limit = '', $debug = 0));
            } else if ($id == 4) {
                $pageTitle = 'Buy Sell Rent | Terms And Conditions';
                $renderTo = 'cms/terms_cms';
                $this->data['post_info'] = ($this->common_model->getRecords('tbl_mst_cms', '*', array('cms_id' => '4'), $order_by = '', $limit = '', $debug = 0));
            }
        }
        // set the parameters for rendering view
        // call the render view function here
        $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    public function about() {
//        print_r('about');die;
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $heading[0] = $this->input->post('heading1');
        $heading[1] = $this->input->post('heading3');
        $heading[2] = $this->input->post('name1');
        $heading[3] = $this->input->post('name2');
        $heading[4] = $this->input->post('name3');

        $content[0] = $this->input->post('column_content_1');
        $content[1] = $this->input->post('column_content_3');
        $content[2] = $this->input->post('designation1');
        $content[3] = $this->input->post('designation2');
        $content[4] = $this->input->post('designation3');


        $heading = implode('-heading-', $heading);
        $content = implode('-content-', $content);

        $img_path = array();
        $target = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'cms/';
        $user_id = $this->session->userdata('user_id');
        $this->data['post_info'] = ($this->common_model->getRecords('tbl_mst_cms', '*', array('cms_id' => '1'), $order_by = '', $limit = '', $debug = 0));

        if (!empty($this->input->post())) {
            
            foreach ($_FILES['section_image']['name'] as $key => $file) {
             //   print_r($_FILES['section_image']['name'][$key]);die;
                $config['file_name'] = $_FILES['section_image']['name'][$key];
                $config['upload_path'] = './backend/assets/img/cms';
                $config['allowed_types'] = 'jpg|jpeg|gif|png';
                $config['max_size'] = '9000000';
                $config['width']     = 217;
                $config['height']   = 217;   
               

                if ($_FILES['section_image']['name'][$key] != '') {
                    $_FILES['section_image[]']['name'] = $_FILES['section_image']['name'][$key];
                    $_FILES['section_image[]']['type'] = $_FILES['section_image']['type'][$key];
                    $_FILES['section_image[]']['tmp_name'] = $_FILES['section_image']['tmp_name'][$key];
                    $_FILES['section_image[]']['error'] = $_FILES['section_image']['error'][$key];
                    $_FILES['section_image[]']['size'] = $_FILES['section_image']['size'][$key];
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('section_image[]')) {

                        //print_r($_FILES['img_file']['name']);
                        $data1['upload_data'] = $this->upload->data();

                        $upload_result = $this->upload->data();


                        $this->load->library('image_lib');
                        if (!empty($upload_result['file_name'])) {
//                            array_push($img_path, $upload_result['file_name']);
                            $img_path[] = $upload_result['file_name'];
                        }
                        else {
                            $img_path[] = $_POST['replace_img'][$key];
                        }
                    }
                    else {
                        $error = array('error' => $this->upload->display_errors());
                    }
                } else {
                    $img_path[$key] = $_POST['replace_img'][$key];                    
                }
            }

            $img = json_encode(array_values($img_path));

            $values = array(
                'heading' => $heading,
                'content' => $content,
                'cms_img' => $img,
                'on_date' => date('y-m-d H:i:s')
            );
//            print_r($values);DIE;
            if (!empty($values)) {
                $res = $this->common_model->updateRow('tbl_mst_cms', $values, array('cms_id' => '1'));

                if ($res) {
                    $this->session->set_flashdata('message', 'About section updated successfully');
                    redirect(base_url() . 'admin/manage_cms');
                }
            }
        }
    }

    public function policy() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $heading[0] = $this->input->post('heading1');
        $heading[1] = $this->input->post('heading2');
        $content[0] = $this->input->post('column_content_1');
        $content[1] = $this->input->post('column_content_2');


        $heading = implode('-heading-', $heading);
        $content = implode('-content-', $content);

        $user_id = $this->session->userdata('user_id');
        $this->data['post_info'] = ($this->common_model->getRecords('tbl_mst_cms', '*', array('cms_id' => '3'), $order_by = '', $limit = '', $debug = 0));

        if (!empty($this->input->post())) {


            $values = array(
                'heading' => $heading,
                'content' => $content,
                'on_date' => date('y-m-d H:i:s')
            );
//            print_r($values);
//            die;
            if (!empty($values)) {
                $res = $this->common_model->updateRow('tbl_mst_cms', $values, array('cms_id' => '3'));

                if ($res) {
                    $this->session->set_flashdata('message', 'Policy section updated successfully');
                    redirect(base_url() . 'admin/manage_cms');
                }
            }
        }


        // $pageTitle = 'Buy Sell Rent | Edit Policy';
        // $renderTo = 'cms/policy_cms';
        // call the render view function here
        // $this->_renders_view($pageTitle, $renderTo, $this->data);
    }

    public function contact() {
//        print_r($_POST);die;
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->is_admin()) {
            redirect('/home', 'refresh');
        }

        $email[0] = $this->input->post('mail1');
        $email[1] = $this->input->post('mail2');
        $phone[0] = $this->input->post('phone');
        $phone[1] = $this->input->post('fax');
        $time_hours[0] = $this->input->post('text1');
        $time_hours[1] = $this->input->post('startdate1');
        $time_hours[2] = $this->input->post('text2');
        $time_hours[3] = $this->input->post('startdate2');
        $time_hours[4] = $this->input->post('text3');
        $time_hours[5] = $this->input->post('startdate3');
        $maps[0] = $this->input->post('lati');
        $maps[1] = $this->input->post('longi');

        $map = implode('-map-', $maps);

        $mail = implode('-email-', $email);
        $phone = implode('-phone-', $phone);
        $set_time = implode('-settime-', $time_hours);
        $user_id = $this->session->userdata('user_id');
        $this->data['post_info'] = ($this->common_model->getRecords('tbl_mst_cms', '*', array('cms_id' => '2'), $order_by = '', $limit = '', $debug = 0));

        if (!empty($this->input->post())) {


            $values = array(
                'heading' => $this->input->post('heading'),
                'content' => $this->input->post('content'),
                'address' => $this->input->post('addr'),
                'map' => $map,
                'email' => $mail,
                'phone' => $phone,
                'time_hours' => $set_time,
                'on_date' => date('y-m-d H:i:s')
            );
//            print_r($values);
//            die;
            if (!empty($values)) {
                $res = $this->common_model->updateRow('tbl_mst_cms', $values, array('cms_id' => '2'));

                if ($res) {
                    $this->session->set_flashdata('message', 'Contact section updated successfully');
                    redirect(base_url() . 'admin/manage_cms');
                }
            }
        }
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

    /**
     * Image resize
     * @param int $width
     * @param int $height
     */
    public function resize($path, $fileobj, $width, $height) {
        /* Get original image x y */
        list($w, $h) = getimagesize($fileobj['tmp_name']);
        /* calculate new image size with ratio */
        $ratio = max($width / $w, $height / $h);
        $h = ceil($height / $ratio);
        $x = ($w - $width / $ratio) / 2;
        $w = ceil($width / $ratio);
        /* new file name */
        $new_img_name = $width . 'x' . $height . '_' . $fileobj['name'];
        $path = $path . $new_img_name;
        /* read binary data from image file */
        $imgString = file_get_contents($fileobj['tmp_name']);
        /* create image from string */
        $image = imagecreatefromstring($imgString);
        $tmp = imagecreatetruecolor($width, $height);
        imagealphablending($tmp, false);
        imagesavealpha($tmp, true);
        imagecopyresampled($tmp, $image, 0, 0, $x, 0, $width, $height, $w, $h);

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

}
