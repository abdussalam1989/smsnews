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
    });
    $('#example1_report').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": false,
        "ordering": false,
        "scrollX": true,
        "info": true,
        "autoWidth": false,
    });
    $('#example2_report').DataTable({
        "paging": false,
        "lengthChange": true,
        "searching": false,
        "scrollX": true,
        "ordering": false,
        "info": true,
        "autoWidth": false
    });
    $('#sms_report').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": false,
        "ajax": "reportajax",
        "order": [],
        "ordering": false,
        "deferLoading": 57
    });
    /*  $('#all_student').DataTable({
     "processing": true,
     "serverSide": true,
     "searching": false,
     "ajax": "ajaxstudent",
     "order": [],
     "ordering": false,
     "deferLoading": 57
     });
     
     $('#sms_to_student').DataTable({
     "processing": true,
     "serverSide": true,
     "searching": false,
     "ajax": "ajax_send_student",
     "order": [],
     "ordering": false,
     "deferLoading": 57
     });*/

    $(".active").trigger("click");
});
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


$("#ckbCheckAll2").change(function(){
    if(this.checked){
      $(".checkBoxClass").each(function(){
        this.checked=true;
      })              
    }else{
      $(".checkBoxClass").each(function(){
        this.checked=false;
      })              
    }
  });

  $(".checkBoxClass").click(function () {
    if ($(this).is(":checked")){
      var isAllChecked = 0;
      $(".checkBoxClass").each(function(){
        if(!this.checked)
           isAllChecked = 1;
      })              
      if(isAllChecked == 0){ $("#ckbCheckAll2").prop("checked", true); }     
    }else {
      $("#ckbCheckAll2").prop("checked", false);
    }
  });
//select all check box
$("#ckbCheckAll4").click(function () {
    $(".checkBoxClasstwo").prop('checked', $(this).prop('checked'));
});
//for single delete record in manage list
function delete_rec(id, $del_url) {
    //alert(ADMIN_URL);
    //var admin_url=json_encode(ADMIN_URL);
    var r = confirm("Are you sure you want to delete ?");
    if (r == true) {
        window.location = ADMIN_URL + $del_url + id;
    } else {
        return false;
    }
}

// JavaScript Document
var first_run = true;
var country_code = "";
var xhr1_postal;
$(function () {
    // Counting for the descriptions
    $('#text_message').keyup(function () {
        var len = $(this).val().length;
        var max = 160;
        $('#charLeftInput_wine_desc').text(len + ' characters.');
        if (len > max) {
            $('#charLeftInput_wine_desc').text(len + ' characters. more than 1 message send');
        }
    });
});
// For count the winery descriptions
if ($('#text_message').val() != "") {
    $('#text_message').trigger('keyup');
}

// select sms template value and print message   
$('.select_template').click(function () {
    $('#text_messagee').append($(this).val());
});
// after astutesixface change
$(function () {

    $('.static_value').click(function () {
        var text = $(this).html();
        $('#text_messagee').val(function (_, val) {
            return val + text;
        });
        $('#text_messagee').focus()
    });
    if ($('#text_messagee').length) {
        $('#text_messagee').on("propertychange click change blur keyup paste", function () {
            var len = $('#text_messagee').val().length;
            var max = 160;
            $('#charLeftInput_wine_desc').text(len + ' characters.');
            if (len > max) {
                $('#charLeftInput_wine_desc').text(len + ' characters. more than 1 message send');
            }            
        });
    }

});
$(function () {

    $("input[name='sms_type']").change(function () {
        if ($('#schedule_message').is(":checked")) {
            $('#schedule_message_datetimepicker').show();
        } else {
            $('#schedule_message_datetimepicker').hide();
        }
    });
    var words = ['Dear Staff,', 'Dear Student,', 'Dear Teacher,', 'Dear Parents,'];
    $('#language,#message_for').change(function () {
        var lang = $('#text_messagee');
        var type = $('#message_for').val();
        var textarea_prefix = '';
        if (type == 'Staff') {
            textarea_prefix = 'Dear Staff, ';
        }
        if (type == 'Student') {
            textarea_prefix = 'Dear Student, ';
        }
        if (type == 'Teacher') {
            textarea_prefix = 'Dear Teacher, ';
        }
        if (type == 'Parents') {
            textarea_prefix = 'Dear Parents, ';
        }
        if ($('#language').val() !== 'eng') {
            var lang_data = lang.val().replace(textarea_prefix, "");
            lang.val(lang_data);
        } else {
            var text = lang.val();
            for (var i = 0, len = words.length; i < len; i++) {
                if (text.indexOf(words[i]) > -1) {
                    console.log('match', words[i]);
                    lang_data = lang.val().replace(words[i], "");
                    lang.val(lang_data);
                }
            }
            var re = new RegExp(textarea_prefix, 'gi');
            lang.val(lang.val().replace(re, ''));
            lang.val(textarea_prefix + lang.val());
        }

    });
});
function updateTextArea() {
    var allval = [];
    $('#mydiv :checked').each(function () {
        if ($(this).val() != "") {
            allval.push($(this).val());
        }
    });
    $('#mydivtwo :checked').each(function () {
        //alert($(this).val());
        if ($(this).val() != " ") {
            allval.push($(this).val());
        }
    });
    $('.mobile_number').val(allval)
}
$(function () {
    $('#mydiv input').click(updateTextArea);
    $('#mydivtwo input').click(updateTextArea);
    updateTextArea();
});
function validateForm(theForm) {

    characters_count();

    if ($('#language').val() === 'eng') {
        var problem_desc = document.getElementById("text_messagee");
        if ($.trim(problem_desc.value.substr(0, 14)) == 'Dear Parents,' || $.trim(problem_desc.value.substr(0, 12)) == 'Dear Staff,' || $.trim(problem_desc.value.substr(0, 14)) == 'Dear Student,' || $.trim(problem_desc.value.substr(0, 14)) == 'Dear Teacher,') {
            var r = confirm("Are you sure you want to send sms?");
            if (r == true) {
                return true;
            } else {
                return false;
            }
            //    alert("Please Write Problem Description");
            return true;
        } else {
            var type = $('#message_for').val();
            var textarea_prefix = '';
            if (type == 'Staff') {
                textarea_prefix = 'Dear Staff,';
            }
            if (type == 'Student') {
                textarea_prefix = 'Dear Student,';
            }
            if (type == 'Teacher') {
                textarea_prefix = 'Dear Teacher,';
            }
            if (type == 'Parents') {
                textarea_prefix = 'Dear Parents,';
            }

            alert("Please Start SMS text with '" + textarea_prefix + "[space]'");
            problem_desc.focus();
            return false;
        }
    }


}


function updateTextArea1() {
    var rollNo = [];
    $('#mydiv :checked').each(function () {
        if ($(this).val() != "") {
            var roll_name_contact = $(this).val();
            var result = roll_name_contact.split('~');
            var roll_no = result[0];
            //alert(roll_no);  
            rollNo.push(roll_no);
        }
    });
    $('#admission_no').val(rollNo)
}
$(function () {
    $('#mydiv input').click(updateTextArea1);
    updateTextArea1();
    characters_count();
});
function characters_count() {

    if ($('#language').length) {
        var problem_desc = document.getElementById("text_messagee");
        if ($('#language').val() === 'eng') {
            var max = 305;
        } else {
            var max = 135;
        }
        var len = $('#text_messagee').val().length;
        $('#charLeftInput_wine_desc').text(len + ' characters.');
        if (len > max) {
            alert("You reach the maximum characters count, please reduce and send");
            problem_desc.focus();
            return false;
        }
    }
}
   