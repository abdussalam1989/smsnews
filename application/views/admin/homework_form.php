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
                        <li><a href="<?php echo base_url().$this->config->item('admin_folder').'/homework'?>">Homework</a></li>
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
                                <input type="text" class="form-control" name="name" id="name"  placeholder="Enter name" value="<?php  if(isset($data['name'])){echo $data['name']; }else{echo set_value('name'); }?>">
                                <input type="hidden" name="data_id" id="data_id" value="<?php if(isset($data['id'])) { echo $data['id']; } ?>">
                            </div>
                            
                            <div class="col-md-3">
                                 <label>Assignment<span class="has-error">*</span></label>
                            </div>
                            <div class="col-md-9 form-group">
                                <textarea name="template_text" placeholder="Enter message" style="height: 100px" class="form-control" id="template_text" ><?php if(isset($data['template_text'])) { echo $data['template_text']; } else { set_value('template_text'); } ?> </textarea>
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
                                <button type="button" name="back" id="back" onclick='window.location.href="<?php echo base_url().$this->config->item('admin_folder').'/sms'?>"' class="btn btn-box">&nbsp; Back &nbsp;</button>
                            </div>
                        </form>
                        </div>
                </div><!-- /.col-->
                <div class="col-md-3">
                    <div class="btn-group pull-right box-header">
                        <a class="btn btn-default" href="<?php echo base_url().$this->config->item('admin_folder')?>/sms">Manage SMS Tem.</a>
                    </div> 
                </div>
            </div><!-- ./row -->
             </div><!-- /.box -->
    </section><!-- /.content -->
                
            </div> 
    </div><!-- ./wrapper -->
    <?php include('footer.php')?>
</body>
</html>