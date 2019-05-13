function getrollno(class_id)
{
        //alert('this id value :'+id);
        $.ajax({
                type: "POST",
                url: ADMIN_URL + '/student/ajax_rollno' + '/'  + class_id,
                data: country_id = 'class_id',
                    success: function(data){
                        //alert(state);
                        $('#roll_no').html(data);
                    },
        });
}