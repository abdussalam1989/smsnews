<?php
class Smsapi extends CI_Controller {

	function __construct()
	{
		parent::__construct();
                $this->load->library('auth');
                $this->load->model('User_model');
		$redirect = $this->auth->is_logged_in();
		if ($redirect == false) {
			$this->session->set_userdata("redirect", current_url());
			redirect($this->config->item('admin_folder').'/login');
		}
        }
        
        function index()
        {   
		$admin=$this->session->userdata();
				
				if($admin['user_id']!=""){
					$user_id=$admin['user_id'];
				}else{
					$user_id=$admin['admin_id'];
				}
				
				$overall_sms="";
			$overall_sms=$this->User_model->get_overall_sms($user_id);
		   
                $over_sms=0;
                    foreach ($overall_sms as $ovr_sms)
                    {   
                        $over_sms=$over_sms + $ovr_sms['count_msg'];
                    }
                $user_data=get_list_by_id($user_id, USERS);
				//print_r($user_data);
                $sentsms_one=$user_data['sentsms_one'];
					
                $sentsms_two=$user_data['sentsms_two'];
						
                if(empty($sentsms_one)){
                    $sentsms_one=0;
                }
                if(empty($sentsms_two)){
                    $sentsms_two=0;
                }
                $total_sent_sms=$sentsms_one + $sentsms_two;
			   
                $over_sms=$over_sms+$total_sent_sms;
			   
          $data_vlue['overall_sms']=$over_sms; 
		  
                $data['page_title']= 'Manage SMS API';
                $data['check']='add';
                $data['val_error']='';
                $data['data_value']=get_list(SMS_API);
                $data['status']=array('Active','Inactive');
                    if(isset($_REQUEST['submit']))
                    {
                        $save['api_name']=$this->input->post('api_name',TRUE);
                        $save['api_msg']=$this->input->post('api_msg',TRUE);
                        $save['status']=$this->input->post('status',TRUE);
                        
                            //check empty records 
                            $check_required_val=check_required($save);
                            
                            //check all ready exits
                            $check_api_name = check_data_exist('api_name',$save['api_name'],SMS_API);
                            
                            //allow only number
                            $check_number= allow_only_number($save['api_msg']);
                            
                            if($check_number) {
                                $data['val_error']='allow only number on message';
                            }
                            
                            if($check_required_val) {        
                                    $data['val_error']='(*) field must be required !! ';
                            }  
                            if($check_api_name==TRUE) {
                                    $data['val_error']='API name already exist';
                            }
                            
                            if($data['val_error']=='')
                            {
                                $add=insert_record(SMS_API, $save);
                                if($add) {
                                        $this->session->set_flashdata('success', 'You have successfully Added API!!' );
                                        redirect($this->config->item('admin_folder').'/smsapi');
                                } else {
                                        $this->session->set_flashdata('error', 'Error while adding API !!' );
                                        redirect($this->config->item('admin_folder').'/smsapi');
                                }
                            }
                    }
		$this->load->view($this->config->item('admin_folder').'/smsapi_list', $data);
		
        }
        
        //delete single record
        function delete($id)
	{       
		$del =delete_single_rec($id,SMS_API);
		if($del){
			$this->session->set_flashdata('success', 'You have successfully deleted sms !!' );
			redirect($this->config->item('admin_folder').'/smsapi');
		} else {
			$this->session->set_flashdata('error', 'Error while deleting sms !!' );
			redirect($this->config->item('admin_folder').'/smsapi');
		}
	}
        
        function mul_action()
        {
            $action_val= $_REQUEST['mul_val'];
            $arr_ids= $_REQUEST['mul_id'];
            $path='/smsapi';
            $table=SMS_API;
            multiple_action($arr_ids, $action_val, $table, $path);
        }
        
