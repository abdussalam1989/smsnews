
<?php
class Sender extends CI_Controller {
    
	function __construct()
	{
		parent::__construct();
		$this->load->library('auth');
		//ini_set('max_execution_time', 90000);
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '-1'); 
		$this->load->model('Data_model');
		
		$redirect = $this->auth->is_logged_in();
		if ($redirect == false) {
			$this->session->set_userdata("redirect", current_url());
			redirect($this->config->item('admin_folder').'/login');
		}
                //header( 'Content-Type: text/html; charset=utf-8' ); 
        }
        
        function index($tiny_url='')
        {  
				//date_default_timezone_set('Asia/Kolkata');
				//echo date('H:i:s');  exit;
                $data['tiny_url']=$tiny_url;
                $data['page_title']='Send SMS';
                $admin=$this->session->userdata();
                $user_id=$admin['user_id'];
                $user=$admin['logint_type'];           
                $data['get_msg_for']=  get_listt(SMS_FOR_LIST);
                $data['get_api_status']=$this->Data_model->get_api_status($user_id);
                $data['get_sms_template']=get_list_by_user_id($user_id,SMS_TEMPLATE);
                $data['get_list']=get_sms_list($user_id,'Anyone');
                //$data['get_list']=get_list(SMS_LOG);
                $data['total_msg']=count($data['get_list']);                
                    if(isset($_POST['submit']))
                    {
                        $save['mobile_no']=$this->input->post('mobile_no',TRUE);
                        $save['message']=$this->input->post('message',TRUE);
                        $save['msg_for']=$this->input->post('msg_for',TRUE);
                        $save['user_id']=$user_id;
                        $save['send_sms_type']='Anyone';
                        $save['sms_type']=$this->input->post('sms_type',TRUE);
                        if($save['msg_for']!='None'){    
                            //for send sms data
                            $message="Dear ".$save['msg_for'].", ".$save['message'];
                            //$message=urlencode($message);
                            // $source=mb_convert_encoding($message, 'UTF-16LE', 'UTF-8');
                            //$message=utf8_encode($message);
                            //$message = str_replace(' ', '%20', $message);
                          $save['message']=$message;
						  
                            $message=urlencode($message);
                            // $message=$message;
                            // echo $message; exit;
                        } else {
                           // $msg=$save['message'];
                           $message=urlencode($save['message']);
                           // $source=mb_convert_encoding($msg, 'UTF-16LE', 'UTF-8');
                           // print_r($save['message']); exit;
                        }
                        
                        $path_link='';
                        $mobile_no=$save['mobile_no'];
					   	echo $result = count($mobile_no);
					 
					 
					 if($result >50) {
                               
								$this->session->set_flashdata('error', 'Error while Sending sms no of msg is grater then 50 please select only 50 students!!' );
								redirect($this->config->item('admin_folder').'/send');
								exit;
						}
				
					  
                        //$mobile_no=''; $s_data=""; $smscode='';
                        $get_user_list=get_list_by_id($user_id, USERS);
                        
                      /* if($get_user_list['status_one']=='Active') {
                                $api_username=$get_user_list['username_one'];
                                $api_password=$get_user_list['password_one'];
                                $api_sender=$get_user_list['senderid_one'];
                                $api_type=$get_user_list['smstype_one'];
                                $api_priority=$get_user_list['prioritydetails_one'];
                                $api_schedule_link=API1_SCHEDULE_LINK;
                                $api_instant_link=API1_INSTANT_LINK;
                                $api_status_link=API1_GETSTATUS_LINK;
                                //$schedule_link=$api_schedule_link.'user='.$api_username.'&pass='.$api_password.'&sender='.$api_sender.'&phone='.$mobile_no.'&text='.$message.'&priority='.$api_priority.'&stype='.$api_type.'&time='.$s_data;
                                //$instant_link=$api_instant_link.'user='.$api_username.'&pass='.$api_password.'&sender='.$api_sender.'&phone='.$mobile_no.'&text='.$message.'&priority='.$api_priority.'&stype='.$api_type;
                                //$status_link=$api_status_link.'user='.$api_username.'&msgid='.$smscode.'&phone='.$mobile_no.'&msgtype='.$api_type;
                        }
                        if($get_user_list['status_two']=='Active') {
                                $api_username=$get_user_list['username_two'];
                                $api_hash=$get_user_list['api_two_hash'];
                                $api_sender=$get_user_list['senderid_two'];
                                //$api_type=$get_user_list['smstype_two'];
                                //$api_priority=$get_user_list['prioritydetails_two'];
                                $api_schedule_link=API2_INSTANT_LINK;
                                //$instant_link=$api_schedule_link.'username='.$api_username.'&pass='.$api_hash.'&numbers='.$mobile_no.'&sender='.$api_sender.'&message='.$message;
                        }
                        
                        if(isset($api_username)) {
                            if(empty($api_username)) {
                                    $this->session->set_flashdata('error', 'API Username is not set!!' );
                                    redirect($this->config->item('admin_folder').'/send');
                            }
                        }
                        
                        if(isset($api_password))    { 
                            if(empty($api_password)) {
                                    $this->session->set_flashdata('error', 'API Password is not set !!' );
                                    redirect($this->config->item('admin_folder').'/send');
                            }
                        }
                        
                        if(isset($api_sender)){
                            if(empty($api_sender)) {
                                $this->session->set_flashdata('error', 'API Sender id is not set!!' );
                                redirect($this->config->item('admin_folder').'/send');                            
                            }                        
                        }
                        
                        if(isset($api_type)){
                            if(empty($api_type)) {
                                $this->session->set_flashdata('error', 'API SMS type is not set!!' );
                                redirect($this->config->item('admin_folder').'/send');
                            }
                        }
                        
                        if(isset($api_priority)) {
                            if(empty($api_priority)) {
                                $this->session->set_flashdata('error', 'API Priority is not set!!' );
                                redirect($this->config->item('admin_folder').'/send');
                            }
                        }
                        
                        if(isset($api_hash)) {
                            if(empty($api_hash)) {
                                $this->session->set_flashdata('error', 'API Hash is not set!!' );
                                redirect($this->config->item('admin_folder').'/send');
                            }
                        }
                        
                       * 
                       */
                        if($save['sms_type']=='Schedule')
                        {   
                            $save['schedule_date']=$this->input->post('schedule_date',TRUE);
                            $save['sms_type']='Schedule';
                            $save['msg_status']='Delivered';
                                
                        }  else  {
                                $save['sms_type']='Instant';
                        } 
                            $msg_value=strlen($save['message']);
                            $total_msg=$msg_value/160;
                            $total_val=ceil($total_msg);
                            $save['count_msg']=$total_val;
                            $master_id=insert_record(SMS_LOG_MASTER, $save);                             
                            
                            $mobile_number=$save['mobile_no'];
                            $mb_no=explode(",",$mobile_number);
                            $save['masterlog_id']=$master_id;
                            $date=get_current_date_time();
                            $save['addtime']=date("H:i:s",strtotime($date));
                            $save['adddate']=date("Y-m-d",strtotime($date));
                            
                                foreach($mb_no as $key=>$value)
                                {
                                    $mobile_no=$value;
                                    if($save['sms_type'] !='Schedule') {
                                        if($get_user_list['status_one']=='Active') {
                                            
                                            $save['api_name']='one';
                                               // $link=$api_instant_link.'user='.$api_username.'&pass='.$api_password.'&sender='.$api_sender.'&phone='.$mobile_no.'&text='.$message.'&priority='.$api_priority.'&stype='.$api_type;
                                                //$link=$instant_link;
                                                //echo $link; exit;
                                                //$send_sms=call_send_sms_link($link);
                                                //$save['send_sms_id']=$send_sms;
                                                //$smscode=urlencode($send_sms);
                                              /*  if(!empty($smscode)) {
                                                    $check_status=$api_status_link.'user='.$api_username.'&msgid='.$smscode.'&phone='.$mobile_no.'&msgtype='.$api_type;
                                                    // $check_status=$status_link;
                                                    $sms_status=call_send_sms_link($check_status);
                                                    //S.90271 DELIVRD1
                                                    if(strpos($sms_status, 'DELIVRD') !== false ) {
                                                        $sms_status="Delivered";
                                                    } else {
                                                        $sms_status=$sms_status;
                                                    }
                                                    /*$arr_sms_status = explode(" ",$sms_status);
                                                    echo '<pre>';
                                                    print_r($arr_sms_status);
                                                    exit;
                                                   // $save['msg_status']=$sms_status; 
                                                } */
                                              //  unset($link); unset($check_status);
                                                $upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
                                        }
                                        
                                    if($get_user_list['status_two']=='Active') {    
                                            $save['api_name']='two';
                                           /* $link=$api_schedule_link.'username='.$api_username.'&hash='.$api_hash.'&numbers=91'.$mobile_no.'&sender='.$api_sender.'&message='.$message;
                                            // echo $link; exit;
                                            $send_sms=call_send_sms_link($link);                                            
                                            $send_report=json_decode($send_sms);
                                            // print_r($send_report['status']); exit;
                                            if($send_report['status']=='success'){
                                                $save['msg_status']='Delivered';
                                            }
                                            $save['msg_status']='Delivered';*/
                                            $upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
                                        }
                                    }  else {
                                        if(isset($save['schedule_date'])) {
                                            $date=explode(" ",$save['schedule_date']);
                                            $s_data=$date[0]."%20".$date[1];
                                            if($get_user_list['status_one']=='Active') { 
                                               // $link=$api_schedule_link.'user='.$api_username.'&pass='.$api_password.'&sender='.$api_sender.'&phone='.$mobile_no.'&text='.$message.'&priority='.$api_priority.'&stype='.$api_type.'&time='.$s_data;
                                                $save['api_name']='one';
                                                $upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
                                            }
                                            if($get_user_list['status_two']=='Active') { 
                                               // $link=$api_schedule_link.'username='.$api_username.'&hash='.$api_hash.'&numbers=91'.$mobile_no.'&sender='.$api_sender.'&message='.$message.'&time='.$s_data;
                                                $save['api_name']='two';
                                                $upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
                                            }
                                            //$link=$schedule_link;
                                           // $send_sms=send_schedule_sms($link);
                                            $save['schedule_date']=$send_sms;
                                        }
                                    }
                                    
                                    $save['msg_status']='Submitted';
                                    update_record($upd,$user_id,USERS);
                                    $save['mobile_no']=$value;
                                    
                                    if(!empty($value)){
                                        $add=insert_record(SMS_LOG,$save);                                    
                                    } else {
                                        $add=true;
                                    }
                                    // echo $this->db->last_query(); exit;                                    
                                }
                                
                                if($add) {
                                        $this->session->set_flashdata('success', 'Message send succesfully' );
                                        redirect($this->config->item('admin_folder').'/send');
                                } else  {
                                        $this->session->set_flashdata('error', 'Error while Sending sms !!' );
                                        redirect($this->config->item('admin_folder').'/send');
                                }
                        }
            	$this->load->view($this->config->item('admin_folder').'/sendsms_any', $data);
        }
        
        function stud()
        {
			$admin=$this->session->userdata();
			//$data['mode']=ADMIN_URL.'/send/stud';
			$user_id=$admin['user_id'];
			$user=$admin['logint_type'];
			$field='user_id';
			//$data['get_student_list']=get_list_by_idd($user_id,$field,STUDENT);
			$data['get_msg_for']=get_listt(SMS_FOR_LIST);
			$data['get_api_status']=$this->Data_model->get_api_status($user_id);
			$data['get_class_list']=get_list_by_user_id($user_id,CLASSES);
			$data['get_sms_template']=get_list_by_user_id($user_id,SMS_TEMPLATE);
			$data['page_title']='SMS To Student';
			//$data['get_list']=get_sms_list($user_id,'Student');
			//$data['get_list']=$this->Data_model->get_student_details($user_id,'Student');
			
			//$data['get_list']=get_list(SMS_LOG);
		     $data['total_msg']=count($data['get_list']);
		
			
				if(isset($_POST['submit']))
				{
					$save['mobile_no']=$this->input->post('mobile_no',TRUE);
				 	$save['admission_no']=$this->input->post('admission_no',TRUE);
			
					$s_message=$this->input->post('message',TRUE);
					$save['sms_type']=$this->input->post('sms_type',TRUE);
					$save['msg_for']=$this->input->post('msg_for',TRUE);
					$save['user_id']=$user_id;
					$save['send_sms_type']='Student';  
				   
					$path_link='';
					 $admission_no=$save['admission_no'];
					
					 $msg_value=strlen($s_message);
						
					 $total_msg=$msg_value/160;
					
					$total_val=ceil($total_msg);
					$save['count_msg']=$total_val;
					
					/*$numbers_array=extract_numbers($save['admission_no']);
					$numbers=implode(",",$numbers_array);
					$save['admission_no']=$numbers;*/
					
					
					 $mobile_numbers_array=extract_numbers($save['mobile_no']);
					
			
					 
					 
				
					
					$mobile_numbers=implode(",",$mobile_numbers_array);
					$save['mobile_no']=$mobile_numbers;
					 
					$get_user_list=get_list_by_id($user_id, USERS);
										
					//for send sms data
					$admission_no=$mobile_numbers;
					
					
					
					
					
					if($save['sms_type']=='Schedule') { 
						$save['schedule_date']=$this->input->post('schedule_date',TRUE);
						$save['sms_type']='Schedule';
						$save['msg_status']='Delivered';
					} else {
						$save['sms_type']='Instant';
					}
						$master_id=insert_record(SMS_LOG_MASTER, $save);
						$mobile_number=$save['admission_no'];
						$mb_no=explode(",",$mobile_number);
						$save['masterlog_id']=$master_id;
						
						$date=get_current_date_time();
						$save['addtime']=date("H:i:s",strtotime($date));
						$save['adddate']=date("Y-m-d",strtotime($date));
						/*echo "<pre>";
						print_r($save);
						echo "</pre>"; die;*/
						
						foreach($mb_no as $key=>$value)
						{   
							if($save['msg_for']!='None'){    
								$msg=$s_message;
								$message="Dear ".$save['msg_for'].", ".$msg;
							} else {
								$msg=$s_message;
								$message=$msg;
							}
								$student_info=get_detalis_for_message('admission_no',$value,'user_id',$user_id,STUDENT);
								if(!$student_info){
									$student_info=get_detalis_for_message('alternate_no',$value,'user_id',$user_id,STUDENT);
								}
								/*echo "<pre>";
								print_r($student_info);
								echo "</pre>"; */
								
								if(strrchr($message,"[todaydate]")){
									$arr['[todaydate]']=date('d-m-Y');
								}
								if(strrchr($message,"[name]")){
									$arr['[name]']=$student_info['name'];
								}
								if(strrchr($message,"[class]")){
									$arr['[class]']=$student_info['class_name'];
								}
								if(strrchr($message,"[rollno]")){
									$arr['[rollno]']=$student_info['roll_no']; 
								}
								
								/*echo "<pre>";
								print_r($arr);
								echo "</pre>";  */
																
								$message_test=replace_string_using_array($arr,$message);
								if($message_test==FALSE){
									$save['message']=$message;
								   
									$message=urlencode($message);
								} else {
									$save['message']=$message_test;
									$message=urlencode($message_test);
									//echo "this is else condition"; exit;
								}
								unset($arr);
								
							$save['stud_id']=$student_info['id'];
							$save['mobile_no']=$student_info['mobile_no'];
							$admission_no=$value;
							if($save['sms_type'] !='Schedule') {
								if($get_user_list['status_one']=='Active') {
										$save['api_name']='one';
										$upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
								}

								if($get_user_list['status_two']=='Active') {   
										$save['api_name']='two';
										$upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
								}
							} else {
								 if(isset($save['schedule_date'])) {
									$date=explode(" ",$save['schedule_date']);
									$s_data=$date[0]."%20".$date[1];
									if($get_user_list['status_one']=='Active') {                                   
										$upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
										$save['api_name']='one';
									}
									if($get_user_list['status_two']=='Active') { 
										$upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
										$save['api_name']='two';
									}
									$save['schedule_date']=$send_sms;
								}   
							}
								$save['msg_status']='Submitted';
								update_record($upd, $user_id, USERS);
								$admission_no=$result=substr($value,0,10);
								$save['admission_no']=$admission_no;
								
								/*echo "<pre>";
								print_r($value);
								echo "</pre>";*/
								
								
								if(!empty($value)){
									//echo "AFtab";die;
									$add=insert_record(SMS_LOG,$save);                                    
								} else {
									$add=true;
								}
								
						}
						
						/*foreach($mb_no as $key=>$value)
						{   
							if($save['msg_for']!='None'){    
								$msg=$s_message;
								$message="Dear ".$save['msg_for'].", ".$msg;
							} else {
								$msg=$s_message;
								$message=$msg;
							}
								$student_info=get_detalis_for_message('mobile_no',$value,'user_id',$user_id,STUDENT);
								if(!$student_info){
									$student_info=get_detalis_for_message('alternate_no',$value,'user_id',$user_id,STUDENT);
								}
								
								if(strrchr($message,"[todaydate]")){
									$arr['[todaydate]']=date('d-m-Y');
								}
								if(strrchr($message,"[name]")){
									$arr['[name]']=$student_info['name'];
								}
								if(strrchr($message,"[class]")){
									$arr['[class]']=$student_info['class_name'];
								}
								if(strrchr($message,"[rollno]")){
									$arr['[rollno]']=$student_info['roll_no'];
								}
								
								echo "<pre>";
								print_r($arr);
								echo "</pre>";
																
								$message_test=replace_string_using_array($arr,$message);
								if($message_test==FALSE){
									$save['message']=$message;
								   
									$message=urlencode($message);
								} else {
									$save['message']=$message_test;
									$message=urlencode($message_test);
									//echo "this is else condition"; exit;
								}
								unset($arr);
							$save['stud_id']=$student_info['id'];
							$mobile_no=$value;
							if($save['sms_type'] !='Schedule') {
								if($get_user_list['status_one']=='Active') {
										$save['api_name']='one';
										$upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
								}

								if($get_user_list['status_two']=='Active') {   
										$save['api_name']='two';
										$upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
								}
							} else {
								 if(isset($save['schedule_date'])) {
									$date=explode(" ",$save['schedule_date']);
									$s_data=$date[0]."%20".$date[1];
									if($get_user_list['status_one']=='Active') {                                   
										$upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
										$save['api_name']='one';
									}
									if($get_user_list['status_two']=='Active') { 
										$upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
										$save['api_name']='two';
									}
									$save['schedule_date']=$send_sms;
								}   
							}
								$save['msg_status']='Submitted';
								update_record($upd, $user_id, USERS);
								$mobile_no=$result=substr($value,0,10);
								$save['mobile_no']=$mobile_no;
								
								if(!empty($value)){
									$add=insert_record(SMS_LOG,$save);                                    
								} else {
									$add=true;
								}
								
						}*/
								
						if($add){
								$this->session->set_flashdata('success', 'Message send succesfully' );
								redirect($this->config->item('admin_folder').'/send/stud');
						} else {
								$this->session->set_flashdata('error', 'Error while Sending sms !!' );
								redirect($this->config->item('admin_folder').'/send/stud');
						}
					}
			$this->load->view($this->config->item('admin_folder').'/sendsms_student', $data);
        }
		
		
		
		
		
		
        
        function ajax_send_student(){
                
            $admin=$this->session->userdata();
                $user_id=$admin['user_id'];
                  // DB table to use
                $table = SMS_LOG;

                // Table's primary key
                $primaryKey = 'id';
                
                /*  <th WIDTH="8%">SMS STATUS</th>
                                <th>DATE</th>
                                <th>TIME</th>
                                <th width="10%"> Roll NO.</th>
                                <th>CLASS NAME</th>
                                <th width="20%">MESSAGE</th>  
                                <th>MOBILE NO.</th>
                                <th>MSG COUNT</th>*/ 
                $columns = array(                
                array( 'db' => '`sl`.`msg_status`', 'dt' => 0, 'field' => 'msg_status' ),
                array( 'db' => '`sl`.`adddate`', 'dt' => 1, 'field' => 'adddate' ),
                array( 'db' => '`sl`.`addtime`', 'dt' => 2, 'field' => 'addtime' ),
                array( 'db' => '`st`.`roll_no`','dt' => 3,'field' => 'roll_no' ),
                array( 'db' => '`st`.`class_name`','dt' => 4,'field' => 'class_name' ),
                array( 'db' => '`sl`.`message`', 'dt' => 5, 'field' => 'message' ),
                array( 'db' => '`sl`.`mobile_no`', 'dt' => 6, 'field' => 'mobile_no' ),
                array( 'db' => '`sl`.`count_msg`', 'dt' => 7, 'field' => 'count_msg' ),
                );

                // SQL server connection information
                $sql_details = array(
                    'user' => $this->db->username,
                    'pass' => $this->db->password,
                    'db'   => $this->db->database,
                    'host' => $this->db->hostname
                );

                $send_sms_type='Student';
                //require('ssp.class.php');
                $this->load->library('Ssp.php');
                // $joinQuery = "FROM `sms_log` AS `sl` JOIN `student` AS `st` ON `sl`.`user_id`=$user_id and `sl`.`mobile_no` = `st`.`mobile_no` ";
                //$joinQuery = "FROM `sms_log` AS `sl` JOIN `student` AS `st` ON  `sl`.`stud_id` = `st`.`id` WHERE `sl`.`send_sms_type`='".$send_sms_type."' AND `st`.`user_id`='".$user_id."'  ";
                
                $joinQuery = "FROM sms_log AS sl JOIN student AS st ON st.id=sl.stud_id";
                //$extraWhere="sl.send_sms_type='".$send_sms_type."' AND st.user_id='".$user_id."' ORDER BY sl.id DESC";
                $extraWhere="sl.send_sms_type='".$send_sms_type."' AND st.user_id='".$user_id."' ORDER BY sl.id DESC";
                
                //sl.user_id='".$user_id."' ORDER BY sl.id DESC
                //SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery,$extraWhere)
                echo json_encode(
                    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery,$extraWhere)
                );
        }
        
        function allstudents()
        {
            $data['page_title']= 'SMS To All Student';
            $admin=$this->session->userdata();
            $user_id=$admin['user_id'];
            $user=$admin['logint_type'];              
            $data['get_sms_template']=get_list_by_user_id($user_id,SMS_TEMPLATE);
            $data['get_list']=get_sms_list($user_id,'allstudents');
            $data['total_msg']=count($data['get_list']);
            
                    if(isset($_POST['submit']))
                    {
                        //$save['mobile_no']=$this->input->post('mobile_no',TRUE);
                        $s_message=$this->input->post('message',TRUE);
                        //$save['msg_for']=$this->input->post('msg_for',TRUE);
                        $save['user_id']=$user_id;
                        $save['send_sms_type']='allstudents';
                        $save['sms_type']=$this->input->post('sms_type',TRUE);
                        $check_alt=$this->input->post('alt_check',TRUE);
                        
                            $get_user_list=get_list_by_id($user_id, USERS);
                           /* if($get_user_list['status_one']=='Active') {
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
                            
                            $path_link='';
                            if(isset($api_username)) {
                            if(empty($api_username)) {
                                            $this->session->set_flashdata('error', 'API Username is not set!!' );
                                            redirect($this->config->item('admin_folder').'/send/allstudents');
                                    }
                                }

                                if(isset($api_password)){ 
                                    if(empty($api_password)) {
                                            $this->session->set_flashdata('error', 'API Password is not set !!' );
                                            redirect($this->config->item('admin_folder').'/send/allstudents');
                                    }
                                }

                                if(isset($api_sender)){
                                    if(empty($api_sender)) {
                                        $this->session->set_flashdata('error', 'API Sender id is not set!!' );
                                        redirect($this->config->item('admin_folder').'/send/allstudents');                            
                                    }                        
                                }

                                if(isset($api_type)){
                                    if(empty($api_type)) {
                                        $this->session->set_flashdata('error', 'API SMS type is not set!!' );
                                        redirect($this->config->item('admin_folder').'/send/allstudents');
                                    }
                                }

                                if(isset($api_priority)) {
                                    if(empty($api_priority)) {
                                        $this->session->set_flashdata('error', 'API Priority is not set!!' );
                                        redirect($this->config->item('admin_folder').'/send/allstudents');
                                    }
                                }

                                if(isset($api_hash)) {
                                    if(empty($api_hash)) {
                                        $this->session->set_flashdata('error', 'API Hash is not set!!' );
                                        redirect($this->config->item('admin_folder').'/send/allstudents');
                                    }
                                }
                            */
                            
                            if($save['sms_type']=='Schedule')
                            {   
                                $save['schedule_date']=$this->input->post('schedule_date',TRUE);
                                $save['sms_type']='Schedule';
                                //$save['msg_status']='Delivered';
                            }  else {
                                $save['sms_type']='Instant';
                            }       
                                    $msg_value=strlen($s_message);
                                    $total_msg=$msg_value/160;
                                    $total_val=ceil($total_msg);
                                    $save['count_msg']=$total_val;
                                    $master_id=insert_record(SMS_LOG_MASTER, $save);
                                        //echo $this->db->last_query(); exit;
                                        $save['masterlog_id']=$master_id;
                                        
                                        $date=get_current_date_time();
                                        $save['addtime']=date("H:i:s",strtotime($date));
                                        $save['adddate']=date("Y-m-d",strtotime($date));

                                        $field='user_id';
                                        $get_student_list=get_list_by_idd($user_id,$field,STUDENT);
                                        
                                        // $cnt=1;
                                        foreach ($get_student_list as $student_list)
                                        {
                                            if($save['msg_for']!='None'){    
                                                $msg=$s_message;
                                                if($get_user_list['status_one']=='Active') {
                                                    $message=$s_message;
                                                }
                                                if($get_user_list['status_two']=='Active') {
                                                    $message="Dear Parent, ".$msg;
                                                }
                                            } else {
                                                $message=$s_message;
                                            }
                                            if(strrchr($message,"[todaydate]")){
                                                $arr['[todaydate]']=date('d-m-Y');
                                            }
                                            if(strrchr($message,"[name]")){
                                                $arr['[name]']=$student_list['name'];
                                            }
                                            if(strrchr($message,"[class]")){
                                                $arr['[class]']=$student_list['class_name'];
                                            }
                                            if(strrchr($message,"[rollno]")){
                                                $arr['[rollno]']=$student_list['roll_no'];
                                            }
                                            $message_test=replace_string_using_array($arr,$message);
                                            if($message_test==FALSE){
                                                $save['message']=$message;
                                                $message=urlencode($message);
                                            } else {
                                                $save['message']=$message_test;
                                                $message=urlencode($message_test);
                                                //echo "this is else condition"; exit;
                                            }
                                            unset($arr);
                                            $save['stud_id']=$student_list['id'];
                                            //echo '<pre>';
                                            // print_r($student_list);
                                            //log_message('error', $student_list);
                                            $mobile_no=$student_list['mobile_no'];
                                                if($save['sms_type'] !='Schedule') {
                                                if($get_user_list['status_one']=='Active') {
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
                                                        }*/
                                                        // unset($link); unset($check_status);
                                                        $save['api_name']='one';
                                                        $upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
                                                }
                                                   // log_message('error', 'pre if ' .$cnt);
                                                    if($get_user_list['status_two']=='Active') {    
                                                           /* $link=$api_schedule_link.'username='.$api_username.'&hash='.$api_hash.'&numbers=91'.$mobile_no.'&sender='.$api_sender.'&message='.$message;
                                                            $send_sms=call_send_sms_link($link);    
                                                            // log_message('error', 'if tst pratik' .$cnt);
                                                            $send_report=json_decode($send_sms);
                                                            if($send_report['status']=='success'){
                                                                $save['msg_status']='Delivered';
                                                            }*/
                                                            //$save['msg_status']='Delivered';
                                                            $upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
                                                            $save['api_name']='two';
                                                    }
                                                    //log_message('error', 'out if pratik' .$cnt);
                                                    
                                                } else {
                                                    
                                                    if(isset($save['schedule_date'])) {
                                                        $date=explode(" ",$save['schedule_date']);
                                                        $s_data=$date[0]."%20".$date[1];
                                                        if($get_user_list['status_one']=='Active') { 
                                                            //$link=$api_schedule_link.'user='.$api_username.'&pass='.$api_password.'&sender='.$api_sender.'&phone='.$mobile_no.'&text='.$message.'&priority='.$api_priority.'&stype='.$api_type.'&time='.$s_data;                                        
                                                            $upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
                                                            $save['api_name']='one';
                                                        }
                                                        if($get_user_list['status_two']=='Active') { 
                                                           // $link=$api_schedule_link.'username='.$api_username.'&hash='.$api_hash.'&numbers=91'.$mobile_no.'&sender='.$api_sender.'&message='.$message.'&time='.$s_data;
                                                            $upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
                                                            $save['api_name']='two';
                                                        }
                                                        //$send_sms=send_schedule_sms($link);
                                                        $save['schedule_date']=$send_sms;
                                                    }  
                                                }
                                                $save['msg_status']='Submitted';
                                                update_record($upd, $user_id, USERS);
                                                
                                                if($check_alt){
                                                    $save['mobile_no']=$student_list['alternate_no'];
                                                    if(!empty($save['mobile_no'])){
                                                        insert_record(SMS_LOG,$save);                                    
                                                    }
                                                }
                                                
                                                $save['mobile_no']=$student_list['mobile_no'];
                                                $mobile_no_arr[]=$student_list['mobile_no'];
                                                
                                                if(!empty($save['mobile_no'])){
                                                    $add=insert_record(SMS_LOG,$save);                                    
                                                } else {
                                                    $add=true;
                                                }
                                                //$add=insert_record(SMS_LOG,$save); 
                                                //echo $this->db->last_query(); exit;
                                                //$cnt++;
                                                
                                        }
                                        $mobile_numer=implode(",",$mobile_no_arr);
                                        $savedata['mobile_no']=$mobile_numer;
                                        update_record($savedata,$master_id , SMS_LOG_MASTER);
                                        if($add) {
                                                    $this->session->set_flashdata('success', 'Message send succesfully' );
                                                    redirect($this->config->item('admin_folder').'/send/allstudents');
                                        } else {
                                                    $this->session->set_flashdata('error', 'Error while Sending sms !!' );
                                                    redirect($this->config->item('admin_folder').'/send/allstudents');
                                        }
                    }
                    
               
                    
            $this->load->view($this->config->item('admin_folder').'/sendsms_allstudent', $data);
        }    
        
        function ajaxstudent(){
                
            $admin=$this->session->userdata();
                $user_id=$admin['user_id'];
                  // DB table to use
                $table = SMS_LOG;

                // Table's primary key
                $primaryKey = 'id';
                
                /*  <th WIDTH="8%">SMS STATUS</th>
                                <th>DATE</th>
                                <th>TIME</th>
                                <th width="10%"> Roll NO.</th>
                                <th>CLASS NAME</th>
                                <th width="20%">MESSAGE</th>  
                                <th>MOBILE NO.</th>
                                <th>MSG COUNT</th>*/ 
                
                $columns = array(                
                array( 'db' => '`sl`.`msg_status`', 'dt' => 0, 'field' => 'msg_status' ),
                array( 'db' => '`sl`.`adddate`', 'dt' => 1, 'field' => 'adddate' ),
                array( 'db' => '`sl`.`addtime`', 'dt' => 2, 'field' => 'addtime' ),
                array( 'db' => '`st`.`roll_no`','dt' => 3,'field' => 'roll_no' ),
                array( 'db' => '`st`.`class_name`','dt' => 4,'field' => 'class_name' ),
                array( 'db' => '`sl`.`message`', 'dt' => 5, 'field' => 'message' ),
                array( 'db' => '`sl`.`mobile_no`', 'dt' => 6, 'field' => 'mobile_no' ),
                array( 'db' => '`sl`.`count_msg`', 'dt' => 7, 'field' => 'count_msg' ),
                );

                // SQL server connection information
                $sql_details = array(
                    'user' => $this->db->username,
                    'pass' => $this->db->password,
                    'db'   => $this->db->database,
                    'host' => $this->db->hostname
                );

                $send_sms_type='allstudents';
                //require('ssp.class.php');
                $this->load->library('Ssp.php');
                // $joinQuery = "FROM `sms_log` AS `sl` JOIN `student` AS `st` ON `sl`.`user_id`=$user_id and `sl`.`mobile_no` = `st`.`mobile_no` ";
                //$joinQuery = "FROM `sms_log` AS `sl` JOIN `student` AS `st` ON  `sl`.`stud_id` = `st`.`id` WHERE `sl`.`send_sms_type`='".$send_sms_type."' AND `st`.`user_id`='".$user_id."'  ";
                
                $joinQuery = "FROM sms_log AS sl JOIN student AS st ON st.id=sl.stud_id";
                //$extraWhere="sl.send_sms_type='".$send_sms_type."' AND st.user_id='".$user_id."' ORDER BY sl.id DESC";
                $extraWhere="sl.send_sms_type='".$send_sms_type."' AND st.user_id='".$user_id."' ORDER BY sl.id DESC";
                
                //sl.user_id='".$user_id."' ORDER BY sl.id DESC
                //SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery,$extraWhere)
                echo json_encode(
                    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery,$extraWhere)
                );
        }
                
        function teacher()
        {
                $data['page_title']= 'SMS To Teacher';
                $admin=$this->session->userdata();
                //$data['mode']=ADMIN_URL.'/send/stud';
                $user_id=$admin['user_id'];
                $user=$admin['logint_type'];
                $data['get_msg_for']=get_listt(SMS_FOR_LIST);
                $data['get_api_status']=$this->Data_model->get_api_status($user_id);
                $data['get_teacher_list']=get_list_by_user_id($user_id,CLASS_TEACHER);
                $data['get_sms_template']=get_list_by_user_id($user_id,SMS_TEMPLATE);
                $data['get_list']=get_sms_list($user_id,'Teacher');
                //$data['get_list']=get_list(SMS_LOG);
                $data['total_msg']=count($data['get_list']);
                    if(isset($_POST['submit']))
                    {
                        $save['mobile_no']=$this->input->post('mobile_no',TRUE);
                        $s_message=$this->input->post('message',TRUE);
                        $save['sms_type']=$this->input->post('sms_type',TRUE);
                        $save['msg_for']=$this->input->post('msg_for',TRUE);
                        $save['user_id']=$user_id;
                        $save['send_sms_type']='Teacher';
                        /*if($save['msg_for']!='None'){    
                            //for send sms data
                            $message="Dear ".$save['msg_for'].", ".$save['message'];
                            //$message = str_replace(' ', '%20', $message);
                            $message=urlencode($message);
                            $message=$message;
                        } else {
                            $message=urlencode($save['message']);
                        }*/
                                    $path_link='';
                                    $mobile_no=$save['mobile_no'];
                                    $msg_value=strlen($s_message);
                                    $total_msg=$msg_value/160;
                                    $total_val=ceil($total_msg);
                                    $save['count_msg']=$total_val;
                                    $numbers_array=extract_numbers($save['mobile_no']);
                                    $numbers=implode(",",$numbers_array);
                                    $save['mobile_no']=$numbers;
                                    $master_id=insert_record(SMS_LOG_MASTER, $save);
                                    
                                    $get_user_list=get_list_by_id($user_id, USERS);
                                   /* if($get_user_list['status_one']=='Active') {
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
                                                $this->session->set_flashdata('error', 'API Username is not set!!' );
                                                redirect($this->config->item('admin_folder').'/send/teacher');
                                        }
                                    }

                                    if(isset($api_password)){ 
                                        if(empty($api_password)) {
                                                $this->session->set_flashdata('error', 'API Password is not set !!' );
                                                redirect($this->config->item('admin_folder').'/send/teacher');
                                        }
                                    }

                                    if(isset($api_sender)){
                                        if(empty($api_sender)) {
                                            $this->session->set_flashdata('error', 'API Sender id is not set!!' );
                                            redirect($this->config->item('admin_folder').'/send/teacher');                            
                                        }                        
                                    }

                                    if(isset($api_type)){
                                        if(empty($api_type)) {
                                            $this->session->set_flashdata('error', 'API SMS type is not set!!' );
                                            redirect($this->config->item('admin_folder').'/send/teacher');
                                        }
                                    }

                                    if(isset($api_priority)) {
                                        if(empty($api_priority)) {
                                            $this->session->set_flashdata('error', 'API Priority is not set!!' );
                                            redirect($this->config->item('admin_folder').'/send/teacher');
                                        }
                                    }

                                    if(isset($api_hash)) {
                                        if(empty($api_hash)) {
                                            $this->session->set_flashdata('error', 'API Hash is not set!!' );
                                            redirect($this->config->item('admin_folder').'/send/teacher');
                                        }
                                    }*/
                                    
                                    if($save['sms_type']=='Schedule')
                                    {   
                                        $save['schedule_date']=$this->input->post('schedule_date',TRUE);
                                        $save['sms_type']='Schedule';
                                        $save['msg_status']='Delivered';
                                    }  else {
                                        $save['sms_type']='Instant';
                                    } 
                                    
                                        $mobile_number=$save['mobile_no'];
                                        $mb_no= explode(",",$mobile_number);
                                        $save['masterlog_id']=$master_id;
                                        $date=get_current_date_time();
                                        $save['addtime']=date("H:i:s",strtotime($date));
                                        $save['adddate']=date("Y-m-d",strtotime($date));
                                        
                                        foreach($mb_no as $key=>$value)
                                        {    
                                            if($save['msg_for']!='None'){    
                                                $msg=$s_message;
                                                $message="Dear ".$save['msg_for'].", ".$msg;
                                            } else {
                                                $message=$s_message;
                                            }
                                            $teacher_info=get_detalis_for_message('mobile_no',$value,'user_id',$user_id,CLASS_TEACHER);
                                            
                                            if(strrchr($message,"[todaydate]")){
                                                $arr['[todaydate]']=date('d-m-Y');
                                            }
                                            if(strrchr($message,"[name]")){
                                                $arr['[name]']=$teacher_info['name'];
                                            }
                                            /*if(strrchr($message,"[class]")){
                                                $arr['[class]']=$teacher_info['class_name'];
                                            }*/
                                            if(strrchr($message,"[employ_id]")){
                                                $arr['[employ_id]']=$teacher_info['employ_id'];
                                            }
                                            $message_test=replace_string_using_array($arr,$message);
                                            if($message_test==FALSE){
                                                $save['message']=$message;
                                                $message=urlencode($message);
                                            } else {
                                                $save['message']=$message_test;
                                                $message=urlencode($message_test);
                                                //echo "this is else condition"; exit;
                                            }
                                            unset($arr);
                                            $save['teacher_id']=$teacher_info['id'];
                                            if($save['sms_type'] !='Schedule') {
                                                $mobile_no=$value;
                                                if($get_user_list['status_one']=='Active') {
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
                                                        unset($link); unset($check_status);*/
                                                        $save['api_name']='one';
                                                        $upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
                                                }

                                                if($get_user_list['status_two']=='Active') {    
                                                       /* $link=$api_schedule_link.'username='.$api_username.'&hash='.$api_hash.'&numbers=91'.$mobile_no.'&sender='.$api_sender.'&message='.$message;
                                                        $send_sms=call_send_sms_link($link);                                            
                                                        $send_report=json_decode($send_sms);
                                                        if($send_report['status']=='success'){
                                                            $save['msg_status']='Delivered';
                                                        } else {
                                                            $save['msg_status']=$send_report['status'];
                                                        }
                                                       */
                                                        $save['api_name']='two';
                                                        $upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
                                                }
                                            } else {
                                                    if(isset($save['schedule_date']))
                                                    {
                                                        $date=explode(" ",$save['schedule_date']);
                                                        $s_data=$date[0]."%20".$date[1];
                                                        if($get_user_list['status_one']=='Active') { 
                                                            //$link=$api_schedule_link.'user='.$api_username.'&pass='.$api_password.'&sender='.$api_sender.'&phone='.$mobile_no.'&text='.$message.'&priority='.$api_priority.'&stype='.$api_type.'&time='.$s_data;                                        
                                                            $upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
                                                            $save['api_name']='one';
                                                        }
                                                        if($get_user_list['status_two']=='Active') { 
                                                           // $link=$api_schedule_link.'username='.$api_username.'&hash='.$api_hash.'&numbers=91'.$mobile_no.'&sender='.$api_sender.'&message='.$message.'&time='.$s_data;
                                                            $upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
                                                            $save['api_name']='two';
                                                        }
                                                        // $send_sms=send_schedule_sms($link);
                                                        $save['schedule_date']=$send_sms;
                                                        
                                                        $upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
                                                    }
                                            }      
                                                $save['msg_status']='Submitted';
                                                update_record($upd, $user_id, USERS);
                                                $mobile_no=$result = substr($value, 0, 10);
                                                $save['mobile_no']=$mobile_no;
                                                if(!empty($value)){
                                                    $add=insert_record(SMS_LOG,$save);
                                                } else {
                                                    $add=true;
                                                }
                                                
                                        }
                                        
                                        if($add){
                                                    $this->session->set_flashdata('success', 'Message send succesfully' );
                                                    redirect($this->config->item('admin_folder').'/send/teacher');
                                        } else {
                                                    $this->session->set_flashdata('error', 'Error while Sending sms !!' );
                                                    redirect($this->config->item('admin_folder').'/send/teacher');
                                        }
                    }
		$this->load->view($this->config->item('admin_folder').'/sendsms_teacher', $data);
        }
        
        function staff()
        {
                $data['page_title']= 'SMS To Staff';
                $admin=$this->session->userdata();
                //$data['mode']=ADMIN_URL.'/send/stud';
                $user_id=$admin['user_id'];
                $user=$admin['logint_type'];
                 $data['get_msg_for']=  get_listt(SMS_FOR_LIST);
                $data['get_api_status']=$this->Data_model->get_api_status($user_id);
                $data['get_staff_list']=get_list_by_user_id($user_id,STAFF);
                $data['get_sms_template']=get_list_by_user_id($user_id,SMS_TEMPLATE);
                //$data['get_list']=get_sms_list($user_id,'Staff');
                $data['get_list']=  $this->Data_model->get_sms_list($user_id,'Staff');
                
                //$data['get_list']=get_list(SMS_LOG);
                $data['total_msg']=count($data['get_list']);
                    if(isset($_POST['submit']))
                    {
                        $save['mobile_no']=$this->input->post('mobile_no',TRUE);
                        $s_message=$this->input->post('message',TRUE);
                        $save['sms_type']=$this->input->post('sms_type',TRUE);
                        $save['msg_for']=$this->input->post('msg_for',TRUE);
                        $save['user_id']=$user_id;
                        $save['send_sms_type']='Staff';
                        /*if($save['msg_for']!='None'){    
                            //for send sms data
                            $message="Dear ".$save['msg_for'].", ".$save['message'];
                            //$message = str_replace(' ', '%20', $message);
                            $message=urlencode($message);
                            $message=$message;
                        } else {
                            $message=urlencode($save['message']);
                        }*/
                            $path_link='';
                            $mobile_no=$save['mobile_no'];
                            $msg_value=strlen($s_message);
                            $total_msg=$msg_value/160;
                            $total_val=ceil($total_msg);
                            $save['count_msg']=$total_val;
                            $numbers_array=extract_numbers($save['mobile_no']);
                            $numbers=implode(",",$numbers_array);
                            $save['mobile_no']=$numbers;
                            
                            $get_user_list=get_list_by_id($user_id, USERS);
                          /* if($get_user_list['status_one']=='Active') {
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
                                            $this->session->set_flashdata('error', 'API Username is not set!!' );
                                            redirect($this->config->item('admin_folder').'/send/staff');
                                    }
                                }

                                if(isset($api_password)){ 
                                    if(empty($api_password)) {
                                            $this->session->set_flashdata('error', 'API Password is not set !!' );
                                            redirect($this->config->item('admin_folder').'/send/staff');
                                    }
                                }

                                if(isset($api_sender)){
                                    if(empty($api_sender)) {
                                        $this->session->set_flashdata('error', 'API Sender id is not set!!' );
                                        redirect($this->config->item('admin_folder').'/send/staff');                            
                                    }                        
                                }

                                if(isset($api_type)){
                                    if(empty($api_type)) {
                                        $this->session->set_flashdata('error', 'API SMS type is not set!!' );
                                        redirect($this->config->item('admin_folder').'/send/staff');
                                    }
                                }

                                if(isset($api_priority)) {
                                    if(empty($api_priority)) {
                                        $this->session->set_flashdata('error', 'API Priority is not set!!' );
                                        redirect($this->config->item('admin_folder').'/send/staff');
                                    }
                                }

                                if(isset($api_hash)) {
                                    if(empty($api_hash)) {
                                        $this->session->set_flashdata('error', 'API Hash is not set!!' );
                                        redirect($this->config->item('admin_folder').'/send/staff');
                                    }
                                }
                            
                            */  
                            if($save['sms_type']=='Schedule')
                            {   
                                $save['schedule_date']=$this->input->post('schedule_date',TRUE);
                                $save['sms_type']='Schedule';
                                $save['msg_status']='Delivered';
                                
                            } else {
                                $save['sms_type']='Instant';
                            }      
                                $master_id=insert_record(SMS_LOG_MASTER, $save);
                            
                                        $mobile_number=$save['mobile_no'];
                                        $mb_no=  explode(",",$mobile_number);
                                        $save['masterlog_id']=$master_id;
                                        $date=get_current_date_time();
                                        $save['addtime']=date("H:i:s",strtotime($date));
                                        $save['adddate']=date("Y-m-d",strtotime($date));
                                        
                                        foreach ($mb_no as $key=>$value)
                                        {
                                            if($save['msg_for']!='None'){    
                                                $msg=$s_message;
                                                $message="Dear ".$save['msg_for'].", ".$msg;
                                            } else {
                                                $message=$s_message;
                                            }
                                            $teacher_info=get_detalis_for_message('mobile_no',$value,'user_id',$user_id,STAFF);
                                            
                                            if(strrchr($message,"[todaydate]")){
                                                $arr['[todaydate]']=date('d-m-Y');
                                            }
                                            if(strrchr($message,"[name]")){
                                                $arr['[name]']=$teacher_info['name'];
                                            }
                                            /*if(strrchr($message,"[class]")){
                                                $arr['[class]']=$teacher_info['class_name'];
                                            }*/
                                            if(strrchr($message,"[employ_id]")){
                                                $arr['[employ_id]']=$teacher_info['employ_id'];
                                            }
                                            $message_test=replace_string_using_array($arr,$message);
                                            if($message_test==FALSE){
                                                $save['message']=$message;
                                                $message=urlencode($message);
                                            } else {
                                                $save['message']=$message_test;
                                                $message=urlencode($message_test);
                                                //echo "this is else condition"; exit;
                                            }
                                            unset($arr);
                                            $save['staff_id']=$teacher_info['id'];
                                            $mobile_no=$value;
                                            if($save['sms_type'] !='Schedule') {
                                                if($get_user_list['status_one']=='Active') {
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
                                                        unset($link); unset($check_status);*/
                                                        $save['api_name']='one';
                                                        $upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
                                                }
                                                if($get_user_list['status_two']=='Active') {    
                                                      /*  $link=$api_schedule_link.'username='.$api_username.'&hash='.$api_hash.'&numbers=91'.$mobile_no.'&sender='.$api_sender.'&message='.$message;
                                                        $send_sms=call_send_sms_link($link);                                            
                                                        $send_report=json_decode($send_sms);
                                                        if($send_report['status']=='success'){
                                                            $save['msg_status']='Delivered';
                                                        }*/
                                                        $save['api_name']='two';
                                                        $upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
                                                }
                                            } else {
                                                if(isset($save['schedule_date'])) {
                                                    $date=explode(" ",$save['schedule_date']);
                                                    $s_data=$date[0]."%20".$date[1];
                                                    if($get_user_list['status_one']=='Active') { 
                                                        //$link=$api_schedule_link.'user='.$api_username.'&pass='.$api_password.'&sender='.$api_sender.'&phone='.$mobile_no.'&text='.$message.'&priority='.$api_priority.'&stype='.$api_type.'&time='.$s_data;                                        
                                                         $upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
                                                         $save['api_name']='one';
                                                    }
                                                    if($get_user_list['status_two']=='Active') { 
                                                        //$link=$api_schedule_link.'username='.$api_username.'&hash='.$api_hash.'&numbers=91'.$mobile_no.'&sender='.$api_sender.'&message='.$message.'&time='.$s_data;
                                                        $upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
                                                        $save['api_name']='two';
                                                    }
                                                    $send_sms=send_schedule_sms($link);
                                                    $save['schedule_date']=$send_sms;
                                                }
                                            }
                                                $save['msg_status']='Submitted';
                                                update_record($upd, $user_id, USERS);
                                                $mobile_no=$result = substr($value, 0, 10);
                                                $save['mobile_no']=$mobile_no;
                                                if(!empty($value)){
                                                    $add=insert_record(SMS_LOG,$save);
                                                } else {
                                                    $add=true;
                                                }
                                                
                                        }                                
                                        if($add){
                                                    $this->session->set_flashdata('success', 'Message send succesfully' );
                                                    redirect($this->config->item('admin_folder').'/send/staff');
                                        } else {
                                                    $this->session->set_flashdata('error', 'Error while Sending sms !!' );
                                                    redirect($this->config->item('admin_folder').'/send/staff');
                                        }
                    }
            $this->load->view($this->config->item('admin_folder').'/sendsms_staff', $data);
        }
        
        function group()
        {
                $data['page_title']='SMS To Group';
                $admin=$this->session->userdata();
                $user_id=$admin['user_id'];
                $user=$admin['logint_type'];
                $data['get_msg_for']=  get_listt(SMS_FOR_LIST);
                $data['get_api_status']=$this->Data_model->get_api_status($user_id);
                $data['get_sms_template']=get_list_by_user_id($user_id,SMS_TEMPLATE);
                $data['get_group_list']=get_list_by_user_id($user_id,GROUP);
                $data['get_list']=get_sms_list($user_id,'Group');
                $data['total_msg']=count($data['get_list']);
                    if(isset($_POST['submit']))
                    {
                        $save['mobile_no']=$this->input->post('mobile_no',TRUE);
                        $s_message=$this->input->post('message',TRUE);
                        $save['sms_type']=$this->input->post('sms_type',TRUE);
                        $save['msg_for']=$this->input->post('msg_for',TRUE);
                        $save['user_id']=$user_id;
                        $save['send_sms_type']='Group';
                        $check_group = $this->input->post('check_id',TRUE);
                       /* if($save['msg_for']!='None'){    
                            //for send sms data
                            $message="Dear ".$save['msg_for'].", ".$save['message'];
                            //$message = str_replace(' ', '%20', $message);
                            $message=urlencode($message);
                            $message=$message;
                        } else {
                            $message=urlencode($save['message']);
                        }*/
                        $path_link='';
                        $mobile_no=$save['mobile_no'];
                        $get_user_list=get_list_by_id($user_id, USERS);
                       /* if($get_user_list['status_one']=='Active') {
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
                                    $this->session->set_flashdata('error', 'API Username is not set!!' );
                                    redirect($this->config->item('admin_folder').'/send/group');
                            }
                        }
                        
                        if(isset($api_password)){ 
                            if(empty($api_password)) {
                                    $this->session->set_flashdata('error', 'API Password is not set !!' );
                                    redirect($this->config->item('admin_folder').'/send/group');
                            }
                        }
                        
                        if(isset($api_sender)){
                            if(empty($api_sender)) {
                                $this->session->set_flashdata('error', 'API Sender id is not set!!' );
                                redirect($this->config->item('admin_folder').'/send/group');                            
                            }                        
                        }
                        
                        if(isset($api_type)){
                            if(empty($api_type)) {
                                $this->session->set_flashdata('error', 'API SMS type is not set!!' );
                                redirect($this->config->item('admin_folder').'/send/group');
                            }
                        }
                        
                        if(isset($api_priority)) {
                            if(empty($api_priority)) {
                                $this->session->set_flashdata('error', 'API Priority is not set!!' );
                                redirect($this->config->item('admin_folder').'/send/group');
                            }
                        }
                        
                        if(isset($api_hash)) {
                            if(empty($api_hash)) {
                                $this->session->set_flashdata('error', 'API Hash is not set!!' );
                                redirect($this->config->item('admin_folder').'/send/group');
                            }
                        }                        
                        if(empty($check_group))
                        {
                                $this->session->set_flashdata('error','Please select Group');
                                redirect($this->config->item('admin_folder').'/send/group');
                        }
                             */                   
                        if($save['sms_type']=='Schedule') {   
                                $save['schedule_date']=$this->input->post('schedule_date',TRUE);
                                $save['sms_type']='Schedule';
                                $save['msg_status']='Delivered';
                        } else {
                                $save['sms_type']='Instant';
                        }                 
                                $msg_value=strlen($s_message);
                                $total_msg=$msg_value/160;
                                $total_val=ceil($total_msg);
                                $save['count_msg']=$total_val;
                                $master_id=insert_record(SMS_LOG_MASTER,$save);
                            
                                $date=get_current_date_time();
                                $save['addtime']=date("H:i:s",strtotime($date));
                                $save['adddate']=date("Y-m-d",strtotime($date));
                                
                                foreach($check_group as $key=>$value) {
                                       $grp_name=$this->Data_model->get_grp_list($value,$user_id);
                                       foreach ($grp_name as $gm)
                                       {    
                                            if($gm['group_type']=='teacher')  {     
                                                   $member_data= get_list_by_id($gm['member_id'], STAFF);
                                                   $save['mobile_no']=$member_data['mobile_no'];
                                                   $save['name']='teacher';
                                                   $save['group_id']=$value;
                                                   $save['teacher_id']=$member_data['id'];
                                            }
                                            
                                            if($gm['group_type']=='student') {
                                                $member_data=get_list_by_id($gm['member_id'], STUDENT);
                                                $save['mobile_no']=$member_data['mobile_no'];
                                                $save['name']='student';
                                                $save['group_id']=$value;
                                                $save['stud_id']=$member_data['id'];
                                            }
                                            
                                            if($gm['group_type']=='staff') {
                                                $member_data= get_list_by_id($gm['member_id'], STAFF);
                                                $save['mobile_no']=$member_data['mobile_no'];
                                                $save['name']='staff';
                                                $save['group_id']=$value;
                                                $save['staff_id']=$member_data['id'];
                                            }
                                            
                                            if($save['msg_for']!='None'){    
                                                $msg=$s_message;
                                                $message="Dear ".$save['msg_for'].", ".$msg;
                                            } else {
                                                $message=$s_message;
                                            }
                                            // $teacher_info=get_detalis_for_message('mobile_no',$value,'user_id',$user_id,STAFF);
                                            
                                            if(strrchr($message,"[todaydate]")){
                                                $arr['[todaydate]']=date('d-m-Y');
                                            }
                                            if(strrchr($message,"[name]")){
                                                $arr['[name]']=$member_data['name'];
                                            }
                                            if(strrchr($message,"[class]")){
                                                $arr['[class]']=$member_data['class_name'];
                                            }
                                            if(strrchr($message,"[rollno]")){
                                                $arr['[rollno]']=$member_data['roll_no'];
                                            }
                                           
                                            $message_test=replace_string_using_array($arr,$message);
                                            
                                            if($message_test==FALSE){
                                                $save['message']=$message;
                                                $message=urlencode($message);
                                            } else {
                                                $save['message']=$message_test;
                                                $message=urlencode($message_test);
                                                //echo "this is else condition"; exit;
                                            }
                                            unset($arr); unset($member_data);
                                            
                                            $mobile_no=$save['mobile_no'];
                                            
                                            if($save['sms_type'] !='Schedule') {
                                                if($get_user_list['status_one']=='Active') {
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
                                                    unset($link); unset($check_status);*/
                                                    $save['api_name']='one';
                                                    $upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
                                                }
                                                if($get_user_list['status_two']=='Active') {    
                                                       /* $link=$api_schedule_link.'username='.$api_username.'&hash='.$api_hash.'&numbers=91'.$mobile_no.'&sender='.$api_sender.'&message='.$message;
                                                        $send_sms=call_send_sms_link($link);                                            
                                                        $send_report=json_decode($send_sms);
                                                        if($send_report['status']=='success'){
                                                            $save['msg_status']='Delivered';
                                                        }
                                                        $save['msg_status']='Delivered';*/
                                                        $save['api_name']='two';
                                                        $upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
                                                }
                                            } else { 
                                                    if(isset($save['schedule_date'])) {
                                                        $date=explode(" ",$save['schedule_date']);
                                                        $s_data=$date[0]."%20".$date[1];
                                                        if($get_user_list['status_one']=='Active') { 
                                                           // $link=$api_schedule_link.'user='.$api_username.'&pass='.$api_password.'&sender='.$api_sender.'&phone='.$mobile_no.'&text='.$message.'&priority='.$api_priority.'&stype='.$api_type.'&time='.$s_data;                                        
                                                            $upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
                                                            $save['api_name']='one';
                                                        }
                                                        if($get_user_list['status_two']=='Active') { 
                                                          // $link=$api_schedule_link.'username='.$api_username.'&hash='.$api_hash.'&numbers=91'.$mobile_no.'&sender='.$api_sender.'&message='.$message.'&time='.$s_data;
                                                            $upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
                                                            $save['api_name']='two';
                                                        }
                                                       // $send_sms=send_schedule_sms($link);
                                                        $save['schedule_date']=$send_sms;
                                                    }
                                            }
                                            $save['msg_status']='Submitted';
                                            update_record($upd, $user_id, USERS); 
                                            $add=insert_record(SMS_LOG, $save);
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
                                }  */       
                                
                                if($add){
                                        $this->session->set_flashdata('success', 'Message send succesfully' );
                                        redirect($this->config->item('admin_folder').'/send/group');
                                } else {
                                        $this->session->set_flashdata('error', 'Error while Sending sms !!' );
                                        redirect($this->config->item('admin_folder').'/send/group');
                                }
                    }
		$this->load->view($this->config->item('admin_folder').'/sendsms_group', $data);
        }
        
        function homework()
        {
            
                $data['page_title']= 'SMS To Homework';
                $admin=$this->session->userdata();
                $user_id=$admin['user_id'];
                $user=$admin['logint_type'];
                $data['get_msg_for']=  get_listt(SMS_FOR_LIST);
                $data['get_api_status']=$this->Data_model->get_api_status($user_id);
                $data['get_class_list']=get_list_by_user_id($user_id,CLASSES);
                $data['get_home_template']=get_list_by_user_id($user_id,HOMEWORK);
                $data['get_list']=get_sms_list($user_id,'Homework');
                $data['total_msg']=count($data['get_list']);
                    if(isset($_POST['submit']))
                    {
                        $save['mobile_no']=$this->input->post('mobile_no',TRUE);
                        $s_message=$this->input->post('message',TRUE);
                        $save['sms_type']=$this->input->post('sms_type',TRUE);
                        $save['msg_for']=$this->input->post('msg_for',TRUE);
                        $save['user_id']=$user_id;
                        $save['send_sms_type']='Homework';
                        /*if($save['msg_for']!='None'){    
                            //for send sms data                            
                            $message="Dear ".$save['msg_for'].", ".$save['message'];
                            //$message = str_replace(' ', '%20', $message);
                            $message=urlencode($message);
                            $message=$message;
                        } else {
                            $message=urlencode($save['message']);
                        }*/
                        $path_link='';
                        $mobile_no=$save['mobile_no'];
                        $msg_value=strlen($s_message);
                        $total_msg=$msg_value/160;
                        $total_val=ceil($total_msg);
                        $save['count_msg']=$total_val;
                        $numbers_array=extract_numbers($save['mobile_no']);
                        $numbers=implode(",",$numbers_array);
                        $save['mobile_no']=$numbers;
                        
                        $get_user_list=get_list_by_id($user_id, USERS);
                       /* if($get_user_list['status_one']=='Active') {
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
                                    $this->session->set_flashdata('error', 'API Username is not set!!' );
                                    redirect($this->config->item('admin_folder').'/send/homework');
                            }
                        }
                        
                        if(isset($api_password)){ 
                            if(empty($api_password)) {
                                    $this->session->set_flashdata('error', 'API Password is not set !!' );
                                    redirect($this->config->item('admin_folder').'/send/homework');
                            }
                        }
                        
                        if(isset($api_sender)){
                            if(empty($api_sender)) {
                                $this->session->set_flashdata('error', 'API Sender id is not set!!' );
                                redirect($this->config->item('admin_folder').'/send/homework');                            
                            }                        
                        }
                        
                        if(isset($api_type)){
                            if(empty($api_type)) {
                                $this->session->set_flashdata('error', 'API SMS type is not set!!' );
                                redirect($this->config->item('admin_folder').'/send/homework');
                            }
                        }
                        
                        if(isset($api_priority)) {
                            if(empty($api_priority)) {
                                $this->session->set_flashdata('error', 'API Priority is not set!!' );
                                redirect($this->config->item('admin_folder').'/send/homework');
                            }
                        }
                        
                        if(isset($api_hash)) {
                            if(empty($api_hash)) {
                                $this->session->set_flashdata('error', 'API Hash is not set!!' );
                                redirect($this->config->item('admin_folder').'/send/homework');
                            }
                        }*/
                        
                            if($save['sms_type']=='Schedule') {
                                $save['schedule_date']=$this->input->post('schedule_date',TRUE);
                                $save['sms_type']='Schedule';
                                $save['msg_status']='Delivered';
                            } else {
                                $save['sms_type']='Instant';
                            }                                                    
                                    $master_id=insert_record(SMS_LOG_MASTER, $save);
                            
                                        $mobile_number=$save['mobile_no'];
                                        $mb_no=explode(",",$mobile_number);
                                        $save['masterlog_id']=$master_id;
                                        $date=get_current_date_time();
                                        $save['addtime']=date("H:i:s",strtotime($date));
                                        $save['adddate']=date("Y-m-d",strtotime($date));
                                        foreach($mb_no as $key=>$value)  {   
                                            if($save['msg_for']!='None'){    
                                            $msg=$s_message;
                                            $message="Dear ".$save['msg_for'].", ".$msg;
                                        } else {
                                            $message=$s_message;
                                        }
                                            $student_info=get_detalis_for_message('mobile_no',$value,'user_id',$user_id,STUDENT);
                                            
                                            if(strrchr($message,"[todaydate]")){
                                                $arr['[todaydate]']=date('d-m-Y');
                                            }
                                            if(strrchr($message,"[name]")){
                                                $arr['[name]']=$student_info['name'];
                                            }
                                            if(strrchr($message,"[class]")){
                                                $arr['[class]']=$student_info['class_name'];
                                            }
                                            if(strrchr($message,"[rollno]")){
                                                $arr['[rollno]']=$student_info['roll_no'];
                                            }
                                            $message_test=replace_string_using_array($arr,$message);
                                            if($message_test==FALSE){
                                                $save['message']=$message;
                                               
                                                $message=urlencode($message);
                                            } else {
                                                $save['message']=$message_test;
                                                $message=urlencode($message_test);
                                            }
                                            unset($arr);
                                            $save['stud_id']=$student_info['id'];
                                            $mobile_no=$value;
                                            if($save['sms_type'] !='Schedule') {                                                
                                                if($get_user_list['status_one']=='Active') {
                                                      /*  $link=$api_instant_link.'user='.$api_username.'&pass='.$api_password.'&sender='.$api_sender.'&phone='.$mobile_no.'&text='.$message.'&priority='.$api_priority.'&stype='.$api_type;
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
                                                    unset($link); unset($check_status);*/
                                                    $save['api_name']='one';
                                                    $upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
                                                }
                                                if($get_user_list['status_two']=='Active') {    
                                                        /*$link=$api_schedule_link.'username='.$api_username.'&hash='.$api_hash.'&numbers=91'.$mobile_no.'&sender='.$api_sender.'&message='.$message;
                                                        $send_sms=call_send_sms_link($link);                                            
                                                        $send_report=json_decode($send_sms);
                                                        if($send_report['status']=='success'){
                                                            $save['msg_status']='Delivered';
                                                        }
                                                        $save['msg_status']='Delivered';*/
                                                        $save['api_name']='two';
                                                        $upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
                                                }
                                            } else {
                                                if(isset($save['schedule_date'])) {
                                                    $date=explode(" ",$save['schedule_date']);
                                                    $s_data=$date[0]."%20".$date[1];
                                                    if($get_user_list['status_one']=='Active') { 
                                                       // $link=$api_schedule_link.'user='.$api_username.'&pass='.$api_password.'&sender='.$api_sender.'&phone='.$mobile_no.'&text='.$message.'&priority='.$api_priority.'&stype='.$api_type.'&time='.$s_data;                                        
                                                        $upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
                                                        $save['api_name']='one';
                                                    }
                                                    if($get_user_list['status_two']=='Active') { 
                                                      //  $link=$api_schedule_link.'username='.$api_username.'&hash='.$api_hash.'&numbers=91'.$mobile_no.'&sender='.$api_sender.'&message='.$message.'&time='.$s_data;
                                                        $upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
                                                        $save['api_name']='two';
                                                    }
                                                   // $send_sms=send_schedule_sms($link);
                                                    $save['schedule_date']=$send_sms;
                                                }
                                            }    
                                                $save['msg_status']='Submitted';
                                                update_record($upd, $user_id, USERS);
                                                $mobile_no=$result = substr($value, 0, 10);
                                                $save['mobile_no']=$mobile_no;
                                                if(!empty($value)){
                                                    $add=insert_record(SMS_LOG,$save);
                                                } else {
                                                    $add=true;
                                                }
                                                
                                        }                                
                                        if($add) {
                                                    $this->session->set_flashdata('success', 'Message send succesfully' );
                                                    redirect($this->config->item('admin_folder').'/send/homework');
                                        } else {
                                                    $this->session->set_flashdata('error', 'Error while Sending sms !!' );
                                                    redirect($this->config->item('admin_folder').'/send/homework');
                                    }
                        }
		$this->load->view($this->config->item('admin_folder').'/sendsms_home', $data);
        }
        
        /*function get_class_list(){
            
                $classname=$_REQUEST['class_name'];
                $get_student_list=$this->Data_model->get_student_list($classname);
               
                $attendance_sit='';
                $attendance_sit.='<div class="form-group">';
                $attendance_sit.='<table id="example1" class="table table-bordered table-striped">';
                $attendance_sit.='<thead> <tr>';
                $attendance_sit.='<th width="5%">NO.</th>';
                $attendance_sit.='<th>STUDENT ID</th>';
                $attendance_sit.='<th>STUDENT NAME</th>';
                $attendance_sit.='<th>FATHER NAME</th>';
                $attendance_sit.='<th>FATHER MOBILE NO.</th>';
                $attendance_sit.='<th id="fir" width="3%"><input type="checkbox" id="ckbCheckAll2" name="head_checkbox" ></th>';
                $attendance_sit.='</tr></thead><tbody>';
                $cnt=1;
                if(empty($get_student_list))
                {
                    $attendance_sit.='<tr>';
                    $attendance_sit.='<td colspan="6"><b>Sorry No Record Found</b></td>';
                    $attendance_sit.='</tr>';
                } else {
                    foreach($get_student_list as $student) {
                        $attendance_sit.='<tr>';
                        $attendance_sit.='<td>'.$cnt.'</td> ';
                        $attendance_sit.='<td>'.$student['admission_no'].'</td>';
                        $attendance_sit.='<td>'.$student['name'].'</td>';
                        $attendance_sit.='<td>'.$student['father_name'].'</td>';
                        $attendance_sit.='<td>'.$student['mobile_no'].'</td>';
                        $attendance_sit.='<td><input type="checkbox" name="mul_id[]"  class="checkBoxClass" value="'.$student['mobile_no'].'( '.$student['name'].')" > </td>';
                        $attendance_sit.='</tr>';
                        $cnt++;
                    }
                }
                $attendance_sit.='</tbody> </table> </div>';
                echo $attendance_sit;
                //print_r($get_student_list);
        }*/
        
        function getclass()
        {
                $admin=$this->session->userdata();
                $user_id=$admin['user_id'];
                $user=$admin['logint_type'];
                $data['get_msg_for']=  get_listt(SMS_FOR_LIST);
                $data['get_api_status']=$this->Data_model->get_api_status($user_id);
                $data['get_class_list']=$this->Data_model->get_classs_list($user_id);
                //$data['get_class_list']=get_list_by_user_id($user_id,CLASSES);
                $data['get_sms_template']=get_list_by_user_id($user_id,SMS_TEMPLATE);
                $data['page_title']= 'SMS To Student';
                //$data['get_list']=get_sms_list($user_id,'Student');
                $data['get_list']=  $this->Data_model->get_student_details($user_id,'Student');
				
                $data['total_msg']=count($data['get_list']);
                $value = $this->input->post('class_name',TRUE);
                $data['class_value']=$value;
                
                if($value=='select'){
                    redirect($this->config->item('admin_folder').'/send/send-sms-to-student');
                }
                if($value=='All') {
                    $field='user_id';
                    $data['class_value']='All';
                    $data['get_student_list']=get_list_by_idd($user_id,$field,STUDENT);
                } else {
                $class_name=get_list_by_id($value,CLASSES);
                $data['class_value']=$class_name['name'];
                $data['get_student_list']=$this->Data_model->get_student_list_by_class_id($value,$user_id);
                }
                $this->load->view($this->config->item('admin_folder').'/sendsms_student', $data);
        }
        
        function getwork()
        {
            $data['page_title']= 'SMS To Homework';
            $admin=$this->session->userdata();
            $user_id=$admin['user_id'];
            $user=$admin['logint_type'];
            $data['get_msg_for']=  get_listt(SMS_FOR_LIST);
            $data['get_api_status']=$this->Data_model->get_api_status($user_id);
            $data['get_class_list']=get_list_by_user_id($user_id,CLASSES);
            $data['get_home_template']=get_list_by_user_id($user_id,HOMEWORK);
            $data['get_list']=get_sms_list($user_id,'Homework');
            $data['total_msg']=count($data['get_list']);
            $value = $this->input->post('class_name',TRUE);
            if($value=='select'){
                    redirect($this->config->item('admin_folder').'/send/send-sms-to-student');
                }
                if($value=='All') {
                    $field='user_id';
                    $data['class_value']='All';
                    $data['get_student_list']=get_list_by_idd($user_id,$field,STUDENT);
                } else {
                $class_name=get_list_by_id($value,CLASSES);
                $data['class_value']=$class_name['name'];
                $data['get_student_list']=$this->Data_model->get_student_list_by_class_id($value,$user_id);
                }
            $this->load->view($this->config->item('admin_folder').'/sendsms_home', $data);
        }
        
        function class_sms()
        {
                $data['page_title']='SMS To Class';
                $admin=$this->session->userdata();
                $user_id=$admin['user_id'];
                $user=$admin['logint_type'];
                $data['get_msg_for']=get_listt(SMS_FOR_LIST);
                $data['get_api_status']=$this->Data_model->get_api_status($user_id);
                $data['get_sms_template']=get_list_by_user_id($user_id,SMS_TEMPLATE);
                $data['get_group_list']=get_list_by_user_id($user_id,CLASSES);
                $data['get_list']=get_sms_list($user_id,'class_sms');
                $data['total_msg']=count($data['get_list']);
                    if(isset($_POST['submit']))
                    {
                        //$save['mobile_no']=$this->input->post('mobile_no',TRUE);
                        $s_message=$this->input->post('message',TRUE);
                        $save['sms_type']=$this->input->post('sms_type',TRUE);
                        $save['msg_for']=$this->input->post('msg_for',TRUE);
                        $save['user_id']=$user_id;
                        $save['send_sms_type']='class_sms';
                        $check_group=$this->input->post('check_id',TRUE);
                        
                        //print_r($check_group); exit;
                        $path_link='';
                     /* if($save['msg_for']!='None'){    
                            //for send sms data
                            $message="Dear ".$save['msg_for'].", ".$save['message'];
                            //$message = str_replace(' ', '%20', $message);
                            $message=urlencode($message);
                            $message=$message;
                        } else {
                            $message=urlencode($save['message']);
                        }*/
                        
                       //$mobile_no=$save['mobile_no'];
                        $get_user_list=get_list_by_id($user_id, USERS);
                        /*if($get_user_list['status_one']=='Active') {
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
                                    $this->session->set_flashdata('error', 'API Username is not set!!' );
                                    redirect($this->config->item('admin_folder').'/send/class_sms');
                            }
                        }
                        
                        if(isset($api_password)){ 
                            if(empty($api_password)) {
                                    $this->session->set_flashdata('error', 'API Password is not set !!' );
                                    redirect($this->config->item('admin_folder').'/send/class_sms');
                            }
                        }
                        
                        if(isset($api_sender)){
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
                            */                    
                        if($save['sms_type']=='Schedule') {   
                                $save['schedule_date']=$this->input->post('schedule_date',TRUE);
                                $save['sms_type']='Schedule';
                                $save['msg_status']='Delivered';
                        } else {
                                $save['sms_type']='Instant';
                        }                 
                                $msg_value=strlen($s_message);
                                $total_msg=$msg_value/160;
                                $total_val=ceil($total_msg);
                                $save['count_msg']=$total_val;
                                $master_id=insert_record(SMS_LOG_MASTER, $save);
                                
                                $date=get_current_date_time();
                                $save['addtime']=date("H:i:s",strtotime($date));
                                $save['adddate']=date("Y-m-d",strtotime($date));
                                foreach($check_group as $key=>$value) {
                                        $stdnt_list=$this->Data_model->get_student_list_by_class_id($value,$user_id);
                                         
                                        foreach($stdnt_list as $gm)
                                        {   
                                            if($save['msg_for']!='None'){    
                                            $msg=$s_message;
                                            $message="Dear ".$save['msg_for'].", ".$msg;
                                            } else {
                                                $message=$s_message;
                                            }
                                            //$student_info=get_detalis_for_message('mobile_no',$value,'user_id',$user_id,STUDENT);
                                            
                                            if(strrchr($message,"[todaydate]")){
                                                $arr['[todaydate]']=date('d-m-Y');
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
                                            $mobile_no=$save['mobile_no'];
                                            if($save['sms_type'] !='Schedule') {
                                                if($get_user_list['status_one']=='Active') {
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
                                                        unset($link); unset($check_status);*/
                                                    $save['api_name']='one';
                                                        $upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
                                                }
                                                if($get_user_list['status_two']=='Active') {    
                                                      /*  $link=$api_schedule_link.'username='.$api_username.'&hash='.$api_hash.'&numbers=91'.$mobile_no.'&sender='.$api_sender.'&message='.$message;
                                                        $send_sms=call_send_sms_link($link);                                            
                                                        $send_report=json_decode($send_sms);
                                                        if($send_report['status']=='success'){
                                                            $save['msg_status']='Delivered';
                                                        } else {
                                                            $save['msg_status']=$send_report['status'];
                                                        }*/
                                                        $save['api_name']='two';
                                                        $upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
                                                }
                                            } else { 
                                                    if(isset($save['schedule_date'])) {
                                                        $date=explode(" ",$save['schedule_date']);
                                                        $s_data=$date[0]."%20".$date[1];
                                                        if($get_user_list['status_one']=='Active') { 
                                                          //  $link=$api_schedule_link.'user='.$api_username.'&pass='.$api_password.'&sender='.$api_sender.'&phone='.$mobile_no.'&text='.$message.'&priority='.$api_priority.'&stype='.$api_type.'&time='.$s_data;                                        
                                                            $upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
                                                            $save['api_name']='one';
                                                        }
                                                        if($get_user_list['status_two']=='Active') { 
                                                           // $link=$api_schedule_link.'username='.$api_username.'&hash='.$api_hash.'&numbers=91'.$mobile_no.'&sender='.$api_sender.'&message='.$message.'&time='.$s_data;
                                                            $upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
                                                            $save['api_name']='two';
                                                        }
                                                       // $send_sms=send_schedule_sms($link);
                                                        $save['schedule_date']=$send_sms;
                                                    }
                                            }
                                           
                                            $save['msg_status']='Submitted';
                                            update_record($upd, $user_id, USERS); 
                                            if(!empty($save['mobile_no'])){
                                                $add=insert_record(SMS_LOG, $save);
                                            } else {
                                                $add=true;
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
                                }  */       
                                
                                if($add){
                                        $this->session->set_flashdata('success', 'Message send succesfully' );
                                        redirect($this->config->item('admin_folder').'/send/class_sms');
                                } else {
                                        $this->session->set_flashdata('error', 'Error while Sending sms !!' );
                                        redirect($this->config->item('admin_folder').'/send/class_sms');
                                }
                    }
		$this->load->view($this->config->item('admin_folder').'/sendsms_class', $data);
        }
        
        function tiny_url()
        {
                //$url=urldecode($current_url);
                //echo $current_url; exit;
                
                $admin=$this->session->userdata();
                $user_id=$admin['user_id'];
                
                //$save['user_id']=$user_id;
                //$current_url=$this->input->post('current_url',TRUE);
                //$save['request_url']=$current_url;
                /*echo '<pre>';
                print_r($_REQUEST);
                echo '<br>';
                echo '<pre>';
                print_r($_FILES);
                exit;*/
                
                if(isset($_FILES['photo']['name']))
                {    
                    if($_FILES['photo']['name']!="") 
                    {
                            $config['upload_path']=UPLOAD_FILES;
                            $r_nm=str_replace(' ', '_', $_FILES['photo']['name']);
                            $name=date("dmY")."-".time().$r_nm;
                            $image_upd=$name;
                            $config['file_name']=$image_upd;
                            $config['overwrite']=TRUE;
                            $config["allowed_types"]='*';
                            $this->load->library('upload',$config);
                            $uploaded=$this->upload->do_upload('photo');
                            if(!$uploaded)
                            {
                                    $this->session->set_flashdata('error', $this->upload->display_errors());
                                    redirect($current_url);
                            } else {                                        
                                    $image=$this->upload->data();
                                    $upload_link=SITE_URL.UPLOAD_FILES.$image['file_name'];
                                    $Tiny_url=get_tiny_url($upload_link);
                                    $path_link=$Tiny_url;
                            }
                        $save['name']=$name;
                        $save['user_id']=$user_id;
                        $save['tiny_url_name']=$path_link;     
                        $add=insert_record(TINY_URL, $save);
                        echo $Tiny_url; exit;
                    }
                }  
        }
		
		function getgroup()
        {
			$admin=$this->session->userdata();
			$user_id=$admin['user_id'];
			$user=$admin['logint_type'];
			$data['get_msg_for']=  get_listt(SMS_FOR_LIST);
			$data['get_api_status']=$this->Data_model->get_api_status($user_id);
			$data['page_title']= 'SMS To Group';
			$data['get_group_list']=get_list_by_user_id($user_id,GROUP);
			$data['get_list']=get_sms_list($user_id,'Group');
			
			$data['total_msg']=count($data['get_list']);
			$value = $this->input->post('class_name',TRUE); 
			$data['class_value']=$value;
			
			if($value=='select'){
				redirect($this->config->item('admin_folder').'/send/send-sms-to-student');
			}
			if($value=='All') {
				$field='user_id';
				$data['class_value']='All';
				$data['get_student_list']=get_list_by_idds($user_id,$field,SMS_GROUP_INFO);
			} else {
			$class_name=get_list_by_id($value,GROUP);
			$data['class_value']=$class_name['name'];
			$data['get_student_list']=$this->Data_model->get_student_list_by_group_id($value,$user_id);
			}
			$this->load->view($this->config->item('admin_folder').'/sendtosms_group', $data);
        } 
		
		
		function grou()
        {
			$admin=$this->session->userdata();
			$user_id=$admin['user_id'];
			$user=$admin['logint_type'];
			$field='user_id';
			$data['get_msg_for']=get_listt(SMS_FOR_LIST);
			$data['get_api_status']=$this->Data_model->get_api_status($user_id);
			$data['get_class_list']=get_list_by_user_id($user_id,CLASSES);
			$data['get_sms_template']=get_list_by_user_id($user_id,SMS_TEMPLATE);
			$data['page_title']='SMS To Group';
			$data['total_msg']=count($data['get_list']);
			
				if(isset($_POST['submit']))
				{
					$save['mobile_no']=$this->input->post('mobile_no',TRUE);
					$save['admission_no']=$this->input->post('admission_no',TRUE);
					$s_message=$this->input->post('message',TRUE);
					$save['sms_type']=$this->input->post('sms_type',TRUE);
					$save['msg_for']=$this->input->post('msg_for',TRUE);
					$save['user_id']=$user_id;
					$save['send_sms_type']='Student';  
				   
					$path_link='';
					$admission_no=$save['admission_no'];
					$msg_value=strlen($s_message);
					$total_msg=$msg_value/160;
					$total_val=ceil($total_msg);
					$save['count_msg']=$total_val;
					$mobile_numbers_array=extract_numbers($save['mobile_no']);
					$mobile_numbers=implode(",",$mobile_numbers_array);
					$save['mobile_no']=$mobile_numbers;
					 
					$get_user_list=get_list_by_id($user_id, USERS);
										
					//for send sms data
					$admission_no=$mobile_numbers;

					if($save['sms_type']=='Schedule') { 
						$save['schedule_date']=$this->input->post('schedule_date',TRUE);
						$save['sms_type']='Schedule';
						$save['msg_status']='Delivered';
					} else {
						$save['sms_type']='Instant';
					}
						$master_id=insert_record(SMS_LOG_MASTER, $save);
						$mobile_number=$save['admission_no'];
						$mb_no=explode(",",$mobile_number);
						$save['masterlog_id']=$master_id;
						
						$date=get_current_date_time();
						$save['addtime']=date("H:i:s",strtotime($date));
						$save['adddate']=date("Y-m-d",strtotime($date));
	
						foreach($mb_no as $key=>$value)
						{   
							if($save['msg_for']!='None'){    
								$msg=$s_message;
								$message="Dear ".$save['msg_for'].", ".$msg;
							} else {
								$msg=$s_message;
								$message=$msg;
							}
								$student_info=get_detalis_for_message('admission_no',$value,'user_id',$user_id,STUDENT);
								if(!$student_info){
									$student_info=get_detalis_for_message('alternate_no',$value,'user_id',$user_id,STUDENT);
								}

								if(strrchr($message,"[todaydate]")){
									$arr['[todaydate]']=date('d-m-Y');
								}
								if(strrchr($message,"[name]")){
									$arr['[name]']=$student_info['name'];
								}
								if(strrchr($message,"[class]")){
									$arr['[class]']=$student_info['class_name'];
								}
								if(strrchr($message,"[rollno]")){
									$arr['[rollno]']=$student_info['roll_no']; 
								}
			
								$message_test=replace_string_using_array($arr,$message);
								if($message_test==FALSE){
									$save['message']=$message;
								   
									$message=urlencode($message);
								} else {
									$save['message']=$message_test;
									$message=urlencode($message_test);
									//echo "this is else condition"; exit;
								}
								unset($arr);
								
							$save['stud_id']=$student_info['id'];
							$save['mobile_no']=$student_info['mobile_no'];
							$admission_no=$value;
							if($save['sms_type'] !='Schedule') {
								if($get_user_list['status_one']=='Active') {
										$save['api_name']='one';
										$upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
								}

								if($get_user_list['status_two']=='Active') {   
										$save['api_name']='two';
										$upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
								}
							} else {
								 if(isset($save['schedule_date'])) {
									$date=explode(" ",$save['schedule_date']);
									$s_data=$date[0]."%20".$date[1];
									if($get_user_list['status_one']=='Active') {                                   
										$upd['total_sms_one']=$get_user_list['total_sms_one']-$save['count_msg'];
										$save['api_name']='one';
									}
									if($get_user_list['status_two']=='Active') { 
										$upd['total_sms_two']=$get_user_list['total_sms_two']-$save['count_msg'];
										$save['api_name']='two';
									}
									$save['schedule_date']=$send_sms;
								}   
							}
								$save['msg_status']='Submitted';
								update_record($upd, $user_id, USERS);
								$admission_no=$result=substr($value,0,10);
								$save['admission_no']=$admission_no;

								if(!empty($value)){
									//echo "AFtab";die;
									$add=insert_record(SMS_LOG,$save);                                    
								} else {
									$add=true;
								}
								
						}
							
						if($add){
								$this->session->set_flashdata('success', 'Message send succesfully' );
								redirect($this->config->item('admin_folder').'/send/group');
						} else {
								$this->session->set_flashdata('error', 'Error while Sending sms !!' );
								redirect($this->config->item('admin_folder').'/send/group');
						}
					}
			$this->load->view($this->config->item('admin_folder').'/sendsms_group', $data);
        }
        
        
}?>