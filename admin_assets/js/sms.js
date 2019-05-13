$('#datetimepicker1').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        format: 'yyyy-mm-dd hh:ii',
        showMeridian: 1
    });
    
function confirmation()
{  
        //alert(ADMIN_URL);
        //var admin_url=json_encode(ADMIN_URL);
        
        var r = confirm("Are you sure you want to send sms?");
        if (r == true) {
           return true;
        } else {
            return false;
        }
}   
    
//check email is valid or not   
/*$('#fileupload').click(function(){
        //alert('key up event call');
        var image=encodeURIComponent($('#photo').val());
        var current_url=encodeURIComponent($('#current_url').val());
       // alert(email);
        //var email=$('#email').val();
        //alert(ADMIN_URL);
            $.ajax({
                    type: "POST",
                    dataType:"json",
                    url: ADMIN_URL + '/send/tiny_url/' + image + '/' + current_url,
                    data: 'image=' + image + '&current_url=' + current_url,
                    success: function(data){
                        //alert('all ready exits');
                        if(data)
                        {
                            $('#act_msg').html( '<div>Please Enter Valid Email id !! </div>').show();
                        }
                    },
            });
}); */

$("#uploadForm").click(function(){
    //e.preventDefault();
    var formData = new FormData();
    formData.append('photo', $('input[type=file]')[0].files[0]);
    $.ajax({
        beforeSend: function(xhr) { 
            $("#targetLayer").html('<div class="form-control"><center> <b> File Uploading.... </b></div>');
        },
        url: ADMIN_URL + '/send/tiny_url/',
        type: "POST",
        //data:  new FormData(this),
        data: formData,
        contentType: false,
        cache: false,
        processData:false,
        success: function(data){
            $("#targetLayer").html('<div class="form-control"> <b> URL : </b>'+ data + '</div>');
    },
    error: function(){} 	        
    });
});
