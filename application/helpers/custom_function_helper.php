<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// check string
function createSlug($str) {
    $str = strtolower(strip_tags(stripslashes(trim($str))));
    $str = str_replace(" & ", " and ", $str);
    $str = preg_replace('/[^a-zA-Z0-9]/i', '-', $str);
    $expStr = explode("--", $str);
    while (count($expStr) > 1) {
        $str = implode("-", $expStr);
        $expStr = explode("--", $str);
    }
    if (substr($str, 0, 1) == "-") {
        $str = substr($str, 1);
    }
    if (substr($str, -1) == "-") {
        $str = substr($str, 0, -1);
    }
    return $str;
}

// for create slug URL
function createSlugUrl($table, $str = "") {
    $str = createSlug($str);
    //$ustr=$str."-".uniqid();
    //$str=$ustr;
    $ci = & get_instance();
    $ci->db->select('slug');
    $ci->db->where('slug', $str);
    $query = $ci->db->get($table);
    $cnt = 1;
    if ($query->num_rows() > 0) {
        while ($exRow = $query->result_array($query)) {
            $cnt++;
            $estr = $str . "-" . $cnt;
            $ci->db->select('slug');
            $ci->db->where('slug', $estr);
            $query = $ci->db->get($table);
            $cstr = $query->result_array();
        }
        $str = $estr;
    }
    return $str;
}

function check_required($chk_required) {
    return array_search("", $chk_required) !== false;
}

function check_url($website) {
    // if (!preg_match("@^(http\:\/\/|https\:\/\/)?([a-z0-9][a-z0-9\-]*\.)+[a-z0-9][a-z0-9\-]*$@i",$website)) 
    if (!filter_var($website, FILTER_VALIDATE_URL) === true) {
        return true;
        //$websiteErr = "Invalid URL"; 
    } else {
        return false;
    }
}

function check_email_validation($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) == true) {
        return true;
    } else {
        return false;
    }
}

function check_email_exist($email, $table) {
    $ci = & get_instance();
    $ci->db->select('email');
    $ci->db->where('email', $email);
    $query = $ci->db->get($table);
    //echo $ci->db->last_query(); exit;
    if ($query->num_rows() > 0) {
        return true;
    } else {
        return false;
    }
}

function check_field_exist($field_nm, $field_data, $table) {
    $ci = & get_instance();
    $ci->db->select($field_nm);
    $ci->db->where($field_nm, $field_data);
    $query = $ci->db->get($table);
    //echo $ci->db->last_query(); exit;
    if ($query->num_rows() > 0) {
        return true;
    } else {
        return false;
    }
}

//check data exits or not
function check_data_exist($field_nm, $field_data, $table) {
    $ci = & get_instance();
    $ci->db->select($field_nm);
    $ci->db->where($field_nm, $field_data);
    $query = $ci->db->get($table);
    if($query->num_rows() > 0) {
        return true;
    } else {
        return false;
    }
}

function allow_only_character($data) {
    $chk_data = trim($data, '');
    if (preg_match('/[^A-Za-z_ ]/', $chk_data)) {
        return TRUE;
    }
}

function check_old_password($password, $table) {
    $ci = & get_instance();
    $ci->db->where('password', md5($password));
    $ci->db->get($table);
    //echo $ci->db->last_query(); exit;
    if ($ci->db->affected_rows() > 0) {
        return true;
    } else {
        return false;
    }
}

function allow_only_number($data) {
    if (preg_match('/[^0-9]/', $data)) {
        return TRUE;
        ;
    }
}

//check password
/*
  ^       # Bind the RegExp to the beginning of the string.
  (?=.{8,})   # Followed by 8 or more characters (min length)
  (?=.*\\d)   # At least one digit.
  (?=.*[a-z]) # At least one lower-case character.
  (?=.*[A-Z]) # At least one upper-case character.
  .*\\z       # Followed by any number of characters, before the end of the string.
 */
function check_password($data) {
    if (!preg_match('/^(?=.{8,})(?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).*\\z/', $data)) {
        return true;
    }
}

// get only number from string
function extract_numbers($string) {
    preg_match_all('/([\d]+)/', $string, $match);
    return $match[0];
}

