<?php

class Staff extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->library('auth');
        $this->load->library('csvimport');
        //ini_set('max_execution_time', 90000);
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        $redirect = $this->auth->is_logged_in();
        if ($redirect == false) {
            $this->session->set_userdata("redirect", current_url());
            redirect($this->config->item('admin_folder') . '/login');
        }
    }
    
    function index()
    {
        $admin        = $this->session->userdata();
        $logint_type  = $admin['logint_type'];
        $user_id      = $admin['user_id'];
        $field        = 'user_id';
        $data['data'] = get_list_by_idd($user_id, $field, STAFF);
        
        $data['page_title'] = 'Manage Staff';
        $this->load->view($this->config->item('admin_folder') . '/staff_list', $data);
    }
    
    function mode($id = '')
    {
        $data['page_title']   = 'Add Staff';
        $data['check']        = 'add';
        $data['status']       = array(
            'Active',
            'Inactive'
        );
        $data['mode']         = base_url() . $this->config->item('admin_folder') . '/staff/mode/';
        $data['val_error']    = '';
        $data['custom_error'] = null;
        $admin                = $this->session->userdata();
        $user_id              = $admin['user_id'];
        $user                 = $admin['logint_type'];
        if ($id != '') {
            $data['check']        = 'edit';
            $data['mode']         = base_url() . $this->config->item('admin_folder') . '/staff/mode/' . $id;
            $data['val_error']    = "";
            $data['page_title']   = 'Edit Staff';
            $data['custom_error'] = null;
            $data['data']         = get_list_by_id($id, STAFF);
        }
        if (isset($_REQUEST['submit'])) {
            $save['name']      = $this->input->post('name', TRUE);
            $save['employ_id'] = $this->input->post('employ_id', TRUE);
            $save['email']     = $this->input->post('email', TRUE);
            $save['mobile_no'] = $this->input->post('mobile_no', TRUE);
            $save['status']    = $this->input->post('status', TRUE);
            
            //check email id valid or not
            $check_email_val = check_email_validation($save['email']);
            
            //check number
            $check_contact = allow_only_number($save['mobile_no']);
            
            //check empty records 
            $check_required_val = check_required($save);
            
            if ($check_required_val) {
                $data['val_error'] = '(*) field must be required !! ';
            }
            
            if ($check_email_val == TRUE) {
                $data['val_error'] = 'Email id is not valid';
            }
            
            if ($check_contact == TRUE) {
                $data['val_error'] = 'Only number allow on Mobile number';
            }
            
            if ($id == '') {
                //check already exits value
                $check_employ_id = check_data_exist('employ_id', $save['employ_id'], STAFF);
                
                //check email id already exits
                $check_email = check_email_exist($save['email'], STAFF);
                
                if ($check_email) {
                    $data['val_error'] = 'email id already exits';
                }
                
                if ($check_employ_id) {
                    $data['val_error'] = 'employ id already exits';
                }
                
                $save['user_id'] = $user_id;
                $save['adddate'] = date("Y-m-d h:m:s");
                $str             = $save['name'];
                $save['slug']    = createSlugUrl(STUDENT, $str);
                if ($data['val_error'] == '') {
                    $add = insert_record(STAFF, $save);
                    if ($add) {
                        $this->session->set_flashdata('success', 'You have successfully Added staff !!');
                        redirect($this->config->item('admin_folder') . '/staff');
                    } else {
                        $this->session->set_flashdata('error', 'Error while adding staff !!');
                        redirect($this->config->item('admin_folder') . '/staff');
                    }
                }
            } else {
                $id               = $this->input->post('data_id', TRUE);
                $save['editdate'] = date("Y-m-d h:m:s");
                /* $save['editdate']=date('d-m-y');
                $save['status']='Active'; */
                $str              = $save['name'];
                $save['slug']     = createSlugUrl(STUDENT, $str);
                if ($data['val_error'] == '') {
                    $upd = update_record($save, $id, STAFF);
                    if ($upd) {
                        $this->session->set_flashdata('success', 'You have successfully updated staff !!');
                        redirect($this->config->item('admin_folder') . '/staff');
                    } else {
                        $this->session->set_flashdata('error', 'Error while updating staff!!');
                        redirect($this->config->item('admin_folder') . '/staff/mode');
                    }
                }
            }
        }
        $this->load->view($this->config->item('admin_folder') . '/staff_form', $data);
    }
    
    //delete single record
    function delete($id)
    {
        $del = delete_single_rec($id, STAFF);
        if ($del) {
            $this->session->set_flashdata('success', 'You have successfully deleted staff !!');
            redirect($this->config->item('admin_folder') . '/staff');
        } else {
            $this->session->set_flashdata('error', 'Error while deleting staff !!');
            redirect($this->config->item('admin_folder') . '/staff');
        }
    }
    
    function import()
    {
        $data['page_title'] = 'Staff Import';
        //ini_set('max_execution_time', 90000);
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        if (isset($_REQUEST['submit'])) {
            // $data['addressbook'] = $this->csv_model->get_addressbook();
            $admin                   = $this->session->userdata();
            $user_id                 = $admin['user_id'];
            $data['error']           = '';
            $file_name               = $_FILES['userfile']['name'];
            $config['file_name']     = $file_name;
            $config['upload_path']   = USER_IMAGES;
            $config['allowed_types'] = 'csv';
            $config['max_size']      = '1000';
            
            //print_r($config); exit;
            $this->load->library('upload', $config);
            
            if (!$this->upload->do_upload()) {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect($this->config->item('admin_folder') . '/staff/import');
            } else {
                $file_data = $this->upload->data();
                $file_path = USER_IMAGES . $file_data['file_name'];
                
                if ($this->csvimport->get_array($file_path)) {
                    $csv_array = $this->csvimport->get_array($file_path);
                    //echo "<pre>";
                    //print_r($csv_array); exit;
                    foreach ($csv_array as $row) {
                        $insert_data = array(
                            'name' => $row['name'],
                            'employ_id' => $row['emp_id'],
                            'mobile_no' => $row['mobile_no'],
                            'user_id' => $user_id,
                            'status' => 'Active'
                        );
                        $add         = insert_record(STAFF, $insert_data);
                    }
                    //print_r($insert_data); exit;
                    //$data['get_list']=$insert_data;
                    if ($add) {
                        unlink(USER_IMAGES . $file_name);
                        $this->session->set_flashdata('success', 'Csv Data Imported Succesfully');
                        redirect($this->config->item('admin_folder') . '/staff/import');
                    } else {
                        $this->session->set_flashdata('error', ' error while Csv Data Imported Succesfully');
                        redirect($this->config->item('admin_folder') . '/staff/import');
                    }
                }
            }
        }
        $this->load->view($this->config->item('admin_folder') . '/staff_import', $data);
    }
    
    function mul_action()
    {
        $action_val = $_REQUEST['mul_val'];
        $arr_ids    = $_REQUEST['mul_id'];
        $path       = '/staff';
        $table      = STAFF;
        multiple_action($arr_ids, $action_val, $table, $path);
    }
    
    function change_status()
    {
        $id     = $_REQUEST['id'];
        $status = $_REQUEST['status'];
        $table  = STAFF;
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
    
}

?>