<?php

class Dashboard_model extends CI_Model {
    
        function __construct()
        {
            parent::__construct();
        }
       
     
        function get_active_student($user_id)
        {
            $this->db->select('*');
            $this->db->where('status','Active');
            $this->db->where('user_id',$user_id);
            $query=$this->db->get(STUDENT);
            $result=$query->num_rows();
            return $result;
        }
        function get_inactive_student($user_id)
        {
            $this->db->select('*');
            $this->db->where('status','Inactive');
            $this->db->where('user_id',$user_id);
            $query=$this->db->get(STUDENT);
            $result=$query->num_rows();
            return $result;
        }
        
        function get_today_sms($user_id,$date)
        {
            $this->db->select('*');
            $this->db->where('user_id',$user_id);
            $this->db->where('adddate',$date);
			$this->db->where('msg_status','Delivered');
			//print_r($this->db->last_query());
			//print_r($this->db->last_query());
			
            $query=$this->db->get(SMS_LOG);
			//print_r($query->num_rows());
            //return $query->result_array();
            return $query->num_rows();
        }
        
        function get_overall_sms($user_id)
        {
            $this->db->select('*');
            $this->db->where('user_id',$user_id);
			$this->db->where('msg_status','Delivered');
            $query=$this->db->get(SMS_LOG);
			//return $query->result_array();
			return $query->num_rows();
        }
        
        function get_today_absent_list($user_id,$date)
        {
            $this->db->select('*');
            $this->db->where('user_id',$user_id);
            $this->db->where('adddate',$date);
            $this->db->where('attendance','A');
            $query=$this->db->get(ATTENDANCE_SHEET);
            return $query->result_array();
        }
		
        function get_all_sms($user_id)
        {
          $this->db->select("total_sms");
		  $this->db->where('id',$user_id);
		  $this->db->where('status','Active');
		  $this->db->from('users');
		  $query = $this->db->get();
		  return $query->result();
		}
		
}
?>