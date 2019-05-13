/*$('#class_name').change(function(){      
    var class_name=($('#class_name').val());
        $.ajax({
            type: "POST",
            url: ADMIN_URL + '/send/get_class_list/' + class_name,
            data: 'class_name=' + class_name,
            success: function(data){
                $('#student_list').html(data);
        },
    });
});*/

$('.select_template').click(function(){ 
        var name=$(this).val();
        $('#text_message').html(name);
});

/*function updateTextArea() {
    var allval=[];
    $('#mydiv :checked').each(function () {
        allval.push($(this).val());
    });
    $('.mobile_number').val(allval)
}
$(function () {
    $('#mydiv input').click(updateTextArea);
    updateTextArea();
});
*/

/*$('.checkBoxClass').click(function(){ 
        var name=$(this).val();
        var value=$('.mobile_number').val();
        $('.mobile_number').text(value + name);
});*/

//select all check box
/*$("#ckbCheckAll3").click(function () {
    //$(".checkBoxClass").prop('checked', $(this).prop('checked'));
});*/

/*$('.checkBoxClass').click(function(){ 
        var name=$(this).val();
        alert(name);
        $('.mobile_number').text(name);
});*/


/*$('.checkBoxClass').click(function(){
    var val = [];
    $(':checkbox:checked').each(function(i){
        val[i] = $(this).val();     
        $('#mobile_number').html(val[i]);
    });
});
*/


/*$(function(){ 
    callback();
});
function callback(data){
    $('#student_list').html(data);
    $('.mul_id').bind('click', function(e) {});
}*/
