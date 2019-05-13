<?php

class Sendsmsallstud extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        //ini_set('max_execution_time', 90000);
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '-1');
        $this->load->model('Data_model');
        
        $redirect = $this->auth->is_logged_in();
        if ($redirect == false) {
            $this->session->set_userdata("redirect", current_url());
            redirect($this->config->item('admin_folder') . '/login');
        }
        //header( 'Content-Type: text/html; charset=utf-8' ); 
    }

    function allstudents() {
        $data['page_title'] = 'SMS To All Student';
        $admin = $this->session->userdata();
        $user_id = $admin['user_id'];
        $user = $admin['logint_type'];
        // $data['get_sms_template']=get_list_by_user_id($user_id,SMS_TEMPLATE);
        // $data['get_list']=get_sms_list($user_id,'allstudents');
        /* echo'<pre>';
          print_r($data['get_list']);
         */
        $data['total_msg'] = count($data['get_list']);
        if (isset($_POST['submit'])) {
            //$save['mobile_no']=$this->input->post('mobile_no',TRUE);
            $s_message = $this->input->post('message', TRUE);
            //$save['msg_for']=$this->input->post('msg_for',TRUE);
            $save['user_id'] = $user_id;
            $save['send_sms_type'] = 'allstudents';
            $save['sms_type'] = $this->input->post('sms_type', TRUE);
            $check_alt = $this->input->post('alt_check', TRUE);
            $get_user_list = get_list_by_id($user_id, USERS);
            if ($get_user_list['status_one'] == 'Active') {
                $api_username = $get_user_list['username_one'];
                $api_password = $get_user_list['password_one'];
                $api_sender = $get_user_list['senderid_one'];
                $api_type = $get_user_list['smstype_one'];
                $api_priority = $get_user_list['prioritydetails_one'];
                $api_schedule_link = API1_SCHEDULE_LINK;
                $api_instant_link = API1_INSTANT_LINK;
                $api_status_link = API1_GETSTATUS_LINK;
            }
            if ($get_user_list['status_two'] == 'Active') {
                $api_username = $get_user_list['username_two'];
                $api_hash = $get_user_list['api_two_hash'];
                $api_sender = $get_user_list['senderid_two'];
                $api_schedule_link = API2_INSTANT_LINK;
            }

            $path_link = '';
            if (isset($api_username)) {
                if (empty($api_username)) {
                    $this->session->set_flashdata('error', 'API Username is not set!!');
                    redirect($this->config->item('admin_folder') . '/send/allstudents');
                }
            }

            if (isset($api_password)) {
                if (empty($api_password)) {
                    $this->session->set_flashdata('error', 'API Password is not set !!');
                    redirect($this->config->item('admin_folder') . '/send/allstudents');
                }
            }

            if (isset($api_sender)) {
                if (empty($api_sender)) {
                    $this->session->set_flashdata('error', 'API Sender id is not set!!');
                    redirect($this->config->item('admin_folder') . '/send/allstudents');
                }
            }

            if (isset($api_type)) {
                if (empty($api_type)) {
                    $this->session->set_flashdata('error', 'API SMS type is not set!!');
                    redirect($this->config->item('admin_folder') . '/send/allstudents');
                }
            }

            if (isset($api_priority)) {
                if (empty($api_priority)) {
                    $this->session->set_flashdata('error', 'API Priority is not set!!');
                    redirect($this->config->item('admin_folder') . '/send/allstudents');
                }
            }

            if (isset($api_hash)) {
                if (empty($api_hash)) {
                    $this->session->set_flashdata('error', 'API Hash is not set!!');
                    redirect($this->config->item('admin_folder') . '/send/allstudents');
                }
            }


            if ($save['sms_type'] == 'Schedule') {
                $save['schedule_date'] = $this->input->post('schedule_date', TRUE);
                $save['sms_type'] = 'Schedule';
                //$save['msg_status']='Delivered';
            } else {
                $save['sms_type'] = 'Instant';
            }
            $msg_value = strlen($s_message);
            $total_msg = $msg_value / 160;
            $total_val = ceil($total_msg);
            $save['count_msg'] = $total_val;

            //$master_id=insert_record(SMS_LOG_MASTER, $save);
            //echo $this->db->last_query(); 
            $save['masterlog_id'] = $master_id;
            $date = get_current_date_time();
            $save['addtime'] = date("H:i:s", strtotime($date));
            $save['adddate'] = date("Y-m-d", strtotime($date));
            $field = 'user_id';
            $get_student_list = get_list_by_idd($user_id, $field, STUDENT);

            foreach ($get_student_list as $student_list) {
                //echo $numbers = implode(",",array_column($get_student_list,'mobile_no'));
                $mo_no = $save['mobile_no'] = $student_list['mobile_no'];
                if ($save['msg_for'] != 'None') {
                    $msg = $s_message;
                    if ($get_user_list['status_one'] == 'Active') {
                        $message = $s_message;
                    }
                    if ($get_user_list['status_two'] == 'Active') {
                        $message = "Dear Parents, " . $msg;
                    }
                } else {
                    $message = $s_message;
                }
                if (strrchr($message, "[todaydate]")) {
                    $arr['[todaydate]'] = date('d-m-Y');
                }
                if (strrchr($message, "[name]")) {
                    $arr['[name]'] = $student_list['name'];
                }
                if (strrchr($message, "[class]")) {
                    $arr['[class]'] = $student_list['class_name'];
                }
                if (strrchr($message, "[rollno]")) {
                    $arr['[rollno]'] = $student_list['roll_no'];
                }
                $message_test = replace_string_using_array($arr, $message);
                if ($message_test == FALSE) {
                    $save['message'] = $message;
                    $message = urlencode($message);
                } else {
                    $save['message'] = $message_test;
                    $message = urlencode($message_test);
                    //echo "this is else condition"; 
                }
                unset($arr);
                $save['stud_id'] = $student_list['id'];

                if ($save['sms_type'] != 'Schedule') {
                    /*   if($get_user_list['status_one']=='Active') {
                      $link=$api_instant_link.'user='.$api_username.'&pass='.$api_password.'&sender='.$api_sender.'&phone='.$mobile_no.'&text='.$message.'&priority='.$api_priority.'&stype='.$api_type;
                      $send_sms=call_send_sms_link($link);
                      $save['send_sms_id']=$send_sms;
                      $smscode=urlencode($send_sms);
                      if(!empty($smscode)) {
                      $check_status=$api_status_link.'user='.$api_username.'&msgid='.$smscode.'&phone='.$mobile_no.'&msgtype='.$api_type;
                      $sms_status=call_send_sms_link($check_status);
                      if(strpos($sms_status, 'DELIVRD') !== false ) {
                      $sms_status="Delivered";
                      } else {
                      $sms_status=$sms_status;
                      }
                      $save['msg_status']=$sms_status;
                      }
                      // unset($link); unset($check_status);
                      $save['api_name']='one';
                      $upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
                      } */
                    // log_message('error', 'pre if ' .$cnt);
                    if ($get_user_list['status_two'] == 'Active') {
                        $username = $api_username;
                        $hash = $api_hash;
                        $numbers = $mo_no;
                        $sender = $api_sender;
                        $message = $message;
                        $data = array('username' => $username, 'hash' => $hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message, "unicode" => true);

                        $ch = curl_init('http://smartsms.clickschooldiary.com/api2/send/');
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $send_repor = curl_exec($ch);
                        curl_close($ch);
                        $send_report = json_decode($send_repor, true);

                        //   echo  $link=$api_schedule_link.'username='.$api_username.'&hash='.$api_hash.'&numbers=91'.$mobile_no.'&sender='.$api_sender.'&message='.$message;
                        //   $send_sms=call_send_sms_link($link);    
                        // log_message('error', 'if tst pratik' .$cnt);

                        if ($send_report['status'] == 'success') {
                            $save['msg_status'] = 'Delivered';
                            $save['is_send'] = 1;
                        } else {
                            $save['msg_status'] = 'failure';
                        }
                        //$save['msg_status']='Delivered';
                        // $upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
                        $save['api_name'] = 'two';
                    }
                    //log_message('error', 'out if pratik' .$cnt);
                } else {

                    if (isset($save['schedule_date'])) {
                        $datedata = $save['schedule_date'];
                        $dated = strtotime($datedata);
                        $date = explode(" ", $save['schedule_date']);
                        $s_data = $date[0] . "%20" . $date[1];
                        if ($get_user_list['status_one'] == 'Active') {
                            //$link=$api_schedule_link.'user='.$api_username.'&pass='.$api_password.'&sender='.$api_sender.'&phone='.$mobile_no.'&text='.$message.'&priority='.$api_priority.'&stype='.$api_type.'&time='.$s_data;                                        
                            // $upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
                            $save['api_name'] = 'one';
                        }
                        if ($get_user_list['status_two'] == 'Active') {
                            // $link=$api_schedule_link.'username='.$api_username.'&hash='.$api_hash.'&numbers=91'.$mobile_no.'&sender='.$api_sender.'&message='.$message.'&time='.$s_data;
                            // $upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
                            $username = $api_username;
                            $hash = $api_hash;
                            $numbers = $mo_no;
                            $sender = $api_sender;
                            $message = $message;
                            $schedule_time = $dated;
                            $data = array('username' => $username, 'hash' => $hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message, "schedule_time" => $dated, "unicode" => true);
                            $ch = curl_init('http://smartsms.clickschooldiary.com/api2/send/');
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $send_repor = curl_exec($ch);
                            curl_close($ch);
                            $send_report = json_decode($send_repor, true);
                            //$upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
                            $save['api_name'] = 'two';
                            if ($send_report['status'] == 'success') {
                                $save['msg_status'] = 'Delivered';
                                $save['is_send'] = 1;
                            } else {
                                $save['msg_status'] = 'failure';
                            }
                            $save['api_name'] = 'two';
                        }
                        //$send_sms=send_schedule_sms($link);
                        $save['schedule_date'] = $datedata;
                    }
                }

                /*          echo    $save['msg_status']='Submitted';
                  update_record($upd, $user_id, USERS); */

                if ($check_alt) {
                    $save['mobile_no'] = $student_list['alternate_no'];
                    if (!empty($save['mobile_no'])) {
                        insert_record(SMS_LOG, $save);
                    }
                }

                $save['mobile_no'] = $student_list['mobile_no'];
                // $mobile_no_arr[]=$numbers;
                if (!empty($save['mobile_no'])) {
                    $add = insert_record(SMS_LOG, $save);
                } else {
                    $add = true;
                }
                //$add=insert_record(SMS_LOG,$save); 
                //echo $this->db->last_query();
                //$cnt++;
            }

            if ($send_report['status'] == 'success') {
                $this->session->set_flashdata('success', 'Message send succesfully');
                redirect($this->config->item('admin_folder') . '/send/allstudents');
            } else {
                $this->session->set_flashdata('error', 'Error while Sending sms !!');
                redirect($this->config->item('admin_folder') . '/send/allstudents');
            }
        }



        $this->load->view($this->config->item('admin_folder') . '/send/sms_allstudent', $data);
    }

}
?>	
