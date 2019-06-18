<?php
class Teacher extends CI_Controller {

	function __construct()
	{
		parent::__construct();
                $this->load->library('auth');
                $this->load->library('csvimport');
                //ini_set('max_execution_time', 90000);
                ini_set('max_execution_time', 0);
                ini_set('memory_limit', '-1'); 
		$redirect = $this->auth->is_logged_in();
		if ($redirect == false)
		{
			$this->session->set_userdata("redirect", current_url());
			redirect($this->config->item('admin_folder').'/login');
		}
        }
        
        function index()
        {   
                $admin=$this->session->userdata();
                $user_id=$admin['user_id'];
                $user=$admin['logint_type'];
                $field='user_id';
                $data['data']=get_list_by_idd($user_id,$field,CLASS_TEACHER);
				
                /*if($logint_type=='user')
                {
                    $id=$admin['user_id'];
                    $field='user_id';
                    $data['data']=get_list_by_idd($id,$field,CLASS_TEACHER);
                } else {
                    $data['data']=get_list(CLASS_TEACHER);
                }*/
                $data['page_title']= 'Manage Teacher';
                $this->load->view($this->config->item('admin_folder').'/teacher_list', $data);
        }
        
        function import()
        {
                //ini_set('max_execution_time', 90000);
                ini_set('max_execution_time', 0);
                ini_set('memory_limit', '-1'); 
                $data['page_title']='Teacher Import';
                
                if(isset($_REQUEST['submit']))
                {
                       // $data['addressbook'] = $this->csv_model->get_addressbook();
                        $admin=$this->session->userdata();
                        $user_id=$admin['user_id'];
                        $data['error'] = '';  
                        $file_name=$_FILES['userfile']['name'];
                        $config['file_name']=$file_name;
                        $config['upload_path'] = USER_IMAGES;
                        $config['allowed_types'] = 'csv';
                        $config['max_size'] = '1000';
                        
                        //print_r($config); exit;
                        $this->load->library('upload', $config);
                        
                        if (!$this->upload->do_upload()) {
                                $this->session->set_flashdata('error', $this->upload->display_errors());
                                redirect($this->config->item('admin_folder').'/teacher/import');
                        } else {
                            $file_data = $this->upload->data();
                            $file_path = USER_IMAGES.$file_data['file_name'];
                           
                            if ($this->csvimport->get_array($file_path)) {
                                $csv_array = $this->csvimport->get_array($file_path);
                                //echo "<pre>";
                                //print_r($csv_array); exit;
                                foreach ($csv_array as $row) {
                                    $insert_data = array(
                                        'name'=>$row['name'],
                                        'employ_id'=>$row['employ_id'],
                                        'mobile_no'=>$row['mobile_no'],
                                        'email'=>$row['email'],
                                        'user_id'=>$user_id,
                                        'status'=>'Active',
                                    );
                                    $add=insert_record(CLASS_TEACHER,$insert_data); 
                                }
                                //print_r($insert_data); exit;
                                //$data['get_list']=$insert_data;
                                if($add)
                                {
                                    unlink(USER_IMAGES.$file_name);
                                    $this->session->set_flashdata('success', 'Csv Data Imported Succesfully');
                                    redirect($this->config->item('admin_folder').'/teacher/import');
                                } else {
                                    $this->session->set_flashdata('error', ' error while Csv Data Imported Succesfully');
                                    redirect($this->config->item('admin_folder').'/teacher/import');
                                }
                            }
                        }
                }
            $this->load->view($this->config->item('admin_folder').'/teacher_import', $data);
        }
        
