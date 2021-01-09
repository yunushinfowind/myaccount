<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Edit Additional Student
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="form">
                            <?php echo $this->Session->flash(); ?>  
                            <?php echo $this->Form->create('Child_user', array('url' => array('controller' => 'student', 'action' => 'edit_additional', $this->params['pass'][0], 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal', 'enctype' => 'multipart/form-data')); ?>   


                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Student's First Name</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('firstname', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => "Student's First Name", 'required' => FALSE, 'value' => $additional_user['Child_user']['firstname'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Student's Last Name</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('lastname', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => "Student's Last Name", 'value' => $additional_user['Child_user']['lastname'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Student's Age</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('age', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => "Student's Age", 'value' => $additional_user['Child_user']['age'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Subject</label>
                                <div class="col-lg-6">
                                    <?php
                                    if (!empty($subjects)) {
                                        foreach ($subjects as $subject) {
                                            $sub[$subject['Subject']['subject']] = $subject['Subject']['subject'];
                                        }
                                    }
                                    echo $this->Form->input('subject', array('class' => 'form-control', 'label' => FALSE, 'empty' => "-Subject-", 'value' => $additional_user['Child_user']['subject'], 'options' => $sub));
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button type="submit" class="btn btn-success"><?php echo __('Edit Additional Student'); ?></button>
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

