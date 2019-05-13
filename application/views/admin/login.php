<?php
include('header.php');
?>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
 
<body class="hold-transition login-page">
     
    <div class="login-box">
        <div class="login-logo"></div>
        <center>   
        <?php $image= base_url().LOGO_IMAGE.$site_data['0']['photo']; ?>
        <img  src="<?php echo $image ?>" width="100px" >
        </center>   
        <!-- /.login-logo -->
                <div class="login-box-body">
                        <center><h3> Welcome to Admin Panel</h3>  </center>
                        <p class="login-box-msg">Sign in to start your session</p>
                    
                    <div id="div_msg">
                    <?php include('flashmessage.php');                        
                    ?>
                    </div>  
                    <form action="<?php echo base_url().$this->config->item('admin_folder').'/login' ?>" method="post">
                   
                        <div class="form-group has-feedback">
                            <input type="username" class="form-control" placeholder="Email" required="" id="login-username" autofocus=""  name="username">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        
                            <div class="form-group has-feedback">
                                <input type="password" class="form-control" placeholder="Password" required="" id="login-password" name="password">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                        
                            <div class="row">
                                <div class="col-xs-8">
                                    <div class="checkbox icheck">
                                        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" name="remember_me" value="remember_me" id="remember_me"> Remember Me
                                        </label>                                      
                                    </div>
                                </div><!-- /.col -->
                                    <div class="col-xs-4">
                                       <button type="submit" name="submit" id="login-btn"  class="btn btn-primary btn-block btn-flat">Sign In</button>
                                    </div><!-- /.col -->                                        
                            </div>
                        
                    </form>
                 

              <a href="<?php echo  base_url().$this->config->item('admin_folder').'/forgotpassword'?>">I forgot my password</a><br>    

                </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->
  
  
<?php
include('footer.php');
?>
    <script src="<?php echo base_url()?>admin_assets/js/login.js"></script>
</body>