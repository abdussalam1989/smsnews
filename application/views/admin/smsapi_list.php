<?php include('header.php')?>
<style>.has-error { color: red; }</style>
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
                        <li><a href="<?php echo ADMIN_URL.'/smsapi';?>">Manage SMS API</a></li>
                        <li class="active"><?php echo $page_title; ?></li>
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
                                <?php echo $val_error;  ?>  </span></label>
                                <span class="has-error"><?php echo $this->session->flashdata('error_msg'); ?></span>
                    </div>
                    <div class="box-body">
                        <form role="form" method="POST" enctype="multipart/form-data" action="<?php echo ADMIN_URL; ?>/smsapi">    
                            <div class="col-md-3">
                                 <label>API Name <span class="has-error">*</span></label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" class="form-control" name="api_name" id="api_name"  placeholder="Enter Api name" value="<?php if(isset($data['api_name'])){ } else { echo set_value('api_name');} ?>" >
                            </div>
                            
                            <div class="col-md-3">
                                <label>Total Message<span class="has-error">* </span> </label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="text" name="api_msg" id="api_msg" class="form-control" placeholder="Enter Total sms" value="<?php if(isset($data['api_msg'])){ } else { echo set_value('api_msg');} ?>" >
                            </div>
                            
                            <div class="col-md-3">
                                <label>Status <span class="has-error">*</span></label>
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
                            </div>
                        </form>
                        </div>
                </div><!-- /.col-->
                <div class="col-md-3">
                    <div class="btn-group pull-right box-header">
<!--                        <a class="btn btn-default" href="<?php echo base_url().$this->config->item('admin_folder')?>/classes">Manage Class</a>-->
                    </div> 
                </div>
            </div><!-- ./row -->
           
            <section class="content">
            <div class="row">
                <div class="col-xs-12">
                <div class="">
                    <?php if(empty($data_value)) { ?>
                    <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th id="fir" width="3%"><input type="checkbox" id="ckbCheckAll2" name="head_checkbox" ></th>       
                                    <th width="5%">NO. </th>
                                    <th>NAME</th>
                                    <th>MESSAGE</th>
                                    <th width="10%">STATUS</th>
                                    <th width="8%">OPTION</th>
                                </tr>
                            </thead>
                    </table>
                        <?php } else { ?>
                        <form name="list_form" action="<?php echo base_url().$this->config->item('admin_folder')?>/smsapi/mul_action" method="POST" >
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th id="fir" width="3%"><input type="checkbox" id="ckbCheckAll2" name="head_checkbox" ></th>       
                                    <th width="5%">NO. </th>
                                    <th>NAME</th>
                                    <th>MESSAGE</th>
                                    <th width="10%">STATUS</th>
                                    <th width="8%">OPTION</th>
                                </tr>
                            </thead>
                        <tbody>
                            <?php 
                            $cnt=1;
                            $del_url='/smsapi/delete/';
                            foreach ($data_value as $data_list){ ?>
                                <tr>  
                                    <td><input type="checkbox" name="mul_id[]" id="mul_id"  value="<?php echo $data_list['id']?>"  class="checkBoxClass"  > </td>
                                    <td><?php echo $cnt;?></td> 
                                    <td><?php echo $data_list['api_name'];?></td>  
                                    <td><?php echo $data_list['api_msg'];?></td>  
                                    <td><?php $checked = '';
                                    if($data_list['status']=='Active'){
                                        $checked = 'checked'; ?>  
                                        <input type='checkbox' name='boot_btn' id='<?php echo $data_list['id'];?>' value='/smsapi/change_status/' class='form-control cls_chk'  data-size='mini' <?php echo $checked ?> >
                                    <?php } else { ?>
                                        <input type='checkbox' name='boot_btn' id='<?php echo $data_list['id'];?>' value='/smsapi/change_status/' class='form-control cls_chk'  data-size='mini'></td>
                                    <?php } ?>
                                    <td>
                                     <a href="javascript:;" title="Delete" class="btn btn-xs btn-danger" onclick="return delete_rec('<?php echo $data_list['id']?>','<?php echo $del_url; ?>');"><i class="fa fa-times"></i></a></td>
                                </tr>  
                                <?php  $cnt++; } ?>  
                        </tbody>
                        </table>
                     
                            <div class="col-xs-2"> 
                                <select id="mul_val" name="mul_val" class="form-control" width="5%">
                                <option value="">Select Action</option>
                                <option value="Delete" id="sel_del_rec" >Delete</option>
                                </select>
                            </div>   
                                <div id="show">
                                    <input type="submit" class="btn btn-primary" id="action_submit" name="mul_sub" value="submit" style="display: none">
                                </div>
                               <?php } ?>
                        </form>
                        </div><!-- /.box-body -->
                  
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section>
             </div><!-- /.box -->
    </section><!-- /.content -->
                
    </div><!-- /.content-wrapper -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <?php include('footer.php'); ?>
  </body>
  <script src="<?php echo base_url()?>admin_assets/js/data.js"> </script>
</html>
