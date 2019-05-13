$(document).ready(function() {
       //alert('ddss');
         $("#mul_val").change(function() {
             if($(this).val()==""){
                 $('#action_submit').hide();
             } else {
                 $('#action_submit').show();
             }
         });
 });

//hide flash message in few seconds
setTimeout(function() 
{   
    $('#div_msg').fadeOut('slow');
}, 4000);

//for single delete record in manage list
function delete_rec(id,$del_url)
{           
        //alert(ADMIN_URL);
        //var admin_url=json_encode(ADMIN_URL);
        var r = confirm("Are you sure you want to delete ?");
        if (r == true) {
            window.location= ADMIN_URL + $del_url + id;
        } else {
            return false;
        }
}

// for bootstrap switch button single active or inactive
$('[name="boot_btn"]').on('switchChange.bootstrapSwitch', function (event, data) {
        var id=$(this).attr('id'); 
        var path=$(this).val();
            //alert(ADMIN_URL);
            if(data==true)
            {   
                $.ajax({
                type: "POST",
                url: ADMIN_URL + path + id + '/' + data,
                data: 'id=' + id + '&status=' + data,
                success: function(data){
                        //var check_val = $('#act_msg').html(data);
                        if(data) 
                        {
                            setTimeout(function() { $('#act_msg').hide(); }, 3000);
                            $('#act_msg').html( '<div  class="alert alert-success"><strong>Status </strong> Active Successfully !! </div>').show();
                        }
                        else 
                        {
                            //alert('else call');
                        }
                    },
                });
            }
            else
            {
                $.ajax({
                type: "POST",
                url: ADMIN_URL + path + id + '/' + data,
                data: 'id=' + id + '&status=' + data,
                success: function(data){
                        //var check_val = $('#act_msg').html(data);
                        if(data)
                        {
                            setTimeout(function() { $('#act_msg').hide(); }, 3000);
                            $('#act_msg').html( '<div  class="alert alert-success"><strong>Status </strong> Inctive Successfully !! </div>').show();
                        } 
                        else 
                        {
                            //alert('else call');
                        }
                    },
                });
            }       
});

$(function () {
        $('#example2').DataTable({
           "paging": false,
           "lengthChange": true,
           "searching": false,
           "scrollX": true,
           "ordering": true,
           "info": true,
           "autoWidth": false
        });
});

/*$(function () {
        $('#example1').DataTable({
           "paging": false,
		   "lengthMenu": [120, 25, 50, "All"],
           "lengthChange": true,
           "searching": false,
           "scrollX": true,
           "ordering": true,
           "info": true,
           "autoWidth": false
        });
});*/