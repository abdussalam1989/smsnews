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
                    <li><a href="<?php echo ADMIN_URL . '/send'; ?>"> Send Sms </a></li>
                    <li class="active"><?php echo $page_title; ?></li>
                </ol>
            </section>

            <section class="content">
              
                    <div class="row">
                        <div class="col-md-7">
                              <div class="box box-primary">
                           
                                   <br>
                                   <div class="col-md-2"></div>
                                    
                                     <form action="<?php echo ADMIN_URL ?>/Send/getClassgroup" enctype="multipart/form-data" method="POST">
                                    <div class="col-md-6 form-group">
                                         <label>Class Group :</label>
                                        <select name="class_name" class="btn btn-default" id="class_name" onchange='this.form.submit()'>                                            
                                            <option value="All" <?php if($class_group_id=='All') { echo "selected=selected";}?>> All </option>
                                            <option value="1" <?php if($class_group_id=='1') { echo "selected=selected";}?>> Nursery </option>
                                            <option value="2" <?php if($class_group_id=='2') { echo "selected=selected";}?>> Primary </option>
                                            <option value="3" <?php if($class_group_id=='3') { echo "selected=selected";}?>> Secondary </option>
                                            <option value="4" <?php if($class_group_id=='4') { echo "selected=selected";}?>> Sr. Secondary </option>
                                                
                                        </select>
                                    </div>
                                    </form>

                                 <form role="form" method="POST" enctype="multipart/form-data" action="<?php echo ADMIN_URL ?>/Sendsmsclass/class_sms" onsubmit="return validateForm()"> 
                                <?php if (empty($get_group_list)) {                           									
								?>
								
                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead> <tr>
                                                <th width="5%">NO. </th>
                                                <th>CLASS NAME</th>
                                                <th id="fir" width="3%"><input type="checkbox" id="ckbCheckAll2" name="head_checkbox"></th>
                                            </tr></thead>
                                    </table>
                                <?php } else { ?>  
                                    <table id="" class="table table-bordered table-striped">
                                        <thead>  <tr>
                                                <th width="5%">NO. </th>
                                                <th>CLASS NAME</th>
                                                <th id="fir" width="3%"><input type="checkbox" id="ckbCheckAll2" value='' name="head_checkbox"></th>
                                            </tr></thead>
                                        <tbody>
                                            <?php
                                            $cnt = 1;
                                            foreach ($get_group_list as $group) {
                                                ?>
                                                <tr>  
                                                    <td><?php echo $cnt; ?></td> 
                                                    <td><?php echo $group['name']; ?></td>  
                                                    <td><input type="checkbox" name="check_id[]" class="checkBoxClass" value="<?php echo $group['id']; ?>"></td>
                                                </tr>  
                                                <?php
                                                $cnt++;
                                            }
                                            ?>  
                                        </tbody>
                                    </table>
                                <?php } ?>
                                 </div>
                        </div>
                        <div class="col-md-5">
                             <div class="box box-primary">
                            <div class="box-header">
                                <div class="col-md-3"></div>
                                <label class="col-md-9"><span class="has-error"> 
                                    </span></label>
                                <span class="has-error"><?php echo $this->session->flashdata('error_msg'); ?></span>
                            </div>
                            <div class="box-body">


                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-5">                                               
                                            <input type="radio" name="sms_type" id="sms_type" value="Instant" checked="checked" >
                                            <label for="sms_type"> Instant Message</label>
                                        </div>
                                        <?php
                                        if ($get_api_status['status_two'] == 'Active') { ?>
                                        <div class="col-md-6">                                                   
                                            <input type="radio" name="sms_type" id="schedule_message" value="Schedule">
                                            <label for="schedule_message"> Schedule Message on</label>
                                        </div>
                                    <?php } else { } ?>
                                    </div>
                                </div>
                                <?php
                                if ($get_api_status['status_two'] == 'Active') { ?>
                                <div class="form-group" id="schedule_message_datetimepicker" style="display:none">           
                                <input type="text" class="form-control" name="schedule_date" id="datetimepicker1"  value="">  
                                </div>
                                <?php } else { } ?>

                                <div class="form-group"> 
                                    <div class="row">
                                        <label for="message_for" class="col-md-4"> Message For :</label>
                                        <div class="col-md-8">    
                                            <select name="msg_for" class="form-control" id="message_for"> 
                                                <?php											
												    foreach ($get_msg_for as $get_msg) { ?>
                                                    <?php
                                                    if ($get_api_status['status_two'] == 'Active') {
                                                        if ($get_msg['for_name'] != 'None') {
                                                            ?>  <option value="<?php echo $get_msg['for_name'] ?>" > <?php echo $get_msg['for_name']; ?></option> <?php
                                                        }
                                                    } else {
                                                        if ($get_msg['for_name'] != 'None') {
                                                        ?>
                                                        <option value="<?php echo $get_msg['for_name'] ?>"  <?php if ($get_msg['for_name'] == 'None') { ?> selected="selected" <?php } ?> > <?php echo $get_msg['for_name']; ?></option>
                                                    <?php } } ?>
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
                                    <textarea class="form-control"  style="height: 150px;" name="message" required="required" id="text_messagee" placeholder="Messsage">Dear Parents, </textarea>   
                                    <span class="static_value">[name]</span> <span class="static_value">[class]</span> <span class="static_value">[rollno]</span> <span class="static_value">[todaydate]</span>
                                    <!-- 160 Characters left start -->
                                    <!--<div class="charLeftInput" id="charLeftInput_wine_desc"></div>-->
									<div class="charLeftInput remaining"></div>
                                    <!-- 160 Characters left end -->
                                </div>    
                                <!--                            <div class="form-group">
                                                                <span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists"></span>   
                                                                <input type="file" name="photo" id="photo">  
                                                            </div>-->


                                <div class="form-group">
                                    <button type="submit" name="submit" id="submit"  class="btn btn-primary" >Send Now</button>
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
                                            <textarea name="select_template" id="select_template" style="height: 100px;" readonly="readonly"  class="form-control select_template"><?php echo $sms['template_text']; ?></textarea>  <br />
                                            <?php
                                        endforeach;
                                    }
                                    ?> 
                                </div>

                            </div>
                        </div><!-- /.col-->
                        <div class="col-md-1"></div>
                    </div><!-- ./row -->
                </div><!-- /.box -->
            </section><!-- /.content -->
        </div>
		<!-- /.content-wrapper -->
        <!-- Add the sidebar's background. This div must be placed
             immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
	<!-- ./wrapper -->
    <?php $this->load->view($this->config->item('admin_folder') . '/footer'); ?>
    <script src="<?php echo base_url() ?>admin_assets/js/data.js"></script>
    <script src="<?php echo base_url() ?>admin_assets/js/sms.js"></script>
    <script src="<?php echo base_url(); ?>admin_assets/js/send_sms.js"></script>

</body>

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

