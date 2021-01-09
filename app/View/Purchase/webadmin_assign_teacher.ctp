<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-user"></i> &nbsp;
                        Assign Teacher
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="form">
                            <?php echo $this->Form->create('Payment', array('url' => array('controller' => 'purchase', 'action' => 'assign_teacher', $this->params['pass'][0], $this->params['pass'][1], 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal', 'enctype' => 'multipart/form-data')); ?>   

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Student's Firstname</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('first_name', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'First Name', 'value' => $user['User']['student_firstname'], 'disabled' => 'disabled')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Student's Lastname</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('last_name', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Last Name', 'value' => $user['User']['student_lastname'], 'disabled' => 'disabled')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Subject</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('subject', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Subject', 'value' => $payment['Subject']['subject'], 'disabled' => 'disabled')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Duration</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('duration', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Duration', 'value' => $payment['Payment']['duration'], 'disabled' => 'disabled')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Pack</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('pack', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Pack', 'value' => $payment['Payment']['pack'], 'disabled' => 'disabled')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Phone Number</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('phone_number', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Phone Number', 'value' => $user['User']['primary_phone'], 'disabled' => 'disabled')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Email</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('email', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Email', 'value' => $user['User']['email'], 'disabled' => 'disabled')); ?>
                                </div>
                            </div>



                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Teacher</label>
                                <div class="col-lg-6">
                                    <?php
                                    if(!empty($get_teacher)){
                                    foreach ($get_teacher as $teacher_name) {
                                        $teacher[$teacher_name['User']['id']] = $teacher_name['User']['first_name'] . ' ' . $teacher_name['User']['last_name'];
                                    } 
                                    }
                                    echo $this->Form->input('teacher', array('type' => 'select', 'label' => false, 'class' => 'form-control', 'empty' => '--Assign Teacher--', 'options' => @$teacher, 'required' => FALSE));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button type="submit" class="btn btn-success"><?php echo __('Assign Teacher'); ?></button>
                                </div>
                            </div>
                            <?php echo $this->Form->end(); ?>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</section>
