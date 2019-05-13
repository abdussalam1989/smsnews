
// Display datatable
$(function () {
        $('#example1').DataTable({ 
            
            "paging": true,
            "bPaginate": false,
            "lengthChange": true,
            "searching": true,
            "scrollX": true,
            "ordering": true,
            "info": true,
            "fnDrawCallback": function (oSettings) {
                   $('[name="boot_btn"]').bootstrapSwitch();
            },
            "autoWidth": false,
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

/*$('#example').dataTable({
    "fnDrawCallback": function(oSettings) {
        if ($('#example1 tr').length < 1) {
            $('.dataTables_paginate').hide();
        }
    }
}); */        
         
        
            
