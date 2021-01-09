<!--dashboard start -->

<div class="dashboard">
    <div class="dashboard_con"> 
        <div class="tchr_side">
            <!--left_side start -->
            <div class="left_side">
                <div class="usr_img">
                    <?php
                    if (!empty($teacherInfo['Teacher_information']['image'])) {
                        ?>
                        <a href="<?php echo BASE_URL . 'teacher/profile/'; ?>"><img alt="teacher image" class="teacher_img img-responsive" src="<?php echo $this->webroot; ?>img/teacher_images/<?php echo $teacherInfo['Teacher_information']['image']; ?>"></a>
                    <?php } else { ?>
                        <a href="<?php echo BASE_URL . 'teacher/profile/'; ?>"><img alt="teacher image" class="teacher_img img-responsive" src="<?php echo $this->webroot . 'img/default_user_icon.png' ?>"></a>
                    <?php } ?>
                    <p><?php echo ucfirst($teacherInfo['User']['first_name']) . ' ' . ucfirst($teacherInfo['User']['last_name']); ?></p>
                </div>
                <div class="menu-button">
                    <img width="40" height="40" src="<?php echo $this->webroot . 'img/menu.png'; ?>" alt="">
                </div>
                <div class="dashboard_content">
                    <ul class="list-unstyled">
                        <li <?php if ($this->params['controller'] == 'teacher' and $this->params['action'] == 'index') { ?> class="active" <?php } ?>> <a href="<?php echo BASE_URL . 'teacher/' ?>"> <i class="fa fa-dashboard"></i> Dashboard</a> </li>
                        <li <?php if ($this->params['controller'] == 'teacher' and $this->params['action'] == 'profile') { ?> class="active" <?php } ?>> <a href="<?php echo BASE_URL . 'teacher/profile/' ?>"> <i class="fa fa-user"></i> Profile</a> </li>
                        <li <?php if ($this->params['controller'] == 'teacher' and $this->params['action'] == 'messages') { ?> class="active" <?php } ?>> <a href="<?php echo BASE_URL . 'teacher/messages/' ?>"> <i class="fa fa-envelope"></i> Messages <?php if (isset($messagecount) && $messagecount > 0) { ?><span> <?php
                                        echo $messagecount;
                                        ?></span><?php
                                }
                                ?></a> </li>

                        <li <?php if ($this->params['controller'] == 'teacher' and $this->params['action'] == 'payment_detail') { ?> class="active" <?php } ?>> <a href="<?php echo BASE_URL . 'teacher/payment_detail/' ?>"> <i class="fa fa-list"></i>Lesson History</a> </li>
                        <li <?php if ($this->params['controller'] == 'teacher' and $this->params['action'] == 'calendar') { ?> class="active" <?php } ?>> <a href="<?php echo BASE_URL . 'teacher/calendar/' ?>"> <i class="fa fa-clock-o"></i> Schedule Lesson</a> </li>





                        <li <?php if ($this->params['controller'] == 'teacher' and $this->params['action'] == 'my_students') { ?> class="active" <?php } ?>> <a href="<?php echo BASE_URL . 'teacher/my_students/' ?>"> <i class="fa fa-mortar-board"></i> My Students</a> </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--left_side closed -->
        <style>
            .teacher_img{
                width: 124px;
                height: 124px;
            }
        </style>