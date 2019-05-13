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
                    <h1><?php echo $page_title; ?></h1>
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
                        <li><a href="<?php echo ADMIN_URL.'/dashboard'; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo ADMIN_URL.'/site/mode'?>">Manage Site Setting</a></li>
                        <li class="active"><?php echo $page_title; ?></li>
                    </ol>
                </section>
            <section class="content">
            <div class="box box-primary">
            <div class="row">
            <!-- left column -->
            <div class="col-md-4"> </div>
                <div class="col-md-4">
                    <?php if($val_error != "") { ?>
                    <div class="col-md-3"></div><label class="col-md-9 has-error"><?php echo $val_error; ?></label>
                    <?php } ?>
                        <!-- /.box-header -->
                                 <!-- form start -->
                                <!--<form role="form" method="POST" enctype="multipart/form-data" action="<?php echo base_url().$this->config->item('admin_folder')?>/profile/edit">-->
                                 <?php echo form_open_multipart('admin/site/mode');?>
                                <div class="box-body">
                                    <div class="col-md-3">
                                        <label>Name <span class="has-error">*</span></label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter site name" value="<?php  if(set_value('first_name') == null){echo (!empty($site_data))?$site_data['name']:''; }else{echo set_value('name'); }?>">
                                        <input type="hidden" name="s_id" id="id" value="<?php echo $site_data['id']; ?>">
                                    </div>
                                        
                                    <div class="col-md-3">
                                        <label>URL <span class="has-error">*</span></label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                        <input type="text" class="form-control" name="url" id="url" placeholder="Enter site url" value="<?php  if(set_value('url') == null){echo (!empty($site_data))?$site_data['url']:''; }else{echo set_value('url'); }?>">
                                    </div>  
                                    
                                    <div class="col-md-3">
                                        <label>Phone no <span class="has-error">*</span></label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                        <input type="text" class="form-control" name="mobile_no" id="mobile_no" maxlength="10" placeholder="Phone number" value="<?php  if(set_value('mobile_no') == null){echo (!empty($site_data))?$site_data['mobile_no']:''; } else {echo set_value('mobile_no'); }?>">
                                    </div>    
                                    
                                    <div class="col-md-3">
                                        <label>Logo </label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                        <div class="fileupload-preview thumbnail" style="width: 100px; height: 100px; line-height: 150px;">
                                            <!--  <img id="blah" src="../../admin_assets/img/NoImageAvailable.png"  />-->
                                                <?php
                                                if($site_data['photo'] == ''){
                                                    $image = base_url().'admin_assets/img/NoImageAvailable.png';
                                                } else {
                                                    $image = base_url().LOGO_IMAGE.$site_data['photo'];
                                                }
                                                echo '<img id="blah" src="'.$image.'" style="width: 100px; height: 90px; line-height: 90px;">';
                                                ?>
                                        </div>
                                        <span class="btn btn-default btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists"></span>   
                                        <input type="file" name="photo" id="photo" onchange="readURL(this)";>
                                        <input type="hidden" name="hidphoto" id="hidphoto" value="<?php echo $site_data['photo']?>">
                                    </div>    
                                    
                                    <div class="col-md-3">
                                        <label>Banner</label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                        <div class="fileupload-preview thumbnail" style="width: 100px; height: 100px; line-height: 150px;">
                                                <?php
                                                if($site_data['banner'] == ''){
                                                    $image = base_url().'admin_assets/img/NoImageAvailable.png';
                                                } else {
                                                    $image = base_url().BANNER_IMAGE.$site_data['banner'];
                                                }
                                                echo '<img id="blahh" src="'.$image.'" style="width: 100px; height: 90px; line-height: 90px;">';
                                                ?>
                                        </div>
                                        <span class="btn btn-default btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists"></span>   
                                        <input type="file" name="banner" id="banner" onchange="readURLL(this)";>
                                        <input type="hidden" name="hidphotoo" id="hidphotoo" value="<?php echo $site_data['banner']?>">
                                    </div>    
                                    
                                    <div class="col-md-3">
                                        <label>Address <span class="has-error">*</span></label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                        <textarea class="form-control" name="address" id="address" placeholder="Enter Address" ><?php echo $site_data['address']; ?></textarea>
                                    </div>    
                                        
                                </div><!-- /.box-body -->
                                <div class="col-md-3"></div>    
                                <div class="col-md-9">
                                    <button type="submit" name="submit" id="submit" class="btn btn-primary">&nbsp; Edit &nbsp;</button>
                                </div>
                          <?php echo form_close(); ?>
            </div>
            <div class="col-md-4"></div>
        </div> 
    </div>
    </section>
        </div> 
    </div><!-- ./wrapper -->

   <?php include('footer.php')?>
    <script src="<?php echo base_url()?>admin_assets/js/site_setting.js"></script>
</body>