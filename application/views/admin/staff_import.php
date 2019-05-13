<?php include('header.php')?>
<style> .clr { background-color: #ffcccc; } </style>
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
                        <div id="act_msg"></div> 
                        <div id="div_msg"> 
                        <?php include('flashmessage.php');?>
                        </div>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo ADMIN_URL.'/dashboard'; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo ADMIN_URL.'/staff';?>">Staff</a></li>
                        <li class="active"><?php echo $page_title; ?></li>
                    </ol>
                </section>
               
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <span class="btn btn-default clr"> Note : Please always use .csv file only. and fields Titles Should be like this ("name","emp_id","mobile_no") </span>
                            <a class="btn btn-default pull-right" href="<?php echo base_url();?>upload/csv/sample_sheet_staff.csv" download>Download Sample Sheet</a>
                            <div class="btn-group pull-right"></div>
                        </div><!-- /.box-header -->
                <div class="box-body">
                      
                    <form action="<?php echo ADMIN_URL ?>/staff/import" enctype="multipart/form-data" method="POST">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="col-md-3">
                                <label> Choose your file : </label>
                            </div>
                            <div class="col-md-9 form-group">
                                <input type="file" name="userfile" class="btn btn-default">
                            </div>
                            
                            <div class="col-md-3"></div>
                            <div class="col-md-9 form-group">
                                <button type="submit" name="submit" id="submit" class="btn btn-primary">&nbsp; Submit &nbsp;</button>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </form>
                        </div><!-- /.box-body -->
            <div>
                
                 <?php if(isset($get_list)) { ?>
                <h1><center> Import Data</h1> 
                       
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">NO. </th>
                                    <th>NAME</th>
                                    <th>EMP ID</th> 
                                    <th>MOBILE NO.</th>
                                </tr>
                            </thead>
                        <tbody>
                            <?php  $cnt=1;  foreach ($get_list as $elist){ ?>
                                <tr>  
                                    <td><?php echo $cnt;?></td> 
                                    <td><?php echo $elist['name'];?></td>  
                                    <td><?php echo $elist['employ_id'];?></td>  
                                    <td><?php echo $elist['mobile_no'];?></td>
                                </tr>  
                                <?php  $cnt++; } ?>  
                        </tbody>
                        </table>
                    <?php } ?>
            </div>
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
  </body>
  <script src="<?php echo base_url()?>admin_assets/js/data.js"> </script>
</html>
