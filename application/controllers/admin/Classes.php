<?php
class Classes extends CI_Controller {

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
                $data['data']=get_list_by_idd($user_id,$field,CLASSES);
                $data['page_title']= 'Manage Class';
                $this->load->view($this->config->item('admin_folder').'/classes_list', $data);
        }

        function assign()
        {   
                $admin=$this->session->userdata();
                $user_id=$admin['user_id'];
                $user=$admin['logint_type'];
                $field='user_id';
                $data['teacher']=get_teacher_list_by_idd($user_id,$field,CLASS_TEACHER);
                $data['get_group_list'] = get_list_by_user_id($user_id, CLASSES);                
                $data['page_title']= 'Assign Class To Teacher';
                $this->load->view($this->config->item('admin_folder').'/classes_assign', $data);
        }

        function assign_class() {
          if(isset($_REQUEST['submit'])){
            $class_id=$this->input->post('check_id',true);
            if(!empty($class_id)) {
            $teacher_id=$this->input->post('teacher',true);
            $k=0;
            $j=0;
            foreach($class_id as $key=>$class) {                              
                $teacherdetail=get_property_info('id',$teacher_id,CLASS_TEACHER);
                $value=explode(',',$teacherdetail['class_id']);
                if(!in_array($class, $value)) {
                $data['class_id']="";
                if($teacherdetail['class_id']=="") {
                  $data['class_id']=$class;
                } else {
                  $data['class_id'].=$teacherdetail['class_id'].",".$class;
                }               
                $updateuser=update_table_record($data,$teacher_id,CLASS_TEACHER);                                
                } else {
                 $j++;
                }
                $k++;                           
            }
             if($j>0) {
                 $this->session->set_flashdata('error', ''.$j.' Assign class to teacher had error while assign class to teacher is '.$k.'!!'); 
            } else {
                    $this->session->set_flashdata('success', 'You have successfully Assigned class to teacher.');
            }
            } else {
               
               $this->session->set_flashdata('error', 'Please select class');  
            }  
                 
          } 
           redirect($this->config->item('admin_folder').'/classes/assign'); 
        }
        
        function mode($id='')
        {
            $data['page_title']='Add Class';
            $data['check']='add';
            $data['status']=array('Active','Inactive');
            $admin=$this->session->userdata();
            $user_id=$admin['user_id'];
            $user=$admin['logint_type'];
            $data['class_teacher']=get_list_by_field('user_id',$user_id,CLASS_TEACHER);
			
            //$data['class_teacher']=get_active_list(CLASS_TEACHER);
            
            /*if($admin['logint_type']=='user') {
                $data['class_teacher']=get_list_by_field('user_id',$admin['user_id'],CLASS_TEACHER);
            }*/
            $data['mode']=base_url().$this->config->item('admin_folder').'/classes/mode/';
            $data['val_error']='';
            $data['custom_error']=null;
                if($id !='')
                {
                    $data['check']='edit';
                    $data['mode']=base_url().$this->config->item('admin_folder').'/classes/mode/'.$id;
                    $data['val_error']="";
                    $data['page_title']='Edit Class';
                    $data['custom_error']=null;
                    $data['data']=get_list_by_id($id,CLASSES);
                }
                    if(isset($_REQUEST['submit']))
                    {
                        $save['name']=$this->input->post('name',TRUE);
                        $save['class_group_id']=$this->input->post('class_group',TRUE);
                        
                        $save['status']=$this->input->post('status',TRUE);
                        
                            //check empty records 
                            $check_required_val=check_required($save);
                            
                            if($check_required_val)
                            {        
                                    $data['val_error']='(*) field must be required !! ';
                            }  
                            $save['class_teacher']=$this->input->post('class_teacher',TRUE);
                            
                                if($id=='')
                                {
                                    $admin=$this->session->userdata();
                                    $user_id=$admin['user_id'];
                                    $user=$admin['logint_type'];
                                    $save['user_id']=$user_id;
                                    $str=$save['name'];
                                    $save['slug']=createSlugUrl(CLASSES,$str);
                                    if($data['val_error']=='') 
                                    {
                                        $add=insert_record(CLASSES, $save);
                                        if($add) {
                                                $this->session->set_flashdata('success', 'You have successfully Added classes !!' );
                                                redirect($this->config->item('admin_folder').'/classes');
                                        } else {
                                                $this->session->set_flashdata('error', 'Error while adding classes !!' );
                                                redirect($this->config->item('admin_folder').'/classes');
                                        }
                                    }
                                }
                                else
                                {
                                        $id=$this->input->post('data_id',TRUE);
                                        $save['editdate']=date("Y-m-d h:m:s");
                                        if($data['val_error'] == '')
                                        {
                                            $upd = update_record($save,$id,CLASSES);
                                            if($upd) 
                                            {       
                                                    $this->session->set_flashdata('success', 'You have successfully updated classes !!' );
                                                    redirect($this->config->item('admin_folder').'/classes');
                                            } else {
                                                    $this->session->set_flashdata('error', 'Error while updating classes!!' );
                                                    redirect($this->config->item('admin_folder').'/classes/mode');
                                            }
                                        }
                                }
                        }
                $this->load->view($this->config->item('admin_folder').'/classes_form', $data);
        }
        
        function mul_action()
        {
            $action_val= $_REQUEST['mul_val'];
            $arr_ids= $_REQUEST['mul_id'];
            $path='/classes';
            $table=CLASSES;
            multiple_action($arr_ids, $action_val, $table, $path);
        }
        
        function import()
        {
                //ini_set('max_execution_time', 90000);
                ini_set('max_execution_time', 0);
                ini_set('memory_limit', '-1'); 
                $data['page_title']='Class Import';
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
                                redirect($this->config->item('admin_folder').'/classes/import');
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
                                        'class_teacher'=>$row['class_teacher'],
                                        'user_id'=>$user_id,
                                        'class_group_id'=>$row['class_group_id'],
                                        'status'=>'Active',
                                    );
                                    $add=insert_record(CLASSES,$insert_data); 
                                }
                                if($add)
                                {
                                    unlink(USER_IMAGES.$file_name);
                                    $this->session->set_flashdata('success', 'Csv Data Imported Succesfully');
                                    redirect($this->config->item('admin_folder').'/classes/import');
                                } else {
                                    $this->session->set_flashdata('error', ' error while Csv Data Imported Succesfully');
                                    redirect($this->config->item('admin_folder').'/classes/import');
                                }
                            }
                        }
                }
            $this->load->view($this->config->item('admin_folder').'/class_import', $data);
        }
        
        function change_status()
        {
            $id=$_REQUEST['id'];
            $status=$_REQUEST['status'];
            $table=CLASSES;
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

        function getclassgroup() {
        $admin = $this->session->userdata();
        $user_id = $admin['user_id'];
        $user = $admin['logint_type'];
        $field='user_id';     
        $data['teacher']=get_teacher_list_by_idd($user_id,$field,CLASS_TEACHER);
        //$data['get_class_list']=get_list_by_user_id($user_id,CLASSES);
        $data['page_title'] = 'Assign Class To Teacher';
      
        $value = $this->input->post('class_name', TRUE);
        $data['class_group_id'] = $value;

        if($value == 'All') {
             $data['get_group_list']=get_list_by_user_id($user_id, CLASSES);

        }
        else {
            $data['get_group_list']=get_class_list_by_user_id($user_id, $value, CLASSES);                  
        }
       
        $this->load->view($this->config->item('admin_folder').'/classes_assign', $data);
    }
        
}
?>