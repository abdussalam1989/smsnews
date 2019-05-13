<?php include('header.php') ?>
<script type="text/javascript">

function validatechangepassword()
{
	var flag=0;
	var old_passwd = $('#old_passwd').val();
	var passwd = $('#passwd').val();
	var c_passwd = $('#c_passwd').val();
	
	if(!$.trim(old_passwd).length)	
	{
		$('#old_passwd_err').html('Please enter old password.');
		$('#old_passwd').addClass('form-control-error');
		$('#old_passwd').removeClass('form-control-success');
		flag=1;
	}
	else
	{
			$('#old_passwd_err').html('');
			$('#old_passwd').addClass('form-control-success');
			$('#old_passwd').removeClass('form-control-error');	
	}

	if(!$.trim(passwd).length)	
	{
		$('#passwd_err').html('Please enter password.');
		$('#passwd').addClass('form-control-error');
		$('#passwd').removeClass('form-control-success');
		flag=1;
	}
	else
	{
		$('#passwd_err').html('');
		$('#passwd').addClass('form-control-success');
		$('#passwd').removeClass('form-control-error');	
	}

	if(!$.trim(c_passwd).length)	
	{
		$('#c_passwd_err').html('Please enter confirm password.');
		$('#c_passwd').addClass('form-control-error');
		$('#c_passwd').removeClass('form-control-success');
		flag=1;
	}
	else
	{
		$('#c_passwd_err').html('');
		$('#c_passwd').addClass('form-control-success');
		$('#c_passwd').removeClass('form-control-error');	
	}
	

	if($.trim($('#old_passwd').val()).length || $.trim($('#passwd').val()).length || $.trim($('#c_passwd').val()).length)
	{
		if(!$.trim($('#old_passwd').val()).length)	
		{
			$('#old_passwd_err').html('Please enter your old password.');
			$('#old_passwd').addClass('form-control-error');
			$('#old_passwd').removeClass('form-control-success');
			flag = 1;
		}
		else{
			var passhash1 = CryptoJS.MD5(old_passwd).toString();
			if(passhash1 != '<?php echo $admin_details['password']?>'){
				$('#old_passwd_err').html('You have entered wrong old password.');
				$('#old_passwd').addClass('form-control-error');
				$('#old_passwd').removeClass('form-control-success');
				flag=1;
			}
			else{
				$('#old_passwd_err').html('');
				$('#old_passwd').addClass('form-control-success');
				$('#old_passwd').removeClass('form-control-error');	
			}
			
		}
		if(!$.trim($('#passwd').val()).length)	
		{
			$('#passwd_err').html('Please enter your new password.');
			$('#passwd').addClass('form-control-error');
			$('#passwd').removeClass('form-control-success');
			flag = 1;
		}
		else{
			if(passwd == '<?php echo base64_decode($admin_details['password'])?>'){
				$('#passwd_err').html('You have entered old password.');
				$('#passwd').addClass('form-control-error');
				$('#passwd').removeClass('form-control-success');
				flag=1;
			}
			else{
				$('#passwd_err').html('');
				$('#passwd').addClass('form-control-success');
				$('#passwd').removeClass('form-control-error');	
			}
		}
		if(!$.trim($('#c_passwd').val()).length)	
		{
			$('#c_passwd_err').html('Please enter confirm password.');
			$('#c_passwd').addClass('form-control-error');
			$('#c_passwd').removeClass('form-control-success');
			flag = 1;
		}
		else{
			if($('#c_passwd').val() != $('#passwd').val()){
				$('#c_passwd_err').html('Confirm password does not match with password.');
				$('#c_passwd').addClass('form-control-success');
				$('#c_passwd').removeClass('form-control-error');
				flag = 1;
			}
			else{
				$('#c_passwd_err').html('');
				$('#c_passwd').addClass('form-control-success');
				$('#c_passwd').removeClass('form-control-error');
			}
		}
	}
	
	if(flag == 1){
		
		return false;
	}
	else{
		
		return true;
	}
	
}
function c_password_fun(){
	var passwd = $('#passwd').val();
	var c_passwd = $('#c_passwd').val();
	if(!$.trim(c_passwd).length)	
	{
		$('#c_passwd_err').html('Please enter password.');
		$('#c_passwd').addClass('form-control-error');
		$('#c_passwd').removeClass('form-control-success');
		
	}
	else{
		if(passwd != c_passwd){
			$('#c_passwd_err').html('Confirm password doesn\'t matches with password.');
			$('#c_passwd').addClass('form-control-error');
			$('#c_passwd').removeClass('form-control-success');
			
		}
		else{
			$('#c_passwd_err').html('');
			$('#c_passwd').addClass('form-control-success');
			$('#c_passwd').removeClass('form-control-error');	
		}
	}
}
function password_fun(){
	var passwd = $('#passwd').val();
	if(!$.trim(passwd).length)	
	{
		$('#passwd_err').html('Please enter password.');
		$('#passwd').addClass('form-control-error');
		$('#passwd').removeClass('form-control-success');
		
	}
	else{
		if(passwd == '<?=md5($admin_details['password'])?>'){
			$('#passwd_err').html('You have entered old password.');
			$('#passwd').addClass('form-control-error');
			$('#passwd').removeClass('form-control-success');
			
		}
		else{
			$('#passwd_err').html('');
			$('#passwd').addClass('form-control-success');
			$('#passwd').removeClass('form-control-error');	
		}
	}
}
function old_passwd_fun(){
	if(!$.trim($('#old_passwd').val()).length)	
		{
			$('#old_passwd_err').html('Please enter your old password.');
			$('#old_passwd').addClass('form-control-error');
			$('#old_passwd').removeClass('form-control-success');
			
		}
		else{
			var passhash = CryptoJS.MD5($('#old_passwd').val()).toString();
			if(passhash != '<?php echo $admin_details['password']?>'){
				
				$('#old_passwd_err').html('You have entered wrong old password.');
				$('#old_passwd').addClass('form-control-error');
				$('#old_passwd').removeClass('form-control-success');
				
			}
			else{
				$('#old_passwd_err').html('');
				$('#old_passwd').addClass('form-control-success');
				$('#old_passwd').removeClass('form-control-error');	
			}
			
		}
}

