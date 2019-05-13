<?php
class Email_templates extends CI_Controller {

	function __construct()
	{
		parent::__construct();
                $this->load->library('auth');
                $this->load->model('Email_templates_model');
		$redirect=$this->auth->is_logged_in();
		if($redirect == false)
		{
			$this->session->set_userdata("redirect", current_url());
			redirect($this->config->item('admin_folder').'/login');
		}
        }
        
        function index()
        {
            $data['etemplates_list']=get_list(EMAIL_TEMPLATES);
            $data['page_title']='Manage Email Templates';
            $this->load->view($this->config->item('admin_folder').'/email_templates_list', $data);
        }
        
        //for add and edit email template
        function mode($id='')
        {
            $data['check']='edit';
            $data['mode']=base_url().$this->config->item('admin_folder').'/email_templates/mode/'.$id;
            $data['val_error']="";
            $data['page_title']='Edit Email Templates';
            $data['custom_error']=null;
            $data['list']=get_list_by_id($id,EMAIL_TEMPLATES);
                    if(isset($_REQUEST['submit']))
                    {
                            $save['title'] = $this->input->post('template_name',TRUE);
                            $save['subject'] = $this->input->post('email_subject',TRUE);
                            $save['mail_content'] = $this->input->post('editor1',TRUE);
                            $id=$this->input->post('template_id',TRUE);
                            $save['editdatetime']=date("y-m-d h:m:s");
                            //check empty records 
                            $check_required_val=check_required($save);
                            
                            if($check_required_val)
                            {        
                                    $data['val_error']='(*) field must be required !! ';
                            }
                                if($data['val_error'] == '')
                                {
                                    $upd = update_record($save,$id,EMAIL_TEMPLATES);
                                    if($upd) 
                                    {       
                                            $this->session->set_flashdata('success', 'You have successfully updated email templates !!' );
                                            redirect($this->config->item('admin_folder').'/email_templates');
                                    } 
                                    else 
                                    {
                                            $this->session->set_flashdata('error', 'Error while updating email templates!!' );
                                            redirect($this->config->item('admin_folder').'/email_templates/mode');
                                    }
                                }
                    }
            $this->load->view($this->config->item('admin_folder').'/email_templates_form',$data);
        }
        
        // for perfoum multiple active / inactive and delete
        function mul_action()
        {
            $action_val=$_REQUEST['mul_val'];
            $arr_ids=$_REQUEST['mul_id'];
            $path='/email_templates';
            $table=EMAIL_TEMPLATES;
            multiple_action($arr_ids, $action_val, $table, $path);
        }
            
        // for change single status
        function change_status()
        {
            $id=$_REQUEST['id'];
            $status=$_REQUEST['status'];
            $table=EMAIL_TEMPLATES;
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