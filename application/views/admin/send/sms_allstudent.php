<?php $this->load->view($this->config->item('admin_folder') . '/header'); ?>
<style> .ab { color: blue; } .size { alignment-adjust: center; } </style>
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
                <div class="box box-primary">
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <div class="box-header">
                                <div class="col-md-3"></div>
                                <label class="col-md-9"><span class="has-error"> 
                                    </span></label>
                                <span class="has-error"><?php echo $this->session->flashdata('error_msg'); ?></span>
                            </div>
                            <div class="box-body">
                                <form role="form" method="POST" enctype="multipart/form-data" action="<?php echo ADMIN_URL ?>/Sendsmsallstud/allstudents" onsubmit="return confirmation()">  
                                    <div class="form-group">
                                        <input type="radio" name="sms_type" id="Instant" value="Instant" checked="checked"> Instant Message
                                    </div>

                                    <div class="form-group">
                                        <input type="radio" name="sms_type" id="sms_type" value="Schedule"   > Schedule Message on :
                                        <input type="text" name="schedule_date" id="datetimepicker1" >  
                                    </div>                            
                                    <div class="form-group">
                                        <textarea class="form-control" style="height: 150px;" required="required" name="message" id="text_message" placeholder="Messsage"></textarea>   
                                        <input type="checkbox" name="alt_check" id="alt_check"> if send sms using alternate number <br>
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
                                            <textarea name="select_template" id="select_template" style="height: 100px;"  readonly="readonly" class="form-control select_template"><?php echo $sms['template_text']; ?></textarea> <br />
                                            <?php
                                        endforeach;
                                    }
                                    ?> 
                                </div>

                            </div>
                        </div><!-- /.col-->
                        <div class="col-md-4"></div>
                    </div><!-- /.box --> 
                    <div>


                        </section><!-- /.content -->
                    </div>  <!-- /.content-wrapper -->
                    <!-- Add the sidebar's background. This div must be placed
                    immediately after the control sidebar -->
                    <div class="control-sidebar-bg"></div>
                </div><!-- ./wrapper -->


                <?php $this->load->view($this->config->item('admin_folder') . '/footer'); ?>

                <script src="<?php echo base_url() ?>admin_assets/js/data.js"></script>
                <script src="<?php echo base_url() ?>admin_assets/js/sms.js"></script>

                </body>
                </html>
				
<script type="text/javascript">
$(function () {
    var nMaxLength = 305; //set the characters length
	var tlength=nMaxLength-$('#text_message').val().length;
	$('.remaining').text('Remaining : '+tlength);
    $("#text_message").keydown(function (event) {
        LimitCharacters($(this));
    });
    $("#text_message").keyup(function (event) {
        LimitCharacters($(this));
    });
    function LimitCharacters(description) {
        if (description.val().length > nMaxLength) {
            description.val(description.val().substring(0, nMaxLength));
        } else {
            var nRemaining = nMaxLength - description.val().length;
			if($('#text_message').val().length>160){
               $('.remaining').text('2 Message, Remaining : '+nRemaining);
			} else {
				$('.remaining').text('Remaining : '+nRemaining);
			}
        }
    }
});
</script>

