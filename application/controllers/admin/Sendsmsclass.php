<?php
class Sendsmsclass extends CI_Controller {
    
	function __construct()
	{
		parent::__construct();
		$this->load->library('auth');
		//ini_set('max_execution_time', 90000);
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '-1'); 
		$this->load->model('Data_model');
		error_reporting(0);
		$redirect = $this->auth->is_logged_in();
		if ($redirect == false) {
			$this->session->set_userdata("redirect", current_url());
			redirect($this->config->item('admin_folder').'/login');
		}
                //header( 'Content-Type: text/html; charset=utf-8' ); 
        }
        function class_sms()
        {
                $data['page_title']='SMS To Class';
                $admin=$this->session->userdata();
                $user_id=$admin['user_id'];
                $user=$admin['logint_type'];              
                $data['get_sms_template']=get_list_by_user_id($user_id,SMS_TEMPLATE);           
                    if(isset($_POST['submit']))
                    {
                        //$save['mobile_no']=$this->input->post('mobile_no',TRUE);
                        $s_message=$this->input->post('message',TRUE);
						$save['sms_type']=$this->input->post('sms_type',TRUE);
                        $save['msg_for']=$this->input->post('msg_for',TRUE);
                        $language = $this->input->post('language', TRUE);
                        if($user!='teacher') {
                        $save['user_id'] = $user_id;
                        } else {
                        $teacherdetail=get_teacher_list_by_user_id($user_id,CLASS_TEACHER);
                        $save['user_id'] = $teacherdetail['user_id'];
                        $save['teacher_id'] = $teacherdetail['login_id'];  
                        }
                        $save['send_sms_type']='class_sms';
                        $check_group=$this->input->post('check_id',TRUE);                       
                        $path_link='';                     
                        if($user!='teacher') {
                        $get_user_list = get_list_by_id($user_id, USERS);
                        } else {
                        $teacherdetail=get_teacher_list_by_user_id($user_id,CLASS_TEACHER);
                        $get_user_list = get_list_by_id($teacherdetail['user_id'], USERS);
                        }                      				
					    if($get_user_list['status_one']=='Active') {
                            $api_username=$get_user_list['username_one'];
                            $api_password=$get_user_list['password_one'];
                            $api_sender=$get_user_list['senderid_one'];
                            $api_type=$get_user_list['smstype_one'];
                            $api_priority=$get_user_list['prioritydetails_one'];
                            $api_schedule_link=API1_SCHEDULE_LINK;
                            $api_instant_link=API1_INSTANT_LINK;
                            $api_status_link=API1_GETSTATUS_LINK;
                        }
                        if($get_user_list['status_two']=='Active') {
                                $api_username=$get_user_list['username_two'];
                                $api_hash=$get_user_list['api_two_hash'];
                                $api_sender=$get_user_list['senderid_two'];
                                $api_schedule_link=API2_INSTANT_LINK;
                        }
                        
                        if(isset($api_username)) {
                            if(empty($api_username)) {
                                    $this->session->set_flashdata('error', 'API Username is not set!!');
                                    redirect($this->config->item('admin_folder').'/send/class_sms');
                            }
                        }
                        
                        if(isset($api_password)) { 
                            if(empty($api_password)) {
                                    $this->session->set_flashdata('error', 'API Password is not set !!' );
                                    redirect($this->config->item('admin_folder').'/send/class_sms');
                            }
                        }
                        
                        if(isset($api_sender)) {
                            if(empty($api_sender)) {
                                $this->session->set_flashdata('error', 'API Sender id is not set!!' );
                                redirect($this->config->item('admin_folder').'/send/class_sms');                            
                            }                        
                        }
                        
                        if(isset($api_type)){
                            if(empty($api_type)) {
                                $this->session->set_flashdata('error', 'API SMS type is not set!!' );
                                redirect($this->config->item('admin_folder').'/send/class_sms');
                            }
                        }
                        
                        if(isset($api_priority)) {
                            if(empty($api_priority)) {
                                $this->session->set_flashdata('error', 'API Priority is not set!!' );
                                redirect($this->config->item('admin_folder').'/send/class_sms');
                            }
                        }
                        
                        if(isset($api_hash)) {
                            if(empty($api_hash)) {
                                $this->session->set_flashdata('error', 'API Hash is not set!!' );
                                redirect($this->config->item('admin_folder').'/send/class_sms');
                            }
                        }                        
                        if(empty($check_group))
                        {
                                $this->session->set_flashdata('error','Please select Class');
                                redirect($this->config->item('admin_folder').'/send/class_sms');
                        }
                                               
                        if($save['sms_type']=='Schedule') {   
                                $save['schedule_date']=$this->input->post('schedule_date',TRUE);
                                $save['sms_type']='Schedule';
                               //$save['msg_status']='Delivered';
                        } else {
                                $save['sms_type']='Instant';
                        }                 
                                $msg_value=strlen($s_message);
                                $total_msg=$msg_value/160;
                                $total_val=ceil($total_msg);
                                $save['count_msg']=$total_val;
                               // $master_id=insert_record(SMS_LOG_MASTER, $save);
                                
                                $date=get_current_date_time();
                                $save['addtime']=date("H:i:s",strtotime($date));
                                $save['adddate']=date("Y-m-d",strtotime($date));
                               // foreach($check_group as $key=>$value) {
                                if($user!='teacher') {                 
                                $stdnt_lists=$this->Data_model->get_student_list_by_class_id($check_group,$user_id);
                                } else {                 
                                $stdnt_lists = $this->Data_model->get_student_list_by_teacher_class_id($check_group);
                                }
                                        
										//$numbers = implode(",",array_column($stdnt_list,'mobile_no'));
                                        $stdnt_list=$this->unique_multi_array($stdnt_lists,'mobile_no');
                                        $active_one=0;
                                        $count=0;
										foreach($stdnt_list as $key=>$gm)
                                        {  		
                                            if($save['msg_for']!='None'){    
                                            $msg=$s_message;
                                            $message=$msg;
                                            } else {
                                                $message=$s_message;
                                            }                                       
                                            if(strrchr($message,"[todaydate]")){
                                             echo   $arr['[todaydate]']=date('d-m-Y');
                                            }
                                            if(strrchr($message,"[name]")){
                                                $arr['[name]']=$gm['name'];
                                            }
                                            if(strrchr($message,"[class]")){
                                                $arr['[class]']=$gm['class_name'];
                                            }
                                            if(strrchr($message,"[rollno]")){
                                                $arr['[rollno]']=$gm['roll_no'];
                                            }
                                            $message_test=replace_string_using_array($arr,$message);
                                            if($message_test==FALSE) {
                                                $save['message']=$message;
                                               
                                                $message=urlencode($message);
                                            } else {
                                                $save['message']=$message_test;
                                                $message=urlencode($message_test);
                                            }
                                            unset($arr);
                                            $save['stud_id']=$gm['id'];
                                            $save['mobile_no']=$gm['mobile_no'];
                                            $save['name']=$gm['class_name'];
                                            $number=$gm['mobile_no'];
											
										//==============================================================================//

                                            if($save['sms_type'] !='Schedule') {
                                                if($get_user_list['status_one']=='Active') {
                                                      
                                                $save['api_name']='one';
                                                $upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
                                                            $username =$api_username;
                                                            $password = $api_password;
                                                            $numbers = $number;
                                                            $sender = $api_sender;

                                                            $data_one = array('user'=>$username, 'pass'=>$password, 'phone'=>$numbers, "sender"=>$sender, 'text'=>$save['message'],'priority'=>$api_priority,'stype'=>$api_type);
                                                                $send_report=send_sms_one($data_one,$save);
                                                                if(preg_match('/^\d{10}$/',$numbers)) {
                                                                $save['response_id']=$send_report;
                                                                $save['msg_status']='Pending';
                                                                $save['is_send']=0;
                                                                $store_data[$key]= $save; 
                                                                } else {
                                                                $active_one++; 
                                                                echo  
                                                                $save['response_id']=$send_report;
                                                                $save['msg_status']='Pending';
                                                                $save['is_send']=0;
                                                               
                                                                $store_data[$key]= $save;
                                                                }        
                                                            
                                                } else {
                                                if($get_user_list['status_two']=='Active') {    
                                                            $save['api_name']='two';  
                                                            $username =$api_username;
															$hash = $api_hash;
															$numbers = $number;
															$sender = $api_sender;
															$message = $message;
															$data = array('username' => $username, 'hash' =>$hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message,'unicode'=>$language=='hindi'?1:0);
															$json = send_sms($data, $save); 		
															
													    if($json['status']=='success')
														{
								                            $store_data[$key]['msg_status']='Delivered';
								                            $store_data[$key]['is_send']=1;											  
														} else {											$active_one++;
                                                            
																$save['msg_status']='failure';
																$save['is_send']=0;			
														}                                                       
                                                      
                                                }
                                            }
                                            } else { 
                                                    if(isset($save['schedule_date'])) {
														
														$datedata =$save['schedule_date'];
													    echo $dated= strtotime($datedata);
													
                                                        $date=explode(" ",$save['schedule_date']);
                                                        $s_data=$date[0]."%20".$date[1];
                                                        if($get_user_list['status_one']=='Active') { 
                                                          
                                                            $upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
                                                            $save['api_name']='one';
                                                        }
                                                        if($get_user_list['status_two']=='Active') { 
                                                            $save['api_name']='two';
                                                            $username =$api_username;
															$hash = $api_hash;
															$numbers = $number;
															$sender = $api_sender;
															$message = $message;
															$schedule_time=$dated;
															$data1 = array('username' => $username, 'hash' => $hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message, "schedule_time" => $dated,'unicode'=>$language=='hindi'?1:0);
														  $json = send_sms($data1, $save);
                                                          $save['api_name']='two';
														 if($json['status']=='success')
														{
								                              $store_data[$key]['msg_status']='Scheduled';
								                              $store_data[$key]['is_send']=2;						  
														}
														else 
														{		$active_one++;			
																$store_data[$key]['msg_status']='failure';
																$store_data[$key]['is_send']=0;
																
														}
															
														}																		
													}
												}
                                              $count++;  
                                        //==============================================================================//

												$store_data[$key]=$save;
                                          
								}
								
								if(isset($store_data)) {
                                    if($get_user_list['status_one']=='Active') {                                   
                                    $this->db->insert_batch(SMS_LOG_ONE,$store_data);
                                } else {
									$this->db->insert_batch(SMS_LOG,$store_data);
                                }
								}
                                          
                              //  }
                           
                                if($json['status']=='failure' || $active_one>0) {
                                      $this->session->set_flashdata('error', $active_one.' Mobile numbers had error while sending sms from '.$count.' numbers!!');
                                      redirect($this->config->item('admin_folder').'/send/class_sms');
                                } 
								else {
                                        
									$this->session->set_flashdata('success', 'Message send succesfully' );
                                          redirect($this->config->item('admin_folder').'/send/class_sms');
                                }
                    }
		$this->load->view($this->config->item('admin_folder').'/sendsms_class', $data);
        }


        function unique_multi_array($array, $key) { 
        $temp_array = array(); 
        $i = 0; 
        $key_array = array(); 
  
       foreach($array as $val) { 
       if (!in_array($val[$key], $key_array)) { 
          $key_array[$i] = $val[$key]; 
          $temp_array[$i] = $val; 
       } 
       $i++; 
       } 
       return $temp_array; 
       }
        }
		?>