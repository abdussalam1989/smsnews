<?php
class Forgotpassword_model extends CI_Model {
   
        function __construct()
        {
            parent::__construct();
        }
        
        function Verify_admin_email($email)
	{
		$this->db->where('email',$email);
                $this->db->where('logint_type','admin');
		$result =$this->db->get(USERS);
                //echo $this->db->last_query();exit;
		if($this->db->affected_rows()>0)
                {
                    	return $result->result_array();
                }
		else
                {
                    	return false;
                }
	}
        function Update_admin_password($password,$email_id)
	{
		$this->db->where('email',$email_id);
		$this->db->update(USERS,$password);
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
        
        function Verify_user_email($email)
        {
		$this->db->where('email',$email);
                $this->db->where('logint_type','user');
		$result =$this->db->get(USERS);
                //echo $this->db->last_query();exit;
		if($this->db->affected_rows()>0)
                {
                    	return $result->result_array();
                }
		else
                {
                    	return false;
                }
	}
        function Update_user_password($password,$email_id)
	{
		$this->db->where('email',$email_id);
		$this->db->update(USERS,$password);
		if($this->db->affected_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
