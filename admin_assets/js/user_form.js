//alert('uesr_form');
//for check password is valid or Not
/*$('input[type="password"]').keyup(function(){      
    //alert('this is password functon');
    //alert(ADMIN_URL);
    var password=encodeURIComponent($('#password').val());
    var url=$(this).attr('id');
    alert();
    //alert(url);
        $.ajax({
            type: "POST",
            dataType:"json",
            url: '<?php echo base_url().$this->config->item("admin_folder")?>/user/check_password/' + password,
            data: 'password' + password,
            success: function(data){
                //alert('all ready exits');
                if(data)
                {
                    setTimeout(function() { $('#pass_msg').hide(); }, 5000);
                    $('#pass_msg').html( '<div>Required min 8 character one digit,lower-case,upper-case </div>').show();
                }
            },
        });
});*/

//check email is valid or not   
$('#email').keyup(function(){
        //alert('key up event call');
        var email=encodeURIComponent($('#email').val());
        //var email=$('#email').val();
        //alert(ADMIN_URL);
            $.ajax({
                    type: "POST",
                    dataType:"json",
                    url: ADMIN_URL + '/user/check_email_val/' + email,
                    data: 'email=' + email,
                    success: function(data){
                        //alert('all ready exits');
                        if(data)
                        {
                            setTimeout(function() { $('#act_msg').hide(); }, 4000);
                            $('#act_msg').html( '<div>Please Enter Valid Email id !! </div>').show();
                        }
                    },
            });
    });

//check email is exits or not
$('input[name="email"]').change(function(){
     //alert('key up event call');
     var email=encodeURIComponent($('#email').val());
     //var email=$('#email').val();
         $.ajax({
                    type: "POST",
                    dataType:"json",
                    url: ADMIN_URL + '/user/check_email/' + email,
                    data: 'email=' + email,
                        success: function(data){
                        //alert('all ready exits');
                        if(data)
                        {
                            //alert('email ');
                            setTimeout(function() { $('#act_msg').hide(); }, 5000);
                            $('#act_msg').html( '<div>Email id is all ready exits </div>').show();
                        }
                 },
            });
     });
     
 //check username is exits or not
$('#user_name').change(function(){ 
    var username=encodeURIComponent($('#user_name').val());
     //var email=$('#email').val();
         $.ajax({
                    type: "POST",
                    dataType:"json",
                    url: ADMIN_URL + '/user/check_username/' + username,
                    data: 'username=' + username,
                        success: function(data){
                        //alert('all ready exits');
                        if(data)
                        {
                            //alert('email ');
                            setTimeout(function() { $('#user_msg').hide(); }, 5000);
                            $('#user_msg').html( '<div>Username all ready exits </div>').show();
                        }
                 },
            });
     });    
  

function readURL(input) 
{
    if (input.files && input.files[0]) 
    {
            var reader = new FileReader();
                    reader.onload = function (e) 
                    {
                        $('#blah')
                        .attr ('src', e.target.result)
                        .width(90)
                        .height(90);
                    };
            reader.readAsDataURL(input.files[0]);
    }
}

function readURLL(input) 
{
    if (input.files && input.files[0]) 
    {
            var reader = new FileReader();
                    reader.onload = function (e) 
                    {
                        $('#blahh')
                        .attr ('src', e.target.result)
                        .width(90)
                        .height(90);
                    };
            reader.readAsDataURL(input.files[0]);
    }
}
function getstatedetails(country_id)
{
        //alert('this id value :'+id);
        $.ajax({
                type: "POST",
                url: ADMIN_URL + '/User/ajax_state_list' + '/'  + country_id,
                data: country_id = 'country_id',
                    success: function(state){
                        //alert(state);
                        $('#get_state').html(state);
                    },
        });
}
            
    function selectstate()
    {   
            var country_id = document.getElementById('old_country').value; 
            var user_state_id = document.getElementById('state').value; 
                $.ajax({
                    type: 'POST',
                    url: ADMIN_URL + '/User/ajax_select_state' + '/' + country_id  + '/' + user_state_id ,
                    data: 'country_id=' + country_id + '&user_state_id=' + user_state_id ,
                        success: function(data){
                            $('#get_state').html(data);
                        },
                });
    }
            
function selectcity()
{      
        var user_state_id = document.getElementById('state').value; 
        var user_city_id = document.getElementById('city').value; 
            $.ajax({
                    type: 'POST',
                    url: ADMIN_URL + '/User/ajax_select_city' + '/' + user_state_id  + '/' + user_city_id ,
                    data:  '&user_state_id=' + user_state_id + '&user_city_id=' + user_city_id ,
                    success: function(data){
                        $('#get_city').html(data);
                    },
            });
}

