<?php $this->load->view($this->config->item('admin_folder') . '/header'); ?>
<style> .ab { color: blue; } .size { alignment-adjust: center; }
</style>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php $this->load->view($this->config->item('admin_folder') . '/header_menu'); ?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php $this->load->view($this->config->item('admin_folder') . '/aside'); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1><?php echo $page_title; ?> </h1>
                <div id="act_msg"></div> 
                <div id="div_msg"> 
                    <?php $this->load->view($this->config->item('admin_folder') . '/flashmessage'); ?>
                </div>
                <ol class="breadcrumb">
                    <li><a href="<?php echo ADMIN_URL . '/dashboard'; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="<?php echo ADMIN_URL . '/send'; ?>">Send Sms </a></li>
                    <li class="active"><?php echo $page_title; ?></li>
                </ol>
            </section>

            <section class="content">

                <div class="row">
                    <div class="col-md-7">
                        <div class="box box-primary">
                            <div class="box-body">
                                <form action="<?php echo ADMIN_URL ?>/send/getclass" enctype="multipart/form-data" method="POST">    
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2">
                                        <label>Class :</label>
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <select name="class_name" class="btn btn-default" id="class_name" onchange='this.form.submit()'>
                                            <option value="select">Select </option>
                                            <option value="All"  <?php
                                            if (isset($class_value)) {
                                                if ('All' == $class_value) {
                                                    ?> selected="selected" <?php
                                                        }
                                                    }
                                                    ?>  > All</option>
                                                    <?php foreach ($get_class_list as $class): ?>
                                                <option value="<?php echo $class['id']; ?>" <?php
                                                if (isset($class_value)) {
                                                    if ($class['name'] == $class_value) {
                                                        ?> selected="selected" <?php
                                                            }
                                                        }
                                                        ?>  > <?php echo $class['name']; ?></option>
                                                    <?php endforeach; ?> 
                                        </select>
                                    </div>

                                    <noscript><input type="submit" value="Submit"></noscript>
                                    <div class="col-md-6"></div>
                                    <div id="student_list" class="col-md-12">

                                        <?php if (empty($get_student_list)) { ?>
                                            <table id="example2" class="table table-bordered table-striped">
                                                <thead> <tr>
                                                        <th width="5%">Roll no. </th>
                                                        <th>STUDENT ID</th>
                                                        <th>STUDENT NAME</th>
                                                        <th>FATHER NAME</th> 
                                                        <th>FATHER MOBILE NO.</th>
                                                        <th id="fir" width="3%"><input type="checkbox" id="ckbCheckAll3" name="head_checkbox"></th>
                                                        <!--<th>Alt NO.</th>
                                                        <th id="fir_two" width="3%"><input type="checkbox" id="ckbCheckAll4" value="" name="head_checkbox"></th>-->
                                                    </tr></thead>
                                            </table>
                                        <?php } else { ?>  
                                            <table id="example2" class="table table-bordered table-striped">
                                                <thead> 
                                                    <tr>
                                                        <th width="5%">Roll no. </th>
                                                        <th>STUDENT ID</th>
                                                        <th>STUDENT NAME</th>
                                                        <th>FATHER NAME</th> 
                                                        <th>FATHER MOBILE NO.</th>
                                                        <th id="mydiv" width="3%"><input type="checkbox" id="ckbCheckAll2" value='' name="head_checkbox"></th>
                                                        <!--<th>Alt NO.</th>
                                                        <th id="mydivtwo" width="3%"><input type="checkbox" id="ckbCheckAll4" value=' ' name="head_checkbox"></th>-->
                                                    </tr></thead>
                                                <tbody>
                                                    <?php
                                                    $cnt = 1;
                                                    foreach ($get_student_list as $student) {
                                                        ?>
                                                        <tr>  
                                                            <td><?php echo $student['roll_no']; ?></td> 
                                                            <td><?php echo $student['admission_no']; ?></td>  
                                                            <td><?php echo $student['name']; ?></td>  
                                                            <td><?php echo $student['father_name']; ?></td>
                                                            <td><?php echo $student['mobile_no']; ?></td>
                                                            <!--<td><div id="mydiv"><input type="checkbox" name="mul_id" class="checkBoxClass" value="<?php
                                                            if (!empty($student['roll_no'])) {
                                                                echo $student['roll_no'] . '(' . $student['name'] . ')';
                                                            }
                                                            ?> "></div></td>-->

                                                            <td><div id="mydiv"><input type="checkbox" name="mul_id" class="checkBoxClass" value="<?php echo  $student['name']." ".$student['mobile_no'] ?> "></div></td>

                                                            <!--<td><?php // echo $student['alternate_no']; ?></td>

                                                            <td><div id="mydivtwo"><input type="checkbox" name="mul_id" class="checkBoxClasstwo" value="<?php
                                                                  /*  if (!empty($student['alternate_no'])) {
                                                                        echo $student['alternate_no'] . '(' . $student['name'] . ')';
                                                                    } */
                                                                    ?> "></div></td> -->
                                                        </tr>  
                                                        <?php
                                                        $cnt++;
                                                    }
                                                    ?>  
                                                </tbody>
                                            </table>
                                        <?php } ?>
                                    </div>

                                    <div class="form-group">
                                        <!-- <button type="submit" name="submit" id="submit" class="btn btn-primary">Get List</button> -->
                                    </div>
                                </form>    
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="box box-primary">
                            <div class="box-body">
                                <form role="form" method="POST" enctype="multipart/form-data" action="<?php echo ADMIN_URL ?>/Sendtostud/stud" onsubmit="return validateForm()">         
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <input type="radio" name="sms_type" id="sms_type" value="Instant" checked="checked" >
                                                <label for="sms_type"> Instant Message</label>
                                            </div>
                                            <div class="col-md-6">   
                                                <input type="radio" name="sms_type" id="schedule_message" value="Schedule">
                                                <label for="schedule_message"> Schedule Message on</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="schedule_message_datetimepicker" style="display:none">
                                        <input type="text" class="form-control" name="schedule_date" id="datetimepicker1"  value="">  
                                    </div>

                                    <div class="form-group"> 
                                        <div class="row">
                                            <label for="message_for" class="col-md-4"> Message For :</label>
                                            <div class="col-md-8">                                               
                                                <select name="msg_for" class="form-control" id="message_for">
                                                    <?php foreach ($get_msg_for as $get_msg) { ?>
                                                        <?php
                                                        if ($get_api_status['status_two'] == 'Active') {
                                                            if ($get_msg['for_name'] != 'None') {
                                                                ?>  <option value="<?php echo $get_msg['for_name'] ?>" > <?php echo $get_msg['for_name']; ?></option> <?php
                                                            }
                                                        } else {
                                                            ?>
                                                            <option value="<?php echo $get_msg['for_name'] ?>" <?php if ($get_msg['for_name'] == 'None') { ?> selected="selected" <?php } ?> > <?php echo $get_msg['for_name']; ?></option>
                                                        <?php } ?>
                                                    <?php } ?>                                    
                                                </select> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group"> 
                                        <div class="row">
                                            <label for="language" class="col-md-4">Language:</label>
                                            <div class="col-md-8">
                                                <select name="language" class="form-control" id="language" >
                                                <?php
												if($get_api_status['language_option']==1) 
												{
												?>
                                                    <option value="eng" > English</option> 
                                                    <option value="hindi" > Hindi</option>
                                                <?php
												} else { ?>
												<option value="eng" > English</option>
												<?php }
                                                 ?>	
                                                </select> 
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <textarea name="mobile_no" id="mobile_no" required="required" class="form-control mobile_number" placeholder="Mobile Number" required></textarea>   
                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" name="admission_no" id="admission_no"/>
                                    </div>



                                    <div class="form-group">
                                        <textarea class="form-control" required="required" style="height: 150px;" name="message" id="text_messagee" placeholder="Messsage">Dear Parents, </textarea>   
                                        <span class="static_value">[name]</span> <span class="static_value">[class]</span> <span class="static_value">[rollno]</span> <span class="static_value">[todaydate]</span>
                                        <!-- 160 Characters left start -->
                                        <!--<div class="charLeftInput" id="charLeftInput_wine_desc"></div>-->
										<div class="charLeftInput remaining"></div>
										
                                        <!-- 160 Characters left end -->
                                    </div>     


                                    <div class="form-group">
                                        <button type="submit" name="submit" id="submit" class="btn btn-primary" >Send Now</button>
                                    </div>
                                    <div id="targetLayer" ></div>
                                </form>

                                <form method="POST" enctype="multipart/form-data" action="<?php echo ADMIN_URL ?>/send/tiny_url/" >
                                    <div class="col-md-7 form-group">
                                        <input type="file" name="photo" id="photo">  