</script>
<script type="text/javascript">
    setTimeout(function() {
    $('#div_msg').fadeOut('slow');
     }, 4000);
</script>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
            <?php include('header_menu.php');?>
            <!-- Left side column. contains the logo and sidebar -->
            <?php include('aside.php')?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1><?php echo $page_title; ?></h1>
                    <div id="div_msg">
                        <?php include('flashmessage.php'); ?>
                        <?php if( validation_errors() != null) { ?>
                                <div class="alert alert-danger">
                                <?php echo validation_errors(); ?>
                                </div>
                        <?php } if(isset($custom_error) || $custom_error != null ) { ?>
                                <div class="alert alert-danger">
                                <?php echo $custom_error; ?>
                                </div>
                        <?php } ?>
                    </div>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo ADMIN_URL.'/dashboard'?>"><i class="fa fa-dashboard"></i>Home</a></li>
                        <li><a href="<?php echo ADMIN_URL.'/Profile/changepassword'?>">Setting</a></li>
                        <li class="active"><?php echo $page_title; ?></li>
                    </ol>
                </section>
                
                
 
        <section class="content">
        <div class="box box-primary">
        <div class="row">
            <div class="col-sm-3"></div>
        <div class="col-md-6">
                    <div class="box-header ">
                        <!--<h3 class="box-title">Change Password</h3> -->
                    </div><!-- /.box-header -->
                  <!-- form start -->
                  <form class="form-horizontal" method="POST" action="<?php echo ADMIN_URL?>/Profile/changepassword" onSubmit="return validatechangepassword()">
                        <div class="box-body">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">OldPassword :</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" id="old_passwd"  name="old_passwd" placeholder="Old Password" onBlur="old_passwd_fun();">
                                                <div class="has-error">
                                                    <label class="control-label" id="old_passwd_err"></label>
                                                </div>
                                        </div>
                            </div>
                            

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">NewPassword :</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" id="passwd" name="passwd"  placeholder="New Password" onBlur="password_fun();"/>
                                                <div class="has-error">
                                                    <label class=" control-label" id="passwd_err"></label>
                                                </div>
                                        </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Confirm Password :</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" id="c_passwd" name="c_passwd"   placeholder="Confirm Password" value="<?php if(!empty($paypal)) { echo $paypal['password']; }?>" onBlur="c_password_fun();"/>
                                                <div class="has-error">
                                                    <label class=" control-label" id="c_passwd_err"></label>
                                                </div>
                                        </div>
                                </div>                                

                            <div class="col-md-3"></div>
                            <div class="col-sm-9 form-group">
                                <button type="submit" name="submit" class="btn btn-primary ">Change Password</button>
                            </div><!-- /.box-footer -->
                        </form>
                   </div><!-- /.box-body -->
           <!-- general form elements disabled -->
           <!-- /.box -->
         </div> 
            <div class="col-md-3"></div>
            <!--/.col (right) -->
          </div>   <!-- /.row -->
          </div><!-- /.box -->
        </section><!-- /.content -->
        </div> 
    </div><!-- ./wrapper -->
</body>
<?php include('footer.php')?>