        function change_status()
        {
            $id=$_REQUEST['id'];
            $status=$_REQUEST['status'];
            $table=SMS_API;
            if($status== 'true')
            {   
                $status='Active';    
                $result=change_status($id,$status,$table);       
                echo $result;
            } else {   
                $status='Inactive';
                $result=change_status($id,$status,$table);       
                echo $result;
            }
        }
        
       /* function check() 
        {
                // Textlocal account details
                $username = 'youremail@address.com';
                $hash = 'Your API hash';                
                // Message details
                $numbers = array(918123456789, 918987654321);
                $sender = urlencode('TXTLCL');
                $message = rawurlencode('This is your message');
                $numbers = implode(',', $numbers);
                // Prepare data for POST request
                $data = array('username' => $username, 'hash' => $hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

                // Send the POST request with cURL
                $ch = curl_init('http://api.textlocal.in/send/');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                
                // Process your response here
                echo "<pre>";
                echo $response;
        }  */
        
        function allocate()
        {
                $data['page_title']= 'Alot SMS API';
                //$data['user_list']=get_list(USERS);
                $data['user_list']=$this->User_model->get_user_list();
				/* echo '<pre>';
				print_r($data['user_list']);
				exit; */
                $data['check']='add';
                if(isset($_REQUEST['submit']))  
                {
                    $user_id=$this->input->post('user_id',TRUE);
                    //$user_id=$this->input->post('select_user');
                    $save['username_one']=$this->input->post('username_one',TRUE);
					$save['r_sms_one']=$this->input->post('r_sms_one',TRUE);
                    $save['r_sms_two']=$this->input->post('r_sms_two',TRUE);
				    $save['t_sms_one']=$this->input->post('t_sms_one',TRUE);
                    $save['t_sms_two']=$this->input->post('t_sms_two',TRUE);
                    $save['password_one']=$this->input->post('password_one',TRUE);
                    $save['senderid_one']=$this->input->post('senderid_one',TRUE);
				
                    $save['smstype_one']=$this->input->post('smstype_one',TRUE);
                    $save['sentsms_one']=$this->input->post('sentsms_one',TRUE);
                    $save['sentsms_two']=$this->input->post('sentsms_two',TRUE);
                    $save['prioritydetails_one']=$this->input->post('prioritydetails_one',TRUE);
                    $save['status_one']=$this->input->post('status_one',TRUE);
                    $save['username_two']=$this->input->post('username_two',TRUE);
                    $save['password_two']=$this->input->post('password_two',TRUE);
                    $save['senderid_two']=$this->input->post('senderid_two',TRUE);
                    $save['smstype_two']=$this->input->post('smstype_two',TRUE);                    
                    $save['prioritydetails_two']=$this->input->post('prioritydetails_two',TRUE);
                    $save['status_two']=$this->input->post('status_two',TRUE);
                    $save['api_two_hash']=$this->input->post('api_two_hash',TRUE);
                    
                    $save['username_one']=trim($save['username_one']);
                    $save['senderid_one']=trim($save['senderid_one']);
                    $save['username_two']=trim($save['username_two']);
                    $save['senderid_two']=trim($save['senderid_two']);
                    $save['api_two_hash']=trim($save['api_two_hash']);
                    
                    
                    /* $save['name']=$this->input->post('name',TRUE);
                    $total_sms=$this->input->post('total_sms',TRUE);
                    $alot_sms=$this->input->post('alot_sms',TRUE); 
                    $save['total_sms']=$total_sms + $alot_sms; 
                    $api_data=get_list_by_id($api_id,SMS_API);
                    $api_ms= $api_data['api_msg'] - $alot_sms;
                    $api['api_msg']=$api_ms; 
                    update_record($api, $api_id, SMS_API);
                    //echo $this->db->last_query(); exit;
                    $id=$this->input->post('data_id',TRUE);*/
                    
                    if($save['status_one']=='Active') {
                        $save['status_two']='Inactive';
                    } else {
                        $save['status_two']='Active';
                    }
                    
                    $alot_sms_one=$this->input->post('t_sms_one',TRUE);
                    if(!empty($alot_sms_one)){
                        $total_msg=$this->input->post('r_sms_one',TRUE);
                        $save['total_sms_one']=$alot_sms_one;
                        $save['red_sms_one']=$total_msg;
                        $user_total_sms=$save['total_sms_one'];
                        $history['api_name']=$save['username_one'];
						//$history['R_Sms']=$save['r_sms_one'];
						//$history['T_Sms']=$save['t_sms_one'];
						
                        $history['total_sms']=$alot_sms_one;
                        $history['user_id']=$user_id;
                        $history['user_name']=$this->input->post('name',TRUE);
					
                        insert_record(SMS_ALLOCATION_HISTORY, $history);
						
                    }
                    
                    $alot_sms_two=$this->input->post('t_sms_two',TRUE);
                    if(!empty($alot_sms_two)) {
                        $total_msg=$this->input->post('r_sms_two',TRUE);
                        $save['total_sms_two']=$alot_sms_two;
                        $save['red_sms_two']=$total_msg;
                      
                        $user_total_sms=$save['total_sms_two'];
                        $history['api_name']=$save['username_two'];
						//$history['R_Sms']=$save['r_sms_two'];
						//$history['T_Sms']=$save['t_sms_two'];
                        $history['total_sms']=$alot_sms_two;
							
                        $history['user_id']=$user_id;
                        $history['user_name']=$this->input->post('name',TRUE);
						
                       insert_record(SMS_ALLOCATION_HISTORY, $history);
							
                    }
                    $upd=update_record($save, $user_id, USERS);
                        if($upd) {  
                                $this->session->set_flashdata('success', ''.$history['total_sms'].' SMS alloted in the account of '.$history['user_name'].' Now the Total Message is '.$user_total_sms.' ' );
                                redirect($this->config->item('admin_folder').'/smsapi/allocate');
                        } else {
                                $this->session->set_flashdata('error', 'Error while Alot SMS ' );
                                redirect($this->config->item('admin_folder').'/smsapi/allocate');
                        }
							print_r($history);
						exit;
                }
            $this->load->view($this->config->item('admin_folder').'/smsalot_list', $data);
        }
        