<!--                                        <input type="hidden" name="current_url" id="current_url" value="<?php echo current_url(); ?>">-->
                                    </div>
                                    <div class="col-md-5">
                                        <button type="button" name="submit" id="uploadForm" class="btn btn-primary">Save</button>
                                    </div>    
                                </form>    
                                <div class="col-md-12 form-group">
                                    Select Message Template :
                                    <?php if (empty($get_sms_template)) { ?>
                                        <b> No Template found </b>
                                        <?php
                                    } else {
                                        foreach ($get_sms_template as $sms):
                                            ?>
                                            <textarea name="select_template" style="height: 100px;" id="select_template" readonly="readonly" class="form-control select_template"><?php echo $sms['template_text']; ?></textarea> <br />
                                            <?php
                                        endforeach;
                                    }
                                    ?> 
                                </div>

                            </div>
                        </div><!-- /.col-->
                        <div class="col-md-1"></div>
                    </div><!-- ./row -->
                    <div>

                    </div>
                </div><!-- /.box -->
            </section><!-- /.content -->

        </div><!-- /.content-wrapper -->
        <!-- Add the sidebar's background. This div must be placed
             immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <?php $this->load->view($this->config->item('admin_folder') . '/footer'); ?>

    <script src="<?php echo base_url() ?>admin_assets/js/data.js"></script>
    <script src="<?php echo base_url() ?>admin_assets/js/sms.js"></script>
    <script src="<?php echo base_url(); ?>admin_assets/js/send_sms.js"></script>
</body>
</html>

<script type="text/javascript">
$(function () {
    var nMaxLength = 305; //set the characters length
	var tlength=nMaxLength-$('#text_messagee').val().length;
	$('.remaining').text('Remaining : '+tlength);
    $("#text_messagee").keydown(function (event) {
        LimitCharacters($(this));
    });
    $("#text_messagee").keyup(function (event) {
        LimitCharacters($(this));
    });
    function LimitCharacters(description) {
        if (description.val().length > nMaxLength) {
            description.val(description.val().substring(0, nMaxLength));
        } else {
            var nRemaining = nMaxLength - description.val().length;
			if($('#text_messagee').val().length>160){
               $('.remaining').text('2 Message, Remaining : '+nRemaining);
			} else {
				$('.remaining').text('Remaining : '+nRemaining);
			}
        }
    }
});
</script>
