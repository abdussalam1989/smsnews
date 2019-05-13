<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//model->clients_model
class User_model extends CI_Model
{
        function __construct()
        {
            parent::__construct();
        }
        
        /*function insert_user($save)
	{
		$this->db->insert(USERS, $save);
		//$id = $this->db->insert_id();
		//return $id;
                if($this->db->affected_rows() > 0)
                {
                        return 1;
                }
                else
                {
                        return 0;
                }  
	}*/
        
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
 
        function getcity($state_name='')
        {
            $this->db->select('*');
            $this->db->where('city_state', $state_name);
            $query=$this->db->get(CITY);
            //echo $this->db->last_query(); exit;
            return $query->result_array();
        }
        
        function get_list_of_img($id)
        {
            $this->db->select('photo');
            $this->db->where_in('id',$id);
            $query=$this->db->get(USERS);
            //echo $this->db->last_query(); exit;
            return $query->result_array();
        }
        
        function get_user_list()
        {
           $this->db->select('name,total_sms_one,total_sms_two,status,email,status_one,status_two,id');
            // $this->db->select('*');
            $this->db->where('logint_type','user');
            $query=$this->db->get(USERS);
            return $query->result_array();
        }
		
		
		function get_total_sms($id)
        {
            $this->db->select('*');
            $this->db->where('logint_type','user');
            $query=$this->db->get(USERS);
            return $query->result_array();
        }
		
		  function get_overall_sms($user_id)
        {
            $this->db->select('*');
            $this->db->where('user_id',$user_id);
            $this->db->where('msg_status','Delivered');
           // $this->db->where('send_sms_type','Staff');
            $query=$this->db->get(SMS_LOG);
			//print_r($this->db->last_query());
		
            return $query->result_array();
        }
        
        
        
}
