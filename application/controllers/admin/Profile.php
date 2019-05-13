<?php
class Profile extends CI_Controller {

	function __construct()
	{
                parent::__construct();
                $this->load->model('Admin_model');
                $this->load->library('auth');
                $this->load->helper('url');
                $redirect = $this->auth->is_logged_in();
                if ($redirect == false)
                {
                    $this->session->set_userdata("redirect", current_url());
                    redirect($this->config->item('admin_folder').'/login');
                }
	}
        
            function index()
            {
                redirect($this->config->item('admin_folder').'/dashboard');
            }

            function edit()
            {       
                    $data['page_title'] = 'Edit Profile';
                    $data['val_error']="";
                    $data['custom_error'] = null;
                    $admin=$this->session->userdata();
                    $id=$admin['admin_info'];
                    $data['admin_details'] = $this->Admin_model->get_admin_detail($id);
                    //$result['list']=$this->Admin_model->getCountry();
                            
                    $data['country']=$this->Admin_model->getcountry();
                    if(isset($_REQUEST['submit']))
                    {
                            $save['first_name']=$this->input->post('first_name',TRUE);
                            $save['last_name']=$this->input->post('last_name',TRUE);
                            $save['username']=$this->input->post('username',TRUE);
                            
                        if($_FILES['photo']['name']!="") 
                        {
                            $config['upload_path'] = ADMIN_PROFILE_IMAGES;
                            $r_nm = str_replace(' ', '_', $_FILES['photo']['name']);
                            $name = date("dmY")."-".time().$r_nm;
                            //$image_upd=$name.$image['file_name'];
                            $image_upd=$name;
                            $config['file_name'] = $image_upd;
                            $config['overwrite'] = TRUE;
                            $config["allowed_types"] = 'jpg|jpeg|png|gif';
                            $this->load->library('upload', $config);
                            $uploaded=$this->upload->do_upload('photo');
                            if(!$uploaded)
                            {
                                    $this->session->set_flashdata('error', $this->upload->display_errors());
                                    redirect($this->config->item('admin_folder').'/profile/edit');
                                    //end script here if there is an error
                            }
                            else
                            {
                                    $image= $this->upload->data();
                                    $save['photo']= $image['file_name'];
                                    if($this->input->post('hidphoto') != 'default.jpg')
                                    {
                                        unlink(ADMIN_PROFILE_IMAGES.$this->input->post('hidphoto'));
                                        unlink(ADMIN_PROFILE_IMAGES_THUMB.$this->input->post('hidphoto'));
                                    }
                            }
                        }
                        else
                        {
                                $save['photo']= $this->input->post('hidphoto');
                        }
                        $source_name=ADMIN_PROFILE_IMAGES;
                        $folder_name=ADMIN_PROFILE_IMAGES_THUMB;
                        $image_name=$save['photo'];
                        $width=ADMIN_PROFILE_WIDTH;
                        $height=ADMIN_PROFILE_HEIGHT;
                        $thumb_image=image_thumb($folder_name,$source_name, $image_name, $width, $height);
                        //$thumb_image=create_thumb_image($folder_name, $image_name, $width, $height);    
                        
                        
                        $save['email_id']=$this->input->post('email_id',TRUE);
                        $save['mobile_no']=$this->input->post('mobile_no',TRUE);
                        $save['address']=$this->input->post('address',TRUE);
                        //$date = date("d-m-Y")."-".date("h:i:sa");
                        $date = date("d-m-Y H:i:s"); 
                        $save['editdatetime']=$date;
                        $save['country']=$this->input->post('country',TRUE);
                        $save['state']=$this->input->post('state',TRUE);
                        $save['city']=$this->input->post('city',TRUE);
                            //echo "call";die;

                            //check email id valid or not
                            $check_email_val=check_email_validation($save['email_id']);

                            //check password
                            // $check_password=check_password($passwd);

                            //check character
                            $check_fname=allow_only_character($save['first_name'] );

                            //check lname
                            $check_lname=allow_only_character($save['last_name'] );

                            //check number
                            $check_contact=allow_only_number($save['mobile_no']);
                            
                            //check empty records 
                            $check_required_val=check_required($save);

                                if($check_email_val)
                                {   
                                        $data['val_error']='Email id is not valid';
                                }

                                else if($check_fname)
                                {
                                        $data['val_error']='Only character allow on firstname and lastname';
                                }

                                else if($check_lname)
                                {
                                        $data['val_error']='Only character allow on firstname and lastname';
                                }

                                else if($check_contact)
                                {
                                        $data['val_error']='Only number allow on phone number';
                                }

                                else if($check_required_val)
                                {        
                                        $data['val_error']='(*) field must be required !! ';
                                }

                    if($data['val_error']=="")
                    {
                        $save['ipaddress']=$this->input->ip_address();
                        $upd = $this->Admin_model->update_admin_details1($save,$id);
                        if($upd) 
                        {       
                                $this->session->set_flashdata('success', 'You have successfully updated profile !!' );
                                redirect($this->config->item('admin_folder').'/profile/edit');
                        } 
                        else 
                        {
                                $this->session->set_flashdata('error', 'Error while updating profile !!' );
                                redirect($this->config->item('admin_folder').'/profile/edit');
                        }
                    }
            }		

        $this->load->view($this->config->item('admin_folder').'/edit_profile', $data);
        //$this->load->view($this->config->item('admin_folder').'/change_passwd', $data);
        }
                
