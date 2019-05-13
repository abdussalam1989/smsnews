<?php
class Contact extends CI_Controller {

	function __construct()
	{
		parent::__construct();
                $this->load->library('auth');
                $this->load->model('User_model');
                $this->load->model('Contact_model');
		$redirect=$this->auth->is_logged_in();
		if($redirect == false)
		{
			$this->session->set_userdata("redirect", current_url());
			redirect($this->config->item('admin_folder').'/login');
		}
        }
        
        function index()
        {
            $admin=$this->session->userdata();
            $user_id=$admin['user_id'];
            if($user_id != '' ) {
                    $data['contact_list']=  $this->Contact_model->get_list_contact($user_id);
				
            } else {
                    $data['contact_list']=get_list(CONTACT_US);
					 echo '<pre>';
				print_r($data['contact_list']);
				exit;
					
            }
            $data['page_title']='Manage Manager';
            $this->load->view($this->config->item('admin_folder').'/contact_list', $data);
        }
        
        //for add or ediit contact records
        function mode($id='')
        {   
            $data['check']='add';
            $data['mode']=base_url().$this->config->item('admin_folder').'/contact/mode/';
            $data['val_error']="";
            $data['required']='<span class="has-error">*</span>';
            $data['page_title']='Add Manager';
            $data['custom_error']=null;
            $data['user_data']=$this->User_model->get_user_list();
			
				
                if($id != '') {
                    $data['check']='edit';
                    $data['mode']=base_url().$this->config->item('admin_folder').'/contact/mode/'.$id;
                    $data['val_error']="";
                    $data['required']='<span class="has-error">*</span>';
                    $data['page_title']='Edit Manager';
                    $data['custom_error']=null;
                    $data['list']=get_list_by_id($id,CONTACT_US);
				
                }
                    if(isset($_REQUEST['submit']))
                    {
                           // echo "heelo"; exit;
                            $save['name']=$this->input->post('name',TRUE);
                            $save['user_id']=$this->input->post('user_id',TRUE);
                            $save['email']=$this->input->post('email',TRUE);
                            $save['phone']=$this->input->post('phone',TRUE);
                            $save['message']=$this->input->post('message',TRUE);
                            $id=$this->input->post('c_id',TRUE);       
                           
                            //print_r($save); exit;
                            //check empty records 
                            $check_required_val=check_required($save);
                            
                            //check name
                            $check_name=allow_only_character($save['name'] );
                            
                            //check email id valid or not
                            $check_email_val=check_email_validation($save['email']);
                            
                            //check number
                            $check_contact=allow_only_number($save['phone']);
                            
                            if($check_required_val)
                            {        
                                    $data['val_error']='(*) field must be required !! ';
                            }
                            
                            if($check_email_val)
                            {   
                                    $data['val_error']='Email id is not valid';
                            }

                            if($check_name)
                            {
                                    $data['val_error']='Only character allow on name ';
                            }
                            
                            if($check_contact)
                            {
                                    $data['val_error']='Only number allow on phone number';
                            }
                            
                            
                           //print_r($save); exit;
                            if($data['val_error'] == '')
                            {
                                if($id==""){
                                       $add=insert_record(CONTACT_US,$save);
                                       
                                       if($add){
                                            $this->session->set_flashdata('success', 'You have successfully add Record!!' );
                                            redirect($this->config->item('admin_folder').'/contact');
                                       } else {
                                            $this->session->set_flashdata('error', 'Error while updating Record!!' );
                                            redirect($this->config->item('admin_folder').'/contact/mode');
                                       }
                                } else  {
                                    $save['follow_up_note']=$this->input->post('follow_up_note',TRUE);
                                    $save['followup_datetime']=$this->input->post('followup_datetime',TRUE);
                                    $save['followup_time']=$this->input->post('followup_time',TRUE);

                                        $upd = update_record($save,$id,CONTACT_US);
                                        if($upd) 
                                        {       
                                                $this->session->set_flashdata('success', 'You have successfully update Record!!' );
                                                redirect($this->config->item('admin_folder').'/contact');
                                        } 
                                        else 
                                        {
                                                $this->session->set_flashdata('error', 'Error while updating email record!!' );
                                                redirect($this->config->item('admin_folder').'/contact/mode');
                                        }
                                } 
                            }
                    }
            $this->load->view($this->config->item('admin_folder').'/contact_form', $data);
        }
        
        //for view contacts
        function view($id)
	{           
                $data['mode']=base_url().$this->config->item('admin_folder').'/contact/mode/'.$id;
                $data['custom_error']=null;
                $data['check']='view';
                $data['val_error']="";
                $data['required']=':';
		$data['page_title'] = 'View Contact';
		$data['list']=get_list_by_id($id,CONTACT_US);
		
		$this->load->view($this->config->item('admin_folder').'/contact_form', $data);
	}
        
        //for delete single record
        function delete($id)
	{
                $table=CONTACT_US;
		$del=delete_single_rec($id, $table);
		if($del){
			$this->session->set_flashdata('success', 'You have successfully deleted Record !!' );
			redirect($this->config->item('admin_folder').'/Contact');
		}else{
			$this->session->set_flashdata('error', 'Error while deleting Record !!' );
			redirect($this->config->item('admin_folder').'/Contact');
		}
	}
        
        //for multiple delete active/inactive
        function mul_action()
        {
                $action_val= $_REQUEST['mul_val'];
                $arr_ids= $_REQUEST['mul_id'];
                $path='/contact';
                $table=CONTACT_US;
                multiple_action($arr_ids, $action_val, $table, $path);
        }
        
        
}