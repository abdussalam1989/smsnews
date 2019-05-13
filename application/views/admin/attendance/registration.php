<?php $this->load->view($this->config->item('admin_folder') . '/header'); ?>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->load->view($this->config->item('admin_folder') . '/header_menu'); ?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php $this->load->view($this->config->item('admin_folder') . '/aside'); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Attendance Register </h1>
                <div id="act_msg" ></div> 
                <div id="div_msg"> 
                    <?php $this->load->view($this->config->item('admin_folder') . '/flashmessage'); ?>
                </div>
                <ol class="breadcrumb">
                    <li><a href="<?php echo ADMIN_URL . '/dashboard'; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="<?php echo ADMIN_URL . '/attendance/registration'; ?>">Attendance Temp</a></li>
                    <li class="active"><?php echo $page_title; ?></li>
                </ol>
            </section>
            <section class="content">
                <div class="box box-primary">
                    <div class="row">
                        <div>
                            <div class="box-header">
                                <div class="col-md-3" ></div>
                                <label class="col-md-9"><span class="has-error"> 
                                    </span></label>
                                <span class="has-error"><?php echo $this->session->flashdata('error_msg'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <form method="POST" action="<?php echo ADMIN_URL ?>/attendance/registration">


                                <div class="col-md-2">
                                    <label>Select Class :</label>
                                </div>
                                <div class="col-md-3 form-group">
                                    <select name="class_name" class="form-control" id="class_name">
                                        <option value="" > Select </option>
                                        <?php foreach ($get_class_list as $class): ?>
                                            <option value="<?php echo $class['name']; ?>" <?php
                                            if (isset($select['class_name'])) {
                                                if ($select['class_name'] == $class['name']) {
                                                    ?> selected <?php
                                                        }
                                                    }
                                                    ?> > <?php echo $class['name']; ?></option>
                                                <?php endforeach; ?> 
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label> Select Month :</label>
                                </div>
                                <div class="col-md-3 form-group">
                                    <select name="month_name" class="form-control" id="class_name">
                                        <!--<option value="" > Select month </option>-->
                                        <option value="01" <?php
                                        if (isset($select['month_name'])) {
                                            if ($select['month_name'] == '01') {
                                                ?> selected="selected"<?php
                                                    }
                                                }
                                                ?> > Jan </option>
                                        <option value="02" <?php
                                        if (isset($select['month_name'])) {
                                            if ($select['month_name'] == '02') {
                                                ?> selected="selected"<?php
                                                    }
                                                }
                                                ?> > Feb </option>
                                        <option value="03" <?php
                                        if (isset($select['month_name'])) {
                                            if ($select['month_name'] == '03') {
                                                ?> selected="selected"<?php
                                                    }
                                                }
                                                ?> > March </option>
                                        <option value="04" <?php
                                        if (isset($select['month_name'])) {
                                            if ($select['month_name'] == '04') {
                                                ?> selected="selected"<?php
                                                    }
                                                }
                                                ?> > April</option>
                                        <option value="05" <?php
                                        if (isset($select['month_name'])) {
                                            if ($select['month_name'] == '05') {
                                                ?> selected="selected"<?php
                                                    }
                                                }
                                                ?> > May</option>
                                        <option value="06" <?php
                                        if (isset($select['month_name'])) {
                                            if ($select['month_name'] == '06') {
                                                ?> selected="selected"<?php
                                                    }
                                                }
                                                ?> > June</option>
                                        <option value="07" <?php
                                        if (isset($select['month_name'])) {
                                            if ($select['month_name'] == '07') {
                                                ?> selected="selected"<?php
                                                    }
                                                }
                                                ?> > July</option>
                                        <option value="08" <?php
                                        if (isset($select['month_name'])) {
                                            if ($select['month_name'] == '08') {
                                                ?> selected="selected"<?php
                                                    }
                                                }
                                                ?> > Aug</option>
                                        <option value="09" <?php
                                        if (isset($select['month_name'])) {
                                            if ($select['month_name'] == '09') {
                                                ?> selected="selected"<?php
                                                    }
                                                }
                                                ?> > Sep</option>
                                        <option value="10" <?php
                                        if (isset($select['month_name'])) {
                                            if ($select['month_name'] == '10') {
                                                ?> selected="selected"<?php
                                                    }
                                                }
                                                ?> > Oct</option>
                                        <option value="11" <?php
                                        if (isset($select['month_name'])) {
                                            if ($select['month_name'] == '11') {
                                                ?> selected="selected"<?php
                                                    }
                                                }
                                                ?> > Nov</option>
                                        <option value="12" <?php
                                        if (isset($select['month_name'])) {
                                            if ($select['month_name'] == '12') {
                                                ?> selected="selected"<?php
                                                    }
                                                }
                                                ?> > Dec</option>
                                    </select>
                                </div>

                                <div class="col-md-2 form-group">
                                    <button type="submit" name="submit" id="submit" class="btn btn-primary">View </button>
                                </div>
                            </form>   
                        </div><!-- /.col-->
                        <div class="col-md-3">
                            <a class="btn btn-primary " href="javascript:void(0)" onclick="printDiv('attendance_report')">Print Register</a>
                        </div>
                    </div><!-- ./row -->

                    <div id="attendance_report">
                        <h1><center> Attendance Register</h1> 
                        <?php
                        $maxDays = cal_days_in_month(CAL_GREGORIAN, $month, date('Y'));
                        $student_de_data = array();
                        $student_reg_data = array();
                        if ($get_list) {
                            foreach ($get_list as $data) {
                                $day = substr($data['adddate'], -2);
                                $student_reg_data[$data['student_id']][$day] = $data['attendance'];
                                $student_de_data[$data['student_id']]['name'] = $data['name'];
                                $student_de_data[$data['student_id']]['roll_no'] = $data['roll_no'];
                            }
                              $maxDays = cal_days_in_month(CAL_GREGORIAN, $month, date('Y'));
                        }
                      

                        $currentDayOfMonth = date('j');
                        ?>
                        <?php if (!$student_de_data) { ?>
                            <table id="" border='2' class="table table-bordered table-striped">
                                <thead> <tr>
                                        <th width='2%'>Roll no.</th>
                                        <th width='5%'>STUDENT NAME</th>
                                        <?php for ($i = 1; $i <= $maxDays; $i++) { ?>
                                            <th width="2%"><?php echo $i; ?></th> 
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tr>
                                    <td colspan="32">No Record Found </td>
                                </tr>
                            </table>
                            <?php
                        } else {
                            ?>  
                            <table id="" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width='2%'>Roll no.</th>
                                        <th width='5%'>STUDENT NAME</th>
                                        <?php for ($i = 01; $i <= $maxDays; $i++) { ?>
                                            <th width="1%"><?php echo $i; ?></th> 
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $cnt = 0;
                                    foreach ($student_de_data as $key => $elist) {
                                        ?>
                                        <tr> 
                                            <td><?php echo $elist['roll_no']; ?></td>
                                            <td><?php echo $elist['name']; ?> </td>
                                            <?php
                                            for ($i = 1; $i <= $maxDays; $i++) {
                                                //echo "%%".$i;
                                                if ($i == 1 || $i == 2 || $i == 3 || $i == 4 || $i == 5 || $i == 6 || $i == 7 || $i == 8 || $i == 9) {
                                                    $i = "0" . $i;
                                                }
                                                ?>
                                                <td width="2%"> 
                                                    <?php
                                                    if (array_key_exists($i, $student_reg_data[$key])) {
                                                        if ($student_reg_data[$key][$i] == 'P') {
                                                            echo '<span style="color:green ;">P</span>';
                                                        }
                                                        if ($student_reg_data[$key][$i] == 'A') {
                                                            echo '<span style="color: red ;">A</span>';
                                                        }
                                                    } else {
                                                        echo '<span style="color: black ;">-</span>';
                                                    }


                                                    //echo "<pre>";
                                                    //print_r($get_rec); exit;    
                                                    ?>
                                                </td>  
                                            <?php } ?>
                                        </tr>  
                                        <?php
                                        $cnt++;
                                    }
                                    ?>  

                                </tbody>
                            </table>
                        <?php } ?>
                    </div>                   
                </div><!-- /.box -->
            </section><!-- /.content -->        

        </div><!-- /.content-wrapper -->
        <!-- Add the sidebar's background. This div must be placed
             immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
    <?php $this->load->view($this->config->item('admin_folder') . '/footer'); ?>    
    <script type="text/javascript">
        function printDiv(divName) {
            // alert(divName);
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>

    <script>
        //for data table setting   
        $(function () {
            $('#example1').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                //"iDisplayLength": 25,

            });
        });
    </script>

</body>

</html>