//function for multiple active and inactive
function rec_active_inactive($arr_ids, $action_val, $table) {
    $ci = & get_instance();
    $ci->db->set('status', $action_val);
    $ci->db->where_in('id', $arr_ids);
    $ci->db->update($table);
    //echo $ci->db->last_query(); exit;
    if ($ci->db->affected_rows() > 0) {
        return true;
    } else {
        return false;
    }
}

//change single active inactive on bootstrap button
function change_status($id, $status, $table) {
    $ci = & get_instance();
    $ci->db->set('status', $status);
    $ci->db->where('id', $id);
    $ci->db->update($table);
    //echo $ci->db->last_query();exit;
    if ($ci->db->affected_rows() > 0) {
        return true;
    } else {
        return false;
    }
}

//change single active inactive on bootstrap button
function change_statuss($id, $field_name, $status, $table) {
    $ci = & get_instance();
    $ci->db->set($field_name, $status);
    $ci->db->where('id', $id);
    $ci->db->update($table);
    //echo $ci->db->last_query();exit;
    if ($ci->db->affected_rows() > 0) {
        return true;
    } else {
        return false;
    }
}

//get single record by id
function get_list_by_id($id, $table) {
    $ci = & get_instance();
    $ci->db->where('id', $id);
    $query = $ci->db->get($table);
    $result = $query->row_array();
    //echo $ci->db->last_query(); exit;
    return $result;
}

//get single record by id
function get_list_by_idd($id, $field, $table) {
    $ci = & get_instance();
    $ci->db->where($field, $id);
    $query = $ci->db->get($table);
    $result = $query->result_array();
    //echo $ci->db->last_query(); exit;
    return $result;
}

function get_list_by_idds($user_id, $field, $table) {
    $ci = & get_instance();
    $ci->db->select('name,admission_no,roll_no,father_name,mobile_no,alternate_no,class_name');
    //$ci->db->where($field, $id);
    $ci->db->where('sms_group_info.user_id', $user_id);
    $ci->db->from($table);
    $ci->db->join('student', 'student.id = sms_group_info.member_id');
    $query = $ci->db->get();
    $result = $query->result_array();
    //echo $ci->db->last_query(); exit;
    return $result;
}

function get_list_by_iddd($id, $field, $table) {
    $ci = & get_instance();
    $ci->db->where($field, $id);
    $ci->db->order_by("id", "DESC");
    $query = $ci->db->get($table);
    $result = $query->result_array();
    //echo $ci->db->last_query(); exit;
    return $result;
}

//get single record by id
function get_list_two_field_name($field_one, $data_one, $field_two, $data_two, $table) {
    $ci = & get_instance();
    $ci->db->where($field_one, $data_one);
    $ci->db->where($field_two, $data_two);
    $query = $ci->db->get($table);
    $result = $query->row_array();
    //echo $ci->db->last_query(); exit;
    return $result;
}

//get list of all records in desc order
function get_list($table) {
    $ci = & get_instance();
    $ci->db->select('*');
    $ci->db->order_by('id', "DESC");
    $query = $ci->db->get($table);
    // echo $ci->db->last_query(); exit;
    return $query->result_array();
}

//get list of all records in desc order
function get_active_list($table) {
    $ci = & get_instance();
    $ci->db->select('*');
    $ci->db->where('status', 'Active');
    $ci->db->order_by('id', "DESC");
    $query = $ci->db->get($table);
    return $query->result_array();
}

//get list of all records in asn order
function get_list1($table) {
    $ci = & get_instance();
    $ci->db->select('*');
    $query = $ci->db->get($table);
    return $query->result_array();
}

function get_listt($table) {
    $ci = & get_instance();
    $ci->db->select('*');
    $ci->db->order_by('id', "ASC");
    $query = $ci->db->get($table);
    return $query->result_array();
}

// insert record in database    
function insert_record($table, $data) {
    $ci = & get_instance();
    $ci->db->insert($table, $data);
    //echo $ci->db->last_query(); exit;
    return $ci->db->insert_id();
}

//update record in database
function update_record($data, $id, $table) {
    $ci = & get_instance();
    $ci->db->where('id', $id);
    $upd = $ci->db->update($table, $data);
    if ($upd)
        return true;
    else
        return false;
}

