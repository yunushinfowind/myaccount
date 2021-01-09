<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Step 2: Profile Information
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="form">
                            <?php echo $this->Session->flash(); ?>  
                            <?php echo $this->Form->create('Teacher_information', array('url' => array('controller' => 'teacher', 'action' => 'add_teacher', $this->params['pass'][0], 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal', 'enctype' => 'multipart/form-data')); ?>   

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">First Name</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('first_name', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'First Name')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Last Name</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('last_name', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Last Initial')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Subject Taught</label>
                                <div class="col-lg-6">
                                    <select id="subjetc" class="form-control" name="data[Teacher_information][subject_taught][]" multiple="multiple">
                                        <?php
                                        foreach ($subjects as $sub) {
                                            ?>
                                            <option value="<?php echo $sub['Subject']['id']; ?>"><?php echo $sub['Subject']['subject']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Age Range Taught</label>
                                <div class="col-lg-6">
                                    <?php
                                    $options = array('5+' => '5+', '6+' => '6+', '7+' => '7+', '8+' => '8+', '9+' => '9+', '10+' => '10+');
                                    echo $this->Form->input('age_range_taught', array('class' => 'form-control', 'label' => FALSE, 'empty' => 'Age Range Taught', 'type' => 'select', 'options' => $options));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Areas Taught</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('areas_taught', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Areas Taught')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Experience</label>
                                <div class="col-lg-6">
                                <div class="col-lg-3">
                                    <?php
                                    echo $this->Form->input('exp', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Experience'));
                                    ?>
                                </div>
                                    <div class="col-lg-3">
                                        <select name="data[Teacher_information][exp_type]" class="form-control">
                                            <option value="">-Select-</option>
                                            <option value="Months">Months</option>
                                            <option value="Years">Years</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Upload Photo</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('image', array('type' => 'file', 'label' => false, 'class' => 'upload')); ?>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Biography Written in Third Person</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('biography', array('class' => 'form-control ckeditor', 'label' => FALSE, 'placeholder' => 'Biography Written in Third Person')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button type="submit" class="btn btn-success"><?php echo __('Add Profile Information'); ?></button>
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
