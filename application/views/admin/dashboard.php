<?php include('header.php') ?>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php include('header_menu.php'); ?>
        <!-- Left side column. contains the logo and sidebar -->
        <?php include('aside.php') ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Dashboard</h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url() . $this->config->item('admin_folder') . '/dashboard' ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <?php if (!empty($user_data['banner'])) { ?>
                        <center>
                            <div class="col-lg-12 col-xs-12" ><h2>Welcome to <?php echo $user_data['school_name']; ?></h2> </div>
                            <div class="col-lg-12 col-xs-12">

                                <?php
                                $image = base_url() . USER_IMAGES . $user_data['banner'];
                                echo '<img id="" src="' . $image . '" style="width: 700px; height: 250px; line-height: 90px;">';
                                ?>
                            </div>   
                        </center>
                    <?php } ?>
                     </div> 
                </section>
                 <section class="content">
 <div class="row">
                    <div class="col-lg-4 col-xs-6">
                        <!-- small box -->

                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>&nbsp;&nbsp;&nbsp;<?php
                                    if (!empty($active_user)) {
                                        echo $active_user;
                                    } else {
                                        echo "0";
                                    }
                                    ?></h3>
                                <p> Active Students</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="<?php echo base_url() . $this->config->item('admin_folder') ?>/student" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div><!-- ./col -->

                    <div class="col-lg-4 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>&nbsp;&nbsp;&nbsp;<?php
                                    if (!empty($inactive_user)) {
                                        echo $inactive_user;
                                    } else {
                                        echo "0";
                                    }
                                    ?></h3>
                                <p> Inactive Students</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="<?php echo base_url() . $this->config->item('admin_folder') ?>/student" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div><!-- ./col -->



                    <div class="col-lg-4 col-xs-6">
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3>&nbsp;&nbsp;&nbsp;<?php
                                    if (!empty($today_sms)) {
                                        echo $today_sms;
                                    } else {
                                        echo "0";
                                    }
                                    ?></h3>
                                <p> Total SMS sent today </p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="<?php echo base_url() . $this->config->item('admin_folder') ?>/sms/report" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <?php if($user_data['logint_type']!='teacher') { ?>
                    <div class="col-lg-4 col-xs-6">
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3>&nbsp;&nbsp;&nbsp;<?php
                                    if (!empty($total_s_sms)) {
                                        echo $total_s_sms;
                                    } else {
                                        echo "0";
                                    }
                                    ?></h3>
                                <p> Overall sent sms </p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="<?php echo base_url() . $this->config->item('admin_folder') ?>/sms/report" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>



                    <div class="col-lg-4 col-xs-6">

                        <div class="small-box bg-yellow">
                            <div class="inner">

                                <h3><?php
                                    if (!empty($user_sms)) {
                                        echo $user_sms;
                                    } else {
                                        echo "0";
                                    }
                                    ?>
                                </h3>

                                <p>Overall Alloted Sms</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="<?php echo base_url() . $this->config->item('admin_folder') . '/sms/report' ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-6">

                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3> <?php
                                    if (!empty($red_s_sms)) {
                                        echo $red_s_sms;
                                    } else {
                                        echo "0";
                                    }
                                    ?></h3>
                                <p>Balance Sms</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="<?php echo base_url() . $this->config->item('admin_folder') . '/sms/report' ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div> <!-- ./col -->
                <?php } ?>

                </div><!-- /.row -->
                <!-- Main row -->
                <div class="row">
                </div><!-- /.content-wrapper -->
                <!-- Add the sidebar's background. This div must be placed
                     immediately after the control sidebar -->
                <div class="control-sidebar-bg"></div>
            </section>
        </div> 
    </div><!-- ./wrapper -->
</body>
<?php include('footer.php') ?>