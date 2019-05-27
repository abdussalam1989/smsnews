//for data table setting   
$(document).ready(function() {
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
         "iDisplayLength": 100,
    });
    
   /* var table = $('#example1').DataTable({
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
            });
        
        $('#csv_class').on('change', function () {
                //alert($('#csv_class option:selected').text());
                //$("#yourdropdownid option:selected").text();
                table.columns(3).search($('#csv_class option:selected').text()).draw();
        });*/
}); 

  /*$('#get_class').cha(function () {
        var class_name=$('#get_class').val();
        $('#csv_class').val(class_name);
  });*/

    //for data table setting   
    $(function () {
            $('#check').DataTable({
                
                //"iDisplayLength": 25,
            });
        });
        //$.noConflict();
        
            //select all check box
            $("#ckbCheckAll2").click(function () {
                    $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            });
   
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

// JavaScript Document
var first_run = true;
var country_code = "";
var xhr1_postal;

$(function(){
    // Counting for the descriptions
    $('#text_message').keyup(function () {
        var len=$(this).val().length;
        var max = 160;
        $('#charLeftInput_wine_desc').text(len + ' characters.');
        if (len > max) {
            $('#charLeftInput_wine_desc').text(len + ' characters. more than 1 message send');
        }
    });
    
    //$('#charLeftInput_wine_desc').text('160 characters left');
    /*$('#text_message').keyup(function () {
        var max = 160;
        var len=$(this).val().length;
        var wine_name=$(this).val();
        if (len >= max) {
            $('#charLeftInput_wine_desc').text('0 characters');
            if(len > max){
                var ch= max  + 1;
                $('#charLeftInput_wine_desc').text(ch + ' total characters,160 character for 1 message');
            }
        } else {
            var ch = max - len;
            $('#charLeftInput_wine_desc').text(ch + ' characters left');
        }
    });*/
});
  
// For count the winery descriptions
if($('#text_message').val()!="") {
    $('#text_message').trigger('keyup');
}

// select sms template value and print message   
$('.select_template').click(function(){ 
    var name=$(this).val();
    $('#text_message').html(name);
});

function updateTextArea() {
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