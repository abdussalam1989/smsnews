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

function readURLL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blahh')
                .attr('src', e.target.result)
                .width(90)
                .height(90);
                };
                    reader.readAsDataURL(input.files[0]);
        }
} 