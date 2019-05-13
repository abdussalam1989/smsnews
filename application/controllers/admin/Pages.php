<?php
class Pages extends CI_Controller {

	function __construct()
	{
		parent::__construct();
                $this->load->model('Page_model');
                $this->load->library('auth');
		$redirect = $this->auth->is_logged_in();
		if ($redirect == false)
		{
			$this->session->set_userdata("redirect", current_url());
			redirect($this->config->item('admin_folder').'/login');
		}
        }
        
        function index()
        {   
               // echo "welcome to page";
                $data['page_list']=get_list(STATICPAGES);
                $data['page_title']='Manage Page';
                $this->load->view($this->config->item('admin_folder').'/page_list', $data);
        }
        
        function mode($id)
        {
            $data['check']='edit';
            $data['val_error']="";
            $data['mode']=base_url().$this->config->item('admin_folder').'/pages/mode/'.$id;
            $data['page_title']='Edit Page';
            $data['custom_error']=null;
            $data['list']=get_list_by_id($id,STATICPAGES);
                if(isset($_REQUEST['submit']))
		{   
                    $save['pagename']=$this->input->post('page_name',TRUE);
                    $save['pagetitle']=$this->input->post('page_title',TRUE);
                    $save['content']=$this->input->post('editor1',TRUE);
                    $save['browsertitle']=$this->input->post('browsertitle',TRUE);
                    $save['metaname']=$this->input->post('metaname',TRUE);
                    $save['description']=$this->input->post('description',TRUE);
                    $save['keywords']=$this->input->post('keywords',TRUE);
                   
                            //for a validation
                            $check_required_val=check_required($save);
                             
                            if($check_required_val)
                            {        
                                $data['val_error']='(*) Field Must Be Required !! ';
                            }

                            if($data['val_error']=='')
                            {
                                    $save['editdatetime']=date("Y-m-d H:i:s");
                                    $id = $this->input->post('id',TRUE);       
                                    $upd = $this->Page_model->update_list($save,$id);
                                    if($upd)
                                    {
                                            $this->session->set_flashdata('success', 'You have successfully edited page !!' );
                                            redirect($this->config->item('admin_folder').'/pages');
                                    } else {
                                            $this->session->set_flashdata('error', 'Error while editing page !!' );
                                            redirect($this->config->item('admin_folder').'/pages');
                                    }
                                     $this->load->view($this->config->item('admin_folder').'/page_form', $data);
                            }
                } 
                
            $this->load->view($this->config->item('admin_folder').'/page_form', $data);
        }
                
                
        function mul_action()
        {
            $action_val= $_REQUEST['mul_val'];
            $arr_ids= $_REQUEST['mul_id'];
            //$arr_ids= $this->input->post('mul_val',TRUE);
            if($arr_ids==""){
                $this->session->set_flashdata('error', 'please select check box !!' );
		redirect($this->config->item('admin_folder').'/pages');
            }
            else
            {
               if($action_val=='Active')
                {
                    $result=rec_active_inactive($arr_ids,$action_val,STATICPAGES);       
                        echo $result;
                        if($result) 
                            {
                                $this->session->set_flashdata('success', 'Record Actived successfully' );
                                redirect($this->config->item('admin_folder').'/pages');
                            } 
                            else 
                            {
                                $this->session->set_flashdata('error', 'Record is all ready actived !!' );
                                redirect($this->config->item('admin_folder').'/pages');
                            }
                }
                else if($action_val=='Inactive')
                {
                        $result=rec_active_inactive($arr_ids,$action_val,STATICPAGES);       
                        echo $result;
                        if($result) 
                            {
                                $this->session->set_flashdata('success', 'Record Inactived successfully' );
                                redirect($this->config->item('admin_folder').'/pages');
                            } 
                            else 
                            {
                                $this->session->set_flashdata('error', 'Record is all ready Inactived  !!' );
                                redirect($this->config->item('admin_folder').'/pages');
                            }
                }
           }
            
        }
        
        
        function change_status()
                {
                    $id=$_REQUEST['id'];
                    $status=$_REQUEST['status'];
                    $table=STATICPAGES;
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