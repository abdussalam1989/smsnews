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
                    <h1><?php echo $page_title; ?> </h1>
                        <div id="act_msg" ></div> 
                        <div id="div_msg"> 
                         <?php $this->load->view($this->config->item('admin_folder') . '/flashmessage'); ?>
                        </div>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo ADMIN_URL.'/dashboard'; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo ADMIN_URL.'/group';?>">group</a></li>
                        <li class="active"><?php echo $page_title; ?></li>
                    </ol>
                </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                             <a class="btn btn-default pull-right" href="<?php echo base_url().$this->config->item('admin_folder')?>/group/mode">Add Group</a>
                                <div class="btn-group pull-right"></div>
                        </div><!-- /.box-header -->
                <div class="box-body">
                     <?php if(empty($data)) { ?>
                    <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th id="fir" width="3%"><input type="checkbox" id="ckbCheckAll2" name="head_checkbox" ></th>       
                                    <th width="5%">NO. </th>
                                    <th>NAME</th>
                                    <th width="10%">STATUS</th>
                                    <th width="8%">OPTION</th>
                                </tr>
                            </thead>
                    </table>
                        <?php } else { ?>
                        <form name="list_form" action="<?php echo base_url().$this->config->item('admin_folder')?>/group/mul_action" method="POST" >
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th id="fir" width="3%"><input type="checkbox" id="ckbCheckAll2" name="head_checkbox" ></th>       
                                    <th width="5%">NO. </th>
                                    <th>NAME</th>
                                    <th width="10%">STATUS</th>
                                    <th width="8%">OPTION</th>
                                </tr>
                            </thead>
                        <tbody>
                            <?php 
                            $cnt=1;
                            foreach ($data as $data_list){ ?>
                                <tr>  
                                    <td><input type="checkbox" name="mul_id[]" id="mul_id"  value="<?php echo $data_list['id']?>"  class="checkBoxClass"  > </td>
                                    <td><?php echo $cnt;?></td> 
                                    <td><?php echo $data_list['name'];?></td>  
                                    <td><?php $checked = '';
                                    if($data_list['status']=='Active'){
                                        $checked = 'checked'; ?>  
                                        <input type='checkbox' name='boot_btn' id='<?php echo $data_list['id'];?>' value='/group/change_status/' class='form-control cls_chk'  data-size='mini' <?php echo $checked ?> >
                                    <?php } else { ?>
                                        <input type='checkbox' name='boot_btn' id='<?php echo $data_list['id'];?>' value='/group/change_status/' class='form-control cls_chk'  data-size='mini'></td>
                                    <?php } ?>
                                    <td>
									<a class="pencil-square-o" title="Edit" href="<?php echo base_url().$this->config->item('admin_folder').'/group/mode/'.$data_list['id']?>"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;
									<a class="pencil-square-o"  onclick='return remove_group("<?php echo $data_list['id']; ?>")' title="Edit" ><i class="fa fa-trash"></i></a>&nbsp;&nbsp;&nbsp;
                                  </td>
                                </tr>  
                                <?php 
                                $cnt++;
                                } ?>  
                        </tbody>
                        </table>
                     
                            <div class="col-xs-2"> 
                                <select id="mul_val" name="mul_val" class="form-control" width="5%">
                                <option value="">Select Action</option>
                                <option value="Active" id="sel_ac_rec" >Active</option>
                                <option value="Inactive" id="sel_inac_rec" >Inactive</option>
                                </select>
                            </div>   
                                <div id="show">
                                    <input type="submit" class="btn btn-primary" id="action_submit" name="mul_sub" value="submit" style="display: none">
                                </div>
                               <?php } ?>
                        </form>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <?php $this->load->view($this->config->item('admin_folder') . '/footer'); ?>
      <script src="<?php echo base_url()?>admin_assets/js/data.js"> </script>
	  <script>
function remove_group(id) {

    // validation code here ...


    if(!id) {
        alert('Please correct the errors in the form!');
        return false;
    }
    else {
        if(confirm('Do you really want to delete the group?')){			 
			$.post("<?php echo base_url().$this->config->item('admin_folder').'/group/remove_group/'; ?>", {id: id}, function(result){
				//$("span").html(result);
				console.log(result);
				location.reload();
			});
		}
    }
}
</script>
  </body>

</html>
