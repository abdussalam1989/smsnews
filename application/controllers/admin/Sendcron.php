<?php
class Sendcron extends CI_Controller {
    
	function __construct()
	{
		parent::__construct();
                $this->load->library('auth');
                ini_set('max_execution_time', 0);
                ini_set('memory_limit', '-1'); 
                $this->load->model('Data_model');
                //
        }
        
        function send_sms_using_cron_job()
        {
                $get_pending_data=$this->Data_model->get_pending_sms_rec();
                if(!empty($get_pending_data)){
                $tot_time=0;
                //log_message('error','for start');
                foreach ($get_pending_data as $pending_data)
                {   
                    $id=$pending_data['id'];
                    $count_sms=$pending_data['count_msg'];
                    $user_id=$pending_data['user_id'];
                    $mobile_no=$pending_data['mobile_no'];
                    $message=urlencode($pending_data['message']);
                    $get_user_list=get_list_by_id($user_id, USERS);                        
                        if($pending_data['api_name']=='two'){
                            $api_username=$get_user_list['username_two'];
                            $api_hash=$get_user_list['api_two_hash'];
                            $api_sender=$get_user_list['senderid_two'];
                            $api_schedule_link=API2_INSTANT_LINK;
                        }
                        
                    if($pending_data['sms_type'] != 'Schedule') {
                        if($pending_data['api_name']=='two'){
                            $link=$api_schedule_link.'username='.$api_username.'&hash='.$api_hash.'&numbers=91'.$mobile_no.'&sender='.$api_sender.'&message='.$message;
                            $send_report=call_send_sms_link_api($link);
                            if($send_report == FALSE){
                                $save['is_send']=0;
                            } else {
                                $save['is_send']=1;
                                if($send_report['status']=='success'){
                                        $save['msg_status']='Delivered';
                                } else {
                                        $save['msg_status']=$send_report['status'];
                                        $user_data=get_list_by_id($user_id,USERS);
                                        $sms_upd['total_sms_two']=$user_data['total_sms_two']+$count_sms;
                                        update_record($sms_upd, $user_id, USERS);
                                }
                                if($send_report['status']=='failure'){
                                        $save['api_message']=$send_report['errors'][0]->message; 
                                }
                            }
                        }
                     } else {
                        if(isset($pending_data['schedule_date'])) {
                            $date=explode(" ",$pending_data['schedule_date']);
                            $s_data=$date[0]."%20".$date[1];
                            if($pending_data['api_name']=='two'){
                               $link=$api_schedule_link.'username='.$api_username.'&hash='.$api_hash.'&numbers=91'.$mobile_no.'&sender='.$api_sender.'&message='.$message.'&time='.$s_data;
                              
						                                
							   $send_report=call_send_sms_link_api($link);
                                    if($send_report == FALSE){
                                            $save['is_send']=0;
                                    } else {
                                            $save['is_send']=1;
                                        if($send_report['status']=='success'){
                                            $save['msg_status']='Delivered';
                                        } else {
                                            $save['msg_status']=$send_report['status'];
                                            $user_data=get_list_by_id($user_id,USERS);
                                            $sms_upd['total_sms_two']=$user_data['total_sms_two']+$count_sms;
                                            update_record($sms_upd, $user_id, USERS);
                                        }
                                        if($send_report['status']=='failure'){
                                            $save['api_message']=$send_report['errors'][0]->message; 
                                        }
                                    }
                            }
                        }
								  
                    }
							  
                    $date=get_current_date_time();
                    $save['is_send_datetime']=$date;
                    update_record($save, $id, SMS_LOG);   
                    unset($save);
                }
                } else {
                    echo "There is no Message to send";
                }        
        }
        
        
        function send_sms_from_apione_using_cron_job()
        {
                $get_pending_data=$this->Data_model->get_pending_sms_rec_from_apione();
                if(!empty($get_pending_data)){
                $tot_time=0;
                foreach ($get_pending_data as $pending_data)
                {   
                        $id=$pending_data['id'];
                        $count_sms=$pending_data['count_msg'];
                        $user_id=$pending_data['user_id'];
                        $mobile_no=$pending_data['mobile_no'];
                        $message=urlencode($pending_data['message']);        
                        $get_user_list=get_list_by_id($user_id,USERS);
                        if($pending_data['api_name']=='one'){
                                $api_username=$get_user_list['username_one'];
                                $api_password=$get_user_list['password_one'];
                                $api_sender=$get_user_list['senderid_one'];
                                $api_type=$get_user_list['smstype_one'];
                                $api_priority=$get_user_list['prioritydetails_one'];
                                $api_schedule_link=API1_SCHEDULE_LINK;
                                $api_instant_link=API1_INSTANT_LINK;
                                $api_status_link=API1_GETSTATUS_LINK;
                        }
                        
                        if($pending_data['sms_type'] != 'Schedule') {
                            if($pending_data['api_name']=='one') {
                                  echo   $link=$api_instant_link.'user='.$api_username.'&pass='.$api_password.'&sender='.$api_sender.'&phone='.$mobile_no.'&text='.$message.'&priority='.$api_priority.'&stype='.$api_type;
                                  
								  $send_sms=send_api_one_sms($link);
                                    if($send_sms == FALSE){
                                        $save['is_send']=0; 
                                    } else {
                                        $save['is_send']=2;
                                        $save['api_message']=trim($send_sms);
                                    }
                            }
                        }  else {
                            if(isset($pending_data['schedule_date'])) {
                                $date=explode(" ",$pending_data['schedule_date']);
                                $s_data=$date[0]."%20".$date[1];
                                if($pending_data['api_name']=='one'){
                                  echo  $link=$api_schedule_link.'user='.$api_username.'&pass='.$api_password.'&sender='.$api_sender.'&phone='.$mobile_no.'&text='.$message.'&priority='.$api_priority.'&stype='.$api_type.'&time='.$s_data;
                                $send_sms=send_api_one_sms($link);
							  
                                    if($send_sms == FALSE){
                                        $save['is_send']=0;
                                    } else {
                                        $save['is_send']=2;
                                        $save['api_message']=trim($send_sms);
                                    }
                                }
                            }
                        }
                    $date=get_current_date_time();
                    $save['is_send_datetime']=$date;
                    update_record($save, $id, SMS_LOG);
                    unset($save);
                }
                
                } else {
                    echo "There is no Message to send";
                }
        }
        