        function changepassword()
	    {       
		$data['custom_error'] = null;
		$data['page_title'] = 'Change Password';
                $admin=$this->session->userdata();
                $id=$admin['admin_info'];
                
		$data['admin_details']=$this->Admin_model->get_admin_detail($id);
		if(isset($_REQUEST['submit']))
		{
			$this->form_validation->set_rules('old_passwd', 'Old password', 'required|xss_clean');
			$this->form_validation->set_rules('passwd', 'New paassword', 'required|xss_clean');
			$this->form_validation->set_rules('c_passwd', 'Confirm password', 'required|xss_clean');
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view($this->config->item('admin_folder').'/change_password', $data);
			}
			else
			{
				if($this->verfiy_password($this->input->post('old_passwd',TRUE)))
				{
					
					if($this->input->post('passwd') != $this->input->post('c_passwd'))
					{
						$data['custom_error'] = "New password and confirm password does not match !..";
						$this->load->view($this->config->item('admin_folder').'/change_password', $data);
					}
					else
					{
						//echo "call";die;
						$upd = $this->Admin_model->update_admin_password($id);
						if($upd) 
						{
							$this->session->set_flashdata('success', 'You have successfully updated Password !!' );
							redirect($this->config->item('admin_folder').'/profile/changepassword');
						} 
						else 
						{
							$this->session->set_flashdata('error', 'Error while updating Password !!' );
							redirect($this->config->item('admin_folder').'/profile/changepassword');
						}
					}
				}
				else
				{
					$data['custom_error'] = "Please enter right old password !";
					$this->load->view($this->config->item('admin_folder').'/change_password', $data);
				}
			}
                }
            $this->load->view($this->config->item('admin_folder').'/change_password', $data);
	}
	
	function verfiy_password($pass)
	{   
            $admin=$this->session->userdata();
            $id=$admin['admin_info'];
            $result = $this->Admin_model->verify_password($pass,$id);
		if($result)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
        
            public function ajax_state_list($country_id)
            {
                    $this->load->model('Admin_model');
                    $state_arr = $this->Admin_model->getstate($country_id);
                    $state_str="";
                    $state_str.="<label>State<span class='has-error'>*</span></label>";
                    $state_str.="<select name='state' id='get_state' required='required' class='form-control' onChange='getcitydetails(this.value)'>";
                    $state_str.="<option value='' >select state </option>";
                        foreach ($state_arr as $st)
                        {
                            $state_str.="<option value='".$st['state_code']."' >".$st['state_name']."</option>";
                        } 
                    $state_str.="</select>";    
                    echo $state_str;
            }

               /* public function ajax_city_list($state_id)
                {
                    $this->load->model('Admin_model');
                    $city_arr = $this->Admin_model->getcity($state_id);
                    $city_ct="";
                    $city_ct.="<label>City </label>";
                    $city_ct.="<select name='city' class='form-control' id='old_city' required='required'>";
                    $city_ct.="<option value=''> select city </option>";
                    foreach ($city_arr as $ct){
                        $city_ct.="<option value='".$ct['id']."'>".$ct['city_name']."</option>";
                    } 
                    $city_ct.="</select>";
                    echo $city_ct;
                    //$this->load->view($this->config->item('admin_folder').'/edit_profile',$data);
                }   */

                public function ajax_select_state($country_id,$admin_state_id)
                {   
                    $state_arr = $this->Admin_model->getstate($country_id);
                    $state_str="";
                    $state_str.="<label>State <span class='has-error'>*</span></label>";
                    $state_str.="<select name='state' id='get_state' required='required' class='form-control' onChange='getcitydetails(this.value)' >";
                    $state_str.="<option value='' >select state </option>";
                    foreach ($state_arr as $st)
                    {
                        $state_str.='<option value="'.$st['state_code'].'" '.(($st['state_code']==$admin_state_id)?'selected=selected':'').'>'.$st['state_name'].'</option>';
                    } 
                    $state_str.="</select>";
                    
                    echo $state_str;
                    
                }
                
                /*function ajax_select_city($admin_state_id,$admin_city_id)
                {
                    $city_arr = $this->Admin_model->getcity($admin_state_id);
                    $city_ct="";
                    $city_ct.="<label>City </label>";
                    $city_ct.="<select name='city' class='form-control' required='required' id='old_city'>";
                    $city_ct.="<option value='-1'   > select city </option>";
                    foreach ($city_arr as $ct){
                        $city_ct.='<option value="'.$ct['id'].'" '.(($ct['id']==$admin_city_id)?'selected=selected':'').'>'.$ct['city_name'].'</option>';
                    } 
                    $city_ct.="</select>";
                    echo $city_ct;
                }*/
                
                function ajax_delete_img($img_nm,$id)
                {   
                    $img_nmm=urldecode($img_nm);
                    $del_img=$this->Admin_model->del_img($img_nmm,$id);
                    //print_r($src); exit;
                    echo $del_img;
                }
                
 }
        
?>