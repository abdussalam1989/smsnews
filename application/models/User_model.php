<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//model->clients_model
class User_model extends CI_Model
{
        function __construct()
        {
            parent::__construct();
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
        
        function get_user_list($api)
        {
           $this->db->select('name,total_sms_one,logint_type,total_sms_two,status,email,status_one,status_two,id');
            // $this->db->select('*');
            $this->db->where('logint_type','user');
            $this->db->or_where('logint_type','teacher');
            if($api=='status_one') {
            $this->db->where('status_one','Active');
            } else if($api=='status_two') {
            $this->db->where('status_two','Active');
            } else  {

            }
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