//delete multiple records
function delete_multi_rec($arr_ids, $table) {
    $ci = & get_instance();
    $ci->db->where_in('id', $arr_ids);
    $ci->db->delete($table);
    //echo $ci->db->last_query();
    //exit;
    if ($ci->db->affected_rows() > 0) {
        return true;
    } else {
        return false;
    }
}

//for multiple delete active/inactive
function multiple_action($arr_ids, $action_val, $table, $path) {
    $ci = & get_instance();
    if ($arr_ids == "") {
        $ci->session->set_flashdata('error', 'please select check box !!');
        redirect($ci->config->item('admin_folder') . $path);
    } else {
        if ($action_val == 'Delete') {
            $result = delete_multi_rec($arr_ids, $table);
            echo $result;
            if ($result) {
                $ci->session->set_flashdata('success', 'Record Deleted Successfully');
                redirect($ci->config->item('admin_folder') . $path);
            } else {
                $ci->session->set_flashdata('error', 'Error while deleting record !!');
                redirect($ci->config->item('admin_folder') . $path);
            }
            //return $result;
        } else if ($action_val == 'Active') {
            $result = rec_active_inactive($arr_ids, $action_val, $table);
            echo $result;
            if ($result) {
                $ci->session->set_flashdata('success', 'Record Actived Successfully');
                redirect($ci->config->item('admin_folder') . $path);
            } else {
                $ci->session->set_flashdata('error', 'Record is all ready actived !!');
                redirect($ci->config->item('admin_folder') . $path);
            }
        } else if ($action_val == 'Inactive') {
            $result = rec_active_inactive($arr_ids, $action_val, $table);
            echo $result;
            if ($result) {
                $ci->session->set_flashdata('success', 'Record Inactived Successfully');
                redirect($ci->config->item('admin_folder') . $path);
            } else {
                $ci->session->set_flashdata('error', 'Record is all ready Inactived  !!');
                redirect($ci->config->item('admin_folder') . $path);
            }
        }
    }
}

//delete Single Record
function delete_single_rec($id, $table) {
    $ci = & get_instance();
    $ci->db->where('id', $id);
    $del = $ci->db->delete($table);
    //echo $ci->db->last_query(); exit;
    if ($ci->db->affected_rows() > 0)
        return true;
    else
        return false;
}

//delete image when delete record
function delete_rec_img($id, $table, $path, $thumb_path) {
    $ci = & get_instance();
    $get_rec = get_list_of_img($id, $table);
    foreach ($get_rec as $del_img) {
        if ($del_img['photo'] != NULL) {
            unlink($path . $del_img['photo']);
            unlink($thumb_path . $del_img['photo']);
        }
    }
}

//getimage name when delete multiple record
function get_list_of_img($id, $table) {
    $ci = & get_instance();
    $ci->db->select('photo');
    $ci->db->where_in('id', $id);
    $query = $ci->db->get($table);
    //echo $ci->db->last_query(); exit;
    return $query->result_array();
}

//create thumb image 
function image_thumb($folder_name, $source_name, $image_name, $width, $height) {
    $CI = & get_instance();
    // Path to image thumbnail
    //$image_thumb = dirname($folder_name . '/' . $image_name) . '/' .'thumb-'.$image_name . '_' . $width . '_' . $height . strrchr($image_name, '.');
    //LOAD LIBRARY
    // print_r($image_name); exit;
    $CI->load->library('image_lib');
    // CONFIGURE IMAGE LIBRARY
    $config['image_library'] = 'GD2';
    $config['source_image'] = $source_name . '/' . $image_name;
    $config['new_image'] = $folder_name . '/' . $image_name;
    $config['maintain_ratio'] = TRUE;
    $config['height'] = $height;
    $config['width'] = $width;
    $CI->image_lib->initialize($config);
    $CI->image_lib->resize();
    $CI->image_lib->clear();
    //return '<img src="' . dirname($_SERVER['SCRIPT_NAME']) . '/' . $image_thumb . '" />';
    return TRUE;
}

