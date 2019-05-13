<?php include('header.php') ?>
<style> .has-error { color: red; } </style>

<?php if(empty($data['id'])){?>  
<body class="hold-transition skin-blue sidebar-mini">
<?php } else {?>
<body class="hold-transition skin-blue sidebar-mini" onload="selectedgrp('<?php echo $grp_info['group_type'];?>','<?php echo $data['id'];?>'); getstudentclasslist('<?php echo $grp_info['class_id'];?>','<?php echo $data['id'];?>');" >
<?php } ?>    
    
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
                        <li><a href="<?php echo base_url().$this->config->item('admin_folder').'/group'?>">group</a></li>
                        <li class="active"><?php echo $page_title ?></li>
                    </ol>
                </section>
            <section class="content">
            <div class="box box-primary">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
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
                                <input type="text" class="form-control" name="name" id="name"  placeholder="Enter name" value="<?php  if(isset($data['name'])){echo $data['name']; }else{echo set_value('name'); }?>">
                                <input type="hidden" name="data_id" id="data_id" value="<?php if(isset($data['id'])) { echo $data['id']; } ?>">
                                <input type="hidden" name="grp_member" id="grp_member" value="<?php if(isset($grp_info['group_type'])) { echo $grp_info['group_type']; }  ?>">
                                <input type="hidden" name="grp_class_id" id="grp_class_id" value="<?php if(isset($grp_info['class_id'])) { echo $grp_info['class_id']; }  ?>">
                            </div>
                             
                           
                          
                            <div class="col-md-3">
                                <label>Status <span class="has-error">*</span></label>
                            </div>
                            <div class="col-md-9 form-group">
                                <select name="status" class="form-control" id="status">
                                <option value="" <?php if(isset($data['id'])){?> disabled='' <?php } ?> > Select </option>
                                <?php foreach($status as $key=>$value): ?>
                                    <option value="<?php echo $value; ?>" <?php if(isset($data['status'])){if($value == $data['status']){ ?> selected <?php } } ?>  ><?php echo $value; ?></option>
                                <?php endforeach; ?> 
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label>Select Member </label>
                            </div>
                            <div class="col-md-9 form-group">
                                <select name="select_member" class="form-control" id="select_member" >
                                    <option value="-1" <?php if(isset($data['id'])){?> disabled='' <?php } ?>> Select</option>
                                    <option value="student" <?php if(isset($grp_info['group_type'])) { if($grp_info['group_type']=='student'){ ?> selected="selected" <?php  } }  ?> > Student</option>
                                    <option value="teacher" <?php if(isset($grp_info['group_type'])) { if($grp_info['group_type']=='teacher'){ ?> selected="selected" <?php  } }  ?> > Teacher</option>
                                    <!--<option value="staff"> Staff </option>-->
                                </select>
                            </div>
                            
                            
                            <div id="student_list_select"></div>
                            <div id="student_list"> </div>
                            <div id="datalist"></div> 
                            
                           <!-- <div class="col-md-3">
                                    <label>Select Member </label>
                            </div>
                            <div class="col-md-9" form-group>
                                <div id="member_list"> </div>
                            </div> -->
                          
                           <!-- <div class="col-md-3">
                                <label>Select Student <span class="has-error">*</span></label>
                            </div>
                            <div class="col-md-9 form-group">
                                <?php if(!empty($student_data)) {?>
                                <?php $cnt=0;
                                foreach($student_data as $s_list): ?>
                                <input type="checkbox" name="students[]" value="<?php echo $s_list['id'] ?>" <?php if(isset($student_grp[$cnt]['member_id'])) { if($s_list['id'] == $student_grp[$cnt]['member_id']){ echo "checked"; }  }  ?>  > <?php echo $s_list['name'] ?> &nbsp; &nbsp; 
                                <?php $cnt++; endforeach; } else { echo "<b>You have not add any Student</b>"; } ?>  
                            </div>
                            
                            <div class="col-md-3">
                                <label>Select Teacher <span class="has-error">*</span></label>
                            </div>
                            <div class="col-md-9 form-group">
                                <?php if(!empty($teacher_data)) {?>
                                <?php $cnt=0; foreach($teacher_data as $t_list): ?>
                                <input type="checkbox" name="teacher[]" value="<?php echo $t_list['employ_id'] ?>"  <?php if(isset($teacher_grp[$cnt]['member_id'])) { if($t_list['employ_id'] == $teacher_grp[$cnt]['member_id']){ echo "checked=checked"; }  }  ?>   > <?php echo $t_list['name'] ?> &nbsp; &nbsp; 
                                <?php $cnt++; endforeach; } else { echo "You have not add any Teacher"; } ?> 
                            </div>  -->
                            
                            <!--<div class="col-md-3">
                                <label>Select Members : <span class="has-error">*</span></label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="checkbox" name="group" value="group"> Student
                            </div>-->
                            
                            <div class="col-md-3"></div>
                            <div class="col-md-9 form-group">
                                <button type="submit" name="submit" id="submit" class="btn btn-primary">&nbsp; Save &nbsp;</button>
                                <button type="button" name="back" id="back" onclick='window.location.href="<?php echo base_url().$this->config->item('admin_folder').'/group'?>"' class="btn btn-box">&nbsp; Back &nbsp;</button>
                            </div>
                        </form>
                        </div>
                </div><!-- /.col-->
                <div class="col-md-2">
                    <div class="btn-group pull-right box-header">
                        <a class="btn btn-default" href="<?php echo base_url().$this->config->item('admin_folder')?>/group">Manage Group</a>
                    </div> 
                </div>
            </div><!-- ./row -->
             </div><!-- /.box -->
    </section><!-- /.content -->
                
    </div> 
    </div><!-- ./wrapper -->
    <?php include('footer.php')?>
  <script src="<?php echo base_url()?>admin_assets/js/group_form.js"> </script>
  <script src="<?php echo base_url()?>admin_assets/js/data.js"> </script>
</body>
</html>