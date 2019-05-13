<?php

class Sendsmsclass extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        //ini_set('max_execution_time', 90000);
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        $this->load->model('Data_model');
        
        $redirect = $this->auth->is_logged_in();
        if ($redirect == false) {
            $this->session->set_userdata("redirect", current_url());
            redirect($this->config->item('admin_folder') . '/login');
        }
        //header( 'Content-Type: text/html; charset=utf-8' ); 
    }

    function class_sms() {
        $data['page_title'] = 'SMS To Class';
        $admin = $this->session->userdata();
        $user_id = $admin['user_id'];
        $user = $admin['logint_type'];
        // $data['get_msg_for']=get_listt(SMS_FOR_LIST);
        // $data['get_api_status']=$this->Data_model->get_api_status($user_id);
        $data['get_sms_template'] = get_list_by_user_id($user_id, SMS_TEMPLATE);
        //  $data['get_group_list']=get_list_by_user_id($user_id,CLASSES);
        //  $data['get_list']=get_sms_list($user_id,'class_sms');
        // $data['total_msg']=count($data['get_list']);
        if (isset($_POST['submit'])) {
            //$save['mobile_no']=$this->input->post('mobile_no',TRUE);
            $s_message = $this->input->post('message', TRUE);
            $save['sms_type'] = $this->input->post('sms_type', TRUE);
            $save['msg_for'] = $this->input->post('msg_for', TRUE);
            $save['user_id'] = $user_id;
            $save['send_sms_type'] = 'class_sms';
            $check_group = $this->input->post('check_id', TRUE);

            $path_link = '';
            /* if($save['msg_for']!='None'){    
              //for send sms data
              $message="Dear ".$save['msg_for'].", ".$save['message'];
              //$message = str_replace(' ', '%20', $message);
              $message=urlencode($message);
              $message=$message;
              } else {
              $message=urlencode($save['message']);
              } */

            //$mobile_no=$save['mobile_no'];
            $get_user_list = get_list_by_id($user_id, USERS);
            /*  print_r($get_user_list); 
              exit; */
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

            if (isset($api_username)) {
                if (empty($api_username)) {
                    $this->session->set_flashdata('error', 'API Username is not set!!');
                    redirect($this->config->item('admin_folder') . '/send/class_sms');
                }
            }

            if (isset($api_password)) {
                if (empty($api_password)) {
                    $this->session->set_flashdata('error', 'API Password is not set !!');
                    redirect($this->config->item('admin_folder') . '/send/class_sms');
                }
            }

            if (isset($api_sender)) {
                if (empty($api_sender)) {
                    $this->session->set_flashdata('error', 'API Sender id is not set!!');
                    redirect($this->config->item('admin_folder') . '/send/class_sms');
                }
            }

            if (isset($api_type)) {
                if (empty($api_type)) {
                    $this->session->set_flashdata('error', 'API SMS type is not set!!');
                    redirect($this->config->item('admin_folder') . '/send/class_sms');
                }
            }

            if (isset($api_priority)) {
                if (empty($api_priority)) {
                    $this->session->set_flashdata('error', 'API Priority is not set!!');
                    redirect($this->config->item('admin_folder') . '/send/class_sms');
                }
            }

            if (isset($api_hash)) {
                if (empty($api_hash)) {
                    $this->session->set_flashdata('error', 'API Hash is not set!!');
                    redirect($this->config->item('admin_folder') . '/send/class_sms');
                }
            }
            if (empty($check_group)) {
                $this->session->set_flashdata('error', 'Please select Class');
                redirect($this->config->item('admin_folder') . '/send/class_sms');
            }

            if ($save['sms_type'] == 'Schedule') {
                $save['schedule_date'] = $this->input->post('schedule_date', TRUE);
                $save['sms_type'] = 'Schedule';
                // $save['msg_status']='Delivered';
            } else {
                $save['sms_type'] = 'Instant';
            }
            $msg_value = strlen($s_message);
            $total_msg = $msg_value / 160;
            $total_val = ceil($total_msg);
            $save['count_msg'] = $total_val;
            // $master_id=insert_record(SMS_LOG_MASTER, $save);

            $date = get_current_date_time();
            $save['addtime'] = date("H:i:s", strtotime($date));
            $save['adddate'] = date("Y-m-d", strtotime($date));
            foreach ($check_group as $key => $value) {
                $stdnt_list = $this->Data_model->get_student_list_by_class_id($value, $user_id);

                foreach ($stdnt_list as $gm) {
                    if ($save['msg_for'] != 'None') {
                        $msg = $s_message;
                        $message = $msg;
                    } else {
                        $message = $s_message;
                    }
                    // echo  $student_info=get_detalis_for_message('mobile_no',$value,'user_id',$user_id,STUDENT);


                    if (strrchr($message, "[todaydate]")) {
                        echo $arr['[todaydate]'] = date('d-m-Y');
                    }
                    if (strrchr($message, "[name]")) {
                        $arr['[name]'] = $gm['name'];
                    }
                    if (strrchr($message, "[class]")) {
                        $arr['[class]'] = $gm['class_name'];
                    }
                    if (strrchr($message, "[rollno]")) {
                        $arr['[rollno]'] = $gm['roll_no'];
                    }
                    $message_test = replace_string_using_array($arr, $message);
                    if ($message_test == FALSE) {
                        $save['message'] = $message;

                        $message = urlencode($message);
                    } else {
                        $save['message'] = $message_test;
                        $message = urlencode($message_test);
                    }
                    unset($arr);
                    $save['stud_id'] = $gm['id'];
                    $save['mobile_no'] = $gm['mobile_no'];
                    $save['name'] = $gm['class_name'];
                    $mobile_no = $save['mobile_no'];
                    if ($save['sms_type'] != 'Schedule') {
                        if ($get_user_list['status_one'] == 'Active') {
                            /* $link=$api_instant_link.'user='.$api_username.'&pass='.$api_password.'&sender='.$api_sender.'&phone='.$mobile_no.'&text='.$message.'&priority='.$api_priority.'&stype='.$api_type;
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
                              unset($link); unset($check_status); */
                            $save['api_name'] = 'one';
                            $upd['total_sms_one'] = $get_user_list['total_sms_one'] - $save['count_msg'];
                        }
                        if ($get_user_list['status_two'] == 'Active') {
                            // $link=$api_schedule_link.'username='.$api_username.'&hash='.$api_hash.'&numbers=91'.$mobile_no.'&sender='.$api_sender.'&message='.$message;
                            $username = $api_username;
                            $hash = $api_hash;
                            $numbers = $mobile_no;
                            $sender = $api_sender;
                            $message = $message;
                            $data = array('username' => $username, 'hash' => $hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message, "unicode" => true);

                            $ch = curl_init('http://smartsms.clickschooldiary.com/api2/send/');
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $send_report = curl_exec($ch);
                            curl_close($ch);
                            $json = json_decode($send_report, true);
                            /* $send_sms=call_send_sms_link($link);                                            
                              $send_report=json_decode($send_sms); */
                            if ($json['status'] == 'success') {
                                $save['msg_status'] = 'Delivered';
                                $save['is_send'] = 1;
                            } else {
                                $save['msg_status'] = 'failure';
                            }
                            /* $send_sms=call_send_sms_link($link);                                            
                              $send_report=json_decode($send_sms);
                              if($send_report['status']=='success'){
                              $save['msg_status']='Delivered';
                              } else {
                              $save['msg_status']=$send_report['status'];
                              } */
                            $save['api_name'] = 'two';
                            // $upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
                        }
                    } else {
                        if (isset($save['schedule_date'])) {
                            $datedata = $save['schedule_date'];
                            echo $dated = strtotime($datedata);
                            $date = explode(" ", $save['schedule_date']);
                            $s_data = $date[0] . "%20" . $date[1];
                            if ($get_user_list['status_one'] == 'Active') {
                                //  $link=$api_schedule_link.'user='.$api_username.'&pass='.$api_password.'&sender='.$api_sender.'&phone='.$mobile_no.'&text='.$message.'&priority='.$api_priority.'&stype='.$api_type.'&time='.$s_data;                                        
                                $upd['total_sms_one'] = $get_user_list['total_sms_one'] - $save['count_msg'];
                                $save['api_name'] = 'one';
                            }
                            if ($get_user_list['status_two'] == 'Active') {
                                // $link=$api_schedule_link.'username='.$api_username.'&hash='.$api_hash.'&numbers=91'.$mobile_no.'&sender='.$api_sender.'&message='.$message.'&time='.$s_data;
                                //$upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
                                $username = $api_username;
                                $hash = $api_hash;
                                $numbers = $mobile_no;
                                $sender = $api_sender;
                                $message = $message;
                                $schedule_time = $dated;
                                $data = array('username' => $username, 'hash' => $hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message, "schedule_time" => $dated, "unicode" => true);
                                $ch = curl_init('http://smartsms.clickschooldiary.com/api2/send/');
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $send_report = curl_exec($ch);
                                curl_close($ch);
                                $json = json_decode($send_report, true);

                                //$upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
                                $save['api_name'] = 'two';
                                if ($json['status'] == 'success') {
                                    $save['msg_status'] = 'Delivered';
                                    $save['is_send'] = 1;
                                } else {
                                    $save['msg_status'] = 'failure';
                                }
                                $save['api_name'] = 'two';
                            }
                            // $send_sms=send_schedule_sms($link);
                            $save['schedule_date'] = $datedata;
                        }
                    }

                    //  $save['msg_status']='Submitted';
                    // update_record($upd, $user_id, USERS); 
                    if (!empty($save['mobile_no'])) {
                        $add = insert_record(SMS_LOG, $save);
                    } else {
                        $add = true;
                    }
                }
            }

            /* $mobile_number=$save['mobile_no'];
              $mb_no=explode(",",$mobile_number);
              $save['masterlog_id']=$master_id;
              foreach ($mb_no as $key=>$value)
              {
              $mobile_no=$result = substr($value, 0, 10);
              $save['mobile_no']=$mobile_no;
              $add=insert_record(SMS_LOG,$save);
              } */

            if ($json['status'] == 'failure') {
                $this->session->set_flashdata('error', 'Error while Sending sms !!');
                redirect($this->config->item('admin_folder') . '/send/class_sms');
            } else {

                $this->session->set_flashdata('success', 'Message send succesfully');
                redirect($this->config->item('admin_folder') . '/send/class_sms');
            }
        }
        $this->load->view($this->config->item('admin_folder') . '/send/sms_class', $data);
    }

}

?>