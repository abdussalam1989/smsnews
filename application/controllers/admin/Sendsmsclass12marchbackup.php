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

        if (isset($_POST['submit'])) {

            $s_message = trim($this->input->post('message', TRUE));
            $save['sms_type'] = $this->input->post('sms_type', TRUE);
            $save['msg_for'] = $this->input->post('msg_for', TRUE);
            $save['user_id'] = $user_id;
            $save['send_sms_type'] = 'class_sms';
            $check_group = $this->input->post('check_id', TRUE);

            $save['count_msg'] = sms_count($s_message);

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
                    redirect($this->config->item('admin_folder') . '/send/stud');
                }
            }

            if (isset($api_password)) {
                if (empty($api_password)) {
                    $this->session->set_flashdata('error', 'API Password is not set !!');
                    redirect($this->config->item('admin_folder') . '/send/stud');
                }
            }

            if (isset($sender)) {
                if (empty($sender)) {
                    $this->session->set_flashdata('error', 'API Sender id is not set!!');
                    redirect($this->config->item('admin_folder') . '/send/stud');
                }
            }

            if (isset($api_type)) {
                if (empty($api_type)) {
                    $this->session->set_flashdata('error', 'API SMS type is not set!!');
                    redirect($this->config->item('admin_folder') . '/send/stud');
                }
            }

            if (isset($api_priority)) {
                if (empty($api_priority)) {
                    $this->session->set_flashdata('error', 'API Priority is not set!!');
                    redirect($this->config->item('admin_folder') . '/send/stud');
                }
            }

            if (isset($hash)) {
                if (empty($hash)) {
                    $this->session->set_flashdata('error', 'API Hash is not set!!');
                    redirect($this->config->item('admin_folder') . '/send/stud');
                }
            }


            $date = get_current_date_time();
            $save['addtime'] = date("H:i:s", strtotime($date));
            $save['adddate'] = date("Y-m-d", strtotime($date));
			
		//	$store_data = array();
			$message = $s_message;
			$save['message'] = $message;
			$i_key = 0;
			$j_error = 0;
            foreach ($check_group as $key => $value) {
                $stdnt_list = $this->Data_model->get_student_list_by_class_id($value, $user_id);
                //  $numbers = implode(",", array_column($stdnt_list, 'mobile_no'));
//print_r($stdnt_list);
                foreach ($stdnt_list as $gm) {
					$save['stud_id'] = $gm['id'];
                    $save['mobile_no'] = $gm['mobile_no'];
                    $save['name'] = $gm['class_name'];
                    $numbers = $save['mobile_no'];
					$data = array();
					
					if (preg_match('/^\d{10}$/', $numbers)) { // phone number is valid
						$arr = array();
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
							$message_test = urlencode($message);
						} else {		
							$save['message'] = $message_test;						
							$message_test = urlencode($message_test);
						}
						unset($arr);
						

						if ($save['sms_type'] != 'Schedule') {

							if ($get_user_list['status_one'] == 'Active') {
								$save['api_name'] = 'one';
							}
							if ($get_user_list['status_two'] == 'Active') {								
								$save['api_name'] = 'two';								
								$data = array('username' => $username, 'hash' => $hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message_test, "unicode" => true);								
							}
						} else {
							if (isset($save['schedule_date'])) {
								$dated = strtotime($save['schedule_date']);
								if ($get_user_list['status_two'] == 'Active') {
									$save['api_name'] = 'two';									
									$schedule_time = $dated;
									$data = array('username' => $username, 'hash' => $hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message_test, "schedule_time" => $dated, "unicode" => true);									
								}
							}
						}
						
						if($data){						
							$json = array();
								// Send sms 
							$json = send_sms($data, $save);
							$store_data[$i_key] = $save;
							if ($json['status'] == 'success') {
								$store_data[$i_key]['msg_status'] = 'Delivered';
								$store_data[$i_key]['is_send'] = 1;
							} else {
								$j_error++;
								$store_data[$i_key]['msg_status'] = 'failure';
							}
						}
						$i_key++;
						
					}
                }
            }

			if ($store_data) {			
					$this->db->insert_batch(SMS_LOG, $store_data);
	
				}


            if ($j_error == 0) {
                $this->session->set_flashdata('success', 'Message send succesfully');
               redirect($this->config->item('admin_folder') . '/send/class_sms');
            } else {
				  $this->session->set_flashdata('error', $j_error.' Mobile numbers had error while sending sms from '.$i_key.' numbers!!');
                redirect($this->config->item('admin_folder') . '/send/class_sms');
            }
        }
        redirect($this->config->item('admin_folder') . '/send/class_sms');
    }

}

?>