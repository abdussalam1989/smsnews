<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth
{
	var $CI;
	
	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->helper('url');
	}
	function check_access($access, $default_redirect=false, $redirect = false)
	{
		/*
		we could store this in the CI->session, but by accessing it this way
		if an admin's access level gets changed while they're logged in
		the system will act accordingly.
		*/
		$admin = $this->CI->session->userdata('admin');
		
		$this->CI->db->select('access');
		$this->CI->db->where('id', $admin['id']);
		$this->CI->db->limit(1);
		$result = $this->CI->db->get('admin');
		$result	= $result->row();
		
		//result should be an object I was getting odd errors in relation to the object.
		//if $result is an array then the problem is present.
		if(!$result || is_array($result))
		{
			$this->logout();
			return false;
		}
	//	echo $result->access;
		if ($access)
		{
			if ($access == $result->access)
			{
				return true;
			}
			else
			{
				if ($redirect)
				{
					redirect($redirect);
				}
				elseif($default_redirect)
				{
					redirect($this->CI->config->item('admin_folder').'/dashboard/');
				}
				else
				{
					return false;
				}
			}
			
		}
	}
	
        /*
	this checks to see if the admin is logged in
	we can provide a link to redirect to, and for the login page, we have $default_redirect,
	this way we can check if they are already logged in, but we won't get stuck in an infinite loop if it returns false.
	*/
	function is_logged_in()
	{
		$admin = $this->CI->session->userdata('admin');
		//$this->CI->config->item('admin_folder');
		if (!empty($admin))
		{
			//redirect($this->CI->config->item('admin_folder').'/dashboard');
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function is_logged_in_user()
	{
		$admin = $this->CI->session->userdata('email');
		//$this->CI->config->item('admin_folder');
		if (!empty($admin))
		{
			//redirect($this->CI->config->item('admin_folder').'/dashboard');
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/*
	this function does the logging in.
	
	function login_admin($uname, $password)
	{
		$this->CI->db->select('*');
		$this->CI->db->where('email_id', $uname);
		$this->CI->db->where('password',  MD5($password));
		$this->CI->db->limit(1);
		$result = $this->CI->db->get('admin_master');
		$result	= $result->row_array();
		
		if (sizeof($result) > 0)
		{
			$admin['admin']	= array();
			$admin['admin']['id'] = $result['id'];
			$admin['admin']['expire'] = false;
			
			$this->CI->session->set_userdata($admin);
			return true;
		}
		else
		{
			return false;
		}
	}
	*/
	/*
	this function does the logging out
	*/
	function logout()
	{
		$this->CI->session->unset_userdata('admin');
		$this->CI->session->sess_destroy();
	}
        function logout1()
	{
		$this->CI->session->unset_userdata('user');
		$this->CI->session->sess_destroy();
	}

	/*
	This function resets the admins password and emails them a copy
	*/
	function reset_password($email)
	{
		$admin = $this->get_admin_by_email($email);
		if($admin)
		{
			$this->CI->load->helper('string');
			$this->CI->load->library('email');			
			$new_password		= random_string('alnum', 8);
			$admin['password']	= sha1($new_password);
			$this->save_admin($admin);			
			$this->CI->email->from($this->CI->config->item('email'), $this->CI->config->item('site_name'));
			$this->CI->email->to($email);
			$this->CI->email->subject($this->CI->config->item('site_name').': Admin Password Reset');
			$this->CI->email->message('Your password has been reset to '. $new_password .'.');
			$this->CI->email->send();
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/*
	This function gets the admin by their email address and returns the values in an array
	it is not intended to be called outside this class
	*/
	private function get_admin_by_email($email)
	{
		$this->CI->db->select('*');
		$this->CI->db->where('email', $email);
		$this->CI->db->limit(1);
		$result = $this->CI->db->get('admin');
		$result = $result->row_array();
		if (sizeof($result) > 0)
		{
			return $result;	
		}
		else
		{
			return false;
		}
	}
	
	/*
	This function takes admin array and inserts/updates it to the database
	*/
	function save($admin)
	{
		if ($admin['id'])
		{
			$this->CI->db->where('id', $admin['id']);
			$this->CI->db->update('admin', $admin);
		}
		else
		{
			$this->CI->db->insert('admin', $admin);
		}
	}
	
	
	/*
	This function gets a complete list of all admin
	*/
	function get_admin_list()
	{
		$this->CI->db->select('*');
		$this->CI->db->order_by('lastname', 'ASC');
		$this->CI->db->order_by('firstname', 'ASC');
		$this->CI->db->order_by('email', 'ASC');
		$result = $this->CI->db->get('admin');
		$result	= $result->result();		
		return $result;
	}

	/*
	This function gets an individual admin
	*/
	function get_admin($id)
	{
		$this->CI->db->select('*');
		$this->CI->db->where('id', $id);
		$result	= $this->CI->db->get('admin');
		$result	= $result->row();
		return $result;
	}		
	
	function check_id($str)
	{
		$this->CI->db->select('id');
		$this->CI->db->from('admin');
		$this->CI->db->where('id', $str);
		$count = $this->CI->db->count_all_results();
		
		if ($count > 0)
		{
			return true;
		}
		else
		{
			return false;
		}	
	}
	
	function check_email($str, $id=false)
	{
		$this->CI->db->select('email');
		$this->CI->db->from('admin');
		$this->CI->db->where('email', $str);
		if ($id)
		{
			$this->CI->db->where('id !=', $id);
		}
		$count = $this->CI->db->count_all_results();
		
		if ($count > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function delete($id)
	{
		if ($this->check_id($id))
		{
			$admin	= $this->get_admin($id);
			$this->CI->db->where('id', $id);
			$this->CI->db->limit(1);
			$this->CI->db->delete('admin');

			return $admin->firstname.' '.$admin->lastname.' has been removed.';
		}
		else
		{
			return 'The admin could not be found.';
		}
	}
        function  get_admin_info($id)
        {   
                $this->CI->db->select('*');
		$this->CI->db->where('id', $id);
		$result	= $this->CI->db->get(USERS);
		$result	= $result->row_array();
		return $result;
        }
        
}