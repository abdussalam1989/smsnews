
<style type='text/css'>

    .highlighte { background-color: white; }
    .highlight { background-color: red; }

</style>
<script type='text/javascript'>

    $('#example1').DataTable({
        'paging': false,
        'lengthChange': true,
        'searching': false,
        'scrollX': true,
        'ordering': true,
        'info': true,
        'autoWidth': false
    });

    function rowHighlight(obj) {
        if (obj.checked) {
            obj.parentNode.parentNode.className = 'highlight';
        } else {

            obj.parentNode.parentNode.className = 'highlight';

        }
    }
    function rowHlight(obj) {
        if (obj.checked) {
            obj.parentNode.parentNode.className = 'highlighte';
        } else {

            obj.parentNode.parentNode.className = 'highlighte';

        }
    }
</script>
<h1><center>Take Attendance of class <?php echo $cl_nm['name']; ?></h1>
<table id="example1" class="table table-bordered ">
    <thead>
        <tr>

            <th width="15%">STUDENT ROLL NO</th> 
            <th>STUDENT NAME</th>
            <th>ATTENDANCE</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $cnt = 0;
        if (empty($get_student_list)) {
            ?>
            <tr>

                <td colspan="3"><b>Sorry No Record Found</b></td>
                <td ></td>
            </tr>  
            <?php
        } else {
            foreach ($get_student_list as $student) {
                ?>
                <tr>

                    <td><?php echo $student['roll_no']; ?></td>
                    <td><?php echo $student['name']; ?></td>
            <input type="hidden" name="student_name[]" id="student_name" value=<?php echo $student['name']; ?> >
            <input type="hidden" name="student_id<?php echo $cnt; ?>" id="student_id" value=<?php echo $student['id']; ?> >
            <input type="hidden" name="class_name" id="class_name" value=<?php echo $classname; ?> >
            <td ><input type="radio" name="student_att<?php echo $cnt; ?>" value="P" onChange="rowHlight(this);" id="isPresent" onclick="changereverse()" checked="checked">P &nbsp; &nbsp; <input type="radio" name="student_att<?php echo $cnt; ?>" onclick="changeColor()" onChange="rowHighlight(this);" value="A" id="isabsent" > A</td>
        </tr>  
        <?php
        $cnt++;
    }
}
?>
</tbody>
</table>
<div class="form-group" style="alignment-adjust: central"><input type="submit" name="submit" class="btn btn-primary" value="Submit Attendance"> </div>
