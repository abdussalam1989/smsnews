<?php

class Contact_model extends CI_Model {
    
        function __construct()
        {
            parent::__construct();
        }
 
        function get_list_contact($user_id)
        {
            $this->db->select('*');
            $this->db->where('user_id',$user_id);
            $qr=$this->db->get(CONTACT_US);
            return $qr->result_array();
        }
}