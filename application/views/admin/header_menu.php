<?php
$admin = $this->session->userdata();
$id = $admin['admin_info'];
$admin_info = $this->auth->get_admin_info($id);
?>
<header class="main-header">

    <div class="logo">
        <?php
        $logo = get_list(SITE);
        $image = base_url() . 'upload/logo/' . $logo['0']['photo'];
        if ($logo['0']['photo'] != '') {
            ?>
            <span class="logo-lg"><img src="<?php echo $image ?>" width="50px"> <?php echo $logo['0']['name'] ?></span>
        <?php } else { ?>
            <span class="logo-lg"><b>Site</b>LOGO</span>
        <?php } ?>
        <span class="logo-mini"><img src="<?php echo $image ?>" width="50px"></span>
    </div>
    <!-- <a href="javascript:void()" class="logo">
    <?php
    $logo = get_list(SITE);
    $image = base_url() . 'upload/logo/thumb' . $logo['0']['photo'];
    if ($logo['0']['photo'] != '') {
        ?>
                                 <span class="logo-mini"><img src="<?php echo $image ?>" width="50px"  ></span>
                                  <span class="logo-lg"><img src="<?php echo $image ?>" width="50px"  ></span>

    <?php } ?>

     </a> -->
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <?php
        if ($admin['logint_type'] == 'admin' && $admin['user_id'] != "") {
            $user_id = $admin['user_id'];
            $admin_user_info = $this->auth->get_admin_info($user_id);
            ?>
            <lable class="btn btn-primary " style="    margin: 9px 15px;">Login as <?php echo strtoupper($admin_user_info['name']); ?></lable>
            <a href="<?php echo base_url() . $this->config->item('admin_folder') . '/user/as_admin' ?>" class="btn btn-primary" style="    margin: 9px 15px;">Login as admin</a>
        <?php } ?>


        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php if ($admin_info['photo'] == '') { ?>
                            <img src="<?php echo base_url(); ?>upload/user_image/default/default.jpg"  class="user-image" alt="User Image">
                        <?php } else { ?>
                            <img src="<?php echo base_url(); ?>upload/user_image/thumb/<?php echo $admin_info['photo'] ?>"  class="user-image" alt="User Image">
                        <?php } ?>
                        <span class="hidden-xs"><?php echo $admin_info['name']; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?php if ($admin_info['photo'] == '') { ?>
                                <img src="<?php echo base_url(); ?>upload/user_image/default/default.jpg"  class="user-image" alt="User Image">
                            <?php } else { ?>
                                <img src="<?php echo base_url(); ?>upload/user_image/thumb/<?php echo $admin_info['photo'] ?>" class="img-circle" alt="User Image">
                            <?php } ?>
                            <p>
                                :: Last edit profile ::
                                <small><?php echo $admin_info['editdatetime']; ?></small>
                            </p>
                        </li>
                        <!-- Menu Body
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </li>  -->
                        <!-- Menu Footer-->
                        <?php $admin = $this->session->userdata(); ?>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php echo base_url() . $this->config->item('admin_folder') . '/user/mode/' . $admin['admin_info'] ?>" class="btn btn-default btn-flat">Edit profile</a>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-default btn-flat" href="<?php echo base_url() . $this->config->item('admin_folder') . '/login/logout' ?>">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->

                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript::;">
                        <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                            <p>Will be 23 on April 24th</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript::;">
                        <i class="menu-icon fa fa-user bg-yellow"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
                            <p>New phone +1(800)555-1234</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript::;">
                        <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
                            <p>nora@example.com</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript::;">
                        <i class="menu-icon fa fa-file-code-o bg-green"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
                            <p>Execution time 5 seconds</p>
                        </div>
                    </a>
                </li>
            </ul><!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript::;">
                        <h4 class="control-sidebar-subheading">
                            Custom Template Design
                            <span class="label label-danger pull-right">70%</span>
                        </h4>
                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript::;">
                        <h4 class="control-sidebar-subheading">
                            Update Resume
                            <span class="label label-success pull-right">95%</span>
                        </h4>
                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript::;">
                        <h4 class="control-sidebar-subheading">
                            Laravel Integration
                            <span class="label label-warning pull-right">50%</span>
                        </h4>
                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript::;">
                        <h4 class="control-sidebar-subheading">
                            Back End Framework
                            <span class="label label-primary pull-right">68%</span>
                        </h4>
                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                        </div>
                    </a>
                </li>
            </ul><!-- /.control-sidebar-menu -->

        </div><!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div><!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
                <h3 class="control-sidebar-heading">General Settings</h3>
                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Report panel usage
                        <input type="checkbox" class="pull-right" checked>
                    </label>
                    <p>
                        Some information about this general settings option
                    </p>
                </div><!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Allow mail redirect
                        <input type="checkbox" class="pull-right" checked>
                    </label>
                    <p>
                        Other sets of options are available
                    </p>
                </div><!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Expose author name in posts
                        <input type="checkbox" class="pull-right" checked>
                    </label>
                    <p>
                        Allow the user to show his name in blog posts
                    </p>
                </div><!-- /.form-group -->

                <h3 class="control-sidebar-heading">Chat Settings</h3>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Show me as online
                        <input type="checkbox" class="pull-right" checked>
                    </label>
                </div><!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Turn off notifications
                        <input type="checkbox" class="pull-right">
                    </label>
                </div><!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Delete chat history
                        <a href="javascript::;" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                    </label>
                </div><!-- /.form-group -->
            </form>
        </div><!-- /.tab-pane -->
    </div>
</aside><!-- /.control-sidebar -->