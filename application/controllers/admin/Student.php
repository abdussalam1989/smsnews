<?php
class Student extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->library('auth');
        $this->load->library('csvimport');
        $this->load->model('Data_model');
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
        //$this->output->enable_profiler(FALSE);
        $admin        = $this->session->userdata();
        $logint_type  = $admin['logint_type'];
        $user_id      = $admin['user_id'];
        $field        = 'user_id';
        $data['data'] = '';
        $class_name   = $this->input->post('get_class', TRUE);
        
        if (!empty($class_name)) {
            $data['csv_data'] = $class_name;
            $data['data']     = $this->Data_model->get_student_list_by_user($user_id, $class_name);
            
        }
        $data['class_name'] = get_list_by_field('user_id', $user_id, CLASSES);
        
        $data['page_title'] = 'Manage Student';
        $this->load->view($this->config->item('admin_folder') . '/student_list', $data);
    }
    
    function mode($id = '')
    {
        $data['page_title'] = 'Add Student';
        $data['check']      = 'add';
        $admin              = $this->session->userdata();
        $user_id            = $admin['user_id'];
        $user               = $admin['logint_type'];
        $data['class_name'] = get_list_by_field('user_id', $user_id, CLASSES);
        $data['group_name'] = get_list_by_field('user_id', $user_id, GROUP);
        
        $data['status']       = array(
            'Active',
            'Inactive'
        );
        $data['mode']         = base_url() . $this->config->item('admin_folder') . '/student/mode/';
        $data['val_error']    = '';
        $data['custom_error'] = null;
        if ($id != '') {
            $data['check']        = 'edit';
            $data['mode']         = base_url() . $this->config->item('admin_folder') . '/student/mode/' . $id;
            $data['val_error']    = "";
            $data['page_title']   = 'Edit Student';
            $data['custom_error'] = null;
            $data['data']         = get_list_by_id($id, STUDENT);
        }
        if (isset($_REQUEST['submit'])) {
            $save['class_id']     = $this->input->post('class_name', TRUE);
            $class_name           = get_list_by_id($save['class_id'], CLASSES);
            $save['class_name']   = $class_name['name'];
            $save['name']         = $this->input->post('name', TRUE);
            $save['mobile_no']    = $this->input->post('mobile_no', TRUE);
            $save['admission_no'] = $this->input->post('admission_no', TRUE);
            
            
            //check empty records 
            $check_required_val = check_required($save);
            
            if ($check_required_val) {
                $data['val_error'] = '(*) field must be required !!';
            }
            
            $save['email']         = $this->input->post('email', TRUE);
            $save['father_name']   = $this->input->post('father_name', TRUE);
            $save['mother_name']   = $this->input->post('mother_name', TRUE);
            $save['alternate_no']  = $this->input->post('alternate_no', TRUE);
            $save['date_of_birth'] = $this->input->post('date_of_birth', TRUE);
            $save['status']        = $this->input->post('status', TRUE);
            $save['roll_no']       = $this->input->post('roll_no', TRUE);
            
            if (!empty($save['email'])) {
                //check email id valid or not
                $check_email_val = check_email_validation($save['email']);
                
                if ($check_email_val == TRUE) {
                    $data['val_error'] = 'Email id is not valid';
                }
            }
            
            if (!empty($save['alternate_no'])) {
                //check number
                $check_alt_contact = allow_only_number($save['alternate_no']);
                
                if ($check_alt_contact) {
                    $data['val_error'] = 'Only number allow on Alternate number';
                }
            }
            
            if (!empty($save['mobile_no'])) {
                //check number
                $check_contact = allow_only_number($save['mobile_no']);
                
                if ($check_contact == TRUE) {
                    $data['val_error'] = 'Only number allow on Mobile number';
                }
                
            }
            
            if (!empty($save['roll_no'])) {
                //check Roll number
                $check_rollno = allow_only_number($save['roll_no']);
                if ($check_rollno) {
                    $data['val_error'] = 'Only number allow on Roll number';
                }
            }
            
            if (empty($save['status'])) {
                $save['status'] = 'Active';
            }
            
            $save['group_id'] = $this->input->post('group_id', TRUE);
            $data['data']     = $save;
            
            $save['user_id'] = $user_id;
            
            if ($id == '') {
                
                
                $str             = $save['name'];
                $save['adddate'] = date('d-m-y');
                $save['slug']    = createSlugUrl(STUDENT, $str);
                if ($data['val_error'] == '') {
                    $add = insert_record(STUDENT, $save);
                    
                    if ($add) {
                        if (!empty($save['group_id'])) {
                            $sms['group_id']   = $save['group_id'];
                            $sms['user_id']    = $user_id;
                            $sms['member_id']  = $add;
                            $sms['group_type'] = 'student';
                            insert_record(SMS_GROUP_INFO, $sms);
                        }
                        $this->session->set_flashdata('success', 'You have successfully Added student !!');
                        redirect($this->config->item('admin_folder') . '/student');
                    } else {
                        $this->session->set_flashdata('error', 'Error while adding student !!');
                        redirect($this->config->item('admin_folder') . '/student');
                    }
                }
            } else {
                $id               = $this->input->post('data_id', TRUE);
                $save['editdate'] = date('d-m-y');
                if ($data['val_error'] == '') {
                    $upd = update_record($save, $id, STUDENT);
                    if ($upd) {
                        $group_id = $save['group_id'];
                        $this->Data_model->update_sms_group_info($group_id, $id, $user_id);
                        $this->session->set_flashdata('success', 'You have successfully updated student !!');
                        redirect($this->config->item('admin_folder') . '/student');
                    } else {
                        $this->session->set_flashdata('error', 'Error while updating student!!');
                        redirect($this->config->item('admin_folder') . '/student/mode');
                    }
                }
            }
        }
        $this->load->view($this->config->item('admin_folder') . '/student_form', $data);
    }
    
    function ExportCSV()
    {
        //ini_set('max_execution_time', 90000);
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        $admin   = $this->session->userdata();
        $user_id = $admin['user_id'];
        $class   = $this->input->post('csv_class', TRUE);
        $date    = date("Y-m-dh:i:s");
        
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline   = "\r\n";
        
        if (isset($class)) {
            if (!empty($class)) {
                $class_name = get_list_by_id($class, CLASSES);
                $class_nm   = $class_name["name"];
                $filename   = $class_nm . "-" . $date . '.csv';
                $query      = "SELECT name,admission_no,roll_no,father_name,mobile_no,alternate_no,class_name FROM student where user_id='" . $user_id . "' AND class_id='" . $class . "'";
            } else {
                $filename = 'All_student_' . $date . '.csv';
                $query    = "SELECT name,admission_no,roll_no,father_name,mobile_no,alternate_no,class_name FROM student where user_id=" . $user_id;
            }
        }
        // echo $query; exit;
        $result = $this->db->query($query);
        if (!$result) {
            $this->session->set_flashdata('error', 'No data in this class');
            redirect($this->config->item('admin_folder') . '/student/mode');
        }
        // $result= get_list(STUDENT);
        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        // print_r($data); exit;
        force_download($filename, $data);
    }
    
    
    
    //delete single record
    function delete($id)
    {
        $student_rec = get_list_by_id($id, STUDENT);
        $del_rec     = $this->Data_model->delete_sms_group_record($student_rec['id'], $student_rec['user_id'], $student_rec['group_id']);
        $del         = delete_single_rec($id, STUDENT);
        if ($del) {
            $this->session->set_flashdata('success', 'You have successfully deleted student !!');
            redirect($this->config->item('admin_folder') . '/student');
        } else {
            $this->session->set_flashdata('error', 'Error while deleting student !!');
            redirect($this->config->item('admin_folder') . '/student');
        }
    }
    
    function import()
    {
        //ini_set('max_execution_time', 90000);
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        $data['page_title'] = 'Student Import';
        
        if (isset($_REQUEST['submit'])) {
            // $data['addressbook'] = $this->csv_model->get_addressbook();
            $get_list                = get_list(STUDENT);
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
                redirect($this->config->item('admin_folder') . '/student/import');
            } else {
                $file_data = $this->upload->data();
                $file_path = USER_IMAGES . $file_data['file_name'];
                
                if ($this->csvimport->get_array($file_path)) {
                    $csv_array = $this->csvimport->get_array($file_path);
                    //echo "<pre>";
                    //print_r($csv_array); exit;
                    foreach ($csv_array as $row) {
                        
                        $check_class_data = $this->Data_model->class_exites($user_id, $row['class_name']);
                        if ($check_class_data) {
                            $class_id = $check_class_data['id'];
                        } else {
                            $class_id = 0;
                        }
                        
                        $insert_data = array(
                            'name' => $row['name'],
                            'admission_no' => $row['admission_no'],
                            'roll_no' => $row['roll_no'],
                            'father_name' => $row['father_name'],
                            'mobile_no' => $row['mobile_no'],
                            'alternate_no' => $row['alternate_no'],
                            'class_name' => $row['class_name'],
                            'class_id' => $class_id,
                            'user_id' => $user_id,
                            'status' => 'Active'
                        );
                        
                        $check_rec = $this->Data_model->check_dul_data($user_id, $insert_data['admission_no']);
                        if ($check_rec == TRUE) {
                            $upd = $this->Data_model->update_studeny_csv($user_id, $insert_data);
                        } else {
                            $add = insert_record(STUDENT, $insert_data);
                        }
                    }
                    if ($add) {
                        unlink(USER_IMAGES . $file_name);
                        $this->session->set_flashdata('success', 'Csv Data Imported Succesfully');
                        redirect($this->config->item('admin_folder') . '/student/import');
                    } elseif ($upd) {
                        unlink(USER_IMAGES . $file_name);
                        $this->session->set_flashdata('success', 'Csv Data Update Succesfully');
                        redirect($this->config->item('admin_folder') . '/student/import');
                    } else {
                        $this->session->set_flashdata('error', ' error while Csv Data Imported Succesfully');
                        redirect($this->config->item('admin_folder') . '/student/import');
                    }
                }
            }
        }
        $this->load->view($this->config->item('admin_folder') . '/student_import', $data);
    }
    
    function mul_action()
    {
        $action_val = $_REQUEST['mul_val'];
        $arr_ids    = $_REQUEST['mul_id'];
        $path       = '/student';
        $table      = STUDENT;
        multiple_action($arr_ids, $action_val, $table, $path);
    }
    
    function change_status()
    {
        $id     = $_REQUEST['id'];
        $status = $_REQUEST['status'];
        $table  = STUDENT;
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
    
    function ajax_rollno($class_id)
    {
        $roll      = $this->Data_model->get_roll_list_of_class($class_id);
        //print_r($roll); exit;    
        $arr       = end($roll);
        $last_roll = $arr['roll_no'];
        if (empty($last_roll)) {
            $roll_no = 1;
        } else {
            $roll_no = $last_roll + 1;
        }
        $roll_val = '';
        $roll_val = '<input type="text" class="form-control" name="roll_no" id="roll_no" placeholder="Admission number" value="' . $roll_no . '">';
        echo $roll_val;
    }
}
?>