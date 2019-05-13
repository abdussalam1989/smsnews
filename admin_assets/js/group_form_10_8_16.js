
function selectedgrp(grp_member,data_id){
    //var class_name=($('#grp_member').val());
    var class_name=grp_member;
    //var class_id=($('#data_id').val());
    var class_id=data_id;
    
    //alert(class_name);
    $.ajax({
            type: "POST",
            url: ADMIN_URL + '/group/get_member_list/' + class_name + '/' + class_id,
            data: 'class_name=' + class_name + '&class_id=' + class_id,
            success: function(data){
                $('#student_list').html(data);
                
                $("#ckbCheckAll2").click(function () {
                        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
                });
                
                $('#example1').DataTable({
                    "paging": false,
                    "lengthChange": true,
                    "searching": true,
                    "scrollX": true,
                    "ordering": true,
                    "info": false,
                    "autoWidth": false,
                    //"iDisplayLength": 25,
                });
        },
    });
}
    

/*$('#select_member').change(function(){      
    var class_name=($('#select_member').val());
    var class_id=($('#data_id').val());
    
    if(class_name=='teacher'){
        $('#datalist').hide();
    }
    
        $.ajax({
            type: "POST",
            url: ADMIN_URL + '/group/get_member_list/' + class_name + '/' + class_id,
            data: 'class_name=' + class_name + '&class_id=' + class_id,
            success: function(data){*/
               /* if(class_name=='student'){
                    $('#student_list_select').html(data);
                } else {
                    $('#student_list').html(data);
                }*/
                /* $('#student_list').html(data);
                 $("#ckbCheckAll2").click(function () {
                        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
                });
                
                $('#example1').DataTable({
                    "paging": false,
                    "lengthChange": true,
                    "searching": true,
                    "scrollX": true,
                    "ordering": true,
                    "info": false,                   
                    "autoWidth": false,
                    //"iDisplayLength": 25,
                });
                
        },
    });
});*/


$('#select_member').change(function(){      
	//alert('Aftab Siddiqui');
    var class_name=($('#select_member').val());
    var class_id=($('#data_id').val());
    $('#datalist').show();
    if(class_name=='teacher'){
        $('#datalist').hide();
    }
    
        $.ajax({
            type: "POST",
            //url: ADMIN_URL + '/group/get_member_list/' + class_name + '/' + class_id,
            url: ADMIN_URL + '/group/get_class_list/' + class_name + '/' + class_id,
            data: 'class_name=' + class_name + '&class_id=' + class_id,
            success: function(data){
				//alert(data);
               /* if(class_name=='student'){
                    $('#student_list_select').html(data);
                } else {
                    $('#student_list').html(data);
                }*/
                //$('#student_list').html(data);
                $('#datalist').html(data);
                $("#ckbCheckAll2").click(function () {
                        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
                });
                
                $('#example1').DataTable({
                    "paging": false,
                    "lengthChange": true,
                    "searching": true,
                    "scrollX": true,
                    "ordering": true,
                    "info": false,                   
                    "autoWidth": false,
                    //"iDisplayLength": 25,
                });
                
        },
    });
});


function getstudentlist(class_name)
{
    $('#datalist').show();
    
    var class_id=($('#data_id').val());
    //alert('hello prashant');
    $.ajax({
            type: "POST",
            url: ADMIN_URL + '/group/get_class_list/' + class_name + '/' + class_id,
            data: 'class_name=' + class_name + '&class_id=' + class_id,
            success: function(data){
                
                $('#datalist').html(data);
                $("#ckbCheckAll2").click(function () {
                        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
                });
                
                $('#example1').DataTable({
                    "paging": false,
                    "lengthChange": true,
                    "searching": true,
                    "scrollX": true,
                    "ordering": true,
                    "info": false,
                    "fnDrawCallback": function (oSettings) {
                           $('[name="boot_btn"]').bootstrapSwitch();
                    },
                    "autoWidth": false,
                    //"iDisplayLength": 25,
                });
                
        },
    });
}

function getstudentclasslist(class_name,class_id){
    $('#datalist').show();
    
   // var class_name=($('#grp_class_id').val());
   // var class_id=($('#data_id').val());
    //alert('hello prashant');
    //alert(class_name);
    $.ajax({
            type: "POST",
            url: ADMIN_URL + '/group/get_class_list/' + class_name + '/' + class_id,
            data: 'class_name=' + class_name + '&class_id=' + class_id,
            success: function(data){
                
                $('#datalist').html(data);
                $("#ckbCheckAll2").click(function () {
                        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
                });
                
                $('#example1').DataTable({
                    "paging": false,
                    "lengthChange": true,
                    "searching": true,
                    "scrollX": true,
                    "ordering": true,
                    "info": false,
                    "fnDrawCallback": function (oSettings) {
                           $('[name="boot_btn"]').bootstrapSwitch();
                    },
                    "autoWidth": false,
                    //"iDisplayLength": 25,
                });
                
        },
    });
}