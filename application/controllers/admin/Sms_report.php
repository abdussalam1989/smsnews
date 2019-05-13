<?php
class Sms_report extends CI_Controller {
    
	function __construct()
	{
		parent::__construct();
                $this->load->library('auth');
                $this->load->model('Data_model');
		$redirect = $this->auth->is_logged_in();
		if($redirect == false)
		{
			$this->session->set_userdata("redirect", current_url());
			redirect($this->config->item('admin_folder').'/login');
		}
        }
        
        function index()
        {   
                $admin=$this->session->userdata();
					$this->load->library('session');
                $user_id=$admin['user_id'];
                $user=$admin['logint_type'];
                $field='user_id';
                $data['data']=get_list_by_idd($user_id,$field,SMS_TEMPLATE);
                
                /*if($logint_type=='user')
                {
                    $id=$admin['user_id'];
                    $field='user_id';
                    $data['data']=get_list_by_idd($id,$field,SMS_TEMPLATE);
                } else {
                    $data['data']=get_list(SMS_TEMPLATE);
                }*/
                $data['page_title']= 'Manage SMS Temp';
                $this->load->view($this->config->item('admin_folder').'/sms_list', $data);
				
        }
       
        function ExportCSV()
        {
				//echo "Aftab Siddiqui";die;
            $data['page_title']= 'SMS Report';
            $data['check_val']='';
            $admin=$this->session->userdata();
            $user_id=$admin['user_id'];
            $field='user_id';
          // $data['get_list']=get_list_by_idd($user_id,$field,SMS_LOG);
		     $this->session->userdata;
		 	$var = $this->session->userdata;
             $first_date= $var['first_date'];
		     $second_date= $var['second_date'];
	
		    if($first_date){
			  
          
			  $data['get_list']=$this->Data_model->search_sms_report($first_date,$second_date,$user_id); 
			$this->session->unset_userdata('first_date'); 
			$this->session->unset_userdata('second_date'); 
			$this->session->unset_userdata('first_date');
$this->session->unset_userdata('second_date');
$this->session->sess_destroy();	
		  }
		  else
		  
			$data['get_list']=get_list_by_idd($user_id,$field,SMS_LOG); 
			    
			  
		
			$fileName = "codexworld_export_data" . date('Ymd') . ".xls";
    
    // headers for download
    header("Content-Disposition: attachment; filename=\"$fileName\"");
    header("Content-Type: application/vnd.ms-excel");

	
foreach($data['get_list'] as $username) {
 
  
  
	 $datalist[] = array('Status' => $username['msg_status'], 'Message' => $username['message'], 'Date' => $username['adddate'], 'Time' => $username['addtime'], 'contact' => $username['mobile_no'], 'Message Count' => $username['count_msg']);
	
  
}



						  
    $flag = false;
    foreach($datalist as $row) {
        if(!$flag) {
            // display column names as first row
            echo implode("\t", array_keys($row)) . "\n";
            $flag = true;
        }
        // filter data
        
        echo implode("\t", array_values($row)) . "\n";

    }
		     function filterData(&$str)
    {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }   			
          
$this->session->unset_userdata('first_date');
$this->session->unset_userdata('second_date');
$this->session->sess_destroy();		  
        }
    	

     

     
      
}
?>