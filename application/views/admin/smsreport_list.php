<?php include('header.php') ?>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include('header_menu.php') ?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php include('aside.php') ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1><?php echo $page_title; ?> </h1>
                <div id="act_msg" ></div> 
                <div id="div_msg"> 
                    <?php include('flashmessage.php'); ?>
                </div>
                <ol class="breadcrumb">
                    <li><a href="<?php echo ADMIN_URL . '/dashboard'; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="<?php echo ADMIN_URL . '/send'; ?>">Send Sms </a></li>
                    <li class="active"><?php echo $page_title; ?></li>
                </ol>
            </section>

            <section class="content">
                <div class="box box-primary">
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-11">

                            <div class="box-header">
                                <div class="col-md-3" ></div>
                                <label class="col-md-9"><span class="has-error"> 
                                    </span></label>
                                <span class="has-error"><?php echo $this->session->flashdata('error_msg'); ?></span>
                            </div>

                            <form action="<?php echo ADMIN_URL ?>/sms/report" method="POST">
                            <!--<div class="col-md-12"><b>From:</b> <input type="text" name="first_date" id="datepicker"> <b>To:</b> <input type="text" name="second_date" id="datepicker2">  <button type="submit" name="submit" id="submit" class="btn btn-primary">&nbsp; Search &nbsp;</button></div>-->
                                <div class="row">
                                    <!--<div class="col-md-1"> <b>From:</b></div>-->
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="first_date" placeholder="Enter From Date" id="datepicker" value="<?php echo $this->input->post('first_date'); ?>">
                                    </div>
                                    <!--<div class="col-md-1"> <b>TO:</b></div>-->
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="second_date" placeholder="Enter End Date" id="datepicker2" value="<?php echo $this->input->post('second_date'); ?>">
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <input type="text" name="mb_no" class="form-control"  placeholder="Mobile number" id="mb_no" value="<?php echo $this->input->post('mb_no'); ?>"> 
                                    </div>
									<div class="col-md-2 form-group">
									<select name="status" id="status" class="btn btn-default">
                                            <option value="">Select Search Status</option>
                                            <option <?php
                                            if ($form_status == "Delivered") {
                                                echo 'selected';
                                            }
                                            ?> value="Delivered">Delivered</option>
											<option <?php
                                            if ($form_status == "Scheduled") {
                                                echo 'selected';
                                            }
                                            ?> value="Scheduled">Scheduled</option>
                                            <option <?php
                                            if ($form_status == "failure") {
                                                echo 'selected';
                                            }
                                            ?> value="failure">failure</option>
                                        </select>
									</div>
									<div class="col-md-2">
                                        <button type="submit" name="submit" style="margin:0px 0px 0px 36px" id="submit" class="btn btn-primary">&nbsp; Search &nbsp;</button>
                                    </div>
                                </div>
                                </br>
                                <!--<div class="row" >
                                    <div class="col-md-3"> <b>Search Status:</b></div>
                                    <?php $form_status = $this->input->post('status'); ?>
                                    <div class="col-md-4 form-group ">
                                        <select name="status" placeholder="Status" id="status" class="btn btn-default">
                                            <option value="">Select</option>
                                            <option <?php
                                            if ($form_status == "Delivered") {
                                                echo 'selected';
                                            }
                                            ?> value="Delivered">Delivered</option>
											<option <?php
                                            if ($form_status == "Scheduled") {
                                                echo 'selected';
                                            }
                                            ?> value="Scheduled">Scheduled</option>
                                            <option <?php
                                            if ($form_status == "failure") {
                                                echo 'selected';
                                            }
                                            ?> value="failure">failure</option>
                                        </select>



                          <input type="text" name="status"  placeholder="Status" id="mb_no" value=""> 
                                    </div>



                                    <div class="col-md-1">
                                        <button type="submit" name="submit" id="submit" class="btn btn-primary">&nbsp; Search &nbsp;</button>
                                    </div>
                                </div>-->
                            </form>    
                        </div><!-- /.col-->
                        <div class="col-md-2">

                        </div>
                    </div>
                </div><!-- ./row -->
                <div class="row">
                    <div class="col-md-12">


                        <div class="box box-primary">
                            <div class="box-body">
                                <h1><center>SMS Report</h1>

                                <table id="sms_report1" class="display table table-bordered table-striped" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>STATUS</th>
                                            <th>DATE</th>
                                            <th>TIME</th>
                                            <th>CLASS NAME</th>
                                            <th>ROLL NO.</th>
                                            <th>MESSAGE</th>
                                            <th>MOBILE NO.</th>
                                            <th>MSG COUNT</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div><!-- /.box -->
                    </div>
                </div>
            </section><!-- /.content --> 
        </div><!-- /.content-wrapper -->
        <!-- Add the sidebar's background. This div must be placed
             immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <?php include('footer.php'); ?>
    <script src="<?php echo base_url() ?>admin_assets/js/data.js"></script>

    <link href="<?php echo base_url() ?>admin_assets/css/datatables/tools/css/dataTables.tableTools.css" rel="stylesheet">

    <script src="<?php echo base_url() ?>admin_assets/js/datatables/tools/js/dataTables.tableTools.js"></script>
    <script>
        $(document).ready(function () {
            $("#datepicker").datepicker({maxDate: 0, dateFormat: 'yy-mm-dd'});
            $("#datepicker2").datepicker({maxDate: 0, dateFormat: 'yy-mm-dd'});
            $("#datepicker3").datepicker({maxDate: 0, dateFormat: 'yy-mm-dd'});
        });



    </script>
    <script>
        var asInitVals = new Array();
        $(document).ready(function () {
            var oTable = $('#sms_report1').dataTable({
                "oLanguage": {
                    "sSearch": "Search all columns:"
                },
                "aoColumnDefs": [
                {
                        'bSortable': false,
                        'aTargets': [0, 1]
                } //disables sorting for column one
                ],
                "processing": true,
                "serverSide": true,
                "searching": false,
                "ajax": {
                    "url": "reportajax",
                    "data": function (d) {
                        d.mobile_number = $('#mb_no').val();
                        d.first_date = $('#datepicker').val();
                        d.second_date = $('#datepicker2').val();
                        d.msg_status = $('#status option:selected').val();
                        // d.custom = $('#status').val();
                        // etc
                    }
                },
                "order": [],
                "ordering": false,
                //"deferLoading": 57,
                'iDisplayLength': 50,
                "sPaginationType": "full_numbers",
                "dom": 'T<"clear">lfrtip',
                "tableTools": {
                    "sSwfPath": '<?php echo base_url() ?>admin_assets/js/datatables/tools/swf/copy_csv_xls_pdf.swf'
                }
            });
            $('input').on('keyup change', function () {
                oTable.fnDraw();
            });
            $('select').on('change', function () {
                oTable.fnDraw();
            });
            //            $("input").keyup(function () {
            //                /* Filter on the column based on the index of this element's parent <th> */
            //                oTable.fnFilter(this.value, $("tfoot th").index($(this).parent()));
            //            });
            $("tfoot input").each(function (i) {
                asInitVals[i] = this.value;
            });
            $("tfoot input").focus(function () {
                if (this.className == "search_init") {
                    this.className = "";
                    this.value = "";
                }
            });
            $("tfoot input").blur(function (i) {
                if (this.value == "") {
                    this.className = "search_init";
                    this.value = asInitVals[$("tfoot input").index(this)];
                }

            });
        });
    </script>



</body>

</html>
