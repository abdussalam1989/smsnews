
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            
            <!-- Left side column. contains the logo and sidebar -->
                        <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                 <!-- Content Header (Page header) -->
        <section class="content-header">
            <div id="act_msg" ></div> 
            <div id="div_msg">
        
            </div>  
            <ol class="breadcrumb">
            
             
        
            
             
            <li class="active"></li>
        </ol>
        </section>
                
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                           
                            <!-- <h3 class="box-title">Display Users</h3>-->
                            <div class="btn-group ">
                            </div>
                        </div><!-- /.box-header -->
                    
                <div class="box-body">
                     <?php if(empty($userlist)) { ?>
                    <table id="example2" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="5%">NO. </th>
                                <th>NAME</th>
                                <th>Email</th>
                                <th width="10%">API2 STATUS</th>
                                <th width="8% ">OPTION</th>
                            </tr>
                            </thead>
                    </table>
                    <?php } else { ?>
                    <form name="list_form" action="" method="POST" >
                    <table border="1" id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">NO. </th>
                                <th>id</th>
                                <th>User id</th>
                                <th>Msg Count</th>
                                <th>msg_status</th>
                                <th>is_send</th>
                                <th>Add Date time</th>
                                <th>is_send_datetime</th>
                                <th>Api message</th> 
                                <th>Api name</th> 
                            </tr>
                            </thead>
                    <tbody>
                        <?php 
                        $cnt=1;
                        $del_url='/user/delete/';
                        foreach ($userlist as $user){ ?>
                            <tr>  
                                <td><?php echo $cnt;?></td> 
                                <td><?php echo $user['id']; ?></td>  
                                <td><?php echo $user['user_id']; ?></td>
                                <td><?php echo $user['count_msg']; ?></td>
                                <td><?php echo $user['msg_status']; ?></td>
                                <td><?php echo $user['is_send']; ?></td>
                                <td><?php echo $user['adddate']." ".$user['addtime']; ?></td>
                                <td><?php echo $user['is_send_datetime']; ?></td>
                                <td><?php echo $user['api_message']; ?></td>
                                <td><?php echo $user['api_name']; ?></td>
                            </tr>  
                            <?php $cnt++; } ?>  
                    </tbody>
                     
                    <!--<tfoot>
                     <tr>
                        <th>SR NO. </th>
                        <th>NAME</th>
                        <th>Email</th>
                        <th>MOBILE NO.</th>
                        <th>ACTIVE/INACTIVE</th>
                        <th>OPTION</th>
                      </tr>
                    </tfoot> -->
                    </table>
                           
                    
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
     
    </div><!-- ./wrapper -->
    <div class="control-sidebar-bg"></div>
    
    <?php include('footer.php'); ?>
    <script src="<?php echo base_url()?>admin_assets/js/user.js"></script>
    </body>
</html>