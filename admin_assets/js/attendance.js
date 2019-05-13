$('#class_name').click(function(){      
    var class_name=($('#class_name').val());
        $.ajax({
            type: "POST",
            url: '<?php echo base_url().$this->config->item("admin_folder")?>/attendance/get_class_list/' + class_name,
            data: 'class_name=' + class_name,
            success: function(data){
                if(data)
                {   
                    $('#attendance_report').html(data);
                }
            },
    });
});