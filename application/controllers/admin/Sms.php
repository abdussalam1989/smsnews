<?php

class Sms extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('auth');
        $this->load->library('session');
        $this->load->model('Data_model');
        $redirect = $this->auth->is_logged_in();
        if ($redirect == false) {
            $this->session->set_userdata("redirect", current_url());
            redirect($this->config->item('admin_folder') . '/login');
        }
    }

    function index() {
        $admin = $this->session->userdata();
        $user_id = $admin['user_id'];
        $user = $admin['logint_type'];
        $field = 'user_id';
        $data['data'] = get_list_by_idd($user_id, $field, SMS_TEMPLATE);

        /* if($logint_type=='user')
          {
          $id=$admin['user_id'];
          $field='user_id';
          $data['data']=get_list_by_idd($id,$field,SMS_TEMPLATE);
          } else {
          $data['data']=get_list(SMS_TEMPLATE);
          } */
        $data['page_title'] = 'Manage SMS Temp';
        $this->load->view($this->config->item('admin_folder') . '/sms_list', $data);
    }

    function report() {

        //echo "Aftab Siddiqui";die;
        $data['page_title'] = 'SMS Report';
        $admin = $this->session->userdata();
        $user_id = $admin['user_id'];
        $user = $admin['logint_type'];
        $get_user_list=get_list_by_id($user_id, USERS);        
        if($get_user_list['status_one']=='Active') {
        if($user!='teacher') {
        $resultstatus=$this->Data_model->sms_detail_sent_status($user_id); 
        } else {
        $resultstatus=$this->Data_model->sms_detail_sent_status_by_teacher($user_id);
        }       
        foreach($resultstatus as $key=>$smsdata){
        if($smsdata['response_id']!="") {
        $data = array('user'=>$get_user_list['username_one'], 'phone'=>$smsdata['mobile_no'], "msgid"=>$smsdata['response_id'],'msgtype'=>$get_user_list['prioritydetails_one']);
        $response=send_sms_response($data);
        if($response=='Sent'){           
            $store_data['msg_status'] = 'Delivered';
            $store_data['is_send'] = 1;
        } else {
            $store_data['msg_status'] = 'failure';
            $store_data['is_send'] = 0;
        } 
        update_record($store_data,$smsdata['id'],SMS_LOG_ONE);        
        }   
        }
    }
        $this->load->view($this->config->item('admin_folder') . '/smsreport_list', $data);
    }

    function reportajax() {
        $admin = $this->session->userdata();
        $user_id = $admin['user_id'];
        $usertype = $admin['logint_type'];

        // DB table to use
        $get_user_list=get_list_by_id($user_id, USERS);
        $get_teacher_id=get_list_by_admin_sms($user_id,'user_id',CLASS_TEACHER);    
        if($get_user_list['status_one']=='Active') {
        $table = SMS_LOG_ONE;
        } else {
        $table = SMS_LOG;
        }        
        // Table's primary key
        $primaryKey = 'id';
        

        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes

        /* $columns = array(                
          array( 'db' => '`sl`.`msg_status`', 'dt' => 0, 'field' => 'msg_status' ),
          array( 'db' => '`sl`.`adddate`', 'dt' => 1, 'field' => 'adddate' ),
          array( 'db' => '`sl`.`addtime`', 'dt' => 2, 'field' => 'addtime' ),
          array( 'db' => '`st`.`class_name`','dt' => 3,'field' => 'class_name' ),
          array( 'db' => '`st`.`roll_no`','dt' => 4,'field' => 'roll_no' ),
          array( 'db' => '`sl`.`message`', 'dt' => 5, 'field' => 'message' ),
          array( 'db' => '`sl`.`mobile_no`', 'dt' => 6, 'field' => 'mobile_no' ),
          array( 'db' => '`sl`.`count_msg`', 'dt' => 7, 'field' => 'count_msg' ),
          );
         */

        /* case when st.class_name is null then N/A else st.class_name end */
        $columns = array(
            array('db' => 'sl.msg_status', 'dt' => 0, 'field' => 'msg_status'),
            array('db' => 'sl.adddate', 'dt' => 1, 'field' => 'adddate'),
            array('db' => 'sl.addtime', 'dt' => 2, 'field' => 'addtime'),
            array('db' => '(case when st.class_name is null then "N/A" else st.class_name end) as class_name', 'dt' => 3, 'field' => 'class_name'),
            array('db' => '(case when st.roll_no is null then "N/A" else st.roll_no end) as roll_no', 'dt' => 4, 'field' => 'roll_no'),
            array('db' => 'sl.message', 'dt' => 5, 'field' => 'message'),
            array('db' => 'sl.mobile_no', 'dt' => 6, 'field' => 'mobile_no'),
            array('db' => 'sl.count_msg', 'dt' => 7, 'field' => 'count_msg'),
        );


        //$columns = 
        // SQL server connection information
        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db' => $this->db->database,
            'host' => $this->db->hostname
        );


        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP
         * server-side, there is no need to edit below this line.
         */
        //require('ssp.class.php');
        $this->load->library('Ssp.php');

        // REFERENCE
        //http://74.207.246.202/ssp/example/
        //simple ( $request, $sql_details, $table, $primaryKey, $columns, $joinQuery = NULL, $extraWhere = '', $groupBy = '')
        //$joinQuery = "FROM `sms_log` AS `sl` JOIN `student` AS `st` ON `sl`.`user_id`=$user_id and `sl`.`mobile_no` = `st`.`mobile_no` order_by sl.id DESC";

        /* Ex:
          SELECT something
          FROM   master      parent
          JOIN   master      child ON child.parent_id = parent.id
          LEFT   JOIN second parentdata ON parentdata.id = parent.secondary_id
          LEFT   JOIN second childdata ON childdata.id = child.secondary_id
          WHERE  parent.parent_id = 'rootID'
         */
        //$_REQUEST
        /*
          22-June-2016 */
        //$joinQuery="FROM sms_log AS sl JOIN student AS st ON st.id=sl.stud_id";

        /* $joinQuery="FROM sms_log AS sl JOIN student AS st ON st.id=sl.stud_id";
          $extraWhere="sl.user_id='".$user_id."' ORDER BY sl.id DESC"; */

        // Now all the student , teacher and staff data is also coming.
        //class_teacher : teacher_id,  staff : staff_id
        
        $value = $this->input->get('mobile_number');
        $valuee = $this->input->get('msg_status');
        $first_date = $this->input->get('first_date');
        $second_date = $this->input->get('second_date');
        $where = '';
        if ($valuee) {
            $where .= ' and sl.msg_status = "' . $valuee.'"';
        } 
        if ($value) {
            $where .= ' and sl.mobile_no LIKE "%' . $value.'%"';
        } 
        if ($first_date && !$second_date) {

            $where .= ' and (sl.adddate = "' . $first_date . '" ) ';
        }
        if (!$first_date && $second_date) {

            $where .= ' and (sl.adddate = "' . $second_date . '") ';
        }
        if ($first_date && $second_date) {

            $where .= ' and (sl.adddate >="' . $first_date . '" and sl.adddate <= "' . $second_date . '") ';
        }
        if($get_user_list['status_one']=='Active') {
        $joinQuery = "FROM sms_log_one AS sl "
                . " LEFT OUTER JOIN student AS st ON st.id=sl.stud_id "
                . " LEFT OUTER JOIN class_teacher AS ct ON ct.id=sl.teacher_id"
                . " LEFT OUTER JOIN staff AS sf ON sf.id=sl.staff_id";
        if($usertype!='teacher') {
        $extraWhere = "sl.user_id='" . $user_id . "' " . $where . " ORDER BY sl.id DESC";
        } else {
        $extraWhere = "sl.teacher_id='" . $user_id . "' " . $where . " ORDER BY sl.id DESC";    
        }
        } else {
        $joinQuery = "FROM sms_log AS sl "
                . " LEFT OUTER JOIN student AS st ON st.id=sl.stud_id "
                . " LEFT OUTER JOIN class_teacher AS ct ON ct.id=sl.teacher_id"
                . " LEFT OUTER JOIN staff AS sf ON sf.id=sl.staff_id";
        if($usertype!='teacher') {
        $extraWhere = "sl.user_id='" . $user_id . "' " . $where . " ORDER BY sl.id DESC";
        } else {
        $extraWhere = "sl.teacher_id='" . $user_id . "' " . $where . " ORDER BY sl.id DESC";    
        } 
        }        

        //$groupBy="sl.id DESC";
        //$joinQuery = "FROM sms_log AS sl JOIN student AS st ON sl.mobile_no=st.mobile_no where sl.user_id='".$user_id."' ";
        /* echo $joinQuery;
          exit; */
       //echo $extraWhere;
        echo json_encode(
                SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
         );
    }

    function search() {
        $data['page_title'] = 'SMS Report';
        $value = $this->input->post('date');
        $get_list = $this->Data_model->get_sms_search($value);
        $data['get_list'] = $get_list;
        $this->load->view($this->config->item('admin_folder') . '/smsreport_list', $data);
    }

    function mode($id = '') {
        $data['page_title'] = 'Add SMS Temp';
        $data['check'] = 'add';
        $data['status'] = array('Active', 'Inactive');
        $data['mode'] = base_url() . $this->config->item('admin_folder') . '/sms/mode/';
        $data['val_error'] = '';
        $admin = $this->session->userdata();
        $user_id = $admin['user_id'];
        $user = $admin['logint_type'];
        $data['custom_error'] = null;
        if ($id != '') {
            $data['check'] = 'edit';
            $data['mode'] = base_url() . $this->config->item('admin_folder') . '/sms/mode/' . $id;
            $data['val_error'] = "";
            $data['page_title'] = 'Edit SMS Temp';
            $data['custom_error'] = null;
            $data['data'] = get_list_by_id($id, SMS_TEMPLATE);
        }
        if (isset($_REQUEST['submit'])) {
            $save['name'] = $this->input->post('name', TRUE);
            $save['template_text'] = $this->input->post('template_text', TRUE);
            $save['status'] = $this->input->post('status', TRUE);

            //check empty records 
            $check_required_val = check_required($save);

            if ($check_required_val) {
                $data['val_error'] = '(*) field must be required !! ';
            }

            if ($id == '') {
                $save['user_id'] = $user_id;
                $str = $save['name'];
                $save['slug'] = createSlugUrl(STUDENT, $str);
                if ($data['val_error'] == '') {
                    $add = insert_record(SMS_TEMPLATE, $save);
                    if ($add) {
                        $this->session->set_flashdata('success', 'You have successfully Added sms !!');
                        redirect($this->config->item('admin_folder') . '/sms');
                    } else {
                        $this->session->set_flashdata('error', 'Error while adding sms !!');
                        redirect($this->config->item('admin_folder') . '/sms');
                    }
                }
            } else {
                $id = $this->input->post('data_id', TRUE);
                $save['editdate'] = date("Y-m-d h:m:s");
                if ($data['val_error'] == '') {
                    $upd = update_record($save, $id, SMS_TEMPLATE);
                    if ($upd) {
                        $this->session->set_flashdata('success', 'You have successfully updated sms !!');
                        redirect($this->config->item('admin_folder') . '/sms');
                    } else {
                        $this->session->set_flashdata('error', 'Error while updating sms!!');
                        redirect($this->config->item('admin_folder') . '/sms/mode');
                    }
                }
            }
        }
        $this->load->view($this->config->item('admin_folder') . '/sms_form', $data);
    }

    //delete single record
    function delete($id) {
        $del = delete_single_rec($id, SMS_TEMPLATE);
        if ($del) {
            $this->session->set_flashdata('success', 'You have successfully deleted sms !!');
            redirect($this->config->item('admin_folder') . '/sms');
        } else {
            $this->session->set_flashdata('error', 'Error while deleting sms !!');
            redirect($this->config->item('admin_folder') . '/sms');
        }
    }

    function mul_action() {
        $action_val = $_REQUEST['mul_val'];
        $arr_ids = $_REQUEST['mul_id'];
        $path = '/sms';
        $table = SMS_TEMPLATE;
        multiple_action($arr_ids, $action_val, $table, $path);
    }

    function change_status() {
        $id = $_REQUEST['id'];
        $status = $_REQUEST['status'];
        $table = SMS_TEMPLATE;
        if ($status == 'true') {
            $status = 'Active';
            $result = change_status($id, $status, $table);
            echo $result;
        } else {
            $status = 'Inactive';
            $result = change_status($id, $status, $table);
            echo $result;
        }
    }

}

?>