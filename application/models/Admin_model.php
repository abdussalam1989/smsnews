<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//model->clients_model
class Admin_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
       /* function get_admin_detail($id)
	{
                //$query =  "SELECT * FROM admin_master where id=1 ";
                //$result = $this->db->query($query)->row_array();
                //return $result;
                $this->db->where('id', $id);
                $query =$this->db->get(ADMIN_MASTER);
		$result=$query->row_array();
                return $result;
	}*/
       
        function update_admin_details1($save,$id)
	{
		$this->db->where('id', $id);
		$upd = $this->db->update(ADMIN_MASTER, $save);
		if($upd)
			return true;
		else
			return false;	
	}
        
        function update_admin_password($id)
	{
		if($this->input->post('passwd'))
			$data['password'] =MD5($this->input->post('passwd'));
		/*$data = array(
			'uname' => $this->input->post('uname'),
			'passwd' => base64_encode($this->input->post('passwd')),
		);*/
		$this->db->where('id', $id);
		$upd = $this->db->update(ADMIN_MASTER, $data);
		//echo $this->db->last_query();die;
		if($upd)
			return true;
		else
			return false;	
	}
        
        function verify_password($pass ,$id)
	{
		$this->db->where('id',$id);
		$this->db->where('password',md5($pass));
		$quesry = $this->db->get(ADMIN_MASTER);
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
        
        function getcountry()
        {
           $this->db->select('*');
           $query=$this->db->get(COUNTRY);
           return $query->result_array();
        }

        function getstate($country_id='')
        {
           $this->db->select('*');
           $this->db->where('country_iso',$country_id);
           $query =$this->db->get(STATE);
           return $query->result_array();
        }

        function getcity($state_id='')
        {
           $this->db->select('city.*');
           $this->db->where('state_id', $state_id);
           $query=$this->db->get('city');
           return $query->result_array();
        }
       
        
        function del_img($img_nm,$id)
        {  
            if($img_nm != 'default.jpg');
            {
                unlink(ADMIN_PROFILE_IMAGES.$img_nm);
                unlink(ADMIN_PROFILE_IMAGES_THUMB.$img_nm);
            }
            $image="default.jpg";
            $this->db->set('photo',$image);
            $this->db->where('id', $id);
            $del=$this->db->update(ADMIN_MASTER);
            echo $this->db->last_query(); exit;
                if($del)
                {       
			return true;
                }
		else
			return false;	
        }
        
}