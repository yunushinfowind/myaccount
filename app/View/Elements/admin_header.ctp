

<header class="header fixed-top clearfix">
    <!--logo start-->
    <div class="brand">

        <a href="<?php echo BASE_URL; ?>" class="logo">
            <img src="<?php echo $this->webroot; ?>img/logoback.png" class="img-responsive" alt="logo" style='margin: 5px 16px;'>
        </a>
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars"></div>
        </div>
    </div>
    <!--logo end-->
    <div class="top-nav clearfix">
        <!--search & user info start-->
        <ul class="nav pull-right top-menu">

            <!-- user login dropdown start-->

            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
		    <?php if (!empty($admin_detail['Admin']['image'])) { ?>
    		    <img src="<?php echo $this->webroot . 'img/admin_images/' . $admin_detail['Admin']['image']; ?>" alt="image">
		    <?php } else { ?>
    		    <img src="<?php echo $this->webroot . 'img/default_user_icon.png'; ?>" alt="image">
		    <?php } ?>
		    <?php // echo $this->Html->image('default_user_icon.png') ?>
                    <span class="username">Welcome <?php
			if ($admin_detail['Admin']['username']) {
			    echo ucfirst($admin_detail['Admin']['username']);
			} else {
			    echo 'Admin';
			}
			?></span>
                    <b class="caret"></b>
                </a>

                <ul class="dropdown-menu extended logout">
                    <li><?php echo $this->Html->link('<i class="fa fa-cog"></i> Change Password', '/webadmin/Login/change_password', array('class' => '', 'escape' => false)); ?></li>
                    <li><?php echo $this->Html->link('<i class="fa fa-cog"></i> Change Details', '/webadmin/Login/change_details', array('class' => '', 'escape' => false)); ?></li>
		    <li><?php echo $this->Html->link('<i class="fa fa-key"></i> Log Out', '/webadmin/Login/logout', array('class' => '', 'escape' => false)); ?></li>
                </ul>
            </li>
            <!-- user login dropdown end -->

        </ul>
        <!--search & user info end-->
    </div>
</header>
