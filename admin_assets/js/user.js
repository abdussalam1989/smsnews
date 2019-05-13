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
                       $('[name="boot_btnn"]').bootstrapSwitch();
                 },
                "autoWidth": false,
                //"iDisplayLength": 25,
                /*"aoColumns": [
                    { "bSortable": false },    
                    null,
                    null,
                    null,
                    null,
                    { "bSortable": false }
                ]*/
            });
        });
        
        //$.noConflict();
        
            //select all check box
            $("#ckbCheckAll2").click(function () {
                    $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            });
    
  // for bootstrap switch button single active or inactive
$('[name="boot_btnn"]').on('switchChange.bootstrapSwitch', function (event, data) {
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
                            window.location.reload();
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
                            window.location.reload();
                        } 
                        else 
                        {
                            //alert('else call');
                        }
                    },
                });
            }
});