<?php class Attendance extends CI_Controller {

	function __construct()
	{
		parent::__construct();
                $this->load->library('auth');
                $this->load->model('Data_model');
                //ini_set('max_execution_time', 10000);
                ini_set('max_execution_time', 0);
                
		$redirect = $this->auth->is_logged_in();
		if ($redirect == false)
		{
			$this->session->set_userdata("redirect", current_url());
			redirect($this->config->item('admin_folder').'/login');
		}
        }
        
        function index()
        {   
                $admin=$this->session->userdata();
                $logint_type=$admin['logint_type'];
                $user_id=$admin['user_id'];
                $field='user_id';
                $data['data']=get_list_by_idd($user_id,$field,ATTENDANCE_SMS_TEMPLATE);
				
				
                    /*if($logint_type=='user')
                    {
                        $id=$admin['user_id'];
                        $field='user_id';
                        $data['data']=get_list_by_idd($id,$field,ATTENDANCE_SMS_TEMPLATE);
                    } else {
                        $data['data']=get_list(ATTENDANCE_SMS_TEMPLATE);
                    }*/
                $data['page_title']= 'Manage SMS Att';
                $this->load->view($this->config->item('admin_folder').'/attendance_list', $data);
        }
        
        function take()
        {
                $data['page_title']= 'Take Attendance';
                //$data['get_class_list']=get_list(CLASSES);
                $admin=$this->session->userdata();
                $user_id=$admin['user_id'];
                $field='user_id';
                $data['get_class_list']=get_list_by_idd($user_id,$field,CLASSES);
			
                $data['get_take_type']=get_list(ATTENDANCE_TAKE_TYPE);
               
                //log_message('error','Function take called');
                    if(isset($_REQUEST['submit']))
                    {       
                            // echo "isf condition"; exit;
                            //log_message('error','if request called : submit'.$user_id);
                            $get_class_nm= $this->input->post('class_name',TRUE);
                           
                            //$class_name =$this->Data_model->get_class_list($save['class_name']);
                            $class_name=$this->Data_model->get_student_list_by_id($user_id,$get_class_nm);
                            //echo "<pre>"; print_r($class_name); exit;
                            $get_class_name=get_list_by_id($get_class_nm, CLASSES);
                            $class_nm=$get_class_name['name']; 
                            $abc=count($class_name);
                            $date=date('Y-m-d');
                            $table=ATTENDANCE_SHEET;
                            $check_class_name=$this->Data_model->check_class_exits($user_id,$date,$get_class_name['name'],$table);
                             //echo "<pre>"; print_r($check_class_name); exit;                           
                            //for send sms
                            $take_type=$this->input->post('take_type',TRUE);
                            $con_sms=$this->input->post('con_sms');
                            $student_name=$this->input->post('student_name',TRUE);
                            
                            if($check_class_name==TRUE)
                            {
                                //log_message('error','if check class name true value='.$check_class_name);
                                //delete Todays attendance
                                $upd=$this->Data_model->att_del_rec($user_id,$date,$class_nm);
                                for($i=0;$i<$abc;$i++)
                                {
                                    $save2['student_id']=$this->input->post('student_id'.$i,TRUE);
                                    $save2['class_name']=$class_nm; 
                                    $save2['attendance']=$this->input->post('student_att'.$i,TRUE);
                                    $save2['user_id']=$user_id;   
                                    $student_id=$save2['student_id'];
                                    $student_detail=$this->Data_model->get_student_listt($class_nm,$save2['student_id'],$student_id);
                                  
									$mobile_no=$student_detail['mobile_no'];
                                    $get_user_list=get_list_by_id($user_id,USERS);
                                    
                                    //log_message('error','chck_class_name value true come '. $i);
                                    $student_list=get_list_by_id($student_id, STUDENT);
                                    if(!empty($take_type)){
                                       // log_message('error','Task time not empty than come in if cluaes');
                                        if($con_sms=='ps'){
                                           // log_message('error','if con sms PS'.$con_sms);
                                            if($take_type=='present'){
                                              //  log_message('error',' if task type present:'.$take_type);
                                                if($save2['attendance']=="P"){
                                                   // log_message('error','if save attend p:'.$save2['attendance']);
                                                    $get_template=$this->Data_model->get_present_template($user_id);
                                                    $message=$get_template['template_text'];
                                                    $send_sms_message=set_token_in_message($message,$student_list);
                                                    $send=send_sms_using_aip($user_id,$mobile_no,$send_sms_message,$student_id);
                                                }     
                                            }
                                        } 
                                       // log_message('error','IF ps over');
                                        if($con_sms=='as'){
                                         //   log_message('error','IF con sms as:'.$con_sms);
                                            if($take_type=='absent'){
                                              //  log_message('error','IF task type absent:'.$take_type);
                                                if($save2['attendance']=="A")   {
                                                 //   log_message('error','IF save2_attend : '.$save2['attendance']);
                                                    $get_template=$this->Data_model->get_absent_template($user_id);
													
                                                    $message=$get_template['template_text'];
                                                    $send_sms_message=set_token_in_message($message,$student_list);
                                                    $send=send_sms_using_aip($user_id,$mobile_no,$send_sms_message,$student_id);
                                                }
                                            }
                                        }
                                       // log_message('error','IF as over');
                                        if($con_sms=='pas'){
                                           //  log_message('error','IF con sms pas:'.$con_sms);
                                            if($take_type=='both'){
                                               //  log_message('error','IF task type both:'.$task_type);
                                                if($save2['attendance']=="A"){
                                                  //  log_message('error','IF save2_attend A: '.$save2['attendance']);
                                                    $get_template=$this->Data_model->get_absent_template($user_id);
                                                    $message=$get_template['template_text'];
                                                    $send_sms_message=set_token_in_message($message,$student_list);
                                                    $send=send_sms_using_aip($user_id,$mobile_no,$send_sms_message,$student_id);
                                                }
                                                if($save2['attendance']=="P"){
                                                     //   log_message('error','IF save2_attend P: '.$save2['attendance']);
                                                        $get_template=$this->Data_model->get_present_template($user_id);
                                                        $message=$get_template['template_text'];
                                                        $send_sms_message=set_token_in_message($message,$student_list);
                                                        $send=send_sms_using_aip($user_id,$mobile_no,$send_sms_message,$student_id);
                                                } 
                                            }
                                        }
                                      //  log_message('error','IF pas over');
                                    }
                                    //log_message('error','if task type over ');
                                    $save2['adddate']=date('Y-m-d');
                                    $add1=insert_record(ATTENDANCE_SHEET, $save2);
                                   // log_message('error','Insereted record is add1:'.$add1);
                                }
                                
                                if($add1) {
                                     //   log_message('error','if add1:'.$add1);
                                        $this->session->set_flashdata('success', 'Attendance store successfully !!' );
                                        redirect($this->config->item('admin_folder').'/attendance/take');
                                } else {
                                      //  log_message('error','else add1:'.$add1);
                                        $this->session->set_flashdata('error', 'Error while adding attendance !!' );
                                        redirect($this->config->item('admin_folder').'/attendance/take');
                                }
                            } else {
                              //  log_message('error','Else check class :'.$check_class_name);
                                for($i=0;$i<$abc;$i++)
                                {
                                  //  log_message('error','else for loop :'.$i);
                                    $save['student_id']=$this->input->post('student_id'.$i,TRUE);
                                    $save['class_name']=$class_nm;
                                    $save['attendance']=$this->input->post('student_att'.$i,TRUE);
                                    $save['user_id']=$user_id;   
                                    $student_id=$save['student_id'];
                                    $student_detail=$this->Data_model->get_student_listt($class_nm,$save['student_id']);
                                    
									$mobile_no=$student_detail['mobile_no'];
                                    $student_list=  get_list_by_id($student_id, STUDENT);
                                    if(!empty($take_type)){
                                      //  log_message('error','if task type:'.$task_type);
                                                        
                                        if($con_sms=='ps'){
                                          //  log_message('error','if con_sms:'.$con_sms);
                                            if($take_type=='present'){
                                            //    log_message('error','if task_type:'.$task_type);
                                                if($save['attendance']=="P"){
                                                  //  log_message('error','if save attem:'.$save['attendance']);
                                                    $get_template=$this->Data_model->get_present_template($user_id);
                                                    $message=$get_template['template_text'];
                                                    $send_sms_message=set_token_in_message($message,$student_list);
                                                    $send=send_sms_using_aip($user_id,$mobile_no,$send_sms_message,$student_id);
                                                }     
                                            }
                                        } 
                                       // log_message('error','IF ps over');
                                        if($con_sms=='as'){
                                          //   log_message('error','if con_sms as:'.$con_sms);
                                            if($take_type=='absent'){
                                             //   log_message('error','if task_type:'.$task_type);
                                                if($save['attendance']=="A")   {
                                               //     log_message('error','if save attent A:');
                                                    $get_template=$this->Data_model->get_absent_template($user_id);
                                                    $message=$get_template['template_text'];
                                                    $send_sms_message=set_token_in_message($message,$student_list);
                                                    $send=send_sms_using_aip($user_id,$mobile_no,$send_sms_message,$student_id);
                                                }
                                            }
                                        }
                                     //   log_message('error','IF as over');
                                        if($con_sms=='pas'){
                                       //     log_message('error','if con_sms pas:'.$con_sms);
                                            if($take_type=='both'){
                                         //       log_message('error','if task_type both:'.$task_type);
                                                if($save['attendance']=="A"){
                                           //         log_message('error','if save attent A:'.$save['attendance']);
                                                    $get_template=$this->Data_model->get_absent_template($user_id);
                                                    $message=$get_template['template_text'];
                                                    $send_sms_message=set_token_in_message($message,$student_list);
                                                    $send=send_sms_using_aip($user_id,$mobile_no,$send_sms_message,$student_id);
                                                }
                                                if($save['attendance']=="P"){
                                                    log_message('error','if save attent P:'.$save['attendance']);
                                                        $get_template=$this->Data_model->get_present_template($user_id);
                                                        $message=$get_template['template_text'];
                                                        $send_sms_message=set_token_in_message($message,$student_list);
                                                        $send=send_sms_using_aip($user_id,$mobile_no,$send_sms_message,$student_id);
                                                } 
                                            }
                                        }
                                      //  log_message('error','IF PAS over');
                                    }
                                        $save['adddate']=date('Y-m-d');
                                        $add2=insert_record(ATTENDANCE_SHEET, $save);
                                      //  log_message('error','Insereted record is add2:'.$add2);
                                }
                                if($add2) {
                                        $this->session->set_flashdata('success', 'Attendance store successfully !!' );
                                        redirect($this->config->item('admin_folder').'/attendance/take');
                                } else {
                                        $this->session->set_flashdata('error', 'Error while adding attendance !!' );
                                        redirect($this->config->item('admin_folder').'/attendance/take');
                                }
                                
                                
                               // log_message('error','Main else:');
                            }
                                    /*if($add) {
                                            $this->session->set_flashdata('success', 'Attendance store successfully !!' );
                                            redirect($this->config->item('admin_folder').'/attendance/take');
                                    } else {
                                            $this->session->set_flashdata('error', 'Error while adding attendance !!' );
                                            redirect($this->config->item('admin_folder').'/attendance/take');
                                    }*/
                           // exit;
                        log_message('error','Main submit over');
                    }
		$this->load->view($this->config->item('admin_folder').'/attendance_take', $data);
        }
		
        function get_class_list(){
            
                $admin=$this->session->userdata();
                $user_id=$admin['user_id'];
                $classname=$_REQUEST['class_name'];
                $get_student_list=$this->Data_model->get_student_list_by_id($user_id,$classname);
                $cl_nm=  get_list_by_id($classname, CLASSES);
                $attendance_sit='';
               // $attendance_sit.='<form action="'.ADMIN_URL.'/attendance/take" method="POST" >';
                $attendance_sit.='<h1><center>Take Attendance of class '.$cl_nm['name'].'</h1> ';
                $attendance_sit.='<table id="example1" class="table table-bordered ">';
                $attendance_sit.='<thead> <tr>';
               // $attendance_sit.='<th width="5%">NO. </th>';
                $attendance_sit.='<th width="15%">STUDENT ROLL NO</th> ';
                $attendance_sit.='<th>STUDENT NAME</th>';
                $attendance_sit.='<th>ATTENDANCE</th>';
                $attendance_sit.='</tr></thead><tbody>';
                $cnt=0;
                if(empty($get_student_list))
                {
                    $attendance_sit.='<tr>';
                    //$attendance_sit.='<td colspan=""></td>';
                    $attendance_sit.='<td colspan="3"><b>Sorry No Record Found</b></td>';
                    $attendance_sit.='<td ></td>';
                    $attendance_sit.=' </tr>  ';
                } else {
                    foreach($get_student_list as $student) {
                        $attendance_sit.='<tr id="firstrow">';
                        //$attendance_sit.='<td>'.$cnt.'</td> ';
                        //$attendance_sit.='<td>'.$student['roll_no'].'</td>';
                        if($user_id==20){
                          $attendance_sit.='<td>'.$student['admission_no'].'</td>';
                        }else{
                          $attendance_sit.='<td>'.$student['roll_no'].'</td>';
                        }
                        $attendance_sit.='<td>'.$student['name'].'</td>';
                        $attendance_sit.='<input type="hidden" name="student_name[]" id="student_name" value='.$student['name'].' >';
                        $attendance_sit.='<input type="hidden" name="student_id'.$cnt.'" id="student_id" value='.$student['id'].' >';
                        $attendance_sit.='<input type="hidden" name="class_name" id="class_name" value='.$classname.' >';
                        $attendance_sit.='<td ><input type="radio" name="student_att'.$cnt.'" value="P" onChange="rowHlight(this);" id="isPresent" onclick="changereverse()" checked="checked">P &nbsp; &nbsp; <input type="radio" name="student_att'.$cnt.'" onclick="changeColor()" onChange="rowHighlight(this);" value="A" id="isabsent" > A</td>';
                        $attendance_sit.=' </tr>  ';         
                        $cnt++;
                    }
                }
                $attendance_sit.='</tbody> </table>';
                $attendance_sit.='<div class="form-group" style="alignment-adjust: central"><input type="submit" name="submit" class="btn btn-primary" value="Submit Attendance"> </div>';
                //$attendance_sit.='<div class="form-group" style="alignment-adjust: central"><input type="submit" name="submit" class="btn btn-primary" value="Submit Attendance" onclick="confirboxvalue()" > </div>';
                // $attendance_sit.='</form>';
                echo $attendance_sit;
                //print_r($get_student_list);
        }
        
                
        function registration()
        {
                $data['page_title']='Registration Att';
                $data['get_list']='';
                $admin=$this->session->userdata();
                $user_id=$admin['user_id'];
                $field='user_id';
                $data['get_class_list']=get_list_by_idd($user_id,$field,CLASSES);
                //$data['get_class_list']=get_list(CLASSES);
                        if(isset($_POST['submit']))
                        {
                                $save['class_name']=$this->input->post('class_name',TRUE);
                                $save['month_name']=$this->input->post('month_name',TRUE);
                                $data['select']=$save;
                                $admin=$this->session->userdata();
                                $user_id=$admin['user_id'];
                                //$data['get_list']=$this->Data_model->check_attendance_reg($save['class_name'],$user_id);
                                
                                //$data['get_list']=get_list_by_field('class_name',$save['class_name'],STUDENT);
                                /* PRATIK ADDED 14-June-2016 */
                                $data['get_list']=get_list_by_field_two('user_id',$user_id,'class_name',$save['class_name'],STUDENT);
                               // echo "<pre>"; print_r($data['get_list']); exit;
                                $data['get_att_list']=$this->Data_model->check_attendance_reg($save['class_name'],$user_id);
                                //echo "<pre>"; print_r($data['get_att_list']); exit;
                                
                        }
		$this->load->view($this->config->item('admin_folder').'/attendance_reg', $data);
        }
                
        function mode($id='')
        {
            $data['page_title']='Add SMS Att';
            $data['check']='add';
            $data['status']=array('Active','Inactive');
            $data['mode']=base_url().$this->config->item('admin_folder').'/attendance/mode/';
            $data['val_error']='';
            $data['custom_error']=null;
                if($id !='')
                {
                    $data['check']='edit';
                    $data['mode']=base_url().$this->config->item('admin_folder').'/attendance/mode/'.$id;
                    $data['val_error']="";
                    $data['page_title']='Edit SMS Att';
                    $data['custom_error']=null;
                    $data['data']=get_list_by_id($id,ATTENDANCE_SMS_TEMPLATE);
                }
                    if(isset($_REQUEST['submit']))
                    {
                        $save['name']=$this->input->post('name',TRUE);
                        $save['template_text']=$this->input->post('template_text',TRUE);
                        $save['status']=$this->input->post('status',TRUE);
                            
                            //check empty records 
                            $check_required_val=check_required($save);
                        
                            if($check_required_val)
                            {        
                                    $data['val_error']='(*) field must be required !! ';
                            }  
                                
                                if($id=='')
                                {
                                    $admin=$this->session->userdata();
                                    $user_id=$admin['user_id'];
                                    $user=$admin['logint_type'];
                                    $save['user_id']=$user_id;    
                                    $str=$save['name'];
                                    $save['slug']=createSlugUrl(ATTENDANCE_SMS_TEMPLATE,$str);
                                    if($data['val_error']=='') 
                                    {
                                        $add=insert_record(ATTENDANCE_SMS_TEMPLATE, $save);
                                        if($add){
                                                    $this->session->set_flashdata('success', 'You have successfully Added attendance !!' );
                                                    redirect($this->config->item('admin_folder').'/attendance');
                                        } else {
                                                    $this->session->set_flashdata('error', 'Error while adding attendance !!' );
                                                    redirect($this->config->item('admin_folder').'/attendance');
                                        }
                                    }
                                } else {
                                        $save['editdate']=date("Y-m-d h:m:s");
                                        $id=$this->input->post('data_id',TRUE);
                                        if($data['val_error'] == '')
                                        {
                                            $upd = update_record($save,$id,ATTENDANCE_SMS_TEMPLATE);
                                            if($upd) 
                                            {       
                                                    $this->session->set_flashdata('success', 'You have successfully updated attendance !!' );
                                                    redirect($this->config->item('admin_folder').'/attendance');
                                            } else {
                                                    $this->session->set_flashdata('error', 'Error while updating attendance!!' );
                                                    redirect($this->config->item('admin_folder').'/attendance/mode');
                                            }
                                        }
                                }
                        }
                $this->load->view($this->config->item('admin_folder').'/attendance_form', $data);
        }
        
        //delete single record
        function delete($id)
	{       
		$del =delete_single_rec($id,ATTENDANCE_SMS_TEMPLATE);
		if($del){
			$this->session->set_flashdata('success', 'You have successfully deleted attendance !!' );
			redirect($this->config->item('admin_folder').'/attendance');
		} else {
			$this->session->set_flashdata('error', 'Error while deleting attendance !!' );
			redirect($this->config->item('admin_folder').'/attendance');
		}
	}
        
        function mul_action()
        {
                $action_val= $_REQUEST['mul_val'];
                $arr_ids= $_REQUEST['mul_id'];
                $path='/attendance';
                $table=ATTENDANCE_SMS_TEMPLATE;
                multiple_action($arr_ids, $action_val, $table, $path);
        }
        
        function change_status()
        {
            $id=$_REQUEST['id'];
            $status=$_REQUEST['status'];
            $table=ATTENDANCE_SMS_TEMPLATE;
            if($status== 'true')
            {   
                $status='Active';    
                $result=change_status($id,$status,$table);       
                echo $result;
            } else {   
                $status='Inactive';
                $result=change_status($id,$status,$table);       
                echo $result;
            }

        }
        
}?>
<style type="text/css">
		.highlighte { background-color: white; }
		.highlight { background-color: red; }
		
	</style>
	<script type="text/javascript">
	            $('#example1').DataTable({
                 "paging": false,
                "lengthChange": true,
                "searching": false,
                "scrollX": true,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
	
		function rowHighlight(obj) {
			if (obj.checked) {
				obj.parentNode.parentNode.className = 'highlight';
			} else {
				
				obj.parentNode.parentNode.className = 'highlight';
				
			}
		}
	function rowHlight(obj) {
		if (obj.checked) {
				obj.parentNode.parentNode.className = 'highlighte';
			} else {
				
				obj.parentNode.parentNode.className = 'highlighte';
				
			}
		}
	</script>
	

