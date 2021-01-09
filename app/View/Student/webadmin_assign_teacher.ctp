<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Assign Teacher
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="form">
                            <?php echo $this->Session->flash(); ?>  
                            <?php echo $this->Form->create('Assigned_teacher', array('url' => array('controller' => 'student', 'action' => 'assign_teacher',$this->params['pass'][0], 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal')); ?>   

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Subject</label>
                                <div class="col-lg-6">
                                    <?php
                                    foreach ($all_subjects as $subjects) {
                                        $subject[$subjects['Subject']['id']] = $subjects['Subject']['subject'];
                                    }
                                    echo $this->Form->input('subject', array('class' => 'form-control', 'label' => FALSE, 'empty' => 'Select Subject', 'type' => 'select', 'options' => $subject, 'id' => 'assignSubject'));
                                    ?>   
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Teacher</label>
                                <div class="col-lg-6">
                                    <?php
                                    echo $this->Form->input('teacher', array('class' => 'form-control', 'label' => FALSE, 'empty' => '-Select-', 'type' => 'select', 'id' => 'assignTeacher'));
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