//get list DESC order
function get_list_order_by($field_name, $table, $limit_val) {
    $ci = & get_instance();
    $ci->db->select('*');
    $ci->db->order_by($field_name, "DESC");
    $ci->db->limit($limit_val);
    $query = $ci->db->get($table);
    return $query->result_array();
}

//get Active list DESC order
function get_active_list_order_by($field_name, $table, $limit_val) {
    $ci = & get_instance();
    $ci->db->select('*');
    $ci->db->where('status', 'Active');
    $ci->db->order_by($field_name, "DESC");
    $ci->db->limit($limit_val);
    $query = $ci->db->get($table);
    //echo $ci->db->last_query(); exit;
    return $query->result_array();
}

//get table value which releted with property at time of display list
function get_property_info($field_name, $id, $table) {
    $ci = & get_instance();
    $ci->db->where($field_name, $id);
    $query = $ci->db->get($table);
    $result = $query->row_array();
    //echo $ci->db->last_query(); exit;
    return $result;
}

//count page views
function count_page($id, $count) {
    $ci = & get_instance();
    $ci->db->set('page_view', $count);
    $ci->db->where('id', $id);
    $ci->db->update(PROPERTY);
}

//get is_featured value
function get_is_featured_value() {
    $ci = & get_instance();
    $ci->db->where('is_featured', 1);
    $ci->db->where('status', 'Active');
    $query = $ci->db->get(PROPERTY);
    $result = $query->result_array();
    return $result;
}

//get list by field name
function get_list_by_field($field_nm, $field_val, $table) {
    $ci = & get_instance();
    $ci->db->select('name,id');
    $ci->db->where($field_nm, $field_val);
    $ci->db->where('status', 'Active');
    $query = $ci->db->get($table);
    $result = $query->result_array();
    return $result;
}

//get list by field name
function get_list_by_field_two($field_nm, $field_val, $field_nm2, $field_val2, $table) {
    $ci = & get_instance();
    $ci->db->select('roll_no,name,id');
    $ci->db->where($field_nm, $field_val);
    $ci->db->where($field_nm2, $field_val2);
    $ci->db->where('status', 'Active');
    $query = $ci->db->get($table);
    $result = $query->result_array();
    return $result;
}

//get list from sms log
function get_sms_list($user_id, $send_sms_type) {

    $ci = & get_instance();
    $ci->db->select('group_id,msg_status,count_msg,adddate,addtime,mobile_no,message');
    $ci->db->order_by("id", 'DESC');
    $ci->db->where('user_id', $user_id);
    //$ci->db->where('user_type',$user_type);
    $ci->db->where('send_sms_type', $send_sms_type);
    $query = $ci->db->get(SMS_LOG);
    $result = $query->result_array();
    return $result;
}

//get list by user id
function get_list_by_user_id($user_id, $table_name) {
    $ci = & get_instance();
    $ci->db->select('*');
    $ci->db->where('user_id', $user_id);
    $ci->db->where('status', 'Active');
    $query = $ci->db->get($table_name);
    //echo $ci->db->last_query(); exit;
    $result = $query->result_array();
    return $result;
}

function get_att_req_record($user_id, $t_dt, $student_id) {
    $ci = & get_instance();
    $ci->db->select('*');
    $ci->db->where('user_id', $user_id);
    $ci->db->where('adddate', $t_dt);
    $ci->db->where('student_id', $student_id);
    $query = $ci->db->get(ATTENDANCE_SHEET);
    //echo $ci->db->last_query(); exit;
    $result = $query->row_array();
    return $result;
}

function sms_count($msg) {
    $ci = & get_instance();
    $lang = $ci->input->post('language', TRUE);
    $max = 160;
    if ($lang == 'eng') {
        $max = 160;
    } else {
        $max = 70;
    }
    return ceil(strlen($msg) / $max);
}

// send message using api
function send_sms($data, $save) {
	
    $ch = curl_init('http://smartsms.clickschooldiary.com/api2/send/');
	//$ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $send_report = curl_exec($ch);
    curl_close($ch);
    
    // Process your response here

    $json = json_decode($send_report, true);

   /*if($json['status'] == 'success') {
        $save['msg_status'] = 'Delivered';
        $save['is_send'] = 1;
    } else {
        $save['msg_status'] = 'failure';
    }
    if(!empty($save['mobile_no'])) {
        $add = insert_record(SMS_LOG, $save);
    } else {
        $add = true;
    }*/
    return $json;
}