        function mode($id='')
        {
            $data['page_title']='Add Teacher';
            $data['check']='add';
            $admin=$this->session->userdata();
            $user_id=$admin['user_id'];
            $user=$admin['logint_type'];
            $data['login_type']=$admin['logint_type'];
            $data['employ_id']=get_list_by_field('user_id',$user_id, STAFF);
            /*if($admin['logint_type']=='user')
            {
                $data['employ_id']=get_list_by_field('user_id',$admin['user_id'], STAFF);
            } else {
                $data['employ_id']=get_active_list(STAFF);
            }*/
            
            $data['mode']=base_url().$this->config->item('admin_folder').'/teacher/mode/';
            $data['val_error']='';
            $data['status']=array('Active','Inactive');
            $data['custom_error']=null;
                if($id !='')
                {
                    $data['check']='edit';
                    $data['mode']=base_url().$this->config->item('admin_folder').'/teacher/mode/'.$id;
                    $data['val_error']="";
                    $data['page_title']='Edit Teacher';
                    $data['custom_error']=null;
                    $data['data']=get_list_by_id($id,CLASS_TEACHER);
                }
                    if(isset($_REQUEST['submit']))
                    {
                        if($user!='teacher') {
                        $class_id=$this->input->post('class_id',TRUE);
                        $save['class_id']=implode(',', $class_id);
                        } 
                        $save['name']=$this->input->post('name',TRUE);
                        $save['employ_id']=$this->input->post('employ_id',TRUE);
                        $save['email']=$this->input->post('email',TRUE);
                        $save['mobile_no']=$this->input->post('mobile_no',TRUE);
                        $save['status']=$this->input->post('status',TRUE);
                        $password=$this->input->post('password');
                        $userdata['user']  = get_list_by_id($user_id, USERS);
                        $teacherdata['banner']=$userdata['user']['banner'];          
                        $teacherdata['name']=$save['name'];                        
                        $teacherdata['logint_type']='teacher';
                        $teacherdata['email']=$save['email'];
                        $teacherdata['contact']=$save['mobile_no'];
                        $teacherdata['status']=$save['status'];
                        if($password!="") {
                        $teacherdata['password']=md5($this->input->post('password',TRUE));
                        }
                        $teacherdata['school_name']=$userdata['user']['school_name'];
                        $teacherdata['institution']=$userdata['user']['institution'];
                        $teacherdata['landline_contact']=$userdata['user']['landline_contact'];
                        $teacherdata['username_one']=$userdata['user']['username_one'];
                        $teacherdata['password_one']=$userdata['user']['password_one'];
                        $teacherdata['senderid_one']=$userdata['user']['senderid_one'];
                        $teacherdata['smstype_one']=$userdata['user']['smstype_one'];
                        $teacherdata['prioritydetails_one']=$userdata['user']['prioritydetails_one'];
                        $teacherdata['total_sms_one']=$userdata['user']['total_sms_one'];
                        $teacherdata['sentsms_one']=$userdata['user']['sentsms_one'];
                        $teacherdata['status_one']=$userdata['user']['status_one'];
                        $teacherdata['username_two']=$userdata['user']['username_two'];
                        $teacherdata['password_two']=$userdata['user']['password_two'];
                        $teacherdata['senderid_two']=$userdata['user']['senderid_two'];
                        $teacherdata['smstype_two']=$userdata['user']['smstype_two'];
                        $teacherdata['prioritydetails_two']=$userdata['user']['prioritydetails_two'];
                        $teacherdata['total_sms_two']=$userdata['user']['total_sms_two'];
                        $teacherdata['sentsms_two']=$userdata['user']['sentsms_two'];
                        $teacherdata['status_two']=$userdata['user']['status_two'];
                        $teacherdata['api_two_hash']=$userdata['user']['api_two_hash'];
                        $teacherdata['r_sms_one']=$userdata['user']['r_sms_one'];
                        $teacherdata['r_sms_two']=$userdata['user']['r_sms_two'];
                        $teacherdata['t_sms_one']=$userdata['user']['t_sms_one'];
                        $teacherdata['t_sms_two']=$userdata['user']['t_sms_two'];
                        $teacherdata['red_sms_one']=$userdata['user']['red_sms_one'];
                        $teacherdata['red_sms_two']=$userdata['user']['red_sms_two'];
                        $teacherdata['language_option']=$userdata['user']['language_option'];
                        
                            //check email id valid or not
                            //$check_email_val=check_email_validation($save['email']);                            
                            //check number
                            $check_contact=allow_only_number($save['mobile_no']);                            
                            //check empty records 
                            /*$check_required_val=check_required($save);
                        
                            if($check_required_val)
                            {        
                                    $data['val_error']='(*) field must be required !! ';
                            } 
                            
                            if($check_email_val==TRUE)
                            {   
                                    $data['val_error']='Email id is not valid';
                            }*/
                            
                            if($check_contact==TRUE)
                            {
                                    $data['val_error']='Only number allow on Mobile number';
                            }
                            $data['data']=$save;
                            $data['id']=$id;
                                if($id=='')
                                {
                                    //check already exits value
                                    $check_employ_id = check_data_exist('employ_id',$save['employ_id'],CLASS_TEACHER);
                                    
                                    //check email id already exits
                                    $check_email=  check_email_exist($save['email'], CLASS_TEACHER);
                                    
                                    /*if($check_email)
                                    {
                                            $data['val_error']='email id already exits';
                                    }
                                    
                                    if($check_employ_id)
                                    {
                                            $data['val_error']='employ id already exits';
                                    }*/
                                    
                                    $save['user_id']=$user_id;
                                    $str=$save['name'];
                                    $save['slug']=createSlugUrl(CLASS_TEACHER,$str);
                                    if($data['val_error']=='') 
                                    {
                                        /*echo "<pre>";
                                        print_r($teacherdata);
                                        
                                        print_r($userdata['user']);
                                        die;*/
                                        $teacherdata['slug']=$save['slug'];
                                        $adduser=insert_record(USERS, $teacherdata);
                                        $last_insert_id=$this->db->select('id')->order_by('id',"desc")->limit(1)->get(USERS)->result_array();
                                        $save['login_id']=$last_insert_id[0]['id'];
                                        $add=insert_record(CLASS_TEACHER, $save);
                                        if($add && $adduser){
                                                    $this->session->set_flashdata('success', 'You have successfully Added teacher !!' );
                                                    redirect($this->config->item('admin_folder').'/teacher');
                                        } else {
                                                    $this->session->set_flashdata('error', 'Error while adding teacher !!' );
                                                    redirect($this->config->item('admin_folder').'/teacher');
                                        }
                                    }
                                } else {
                                        $id=$this->input->post('data_id',TRUE);
                                        $login_id=$this->input->post('login_id',TRUE);
                                        $str=$save['name'];
                                        $save['editdate']=date("Y-m-d h:m:s");
                                        $save['slug']=createSlugUrl(CLASS_TEACHER,$str);
                                        $teacherdata['slug']=$save['slug'];
                                        if($data['val_error'] == '')
                                        {
                                            $resultuser=check_user_exist_or_not(USERS,$save['email']);                                      if(empty($resultuser)) {                                             
                                            $adduser=insert_record(USERS, $teacherdata);
                                            $last_insert_id=$this->db->select('id')->order_by('id',"desc")->limit(1)->get(USERS)->result_array();
                                            $save['login_id']=$last_insert_id[0]['id'];
                                            $upd = update_record($save,$id,CLASS_TEACHER);
                                            } else {
                                            $upduser = update_record($teacherdata,$login_id,USERS);
                                            $upd = update_record($save,$id,CLASS_TEACHER);
                                            }
                                            if($upd) 
                                            {       
                                                    $this->session->set_flashdata('success', 'You have successfully updated teacher !!' );
                                                    if($user!='teacher') {
                                                    redirect($this->config->item('admin_folder').'/teacher');
                                                    } else {
                                                    redirect($this->config->item('admin_folder').'/dashboard');
                                                    }
                                            } else {
                                                    $this->session->set_flashdata('error', 'Error while updating teacher!!');
                                                    redirect($this->config->item('admin_folder').'/teacher/mode');
                                            }
                                        }
                                }
                        }
                      
                $this->load->view($this->config->item('admin_folder').'/teacher_form', $data);
        }
        
        //delete single record
        function delete($id)
	{       
		$del =delete_single_rec($id,CLASS_TEACHER);
		if($del){
			$this->session->set_flashdata('success', 'You have successfully deleted teacher !!' );
			redirect($this->config->item('admin_folder').'/teacher');
		}else{
			$this->session->set_flashdata('error', 'Error while deleting teacher !!' );
			redirect($this->config->item('admin_folder').'/teacher');
		}
	}
        
        function mul_action()
        {
            $action_val= $_REQUEST['mul_val'];
            $arr_ids= $_REQUEST['mul_id'];
            $path='/teacher';
            $table=CLASS_TEACHER;
            multiple_action($arr_ids, $action_val, $table, $path);
        }
        
        function change_status()
        {
            $id=$_REQUEST['id'];
            $status=$_REQUEST['status'];
            $table=CLASS_TEACHER;
            if($status== 'true')
            {   
                $status='Active';    
                $result=change_status($id,$status,$table);       
                echo $result;
            }
            else
            {   
                $status='Inactive';
                $result=change_status($id,$status,$table);       
                echo $result;
            }

        }
        
}
?>