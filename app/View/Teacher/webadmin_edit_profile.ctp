<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Edit Profile Information
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="form">
                            <?php echo $this->Session->flash(); ?>  
                            <?php echo $this->Form->create('Teacher_information', array('url' => array('controller' => 'teacher', 'action' => 'edit_profile', $this->params['pass'][0], 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal', 'enctype' => 'multipart/form-data')); ?>   

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">First Name</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('first_name', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'First Name', 'required' => FALSE, 'value' => @$teacher['Teacher_information']['first_name'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Last Name</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('last_name', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Last Initial', 'required' => FALSE, 'value' => @$teacher['Teacher_information']['last_name'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Subject Taught</label>
                                <div class="col-lg-6">
                                    <?php // pr($subjects); ?>
                                    <select id="subjetc" class="form-control" name="data[Teacher_information][subject_taught][]" multiple="multiple" >
                                        <?php
                                        if (!empty($subjects)) {
                                            foreach ($subjects as $sub) {
                                                ?>
                                                <option value="<?php echo $sub['Subject']['id']; ?>" <?php
                                        if (isset($sub['Subject']['selected']) && !empty($sub['Subject']['selected']) && $sub['Subject']['selected'] == 'true') {
                                            echo 'selected';
                                        }
                                                ?>><?php echo $sub['Subject']['subject']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Age Range Taught</label>
                                <div class="col-lg-6">
                                    <?php
                                    $options = array('5+' => '5+', '6+' => '6+', '7+' => '7+', '8+' => '8+', '9+' => '9+', '10+' => '10+');
                                    echo $this->Form->input('age_range_taught', array('class' => 'form-control', 'label' => FALSE, 'empty' => 'Age Range Taught', 'type' => 'select', 'options' => $options, 'value' => @$teacher['Teacher_information']['age_range_taught']));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Areas Taught</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('areas_taught', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Areas Taught', 'required' => FALSE, 'value' => @$teacher['Teacher_information']['areas_taught'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Experience</label>
                                <div class="col-lg-6"> 
                                    <div class="col-md-3">
                                        <?php
                                        $explode_Exp = explode(' ', $teacher['Teacher_information']['experience']);
//                                        pr($explode_Exp);die;
                                        echo $this->Form->input('exp', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Experience', 'required' => FALSE, 'value' => @$explode_Exp[0]));
                                        ?>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="data[Teacher_information][exp_type]" class="form-control">
                                            <option>-Select-</option>
                                            <option value="Months" <?php
                                        if ($explode_Exp[1] == 'Months') {
                                            echo 'selected';
                                        }
                                        ?>>Months</option>
                                            <option value="Years" <?php
                                            if ($explode_Exp[1] == 'Years') {
                                                echo 'selected';
                                            }
                                        ?>>Years</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Upload Photo</label>
                                <div class="col-lg-6">
                                    <?php if (!empty($teacher['Teacher_information']['image']) && ($teacher['Teacher_information']['image'] != "")) { ?>
                                        <div class="fileupload-new thumbnail">
                                            <img alt="uploadedImage" src="<?php echo $this->webroot . 'img/teacher_images/' . @$teacher['Teacher_information']['image']; ?>">
                                        </div>
                                    <?php } ?>
                                    <?php echo $this->Form->input('image', array('type' => 'file', 'label' => false, 'class' => 'upload', 'required' => FALSE, 'value' => @$teacher['Teacher_information']['image'])); ?>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Biography Written in Third Person</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('biography', array('class' => 'form-control ckeditor', 'label' => FALSE, 'placeholder' => 'Biography Written in Third Person', 'required' => FALSE, 'value' => @$teacher['Teacher_information']['biography'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button type="submit" class="btn btn-success"><?php echo __('Edit Profile Information'); ?></button>
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