        function alot_msg($id)
        {
			$admin=$this->session->userdata();				
			if($admin['user_id']!=""){
					$user_id=$admin['user_id'];
			} else {
					$user_id=$admin['admin_id'];
			}
			$overall_sms="";
			$overall_sms=$this->User_model->get_overall_sms($id);
		/* print_r($overall_sms);
		exit; */
                $over_sms=0;
                    foreach ($overall_sms as $ovr_sms)
                    {   
                        $over_sms=$over_sms + $ovr_sms['count_msg'];
                    }
                $user_data=get_list_by_id($user_id, USERS);
				//print_r($user_data);
                $sentsms_one=$user_data['sentsms_one'];
					
                $sentsms_two=$user_data['sentsms_two'];
						
                if(empty($sentsms_one)){
                    $sentsms_one=0;
                }
                if(empty($sentsms_two)){
                    $sentsms_two=0;
                }
                $total_sent_sms=$sentsms_one + $sentsms_two;
			//print_r($total_sent_sms);
			//exit;
                    
                //echo $over_sms; exit;    
                $over_sms=$over_sms+$total_sent_sms;			   
                $data['overall_sms']=$over_sms; 		 
                $data['check']='edit';
                $data['page_title']= 'Alotgg  SMS API';
                $data['user_list']=$this->User_model->get_user_list();
                $data['sms_type']=get_list(SMS_TYPE_LIST);
                $data['sms_priority']=  get_list(SMS_PRIORITY_LIST);
                //$data['api_data']=get_list(SMS_API);
               $data['user_data']=get_list_by_id($id, USERS);
			//print_r( $data['user_data']);
              //exit;
		       $this->load->view($this->config->item('admin_folder').'/smsalot_list', $data);
		
		  
        }
	      
}
?>