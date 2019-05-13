<?php include('header.php');?>
<style> .has-error { color: red; } </style>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include('header_menu.php'); ?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php include('aside.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
        <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1 class="box-title"><?php echo $page_title ?></h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url().$this->config->item('admin_folder').'/dashboard'?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo base_url().$this->config->item('admin_folder').'/email_templates'?>">Email Templates</a></li>
                        <li class="active"><?php echo $page_title ?></li>
                    </ol>
                </section>
            <div id="act_msg"></div> 
            <div id="div_msg"> 
                    <?php include('flashmessage.php'); ?>
            </div>
        <!-- Main content -->
        <section class="content">
            <div class="box box-primary">
            <div class="row">
                <div class="col-md-2"></div>
            <div class="col-md-7">
                    <div class="box-header">
                        <div class="col-md-3"></div>
                        <label class="col-md-9"><span class="has-error"><?php echo $val_error; ?></span>
                        <span class="has-error"><?php echo $this->session->flashdata('error_msg'); ?></span></label>
                    </div>
                   
                <div class="box-body">
                    <form role="form" method="POST" enctype="multipart/form-data" action="<?php echo $mode; ?>">           
                       
                        <div class="col-md-3">
                            <label>Tamplate Name<span class="has-error">*</span></label>
                        </div>
                        <div class="col-md-9 form-group">
                            <input type="text" class="form-control" name="template_name" id="template_name"  placeholder="Enter your name" value="<?php  if(set_value('template_name') == null){echo $list['title']; }else{echo set_value('template_name'); }?>">
                            <input type="hidden" name="template_id" id="template_id" value="<?php echo $list['id']; ?>">
                        </div>
                        
                        <div class="col-md-3">
                            <label>Email Subject <span class="has-error">*</span></label>
                        </div>
                        <div class="col-md-9 form-group">
                             <input type="text" class="form-control" name="email_subject" id="email_subject" value="<?php  if(set_value('email_subject') == null){echo $list['subject']; }else{echo set_value('email_subject'); }?>">
                        </div>
                        
                        <div class="col-md-3">
                            <label>Mail Content <span class="has-error">*</span></label>
                        </div>
                        <div class="col-md-9 form-group">
                                 <textarea id="editor1" name="editor1" rows="10" cols="80" >
                                <?php  if(set_value('editor1') == null){echo $list['mail_content']; }else{echo set_value('editor1'); }?>
                                </textarea>
                        </div>
                    <div class="col-md-3"></div>    
                    <div class="col-md-9 form-group">
                        <button type="submit" name="submit" id="submit" class="btn btn-primary">&nbsp; Save &nbsp;</button>
                        <button type="button" name="back" id="back" onclick='window.location.href="<?php echo base_url().$this->config->item('admin_folder').'/email_templates'?>"' class="btn btn-box">&nbsp; Back &nbsp;</button>
                    </div>
                    </form>
                </div>
                       
            </div><!-- /.col-->
            <div class="col-md-3">
                <div class="btn-group pull-right box-header">
                <a class="btn btn-default" href="<?php echo base_url().$this->config->item('admin_folder')?>/email_templates">Manage EmailTemplate</a>
                </div> 
            </div>
        </div><!-- ./row -->
         </div><!-- /.box -->
    </section><!-- /.content -->
   
    <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
 </div><!-- /.content-wrapper -->
    <?php include('footer.php'); ?>
    <!-- CK Editor -->
    <script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
    <script src="<?php echo base_url()?>admin_assets/js/emailtemplate.js"></script>
</body>

