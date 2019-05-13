<script src="<?php echo base_url()?>admin_assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<?php 
        $admin=$this->session->userdata();
        $id=$admin['admin_info'];
        $user_id=$admin['user_id'];
        if(!empty($user_id)){
            $edit_id=$user_id;
        } else {
            $edit_id=$admin['admin_id'];
        }
        $admin_info=$this->auth->get_admin_info($id);
?>
<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
             <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                        <?php if(empty($admin_info['photo'])){ ?> 
                            <img src="<?php echo base_url();?>upload/user_image/default/default.jpg"  class="img-circle"  alt="User Image">
                        <?php } else { ?> 
                            <img src="<?php echo base_url();?>upload/user_image/thumb/<?php echo $admin_info['photo']?>" class="img-circle" alt="User Image" style="width: 100%; height: 45px; line-height: 50px;" >
                        <?php } ?>
                </div>
                <div class="pull-left info">
                    <p><?php echo $admin_info['name'];?></p>
                    <div id="online"> <a href="" id="online"><i class="fa fa-circle text-success"></i> Online</a> </div>
                    <div id="away" style="display:none;"> <a href="" id="away"> Away</a> </div>
                </div>
            </div>
             
            <ul class="sidebar-menu">
                    <?php if($user_id != '') { ?>
                
                   <!-- <li <?php if($page_title=='Dashboard'){ echo 'class="active "'; } ?>>
                            <a href="<?php echo base_url().$this->config->item('admin_folder').'/dashboard'?>">
                                    <i class="fa fa-dashboard"></i> <span>Dashboard</span> 
                            </a>
                    </li> -->
                    
                        <li <?php if($page_title=='Dashboard'  ){ echo 'class="active "'; } ?> >
                            <a href="javascript:void(0);"><i class="fa fa-dashboard"></i>
                            <span>Dashboard</span><i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li <?php if($page_title=='Dashboard'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/dashboard'?>">
                                <i class="fa fa-check-square-o"></i>Dashboard</a>
                            </li>
                           
                           
                        </ul>
                    </li>
                    
                     <li  <?php if($page_title=='Send SMS' || $page_title=='SMS To Student'||  $page_title=='SMS To Teacher' || $page_title=='SMS To All Student' || $page_title=='SMS To Staff'|| $page_title=='SMS To Group' || $page_title=='SMS To Homework' || $page_title=='SMS To Class' || $page_title=='SMS Report'){ echo 'class="active treeview"'; } ?>>
                        <a href="javascript:void(0);"><i class="fa fa-send"></i>
                                <span>Send sms</span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                                <li <?php if($page_title=='Send SMS'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/send'?>">
                                    <i class="fa fa-send-o"></i>Send Sms</a>
                                </li>
                                <li <?php if($page_title=='SMS To Student'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/send/send-sms-to-student'?>">
                                    <i class="fa fa-send-o"></i>Sms To Student </a>
                                </li>
                                
                                <li <?php if($page_title=='SMS To All Student'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/send/allstudents'?>">
                                    <i class="fa fa-send-o"></i>Sms To All Students </a>
                                </li>
                                
                                <li <?php if($page_title=='SMS To Teacher'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/send/teacher'?>">
                                    <i class="fa fa-send-o"></i>Sms To Teacher</a>
                                </li>
                                <li <?php if($page_title=='SMS To Staff'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/send/staff'?>">
                                    <i class="fa fa-send-o"></i>Sms To Staff</a>
                                </li>
                                <li <?php if($page_title=='SMS To Group'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/send/group'?>">
                                    <i class="fa fa-send-o"></i>Sms To Group</a>
                                </li>
                                <li <?php if($page_title=='SMS To Homework'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/send/homework'?>">
                                    <i class="fa fa-send-o"></i>Sms To Homework</a>
                                </li>
                                <li <?php if($page_title=='SMS To Class'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/send/send-sms-to-class'?>">
                                    <i class="fa fa-send-o"></i>Sms To Class</a>
                                </li>
                                <li <?php if($page_title=='SMS Report'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/sms/report'?>">
                                    <i class="fa fa-check-square-o"></i>Sms Report</a>
                                </li>
                        </ul>
                    </li>
                    
                    <?php } ?>
                    
                    
                    <?php if($admin['logint_type']=='admin' && $admin['user_id']=='') {  ?>
                    <li  <?php if($page_title=='Add User' || $page_title=='Manage User'|| $page_title=='Edit User'){ echo 'class="active treeview"'; } ?>>
                        <a href="javascript:void(0);"><i class="fa fa-user"></i>
                                <span>User</span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                                <li <?php if($page_title=='Manage User'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/user'?>">
                                    <i class="fa fa-check-square-o"></i>Manage User</a>
                                </li>
                                <li <?php if($page_title=='Add User'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/user/mode'?>">
                                    <i class="fa fa-plus"></i>Add User</a>
                                </li>
                        </ul>
                    </li>
                    <?php } ?>
                    
                    <?php if($user_id != '') { ?>
                    <li  <?php if($page_title=='Add Group' || $page_title=='Manage Group'|| $page_title=='Edit Group'){ echo 'class="active treeview"'; } ?>>
                        <a href="javascript:void(0);"><i class="fa fa-users"></i>
                                <span>Group</span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                                <li <?php if($page_title=='Manage Group'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/group'?>">
                                    <i class="fa fa-check-square-o"></i>Manage Group</a>
                                </li>
                                <li <?php if($page_title=='Add Group'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/group/mode'?>">
                                    <i class="fa fa-plus"></i>Add Group</a>
                                </li>
                        </ul>
                    </li>
                    
                    <li  <?php if($page_title=='Add Staff' || $page_title=='Staff Import' || $page_title=='Manage Staff'|| $page_title=='Edit Staff'){ echo 'class="active treeview"'; } ?>>
                        <a href="javascript:void(0);"><i class="fa fa-users"></i>
                            <span>Staff</span><i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                                <li <?php if($page_title=='Manage Staff' || $page_title=='Staff Import'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/staff'?>">
                                    <i class="fa fa-check-square-o"></i>Manage Staff</a>
                                </li>
                                <li <?php if($page_title=='Add Staff'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/staff/mode'?>">
                                    <i class="fa fa-plus"></i>Add Staff</a>
                                </li>
                        </ul>
                    </li>
                    
                    <li <?php if($page_title=='Add Student' || $page_title=='Manage Student' || $page_title=='Student Import' || $page_title=='Edit Student'){ echo 'class="active treeview"'; } ?>>
                        <a href="javascript:void(0);"><i class="fa fa-users"></i>
                                <span>Student</span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                                <li <?php if($page_title=='Manage Student' || $page_title=='Student Import' ){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/student'?>">
                                    <i class="fa fa-check-square-o"></i>Manage Student</a>
                                </li>
                                <li <?php if($page_title=='Add Student'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/student/mode'?>">
                                    <i class="fa fa-plus"></i>Add Student</a>
                                </li>
                        </ul>
                    </li>
                    
                    <li <?php if($page_title=='Manage Teacher' || $page_title=='Edit Teacher' || $page_title=='Teacher Import' || $page_title=='Add Teacher'){ echo 'class="active "'; } ?> >
                        <a href="javascript:void(0);"><i class="fa fa-male"></i>
                            <span>Class Teacher</span><i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                                <li <?php if($page_title=='Manage Teacher' || $page_title=='Teacher Import'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/teacher'?>">
                                    <i class="fa fa-check-square-o"></i>Manage Teacher</a>
                                </li>
                                <li <?php if($page_title=='Add Teacher'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/teacher/mode'?>">
                                    <i class="fa fa-plus"></i>Add Teacher </a>
                                </li>
                        </ul>
                    </li>
                    
                    <li <?php if($page_title=='Add Class' || $page_title=='Class Import'  ||  $page_title=='Manage Class'|| $page_title=='Edit Class'){ echo 'class="active treeview"'; } ?>>
                        <a href="javascript:void(0);"><i class="fa fa-users"></i>
                                <span>Class</span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                                <li <?php if($page_title=='Manage Class' || $page_title=='Class Import'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/classes'?>">
                                    <i class="fa fa-check-square-o"></i>Manage Class</a>
                                </li>
                                <li <?php if($page_title=='Add Class'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/classes/mode'?>">
                                    <i class="fa fa-plus"></i>Add Class</a>
                                </li>
                        </ul>
                    </li>
                    
<!--                    <li  <?php if($page_title=='Add Homework' || $page_title=='Manage Homework'|| $page_title=='Edit Homework'){ echo 'class="active treeview"'; } ?>>
                        <a href="javascript:void(0);"><i class="fa fa-users"></i>
                                <span>Homework</span> <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                                <li <?php if($page_title=='Manage Homework'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/homework'?>">
                                    <i class="fa fa-check-square-o"></i>Manage Homework</a>
                                </li>
                                <li <?php if($page_title=='Add Homework'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/homework/mode'?>">
                                    <i class="fa fa-plus"></i>Add Homework</a>
                                </li>
                        </ul>
                    </li>-->
                    
                    <li <?php if($page_title=='Manage SMS Temp'  ||  $page_title=='Edit SMS Temp' || $page_title=='Add SMS Temp'){ echo 'class="active "'; } ?> >
                        <a href="javascript:void(0);"><i class="fa fa-envelope-o"></i>
                            <span> Sms Template </span><i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                                <li <?php if($page_title=='Manage SMS Temp'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/sms'?>">
                                    <i class="fa fa-check-square-o"></i>Manage Sms Temp</a>
                                </li>
                                <li <?php if($page_title=='Add SMS Temp'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/sms/mode'?>">
                                    <i class="fa fa-plus"></i>Add Sms Temp</a>
                                </li>
                        </ul>
                    </li>
                    
                    <li <?php if($page_title=='Manage SMS Att'  || $page_title=='Edit SMS Att' || $page_title=='Add SMS Att' || $page_title=='Registration Att' || $page_title=='Take Attendance'){ echo 'class="active "'; } ?> >
                        <a href="javascript:void(0);"><i class="fa fa-envelope-o"></i>
                                <span>Attendance Template.</span><i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            
                              
                                <li <?php if($page_title=='Take Attendance'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/attendance/take'?>">
                                       <i class="fa fa-check-square-o"></i>Take Attendance</a>
                                </li>
                                <li <?php if($page_title=='Registration Att'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/attendance/registration'?>">
                                        <i class="fa fa-check-square-o"></i>Attendance Reg.</a>
                                </li>
                                <li <?php if($page_title=='Manage SMS Att'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/attendance'?>">
                                        <i class="fa fa-check-square-o"></i>Attendance Temp.</a>
                                </li>
                                
<!--                                <li <?php if($page_title=='Add SMS Att'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/attendance/mode'?>">
                                        <i class="fa fa-plus"></i>Add SMS Att.</a>
                                </li>-->
                        </ul>
                    </li>
                    
                    <?php } ?>
                   <!-- <li <?php if($page_title=='Manage Email Templates' || $page_title=='Edit Email Templates'){ echo 'class="active "'; } ?> >
                        <a ><i class="fa fa-envelope-o"></i>
                            <span>Email Templates</span><i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                                <li <?php if($page_title=='Manage Email Templates'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/Email_templates'?>">
                                        <i class="fa fa-check-square-o"></i>Manage Email Temp.</a>
                                </li>
                        </ul>
                    </li> -->
                    
                    <?php if($admin['logint_type']=='admin' && $admin['user_id']=='') {  ?>
                    <li <?php if($page_title=='Manage SMS API' || $page_title=='Alot SMS API' || $page_title=='Add SMS API'){ echo 'class="active "'; } ?> >
                        <a href="javascript:void(0);"><i class="fa fa-envelope-o"></i>
                            <span>Manage Sms Api</span><i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                                <li <?php if($page_title=='Manage SMS API'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/smsapi'?>">
                                    <i class="fa fa-check-square-o"></i>Manage Sms Api</a>
                                </li>
                                <li <?php if($page_title=='Alot SMS API'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/smsapi/allocate'?>">
                                    <i class="fa fa-check-square-o"></i>Alot Sms Api</a>
                                </li>
                        </ul>
                    </li>
                     <?php } ?>
                    <!-- <li <?php if($page_title=='Manage SMS Alot' || $page_title=='Manage SMS API' ){ echo 'class="active "'; } ?> >
                        <a><i class="fa fa-envelope-o"></i>
                            <span>Alot SMS API</span><i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                                
                        </ul>
                    </li> -->
                  
                    
                    <li <?php if($page_title=='Manage Manager' || $page_title=='Edit Manager' || $page_title=='Add Manager'){ echo 'class="active "'; } ?> >
                        <a href="javascript:void(0);"><i class="fa fa-envelope-o"></i>
                            <span>Account Manager</span><i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                                <?php if($user_id == '') { ?>
                                <li <?php if($page_title=='Add Manager' || $page_title=='Edit Contact' || $page_title=='View Contact'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/contact/mode'?>">
                                        <i class="fa fa-check-square-o"></i>Add Manager </a>
                                </li>
                                <?php } ?>
                                <li <?php if($page_title=='Manage Manager' || $page_title=='Edit Contact' || $page_title=='View Contact'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/contact'?>">
                                        <i class="fa fa-check-square-o"></i>Manage Manager </a>
                                </li>
                        </ul>
                    </li>
                    
                    <li <?php if($page_title=='Site Setting' || $page_title=='Manage Page'  || $page_title=='Change Password' || $page_title=='Edit Profile' || $page_title=='Edit Page'){ echo 'class="active "'; } ?> >
                        <a href="javascript:void(0);" ><i class="fa fa-wrench"></i>
                            <span>Settings</span><i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                                <?php if($user_id=='' ) { ?>
                                <li <?php if($page_title=='Site Setting'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/site/mode'?>">
                                        <i class="fa fa-check-square-o"></i>Site Setting</a>
                                </li>
                                <?php } ?>
                                <li <?php if($page_title=='Edit Profile'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/user/mode/'.$edit_id ?>">
                                        <i class="fa fa-user"></i>Edit Profile</a>
                                </li>
                                <li <?php if($page_title=='log_out'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/login/logout'?>">
                                        <i class="fa fa-power-off"></i>Logout</a>
                                </li>
                        </ul>
                    </li>
                    <!-- <li <?php if($page_title=='demoforpage'){ echo 'class="active treeview"'; } ?>>
                            <a href="<?php echo base_url().$this->config->item('admin_folder').'/demoforcontroller'?>">
                                    <i class="fa fa-dashboard"></i> <span>Temp</span> 
                            </a>
                    </li>-->
            </ul>
    </section>
</aside>