 //for data table setting   
$(function () {
        $('#example1').DataTable({
           "paging": true,
           "lengthChange": true,
           "searching": true,
           "scrollX": true,
           "ordering": true,
           "info": true,
           "fnDrawCallback": function (oSettings) {
                  $('[name="boot_btn"]').bootstrapSwitch();
            },
           "autoWidth": false,
           //"iDisplayLength": 25,
           "aoColumns": [
               { "bSortable": false },    
               null,
               null,
               null,
               null,
               { "bSortable": false }
           ]
        });
});
    
//select all check box
$("#ckbCheckAll2").click(function () {
        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
});