<?php
class Homework extends CI_Controller {
    
	function __construct()
	{
		parent::__construct();
                $this->load->library('auth');
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
                $user_id=$admin['user_id'];
                $user=$admin['logint_type'];
                $field='user_id';
                $data['data']=get_list_by_idd($user_id,$field,HOMEWORK);
                /*if($logint_type=='user')
                {
                    $id=$admin['user_id'];
                    $field='user_id';
                    $data['data']=get_list_by_idd($id,$field,HOMEWORK);
                } else {
                    $data['data']=get_list(HOMEWORK);
                }*/
                
                $data['page_title']= 'Manage Homework';
                $this->load->view($this->config->item('admin_folder').'/homework_list', $data);
        }
        
        function mode($id='')
        {
            $data['page_title']='Add Homework';
            $data['check']='add';
            $data['status']=array('Active','Inactive');
            $data['mode']=base_url().$this->config->item('admin_folder').'/homework/mode/';
            $data['val_error']='';
            $admin=$this->session->userdata();
            $user_id=$admin['user_id'];
            $user=$admin['logint_type'];
            $data['custom_error']=null;
                if($id !='')
                {
                    $data['check']='edit';
                    $data['mode']=base_url().$this->config->item('admin_folder').'/homework/mode/'.$id;
                    $data['val_error']="";
                    $data['page_title']='Edit Homework';
                    $data['custom_error']=null;
                    $data['data']=get_list_by_id($id,HOMEWORK);
                }
                    if(isset($_REQUEST['submit']))
                    {
                        $save['name']=$this->input->post('name',TRUE);
                        $save['template_text']=$this->input->post('template_text',TRUE);
                        $save['status']=$this->input->post('status',TRUE);
                        
                            //check empty records 
                            $check_required_val=check_required($save);
                        
                            if($check_required_val)
                            {        
                                    $data['val_error']='(*) field must be required !! ';
                            }  
                            
                                if($id=='')
                                {                        
                                    $save['user_id']=$user_id;
                                    $str=$save['name'];
                                    $save['slug']=createSlugUrl(STUDENT,$str);
                                    if($data['val_error']=='') 
                                    {
                                        $add=insert_record(HOMEWORK, $save);
                                        if($add){
                                                    $this->session->set_flashdata('success', 'You have successfully Added Assignment !!' );
                                                    redirect($this->config->item('admin_folder').'/homework');
                                        } else {
                                                    $this->session->set_flashdata('error', 'Error while adding Assignment !!' );
                                                       redirect($this->config->item('admin_folder').'/homework');
                                        }
                                    }
                                }
                                else
                                {
                                        $id=$this->input->post('data_id',TRUE);
                                        $save['editdate']=date("Y-m-d h:m:s");
                                        if($data['val_error'] == '')
                                        {
                                            $upd = update_record($save,$id,HOMEWORK);
                                            if($upd) 
                                            {       
                                                    $this->session->set_flashdata('success', 'You have successfully updated Assignment !!' );
                                                    redirect($this->config->item('admin_folder').'/homework');
                                            } else {
                                                    $this->session->set_flashdata('error', 'Error while updating Assignment!!' );
                                                    redirect($this->config->item('admin_folder').'/homework/mode');
                                            }
                                        }
                                }
                        }
                $this->load->view($this->config->item('admin_folder').'/homework_form', $data);
        }
        
        //delete single record
        function delete($id)
	{       
		$del =delete_single_rec($id,HOMEWORK);
		if($del){
			$this->session->set_flashdata('success', 'You have successfully deleted Assignment !!' );
			redirect($this->config->item('admin_folder').'/homework');
		}else{
			$this->session->set_flashdata('error', 'Error while deleting Assignment !!' );
			redirect($this->config->item('admin_folder').'/homework');
		}
	}
        
        function mul_action()
        {
            $action_val= $_REQUEST['mul_val'];
            $arr_ids= $_REQUEST['mul_id'];
            $path='/homework';
            $table=HOMEWORK;
            multiple_action($arr_ids, $action_val, $table, $path);
        }
        
        function change_status()
        {
            $id=$_REQUEST['id'];
            $status=$_REQUEST['status'];
            $table=HOMEWORK;
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