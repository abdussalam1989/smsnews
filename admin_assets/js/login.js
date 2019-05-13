 $(function() {

    if (localStorage.chkbx && localStorage.chkbx != '') {
        $('#remember_me').attr('checked', 'checked');
        $('#login-username').val(localStorage.usrname);
        $('#login-password').val(localStorage.pass);
    } else {
        $('#remember_me').removeAttr('checked');
        $('#login-username').val('');
        $('#login-password').val('');
    }

    $('#remember_me').click(function() {

        if ($('#remember_me').is(':checked')) {
            // save username and password
            localStorage.usrname = $('#login-username').val();
            localStorage.pass = $('#login-password').val();
            localStorage.chkbx = $('#remember_me').val();
        } else {
            localStorage.usrname = '';
            localStorage.pass = '';
            localStorage.chkbx = '';
        }
    });
});

//hide flash message in few seconds
setTimeout(function() 
{   
    $('#div_msg').fadeOut('slow');
}, 4000);
