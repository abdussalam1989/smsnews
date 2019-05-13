<?php
include('header.php');
?>
   <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript">
setTimeout(function() {
$('#div_msg').fadeOut('slow');
 }, 2000);
    </script>
<body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <b>SMS</b></a>
            </div><!-- /.login-logo -->
              
                <div class="login-box-body">
                            <center> <h4><b>FORGOT  PASSWORD ?</b> </h4><br />
                            <!-- <p class="login-box-msg">Don't worry! just fill in your email and we'll help you reset your password.</p>-->
                            </center>
                            <div id="div_msg"> 
                                <?php if($this->session->flashdata('error')) { ?>
                                        <div class="alert alert-danger">
                                        <?php echo $this->session->flashdata('error'); ?>
                                        </div>
                                <?php } if ($this->session->flashdata('message')) { ?>
                                        <div class="alert alert-success">
                                        <?php echo $this->session->flashdata('message'); ?>
                                        </div>
                                <?php } ?>
                            </div>
                   
                    <form action="<?php echo base_url().$this->config->item('admin_folder').'/forgotpassword'?>" class="form" method="post">
                        <div class="form-group has-feedback">
                            <input type="username" class="form-control"  placeholder="Email id"  id="login-username"  name="admin_email">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        
                            <label>
                                <input type="checkbox" name="admin" id="admin">Check if admin
                            </label>
                        
                        
                            <div class="row">
                                <div class="col-xs-12">
                                     <button type="submit" name="submit" id="login-btn"  class="btn btn-primary btn-block btn-flat">Send Mail</button>
                                </div><!-- /.col -->
                            </div>
                    </form>

                <a href="<?php echo  base_url().$this->config->item('admin_folder').'/login'?>">Login</a><br>
                <!--<a href="register.html" class="text-center">Register a new membership</a>-->

                </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->
    </body>
<script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
<?php
include('footer.php');

?>