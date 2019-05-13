<?php include('header.php');?>
<style> .has-error { color: red; } </style>

    <?php $admin=$this->session->userdata();
            $logint_type=$admin['logint_type'];
		
    if(empty($user['id'])){
		?> 
        <body class="hold-transition skin-blue sidebar-mini">
    <?php } else { ?>
        <body class="hold-transition skin-blue sidebar-mini" onload="selectstate(); selectcity();">
    <?php } ?>    
        <?php include('header_menu.php'); ?>
            <!-- Left side column. contains the logo and sidebar -->
            <?php include('aside.php')?>
    <div class="wrapper">
        <div class="content-wrapper">
            <section class="content-header">
                <h1 class="box-title"><?php echo $page_title; ?></h1>
                <ol class="breadcrumb">
                        <li><a href="<?php echo base_url().$this->config->item('admin_folder').'/dashboard'?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo base_url().$this->config->item('admin_folder').'/user'?>">User</a></li>
                        <li class="active"><?php echo $page_title; ?></li>
                </ol>
            </section>
                <div id="div_msg"> 
                        <?php include('flashmessage.php'); ?>
                </div>
            <section class="content">
                <div class="box box-primary">
                <div class="row">
                <!-- left column -->
                <div class="col-md-3"></div>
                    <div class="col-md-6">
                            <div class="box-header ">
                                <div class="col-md-4"></div>
                                <label class="col-md-8"><span class="has-error"> 
                                <?php echo $val_error;  ?></span></label>
                                <span class="has-error"><?php echo $this->session->flashdata('error_msg'); ?></span> 
                            </div><!-- /.box-header -->
                            <!-- form start -->
                            <form role="form" method="POST" enctype="multipart/form-data" action="<?php echo $mode; ?>">
                            <div class="box-body">
                                
                                <?php if($check=='add') { ?>
                                <div class="col-md-4">
                                    <label>Type of Institution <span class="has-error">*</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <select name="institution" class="form-control" id="identity">
                                    <option value="" <?php if(isset($user['id'])){?> disabled='' <?php } ?>> Select </option>
                                    <?php foreach($institution as $identityy): ?>
                                    <option value="<?php echo $identityy['name']; ?>" <?php if(isset($user['institution'])){if($identityy['name'] == $user['institution']){ ?> selected <?php } } ?>  ><?php echo $identityy['name']; ?></option>
                                    <?php endforeach; ?> 
                                    </select>
                                </div>
                                <?php } else { ?>
                                <div class="col-md-4">
                                    <label>Type of Inst.<span class="has-error">*</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    
                                    <?php echo  "<b>".$user['institution']."</b>"; ?>
                                </div>
                                <?php } ?>
                                <div class="col-md-4">
                                    <label>School name<span class="has-error">*</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" class="form-control" name="school_name" id="school_name"  placeholder="Name of School" value="<?php  if(isset($user['school_name']) != null){echo $user['school_name']; }else{echo set_value('school_name'); }?>">
                                </div>
                                
                                <div class="col-md-4">
                                     <label>Username <span class="has-error">*</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" class="form-control" name="name" id="name"  placeholder="name" value="<?php if(isset($user['name'])){echo $user['name']; } else {echo set_value('name');}?>"> 
                                    <input type="hidden" name="user_id" id="user_id" value="<?php  if(isset($user['id'])){ echo $user['id']; }else{echo set_value('user_id'); }?>">
                                    <span class="has-error"><?php echo $this->session->flashdata('check_fname'); ?></span>
                                </div>
                                
                                <div class="col-md-4">
                                    <label>Email address <?php if($check=='add'){ echo '<span class="has-error">*</span>'; }?></label>
                                </div>
                                <div class="col-md-8 form-group">
                                        <?php if($check == 'edit'){ echo '<b>'.$user['email']."</b>"; ?>
                                        <input type="hidden" class="form-control" name="email" id="email"   placeholder="Enter email" value="<?php  if(isset($user['email']) != null){echo $user['email']; } else {echo set_value('email'); }?>"  >
                                        <?php   } else  { ?>
                                        <input type="text" class="form-control" name="email" id="email"   placeholder="Enter email" value="<?php  if(isset($user['email']) != null){echo $user['email']; } else {echo set_value('email'); }?>"  >
                                        <?php } ?>
                                        <div class="has-error" id="act_msg"></div>
                                </div>
                                
                                    
                                <div class="col-md-4">
                                    <label>Password <?php if($check =='edit'){ echo ":"; } else {  echo  "<span class='has-error'>*</span>"; } ?></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="password" class="form-control" name="password" id="password"  placeholder="Password" >
                                    <div class="has-error" id="pass_msg"><?php if($check=='edit') { echo "Change Password"; } ?></div>
                                </div>
                             
                                <div class="col-md-4">
                                     <label>Profile Image :</label>
                                </div>
                                <div class="col-md-8 form-group">
                                        <div class="fileupload-preview thumbnail" style="width: 100px; height: 100px; line-height: 100px;">
                                        <!-- <img id="blah" src="../../admin_assets/img/NoImageAvailable.png"  />-->
                                                <?php
                                                if(isset($user['photo']))
                                                {
                                                    if($user['photo']=='')
                                                    {   $image = base_url().'admin_assets/img/NoImageAvailable.png';    }
                                                    else
                                                    { $image = base_url().'upload/user_image/'.$user['photo']; }
                                                }
                                                else {
                                                    $image = base_url().'admin_assets/img/NoImageAvailable.png';
                                                }
                                                
                                                echo '<img id="blah" src="'.$image.'" style="width: 100px; height: 90px; line-height: 90px;">';
                                            ?>
                                        </div>
                                        <span class="btn btn-default btn-file"><span class="fileupload-new">Select image </span><span class="fileupload-exists"></span>   
                                        <input type="file" name="photo" id="photo" onchange="readURL(this);">
                                        <input type="hidden" name="hidphoto" id="hidphoto" value="<?php if(isset($user['photo'])) { echo $user['photo'] ; } else { echo set_value('hidphoto');}?>">
                                </div>
                                
                                <div class="col-md-4">
                                        <label>Banner</label>
                                    </div>
                                <div class="col-md-8 form-group">
                                        <div class="fileupload-preview thumbnail" style="width: 100px; height: 100px; line-height: 150px;">
                                                <?php
                                                if(isset($user['photo']))
                                                {
                                                if($user['banner'] == ''){
                                                    $image = base_url().'admin_assets/img/NoImageAvailable.png';
                                                } else {
                                                    $image = base_url().USER_IMAGES.$user['banner'];
                                                } }
                                                else {
                                                    $image = base_url().'admin_assets/img/NoImageAvailable.png';
                                                }
                                                echo '<img id="blahh" src="'.$image.'" style="width: 100px; height: 90px; line-height: 90px;">';
                                                ?>
                                        </div>
                                        <span class="btn btn-default btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists"></span>   
                                        <input type="file" name="banner" id="banner" onchange="readURLL(this)";>
                                        <input type="hidden" name="banner_hidphotoo" id="hidphotoo" value="<?php if(isset($user['banner'])) { echo $user['banner'] ; } else { echo set_value('banner_hidphotoo');}?>">
                                </div>                                                                          
                                
                                <div class="col-md-4">
                                    <label>Mobile no <span class="has-error">*</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" class="form-control" name="contact" id="contact" maxlength="10" placeholder="Mobile number" value="<?php  if(isset($user['contact']) != null){echo $user['contact']; }else{echo set_value('contact'); }?>">
                                    <span class="has-error"><?php echo $this->session->flashdata('check_contact'); ?></span>
                                </div>
                                
                                
                                
                               <!-- <?php if($check=='add') {?>
                                <div class="col-md-4">
                                    <label>API Name </label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <select name="api_name" class="form-control" id="api_name">
                                    <option value="" <?php if(isset($data['id'])){?> disabled='' <?php } ?>> Select </option>
                                    <?php foreach($api_data as $api): ?>
                                    <option value="<?php echo $api['id']; ?>" ><?php echo $api['api_name']."  -  SMS : ". $api['api_msg']; ?></option>
                                    <?php endforeach; ?> 
                                    </select>
                                </div>
                                
                                 <div class="col-md-4">
                                <label>Alot sms </label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text" name="alot_sms" id="alot_sms" class="form-control">
                                    </div>
                                <?php } ?> -->
                                <div class="col-md-4">
                                    <label>Landline no : </label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" class="form-control" name="landline_contact" id="landline_contact"  placeholder="landline number" value="<?php  if(isset($user['landline_contact']) != null){echo $user['landline_contact']; }else{echo set_value('landline_contact'); }?>">
                                </div>
                                
                                <div class="col-md-4">
                                   <label>Country <span class="has-error">*</span> </label>
                                </div>
                                <div class="col-md-8 form-group">
                                        <select name="country" class="form-control"   id="old_country"  onChange="getstatedetails(this.value)">
                                            <option value="" <?php if(isset($user['id'])){?> disabled='' <?php } ?> >Select Country</option>
                                        <?php foreach($country as $count): ?>
                                            <option value="<?php echo $count['iso']; ?>"  <?php if(isset($user['country'])){ if($count['iso']==$user['country']){?>selected<?php } } ?> ><?php echo $count['country_name']; ?></option>
                                            <?php endforeach; ?> 
                                        </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <input type="hidden" name="state" id="state"  value="<?php  if(empty($user['id'])){  }else { echo $user['state']; }?>" >
                                    <label>State <span class="has-error">*</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <select name="state" class="form-control"  id="get_state" >
                                    <option value="" >Select State</option>
                                    </select>
                                </div>
                                
                                        <!--<div class="form-group" id="get_city">
                                            <input type="hidden" name="city" id="city" value="<?php  if(empty($user['id'])){  }else { echo $user['city']; }?>">
                                            <label>City <span class="has-error">*</span></label>
                                            <select name="city" class="form-control"  id="old_city" onload="selectstate(this.value)">
                                                <option value="" label="city">Select City</option>
                                            </select>
                                        </div> -->
                                
                                <div class="col-md-4">
                                    <label>City <span class="has-error">*</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" class="form-control" name="city" id="city" placeholder="city" value="<?php  if(isset($user['city'])){echo $user['city']; }else{echo set_value('city'); }?>">
                                </div>
                                <div class="col-md-4">
                                <label>Language Option <span class="has-error">*</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                        <select name="language_option" class="form-control" id="status">
                                        <option value="" <?php if(isset($data['id'])){?> disabled='' <?php } ?>> Select </option>
                                        <?php 
										foreach($language as $key=>$value): ?>
                                        <option value="<?php echo $key; ?>" <?php if(isset($user['language_option'])){if($key == $user['language_option']){ ?> selected <?php } } ?>  ><?php echo $value; ?></option>
                                        <?php endforeach; ?> 
                                        </select>
										<div style="color:red; font-size:10px">Active for Hindi,English and Inactive for English</div>
                                </div> 
                                <div class="col-md-4">
                                <label>Status <span class="has-error">*</span></label>
                                </div>
                                <div class="col-md-8 form-group">
                                        <select name="status" class="form-control" id="status">
                                        <option value="" <?php if(isset($data['id'])){?> disabled='' <?php } ?>> Select </option>
                                        <?php foreach($status as $key=>$value): ?>
                                        <option value="<?php echo $value; ?>" <?php if(isset($user['status'])){if($value == $user['status']){ ?> selected <?php } } ?>  ><?php echo $value; ?></option>
                                        <?php endforeach; ?> 
                                        </select>
                                </div>
								
                                <div class="col-md-4"></div>   
                                <div class="col-md-8 form-group">
                                    <button type="submit" name="submit" id="submit" class="btn btn-primary">&nbsp; Save &nbsp;</button>
                                    <button type="button" name="back" id="back" onclick='window.location.href="<?php echo base_url().$this->config->item('admin_folder').'/user'?>"' class="btn btn-box">&nbsp; Back &nbsp;</button>
                                </div>
                                </div><!-- /.box-body -->
                            </form>
                    </div>
                <div class="col-md-3">
                    <?php if($logint_type=='admin') {?>
                    <div class="btn-group pull-right box-header">
                        <a class="btn btn-default" href="<?php echo base_url().$this->config->item('admin_folder')?>/user">Manage Users</a>
                    </div>
                    <?php } ?>
                </div>
                </div> 
                 </div>
            </section>
        </div>
    </div>
<?php include('footer.php');?>
<script src="<?php echo base_url()?>admin_assets/js/user_form.js"></script>
</body> 
</html>