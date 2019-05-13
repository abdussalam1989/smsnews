function required_fun(ele,msg){
	
	var id = $(ele).attr("id");
	if(!$.trim($(ele).val()).length){
		$('#'+id+'_err').html(msg);
		$(ele).addClass('form-control-error');	
		$(ele).removeClass('form-control-success');
	}
	else{
		//alert('else');
		var filter = /\<|>/;
		if (filter.test($(ele).val())) {
			//alert('here');
			$('#'+id+'_err').html('Please provide a valid data.');
			$(ele).addClass('form-control-error');
			$(ele).removeClass('form-control-success');
		}
		else    {
			$('#'+id+'_err').html('');
			$(ele).addClass('form-control-success');
			$(ele).removeClass('form-control-error');	
		}
	}
}
function req_fun(ele,msg){
	
	var id = $(ele).attr("id");
	if(!$.trim($(ele).val()).length){
		$('#'+id+'_err').html(msg);
		$(ele).addClass('form-control-error');	
		$(ele).removeClass('form-control-success');
	}
	else{
                $('#'+id+'_err').html('');
                $(ele).addClass('form-control-success');
                $(ele).removeClass('form-control-error');	
		
	}
}
function valid_str(ele){
	//alert('in func');
	var id = $(ele).attr("id");
	if($.trim($(ele).val()).length){
		var filter =/\<|>/;
		if (filter.test($(ele).val())) {
			//alert('here');
			$('#'+id+'_err').html('Please provide a valid data.');
			$(ele).addClass('form-control-error');
			$(ele).removeClass('form-control-success');
		}
		else{
			$('#'+id+'_err').html('');
			$(ele).addClass('form-control-success');
			$(ele).removeClass('form-control-error');	
		}
	}
	
}
function check_mob(ele){
	var id = $(ele).attr("id");
	if(!$.trim($(ele).val()).length){
		
		$('#'+id+'_err').html('Please enter mobile number.');
		$(ele).addClass('form-control-error');	
		$(ele).removeClass('form-control-success');
	}
	else{
		
		var phoneno = /^\d{10}$/;  
		if(!($(ele).val().match(phoneno)))  
		{  
		  $('#'+id+'_err').html('Not a valid mobile number.');
		  $(ele).addClass('form-control-error');	
		  $(ele).removeClass('form-control-success');
		}
		else{
			$('#'+id+'_err').html('');
			$(ele).addClass('form-control-success');
			$(ele).removeClass('form-control-error');	
		} 
	}
}
function check_ph(ele){
	var id = $(ele).attr("id");
	
	if(isNaN($(ele).val()))  
	{  
	  $('#'+id+'_err').html('Not a valid home contact number.');
	  $(ele).addClass('form-control-error');	
	  $(ele).removeClass('form-control-success');
	}
	else{
		if($(ele).val().length>11){
			$('#'+id+'_err').html('Not a valid home contact number.');
	  		$(ele).addClass('form-control-error');	
	  		$(ele).removeClass('form-control-success');
		}
		else{
			$('#'+id+'_err').html('');
			$(ele).addClass('form-control-success');
			$(ele).removeClass('form-control-error');	
		}
	} 
	
}
function check_email(ele){
	var id = $(ele).attr("id");
	if(!$.trim($(ele).val()).length)	
	{
		$('#'+id+'_err').html('Please enter email id.');
		$(ele).addClass('form-control-error');
		$(ele).removeClass('form-control-success');
	}
	else{
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!filter.test($(ele).val())) {
			$('#'+id+'_err').html('Please provide a valid email id.');
			$(ele).addClass('form-control-error');
			$(ele).removeClass('form-control-success');
		}
		else{
			$('#'+id+'_err').html('');
			$(ele).addClass('form-control-success');
			$(ele).removeClass('form-control-error');	
		}
	}
}
function check_email1(ele){
	var id = $(ele).attr("id");
	if($.trim($(ele).val()).length)	
	{
		
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!filter.test($(ele).val())) {
			$('#'+id+'_err').html('Please provide a valid email id.');
			$(ele).addClass('form-control-error');
			$(ele).removeClass('form-control-success');
		}
		else{
			$('#'+id+'_err').html('');
			$(ele).addClass('form-control-success');
			$(ele).removeClass('form-control-error');	
		}
	}
}
function is_num(ele){
	
	var id = $(ele).attr("id");
	if($.trim($(ele).val()).length){
	if(isNaN($(ele).val()))  
	{  
	  
	  $('#'+id+'_err').html('Please enter digits only.');
	  $(ele).addClass('form-control-error');	
	  $(ele).removeClass('form-control-success');
	}
	else{
		$('#'+id+'_err').html('');
		$(ele).addClass('form-control-success');
		$(ele).removeClass('form-control-error');	
	}
	}
}
function is_num1(ele,msg){
	var id = $(ele).attr("id");
	
	if(!$.trim($(ele).val()).length)	
	{
		$('#'+id+'_err').html(msg);
		$(ele).addClass('form-control-error');
		$(ele).removeClass('form-control-success');
	}
	else{
		if(isNaN($(ele).val()))  
		{  
		  $('#'+id+'_err').html('Please enter digits only.');
		  $(ele).addClass('form-control-error');	
		  $(ele).removeClass('form-control-success');
		}
		else{
			$('#'+id+'_err').html('');
			$(ele).addClass('form-control-success');
			$(ele).removeClass('form-control-error');	
		}
	}
}