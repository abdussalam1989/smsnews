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
                    <h1 class="box-title"><?php echo $page_title ; ?></h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo ADMIN_URL.'/dashboard'?>"><i class="fa fa-dashboard"></i> Home</a></li>
                         <li><a href="<?php echo ADMIN_URL.'/pages'?>">Pages</a></li>
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
                                <?php echo $val_error;  ?></span>
                                <span class="has-error"><?php echo $this->session->flashdata('error_msg'); ?></span></label>
                        </div>
                    <div class="box-body">
                        <form role="form" method="POST" enctype="multipart/form-data" action="<?php echo $mode; ?>">    
                        <div class="col-md-3">
                             <label>Page name <?php if($check=='add'){ echo '<span class="has-error">*</span>'; }?></label>
                        </div>    
                        <div class="col-md-9 form-group"> 
                            <?php if($check=='edit'){ echo '<b>'.$list['pagename'].'</b>'; ?>
                            <input type="hidden" class="form-control" name="page_name" id="page_name"  placeholder="Enter name" value="<?php  if(set_value('page_name')==null){echo $list['pagename']; }else{echo set_value('page_name'); }?> ">
                            <?php   } else  { ?>
                            <input type="text" class="form-control" name="page_name" id="page_name"  placeholder="Enter name" value="<?php  if(set_value('page_name')==null){echo $list['pagename']; }else{echo set_value('page_name'); }?> ">
                            <?php } ?>
                            <input type="hidden" name="id" id="id" value="<?php echo $list['id']; ?>">
                        </div>
                            
                        <div class="col-md-3">
                            <label>Page title <span class="has-error">*</span></label>
                        </div>    
                        <div class="col-md-9 form-group"> 
                            <input type="text" class="form-control" name="page_title" id="page_title"  placeholder="Enter name" value=" <?php  if(set_value('page_title')==null){echo $list['pagetitle']; }else{echo set_value('page_title'); }?>">
                        </div>    
                            
                        <div class="col-md-3">
                            <label>Description <span class="has-error">*</span></label>
                        </div>    
                        <div class="col-md-9 form-group"> 
                            <textarea id="editor1" name="editor1" rows="10" cols="80" >
                            <?php if(set_value('editor1')==null){echo $list['content']; }else{echo set_value('editor1'); }?>
                            </textarea>
                        </div>    
                            
                        <div class="col-md-3">
                            <label>Browser Title <span class="has-error">*</span></label>
                        </div>    
                        <div class="col-md-9 form-group"> 
                             <textarea name="browsertitle" style="height:50px;" placeholder="browsertitle" class="form-control"><?php if(set_value('browsertitle')==null){echo $list['browsertitle']; }else{echo set_value('browsertitle'); }?> </textarea> 
                        </div>   
                        
                        <div class="col-md-3">
                            <label>Meta Name <span class="has-error">*</span></label>
                        </div>    
                        <div class="col-md-9 form-group"> 
                            <textarea name="metaname" style="height:70px;" placeholder="metaname" class="form-control"><?php if(set_value('metaname')==null){echo $list['metaname']; }else{echo set_value('metaname'); }?> </textarea> 
                        </div>   
                            
                        <div class="col-md-3">
                            <label>Meta Description <span class="has-error">*</span></label>
                        </div>    
                        <div class="col-md-9 form-group"> 
                             <textarea name="description" style="height:100px;" placeholder="description" class="form-control"><?php if(set_value('description')==null){echo $list['description']; }else{echo set_value('description'); }?> </textarea> 
                        </div> 
                            
                        <div class="col-md-3">
                            <label>Meta Keywords <span class="has-error">*</span></label>
                        </div>    
                        <div class="col-md-9 form-group"> 
                            <textarea name="keywords" style="height:130px;" placeholder="keywords" class="form-control"><?php if(set_value('keywords')==null){echo $list['keywords']; }else{echo set_value('keywords'); }?> </textarea> 
                        </div> 
                        <div class="col-md-3"></div>
                        <div class="col-md-9 form-group">
                            <button type="submit" name="submit" id="submit" class="btn btn-primary">&nbsp; Save &nbsp;</button>
                            <button type="button" name="back" id="back" onclick='window.location.href="<?php echo base_url().$this->config->item('admin_folder').'/pages'?>"' class="btn btn-box">&nbsp; Back &nbsp;</button>
                        </div>
                        </form>
                    </div>  
                </div><!-- /.col-->
                <div class="col-md-3">
                    <div class="btn-group pull-right box-header">
                            <a class="btn btn-default" href="<?php echo base_url().$this->config->item('admin_folder')?>/Pages">Manage Page</a>
                    </div>  
                </div>
            </div><!-- ./row -->
             </div><!-- /.box -->
    </section><!-- /.content -->
                
                
                
            </div> 
    </div><!-- ./wrapper -->
    <?php include('footer.php')?>
    
    <!-- CK Editor -->
    <script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
    <script src="<?php echo base_url()?>admin_assets/js/page_list.js">
    </script>
    <script></script>
</body>