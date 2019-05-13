<?php

class Forgotpassword extends CI_Controller {

	function __construct()
	{
		parent::__construct();
                $this->load->model('Forgotpassword_model');
                $this->load->model('Setting_model');
	}

	function index()
	{       
                $data['page_title']='Forgotpassword';
                $this->load->helper('form');
                if (isset($_REQUEST['submit']))
		{
                    $admin_email1= $this->input->post('admin_email',TRUE);
                    $admin_email = $this->security->xss_clean($admin_email1);
                        if ($this->security->xss_clean($admin_email1, TRUE) === FALSE)
			{
                            
			}
			else
			{
                            $admin_email=$this->security->xss_clean($admin_email1);
                            $admin=$this->input->post('admin',TRUE);
                            if($admin)
                            {
                                $result = $this->Forgotpassword_model->Verify_admin_email($admin_email);
                            } else {
                                $result = $this->Forgotpassword_model->Verify_user_email($admin_email);
                            }
                            
                            if($result)
                            {
                                    $new_password = uniqid();
                                    $password=array('password'=>md5($new_password));
                                    $result1 = $this->Forgotpassword_model->Update_admin_password($password,$admin_email);
                                    if($result1)
                                    {
                                            $forgot_formate = $this->Setting_model->get_mail_format_list();
                                            //echo "<pre>";
                                            //print_r($forgot_formate);die;
                                            $arr = array('{user}','{password}','{logo}','{link}');
                                            $arr1 = array($result[0]['name'],''.$new_password.'',''.base_url()."/admin_assets/logo/logo.png".'',''.base_url()."admin/login".'');
                                            $text = str_replace($arr,$arr1,$forgot_formate[1]['content']);
                                            //print_r($text);
                                            //exit;
                                            $this->load->library('email');
                                            $this->email->set_mailtype("html");
                                            $this->email->from('noreply@smsportal.co.in','SMS Portal');
                                            $this->email->to($result[0]['email']);
                                            $this->email->subject('Forgot Password');
                                            $this->email->message($text);
                                            if($this->email->send()) 
                                            {
                                                $this->session->set_flashdata('success', 'New Password is being sent to your email id' );
                                                redirect($this->config->item('admin_folder').'/login');
                                                //echo'Email Successfully Send !';
                                                //die;
                                            } else {
                                                //   echo  '<p class="error_msg">Invalid Gmail Account or Password !</p>';
                                                //die;
                                            }
                                    }
                                    else
                                    {
                                            echo "password not updated";
                                    }
                            }
                            
                            else
                            {
                                $this->session->set_flashdata('error', 'Please enter correct Email id ');
				redirect($this->config->item('admin_folder').'/forgotpassword');
                            }
                        }
                }
            $this->load->view($this->config->item('admin_folder').'/forgotpassword',$data);
        }
	
	function logout()
	{
		$this->auth->logout();
		//when someone logs out, automatically redirect them to the login page.
		$this->session->set_flashdata('error', 'You have successfully logout.');
		redirect($this->config->item('admin_folder').'/login');
	}

}