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
                        <li><a href="<?php echo base_url().$this->config->item('admin_folder').'/Teacher'?>">teacher</a></li>
                        <li class="active"><?php echo $page_title ?></li>
                    </ol>
                </section>
            <section class="content">
            <div class="box box-primary">
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
                        <form role="form" method="POST" enctype="multipart/form-data" action="<?php echo $mode; ?>">                              
                            <div class="col-md-3">
                                 <label>Name <span class="has-error">*</span></label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" class="form-control" name="name" id="name" required="required" placeholder="Enter name" value="<?php  if(isset($data['name'])){echo $data['name']; }else{echo set_value('name'); }?>">
                                <input type="hidden" name="data_id" id="data_id" value="<?php if(isset($data['id'])) { echo $data['id']; } ?>">
                                <input type="hidden" name="login_id" id="login_id" value="<?php if(isset($data['login_id'])) { echo $data['login_id']; } ?>">
                            </div>
                            
                            
                            <!--<div class="col-md-3">
                                <label>Employ id <span class="has-error">*</span></label>
                            </div>
                            <div class="col-md-9 form-group">
                                <select name="employ_id" class="form-control" id="employ_id">
                                <option value="" <?php if(isset($data['id'])){?> disabled='' <?php } ?> > Select </option>
                                <?php foreach($employ_id as $e_list): ?>
                                <option value="<?php echo $e_list['id']; ?>" <?php if(isset($data['employ_id'])){ if($e_list['id'] == $data['employ_id']){ ?> selected <?php } } ?>  ><?php echo $e_list['id']; ?></option>
                                <?php endforeach; ?> 
                                </select>
                            </div>-->
                            
                            <div class="col-md-3">
                                <label>Employ id <span class="has-error">*</span></label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" class="form-control" name="employ_id" id="employ_id"   placeholder="Employ id" value="<?php  if(isset($data['employ_id']) != null){echo $data['employ_id']; } else {echo set_value('employ_id'); }?>"  >
                            </div>
                                                        
                            <div class="col-md-3">
                                <label>Email address <span class="has-error"></span></label>
                            </div>
                            <div class="col-md-9 form-group">
                                    <input type="email" class="form-control" name="email" id="email" required="required"   placeholder="Enter email" value="<?php  if(isset($data['email']) != null){ echo $data['email']; } else {echo set_value('email'); }?>" <?php echo $data['email']!=""?"readonly":""?> >
                            </div>
                            
                            <div class="col-md-3">
                                <label>Mobile no <span class="has-error">*</span></label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="number" class="form-control" name="mobile_no" required="required" id="mobile_no" maxlength="10" placeholder="Enter Mobile number" value="<?php  if(isset($data['mobile_no']) != null){echo $data['mobile_no']; } else { echo set_value('mobile_no'); }?>">
                            </div>
                        <?php if($login_type!='teacher') { 
                         if($data['id']!="") {
                         ?>

                        <div class="col-md-3">
                                <label>Assign Class <span class="has-error">*</span></label>
                        </div>
                         <div class="col-md-9 form-group">
                          <select name="class_id[]" class="selectpicker form-control" multiple>
                         <?php $class_detail=get_total_class_list_by_user_id(explode(',',$data['class_id']), CLASSES); 
                         foreach($class_detail as $value) :  ?>  
                        <option value="<?php echo $value['id'] ?>" selected="selected"><?php echo $value['name'] ?></option>
                        <?php endforeach;?>
                         </select>
                          </div>
                         <?php } ?> 
                            <div class="col-md-3">
                                <label>Password <span class="has-error">*</span></label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="password" class="form-control" name="password" id="password"  placeholder="Enter Password" <?php if($data['id']!="") { } else { echo "required"; }?>>
                            </div>
                      <?php } ?>
                            <div class="col-md-3">
                                <label>Status <span class="has-error">*</span></label>
                            </div>
                            <div class="col-md-9 form-group">
                                <select name="status" required="required" class="form-control" id="status">
                                    <option value="" <?php if(isset($data['id'])){?> disabled='' <?php } ?>> Select </option>
                                    <?php foreach($status as $key=>$value): ?>
                                    <option value="<?php echo $value; ?>" <?php if(isset($data['status'])){if($value == $data['status']){ ?> selected <?php } } ?>  ><?php echo $value; ?></option>
                                    <?php endforeach; ?> 
                                </select>
                            </div>
                            
                            <div class="col-md-3"></div>
                            <div class="col-md-9 form-group">
                                <button type="submit" name="submit" id="submit" class="btn btn-primary">&nbsp; Save &nbsp;</button>
                                <button type="button" name="back" id="back" onclick='window.location.href="<?php echo base_url().$this->config->item('admin_folder').'/teacher'?>"' class="btn btn-box">&nbsp; Back &nbsp;</button>
                            </div>
                        </form>
                        </div>
                </div><!-- /.col-->
               <?php if($login_type!='teacher') { ?>
                <div class="col-md-3">
                    <div class="btn-group pull-right box-header">
                        <a class="btn btn-default" href="<?php echo base_url().$this->config->item('admin_folder')?>/teacher">Manage Teacher</a>
                    </div> 
                </div>
               <?php } ?>
            </div><!-- ./row -->
             </div><!-- /.box -->
    </section><!-- /.content -->
                
            </div> 
    </div><!-- ./wrapper -->
    <?php include('footer.php')?>

</body>
</html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css"> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>


