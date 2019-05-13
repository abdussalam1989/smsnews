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
					<?php }?>
                </div>
                <div class="pull-left info">
                    <p><?php echo $admin_info['name'];?></p>
                    <div id="online"> <a href="" id="online"><i class="fa fa-circle text-success"></i> Online</a> </div>
                    <div id="away" style="display:none;"> <a href="" id="away"> Away</a> </div>
                </div>
            </div>
             
            <ul class="sidebar-menu">
                    <?php if($user_id != '') { ?>
                        <li <?php if($page_title=='Dashboard'  ){ echo 'class="active "'; } ?> >
                            <a href="<?php echo base_url().$this->config->item('admin_folder').'/dashboard'?>"><i class="fa fa-dashboard"></i>
                            <span>Dashboard</span><i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <!-- <ul class="treeview-menu">
                            <li <?php if($page_title=='Dashboard'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/dashboard'?>">
                                <i class="fa fa-check-square-o"></i>Dashboard</a>
                            </li> 
                        </ul> -->
                    </li>
                    
                     <li <?php if($page_title=='Send SMS' || $page_title=='SMS To Student'||  $page_title=='SMS To Teacher' || $page_title=='SMS To All Student' || $page_title=='SMS To Staff'|| $page_title=='SMS To Group' || $page_title=='SMS To Homework' || $page_title=='SMS To Class' || $page_title=='SMS Report'){ echo 'class="active treeview"'; } ?>>
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
                                
                           <!-- <li <?php if($page_title=='SMS To All Student'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/send/allstudents'?>">
                                    <i class="fa fa-send-o"></i>Sms To All Students </a>
                                </li>-->
                                
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
                    <li>
                        <a href="javascript:void(0);"><i class="fa fa-users"></i>
                                <span>Manage</span> <i class="fa fa-angle-left pull-right"></i> 
                        </a>
                        <ul class="treeview-menu">
                                <li <?php if($page_title=='Manage Group'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/group'?>">
                                    <i class="fa fa-check-square-o"></i>Group</a>
                                </li>
								<li <?php if($page_title=='Manage Staff' || $page_title=='Staff Import'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/staff'?>">
                                    <i class="fa fa-check-square-o"></i> Staff</a>
                                </li>
								 <li <?php if($page_title=='Manage Student' || $page_title=='Student Import' ){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/student'?>">
                                    <i class="fa fa-check-square-o"></i> Student</a>
                                </li>
								<li <?php if($page_title=='Manage Teacher' || $page_title=='Teacher Import'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/teacher'?>">
                                    <i class="fa fa-check-square-o"></i> Teacher</a>
                                </li>
								 <li <?php if($page_title=='Manage Class' || $page_title=='Class Import'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/classes'?>">
                                    <i class="fa fa-check-square-o"></i> Class</a>
                                </li>
								<li <?php if($page_title=='Manage SMS Temp'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/sms'?>">
                                    <i class="fa fa-check-square-o"></i>Template</a>
                                </li>
                               
                        </ul>
                    </li>
                    
                    <li <?php if($page_title=='Manage SMS Att'  || $page_title=='Edit SMS Att' || $page_title=='Add SMS Att' || $page_title=='Registration Att' || $page_title=='Take Attendance'){ echo 'class="active "'; } ?> >
                        <a href="javascript:void(0);"><i class="fa fa-envelope-o"></i>
                                <span>Attendance</span><i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                                <li <?php if($page_title=='Take Attendance'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/attendance/take'?>">
                                       <i class="fa fa-check-square-o"></i>Take Attendance</a>
                                </li>
                                <li <?php if($page_title=='Registration Att'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/attendance/registration'?>">
                                        <i class="fa fa-check-square-o"></i>Attendance Register</a>
                                </li>
                                <li <?php if($page_title=='Manage SMS Att'){ echo 'class="active"'; } ?>><a href="<?php echo base_url().$this->config->item('admin_folder').'/attendance'?>">
                                        <i class="fa fa-check-square-o"></i>Attendance Template</a>
                                </li>

                        </ul>
                    </li>
                    <?php } ?>

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
					
					<!-- <li>
                        <a href="javascript:void(0);"><i class="fa fa-users"></i>
                            <span>Diary</span> <i class="fa fa-angle-left pull-right"></i> 
                        </a>
                        <ul class="treeview-menu">
							<li <?php if($page_title=='Manage Notice' || $page_title=='Edit Notice' || $page_title=='Add Notice' || $page_title=='Notice'){ echo 'class="active"'; } ?> >
								<a href="<?php echo base_url().$this->config->item('admin_folder').'/notice'?>"><i class="fa fa-envelope-o"></i>
									<span>Notice</span><i class="fa fa-angle-left pull-right"></i>
								</a>
							</li>
							
							<li <?php if($page_title=='Manage Events' || $page_title=='Edit Events' || $page_title=='Add Events' || $page_title=='Events'){ echo 'class="active "'; } ?> >
								<a href="<?php echo base_url().$this->config->item('admin_folder').'/events'?>"><i class="fa fa-envelope-o"></i>
									<span>Events</span><i class="fa fa-angle-left pull-right"></i>
								</a>
							</li>
							
							<li <?php if($page_title=='Update Note' || $page_title=='Edit Update Note' || $page_title=='Add Update Note' || $page_title=='Update Note'){ echo 'class="active "'; } ?> >
								<a href="<?php echo base_url().$this->config->item('admin_folder').'/note'?>"><i class="fa fa-envelope-o"></i>
									<span>Update Note</span><i class="fa fa-angle-left pull-right"></i>
								</a>
							</li>
							
							<li <?php if($page_title=='Homework' || $page_title=='Edit Homework' || $page_title=='Add Homework' || $page_title=='Homework'){ echo 'class="active "'; } ?> >
								<a href="<?php echo base_url().$this->config->item('admin_folder').'/homework'?>"><i class="fa fa-envelope-o"></i>
									<span>Homework</span><i class="fa fa-angle-left pull-right"></i>
								</a>
							</li>                              
                        </ul>
                    </li> -->
                    
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
            </ul>
    </section>
</aside>