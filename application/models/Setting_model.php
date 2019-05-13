<?php
class Setting_model extends CI_Model {
   
        function __construct()
        {
            parent::__construct();
        }
        function Verify_admin_email($email)
	{
		$this->db->where('email_id',$email);
		$this->db->where('is_deleted','0');
		$result =$this->db->get(ADMIN_MASTER);
		if($this->db->affected_rows()>0)
			return $result->result_array();
		else
			$this->db->where('username',$email);
			$this->db->where('is_deleted','0');
			$result = $this->db->get(ADMIN_MASTER);
			if($this->db->affected_rows()>0)
				return $result->result_array();
			else
				return false;
	}
        function get_mail_format_list()
	{   
                $this->db->select('*');
                $query=$this->db->get(EMAIL_FORMATES);
		$result = $query->result_array();
		return $result;
	}
        
        function get_user_mail_format_list($field)
	{   
                $this->db->select('*');
                $this->db->where('name',$field);
                $query=$this->db->get(EMAIL_FORMATES);
		$result = $query->result_array();
		return $result;
	}
        
        function get_mail_format($field)
	{   
                $this->db->select('*');
                $this->db->where('name',$field);
                $query=$this->db->get(EMAIL_FORMATES);
		$result = $query->result_array();
		return $result;
	}
        
        function get_site_info()
        {
            $this->db->select('*');
            $query=$this->db->get(SITE);
            return $query->row_array();
        }
        
        function upd_site_detail($save)
	{
		$this->db->where('id',1);
		$upd = $this->db->update(SITE, $save);
                //echo $this->db->last_query(); exit;
		if($this->db->affected_rows() > 0)
			return true;
		else
			return false;	
	}
}

