<?php

class Attendance extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->model('Data_model');
        //ini_set('max_execution_time', 10000);
        ini_set('max_execution_time', 0);

        $redirect = $this->auth->is_logged_in();
        if ($redirect == false) {
            $this->session->set_userdata("redirect", current_url());
            redirect($this->config->item('admin_folder') . '/login');
        }
        // $this->load->dbforge();
//        if ($this->dbforge->create_database('2017_sixface'))
//{
//        echo 'Database created!';
//}
    }

    function index() {
        $admin = $this->session->userdata();
        $logint_type = $admin['logint_type'];
        $user_id = $admin['user_id'];
        $field = 'user_id';
        $data['data'] = get_list_by_idd($user_id, $field, ATTENDANCE_SMS_TEMPLATE);

        $data['page_title'] = 'Manage SMS Att';
        $this->load->view($this->config->item('admin_folder') . '/attendance_list', $data);
    }

    function take() {

        $data['page_title'] = 'Take Attendance';
        $admin = $this->session->userdata();
        $user_id = $admin['user_id'];
        $field = 'user_id';
        $data['get_class_list'] = get_list_by_idd($user_id, $field, CLASSES);
        $data['get_take_type'] = get_list(ATTENDANCE_TAKE_TYPE);

        //log_message('error','Function take called');
        if (isset($_REQUEST['submit'])) {
            // echo "isf condition"; exit;
            //log_message('error','if request called : submit'.$user_id);
            $get_class_nm = $this->input->post('class_name', TRUE);

            //$class_name =$this->Data_model->get_class_list($save['class_name']);
            $class_name = $this->Data_model->get_student_list_by_id($user_id, $get_class_nm);
            //echo "<pre>"; print_r($class_name); exit;
            $get_class_name = get_list_by_id($get_class_nm, CLASSES);
            $class_nm = $get_class_name['name'];
            $abc = count($class_name);
            $date = date('Y-m-d');
            $table = ATTENDANCE_SHEET;
            $check_class_name = $this->Data_model->check_class_exits($user_id, $date, $get_class_name['name'], $table);

            //for send sms
            $take_type = $this->input->post('take_type', TRUE);
            $con_sms = $this->input->post('con_sms');
            $student_name = $this->input->post('student_name', TRUE);

            if ($check_class_name == TRUE) {
                //log_message('error','if check class name true value='.$check_class_name);
                //delete Todays attendance
                $upd = $this->Data_model->att_del_rec($user_id, $date, $class_nm);
                for ($i = 0; $i < $abc; $i++) {
                    $save2['student_id'] = $this->input->post('student_id' . $i, TRUE);
                    $save2['class_name'] = $class_nm;
                    $save2['attendance'] = $this->input->post('student_att' . $i, TRUE);
                    $save2['user_id'] = $user_id;
                    $student_id = $save2['student_id'];
                    $student_detail = $this->Data_model->get_student_listt($class_nm, $save2['student_id'], $student_id);
                    $mobile_no = $student_detail['mobile_no'];
                    $get_user_list = get_list_by_id($user_id, USERS);

                    //log_message('error','chck_class_name value true come '. $i);
                    $student_list = get_list_by_id($student_id, STUDENT);
                    if (!empty($take_type)) {
                        // log_message('error','Task time not empty than come in if cluaes');
                        if ($con_sms == 'ps') {
                            // log_message('error','if con sms PS'.$con_sms);
                            if ($take_type == 'present') {
                                //  log_message('error',' if task type present:'.$take_type);
                                if ($save2['attendance'] == "P") {
                                    // log_message('error','if save attend p:'.$save2['attendance']);
                                    $get_template = $this->Data_model->get_present_template($user_id);
                                    $message = $get_template['template_text'];
                                    $send_sms_message = set_token_in_message($message, $student_list);
                                    $send = send_sms_using_aip($user_id, $mobile_no, $send_sms_message, $student_id);
                                }
                            }
                        }
                        // log_message('error','IF ps over');
                        if ($con_sms == 'as') {
                            //   log_message('error','IF con sms as:'.$con_sms);
                            if ($take_type == 'absent') {
                                //  log_message('error','IF task type absent:'.$take_type);
                                if ($save2['attendance'] == "A") {
                                    //   log_message('error','IF save2_attend : '.$save2['attendance']);
                                    $get_template = $this->Data_model->get_absent_template($user_id);
                                    $message = $get_template['template_text'];
                                    $send_sms_message = set_token_in_message($message, $student_list);
                                    $send = send_sms_using_aip($user_id, $mobile_no, $send_sms_message, $student_id);
                                }
                            }
                        }
                        // log_message('error','IF as over');
                        if ($con_sms == 'pas') {
                            //  log_message('error','IF con sms pas:'.$con_sms);
                            if ($take_type == 'both') {
                                //  log_message('error','IF task type both:'.$task_type);
                                if ($save2['attendance'] == "A") {
                                    //  log_message('error','IF save2_attend A: '.$save2['attendance']);
                                    $get_template = $this->Data_model->get_absent_template($user_id);
                                    $message = $get_template['template_text'];
                                    $send_sms_message = set_token_in_message($message, $student_list);
                                    $send = send_sms_using_aip($user_id, $mobile_no, $send_sms_message, $student_id);
                                }
                                if ($save2['attendance'] == "P") {
                                    //   log_message('error','IF save2_attend P: '.$save2['attendance']);
                                    $get_template = $this->Data_model->get_present_template($user_id);
                                    $message = $get_template['template_text'];
                                    $send_sms_message = set_token_in_message($message, $student_list);
                                    $send = send_sms_using_aip($user_id, $mobile_no, $send_sms_message, $student_id);
                                }
                            }
                        }
                        //  log_message('error','IF pas over');
                    }
                    //log_message('error','if task type over ');
                    $save2['adddate'] = date('Y-m-d');
                    $add1 = insert_record(ATTENDANCE_SHEET, $save2);
                    // log_message('error','Insereted record is add1:'.$add1);
                }

                if ($add1) {
                    //   log_message('error','if add1:'.$add1);
                    $this->session->set_flashdata('success', 'Attendance store successfully !!');

                    //   header("Location: $this->config->item('admin_folder').'/attendance/take");
                    ?><script type="text/javascript">
                                            //location.reload();   
                                            window.location = "<?php
                    echo base_url() . $this->config->item('admin_folder') . '/attendance/take';
                    ?>";</script>
                    <?php
                    redirect('admin/attendance/take');
                    die();
                } else {
                    //  log_message('error','else add1:'.$add1);
                    $this->session->set_flashdata('error', 'Error while adding attendance !!');
                    redirect($this->config->item('admin_folder') . '/attendance/take');
                }
            } else {
                //  log_message('error','Else check class :'.$check_class_name);
                for ($i = 0; $i < $abc; $i++) {
                    //  log_message('error','else for loop :'.$i);
                    $save['student_id'] = $this->input->post('student_id' . $i, TRUE);
                    $save['class_name'] = $class_nm;
                    $save['attendance'] = $this->input->post('student_att' . $i, TRUE);
                    $save['user_id'] = $user_id;
                    $student_id = $save['student_id'];
                    $student_detail = $this->Data_model->get_student_listt($class_nm, $save['student_id']);
                    $mobile_no = $student_detail['mobile_no'];
                    $student_list = get_list_by_id($student_id, STUDENT);
                    if (!empty($take_type)) {
                        //  log_message('error','if task type:'.$task_type);

                        if ($con_sms == 'ps') {
                            //  log_message('error','if con_sms:'.$con_sms);
                            if ($take_type == 'present') {
                                //    log_message('error','if task_type:'.$task_type);
                                if ($save['attendance'] == "P") {
                                    //  log_message('error','if save attem:'.$save['attendance']);
                                    $get_template = $this->Data_model->get_present_template($user_id);
                                    $message = $get_template['template_text'];
                                    $send_sms_message = set_token_in_message($message, $student_list);
                                    $send = send_sms_using_aip($user_id, $mobile_no, $send_sms_message, $student_id);
                                }
                            }
                        }
                        // log_message('error','IF ps over');
                        if ($con_sms == 'as') {
                            //   log_message('error','if con_sms as:'.$con_sms);
                            if ($take_type == 'absent') {
                                //   log_message('error','if task_type:'.$task_type);
                                if ($save['attendance'] == "A") {
                                    //     log_message('error','if save attent A:');
                                    $get_template = $this->Data_model->get_absent_template($user_id);
                                    $message = $get_template['template_text'];
                                    $send_sms_message = set_token_in_message($message, $student_list);
                                    $send = send_sms_using_aip($user_id, $mobile_no, $send_sms_message, $student_id);
                                }
                            }
                        }
                        //   log_message('error','IF as over');
                        if ($con_sms == 'pas') {
                            //     log_message('error','if con_sms pas:'.$con_sms);
                            if ($take_type == 'both') {
                                //       log_message('error','if task_type both:'.$task_type);
                                if ($save['attendance'] == "A") {
                                    //         log_message('error','if save attent A:'.$save['attendance']);
                                    $get_template = $this->Data_model->get_absent_template($user_id);
                                    $message = $get_template['template_text'];
                                    $send_sms_message = set_token_in_message($message, $student_list);
                                    $send = send_sms_using_aip($user_id, $mobile_no, $send_sms_message, $student_id);
                                }
                                if ($save['attendance'] == "P") {
                                    log_message('error', 'if save attent P:' . $save['attendance']);
                                    $get_template = $this->Data_model->get_present_template($user_id);
                                    $message = $get_template['template_text'];
                                    $send_sms_message = set_token_in_message($message, $student_list);
                                    $send = send_sms_using_aip($user_id, $mobile_no, $send_sms_message, $student_id);
                                }
                            }
                        }
                        //  log_message('error','IF PAS over');
                    }
                    $save['adddate'] = date('Y-m-d');
                    $add2 = insert_record(ATTENDANCE_SHEET, $save);
                    //  log_message('error','Insereted record is add2:'.$add2);
                }
                if ($add2) {
                    $this->session->set_flashdata('success', 'Attendance store successfully !!');
                    redirect($this->config->item('admin_folder') . '/attendance/take');
                } else {
                    $this->session->set_flashdata('error', 'Error while adding attendance !!');
                    redirect($this->config->item('admin_folder') . '/attendance/take');
                }


                // log_message('error','Main else:');
            }
            if ($add) {
                $this->session->set_flashdata('success', 'Attendance store successfully !!');
                redirect($this->config->item('admin_folder') . '/attendance/take');
            } else {
                $this->session->set_flashdata('error', 'Error while adding attendance !!');
                redirect($this->config->item('admin_folder') . '/attendance/take');
            }
            // exit;
            log_message('error', 'Main submit over');
        }
        $this->load->view($this->config->item('admin_folder') . '/attendance/take', $data);
    }

    function get_class_list() {

        $data['admin'] = $this->session->userdata();
        $data['user_id'] = $data['admin']['user_id'];
        $data['classname'] = $_REQUEST['class_name'];
        $data['get_student_list'] = $this->Data_model->get_student_list_by_id($data['user_id'], $data['classname']);
        $data['cl_nm'] = get_list_by_id($classname, CLASSES);

        $this->load->view($this->config->item('admin_folder') . '/attendance/get_class_list', $data);
    }

    function registration() {
        $data['page_title'] = 'Attendance Register';
        $data['get_list'] = '';
        $admin = $this->session->userdata();
        $user_id = $admin['user_id'];
        $field = 'user_id';
        $data['month'] = date('m');
        $data['get_class_list'] = get_list_by_idd($user_id, $field, CLASSES);

        if (isset($_POST['submit'])) {
            $save['class_name'] = $this->input->post('class_name', TRUE);
            $save['month_name'] = $this->input->post('month_name', TRUE);
            $data['select'] = $save;
            $data['month'] = $this->input->post('month_name', TRUE);
            $data['get_list'] = $this->get_list_for_register($user_id, $save['class_name']);
        }
        $this->load->view($this->config->item('admin_folder') . '/attendance/registration', $data);
    }

