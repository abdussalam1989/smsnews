<?php
class Data_model extends CI_Model {

        function __construct()
        {
            parent::__construct();
        }


        function delete_sms_group_record($user_id,$id,$member_value)
        {
           // $this->db->where('member_id',$member_id);
            $this->db->where('user_id',$user_id);
            $this->db->where('group_id',$id);
            $this->db->where('group_type',$member_value);
            $this->db->delete(SMS_GROUP_INFO);
           // echo $this->db->last_query(); exit;
            if($this->db->affected_rows() > 0) {
                return true;
            }
        }

        function update_sms_group_info($group_id,$id,$user_id)
        {
            $this->db->set('group_id',$group_id);
            $this->db->where('member_id',$id);
            $this->db->where('user_id',$user_id);
            $this->db->update(SMS_GROUP_INFO);
            if($this->db->affected_rows() > 0) {
                    return true;
            }
        }

        /*function get_list_sms_info($id,$group_type)
        {
            $this->db->select('');
            $this->db->where('group_id',$id);
            $this->db->where('group_type',$group_type);
            $query=$this->db->get(SMS_GROUP_INFO);
            //echo $this->db->last_query(); exit;
            $result=$query->result_array();
            return $result;
        }*/
		
		function get_list_sms_info($id,$group_type)
        {
            $this->db->select('');
            $this->db->where('group_id',$id);
            $this->db->where('group_type',$group_type);
            $query=$this->db->get(SMS_GROUP_INFO);
            //echo $this->db->last_query(); exit;
            $result=$query->result_array();
            return $result;
        }
		

        function get_student_list($user_id,$classname)
        {
            $this->db->select('');
            $this->db->where('class_name',$classname);
            $this->db->where('user_id',$user_id);
            $this->db->where('status','Active');
            $query=$this->db->get(STUDENT);
            //echo $this->db->last_query(); 
            $result=$query->result_array();
            // echo "<pre>";            print_r($result); exit; 
            return $result;
        }

        //function get class list byy class id
        function get_student_list_by_id($user_id,$class_id)
        {
            $this->db->select('');
            $this->db->where_in('class_id',$class_id);
            $this->db->where('user_id',$user_id);
            $this->db->where('status','Active');
            $this->db->order_by('roll_no',"ASC");
            $query=$this->db->get(STUDENT);
            //echo $this->db->last_query(); 
            $result=$query->result_array();
            //echo "<pre>";print_r($result); exit; 
            return $result;
        }
        
        /*function get_studentdata_listt($class_id)
        {
            $this->db->select('');
            $this->db->where('class_id',$class_id);
            $this->db->where('status','Active');
            $query=$this->db->get(STUDENT);
            $result=$query->result_array();
            return $result;
        }*/
		
		function get_studentdata_listt($user_id)
        {
            $this->db->select('id,class_name,name,father_name,roll_no,alternate_no,admission_no,mobile_no');
            $this->db->where('user_id',$user_id);
            $this->db->where('status','Active');
            $query=$this->db->get(STUDENT);			
            $result=$query->result_array();
            return $result;
        }
        
        function get_sms_search($value,$user_id)
        {
            $this->db->select('*');
            $this->db->where('user_id',$user_id);
            $this->db->where('adddate',$value);
            $this->db->order_by('id',"DESC");
            $query=$this->db->get(SMS_LOG);
            $result=$query->result_array();
            return $result;
        }
        
        function get_sms_search_ot_join($value,$user_id)
        {
            $this->db->select('*');
            $this->db->from('sms_log');
            //$this->db->order_by('sms_log.id',"DESC");
            $this->db->where('adddate',$value);
            $this->db->where('sms_log.user_id',$user_id);
            $this->db->join('student', 'student.id = sms_log.stud_id', 'outer');
            $query=$this->db->get();
            //echo $this->last_query;
            //exit;
            $result=$query->result_array();
            return $result;
        }

        function check_attendance_reg($class_name,$user_id)
        {
            $this->db->select('*');
            $this->db->where('class_name',$class_name);
            $this->db->where('user_id',$user_id);
           // $this->db->where('month',$month);
            $query=$this->db->get(ATTENDANCE_SHEET);
            $result=$query->result_array();
            return $result;
        }

        //check data
        function check_dul_data($user_id,$ad_id)
        {
            $this->db->select('*');
            $this->db->where('user_id',$user_id);
            $this->db->where('admission_no',$ad_id);
            $query=$this->db->get(STUDENT);
            if($this->db->affected_rows() > 0)
            {
                return true;
            } else {
                return false;
            }  
        }
        
        function  update_studeny_csv($user_id,$insert_data)
        {
            $this->db->where('user_id',$user_id);
            $this->db->where('admission_no', $insert_data['alternate_no']);
            $upd=$this->db->update(STUDENT,$insert_data);
            if($upd)
                return true;
            else
                return false;	
        }
        
        
        //get group data
        function get_grp_list($value,$user_id)
        {
			$this->db->select('*');
			$this->db->where('group_id',$value);
			$query=$this->db->get(SMS_GROUP_INFO);
			$result=$query->result_array();
			return $result;
        }
        