// For API One Integration function //

function send_sms_one($data, $save) {
    
    $ch = curl_init('http://smsw.clickschooldiary.com/api/sendmsg.php');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $send_report = curl_exec($ch);
    curl_close($ch);       
    $json = json_decode($send_report, true);
    return $send_report;
}

function send_sms_response($data) {
    
    $ch = curl_init('http://bhashsms.com/api/recdlr.php');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $send_report = curl_exec($ch);
    curl_close($ch);       
    $json = json_decode($send_report, true);
    return $send_report;
}

function call_send_sms_link($link) {
    $ch = curl_init();
    $link .="&unicode=" . true;
    // Reset all previously set options
    //curl_reset($ch);
    //set URL and other appropriate options
    curl_setopt($ch, CURLOPT_URL, $link);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    // unset($response);    
    //grab URL and pass it to the browser
    $response = curl_exec($ch);

    //close cURL resource, and free up system resources
    curl_close($ch);

    return $response;
}

function send_api_one_sms($link) {
    $link .="&unicode=" . true;
    $response = @file_get_contents($link);
    return $response;
}

function call_send_sms_link_api($link) {
    $link .="&unicode=" . true;
    $response = @file_get_contents($link);
    if ($response == FALSE) {
        return $response;
    } else {
        $send_report = json_decode($response);
        $send_report = (array) $send_report;
        return $send_report;
    }
}

function send_schedule_sms($link) {
    $link .="&unicode=" . true;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $link);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    // Reset all previously set options
    //curl_reset($ch);
    //grab URL and pass it to the browser
    $response = curl_exec($ch);

    //close cURL resource, and free up system resources
    curl_close($ch);

    return $response;
}

function get_tiny_url($link) {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, 'http://tinyurl.com/api-create.php?url=' . $link);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

// check value already exits in array
function check_array_value($products, $field, $value) {
    foreach ($products as $key => $product) {
        if ($product[$field] === $value)
        //return $key;
            return TRUE;
    }
    return false;
}

//function for send sms 
function send_sms_using_aip($user_id, $mobile_no, $template, $student_id) {
    $ci = & get_instance();
    $get_user_list = get_list_by_id($user_id, USERS);
    if (!empty($mobile_no)) {
        if ($get_user_list['status_one'] == 'Active') {
            $api_username = $get_user_list['username_one'];
            $api_password = $get_user_list['password_one'];
            $api_sender = $get_user_list['senderid_one'];
            $api_type = $get_user_list['smstype_one'];
            $api_priority = $get_user_list['prioritydetails_one'];
            $api_schedule_link = API1_SCHEDULE_LINK;
            $api_instant_link = API1_INSTANT_LINK;
            $api_status_link = API1_GETSTATUS_LINK;
        }
        if ($get_user_list['status_two'] == 'Active') {
            $api_username = $get_user_list['username_two'];
            $api_hash = $get_user_list['api_two_hash'];
            $api_sender = $get_user_list['senderid_two'];
            $api_schedule_link = API2_INSTANT_LINK;
        }

        $message1 = "Dear Parent, " . $template;
        $message = str_replace(' ', '%20', $message1);
        //$message=urlencode($message);
        $message = $message;
        $save['message'] = $message1;
        $save['user_id'] = $user_id;
        $save['sms_type'] = 'Instant';
        $msg_value = strlen($save['message']);
        $total_msg = $msg_value / 160;
        $total_val = ceil($total_msg);
        $save['count_msg'] = $total_val;
        $date = get_current_date_time();
        $save['addtime'] = date("H:i:s", strtotime($date));
        $save['adddate'] = date("Y-m-d", strtotime($date));
        $save['stud_id'] = $student_id;
        $save['mobile_no'] = $mobile_no;
        if ($get_user_list['status_one'] == 'Active') {

            $link = $api_instant_link . 'user=' . $api_username . '&pass=' . $api_password . '&sender=' . $api_sender . '&phone=' . $mobile_no . '&text=' . $message . '&priority=' . $api_priority . '&stype=' . $api_type;
            $send_sms = call_send_sms_link($link);
            $sms_code = explode(" ", $send_sms);
            $smscode = $sms_code[0];

            if (!empty($smscode)) {
                $check_status = $api_status_link . 'user=' . $api_username . '&msgid=' . $smscode . '&phone=' . $mobile_no . '&msgtype=' . $api_type;
                $sms_status = call_send_sms_link($check_status);
                if ($sms_status == 1) {
                    $save['msg_status'] = "Delivered";
                } else {
                    $save['msg_status'] = "Failure";
                }
            } else {
                $save['msg_status'] = "Failure";
            }
            unset($link);
            unset($check_status);
            $save['api_name'] = 'one';
        }

        if ($get_user_list['status_two'] == 'Active') {
            $link = $api_schedule_link . 'username=' . $api_username . '&hash=' . $api_hash . '&numbers=91' . $mobile_no . '&sender=' . $api_sender . '&message=' . $message;

            $send_report = call_send_sms_link_api($link);
            // print_r($send_report); exit;
            if ($send_report['status'] == 'success') {
                $save['msg_status'] = 'Delivered';
                $save['is_send'] = 1;
            } else {
                $save['msg_status'] = $send_report['status'];
            }
            if ($send_report['status'] == 'failure') {
                $save['msg_status'] = 'failure';
                $save['api_message'] = $send_report['errors'][0]->message;
            }
            $save['api_name'] = 'two';
        }

        if ($get_user_list['status_one'] == 'Active') {
            $total_sms = $get_user_list['total_sms_one'];
            $totl_sms = $total_sms - $save['count_msg'];
            $save1['total_sms_one'] = $totl_sms;
        }

        if ($get_user_list['status_two'] == 'Active') {
            $total_sms = $get_user_list['total_sms_two'];
        }
        $save['is_send'] = 1;
        //update_record($save1,$user_id,USERS);
        $add = insert_record(SMS_LOG, $save);
        return $add;
    } else {
        return FALSE;
    }
}

