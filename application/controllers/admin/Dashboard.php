<?php

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Dashboard_model');
        $this->load->library('auth');
        $redirect = $this->auth->is_logged_in();
        if ($redirect == false) {
            $this->session->set_userdata("redirect", current_url());
            redirect($this->config->item('admin_folder') . '/login');
        }
        //$this->load->model($this->config->item('admin_folder').'/Dashboard_model');
    }

    function index() {
        $data['red_sms'] = '';
        $data['user_sms'] = '';
        $admin = $this->session->userdata();

        if ($admin['user_id'] != "") {
            $user_id = $admin['user_id'];
        } else {
            $user_id = $admin['admin_id'];
        }

        $data['active_user'] = $this->Dashboard_model->get_active_student($user_id);
        $data['inactive_user'] = $this->Dashboard_model->get_inactive_student($user_id);
        $data['all_sms'] = $this->Dashboard_model->get_all_sms($user_id);


        $date = date('Y-m-d');
        $send_sms = $this->Dashboard_model->get_today_sms($user_id, $date);

        $data['today_sms'] = $send_sms;

        $overall_sms = $this->Dashboard_model->get_overall_sms($user_id);

        $data['overall_sms'] = $overall_sms;
        $absent = $this->Dashboard_model->get_today_absent_list($user_id, $date);
        $data['today_absent'] = count($absent);

        $user_sms = get_list_by_id($user_id, USERS);

        if ($user_sms['status_two'] == 'Active') {
            $total_msg = $user_sms['total_sms_two'];
            $data['api_name'] = 'API 2';
        } if ($user_sms['status_one'] == 'Active') {
            $data['api_name'] = 'API 1';
            $total_msg = $user_sms['total_sms_one'];
        }
        if (isset($total_msg)) {
            $data['user_sms'] = $total_msg;
        }



        $red_sms = get_list_by_id($user_id, USERS);


        if ($red_sms['status_two'] == 'Active') {
            $total_msg = $red_sms['red_sms_two'];
            $data['api_name'] = 'API 2';
        } if ($red_sms['status_one'] == 'Active') {
            $data['api_name'] = 'API 1';
            $total_msg = $red_sms['red_sms_one'];
        }
        if (isset($total_msg)) {
            $data['red_sms'] = $total_msg;
        }

        $total_s_sms = "";
        $data['total_s_sms'] = $data['red_sms'] + $data['overall_sms'];

        $red_s_sms = "";
        $data['red_s_sms'] = $data['user_sms'] - $data['total_s_sms'];


        $data['user_data'] = get_list_by_id($user_id, USERS);
        $data['page_title'] = 'Dashboard';
        $this->load->view($this->config->item('admin_folder') . '/dashboard', $data);
    }

}