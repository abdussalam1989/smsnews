<?php $this->load->view($this->config->item('admin_folder') . '/header'); ?>
<style> .ab { color: blue; } .size { alignment-adjust: center; } 
</style>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->load->view($this->config->item('admin_folder') . '/header_menu'); ?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php $this->load->view($this->config->item('admin_folder') . '/aside'); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1><?php echo $page_title; ?> </h1>
                <div id="act_msg"></div> 
                <div id="div_msg"> 
                    <?php $this->load->view($this->config->item('admin_folder') . '/flashmessage'); ?>
                </div>
                <ol class="breadcrumb">
                    <li><a href="<?php echo ADMIN_URL . '/dashboard'; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="<?php echo ADMIN_URL . '/send'; ?>"> Send Sms </a></li>
                    <li class="active"><?php echo $page_title; ?></li>
                </ol>
            </section>

            <section class="content">
              
                    <div class="row">
                        <div class="col-md-7">
                              <div class="box box-primary">
                           
                                   <br>
                                  
                                    
                                     <form action="<?php echo ADMIN_URL ?>/classes/getclassgroup" enctype="multipart/form-data" method="POST">
                                    <div class="col-md-6 form-group">
                                        <label>Class Group :</label>   
                                        <select name="class_name" class="btn btn-default" id="class_name" onchange='this.form.submit()'>                                            
                                            <option value="All" <?php if($class_group_id=='All') { echo "selected=selected";}?>> All </option>
                                            <option value="1" <?php if($class_group_id=='1') { echo "selected=selected";}?>> Nursery </option>
                                            <option value="2" <?php if($class_group_id=='2') { echo "selected=selected";}?>> Primary </option>
                                            <option value="3" <?php if($class_group_id=='3') { echo "selected=selected";}?>> Secondary </option>
                                            <option value="4" <?php if($class_group_id=='4') { echo "selected=selected";}?>> Sr. Secondary </option>
                                                
                                        </select>
                                    </div>
                                    </form>

                                 <form role="form" method="POST" enctype="multipart/form-data" action="<?php echo ADMIN_URL ?>/classes/assign_class" onsubmit="return validateForm()"> 
                                <?php if (empty($get_group_list)) {                                                             
                                ?>
                                
                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead> <tr>
                                                <th width="5%">NO. </th>
                                                <th>CLASS NAME</th>
                                                <th id="fir" width="3%"><input type="checkbox" id="ckbCheckAll2" name="head_checkbox"></th>
                                            </tr></thead>
                                    </table>
                                <?php } else { ?>  
                                    <table id="" class="table table-bordered table-striped">
                                        <thead>  <tr>
                                                <th width="5%">NO. </th>
                                                <th>CLASS NAME</th>
                                                <th id="fir" width="3%"><input type="checkbox" id="ckbCheckAll2" value='' name="head_checkbox"></th>
                                            </tr></thead>
                                        <tbody>
                                            <?php
                                            $cnt = 1;
                                            foreach ($get_group_list as $group) {
                                                ?>
                                                <tr>  
                                                    <td><?php echo $cnt; ?></td> 
                                                    <td><?php echo $group['name']; ?></td>  
                                                    <td><input type="checkbox" name="check_id[]" class="checkBoxClass" value="<?php echo $group['id']; ?>"></td>
                                                </tr>  
                                                <?php
                                                $cnt++;
                                            }
                                            ?>  
                                        </tbody>
                                    </table>
                                <?php } ?>
                                 </div>
                        </div>
                        <div class="col-md-5">
                             <div class="box box-primary">
                            <div class="box-header">
                                <div class="col-md-3"></div>
                                <label class="col-md-9"><span class="has-error"> 
                                    </span></label>
                                <span class="has-error"><?php echo $this->session->flashdata('error_msg'); ?></span>
                            </div>
                            <div class="box-body">

                                                       
                                <div class="form-group"> 
                                    <div class="row">
                                        <label for="teacher" class="col-md-4">Teacher :</label>
                                        <div class="col-md-8">
                                        <select name="teacher" class="form-control" id="teacher" required="required">
                                        <option value="" > Select Teacher</option>
                                        <?php foreach($teacher as $key=>$value): ?>                              <option value="<?php echo $value['id']; ?>" ><?php echo $value['name']; ?></option> 
                                        <?php endforeach; ?>                                                
                                    </select> 
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" style="float:right" name="submit" id="submit"  class="btn btn-primary" >Submit</button>
                                </div>
                                <div id="targetLayer" ></div>
                                </form>
                            </div>
                        </div>

                         <!-- ./row -->
                </div><!-- /.box -->
            </section><!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- Add the sidebar's background. This div must be placed
             immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->
    <?php $this->load->view($this->config->item('admin_folder') . '/footer'); ?>
    <script src="<?php echo base_url() ?>admin_assets/js/data.js"></script>
    <script src="<?php echo base_url() ?>admin_assets/js/sms.js"></script>
    <script src="<?php echo base_url(); ?>admin_assets/js/send_sms.js"></script>

</body>


