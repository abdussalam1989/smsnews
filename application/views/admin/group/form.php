
<?php $this->load->view($this->config->item('admin_folder') . '/header'); ?>
<style> .has-error { color: red; } </style>

<body class="hold-transition skin-blue sidebar-mini">


    <div class="wrapper">
        <?php $this->load->view($this->config->item('admin_folder') . '/header_menu'); ?>        
        <!-- Left side column. contains the logo and sidebar -->
        <?php $this->load->view($this->config->item('admin_folder') . '/aside'); ?>        
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1 class="box-title"><?php echo $page_title ?></h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url() . $this->config->item('admin_folder') . '/dashboard' ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="<?php echo base_url() . $this->config->item('admin_folder') . '/group' ?>">group</a></li>
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
                                        <?php echo $val_error; ?></span></label>
                                <span class="has-error"><?php echo $this->session->flashdata('error_msg'); ?></span>
                            </div>
                            <div class="box-body">
                                <form role="form" method="POST" enctype="multipart/form-data" action="<?php echo $mode; ?>">  
                                    <div class="col-md-3">
                                        <label>Name <span class="has-error">*</span></label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                        <input type="text" class="form-control" name="name" id="name"  placeholder="Enter name" value="<?php
                                        if (isset($data['name'])) {
                                            echo $data['name'];
                                        } else {
                                            echo set_value('name');
                                        }
                                        ?>">
                                        <input type="hidden" name="data_id" id="data_id" value="<?php
                                        if (isset($data['id'])) {
                                            echo $data['id'];
                                        }
                                        ?>">
                                        <input type="hidden" name="grp_member" id="grp_member" value="<?php
                                        if (isset($grp_info['group_type'])) {
                                            echo $grp_info['group_type'];
                                        }
                                        ?>">
                                        <input type="hidden" name="grp_class_id" id="grp_class_id" value="<?php
                                        if (isset($grp_info['class_id'])) {
                                            echo $grp_info['class_id'];
                                        }
                                        ?>">
                                    </div>



                                    <div class="col-md-3">
                                        <label>Status <span class="has-error">*</span></label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                        <select name="status" class="form-control" id="status">
                                            <option value="" <?php if (isset($data['id'])) { ?> disabled='' <?php } ?> > Select </option>
                                            <?php foreach ($status as $key => $value): ?>
                                                <option value="<?php echo $value; ?>" <?php
                                                if (isset($data['status'])) {
                                                    if ($value == $data['status']) {
                                                        ?> selected <?php
                                                            }
                                                        }
                                                        ?>  ><?php echo $value; ?></option>
                                                    <?php endforeach; ?> 
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Mobile Numbers </label>
                                    </div>
                                    <div class="col-md-9 form-group">
                                        <textarea class="form-control" style="height: 150px;" value="" name="mobile_number" id="mobile_number" ><?php if (isset($data['id'])) { echo $data['mobile_number']; }?></textarea>  
                                          <div class="charLeftInput" id="">Please give the mobile each numbers separate with comma(,) </div>
                                    </div>


                                    <div class="col-md-3"></div>
                                    <div class="col-md-9 form-group">
                                        <button type="submit" name="submit" id="submit" class="btn btn-primary">&nbsp; Save &nbsp;</button>
                                        <button type="button" name="back" id="back" onclick='window.location.href = "<?php echo base_url() . $this->config->item('admin_folder') . '/group' ?>"' class="btn btn-box">&nbsp; Back &nbsp;</button>
                                    </div>
                                </form>
                            </div>
                        </div><!-- /.col-->
                        <div class="col-md-2">
                            <div class="btn-group pull-right box-header">
                                <a class="btn btn-default" href="<?php echo base_url() . $this->config->item('admin_folder') ?>/group">Manage Group</a>
                            </div> 
                        </div>
                    </div><!-- ./row -->
                </div><!-- /.box -->
            </section><!-- /.content -->

        </div> 
    </div><!-- ./wrapper -->
    <?php $this->load->view($this->config->item('admin_folder') . '/footer'); ?>
    <script src="<?php echo base_url() ?>admin_assets/js/group_form.js"></script>
    <script src="<?php echo base_url() ?>admin_assets/js/data.js"></script>
</body>
</html>