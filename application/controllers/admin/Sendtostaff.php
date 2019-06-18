<?php

class Sendtostaff extends CI_Controller {

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

    function staff() {
        $data['page_title'] = 'SMS To Staff';
        $admin = $this->session->userdata();
        //$data['mode']=ADMIN_URL.'/send/stud';
        $user_id = $admin['user_id'];
        $user = $admin['logint_type'];

        if (isset($_POST['submit'])) {
            $save['mobile_no'] = $this->input->post('mobile_no', TRUE);
            $s_message = trim($this->input->post('message', TRUE));
            $save['sms_type'] = $this->input->post('sms_type', TRUE);
            $save['msg_for'] = $this->input->post('msg_for', TRUE); 
            $language=$this->input->post('language', TRUE);            
            $save['user_id'] = $user_id;
            $save['send_sms_type'] = 'Staff';

            $path_link = '';

            $save['count_msg'] = sms_count($s_message);

            $numbers_array = extract_numbers($save['mobile_no']);
            $numbers = implode(",", $numbers_array);
            $save['mobile_no'] = $numbers;


            $get_user_list = get_list_by_id($user_id, USERS);
            if ($get_user_list['status_one'] == 'Active') {
                $username = $get_user_list['username_one'];
                $api_password = $get_user_list['password_one'];
                $sender = $get_user_list['senderid_one'];
                $api_type = $get_user_list['smstype_one'];
                $api_priority = $get_user_list['prioritydetails_one'];
                $api_schedule_link = API1_SCHEDULE_LINK;
                $api_instant_link = API1_INSTANT_LINK;
                $api_status_link = API1_GETSTATUS_LINK;
            }
            if ($get_user_list['status_two'] == 'Active') {
                $username = $get_user_list['username_two'];
                $hash = $get_user_list['api_two_hash'];
                $sender = $get_user_list['senderid_two'];
                $api_schedule_link = API2_INSTANT_LINK;
            }

            if (isset($username)) {
                if (empty($username)) {
                    $this->session->set_flashdata('error', 'API Username is not set!!');
                    redirect($this->config->item('admin_folder') . '/send/teacher');
                }
            }

            if (isset($api_password)) {
                if (empty($api_password)) {
                    $this->session->set_flashdata('error', 'API Password is not set !!');
                    redirect($this->config->item('admin_folder') . '/send/teacher');
                }
            }

            if (isset($sender)) {
                if (empty($sender)) {
                    $this->session->set_flashdata('error', 'API Sender id is not set!!');
                    redirect($this->config->item('admin_folder') . '/send/teacher');
                }
            }

            if (isset($api_type)) {
                if (empty($api_type)) {
                    $this->session->set_flashdata('error', 'API SMS type is not set!!');
                    redirect($this->config->item('admin_folder') . '/send/teacher');
                }
            }

            if (isset($api_priority)) {
                if (empty($api_priority)) {
                    $this->session->set_flashdata('error', 'API Priority is not set!!');
                    redirect($this->config->item('admin_folder') . '/send/teacher');
                }
            }

            if (isset($hash)) {
                if (empty($hash)) {
                    $this->session->set_flashdata('error', 'API Hash is not set!!');
                    redirect($this->config->item('admin_folder') . '/send/teacher');
                }
            }

            if ($save['sms_type'] == 'Schedule') {
                $save['schedule_date'] = $this->input->post('schedule_date', TRUE);
                $save['sms_type'] = 'Schedule';
            } else {
                $save['sms_type'] = 'Instant';
            }

            $mobile_number = $save['mobile_no'];

            $mb_nos = explode(",", $mobile_number);
            $mb_no=array_unique($mb_nos);
            //    $save['masterlog_id'] = $master_id;
            $date = get_current_date_time();
            $save['addtime'] = date("H:i:s", strtotime($date));
            $save['adddate'] = date("Y-m-d", strtotime($date));
		//	$store_data = array();
			$message = $s_message;
			$i_key = 0;
            $active_one=0;
			$save['message'] = $message;
			$j_error = 0;
            foreach ($mb_no as $key => $numbers) {
                //if(preg_match('/^\d{10}$/', $numbers)) { // phone number is valid

					$save['mobile_no'] = $numbers;	
					$data = array();
					
                    $teacher_info = get_detalis_for_message_teacher('mobile_no', $numbers, 'user_id', $user_id, STAFF);
                    if (strrchr($message, "[todaydate]")) {
                        $arr['[todaydate]'] = date('d-m-Y');
                    }
                    if (strrchr($message, "[name]")) {
                        $arr['[name]'] = $teacher_info['name'];
                    }

                    if (strrchr($message, "[employ_id]")) {
                        $arr['[employ_id]'] = $teacher_info['employ_id'];
                    }
                    $message_test = replace_string_using_array($arr, $message);
                    if ($message_test == FALSE) {							
							$message_test = urlencode($message);
						} else {		
							$save['message'] = $message_test;						
							$message_test = urlencode($message_test);
						}
                    unset($arr);
                    $save['teacher_id'] = $teacher_info['id'];
                    if ($save['sms_type'] != 'Schedule') {

                        if ($get_user_list['status_one'] == 'Active') {
                            $save['api_name'] = 'one';
                            $username =$username;
                            $password = $api_password;
                            $numbers = $numbers;
                            $sender = $sender;
                            $data_one = array('user'=>$username, 'pass'=>$password, 'phone'=>$numbers, "sender"=>$sender, 'text'=>$save['message'],'priority'=>$api_priority,'stype'=>$api_type);
                            $send_report=send_sms_one($data_one,$save);
                            if(preg_match('/^\d{10}$/',$numbers)) {
                            $save['response_id']=$send_report;                       
                            $save['msg_status']='Pending';
                            $save['is_send']=0;
                            $store_data[$key]= $save;
                            } else {                          
                            $j_error++;
                            $save['response_id']=$send_report;                       
                            $save['msg_status']='Pending';
                            $save['is_send']=0;
                            $store_data[$key]= $save;
                        }
                        } else {
                        if ($get_user_list['status_two'] == 'Active') {                           
                            $save['api_name'] = 'two';                            
                            $data = array('username' => $username, 'hash' => $hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message_test,'unicode'=>$language=='hindi'?1:0);                            
                        }
						if($data!="") {
						$json = send_sms($data, $save);
						$store_data[$i_key] = $save;
						if ($json['status'] == 'success') {
							$store_data[$i_key]['msg_status'] = 'Delivered';
							$store_data[$i_key]['is_send'] = 1;
						} else {
							$j_error++;
							$store_data[$i_key]['msg_status'] = 'Failure';
							$store_data[$i_key]['is_send'] = 0;
						}						
					}
                    }
                    } else {
                        if (isset($save['schedule_date'])) {
                            $dated = strtotime($save['schedule_date']);
                            if ($get_user_list['status_two'] == 'Active') {
                                $save['api_name'] = 'two';                                
                                $schedule_time = $dated;
                                $data = array('username' => $username, 'hash' => $hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message_test, "schedule_time" => $dated,'unicode'=>$language=='hindi'?1:0);                                
                            }
							if($data!=""){
						// Send sms for schedule 
						//print_r($data);
						$json = send_sms($data, $save);
						$store_data[$i_key] = $save;
						if ($json['status'] == 'success') {
							$store_data[$i_key]['msg_status'] = 'Scheduled';
							$store_data[$i_key]['is_send'] = 2;
						} else {
							$j_error++;
							$store_data[$i_key]['msg_status'] = 'Failure';
							$store_data[$i_key]['is_send'] = 0;
						}						
					}
                        }
                    }
															
                //}
				$i_key++;
            }

			if ($store_data) {
                if($get_user_list['status_one'] == 'Active') {
                $this->db->insert_batch(SMS_LOG_ONE, $store_data);
            } else {
                $this->db->insert_batch(SMS_LOG, $store_data);
            }
            }
			
            if ($j_error == 0) {
                $this->session->set_flashdata('success', 'Message send succesfully');
                redirect($this->config->item('admin_folder') . '/send/staff');
            } else {
                 $this->session->set_flashdata('error', $j_error.' Mobile numbers had error while sending sms from '.$i_key.' numbers!!');
                redirect($this->config->item('admin_folder') . '/send/staff');
            }
        }


        redirect($this->config->item('admin_folder') . '/send/staff');
    }

}

?>