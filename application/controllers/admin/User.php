<?php
class User extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('auth');
        $redirect = $this->auth->is_logged_in();
        if ($redirect == false) {
            $this->session->set_userdata("redirect", current_url());
            redirect($this->config->item('admin_folder') . '/login');
        }
    }
    
    function index()
    {
        //$data['users']= $this->User_model->get_users();
        $admin       = $this->session->userdata();
        $logint_type = $admin['logint_type'];
        
        if ($logint_type == 'admin') {
            $id               = $admin['admin_info'];
            $field            = 'id';
            $data['userlist'] = $this->User_model->get_user_list();
        } else {
            redirect($this->config->item('admin_folder') . '/dashboard');
        }
        
        $data['page_title'] = 'Manage User';
        //$data['flag_js']='1';
        $this->load->view($this->config->item('admin_folder') . '/user_list', $data);
    }
    function mode($id = "")
    {
        //for add
        // $data['api_data']=  get_list(SMS_API);
        $data['custom_error'] = null;
        $data['val_error']    = '';
        $data['check']        = 'add';
        $data['status']       = array(
            'Active',
            'Inactive'
        );
		$data['language'] = array(
            'Inactive',
            'Active'
        );
        $data['institution']  = get_list(INSTITUTION);
        $data['mode']         = base_url() . $this->config->item('admin_folder') . '/user/mode/';
        $data['page_title']   = 'Add User';
        $admin                = $this->session->userdata();
        $logint_type          = $admin['logint_type'];
        $data['country']      = $this->User_model->getcountry();
        
        // for edit mode
        if ($id != "") {
            $data['custom_error'] = null;
            $data['val_error']    = '';
            $data['check']        = 'edit';
            $data['mode']         = base_url() . $this->config->item('admin_folder') . '/user/mode/' . $id;
            $data['page_title']   = 'Edit User';
            $data['country']      = $this->User_model->getcountry();
            $data['user']         = get_list_by_id($id, USERS);

        }
        
        if (isset($_REQUEST['submit'])) {
            //$data['user']=$this->input->post();
            $save['name'] = $this->input->post('name', TRUE);            
            $save['school_name'] = $this->input->post('school_name', TRUE);
            $save['email']       = $this->input->post('email', TRUE);
            $save['contact']     = $this->input->post('contact', TRUE);
            $save['status']      = $this->input->post('status', TRUE);
			$save['language_option'] = $this->input->post('language_option', TRUE);
            $save['country']     = $this->input->post('country', TRUE);
            $save['state']       = $this->input->post('state', TRUE);
            $save['city']        = $this->input->post('city', TRUE);
            $passwd              = $this->input->post('password', TRUE);
            $data['user']        = $save;
            
            //check empty records 
            $check_required_val = check_required($save);
            
            //check email id valid or not
            $check_email_val = check_email_validation($save['email']);
            
            
            $check_city = allow_only_character($save['city']);
            
            //check number
            $check_contact = allow_only_number($save['contact']);
            
            //check number
            $check_contact = allow_only_number($save['contact']);
            
            if ($check_required_val) {
                $data['val_error'] = '(*) field must be required !! ';
            }
            
            if ($check_email_val == TRUE) {
                $data['val_error'] = 'Email id is not valid';
            }
            
            if ($check_contact == TRUE) {
                $data['val_error'] = 'Only number allow on phone number';
            }
            
            if ($check_city == TRUE) {
                $data['val_error'] = 'Only Character Allow on city';
            }
            
            $save['landline_contact'] = $this->input->post('landline_contact', TRUE);
            
            
            if ($data['val_error'] == '') {
                // code single image upload        
                if ($_FILES['photo']['name'] != "") {
                    $config['upload_path']   = USER_IMAGES;
                    $r_nm                    = str_replace(' ', '_', $_FILES['photo']['name']);
                    $name                    = date("dmY") . "-" . time() . $r_nm;
                    //$image_upd=$name.$image['file_name'];
                    $image_upd               = $name;
                    $config['file_name']     = $image_upd;
                    $config['overwrite']     = TRUE;
                    $config["allowed_types"] = 'jpg|jpeg|png|gif';
                    $this->load->library('upload', $config);
                    $uploaded = $this->upload->do_upload('photo');
                    if (!$uploaded) {
                        $this->session->set_flashdata('error', $this->upload->display_errors());
                        redirect($this->config->item('admin_folder') . '/user/mode');
                    } else {
                        $image         = $this->upload->data();
                        $save['photo'] = $image['file_name'];
                        if ($this->input->post('hidphoto')) {
                            unlink(USER_IMAGES . $this->input->post('hidphoto'));
                            unlink(USER_IMAGES_THUMB . $this->input->post('hidphoto'));
                        }
                    }
                } else {
                    $save['photo'] = $this->input->post('hidphoto');
                }
                if ($save['photo'] != NULL) {
                    $source_name = USER_IMAGES;
                    $folder_name = USER_IMAGES_THUMB;
                    $image_name  = $save['photo'];
                    $width       = USER_PROFILE_WIDTH;
                    $height      = USER_PROFILE_HEIGHT;
                    $thumb_image = image_thumb($folder_name, $source_name, $image_name, $width, $height);
                }
                
                
                
                if ($save['photo'] != NULL) {
                    $source_name = USER_IMAGES;
                    $folder_name = USER_IMAGES_THUMB;
                    $image_name  = $save['photo'];
                    $width       = USER_PROFILE_WIDTH;
                    $height      = USER_PROFILE_HEIGHT;
                    $thumb_image = image_thumb($folder_name, $source_name, $image_name, $width, $height);
                }
                
                if ($_FILES['banner']['name'] != "") {
                    //$old_banner=$this->input->post('banner_hidphotoo',TRUE);   
                    
                    $r_nm      = str_replace(' ', '_', $_FILES['banner']['name']);
                    $name      = date("dmY") . "-" . time() . $r_nm;
                    $file_path = USER_IMAGES . $name;
                    //'upload/image_file/'.$_FILES['audio_one']['name'];
                    if (move_uploaded_file($_FILES['banner']['tmp_name'], $file_path)) {
                        //print "Received {$_FILES['audio_one']['name']} - its size is {$_FILES['audio_one']['size']}";
                        $save['banner'] = $name;
                        if ($id != "") {
                            if ($save['banner']) {
                                //  $old_image=base_url().USER_IMAGES.$old_banner;
                                //unlink($old_image);
                                unlink(USER_IMAGES . $this->input->post('banner_hidphotoo', TRUE));
                            }
                        }
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors());
                        redirect($this->config->item('admin_folder') . '/user/mode');
                    }
                }
            }
            if ($id == "") {
                $save['institution'] = $this->input->post('institution', TRUE);
                //check mail all ready exist or not 
                $check_email_exist   = check_email_exist($save['email'], USERS);
                
                if ($check_email_exist) {
                    $data['val_error'] = 'Email id already exist';
                }
                
                
                $save['password']    = md5($passwd);
                //$save['ipaddress']=$_SERVER['HTTP_CLIENT_IP'];
                $str                 = $save['name'];
                $save['slug']        = createSlugUrl(USERS, $str);
                $save['logint_type'] = 'user';
                
                if ($data['val_error'] == "") {
                    $add = insert_record(USERS, $save);
                    
                    //$add = $this->User_model->insert_user($save);
                    if ($add) {
                        
                        $att_temp1['name']          = 'Present Template';
                        $str                        = $att_temp1['name'];
                        $att_temp1['slug']          = createSlugUrl(ATTENDANCE_SMS_TEMPLATE, $str);
                        $att_temp1['text_id']       = 1;
                        $att_temp1['template_text'] = 'Present Template';
                        $att_temp1['user_id']       = $add;
                        $att_temp1['status']        = 'Active';
                        insert_record(ATTENDANCE_SMS_TEMPLATE, $att_temp1);
                        $att_temp2['name']          = 'Absent Template';
                        $str                        = $att_temp2['name'];
                        $att_temp2['slug']          = createSlugUrl(ATTENDANCE_SMS_TEMPLATE, $str);
                        $att_temp2['text_id']       = 0;
                        $att_temp2['template_text'] = 'Absent Template';
                        $att_temp2['user_id']       = $add;
                        $att_temp2['status']        = 'Active';
                        insert_record(ATTENDANCE_SMS_TEMPLATE, $att_temp2);
                        
                        $this->session->set_flashdata('success', 'You have successfully edited user !!');
                        redirect($this->config->item('admin_folder') . '/user');
                    } else {
                        $this->session->set_flashdata('error', 'Error while adding user !!');
                        redirect($this->config->item('admin_folder') . '/user');
                    }
                }
            } else {
                if ($passwd != NULL) {
                    $save['password'] = md5($passwd);
                }
                $id = $this->input->post('user_id', TRUE);
                $save['editdatetime'] = date("Y-m-d h:m:s");
                //$upd = $this->User_model->update_user($save,$id);
                if ($data['val_error'] == "") {
                    $upd = update_record($save, $id, USERS);
                    //echo $this->db->last_query(); exit;
                    if ($upd) {
                        if ($logint_type == 'user') {
                            $this->session->set_flashdata('success', 'You have successfully edited Profile!!');
                            redirect($this->config->item('admin_folder') . '/user/mode/' . $id);
                        }
                        $this->session->set_flashdata('success', 'You have successfully edited user !!');
                        redirect($this->config->item('admin_folder') . '/user');
                    } else {
                        $this->session->set_flashdata('error', 'Error while editing user !!');
                        redirect($this->config->item('admin_folder') . '/user');
                    }
                }
            }
        }
        $this->load->view($this->config->item('admin_folder') . '/user_form', $data);
    }
    
    //login as user
    function as_user($id)
    {
        $admin       = $this->session->userdata();
        $logint_type = $admin['logint_type'];
        if ($logint_type == 'admin') {
            $admin['user_id'] = $id;
            $this->session->set_userdata($admin);
            redirect($this->config->item('admin_folder') . '/dashboard');
        }
    }
    
    //login as admin
    function as_admin()
    {
        //$admin=$this->session->userdata(); 
        //$logint_type=$admin['logint_type']; 
        $admin['user_id'] = "";
        $this->session->set_userdata($admin);
        redirect($this->config->item('admin_folder') . '/user');
    }
    
    function check_email($email)
    {
        $email_check     = urldecode($email);
        $check_email_val = check_email_exist($email_check, USERS);
        echo $check_email_val;
    }
    
    function check_username($username)
    {
        $username_check     = urldecode($username);
        $check_username_val = check_data_exist('user_name', $username, USERS);
        echo $check_username_val;
    }
    
    function check_email_val($email)
    {
        $email_check     = urldecode($email);
        $check_email_val = check_email_validation($email_check, USERS);
        echo $check_email_val;
    }
    
    function check_password($password)
    {
        $chk_password = urldecode($password);
        $chk_pass_val = check_password($chk_password);
        echo $chk_pass_val;
    }
    
    //delete single record
    function delete($id)
    {
        $img = get_list_by_id($id, USERS);
        unlink(USER_IMAGES . $img['photo']);
        unlink(USER_IMAGES_THUMB . $img['photo']);
        $del = delete_single_rec($id, USERS);
        if ($del) {
            $this->session->set_flashdata('success', 'You have successfully deleted user !!');
            redirect($this->config->item('admin_folder') . '/user');
        } else {
            $this->session->set_flashdata('error', 'Error while deleting user !!');
            redirect($this->config->item('admin_folder') . '/user');
        }
    }
    //for multiple delete inactive active
    function mul_action()
    {
        $action_val = $_REQUEST['mul_val'];
        $arr_ids    = $_REQUEST['mul_id'];
        if ($arr_ids != '' && $action_val == 'Delete') {
            $id         = $arr_ids;
            $table      = USERS;
            $path       = USER_IMAGES;
            $thumb_path = USER_IMAGES_THUMB;
            delete_rec_img($id, $table, $path, $thumb_path);
        }
        $table = USERS;
        $path  = '/user';
        multiple_action($arr_ids, $action_val, $table, $path);
    }
    
    
    
    function ajax_state_list($country_id)
    {
        $state_arr = $this->User_model->getstate($country_id);
        
        $state_str = "";
        $state_str .= "<label>State <span class='has-error'>*</span> </label>";
        $state_str .= "<select name='state' id='get_state' class='form-control' required='required' onChange='getcitydetails()' >";
        $state_str .= "<option value='-1' >select state  </option>";
        foreach ($state_arr as $st) {
            //  $state_str.='<option value="if(set_value("state")== null) { echo'.$st["state_code"].'}else{ echo set_value("state")" >'.$st["state_name"].'</option>';
            $state_str .= "<option value='" . $st['state_code'] . "' >" . $st['state_name'] . "</option>";
        }
        $state_str .= "</select>";
        echo $state_str;
        
    }
    
    
    function ajax_select_state($country_id, $user_state_id)
    {
        $state_arr = $this->User_model->getstate($country_id);
        $state_str = "";
        $state_str .= "<label>State <span class='has-error'>*</span> </label>";
        $state_str .= "<select name='state' id='get_state' required='required' class='form-control' >";
        $state_str .= "<option value='-1' >select state </option>";
        foreach ($state_arr as $st) {
            $state_str .= '<option value="' . $st['state_code'] . '" ' . (($st['state_code'] == $user_state_id) ? 'selected=selected' : '') . '>' . $st['state_name'] . '</option>';
        }
        $state_str .= "</select>";
        echo $state_str;
    }
    
    
    
    function ajax_city_list($state_name)
    {
        $state_name = urldecode($state_name);
        $city_arr   = $this->User_model->getcity($state_name);
        $city_ct    = "";
        $city_ct .= "<label>City <span class='has-error'>*</span> </label>";
        $city_ct .= "<select name='city' class='form-control' required='required' id='get_city'>";
        $city_ct .= "<option value='-1'> select city </option>";
        foreach ($city_arr as $ct) {
            $city_ct .= "<option value='" . $ct['city_name'] . "'>" . $ct['city_name'] . "</option>";
        }
        $city_ct .= "</select>";
        echo $city_ct;
    }
    
    
    function change_status()
    {
        $id     = $_REQUEST['id'];
        $status = $_REQUEST['status'];
        $table  = USERS;
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
    
    function change_status_api()
    {
        $id         = $_REQUEST['id'];
        $status     = $_REQUEST['status'];
        $table      = USERS;
        $field_name = 'status_one';
        if ($status == 'true') {
            $status             = 'Active';
            $save['status_two'] = 'Inactive';
            update_record($save, $id, $table);
            $result = change_statuss($id, $field_name, $status, $table);
            echo $result;
        } else {
            $status             = 'Inactive';
            $save['status_two'] = 'Active';
            update_record($save, $id, $table);
            $result = change_statuss($id, $field_name, $status, $table);
            echo $result;
        }
        
    }
    function change_status_apii()
    {
        $id         = $_REQUEST['id'];
        $status     = $_REQUEST['status'];
        $table      = USERS;
        $field_name = 'status_two';
        if ($status == 'true') {
            $status             = 'Active';
            $save['status_one'] = 'Inactive';
            update_record($save, $id, $table);
            $result = change_statuss($id, $field_name, $status, $table);
            echo $result;
        } else {
            $status             = 'Inactive';
            $save['status_one'] = 'Active';
            update_record($save, $id, $table);
            $result = change_statuss($id, $field_name, $status, $table);
            echo $result;
        }
        
    }
}