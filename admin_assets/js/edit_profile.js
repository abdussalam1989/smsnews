$('#del_img').click(function(){
//alert(id);
     var id= $("#get_id").val();
     var img_nm= encodeURIComponent($("#hidphoto").val());
         $.ajax({
             type:"POST",
             url: ADMIN_URL + '/profile/ajax_delete_img' + '/'  + img_nm  + '/' + id ,
             data:"img_nm=" + img_nm + "&id=" + id ,
             success : function(data){
                 if(data){
                     $('#blah').hide();
                     location.reload(); 
                     setTimeout(function() { $('#act_msg').hide(); }, 3000);
                     $('#act_msg').html( '<div  class="alert alert-success"><strong>Image </strong> Delete Successfully !! </div>').show();

                     //alert('Deleted');
                 }
             }
         });
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#blah')
            .attr('src', e.target.result)
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
                url: ADMIN_URL + '/profile/ajax_state_list' + '/' + country_id,
                data: country_id = 'country_id',
                    success: function(state){
                        //alert(state);
                        $('#get_state').html(state);
                    },
        });
}
           
function getcitydetails(id)
{
        $.ajax({
                type: "POST",
                url: ADMIN_URL + '/profile/ajax_city_list' + '/' +id,
                data: id='state_id',
                    success: function(data){
                        $('#get_city').html(data);
                    },
        });
}
            
function selectstate()
{   
        var country_id = document.getElementById('old_country').value; 
        var admin_state_id = document.getElementById('state').value; 
                $.ajax({
                    type: 'POST',
                    url: ADMIN_URL + '/profile/ajax_select_state' + '/' + country_id  + '/' + admin_state_id ,
                    data: 'country_id=' + country_id + '&admin_state_id=' + admin_state_id ,
                        success: function(data){
                            $('#get_state').html(data);
                        },
                });
}

function selectcity()
{
        var admin_state_id = document.getElementById('state').value; 
        var admin_city_id = document.getElementById('city').value; 
            $.ajax({
                    type: 'POST',
                    url:  ADMIN_URL + '/profile/ajax_select_city' + '/' + admin_state_id  + '/' + admin_city_id ,
                    data:  '&admin_state_id=' + admin_state_id + '&admin_city_id=' + admin_city_id ,
                        success: function(data){
                            $('#get_city').html(data);
                        },
            });
}
    