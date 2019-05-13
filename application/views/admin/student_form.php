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
                        <li><a href="<?php echo base_url().$this->config->item('admin_folder').'/student'?>">Student</a></li>
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
                                <label>Class name <span class="has-error">*</span></label>
                            </div>
                            <div class="col-md-9 form-group">
                                <select name="class_name" class="form-control" id="class_name" onChange="getrollno(this.value)">
                                    <option value="" <?php if(isset($data['id'])){ ?> disabled='' <?php } ?> > Select </option>
                                    <?php foreach($class_name as $c_list): ?>
                                        <option value="<?php echo $c_list['id']; ?>" <?php if(isset($data['class_name'])){if($c_list['name'] == $data['class_name']){ ?> selected <?php } } ?>  ><?php echo $c_list['name']; ?></option>
                                    <?php endforeach; ?> 
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label>Group name :</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <select name="group_id" class="form-control" id="group_id" >
                                <option value="-1"> Select </option>
                                <?php  foreach($group_name as $g_list): ?>
                                <option value="<?php echo $g_list['id']; ?>" <?php if(isset($data['group_id'])){if($g_list['id'] == $data['group_id']){ ?> selected <?php } } ?>  ><?php echo $g_list['name']; ?></option>
                                <?php endforeach; ?> 
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                 <label>Name <span class="has-error">*</span></label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" class="form-control" name="name" id="name"  placeholder="Enter name" value="<?php  if(isset($data['name'])){echo $data['name']; }else{echo set_value('name'); }?>">
                                <input type="hidden" name="data_id" id="data_id" value="<?php if(isset($data['id'])) { echo $data['id']; } ?>">
                            </div>
                            
                            <div class="col-md-3">
                                    <label>Email address </label>
                            </div>
                            <div class="col-md-9 form-group">
                                    <input type="text" class="form-control" name="email" id="email"   placeholder="Enter email" value="<?php  if(isset($data['email']) != null){echo $data['email']; } else {echo set_value('email'); }?>"  >
                            </div>
                            
                            <div class="col-md-3">
                                <label>Admission no<span class="has-error">*</span></label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" class="form-control" name="admission_no" id="admission_no"  placeholder="Admission number" value="<?php  if(isset($data['admission_no']) != null){echo $data['admission_no']; }else{echo set_value('admission_no'); }?>">
                            </div>
                            
                            <div class="col-md-3">
                                <label>Roll no</label>
                            </div>
                            <div class="col-md-9 form-group" id="roll_no">
                                <input type="text" class="form-control" name="roll_no" id=""  placeholder="Admission number" value="<?php  if(isset($data['roll_no']) != null){echo $data['roll_no']; }else{echo set_value('roll_no'); }?>">
                            </div>
                            
                            <div class="col-md-3">
                                    <label>Father name</label>
                            </div>
                            <div class="col-md-9 form-group">
                                    <input type="text" class="form-control" name="father_name" id="father_name"   placeholder="Father name" value="<?php  if(isset($data['father_name']) != null){echo $data['father_name']; } else {echo set_value('father_name'); }?>"  >
                            </div>
                            
                            <div class="col-md-3">
                                    <label>Mother name</label>
                            </div>
                            <div class="col-md-9 form-group">
                                    <input type="text" class="form-control" name="mother_name" id="mother_name"   placeholder="Mother name" value="<?php  if(isset($data['mother_name']) != null){echo $data['mother_name']; } else {echo set_value('mother_name'); }?>"  >
                            </div>
                            
                            <div class="col-md-3">
                                <label>Mobile no <span class="has-error">*</span></label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" class="form-control" name="mobile_no" id="mobile_no" maxlength="10" placeholder="Phone number" value="<?php  if(isset($data['mobile_no']) != null){echo $data['mobile_no']; }else{echo set_value('mobile_no'); }?>">
                            </div>
                            
                            <div class="col-md-3">
                                <label>Alternate no </label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" class="form-control" name="alternate_no" id="alternate_no"  placeholder="alternate number" value="<?php  if(isset($data['alternate_no']) != null){echo $data['alternate_no']; }else{echo set_value('alternate_no'); }?>">
                            </div>
                            
                            <div class="col-md-3">
                                <label>Date of Birth</label>
                            </div>
                            <div class="col-md-9  form-group">
                                <input type="text" class="form-control" name="date_of_birth" id="datepicker"  placeholder="Date of birth" value="<?php if(isset($data['date_of_birth'])){echo $data['date_of_birth']; } else { echo set_value('date_of_birth');}?>">
                            </div>  
                            
                            <div class="col-md-3">
                                <label>Status </label>
                            </div>
                            <div class="col-md-9 form-group">
                                <select name="status" class="form-control" id="status">
                                <option value="" <?php if(isset($data['id'])){?> disabled='' <?php } ?>> Select </option>
                                <?php foreach($status as $key=>$value): ?>
                                <option value="<?php echo $value; ?>" <?php if(isset($data['status'])){if($value == $data['status']){ ?> selected <?php } } ?>  ><?php echo $value; ?></option>
                                <?php endforeach; ?> 
                                </select>
                            </div>
                            
                            <div class="col-md-3"></div>
                            <div class="col-md-9 form-group">
                                <button type="submit" name="submit" id="submit" class="btn btn-primary">&nbsp; Save &nbsp;</button>
                                <button type="button" name="back" id="back" onclick='window.location.href="<?php echo base_url().$this->config->item('admin_folder').'/student'?>"' class="btn btn-box">&nbsp; Back &nbsp;</button>
                            </div>
                        </form>
                        </div>
                </div><!-- /.col-->
                <div class="col-md-3">
                    <div class="btn-group pull-right box-header">
                        <a class="btn btn-default" href="<?php echo base_url().$this->config->item('admin_folder')?>/student">Manage Student</a>
                    </div> 
                </div>
                </div><!-- ./row -->
            </div><!-- /.box -->
    </section><!-- /.content -->
                
            </div> 
    </div><!-- ./wrapper -->
    <?php include('footer.php')?>
    <script src="<?php echo base_url()?>admin_assets/js/student_form.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  
<script>
$(document).ready(function() {
  $("#datepicker").datepicker({maxDate: 0});
});
</script>

<script>
/*function getrollno(class_id)
{
        //alert('this id value :'+id);
        $.ajax({
                type: "POST",
                url: ADMIN_URL + '/student/ajax_rollno' + '/'  + class_id,
                data: country_id = 'class_id',
                    success: function(data){
                        //alert(state);
                        $('#roll_no').html(data);
                    },
        });
}*/
</script>

</body>
</html>