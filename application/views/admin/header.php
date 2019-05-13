 <?php  $flag_login_manag='0'; ?>
<!DOCTYPE html>
<html>
  <head>
      
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->config->item('site_name');?><?php echo (isset($page_title))?' - '.$page_title:' - Admin '; ?></title>
    <?php if( $this->router->fetch_class() == 'login') { ?>
    <link rel="shortcut icon" href="<?php echo base_url()?>admin_assets/Icon/admin.ico" type="image/x-icon">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url()?>admin_assets/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url()?>admin_assets/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url()?>admin_assets/dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url()?>admin_assets/plugins/iCheck/flat/blue.css">
    <?php  } else { ?>
    
    <link rel="shortcut icon" href="<?php echo base_url()?>admin_assets/Icon/admin.ico" type="image/x-icon">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url()?>admin_assets/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url()?>admin_assets/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url()?>admin_assets/dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url()?>admin_assets/plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="<?php echo base_url()?>admin_assets/plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?php echo base_url()?>admin_assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?php echo base_url()?>admin_assets/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url()?>admin_assets/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?php echo base_url()?>admin_assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?php echo base_url()?>admin_assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url()?>admin_assets/plugins/datatables/dataTables.bootstrap.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    
   <!-- for image hover effect  -->
   <link rel="stylesheet" href="<?php echo base_url()?>admin_assets/bootstrap/css/image_hover.css">
   
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="<?php echo base_url()?>admin_assets/plugins/timepicker/bootstrap-timepicker.min.css"> 
    
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    
    <!--bootstrap switch-->
    <link href="<?php echo base_url()?>admin_assets/plugins/bootstrap-switch-master/docs/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>admin_assets/plugins/bootstrap-switch-master/docs/css/highlight.css" rel="stylesheet">
    <link href="<?php echo base_url()?>admin_assets/plugins/bootstrap-switch-master/dist/css/bootstrap3/bootstrap-switch.css" rel="stylesheet">
    <link href="http://getbootstrap.com/assets/css/docs.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>admin_assets/plugins/bootstrap-switch-master/docs/css/main.css" rel="stylesheet">
    
      <link href="<?php echo base_url(); ?>admin_assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
      <?php } ?>
    
    <script type="text/javascript">
        var ADMIN_URL='<?php echo ADMIN_URL; ?>'; 
        var URL='<?php echo base_url(); ?>';
    </script>
  </head>

