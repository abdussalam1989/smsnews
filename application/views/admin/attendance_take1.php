<?php include('header.php')?>
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
                        <li><a href="<?php echo ADMIN_URL.'/attendance/take';?>">Attendance Temp</a></li>
                        <li class="active"><?php echo $page_title; ?></li>
                    </ol>
                </section>
                <form onsubmit="return confirboxvalue()" action="<?php echo ADMIN_URL.'/attendance/take' ?>" method="POST" >
           <section class="content">
            <div class="box box-primary">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="box-header">
                        <div class="col-md-3" ></div>
                            <label class="col-md-9"><span class="has-error"> 
                                </span></label>
                        <span class="has-error"><?php echo $this->session->flashdata('error_msg'); ?></span>
                    </div>
                    
                    <div class="col-md-2">
                        <label> Class : </label>
                    </div>
                    <div class="col-md-4 form-group">
                        <select name="class_name" class="form-control" id="class_name">
                        <option value=""  > Select </option>
                        <?php foreach($get_class_list as $class): ?>
                            <option value="<?php echo $class['id']; ?>" ><?php echo $class['name']; ?></option>
                        <?php endforeach; ?> 
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label>Sms For </label>
                    </div>
                    <div class="col-md-4 form-group">
                        <select name="take_type" class="form-control" id="take_type">
                        <option value=""> Select </option>
                        <?php foreach($get_take_type as $take): ?>
                        <option value="<?php echo $take['type_name']; ?>" <?php if($take['type_name']=='absent'){ ?> selected="selected" <?php } ?> ><?php echo $take['type_name']; ?></option>
                        <?php endforeach; ?> 
                        </select>
                    </div>
                    
                <input type="hidden" value="0" name="con_sms" id="con_sms">
                </div><!-- /.col-->
                <div class="col-md-3">
                     
                </div>
                </div><!-- ./row -->
                <div id="attendance_report">
                    <h1><center>Take
                            Attendance</h1> 
                    <?php if(empty($get_list)) { ?>
                            <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <!--<th width="5%">NO. </th>-->
                                    <th>STUDENT ROLL NO</th> 
                                    <th>STUDENT NAME</th>
                                    <th>ATTENDANCE</th>
                                </tr>
                            </thead>
                            </table>
                            <?php } else { ?>  
                    <?php } ?>
                </div>    
              
            </div><!-- /.box -->
    </section><!-- /.content -->      
    </form>
    </div><!-- /.content-wrapper -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <?php include('footer.php'); ?>
  </body>
  <script src="<?php echo base_url()?>admin_assets/js/data.js"> </script>
<script>
function confirboxvalue()
{
    var r = confirm("Are you sure you want to send SMS?");
    if (r == true) {
        var class_name=$('#take_type').val();
        if(class_name=='present'){
                $('#con_sms').val('ps');
        }
        if(class_name=='absent'){
                $('#con_sms').val('as');
        }
        if(class_name=='both'){
                $('#con_sms').val('pas');
        }
        //alert(class_name);
        //$('#con_sms').val('1');
        return true;
    } else {
        return false;
    }
}
    
    

</script>

<script>
$('#class_name').change(function(){      
    var class_name=($('#class_name').val());
        $.ajax({
            type: "POST",
            url: '<?php echo base_url().$this->config->item("admin_folder")?>/attendance/get_class_list/' + class_name,
            data: 'class_name=' + class_name,
            success: function(data){
                if(data)
                {   
                    $('#attendance_report').html(data);
                }
            },
        });
});
</script>

</html>