function get_detalis_for_message_teacher($field_one, $field_one_val, $field_two, $field_two_val, $table) {
    $ci = & get_instance();
    $ci->db->select('name,employ_id,id');
    $ci->db->where($field_one, $field_one_val);
    $ci->db->where($field_two, $field_two_val);
    $query = $ci->db->get($table);
    //$ci->db->last_query(); exit;
    $result = $query->row_array();

    return $result;
}

function get_detalis_for_message($field_one, $field_one_val, $field_two, $field_two_val, $table) {
    $ci = & get_instance();
    $ci->db->select('name,class_name,roll_no,id');
    $ci->db->where($field_one, $field_one_val);
    $ci->db->where($field_two, $field_two_val);
    $query = $ci->db->get($table);
    //$ci->db->last_query(); exit;
    $result = $query->row_array();

    return $result;
}

function replace_string_using_array($arr, $message) {
    if (strrchr($message, "[name]") || strrchr($message, "[class]") || strrchr($message, "[rollno]") || strrchr($message, "[todaydate]")) {
        $find = array_keys($arr);
        $replace = array_values($arr);
        $new_string = str_ireplace($find, $replace, $message);
        return $new_string;
    } else {
        return FALSE;
    }
}

//add token at a time of send absent present template
function set_token_in_message($message, $student_list) {
    //$message=$get_template['template_text'];
    $arr[] = '';
    if (strrchr($message, "[todaydate]")) {
        $arr['[todaydate]'] = date('d-m-Y');
    }
    if (strrchr($message, "[name]")) {
        $arr['[name]'] = $student_list['name'];
    }
    if (strrchr($message, "[class]")) {
        $arr['[class]'] = $student_list['class_name'];
    }
    if (strrchr($message, "[rollno]")) {
        $arr['[rollno]'] = $student_list['roll_no'];
    }

    if (!empty($arr)) {
        $message_test = replace_string_using_array($arr, $message);
        if ($message_test == FALSE) {
            $message = $message;
        } else {

            $message = $message_test;
            //echo "this is else condition"; exit;
        }
    }
    return $message;
}

// set default time 
function get_current_date_time() {
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d h:i:s');
    return $date;
}


?>