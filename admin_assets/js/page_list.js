  //for data table setting   
    $(function () {
             $('#example1').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "scrollX": true,
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
         
        
        //$.noConflict();
        
//select all check box
$("#ckbCheckAll2").click(function () {
        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
});
          
$(function () {
           // Replace the <textarea id="editor1"> with a CKEditor
           // instance, using default configuration.
           CKEDITOR.replace('editor1');

       });
