<?php include('header.php') ?>
<style> .has-error { color: red; } </style>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
            <?php include('header_menu.php');?>
            <!-- Left side column. contains the logo and sidebar -->
            <?php include('aside.php')?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1 class="box-title"><?php echo $page_title ?></h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url().$this->config->item('admin_folder').'/dashboard'?>"><i class="fa fa-dashboard"></i> Home</a></li>
                            <li><a href="<?php echo base_url().$this->config->item('admin_folder').'/Contact'?>">Account Manager</a></li>
                            	<li class="active"><?php echo $page_title ?></li>
                    </ol>
                </section>
                
        <section class="content">
            <div class=" box box-primary">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                            <div class="box-header">
                                <div class="col-md-3"></div>
                                <label class="col-md-9"><span class="has-error"> 
                                <?php echo $val_error;  ?></span></label>
                                <span class="has-error"><?php echo $this->session->flashdata('error_msg'); ?></span>
                            </div>

                    <div class="box-body">
                        <form role="form" method="POST" enctype="multipart/form-data"  action="<?php echo $mode; ?>">           
                         
                            <div class="col-md-3">
                                <label>User<?php echo $required; ?></label>
                            </div>
                            <div class="col-md-9 form-group">
                                <?php if($check=='view') { $user=  get_list_by_id($list['user_id'], USERS);  ?> 
                                <input type="text" readonly="readonly" class="form-control" value="<?php echo $user['name']; ?>">
                                    <?php  } else { ?>
                                <?php if($check=='edit') { $user=  get_list_by_id($list['user_id'], USERS)  ?>
                                <input type="hidden" name="user_id" class="form-control" id="user_id" value="<?php echo $list['user_id']; ?>"> 
                                <input type="text"  class="form-control" id="" value="<?php echo $user['name'] ?>" readonly="readonly"> 
                                <?php  } else { ?>
                                <select name="user_id" class="form-control" id="user_id" >
                                <option value=""> Select </option>
                                <?php foreach($user_data as $user): ?>
                                <option value="<?php echo $user['id']; ?>" <?php if(isset($list['user_id'])){ if($user['id'] == $data['user_id']){ ?> selected <?php } } ?>  ><?php echo $user['name']; ?></option>
                                <?php endforeach; ?> 
                                </select>
                                <?php } } ?>
                            </div>
                            
                            <div class="col-md-3">
                                <label>Name <?php echo $required; ?></label>
                            </div>
                            <div class="col-md-9 form-group">
                               <?php if($check=='view') { ?>
                                <input type="text" readonly="readonly" class="form-control" value="<?php echo $list['name']; ?>">
                                 <?php  } else { ?>
                                <input type="text" class="form-control" name="name" id="name"  placeholder="Enter name" value="<?php  if(isset($list['name'])){echo $list['name']; }else{echo set_value('name'); }?>">
                                <input type="hidden" name="c_id" id="c_id" value="<?php if(isset($list['id'])) { echo $list['id']; } ?>">
                               <?php } ?>
                            </div>
                            
                            <div class="col-md-3">
                                <label>Email <?php echo $required; ?></label>
                            </div>
                            <div class="col-md-9 form-group">
                                <?php if($check=='view') {  ?> 
                                    <input type="text" readonly="readonly" class="form-control" value="<?php echo $list['email']; ?>">
                                <?php  } else {?>
                                <input type="text" class="form-control" name="email" id="email" placeholder="Enter email" value="<?php  if(isset($list['email'])){echo $list['email']; }else{echo set_value('email'); }?>"  >
                                    <?php } ?>
                            </div>
                            
                            <div class="col-md-3">
                                <label>Mobile No <?php echo $required; ?></label>
                            </div>
                            <div class="col-md-9 form-group">
                               <?php if($check=='view') {  ?> 
                                    <input type="text" readonly="readonly" class="form-control" value="<?php echo $list['phone']; ?>">
                                <?php  } else {?>
                                <input type="text" class="form-control" name="phone" id="phone" maxlength="10" placeholder="Enter mobile number" value="<?php  if(isset($list['phone'])){echo $list['phone']; }else{echo set_value('phone'); }?>"  >
                               <?php }?>
                            </div>
                            
                            <div class="col-md-3">
                                <label>Message <?php echo $required; ?></label>
                            </div>
                            <div class="col-md-9 form-group">
                                <?php if($check=='view') {  ?> 
                                <textarea class="form-control" readonly="readonly"><?php echo $list['message']; ?></textarea>
                                <?php  } else {?>
                                <textarea name="message" class="form-control" placeholder="Enter Your message" id="message"><?php  if(isset($list['message'])){echo $list['message']; }else{echo set_value('message'); }?></textarea>
                                 <?php }?>
                            </div>
                            
                            <!--  
                          <div class="col-md-3">
                                <label>Date & Time : </label> 
                            </div>
                            <div class="col-md-9 form-group">
                                <?php echo  $list['adddatetime']; ?>
                            </div>
                            
                            <div class="col-md-3">
                                <label> Ip Address :</label> 
                            </div>
                            <div class="col-md-9 form-group ">
                                <?php echo $list['ipaddress'];?>
                            </div>
                       
                            <div class="col-md-3">
                                <label>URL :</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <?php echo $list['url']; ?>
                            </div> 
                            
                            <div class="col-md-3">
                                <label>Follow Up date</label>
                            </div>
                            <div class="col-md-9  form-group">
                                <input type="text" class="form-control" name="followup_datetime" autocomplete="off" id="datepicker"  placeholder="follow up date" value="<?php if(isset($list['followup_datetime'])){echo $list['followup_datetime'];} else { echo set_value('followup_datetime');}?>">
                            </div>  
                            
                            <div class="col-md-3">
                                <label>Follow Up time</label>
                            </div>
                            <div class="col-md-9 bootstrap-timepicker form-group">
                                <input type="text" class="form-control timepicker " name="followup_time" id="followup_time"  placeholder="follow up time" value="<?php if(isset($list['followup_time'])){echo $list['followup_time'];} else { echo set_value('followup_time');}?>">
                            </div> 
                          
                            <div class="col-md-3">
                                <label>Message </label>
                            </div>
                            <div class="col-md-9 form-group">
                                <?php if($check=='edit') { ?>
                                <textarea name="follow_up_note" class="form-control " placeholder="Enter Your message" id="follow_up_note"><?php  if(isset($list['follow_up_note'])){echo $list['follow_up_note']; }else{echo set_value('follow_up_note'); }?></textarea>
                                <?php } else { echo $list['message']; } ?>
                            </div>
                            -->
                        <div class="col-md-3"></div>    
                        <div class="col-md-9">
                              <?php if($check=='edit' || $check=='add' ) { ?>
                              <button type="submit" name="submit" id="submit" class="btn btn-primary">&nbsp; Save &nbsp;</button>  <?php } ?>
                            <button type="button" name="back" id="back" onclick='window.location.href="<?php echo base_url().$this->config->item('admin_folder').'/contact'?>"' class="btn btn-box">&nbsp; Back &nbsp;</button>
                        </div>
                        </form>
                        </div>
                </div><!-- /.col-->
                <div class="col-md-3">
                    <div class="btn-group pull-right box-header">
                            <a class="btn btn-default" href="<?php echo base_url().$this->config->item('admin_folder')?>/contact">Manage Contact</a>
                    </div>  
                </div>
            </div><!-- ./row -->
            </div> <!-- box primary  -->    
        </section><!-- /.content -->
        </div> 
    </div><!-- ./wrapper -->
    <?php include('footer.php')?>
       
    
<script>
$(document).ready(function() {
    $("#datepicker").datepicker();
    
    
        //Timepicker
     $(".timepicker").timepicker({
         showInputs: false
     });
});
</script>
</body>