        function get_apione_status()
        {
                $get_pending_data=$this->Data_model->get_apione_status();
                if(!empty($get_pending_data)){
                $tot_time=0;
                //log_message('error','for start');
                foreach ($get_pending_data as $pending_data)
                {   
                        $id=$pending_data['id'];
                        $count_sms=$pending_data['count_msg'];
                        $user_id=$pending_data['user_id'];
                        $mobile_no=$pending_data['mobile_no'];
                        $message=urlencode($pending_data['message']);
                        $get_user_list=get_list_by_id($user_id, USERS);
                        
                        if($pending_data['api_name']=='one'){
                                $api_username=$get_user_list['username_one'];
                                $api_password=$get_user_list['password_one'];
                                $api_sender=$get_user_list['senderid_one'];
                                $api_type=$get_user_list['smstype_one'];
                                $api_priority=$get_user_list['prioritydetails_one'];
                                $api_schedule_link=API1_SCHEDULE_LINK;
                                $api_instant_link=API1_INSTANT_LINK;
                                $api_status_link=API1_GETSTATUS_LINK;
                        }
                    if($pending_data['sms_type'] != 'Schedule') {
                        if($pending_data['api_name']=='one') {
                                $send_sms=trim($pending_data['api_message']);
                                if(!empty($send_sms)) {
                                    $cnt_str=substr_count($send_sms,'S');
                                    if($cnt_str > 0) {
                                        $arr_val=explode(" ",$send_sms);
                                        $send_sms=$arr_val[0];
                                        unset($cnt_str);
                                    }
                                    $check_status=$api_status_link.'user='.$api_username.'&msgid='.$send_sms.'&phone='.$mobile_no.'&msgtype='.$api_type;
                                    $sms_status=send_api_one_sms($check_status);
                                    if($sms_status == FALSE){
                                        $save['is_send']=2;
                                    } else {
                                        $save['is_send']=1;
                                        //if($sms_status=='Sent' || $sms_status=='DELIVRD') {
                                        if(isset($sms_status)) {
                                            $save['msg_status']=$sms_status;
                                        } else {
                                            $save['msg_status']=$sms_status;
                                            //$save['api_message']=$sms_status;
                                            $user_data=get_list_by_id($user_id,USERS);
                                            $sms_upd['total_sms_one']=$user_data['total_sms_one'] + $count_sms;
                                            update_record($sms_upd, $user_id, USERS);
                                        }
                                    }
                                }
                                unset($link); unset($check_status);
                        }
                    }  else {
                        if(isset($pending_data['schedule_date'])) {
                            $date=explode(" ",$pending_data['api_message']);
                            $s_data=$date[0]."%20".$date[1];
                            if($pending_data['api_name']=='one'){
                                $send_sms=$pending_data['api_message'];
                                if(!empty($send_sms)) {
                                    $cnt_str=substr_count($send_sms,'S');
                                    if($cnt_str > 0) {
                                        $arr_val=explode(" ",$send_sms);
                                        $send_sms=$arr_val[0];
                                        unset($cnt_str);
                                    }
                                    $check_status=$api_status_link.'user='.$api_username.'&msgid='.$send_sms.'&phone='.$mobile_no.'&msgtype='.$api_type;
                                    $sms_status=send_api_one_sms($check_status);
                                    if($sms_status == FALSE){
                                        $save['is_send']=2;
                                    } else {
                                        $save['is_send']=1;
                                    }
                                    //$sms_status=send_api_one_sms($check_status);
                                    //if($sms_status=='Sent' || $sms_status=='DELIVRD') {
                                    if(isset($sms_status)) {
                                        $save['msg_status']=$sms_status;
                                    } else {
                                        $save['msg_status']=$sms_status;
                                        $save['api_message']=$sms_status;
                                        //sms add into user account
                                        $user_data=get_list_by_id($user_id,USERS);
                                        $sms_upd['total_sms_one']=$user_data['total_sms_one']+$count_sms;
                                        update_record($sms_upd, $user_id, USERS);
                                    }
                                }
                            }
                        }
                    }
                    $date=get_current_date_time();
                    $save['is_send_datetime']=$date;
                    update_record($save,$id,SMS_LOG);
                    unset($save);
                }
                //log_message('error', 'total time '.$tot_time);
                } else {
                    echo "There is no Message to send";
                }
        }
                
        function change_sms_status()
        {
                $this->db->set('is_send',1);
                $this->db->update(SMS_LOG);
                echo "how are you ?";
               //echo $this->db->last_query();
        }
        //DELIVRD
}
?>