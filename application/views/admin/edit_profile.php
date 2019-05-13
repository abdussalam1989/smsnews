<?php include('header.php');?>
<style> .has-error { color: red; } </style>

        <?php if(empty($admin_details['id'])){?> 
            <body class="hold-transition skin-blue sidebar-mini">
        <?php } else { ?>
            <body class="hold-transition skin-blue sidebar-mini" onload="selectstate(); selectcity();">
        <?php } ?>    

    <div class="wrapper">
            <?php include('header_menu.php');?>
            <!-- Left side column. contains the logo and sidebar -->
            <?php include('aside.php')?>
            
            <div class="content-wrapper">
                    <section class="content-header">
                        <h1><?php echo $page_title;?></h1>
                        <div id="act_msg"> </div >
                        <div id="div_msg">
                          <?php include('flashmessage.php'); ?>

                          <?php if( validation_errors() != null) { ?>
                                  <div class="alert alert-danger">
                                  <?php echo validation_errors(); ?>
                                  </div>
                          <?php } if(isset($custom_error) || $custom_error != null ) { ?>
                                  <div class="alert alert-danger">
                                  <?php echo $custom_error; ?>
                                  </div>
                          <?php } ?>
                      </div>
                        <ol class="breadcrumb">
                        <li><a href="<?php echo ADMIN_URL.'/dashboard'?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo ADMIN_URL.'/profile/edit'?>">Setting</a></li>
                        <li class="active"><?php echo $page_title;?></li>
                        </ol>
                    </section>
                
                  <!-- Content Header (Page header) -->
                 
        <section class="content">
            <div class="box box-primary">
            <div class="row">
            <!-- left column -->
            <div class="col-md-3"></div>
                <div class="col-md-6">
                        <div class="box-header">
                            <span class="has-error"><?php echo $val_error;  ?></span>
                        </div>
                                <!-- form start -->
                                <!--<form role="form" method="POST" enctype="multipart/form-data" action="<?php echo base_url().$this->config->item('admin_folder')?>/profile/edit">-->
                                <?php echo form_open_multipart('admin/profile/edit');?>
                                <div class="box-body">                        
                                    <div class="col-md-3">
                                         <label>First Name <span class="has-error">*</span></label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First name" value="<?php  if(set_value('first_name') == null){echo (!empty($admin_details))?$admin_details['first_name']:''; }else{echo set_value('first_name'); }?>">
                                        <input type="hidden" id="get_id" value="<?php echo $admin_details['id']; ?> ">
                                    </div>
                                    
                                    <div class="col-md-3">
                                         <label>Last Name <span class="has-error">*</span></label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last name" value="<?php  if(set_value('last_name') == null){echo (!empty($admin_details))?$admin_details['last_name']:''; }else{echo set_value('last_name'); }?>">
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label>Username <span class="has-error">*</span></label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                        <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php  if(set_value('username') == null){echo (!empty($admin_details))?$admin_details['username']:''; }else{echo set_value('username'); }?>">
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label>Email address <span class="has-error">*</span></label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                        <input type="text" class="form-control" name="email_id" id="email_id" placeholder="Enter email"  value="<?php  if(set_value('email_id') == null){echo (!empty($admin_details))?$admin_details['email_id']:''; }else{echo set_value('email_id'); }?>" onchange="check_email()">
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label>Address <span class="has-error">*</span></label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                        <textarea name="address" class="form-control"><?php  if(set_value('address') == null){echo (!empty($admin_details))?$admin_details['address']:''; }else{echo set_value('address'); }?></textarea>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label>Country <span class="has-error">*</span></label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                        <select name="country" class="form-control"  id="old_country"  onChange="getstatedetails(this.value)">
                                            <option value="-1"  >Select Country</option>
                                            <?php foreach($country as $count): ?>
                                               <option value="<?php echo $count['iso']; ?>" <?php if($count['iso']==$admin_details['country']){?>selected<?php } ?>><?php echo $count['country_name']; ?></option>
                                            <?php endforeach; ?> 
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <input type="hidden" name="state" id="state"  value="<?php  if(empty($admin_details['id'])){  }else { echo $admin_details['state']; }?>" >
                                        <label>State <span class="has-error">*</span></label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                            <select name="state" class="form-control" required="required" id="get_state"  >
                                                <option value="" >Select State</option>
                                            </select>
                                    </div>
                                    
                                     <!-- <div class="form-group" id="get_city">
                                        <input type="hidden" name="city" id="city" value="<?php  if(empty($admin_details['id'])){  }else { echo $admin_details['city']; }?>">
                                        <label>City</label>
                                        <select name="city" class="form-control" required="required" id="old_city" onload="selectstate(this.value)">
                                            <option value="1" label="city">Select City</option>
                                        </select>
                                    </div>-->
                                    
                                    <div class="col-md-3">
                                         <label>City <span class="has-error">*</span></label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                            <input type="text" class="form-control" name="city" maxlength="10" id="city" placeholder="Phone number" value="<?php  if(set_value('city') == null){echo (!empty($admin_details))?$admin_details['city']:''; } else {echo set_value('city'); }?>">
                                    </div>
                                    
                                    <div class="col-md-3">
                                            <label>Phone no <span class="has-error">*</span></label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                        <input type="text" class="form-control" name="mobile_no"maxlength="10" id="mobile_no" placeholder="Phone number" value="<?php  if(set_value('mobile_no') == null){echo (!empty($admin_details))?$admin_details['mobile_no']:''; } else {echo set_value('mobile_no'); }?>">
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label>Profile Image </label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                         <?php if($admin_details['photo'] != 'default.jpg') { ?>
                                        <div> <a href="javascript:void(0)" id="del_img">Remove image</a></div> 
                                        <?php } ?>
                                        <div class="fileupload-preview thumbnail" style="width: 100px; height: 100px; line-height: 150px;">
                                         <!--  <img id="blah" src="../../admin_assets/img/NoImageAvailable.png"  />-->
                                        <?php
                                                if($admin_details['photo'] == ''){
                                                    $image=base_url().'admin_assets/img/NoImageAvailable.png';
                                                } else {
                                                    $image=base_url().'upload/admin_image/'.$admin_details['photo'];
                                                }
                                                echo '<img id="blah" src="'.$image.'" style="width: 100px; height: 90px; line-height: 90px;">';
                                        ?>      
                                    </div>
                                        <span class="btn btn-default btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists"></span>   
                                        <input type="file" name="photo" id="photo" onchange="readURL(this)">
                                        <input type="hidden" name="hidphoto" id="hidphoto" value="<?php echo $admin_details['photo']?>">
                                    </div>
                                     <div class="col-md-3"></div>     
                                <div class="col-md-9 form-group">
                                    <button type="submit" name="submit" id="submit" class="btn btn-primary">&nbsp; Save &nbsp;</button>
                                </div>
                                </div><!-- /.box-body -->
                          <?php echo form_close(); ?>
                </div>
                <div class="col-md-3"> </div>
        <!-- include('change_passwd.php'); -->
        </div> 
        </div>
        </section>
        </div>
    </div>
<?php include('footer.php');?>
<script src="<?php echo base_url()?>admin_assets/js/edit_profile.js"></script>
</body>  