function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah')
                  .attr('src', e.target.result)
                  .width(90)
                  .height(90);
                };
        reader.readAsDataURL(input.files[0]);
        }
}
$(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor1');
       
      });
      
$(document).ready(function(){
            //alert('hello');
            var max_fields=100;//maximum input boxes allowed
            var wrapper=$(".input_fields_wrap"); //Fields wrapper
            var add_button=$(".add_field_button"); //Add button ID
    
            var x = 0; //initlal text box count
            $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
                if(x<max_fields){ //max input box allowed
                    //text box increment id="img_'+ x +'"
                    $(wrapper).append('<div class="input-group"><lable >Add Image :</lable>\n\
                    <input type="file" class="form-control" name="userfile[]" value="" id="userfile[]"/>\n\
                    <a href="#" class="remove_field"><i class="fa fa-close"> </i></a></div>'); //add input box
                    x++;
                    }
                    $('#getButtonValue').val(x);
                });
    
            $(wrapper).on("click",".remove_field", function(e){ 
                //user click on remove text
                e.preventDefault(); $(this).parent('div').remove();
                x--;
            });
    
});

$('.delete_img').click(function(e){
  /* var r = confirm("Are you sure you want to delete ?");
        if (r == true) 
        {*/
            var id=$(this).attr('id');
            //alert(id);
                $.ajax({
                    type:"POST",
                    url: ADMIN_URL + '/Property/ajax_delete_img' + '/' + id ,
                    data:"id=" + id ,
                    success: function(data){
                        if(data){
                            // $(this).hide()
                            $('#img_'+id).hide();
                            //setTimeout(function() { $('#act_msg').hide(); }, 3000);
                           // $('#act_msg').html( '<div  class="alert alert-success"><strong>Image </strong> Delete Successfully !! </div>').show();
                            //alert('Deleted');
                            //$(this).parents('div').hide();
                            //location.reload();

                        }
                    }
                });
        /*} 
        else
        {
            return false;
        }*/

});