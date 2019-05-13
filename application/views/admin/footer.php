 <?php if( $this->router->fetch_class() == 'login') { ?>
<!-- jQuery 2.1.4 -->
   
    <script src="<?php echo base_url()?>admin_assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!--<script src="<?php echo base_url()?>admin_assets/plugins/bootstrap-switch-master/docs/js/jquery.min.js"></script>
     <script src="<?php echo base_url()?>admin_assets/plugins/bootstrap-switch-master/docs/js/bootstrap.min.js"></script>-->
    <script src="<?php echo base_url()?>admin_assets/plugins/bootstrap-switch-master/dist/js/bootstrap-switch.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>admin_assets/bootstrap/js/bootstrap.min.js"></script>
    <?php  } else { ?>
    <!-- DataTables -->
    <script src="<?php echo base_url()?>admin_assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!--<script src="<?php echo base_url()?>admin_assets/plugins/bootstrap-switch-master/docs/js/jquery.min.js"></script>
    <script src="<?php echo base_url()?>admin_assets/plugins/bootstrap-switch-master/docs/js/bootstrap.min.js"></script>-->
    <script src="<?php echo base_url()?>admin_assets/plugins/bootstrap-switch-master/dist/js/bootstrap-switch.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url()?>admin_assets/bootstrap/js/bootstrap.min.js"></script>

    <script src="<?php echo base_url()?>admin_assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>admin_assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="<?php echo base_url()?>admin_assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url()?>admin_assets/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url()?>admin_assets/dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url()?>admin_assets/dist/js/demo.js"></script>
    <!-- Custom function add in js which is used in admin view files -->
    <script src="<?php echo base_url()?>admin_assets/js/main.js"></script>
    <!-- For Confirm PAssword -->
    <script type="text/javascript" src="<?php echo base_url()?>admin_assets/js/validation.js"></script>
    <script src="<?php echo base_url()?>admin_assets/js/cripto.js"></script>
    
      <!-- bootstrap time picker -->
    <script src="<?php echo base_url()?>admin_assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    
    <!-- bootstrap time picker -->
    <script src="<?php echo base_url()?>admin_assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    
    
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>admin_assets/js/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
    <?php }?>
