<?php include('header.php')?>
<?php if(isset($user_data['overall_sms'])){ echo $user_data['overall_sms']; } ?>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php  include('header_menu.php') ?>
            <!-- Left side column. contains the logo and sidebar -->
            <?php include('aside.php')?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1><?php echo $page_title; ?> </h1>
                        <div id="act_msg" ></div> 
                        <div id="div_msg"> 
                            <?php include('flashmessage.php');?>
                        </div>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo ADMIN_URL.'/dashboard'; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo ADMIN_URL.'/smsapi/allocate';?>">Manage SMS Alot</a></li>
                        <li class="active"><?php echo $page_title; ?></li>
                    </ol>
                </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                         <div class="box-body">
                             <div class="col-md-3"></div>
                             <div class="col-md-6">
                             <?php if($check =='edit' )  { ?>     
                        <form role="form" method="POST" enctype="multipart/form-data" action="<?php echo ADMIN_URL; ?>/smsapi/allocate">    
                           
                            <!--<div class="col-md-3">
                                 <label>API Name </label>
                            </div>
                            <div class="col-md-9 form-group">
                                <select name="api_name" class="form-control" id="api_name">
                                <option value="" <?php if(isset($data['id'])){?> disabled='' <?php } ?>> Select </option>
                                <?php foreach($api_data as $api): ?>
                                <option value="<?php echo $api['id']; ?>" ><?php echo $api['api_name']."  -  SMS : ". $api['api_msg']; ?></option>
                                <?php endforeach; ?> 
                                </select>
                            </div> -->
                            
                            <!-- <div class="col-md-3">
                                 <label>Select User </label>
                            </div>
                            <div class="col-md-9 form-group">
                                <select name="select_user" class="form-control" id="select_user">
                                <option value="-1"  > Select User </option>
                                <?php foreach($user_list as $user_lt): ?>
                                <option value="<?php echo $user_lt['id']; ?>"   ><?php echo $user_lt['name']; ?></option>
                                <?php endforeach; ?> 
                                </select>
                            </div> -->
                       
                            <fieldset>
                            <legend>API ONE</legend>
                            
                            <div class="col-md-3">
                                <label>User name </label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="name" id="name"  class="form-control" readonly="readonly" value="<?php if(isset($user_data['name'])){ echo $user_data['name']; } ?>"  >
                                <input type="hidden" name="user_id" id="user_id" value="<?php if(isset($user_data['id'])){ echo $user_data['id']; }?>">
                            </div>
                            
                            <div class="col-md-3">
                                <label>Api-1 User name </label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="username_one" id="username_one"  class="form-control" value="<?php if(isset($user_data['username_one'])){ echo $user_data['username_one']; } ?>"  >
                            </div>
                            
                            <div class="col-md-3">
                                <label>Api Password</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="password_one" id="password_one"  class="form-control" value="<?php if(isset($user_data['password_one'])){ echo $user_data['password_one']; } ?>" >
                            </div>
                            
                            <div class="col-md-3">
                                <label>Sender ID </label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="senderid_one" id="senderid_one" class="form-control" value="<?php if(isset($user_data['senderid_one'])){ echo $user_data['senderid_one']; } ?>" >
                            </div>
                            
                            <div class="col-md-3">
                                <label>SMS Type</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <select name="smstype_one" class="form-control" id="smstype_one">
                                <option value="-1" > Select </option>
                                <?php foreach($sms_type as $type): ?>
                                <option value="<?php echo $type['type_name']; ?>" <?php if(isset($user_data['smstype_one'])){if($type['type_name'] == $user_data['smstype_one']){ ?> selected <?php } } ?>  ><?php echo $type['type_name']; ?></option>
                                <?php endforeach; ?> 
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label>Priority Details</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <select name="prioritydetails_one" class="form-control" id="prioritydetails_one">
                                <option value="-1" > Select </option>
                                <?php foreach($sms_priority as $p_name): ?>
                                <option value="<?php echo $p_name['type_name']; ?>" <?php if(isset($user_data['prioritydetails_one'])){if($p_name['type_name'] == $user_data['prioritydetails_one']){ ?> selected <?php } } ?>  ><?php echo $p_name['type_name']; ?></option>
                                <?php endforeach; ?> 
                                </select>
                            </div>
                            
                           <!-- <div class="col-md-3">
                                <label>Total Sms </label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="total_sms_one" id="total_sms_one" readonly="readonly" class="form-control" value="<?php if(isset($user_data['red_sms_one'])){ echo $user_data['red_sms_one']; } ?>"  >
                            </div>-->
                            
                            <div class="col-md-3">
                                <label>Total Sms </label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="t_sms_one" id="t_sms_one"  class="form-control" value="<?php if(isset($user_data['total_sms_one'])){ echo $user_data['total_sms_one']; } ?>"  >
                            </div>
							<div class="col-md-3">
                                <label>U Sms </label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="" id="" readonly="readonly" class="form-control" value="<?php if(isset($overall_sms)){ echo $overall_sms; } ?>"  >  </div>
							
                            
                            <div class="col-md-3">
                                <label>R Sms </label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="r_sms_one" id="r_sms_one"  class="form-control" value="<?php if(isset($user_data['red_sms_one'])){ echo $user_data['red_sms_one']; } ?>"  >
                            </div>
                                                        
                            <div class="col-md-3">
                                <label>Status</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <select name="status_one" class="form-control" id="status_one">
                                <option value="-1"> Select Status</option>
                                <option value="Active"  <?php if(isset($user_data['status_one'])){ if($user_data['status_one']=='Active') { ?> selected="selected"  <?php } } ?> >Activate</option>
                                <option value="Inactive"  <?php if(isset($user_data['status_one'])){ if($user_data['status_one']=='Inactive') { ?> selected="selected"  <?php } } ?> > Deactivate</option>
                                </select>
                            </div>
                            </fieldset>
                            
                            <fieldset>
                            <legend>API TWO</legend>
                            <div class="col-md-3">
                                <label>Api-2 User name </label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="username_two" id="username_two"  class="form-control" value="<?php if(isset($user_data['username_two'])){ echo $user_data['username_two']; } ?>"  >
                            </div>
                            
                            <div class="col-md-3">
                                <label>Api Password</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="password_two" id="password_two"  class="form-control" value="<?php if(isset($user_data['senderid_two'])){ echo $user_data['password_two']; } ?>" >
                            </div>
                            
                            <div class="col-md-3">
                                <label>Api Hash</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="api_two_hash" id="api_two_hash"  class="form-control" value="<?php if(isset($user_data['api_two_hash'])){ echo $user_data['api_two_hash']; } ?>" >
                            </div>
                            
                            
                            <div class="col-md-3">
                                <label>Sender ID </label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="senderid_two" id="senderid_two" class="form-control" value="<?php if(isset($user_data['senderid_two'])){ echo $user_data['senderid_two']; } ?>" >
                            </div>
                            
                            <div class="col-md-3">
                                <label>SMS Type</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <select name="smstype_two" class="form-control" id="smstype_two">
                                <option value="" > Select </option>
                                <?php foreach($sms_type as $type): ?>
                                <option value="<?php echo $type['type_name']; ?>" <?php if(isset($user_data['smstype_two'])){if($type['type_name'] == $user_data['smstype_two']){ ?> selected <?php } } ?>  ><?php echo $type['type_name']; ?></option>
                                <?php endforeach; ?> 
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label>Priority Details</label>
                            </div>
<!--                            <div class="col-md-9 form-group">
                                <textarea name="prioritydetails_two" id="prioritydetails_two" class="form-control" ><?php if(isset($user_data['prioritydetails_two'])){ echo $user_data['prioritydetails_two'];  }  ?></textarea>
                            </div>-->
                            
                            <div class="col-md-9 form-group">
                                <select name="prioritydetails_two" class="form-control" id="prioritydetails_two">
                                <option value="-1" > Select </option>
                                <?php foreach($sms_priority as $p_name): ?>
                                <option value="<?php echo $p_name['type_name']; ?>" <?php if(isset($user_data['prioritydetails_two'])){if($p_name['type_name'] == $user_data['prioritydetails_two']){ ?> selected <?php } } ?>  ><?php echo $p_name['type_name']; ?></option>
                                <?php endforeach; ?> 
                                </select>
                            </div>
                            
                            
                            <!--<div class="col-md-3">
                                <label>Total message </label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="total_sms_two" id="total_sms_two" readonly="readonly"  class="form-control" value="<?php if(isset($user_data['total_sms_two'])){ echo $user_data['total_sms_two']; } ?>"  >
                            </div>
							<div class="col-md-3">
                                <label>Old Total Message </label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="alot_sms_two" id="alot_sms_two"  class="form-control" value="<?php if(isset($user_data['total_sms_two'])){ echo $user_data['total_sms_two']; } ?>"  >
                            </div>-->
							
							 <div class="col-md-3">
                                <label>Total Sms </label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="t_sms_two" id="t_sms_two"  class="form-control" value="<?php if(isset($user_data['total_sms_two'])){ echo $user_data['total_sms_two']; } ?>">
                            </div>

							 <div class="col-md-3">
                                <label>U Sms </label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="" id="" readonly="readonly"  class="form-control" value="<?php if(isset($overall_sms)){ echo $overall_sms; } ?>"  >
                            </div>
                            
							  
                            <div class="col-md-3">
                                <label>R Sms</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="r_sms_two" id="r_sms_two"  class="form-control" value="<?php if(isset($user_data['red_sms_two'])){ echo $user_data['red_sms_two']; } ?>">
                            </div>
                            
                            <div class="col-md-3">
                                <label>Status</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <select name="status_two" class="form-control" id="status_two">
                                <option value="-1"> Select Status</option>
                                <option value="Active" <?php if(isset($user_data['status_two'])){ if($user_data['status_two']=='Active') { ?> selected="selected"  <?php } } ?> >Activate</option>
                                <option value="Inactive" <?php if(isset($user_data['status_two'])){ if($user_data['status_two']=='Inactive') { ?> selected="selected"  <?php } } ?> >Deactivate</option>
                                </select>
                            </div>
                            </fieldset>
                            <div class="col-md-3"></div>
                            <div class="col-md-9 form-group">
                                <button type="submit" name="submit" id="submit" class="btn btn-primary">&nbsp; Save &nbsp;</button>
                            </div>
                        </form>
                        <?php } ?>
                        </div>
                        <div class="col-md-3"></div>
                        </div>
                        
               <div class="box-body">
                     <?php if(empty($user_list)) { ?>
                    <table id="example2" class="table table-bordered table-striped">
                      <thead>
                                <tr>
                                    <th id="fir" width="3%"><input type="checkbox" id="ckbCheckAll2" name="head_checkbox" ></th>       
                                    <th width="5%">NO. </th>
                                    <th>NAME</th>
                                    <th>CLASS NAME</th>
                                    <th>TOTAL MESSAGE</th>
                                    <th width="8%">OPTION</th>
                                </tr>
                            </thead>
                    </table>
                        <?php } else { ?>
                        <form name="list_form" action="<?php echo base_url().$this->config->item('admin_folder')?>/student/mul_action" method="POST" >
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>                               
                                <th width="5%">NO. </th>
                                <th>NAME</th>
                                <th>Email</th>
                                <th width="10%">USER STATUS</th>
                                <th>API 1 SENT SMS</th>
                                <th>API1 STATUS</th>
                                <th>API 2 SENT SMS</th>
                                <th>API2 STATUS</th> 
                                <th width="12% ">OPTION</th>
                                </tr>
                            </thead>
                        <tbody>
                            <?php 
                            $cnt=1;
                            foreach ($user_list as $data_list) { ?>
                                <tr>  
                                    <td><?php echo $cnt;?></td> 
                                    <td><?php echo $data_list['name'];?></td>  
                                    <td><?php echo $data_list['email'];?></td>  
                                    
                                    <td><?php $checked = '';
                                    if($data_list['status']=='Active') {
                                            $checked = 'checked'; ?>  
                                            <input type='checkbox' name='boot_btnn' id='<?php echo $data_list['id'];?>' value="<?php echo '/User/change_status/'; ?>" class='form-control'  data-size='mini' <?php echo $checked ?> >
                                    <?php } else { ?>
                                            <input type='checkbox' name='boot_btnn' id='<?php echo $data_list['id'];?>' value="<?php echo '/User/change_status/'; ?>" class='form-control'  data-size='mini'>
                                            <input type="hidden" name="image" id="image" value="<?php echo $data_list['photo']; ?>">
                                    </td>
                                    <?php } ?>

                                    <td><?php echo $data_list['total_sms_one']; ?> </td>
                                    <td><?php $checked = '';
                                    if($data_list['status_one']=='Active') {
                                            $checked = 'checked'; ?>  
                                            <input type='checkbox' name='boot_btnn' id='<?php echo $data_list['id'];?>' value="<?php echo '/User/change_status_api/'; ?>" class='form-control'  data-size='mini' <?php echo $checked ?> >
                                            <input type="hidden" id="<?php echo 'API1'; ?>">
                                    <?php } else { ?>
                                            <input type='checkbox' name='boot_btnn' id='<?php echo $data_list['id'];?>' value="<?php echo '/User/change_status_api/'; ?>" class='form-control'  data-size='mini'>
                                            <input type="hidden" id="<?php echo 'API1'; ?>">
                                    </td>
                                    <?php } ?>  

                                    <td><?php echo $data_list['total_sms_two']; ?></td>
                                    <td><?php $checked = '';
                                    if($data_list['status_two']=='Active') {
                                            $checked = 'checked'; ?>  
                                            <input type='checkbox' name='boot_btnn' id='<?php echo $data_list['id'];?>' value="<?php echo '/User/change_status_apii/'; ?>" class='form-control'  data-size='mini' <?php echo $checked ?> >
                                            <input type="hidden" id="<?php echo 'API2'; ?>">
                                    <?php } else { ?>
                                            <input type='checkbox' name='boot_btnn' id='<?php echo $data_list['id'];?>' value="<?php echo '/User/change_status_apii/'; ?>" class='form-control'  data-size='mini'>
                                            <input type="hidden" id="<?php echo 'API2'; ?>">
                                    </td>
                                    <?php } ?>                                    
                                    <td><a class="pencil-square-o" title="Alot SMS" href="<?php echo base_url().$this->config->item('admin_folder').'/smsapi/alot_msg/'.$data_list['id']?>"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;
                                    </td>
                                </tr>  
                                <?php $cnt++; } ?>  
                        </tbody>
                        </table>
                        <?php } ?>
                        </form>
                </div>  
                        
                    <!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section> 
       
    </div><!-- /.content-wrapper -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <?php include('footer.php'); ?>
  </body>
  <script src="<?php echo base_url()?>admin_assets/js/user.js"> </script>
</html>
