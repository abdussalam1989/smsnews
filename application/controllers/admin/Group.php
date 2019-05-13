<?php

class Group extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model('Data_model');
        $redirect = $this->auth->is_logged_in();
        if ($redirect == false) {
            $this->session->set_userdata("redirect", current_url());
            redirect($this->config->item('admin_folder') . '/login');
        }
    }

    function index() {
        $admin = $this->session->userdata();
        $logint_type = $admin['logint_type'];
        $user_id = $admin['user_id'];
        $field = 'user_id';
        $data['data'] = get_list_by_idd($user_id, $field, GROUP);

        /* else {
          $data['data']=get_list(GROUP);
          } */
        $data['page_title'] = 'Manage Group';
        $this->load->view($this->config->item('admin_folder') . '/group/list', $data);
    }

    function mode($id = '') {
        $data['page_title'] = 'Add Group';
        $data['check'] = 'add';
        $data['status'] = array(
            'Active',
            'Inactive'
        );
        $admin = $this->session->userdata();
        $user_id = $admin['user_id'];


        $data['mode'] = base_url() . $this->config->item('admin_folder') . '/group/mode/';
        $data['val_error'] = '';
        $data['custom_error'] = null;
        if ($id != '') {
            $data['check'] = 'edit';
            $data['mode'] = base_url() . $this->config->item('admin_folder') . '/group/mode/' . $id;
            $data['val_error'] = "";


            $data['page_title'] = 'Edit Group';
            $data['custom_error'] = null;
            $data['data'] = get_list_by_id($id, GROUP);
        }
        if (isset($_REQUEST['submit'])) {
            $save['name'] = $this->input->post('name', TRUE);

            $save['status'] = $this->input->post('status', TRUE);
            $save['mobile_number'] = trim($this->input->post('mobile_number', TRUE));

            $check_required_val = check_required($save);


            if ($check_required_val) {
                $data['val_error'] = '(*) field must be required !! ';
            }

            $save['user_id'] = $user_id;
            if ($id == '') {
                $str = $save['name'];
                $save['slug'] = createSlugUrl(GROUP, $str);
                if ($data['val_error'] == '') {
                    $add = insert_record(GROUP, $save);
                    if ($add) {
                        $this->session->set_flashdata('success', 'You have successfully Added group !!');
                        redirect($this->config->item('admin_folder') . '/group');
                    } else {
                        $this->session->set_flashdata('error', 'Error while adding group !!');
                        redirect($this->config->item('admin_folder') . '/group');
                    }
                }
            } else {
                $id = $this->input->post('data_id', TRUE);

                if ($data['val_error'] == '') {
                    $upd = update_record($save, $id, GROUP);
                    if ($upd) {
                        $this->session->set_flashdata('success', 'You have successfully updated group !!');
                        redirect($this->config->item('admin_folder') . '/group');
                    } else {
                        $this->session->set_flashdata('error', 'Error while updating group!!');
                        redirect($this->config->item('admin_folder') . '/group/mode');
                    }
                }
            }
        }
        $this->load->view($this->config->item('admin_folder') . '/group/form', $data);
    }

    function mul_action() {
        $action_val = $_REQUEST['mul_val'];
        $arr_ids = $_REQUEST['mul_id'];
        $path = '/group';
        $table = GROUP;
        multiple_action($arr_ids, $action_val, $table, $path);
    }

    function change_status() {
        $id = $_REQUEST['id'];
        $status = $_REQUEST['status'];
        $table = GROUP;
        if ($status == 'true') {
            $status = 'Active';
            $result = change_status($id, $status, $table);
            echo $result;
        } else {
            $status = 'Inactive';
            $result = change_status($id, $status, $table);
            echo $result;
        }
    }
	function remove_group() {
        $id = $_REQUEST['id'];       
        $table = GROUP;
       
           $result = delete_single_rec($id,  $table);
            echo $result;
        
    }

}

?>