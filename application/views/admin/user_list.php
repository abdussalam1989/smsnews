<?php include('header.php');?>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php  include('header_menu.php'); ?>
            <!-- Left side column. contains the logo and sidebar -->
            <?php include('aside.php');?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                 <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1><?php echo $page_title?></h1>
            <div id="act_msg" ></div> 
            <div id="div_msg">
                <?php include('flashmessage.php');?>
            </div>  
            <ol class="breadcrumb">
            <li><a href="<?php echo base_url().$this->config->item('admin_folder').'/dashboard'?>"><i class="fa fa-dashboard"></i> Home</a></li>
             
            <?php $admin=$this->session->userdata();
                        $user_id=$admin['user_id'];
                            if($user_id =='') {?>
                           <li><a href="<?php echo base_url().$this->config->item('admin_folder').'/user'?>">User</a></li>
                            <?php } ?>
            <li class="active"><?php echo $page_title ?></li>
        </ol>
        </section>
                
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <?php  $admin=$this->session->userdata(); 
                                   $logint_type=$admin['logint_type']; 
                                   if($logint_type=='admin') {?>
                            <a class="btn btn-default pull-right" href="<?php echo base_url().$this->config->item('admin_folder')?>/user/mode">Add User</a>
                            <?php } ?>
                            <form action="<?php echo ADMIN_URL ?>/user/" enctype="multipart/form-data" method="POST">                                    
                                    <div class="col-md-2 form-group">
                                        <label>Select : </label>
                                        <select name="api_name" class="btn btn-default" id="class_name" onchange='this.form.submit()'>
                                            <option value="select"> All API </option>
                                            <option value="status_one" <?php echo $api_status_one=='status_one'?'selected=selected':'';?>> API 1 </option>
                                            <option value="status_two" <?php echo $api_status_two=='status_two'?'selected=selected':'';?>> API 2 </option> 
                                        </select>
                                    </div>
                            </form>
                            <!-- <h3 class="box-title">Display Users</h3>-->
                            <div class="btn-group ">
                            </div>
                        </div><!-- /.box-header -->
                    
                <div class="box-body">
                     <?php if(empty($userlist)) { ?>
                    <table id="example2" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th id="fir" width="3%"><input type="checkbox" id="ckbCheckAll2" name="head_checkbox" ></th>       
                                <th width="5%">NO. </th>
                                <th>NAME</th>
                                <th>Email</th>
                                <th width="10%">API2 STATUS</th>
                                <th width="8% ">OPTION</th>
                            </tr>
                            </thead>
                    </table>
                    <?php } else { ?>
                    <form name="list_form" action="<?php echo base_url().$this->config->item('admin_folder')?>/user/mul_action" method="POST" >
                    <table  id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th id="fir" width="3%"><input type="checkbox" id="ckbCheckAll2" name="head_checkbox" ></th>       
                                <th width="5%">NO. </th>
                                <th>NAME</th>
                                <th>Email</th>
                                <th width="10%">USER TYPE</th>
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
                        $del_url='/user/delete/';
                        foreach ($userlist as $user){ ?>
                            <tr>  
                                <td><input type="checkbox" name="mul_id[]" id="mul_id"  value="<?php echo $user['id']?>"  class="checkBoxClass"  > </td>
                                <td><?php echo $cnt;?></td> 
                                <td><?php echo $user['name']; ?></td>  
                                <td><?php echo $user['email']; ?></td>
                                <td><?php echo ucfirst($user['logint_type']); ?></td>
                                
                                <td><?php $checked = '';
                                if($user['status']=='Active') {
                                        $checked = 'checked'; ?>  
                                        <input type='checkbox' name='boot_btnn' id='<?php echo $user['id'];?>' value="<?php echo '/User/change_status/'; ?>" class='form-control'  data-size='mini' <?php echo $checked ?> >
                                <?php } else { ?>
                                        <input type='checkbox' name='boot_btnn' id='<?php echo $user['id'];?>' value="<?php echo '/User/change_status/'; ?>" class='form-control'  data-size='mini'>
                                        <input type="hidden" name="image" id="image" value="<?php echo $user['photo']; ?>">
                                </td>
                                <?php } ?>
                                
                                <td><?php echo $user['total_sms_one']; ?> </td>
                                <td><?php $checked = '';
                                if($user['status_one']=='Active') {
                                        $checked = 'checked'; ?>  
                                        <input type='checkbox' name='boot_btnn' id='<?php echo $user['id'];?>' value="<?php echo '/User/change_status_api/'; ?>" class='form-control'  data-size='mini' <?php echo $checked ?> >
                                        <input type="hidden" id="<?php echo 'API1'; ?>">
                                <?php } else { ?>
                                        <input type='checkbox' name='boot_btnn' id='<?php echo $user['id'];?>' value="<?php echo '/User/change_status_api/'; ?>" class='form-control'  data-size='mini'>
                                        <input type="hidden" id="<?php echo 'API1'; ?>">
                                </td>
                                <?php } ?>  
                                <td><?php echo $user['total_sms_two']; ?></td>
                                <td><?php $checked='';
                                if($user['status_two']=='Active') {
                                        $checked = 'checked'; ?>  
                                        <input type='checkbox' name='boot_btnn' id='<?php echo $user['id'];?>' value="<?php echo '/User/change_status_apii/'; ?>" class='form-control'  data-size='mini' <?php echo $checked ?> >
                                        <input type="hidden" id="<?php echo 'API2'; ?>">
                                <?php } else { ?>
                                        <input type='checkbox' name='boot_btnn' id='<?php echo $user['id'];?>' value="<?php echo '/User/change_status_apii/'; ?>" class='form-control'  data-size='mini'>
                                        <input type="hidden" id="<?php echo 'API2'; ?>">
                                </td>
                                <?php } ?>
                                    <td><a class="pencil-square-o" title="Edit" href="<?php echo base_url().$this->config->item('admin_folder').'/user/mode/'.$user['id']?>"><i class="fa fa-pencil"></i></a> 
                                        <a href="javascript:;" title="Delete" class="btn btn-xs btn-danger" onclick="return delete_rec('<?php echo $user['id']?>','<?php echo $del_url; ?>');"><i class="fa fa-times"></i></a>
                                        <a href="<?php echo base_url().$this->config->item('admin_folder').'/user/as_user/'.$user['id']?>" ><span class="btn btn-default">Panel </span> </a>
                                    </td>
                            </tr>  
                            <?php $cnt++; } ?>  
                    </tbody>
                     
                    <!--<tfoot>
                     <tr>
                        <th>SR NO. </th>
                        <th>NAME</th>
                        <th>Email</th>
                        <th>MOBILE NO.</th>
                        <th>ACTIVE/INACTIVE</th>
                        <th>OPTION</th>
                      </tr>
                    </tfoot> -->

                    </table>
                            <div class="col-xs-2"> 
                            <select id="mul_val" name="mul_val" class="form-control" width="5%">
                            <option value="">Select Action</option>
                            <option value="Delete" id="sel_del_rec" >Delete</option>
                            <option value="Active" id="sel_ac_rec" >Active</option>
                            <option value="Inactive" id="sel_inac_rec" >Inactive</option>
                            </select>
                            </div>   
                    <div id="show">
                        <input type="submit" class="btn btn-primary" id="action_submit" name="mul_sub" value="submit" style="display: none">
                    </div>
                    </form>
                        <?php } ?>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
      
    

     
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
     
    </div><!-- ./wrapper -->
    <div class="control-sidebar-bg"></div>
    
    <?php include('footer.php'); ?>
    <script src="<?php echo base_url()?>admin_assets/js/user.js"></script>
    <script src="<?php echo base_url()?>admin_assets/js/send_sms.js"></script>
    </body>
</html>