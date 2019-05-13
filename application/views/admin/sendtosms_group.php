<?php include('header.php')?>
<style> .ab { color: blue; }  </style>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php  include('header_menu.php') ?>
            <!-- Left side column. contains the logo and sidebar -->
            <?php include('aside.php')?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1><?php echo Groups; ?> </h1>
                        <div id="act_msg" ></div> 
                        <div id="div_msg"> 
                                <?php include('flashmessage.php');?>
                        </div>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo ADMIN_URL.'/dashboard'; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo ADMIN_URL.'/send';?>">Send Sms </a></li>
                        <li class="active">Groups</li>
                    </ol>
                </section>
               
            <section class="content">
            <div class="box box-primary">
            <div class="row">
                <div class="col-md-12">
                    <form action="<?php echo ADMIN_URL ?>/sender/getgroup" enctype="multipart/form-data" method="POST">    
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        <label>Select Group :</label> 
                    </div>
                    <div class="col-md-2 form-group">
                        <select name="class_name" class="btn btn-default" id="class_name" onchange='this.form.submit()'>
                        <option value="select">Select </option>
                        <option value="All"  <?php if(isset($class_value)){ if('All'==$class_value) { ?> selected="selected" <?php } } ?>  > All</option>
                        <?php foreach($get_group_list as $group): ?>
                        <option value="<?php echo $group['id']; ?>" <?php if(isset($class_value)){ if($group['name']==$class_value) { ?> selected="selected" <?php } } ?> > <?php echo $group['name']; ?></option>
                        <?php endforeach;?> 
                        </select>
                    </div>
                   
                    <noscript><input type="submit" value="Submit"></noscript>
                    <div class="col-md-6"></div>
                    <div id="student_list" class="col-md-12">
                        
                    <?php if(empty($get_student_list)) { ?>
                        <table id="example2" class="table table-bordered table-striped">
                        <thead> <tr>
							<th>STUDENT ID</th>
                            <th width="5%">CLASS</th>                            
                            <th>STUDENT NAME</th>
                            <th>FATHER NAME</th> 
                            <th>FATHER MOBILE NO.</th>
                             <th>Alt NO.</th>
                            </tr></thead>
                        </table>
                        <?php } else { ?>  
                        <table id="example2" class="table table-bordered table-striped">
                            <thead> 
                            <tr>
							<th>STUDENT ID</th>
                            <th width="5%">CLASS </th>
                            <th>STUDENT NAME</th>
                            <th>FATHER NAME</th> 
                            <th>FATHER MOBILE NO.</th>
                             <th>Alt NO.</th>
                             </tr></thead>
                        <tbody>
                            <?php 
							$cnt=1;
                            foreach($get_student_list as $student){  
							
							/*echo "<pre>";
							print_r($student);
							echo "</pre>";*/
							?>
                                <tr>  
                                    <td><?php echo $student['admission_no']; ?></td>
									<td><?php echo $student['class_name']; ?></td> 									
                                    <td><?php echo $student['name'];?></td>  
                                    <td><?php echo $student['father_name'];?></td>
                                    <td><?php echo $student['mobile_no'];?></td>
                                    <!--<td><div id="mydiv"><input type="checkbox" name="mul_id" class="checkBoxClass" value="<?php if(!empty($student['roll_no'])) {  echo  $student['roll_no']. '(' .$student['name'] .')'; }  ?> "></div></td>-->
									<td><?php echo $student['alternate_no'];?></td>									
                                    </tr>  
                                <?php  $cnt++; } ?>  
                        </tbody>
                        </table>
                    <?php } ?>
                    </div>
                    
                    <div class="form-group">
                       <!-- <button type="submit" name="submit" id="submit" class="btn btn-primary">Get List</button> -->
                    </div>
                </form>    
                </div>
                <div class="col-md-4">
                    <div class="box-header">
                        <div class="col-md-3"></div>
                            <label class="col-md-9"><span class="has-error"> 
                                </span></label>
                                <span class="has-error"><?php echo $this->session->flashdata('error_msg'); ?></span>
                    </div>
                    
                </div><!-- /.col-->
                <div class="col-md-1"></div>
            </div><!-- ./row -->
            <div>
                   <!-- <h1><center>SMS Report</h1> 
             <table id="sms_to_student" class="display table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>SMS STATUS</th>
                                <th>DATE</th>
                                <th>TIME</th>
                                <th width="10%"> Roll NO.</th>
                                <th>CLASS NAME</th>
                                <th width="20%">MESSAGE</th>  
                                <th>MOBILE NO.</th>
                                <th>MSG COUNT</th>
                            </tr>
                        </thead>
                </table> -->
                 
                <!-- -->
                </div>
             </div><!-- /.box -->
    </section><!-- /.content -->
       
    </div><!-- /.content-wrapper -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <?php include('footer.php'); ?>
  
    <script src="<?php echo base_url()?>admin_assets/js/data.js"> </script>
    <script src="<?php echo base_url()?>admin_assets/js/sms.js"> </script>
    <script src="<?php echo base_url(); ?>admin_assets/js/send_sms.js"> </script>
</body>
</html>





<script>
function updateTextArea1() {
    var rollNo=[];
    $('#mydiv :checked').each(function () {
        if($(this).val()!=""){
			var roll_name_contact = $(this).val();
		    var result= roll_name_contact.split('~');
		    var roll_no 	= result[0];
		    //alert(roll_no);  
		    rollNo.push(roll_no);
        }
    });
    $('#admission_no').val(rollNo)
}
  
    
$(function () {
    $('#mydiv input').click(updateTextArea1);
    updateTextArea1();
});
</script>
