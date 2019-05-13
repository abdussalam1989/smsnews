
<?php if (empty($get_list)) { ?>
    <table id="example2" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%">NO. </th>
                <th>SMS STATUS</th>
                <th>DATE</th>
                <th>TIME</th>
                <th width="20%">MESSAGE</th> 
                <!--<th width="8%">File</th>--> 
                <th>MOBILE NO.</th>
                <th>MSG COUNT</th>
            </tr>
        </thead>
    </table>
<?php } else { ?>  

    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%">NO. </th>
                <th>SMS STATUS</th>
                <th>DATE</th>
                <th>TIME</th>
                <th width="20%">MESSAGE</th> 
                <!--<th width="8%">File</th>--> 
                <th>MOBILE NO.</th>
                <th>MSG COUNT</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $cnt = 1;
            $del_url = '/Contact/delete/';
            foreach ($get_list as $elist) {
                ?>
                <tr>  
                    <td><?php echo $cnt; ?></td> 
                    <td><?php echo $elist['msg_status']; ?></td>
                    <td><?php echo date("Y-m-d", strtotime($elist['adddate'])); ?></td>
                    <td><?php echo $elist['addtime']; ?></td>  
                    <td><?php echo $elist['message']; ?></td>
                    <!--<td><?php echo $elist['upd_file']; ?></td>-->  
                    <td><?php echo $elist['mobile_no']; ?></td>
                    <td><?php echo $elist['count_msg']; ?></td>
                </tr>  
                <?php
                $cnt++;
            }
            ?>  
        </tbody>
    </table>
<?php } ?>

<script>
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
    });
</script>