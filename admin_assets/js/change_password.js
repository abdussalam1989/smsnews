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
			if(passhash1 != '<?php echo $admin_details["password"]?>'){
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
			if(passwd == '<?php echo base64_decode($admin_details["password"])?>'){
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
		if(passwd == '<?=md5($admin_details["password"])?>'){
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
			if(passhash != '<?php echo $admin_details["password"]?>'){
				
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
