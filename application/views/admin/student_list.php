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
                        <li><a href="<?php echo ADMIN_URL.'/student';?>">Student</a></li>
                        <li class="active"><?php echo $page_title; ?></li>
                    </ol>
                </section>
               
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <a class="btn btn-default pull-left" target="_blank" href="<?php echo base_url().$this->config->item('admin_folder')?>/student/import">Import Excel</a>
                            <a class="btn btn-default pull-right" href="<?php echo base_url().$this->config->item('admin_folder')?>/student/mode">Add Student</a>
                            <a class="btn btn-default pull-right" href="<?php echo base_url().$this->config->item('admin_folder')?>/send/send-sms-to-student">Send SMS To Student</a>
                            
                            <form action="<?php echo base_url().$this->config->item('admin_folder')?>/student/ExportCSV" method="POST">
                                <input type="submit" class="btn btn-default pull-right" value="Export CSV">
                                <input type="hidden" name="csv_class" id="csv_class" value="<?php if(isset($csv_data)){ echo $csv_data; } ?>">
                            </form>
                            
                            <form action="<?php echo base_url().$this->config->item('admin_folder')?>/student" method="POST">
                                <div class="pull-right">
                                <select name="get_class" class="form-control pull-right" id="get_class" onchange='this.form.submit()' >
                                    <option value="" <?php if(isset($data['id'])){ ?> disabled='' <?php } ?> > All </option>
                                    <?php foreach($class_name as $c_list): ?>
                                        <option value="<?php echo $c_list['id']; ?>" <?php if(isset($csv_data)){if($c_list['id'] == $csv_data){ ?> selected <?php } } ?>  ><?php echo $c_list['name']; ?></option>
                                    <?php endforeach; ?> 
                                </select>
                                    <noscript><input type="submit" value="Submit"></noscript>
                                </div>
                                <div class="pull-right">
                                    <label>Class name : </label>&nbsp;&nbsp;
                                </div>
                            </form>
                        </div><!-- /.box-header -->
                <div class="box-body">
                    <?php if(empty($data)) { ?>
                    <table id="example2" class="table table-bordered table-striped">
                    <thead>
                                <tr>
                                    <th id="fir" width="3%"><input type="checkbox" id="ckbCheckAll2" name="head_checkbox" ></th>       
                                    <th width="5%">NO.</th>
                                    <th>STUDENT NAME</th>
                                    <th>CLASS NAME</th>
                                    <th>ROll NO</th>
                                    <th>FATHER NAME</th>
                                    <th>MOBILE NO.</th>
                                    <th width="10%">STATUS</th>
                                    <th width="8%">OPTION</th>
                                </tr>
                    </thead>
                    </table>
                        <?php } else { ?>
                        <form name="list_form" action="<?php echo base_url().$this->config->item('admin_folder')?>/student/mul_action" method="POST" >
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th id="fir" width="3%"><input type="checkbox" id="ckbCheckAll2" name="head_checkbox" ></th>       
                                    <th width="5%">NO. </th>
                                    <th>STUDENT NAME</th>
                                    <th>CLASS NAME</th>
                                    <th>ROll NO</th>
                                    <th>FATHER NAME</th> 
                                    <th>MOBILE NO.</th>
                                    <th width="10%">STATUS</th>
                                    <th width="8%">OPTION</th>
                                </tr>
                            </thead>
                        <tbody>
                            <?php 
                            $cnt=1;
                            $del_url='/student/delete/';
                            foreach ($data as $data_list){ 
							/*echo "<pre>";
							print_r($data_list);
							echo "</pre>";*/  
							
							?>
                                <tr>  
                                    <td><input type="checkbox" name="mul_id[]" id="mul_id"  value="<?php echo $data_list['id']?>"  class="checkBoxClass"  > </td>
                                    <td><?php echo $cnt;?></td> 
                                    <td><?php echo $data_list['name'];?></td>  
                                    <td><?php echo $data_list['class_name'];?></td>  
                                    <td><?php if($data_list['user_id']=='20'){ echo $data_list['admission_no']; }else{ echo $data_list['roll_no'];}?></td>  
                                    <td><?php echo $data_list['father_name'];?></td>  
                                    <td><?php echo $data_list['mobile_no'];?></td>  
                                    <td><?php $checked = '';
                                    if($data_list['status']=='Active'){
                                        $checked = 'checked'; ?>  
                                        <input type='checkbox' name='boot_btn' id='<?php echo $data_list['id'];?>' value='/student/change_status/' class='form-control cls_chk'  data-size='mini' <?php echo $checked ?> >
                                    <?php } else { ?>
                                        <input type='checkbox' name='boot_btn' id='<?php echo $data_list['id'];?>' value='/student/change_status/' class='form-control cls_chk'  data-size='mini'></td>
                                    <?php } ?>
                                    <td><a class="pencil-square-o" title="Edit" href="<?php echo base_url().$this->config->item('admin_folder').'/student/mode/'.$data_list['id']?>"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;
                                     <a href="javascript:;" title="Delete" class="btn btn-xs btn-danger" onclick="return delete_rec('<?php echo $data_list['id']?>','<?php echo $del_url; ?>');"><i class="fa fa-times"></i></a></td>
                                </tr>  
                                <?php 
                                $cnt++;
                                } ?>  
                        </tbody>
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
                               <?php } ?>
                        </form>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <?php include('footer.php'); ?>
    <script src="<?php echo base_url()?>admin_assets/js/data2.js"> </script>
   
</body>
</html>
