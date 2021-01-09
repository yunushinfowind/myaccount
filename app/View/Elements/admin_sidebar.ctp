<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a href="<?php echo BASE_URL . 'webadmin/' ?>">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
		<?php if (isset($_SESSION['Auth']['Admin']['user_type']) and $_SESSION['Auth']['Admin']['user_type'] == 'subadmin') { ?>    

		<?php } else { ?> 
    		<li>
    		    <a <?php if ($this->params['controller'] == 'student' and $this->params['action'] == 'webadmin_add' || $this->params['action'] == 'webadmin_index' || $this->params['action'] == 'webadmin_edit_student' || $this->params['action'] == 'webadmin_additional_students' || $this->params['action'] == 'webadmin_purchases' || $this->params['action'] == 'webadmin_completed_lesson' || $this->params['action'] == 'webadmin_make_a_payment') { ?>class="active"<?php } ?> href="javascript:;">
    			<i class="fa fa-users"></i>
    			<span>Student Management</span>
    		    </a>
    		    <ul class="sub">
    			<li <?php if ($this->params['controller'] == 'student' and $this->params['action'] == 'webadmin_add') { ?>class="active"<?php } ?>>
				<?php echo $this->Html->link('Add Student', array('controller' => 'student', 'action' => 'webadmin_add')); ?></li>
    			<li <?php if ($this->params['controller'] == 'student' and $this->params['action'] == 'webadmin_index') { ?>class="active"<?php } ?>>
				<?php echo $this->Html->link('Manage Student', array('controller' => 'student', 'action' => 'webadmin_index')); ?></li>

    		    </ul>
    		</li>

    		<li>
    		    <a <?php if ($this->params['controller'] == 'teacher' and $this->params['action'] == 'webadmin_add' || $this->params['action'] == 'webadmin_index' || $this->params['action'] == 'webadmin_payroll' || $this->params['action'] == 'webadmin_pay' || $this->params['action'] == 'webadmin_edit_basic' || $this->params['action'] == 'webadmin_edit_profile' || $this->params['action'] == 'webadmin_view_calendar' || $this->params['action'] == 'webadmin_completed_lesson') { ?>class="active"<?php } ?>  href="javascript:;">
    			<i class="fa fa-users"></i>
    			<span>Teacher Management</span>
    		    </a>
    		    <ul class="sub">
    			<li <?php if ($this->params['controller'] == 'teacher' and $this->params['action'] == 'webadmin_add') { ?>class="active"<?php } ?>>
				<?php echo $this->Html->link('Add Teacher', array('controller' => 'teacher', 'action' => 'webadmin_add')); ?></li>
    			<li <?php if ($this->params['controller'] == 'teacher' and $this->params['action'] == 'webadmin_index') { ?>class="active"<?php } ?>>
				<?php echo $this->Html->link('Manage Teacher', array('controller' => 'teacher', 'action' => 'webadmin_index')); ?></li>
    			<li <?php if ($this->params['controller'] == 'teacher' and $this->params['action'] == 'webadmin_payroll') { ?>class="active"<?php } ?>>
				<?php echo $this->Html->link('Payroll', array('controller' => 'teacher', 'action' => 'webadmin_payroll')); ?></li>

    		    </ul>
    		</li>

    		<li>
    		    <a <?php if ($this->params['controller'] == 'subject' and $this->params['action'] == 'webadmin_add' || $this->params['action'] == 'webadmin_index' || $this->params['action'] == 'webadmin_edit_subject') { ?>class="active"<?php } ?>  href="javascript:;">
    			<i class="fa fa-book"></i>
    			<span>Subject Management</span>
    		    </a>
    		    <ul class="sub">
    			<li <?php if ($this->params['controller'] == 'subject' and $this->params['action'] == 'webadmin_add') { ?>class="active"<?php } ?>>
				<?php echo $this->Html->link('Add Subject', array('controller' => 'subject', 'action' => 'webadmin_add')); ?></li>
    			<li <?php if ($this->params['controller'] == 'subject' and $this->params['action'] == 'webadmin_index') { ?>class="active"<?php } ?>>
				<?php echo $this->Html->link('Manage Subject', array('controller' => 'subject', 'action' => 'webadmin_index')); ?></li>
    		    </ul>
    		</li>

    		<li class="">
    		    <a <?php if ($this->params['controller'] == 'pack' and $this->params['action'] == 'webadmin_add' || $this->params['action'] == 'webadmin_index' || $this->params['action'] == 'webadmin_edit_pack') { ?> class="active dcjq-parent" <?php } ?>  href="javascript:;">
    			<i class="fa fa-bars"></i>
    			<span>Package Management</span>
    		    </a>
    		    <ul class="sub">
    			<li <?php if ($this->params['controller'] == 'pack' and $this->params['action'] == 'webadmin_add') { ?>class="active"<?php } ?>>
				<?php echo $this->Html->link('Add Package', array('controller' => 'pack', 'action' => 'webadmin_add')); ?></li>
    			<li <?php if ($this->params['controller'] == 'pack' and $this->params['action'] == 'webadmin_index') { ?>class="active"<?php } ?>>
				<?php echo $this->Html->link('Manage Package', array('controller' => 'pack', 'action' => 'webadmin_index')); ?></li>
    		    </ul>
    		</li>

    		<li class="">
    		    <a <?php if ($this->params['controller'] == 'price' and ($this->params['action'] == 'webadmin_add' || $this->params['action'] == 'webadmin_index' || $this->params['action'] == 'webadmin_edit_price' || $this->params['action'] == 'webadmin_add_pricing_type')) { ?> class="active dcjq-parent" <?php } ?>  href="javascript:;">
    			<i class="fa fa-dollar"></i>
    			<span>Price Management</span>
    		    </a>

    		    <ul class="sub">
                    <li <?php if ($this->params['controller'] == 'price' and $this->params['action'] == 'webadmin_add_pricing_type') { ?>class="active"<?php } ?>>
                        <?php echo $this->Html->link('Add New Pricing Type', array('controller' => 'price', 'action' => 'webadmin_add_pricing_type')); ?></li>
    			<li <?php if ($this->params['controller'] == 'price' and $this->params['action'] == 'webadmin_add') { ?>class="active"<?php } ?>>
				<?php echo $this->Html->link('Add Pricing', array('controller' => 'price', 'action' => 'webadmin_add')); ?></li>
    			<li <?php if ($this->params['controller'] == 'price' and $this->params['action'] == 'webadmin_index' || $this->params['action'] == 'webadmin_old_rate') { ?>class="active"<?php } ?>>
				<?php echo $this->Html->link('Manage Pricing', array('controller' => 'price', 'action' => 'webadmin_index')); ?>
    			    <!--ul style='display: block;'>
    				<li <?php if ($this->params['controller'] == 'price' and $this->params['action'] == 'webadmin_old_rate') { ?>class="active"<?php } ?>>
					<?php echo $this->Html->link('Old Rate', array('controller' => 'price', 'action' => 'webadmin_old_rate')); ?></li>
    				<li <?php if ($this->params['controller'] == 'price' and $this->params['action'] == 'webadmin_regular_price') { ?>class="active"<?php } ?>>
					<?php echo $this->Html->link('Regular Pricing', array('controller' => 'price', 'action' => 'webadmin_regular_price')); ?></li>
    				<li <?php if ($this->params['controller'] == 'price' and $this->params['action'] == 'webadmin_violin_price') { ?>class="active"<?php } ?>>
					<?php echo $this->Html->link('Violin Pricing', array('controller' => 'price', 'action' => 'webadmin_violin_price')); ?></li>
    			    </ul-->
    			</li>
    		    </ul>
    		</li>

    		<li class="">
    		    <a <?php if ($this->params['controller'] == 'coupon' and $this->params['action'] == 'webadmin_add' || $this->params['action'] == 'webadmin_index' || $this->params['action'] == 'webadmin_edit_coupon') { ?> class="active dcjq-parent" <?php } ?>  href="javascript:;">
    			<i class="fa fa-money"></i>
    			<span>Coupon Management</span>
    		    </a>
    		    <ul class="sub">
    			<li <?php if ($this->params['controller'] == 'coupon' and $this->params['action'] == 'webadmin_add') { ?>class="active"<?php } ?>>
				<?php echo $this->Html->link('Add Coupon', array('controller' => 'coupon', 'action' => 'webadmin_add')); ?></li>
    			<li <?php if ($this->params['controller'] == 'coupon' and $this->params['action'] == 'webadmin_index') { ?>class="active"<?php } ?>>
				<?php echo $this->Html->link('Manage Coupons', array('controller' => 'coupon', 'action' => 'webadmin_index')); ?></li>
    		    </ul>
    		</li>

    		<li class="">
    		    <a <?php if ($this->params['controller'] == 'dashboard' and ( $this->params['action'] == 'webadmin_manage_emails' || $this->params['action'] == 'webadmin_student_resend' || $this->params['action'] == 'webadmin_teacher_resend' || $this->params['action'] == 'webadmin_make_payment' || $this->params['action'] == 'webadmin_forgot_password' || $this->params['action'] == 'webadmin_student_signup' || $this->params['action'] == 'webadmin_teacher_signup' || $this->params['action'] == 'webadmin_second_last' || $this->params['action'] == 'webadmin_last' || $this->params['action'] == 'webadmin_teacher_paid')) { ?> class="active dcjq-parent" <?php } ?>  href="javascript:;">
    			<i class="fa fa-envelope"></i>
    			<span>Email Management</span>
    		    </a>
    		    <ul class="sub">
    			<li <?php if ($this->params['controller'] == 'dashboard' and $this->params['action'] == 'webadmin_manage_emails') { ?>class="active"<?php } ?>>
				<?php echo $this->Html->link('Edit Automatic Email', array('controller' => 'dashboard', 'action' => 'manage_emails')); ?></li>
    		    </ul>
    		</li>

    		<li class="">
    		    <a <?php if (($this->params['controller'] == 'setting') and ($this->params['action'] == 'webadmin_authorize_credentials')) { ?> class="active dcjq-parent" <?php } ?>  href="javascript:;">
    			<i class="fa fa-cogs"></i>
    			<span>Settings</span>
    		    </a>
    		    <ul class="sub">
    			<li <?php if ($this->params['controller'] == 'setting' and $this->params['action'] == 'webadmin_authorize_credentials') { ?>class="active"<?php } ?>>
				<?php echo $this->Html->link('Authorize.net', array('controller' => 'setting', 'action' => 'authorize_credentials')); ?></li>

    		    </ul>
    		</li>

		<?php } ?>   
            </ul>           
        </div>
    </div>
</aside>
<!--sidebar end-->
