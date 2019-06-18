<?php

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->library('auth');
        $this->load->library('user_agent');
    }

    function index() {
        $redirect = $this->auth->is_logged_in();
        $data['site_data'] = get_list(SITE);
        $data['page_title'] = 'Login';
        if ($redirect) {
            redirect($this->config->item('admin_folder') . '/dashboard');
        }
        $this->load->helper('form');
        if (isset($_REQUEST['submit'])) {
            //  $admin=$this->input->post('admin',TRUE);
            $admin_name = $this->input->post('username', TRUE);
            $admin_password = $this->input->post('password', TRUE);
            $password = md5($admin_password);
            $login = $this->Login_model->login_admin($admin_name, $password);            
            
            if($login) {
                //$r_url = $this->session->userdata("redirect");
				$r_url = $this->config->item('admin_folder').'/dashboard';
                if ($r_url) {
                    $redirect = $r_url;
                } else {
                    $admin = $this->session->userdata();
                    $logint_type = $admin['logint_type'];

                    if ($logint_type == 'admin') {
                        $redirect = $this->config->item('admin_folder') . '/user';
                    } else {
                        $redirect = $this->config->item('admin_folder') . '/dashboard';
                    }
                }
                redirect($redirect);
            } else {
                $this->session->set_flashdata('error', 'Please enter correct Username/Password');
                redirect($this->config->item('admin_folder') . '/login');
            }

        }
        $data['flag_login_manag'] = '1';
        $this->load->view($this->config->item('admin_folder') . '/login', $data);
    }

    function logout() {
        $this->auth->logout();
        //when someone logs out, automatically redirect them to the login page.
        $this->session->set_flashdata('success', 'You have successfully logout');
        //$this->session->set_flashdata('error', 'You have successfully logout.');
        redirect($this->config->item('admin_folder') . '/login');
    }

    function get_list_by_id($id) {
        $select = array('id', 'user_id', 'count_msg', 'adddate', 'addtime', 'msg_status', 'is_send', 'is_send_datetime', 'api_message', 'api_name');
        $data['userlist'] = $this->Login_model->get_list($select, $id);
        $this->load->view($this->config->item('admin_folder') . '/temp', $data);
    }

}
