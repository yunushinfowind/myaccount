<!--dashboard start -->
<div class="dashboard dashboard2">
    <div class="dashboard_con"> 
	<div class="tchr_side">
	    <!--left_side start -->
	    <div class="left_side">
		<div class="usr_img">
		    <a href="<?php echo BASE_URL . 'student/my_info'; ?>">
			<?php if (!empty($studentinfo['User']['image'])) { ?>
                            <img alt="Dashboard user iamge" class="img-responsive" src="<?php echo $this->webroot . 'img/student_images/' . $studentinfo['User']['image']; ?>">
			<?php } else { ?>
                            <img alt="Dashboard user iamge" class="img-responsive" src="<?php echo $this->webroot . 'img/default_user_icon.png'; ?>">
			<?php } ?>
		    </a>
		    <p><?php echo ucfirst($studentinfo['User']['first_name']) . ' ' . ucfirst($studentinfo['User']['last_name']); ?></p>
		</div>
		<div class="menu-button">
		    <img width="40" height="40" src="<?php echo $this->webroot . 'img/menu.png'; ?>" alt="">
		</div>
		<div class="dashboard_content">
		    <ul class="list-unstyled">
			<li <?php if ($this->params['controller'] == 'student' and $this->params['action'] == 'index') { ?> class="active" <?php } ?>> <a href="<?php echo BASE_URL . 'student/'; ?>"> <i class="fa fa-dashboard"></i> Dashboard</a> </li>
			<li <?php if ($this->params['controller'] == 'student' and $this->params['action'] == 'my_info') { ?> class="active" <?php } ?>> <a href="<?php echo BASE_URL . 'student/my_info/'; ?>"> <i class="fa fa-user"></i> My Info</a> </li>

			<li <?php if ($this->params['controller'] == 'student' and $this->params['action'] == 'messages') { ?> class="active" <?php } ?> id="messageCounter"><a href="<?php echo BASE_URL . 'student/messages/'; ?>"> <i class="fa fa-envelope"></i> Messages <?php if (isset($messagecount) && $messagecount > 0) { ?><span class="msg_counter"> <?php
					echo $messagecount;
					?></span><?php } ?></a> </li>
			<li <?php if ($this->params['controller'] == 'student' and $this->params['action'] == 'payments') { ?> class="active" <?php } ?>> <a href="<?php echo BASE_URL . 'student/payments/'; ?>"> <i class="fa fa-database"></i> Payment Information</a> </li>
			<li <?php if ($this->params['controller'] == 'student' and $this->params['action'] == 'make_payment') { ?> class="active" <?php } ?>> <a href="<?php echo BASE_URL . 'student/make_payment/'; ?>"> <i class="fa fa-book"></i> Make a Payment</a> </li>
			<li <?php if ($this->params['controller'] == 'student' and $this->params['action'] == 'purchase_history') { ?> class="active" <?php } ?>> <a href="<?php echo BASE_URL . 'student/purchase_history/'; ?>"> <i class="fa fa-dollar"></i> Purchase History</a> </li>
			<li <?php if ($this->params['controller'] == 'student' and $this->params['action'] == 'completed_lessons') { ?> class="active" <?php } ?>> <a href="<?php echo BASE_URL . 'student/completed_lessons/'; ?>"> <i class="fa fa-thumbs-up"></i> Completed Lessons</a> </li>
			<li <?php if ($this->params['controller'] == 'student' and $this->params['action'] == 'my_teachers') { ?> class="active" <?php } ?>> <a href="<?php echo BASE_URL . 'student/my_teachers/'; ?>"> <i class="fa fa-users"></i>My Teachers</a> </li>
		    </ul>
		</div>
	    </div>
	</div>
        <!--left_side closed -->