        //search sms report between to date
        function search_sms_report($first_date,$second_date,$user_id)
        {
            $this->db->select('msg_status,count_msg,adddate,addtime,mobile_no,message,stud_id,user_id');
            $this->db->where('user_id',$user_id);
            $this->db->where('adddate >=', $first_date);
            $this->db->where('adddate <=', $second_date);
            $query=$this->db->get(SMS_LOG);
            echo $this->db->last_query(); exit;
            $result=$query->result_array();
            return $result;
        }
        
		
		  function search_smss_report($user_id)
        {
            $this->db->select('*');
            $this->db->where('user_id',$user_id);
            $this->db->where('adddate BETWEEN DATE_SUB(NOW(), INTERVAL 90 DAY) AND NOW()');
            $query=$this->db->get(SMS_LOG);
            //echo $this->db->last_query(); exit;
            $result=$query->result_array();
            return $result;
        }
        //check 
        function check_class_exits($user_id,$date,$class_name,$table)
        {
            $this->db->select('*');
            $this->db->where('user_id',$user_id);
            $this->db->where('adddate', $date);
            $this->db->where('class_name', $class_name);
            $this->db->get($table);            
            //echo $this->db->last_query(); exit;
            if($this->db->affected_rows() > 0)
            {
                    return true;
            } else {
                    return false;
            }   
            
        }
        
        function att_del_rec($user_id,$date,$class_name)
        {
			$this->db->where('user_id',$user_id);
			$this->db->where('adddate', $date);
			$this->db->where('class_name', $class_name);
			$upd=$this->db->delete(ATTENDANCE_SHEET);
			if($upd)
				return true;
			else
				return false;
        }
        
        function get_student_details($user_id,$send_msg_type)
        {
            $this->db->select('*');
            $this->db->from('sms_log');
            $this->db->order_by('sms_log.id',"DESC");
            $this->db->where('sms_log.user_id',$user_id);
            $this->db->where('sms_log.send_sms_type',$send_msg_type);
            //$this->db->join('student', 'student.mobile_no = sms_log.mobile_no');
            $this->db->join('student', 'student.id = sms_log.stud_id', 'left');
            $query=$this->db->get();
            //echo $this->db->last_query(); exit;
            return $query->result_array();
        }
        
