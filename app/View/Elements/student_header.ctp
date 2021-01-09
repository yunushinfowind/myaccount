<!--dashboard_header start -->
<div class="dashboard_header navbar navbar-default navbar-fixed-top">
    <div class="col-md-12">
        <div class="dash_logo"> 
            <a href="https://lessonsonthego.com/"> 
                <img src="<?php echo $this->webroot; ?>img/dashboard_logo.png" class="img-responsive" alt="Logo" title="Lessons On The Go"/>
            </a> 
        </div>
        <div class="header_img"> 
            <i>
		<?php if (!empty($studentinfo['User']['image'])) { ?>
    		<img src="<?php echo $this->webroot . 'img/student_images/' . $studentinfo['User']['image']; ?>" class="img-circle" />
		<?php } else { ?> 
    		<img src="<?php echo $this->webroot; ?>img/default_user_icon.png" class="img-circle" />
		<?php } ?>
            </i>
            <span class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo ucfirst($studentinfo['User']['first_name']) . ' ' . ucfirst($studentinfo['User']['last_name']); ?><span class="caret"></span></a>
                <ul class="dropdown-menu">
		    <li><a href="<?php echo BASE_URL . 'frontend/change_password/'; ?>">Change Password</a></li>
		    <li><a href="<?php echo BASE_URL . 'User/logout/'; ?>">Logout</a></li>
                </ul>
            </span> 
        </div>
    </div>
</div>
<!--dashboard_header closed --> 