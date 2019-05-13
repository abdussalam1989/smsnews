<?php
class Site extends CI_Controller {

	function __construct()
	{
		parent::__construct();
                $this->load->model('Setting_model');
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
                $data['page_title']='Site Setting';
                $data['val_error']='';
                $this->load->view($this->config->item('admin_folder').'/site_setting', $data);
        }
        
        function mode()
        {
                $data['page_title'] = 'Site Setting';
                $data['val_error']='';
                $data['custom_error'] = null;
                $data['site_data']=$this->Setting_model->get_site_info();
                //echo '<pre>'; print_r($data['site_data']); exit;
                    if(isset($_REQUEST['submit']))
                    {
                            $save['name'] = $this->input->post('name',TRUE);
                            $save['url'] = $this->input->post('url',TRUE);
                            $save['address'] = $this->input->post('address',TRUE);
                            $save['mobile_no'] = $this->input->post('mobile_no',TRUE);
                            $id=$this->input->post('s_id',TRUE);
                            $save['editdatetime']=date("d-m-Y H:i:s");
                            
                            //check empty records 
                            $check_required_val=check_required($save);
                            
                            //check url
                            $check_url=check_url($save['url']);
                     
                            //check number
                            $check_contact=allow_only_number($save['mobile_no']);
                            
                            //check character
                            $check_name=allow_only_character($save['name'] );
                            
                            if($check_required_val)
                            {        
                                    $data['val_error']='(*) Fields must be required !! ';
                            }
                            
                            if($check_url)
                            {
                                    $data['val_error']='Please Enter Valid URL';
                            }
                            
                            if($check_name)
                            {
                                    $data['val_error']='Only Characters Allow in Name';
                            }
                            
                            if($check_contact)
                            {
                                    $data['val_error']='Only number allow in phone number';
                            }
                            
                                   if($_FILES['photo']['name']!="") 
                                        {
                                            $config['upload_path'] = 'upload/logo/';
                                            $r_nm = str_replace(' ', '_', $_FILES['photo']['name']);
                                            $name = date("dmY")."-".time().$r_nm;
                                            //$image_upd=$name.$image['file_name'];
                                            $image_upd=$name;
                                            $config['file_name'] = $image_upd;
                                            $config['overwrite'] = TRUE;
                                            $config["allowed_types"] = 'jpg|jpeg|png|gif';

                                            $this->load->library('upload', $config);
                                            $uploaded	= $this->upload->do_upload('photo');
                                            if(!$uploaded)
                                                {
                                                        $this->session->set_flashdata('error', $this->upload->display_errors());
                                                        redirect($this->config->item('admin_folder').'/pages/mode');
                                                        //end script here if there is an error
                                                }
                                                else
                                                {
                                                        $image=$this->upload->data();
                                                        $save['photo']=$image['file_name'];
                                                        if($this->input->post('hidphoto'))
                                                        {
                                                            unlink(LOGO_IMAGE.$this->input->post('hidphoto'));
                                                            unlink(LOGO_IMAGE_THUMB.$this->input->post('hidphoto'));
                                                        }
                                                }
                                                $source_name=LOGO_IMAGE;
                                                $folder_name=LOGO_IMAGE_THUMB;
                                                $image_name=$save['photo'];
                                                $width=LOGO_WIDTH;
                                                $height=LOGO_HEIGHT;
                                                $thumb_image=image_thumb($folder_name,$source_name, $image_name, $width, $height);
                                        }
                                        else
                                        {
                                                $save['photo']=$this->input->post('hidphoto');
                                        }
                                        
                                       /* if($_FILES['banner']['name']!="") 
                                        {
                                            $config['upload_path'] = BANNER_IMAGE;
                                            $r_nm = str_replace(' ', '_', $_FILES['banner']['name']);
                                            $name = date("dmY")."-".time().$r_nm;
                                            //$image_upd=$name.$image['file_name'];
                                            $image_upd=$name;
                                            $config['file_name'] = $image_upd;
                                            $config['overwrite'] = TRUE;
                                            $config["allowed_types"] = 'jpg|jpeg|png|gif';

                                            $this->load->library('upload', $config);
                                            $uploaded	= $this->upload->do_upload('banner');
                                            if(!$uploaded)
                                                {
                                                        $this->session->set_flashdata('error', $this->upload->display_errors());
                                                        redirect($this->config->item('admin_folder').'/pages/mode');
                                                        //end script here if there is an error
                                                }
                                                else
                                                {
                                                        $image=$this->upload->data();
                                                        $save['banner']=$image['file_name'];
                                                        if($this->input->post('hidphotoo'))
                                                        {
                                                            unlink(BANNER_IMAGE.$this->input->post('hidphotoo'));
                                                            unlink(BANNER_IMAGE_THUMB.$this->input->post('hidphotoo'));
                                                        }
                                                }
                                                $source_name=BANNER_IMAGE;
                                                $folder_name=BANNER_IMAGE_THUMB;
                                                $image_name=$save['banner'];
                                                $width=BANNER_WIDTH;
                                                $height=BANNER_HEIGHT;
                                                $thumb_image=image_thumb($folder_name,$source_name, $image_name, $width, $height);
                                        }
                                        else
                                        {
                                                $save['banner']=$this->input->post('hidphotoo');
                                        } */
                                        
                                        if($data['val_error'] == '')
                                        {
                                            $upd = $this->Setting_model->upd_site_detail($save);
                                            $save['editdatetime']=date("Y-m-d h:m:s");
                                            if($upd) 
                                            {       
                                                    $this->session->set_flashdata('success', 'You have successfully updated site setting !!' );
                                                    redirect($this->config->item('admin_folder').'/site/mode');
                                            } 
                                            else 
                                            {
                                                    $this->session->set_flashdata('error', 'Error while updating site setting !!' );
                                                    redirect($this->config->item('admin_folder').'/site/mode');
                                            }
                                        }
                    }
                $this->load->view($this->config->item('admin_folder').'/site_setting', $data);
        }

}