//get list by field name
    function get_list_for_register($field_val, $field_val2) {
        $year = Date('Y');
        $month = $this->input->post('month_name', TRUE);
        $monthstring = sprintf('%d-%d-01', $year, $month); /* make yyyy-mm-01 string */


        $where = "( atten.adddate >= '2014-07-01' AND atten.adddate < '2014-07-01' + INTERVAL 1 MONTH) ";
        $this->db->select('atten.student_id,stud.name,atten.attendance,atten.adddate,stud.roll_no');
        $this->db->from(STUDENT . ' as stud');
        $this->db->join(ATTENDANCE_SHEET . ' as atten', 'atten.student_id = stud.id');
        // $this->db->join(ATTENDANCE_SHEET . ' as atten2', 'atten2.user_id = stud.user_id','right');
        $this->db->where('stud.user_id', $field_val);
        $this->db->where('stud.class_name', $field_val2);
        $this->db->where('atten.class_name', $field_val2);
        //  $this->db->where('stud.status', 'Active');

        $this->db->where("MONTH(atten.adddate)", $month);
        $this->db->where("YEAR(atten.adddate)", $year);

        // $this->db->where($where); 
        //$this->db->where("atten.adddate >= '$monthstring'");
        //$this->db->where("atten.adddate < '$monthstring' + INTERVAL 1 MONTH");        
        //    $this->db->where('atten.adddate', $t_dt);        
        //  $this->db->group_by('atten.student_id');
        // $this->db->group_by('(atten.adddate)');
        $this->db->order_by('stud.name');

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function mode($id = '') {
        $data['page_title'] = 'Add SMS Att';
        $data['check'] = 'add';
        $data['status'] = array(
            'Active',
            'Inactive'
        );
        $data['mode'] = base_url() . $this->config->item('admin_folder') . '/attendance/mode/';
        $data['val_error'] = '';
        $data['custom_error'] = null;
        if ($id != '') {
            $data['check'] = 'edit';
            $data['mode'] = base_url() . $this->config->item('admin_folder') . '/attendance/mode/' . $id;
            $data['val_error'] = "";
            $data['page_title'] = 'Edit SMS Att';
            $data['custom_error'] = null;
            $data['data'] = get_list_by_id($id, ATTENDANCE_SMS_TEMPLATE);
        }
        if (isset($_REQUEST['submit'])) {
            $save['name'] = $this->input->post('name', TRUE);
            $save['template_text'] = $this->input->post('template_text', TRUE);
            $save['status'] = $this->input->post('status', TRUE);

            //check empty records 
            $check_required_val = check_required($save);

            if ($check_required_val) {
                $data['val_error'] = '(*) field must be required !! ';
            }

            if ($id == '') {
                $admin = $this->session->userdata();
                $user_id = $admin['user_id'];
                $user = $admin['logint_type'];
                $save['user_id'] = $user_id;
                $str = $save['name'];
                $save['slug'] = createSlugUrl(ATTENDANCE_SMS_TEMPLATE, $str);
                if ($data['val_error'] == '') {
                    $add = insert_record(ATTENDANCE_SMS_TEMPLATE, $save);
                    if ($add) {
                        $this->session->set_flashdata('success', 'You have successfully Added attendance !!');
                        redirect($this->config->item('admin_folder') . '/attendance');
                    } else {
                        $this->session->set_flashdata('error', 'Error while adding attendance !!');
                        redirect($this->config->item('admin_folder') . '/attendance');
                    }
                }
            } else {
                $save['editdate'] = date("Y-m-d h:m:s");
                $id = $this->input->post('data_id', TRUE);
                if ($data['val_error'] == '') {
                    $upd = update_record($save, $id, ATTENDANCE_SMS_TEMPLATE);
                    if ($upd) {
                        $this->session->set_flashdata('success', 'You have successfully updated attendance !!');
                        redirect($this->config->item('admin_folder') . '/attendance');
                    } else {
                        $this->session->set_flashdata('error', 'Error while updating attendance!!');
                        redirect($this->config->item('admin_folder') . '/attendance/mode');
                    }
                }
            }
        }
        $this->load->view($this->config->item('admin_folder') . '/attendance/form', $data);
    }

    //delete single record
    function delete($id) {
        $del = delete_single_rec($id, ATTENDANCE_SMS_TEMPLATE);
        if ($del) {
            $this->session->set_flashdata('success', 'You have successfully deleted attendance !!');
            redirect($this->config->item('admin_folder') . '/attendance');
        } else {
            $this->session->set_flashdata('error', 'Error while deleting attendance !!');
            redirect($this->config->item('admin_folder') . '/attendance');
        }
    }

    function mul_action() {
        $action_val = $_REQUEST['mul_val'];
        $arr_ids = $_REQUEST['mul_id'];
        $path = '/attendance';
        $table = ATTENDANCE_SMS_TEMPLATE;
        multiple_action($arr_ids, $action_val, $table, $path);
    }

    function change_status() {
        $id = $_REQUEST['id'];
        $status = $_REQUEST['status'];
        $table = ATTENDANCE_SMS_TEMPLATE;
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