        function get_sms_list($user_id,$send_msg_type)
        {
            $this->db->select('*');
            $this->db->from('sms_log');
            $this->db->order_by('sms_log.id',"DESC");
            $this->db->where('sms_log.user_id',$user_id);
            $this->db->where('send_sms_type',$send_msg_type);
            $this->db->where('msg_status','Delivered');
            $this->db->join('staff', 'staff.mobile_no = sms_log.mobile_no');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        function get_api_status($user_id)
        {   
            $this->db->select('status_two,language_option');
            $this->db->where('id',$user_id);
            $query=$this->db->get(USERS);
            return $query->row_array();            
        }
        
        function get_roll_list_of_class($class_id)
        {
            $this->db->select('id,class_id,roll_no');
            $this->db->where('class_id',$class_id);
            $query=$this->db->get(STUDENT);
            return $query->result_array();
        }
        
        function get_student_list_by_class_id($class_id,$user_id)
        {		
			$this->db->select('name,class_name,roll_no,father_name,id,class_id,admission_no,mobile_no,alternate_no');
			$this->db->where_in('class_id',$class_id);
			$this->db->where('user_id',$user_id);
			$this->db->where('status','Active');
			//$this->db->order_by('roll_no',"DESC");
			$query=$this->db->get(STUDENT);
			return $query->result_array();
        }
        
        function get_student_list_by_group_id($group_id,$user_id)
        {
			$this->db->select('name,admission_no,roll_no,father_name,mobile_no,alternate_no,class_name');
			$this->db->where('sms_group_info.group_id',$group_id);
			$this->db->where('sms_group_info.user_id',$user_id);
			//$this->db->where('status','Active');
			//$this->db->order_by('roll_no',"ASC");
			$this->db->from('sms_group_info');
			$this->db->join('student', 'student.id = sms_group_info.member_id');
			$query=$this->db->get();
			//echo $this->db->last_query();
			//die;
			return $query->result_array();
				
        }
		
		function get_student_list_by_user_id($user_id)
        {
			$this->db->select('*');
			$this->db->where('user_id',$user_id);
			//$this->db->where('status','Active');
			$this->db->order_by('roll_no',"ASC");   
			$query=$this->db->get(STUDENT);
			//echo $this->db->last_query();
			//die;
			return $query->result_array();
        }
		
        
        function get_absent_template($user_id)
        {
			$this->db->select('*');
			$this->db->where('user_id',$user_id);
			$this->db->where('text_id',0);
			$query=$this->db->get(ATTENDANCE_SMS_TEMPLATE);
			//echo $this->db->last_query(); exit;
			return $query->row_array();
        }
        
        function get_present_template($user_id)
        {
			$this->db->select('*');
			$this->db->where('user_id',$user_id);
			$this->db->where('text_id',1);
			$query=$this->db->get(ATTENDANCE_SMS_TEMPLATE);
			return $query->row_array();
        }
        
        function get_student_listt($class_name,$student_id)
        {
			$this->db->select('name,mobile_no,alternate_no,admission_no,id,class_name,roll_no,status,group_id,user_id');
			$this->db->where('class_name',$class_name);
			$this->db->where('id',$student_id);
			$query=$this->db->get(STUDENT);
			return $query->row_array();
        }
        
        function check_grp_record($grp_id,$user_id,$member_id,$member_typ){
            $this->db->select('*');
            $this->db->where('group_id',$grp_id);
            $this->db->where('user_id',$user_id);
            $this->db->where('member_id',$member_id);
            $this->db->where('group_type',$member_typ);
            $this->db->get(SMS_GROUP_INFO);
            if($this->db->affected_rows() > 0)
            {
                return true;
            } else {
                return false;
            }   
        }
        
        function delete_single_grp_rec ($grp_id,$user_id,$member_id,$member_typ){
            $this->db->where('group_id',$grp_id);
            $this->db->where('user_id',$user_id);
            $this->db->where('member_id',$member_id);
            $this->db->where('group_type',$member_typ);
            $this->db->delete(SMS_GROUP_INFO);
        }
        
        // get group info rec by user id and grp id
        function get_all_rec_by_id($grp_id,$user_id,$member_typ)
        {
            $this->db->select('member_id');
            $this->db->where('group_id',$grp_id);
            $this->db->where('user_id',$user_id);
            $this->db->where('group_type',$member_typ);
            $qr=$this->db->get(SMS_GROUP_INFO);
            //echo $this->db->last_query(); exit;
            return $qr->result_array();
            
        }
        
        function get_grp_info_details($grp_id,$user_id)
        {
            $this->db->select('*');
            $this->db->where('group_id',$grp_id);
            $this->db->where('user_id',$user_id);
            $qr=$this->db->get(SMS_GROUP_INFO);
            //echo $this->db->last_query(); exit;
            return $qr->row_array();
        }
        
        function get_classs_list($user_id)
        {
            $this->db->select('id,name');
            $this->db->where('user_id',$user_id);
            $this->db->where('status','Active');
            $this->db->order_by('id','asc');
            $qr=$this->db->get(CLASSES);
            return $qr->result_array();
        }
        
        
        //check class name exites or not
        function class_exites($user_id,$class_name)
        {
			$this->db->select('*');
			$this->db->where('user_id',$user_id);
			$this->db->where('name',$class_name);
			$qr=$this->db->get(CLASSES);
			return $qr->row_array();
        }
        
        //get student list using user id
        function get_student_list_by_user($user_id,$class_id)
        {
			$this->db->select('id,class_name,name,father_name,mobile_no,alternate_no,roll_no,user_id,status');
			$this->db->where('user_id',$user_id);
			$this->db->where('class_id',$class_id);
			$this->db->order_by('roll_no',"ASC");
			$qr=$this->db->get(STUDENT);
			return $qr->result_array();
        }
        
        // get record pending sms form api two
        function get_pending_sms_rec()
        {
			$this->db->select('*');
			$this->db->where('is_send',0);
			$this->db->where('api_name','two');
			$this->db->limit(2000);
			$qr=$this->db->get(SMS_LOG);
			return $qr->result_array();
        }
        
        // get record pending sms from api 
        function get_pending_sms_rec_from_apione()
        {
			$this->db->select('*');
			$this->db->where('is_send',0);
			$this->db->where('api_name','one');
			$this->db->limit(500);
			$qr=$this->db->get(SMS_LOG);
			return $qr->result_array();
        }
        
        // get apione status
        function get_apione_status()
        {
			$this->db->select('*');
			$this->db->where('is_send',2);
			$this->db->where('api_name','one');
			$this->db->limit(500);
			$qr=$this->db->get(SMS_LOG);
			return $qr->result_array();
        }
        
        
        function get_sms_search_by_mobile_no($value,$user_id)
        {
            $this->db->select('msg_status,count_msg,adddate,addtime,mobile_no,message,stud_id,user_id');
            $this->db->where('user_id',$user_id);
            $this->db->where('mobile_no',$value);
            $this->db->order_by('id',"DESC");
            $query=$this->db->get(SMS_LOG);
            $result=$query->result_array();
			//echo $this->db->last_query(); exit;
            return $result;
        }
		
		function get_sms_search_by_status($valuee,$user_id)
        {
            $this->db->select('msg_status,count_msg,adddate,addtime,mobile_no,message,stud_id,user_id');
            $this->db->where('user_id',$user_id);
            $this->db->where('msg_status',$valuee);
            $this->db->order_by('id',"DESC");
            $query=$this->db->get(SMS_LOG);
            $result=$query->result_array();
            return $result;
        }
        
}
?>