<?php
class Login_model extends CI_Model
{
        
        function __construct()
        {
            parent::__construct();
            $this->load->helper('url');
        }
        
            function login_admin($admin_name, $password)
            {   
                    $this->db->select('*');
                    $this->db->where('email',$admin_name);                   
                    $this->db->where('password',$password);
                    $this->db->where('status','Active');
                    $result=$this->db->get(USERS); 
                    $result=$result->row_array();                   
                    if(sizeof($result) > 0)
                    {       
                     //   print_r($result['logint_type']);
                            $admin['admin']=array();
                            if($result['logint_type']=='admin') {
                                $admin['logint_type']='admin';
                                $admin['admin_id']=$result['id'];
                                $admin['user_id']="";
                            } else  {
                                $admin['logint_type']=$result['logint_type'];
                                $admin['user_id']=$result['id'];
                                $admin['admin_id']="";
                            }
                            $admin['admin_info']=$result['id'];
                            $admin['admin']['id']=$result['id'];
                            $admin['admin']['expire']=false;
                            $this->session->set_userdata($admin);
                            return true;
                    }
                    else
                    {
                            return false;
                    }
            }
            
            /*function login_user($uname, $password)
            {  
                    $this->db->select('*');
                    $this->db->where('email',$uname);
                    //$this->db->where('logint_type','user');
                    $this->db->where('password',md5($password));
                    $result=$this->db->get(USERS);
                    $result=$result->row_array();
                    if(sizeof($result) > 0)
                    {       
                        $admin['admin']=array();
                        $admin['logint_type']='user';
                        $admin['admin_info']=$result['id'];
                        $admin['admin']['id']=$result['id'];
                        $admin['admin']['expire']=false;
                        $this->session->set_userdata($admin);
                        return true;
                    }
                    else
                    {
                            return false;
                    }
            }*/
            
        function get_list($select,$id)
        {
                $this->db->select($select);
                $this->db->where('user_id',$id);
                $this->db->order_by('id','DESC');
                $qr=$this->db->get(SMS_LOG);
                return $qr->result_array();
        }
            
}
