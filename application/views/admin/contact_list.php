<?php include('header.php')?>
<body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php  include('header_menu.php') ?>
            <!-- Left side column. contains the logo and sidebar -->
            <?php include('aside.php')?>
             <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1><?php echo $page_title ?> </h1>
                    <div id="act_msg" ></div> 
                    <div id="div_msg"> 
                    <?php include('flashmessage.php'); ?>
                    </div>
                     <ol class="breadcrumb">
                        <li><a href="<?php echo base_url().$this->config->item('admin_folder').'/dashboard'?>"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo base_url().$this->config->item('admin_folder').'/contact'?>">Account Manager</a></li>
                        <li class="active"><?php echo $page_title ?></li>
                    </ol>
                </section>
                
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                                <div class="btn-group pull-right"></div>
                        </div><!-- /.box-header -->
                <div class="box-body">
                    <?php if(empty($contact_list)) { ?>
                            <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th id="fir" width="3%"><input type="checkbox" id="ckbCheckAll2" name="head_checkbox" ></th>       
                                    <th width="5%">NO. </th>
                                    <th>NAME</th>
                                    <th>EMAIL ID</th> 
                                    <th width="15%" >ADD DATE-TIME</th> 
                                    <th WIDTH="8%">OPTION</th>
                                </tr>
                            </thead>
                            </table>
                        <?php } else { ?>  
                    <form name="list_form" action="<?php echo base_url().$this->config->item('admin_folder')?>/contact/mul_action" method="POST" >
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th id="fir" width="3%"><input type="checkbox" id="ckbCheckAll2" name="head_checkbox" ></th>       
                                    <th width="5%">NO. </th>
                                    <th>NAME</th>
                                    <th>EMAIL ID</th> 
                                    <th>MOBILE NO.</th> 
                                    <th width="15%" >ADD DATE-TIME</th> 
                                    <th WIDTH="8%">OPTION</th>
                                </tr>
                            </thead>
                        <tbody>
                            <?php 
                            $cnt=1;
                            $del_url='/Contact/delete/';
                             foreach ($contact_list as $elist){ ?>
                                <tr>  
                                    <td><input type="checkbox" name="mul_id[]" id="mul_id"  value="<?php echo $elist['id']?>"  class="checkBoxClass"  > </td>
                                    <td><?php echo $cnt;?></td> 
                                    <td><?php echo $elist['name'];?></td>  
                                    <td><?php echo $elist['email'];?></td>  
                                    <td><?php echo $elist['phone'];?></td>  
                                    <td><?php echo $elist['adddatetime'];?></td>  
                                    <td> <?php  $admin=$this->session->userdata();
                                                $user_id=$admin['user_id'];  if(!empty($user_id)) { ?>
                                                <a title="View" class="btn btn-xs btn-default" href="<?php echo base_url().$this->config->item('admin_folder').'/contact/view/'.$elist['id']?>"><i class="fa fa-eye"></i></a> 
                                                <?php } else {?>
                                        <a title="View" class="btn btn-xs btn-default" href="<?php echo base_url().$this->config->item('admin_folder').'/contact/view/'.$elist['id']?>"><i class="fa fa-eye"></i></a> 
                                        <a class="pencil-square-o" title="Edit" href="<?php echo base_url().$this->config->item('admin_folder').'/contact/mode/'.$elist['id']?>"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:;" title="Delete" class="btn btn-xs btn-danger" onclick="return delete_rec('<?php echo $elist['id']?>','<?php echo $del_url;?>');"><i class="fa fa-times"></i></a> </td>
                                                <?php } ?>
                                </tr>  
                                <?php  $cnt++; } ?>  
                        </tbody>
                      
                        </table>
                            <div class="col-xs-2"> 
                                <select id="mul_val" name="mul_val" class="form-control" width="5%">
                                <option value="">Select Action</option>
                                <option value="Delete" id="sel_del_rec" >Delete</option>
                                </select>
                            </div>   
                                <div id="show">
                                    <input type="submit" class="btn btn-primary" id="action_submit" name="mul_sub" value="submit" style="display: none">
                                </div>
                        </form>
                        <?php } ?>
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

    <?php include('footer.php'); ?>

    <script src="<?php echo base_url()?>admin_assets/js/contact_list.js"></script>
  </body>
</html>
