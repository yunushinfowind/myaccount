<?php
$id = $this->params['pass'][0];
?>

<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-edit"></i>
                        Edit Information                                                 <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">


                        <div class="clearfix"></div>
                        <div class="form">
                            <?php echo $this->Session->flash(); ?>  
                            <?php echo $this->Form->create('User', array('url' => array('controller' => 'student', 'action' => 'edit_student', $this->params['pass'][0], 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal', 'enctype' => 'multipart/form-data')); ?>   
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">First Name<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('first_name', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'First Name', 'required' => FALSE, 'value' => $student['User']['first_name'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Last Name<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('last_name', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Last Name', 'value' => $student['User']['last_name'], 'required' => FALSE)); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Student's First Name<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('student_firstname', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => "Student's First Name", 'required' => FALSE, 'value' => $student['User']['student_firstname'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Student's Last Name</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('student_lastname', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => "Student's Last Name", 'value' => $student['User']['student_lastname'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Student's Age</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('student_age', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => "Student's Age", 'value' => $student['User']['student_age'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Subject<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    if (!empty($all_subjects)) {
                                        foreach ($all_subjects as $subjects) {
                                            $subj[$subjects['Subject']['subject']] = $subjects['Subject']['subject'];
                                        }
                                    }

                                    echo $this->Form->input('subject', array('class' => 'form-control', 'label' => FALSE, 'empty' => "-Select-", 'required' => FALSE, 'type' => 'select', 'options' => @$subj, 'value' => $student['User']['subject']));
                                    ?>
                                </div>
                            </div>

                            <!--Additional Student start-->
                            <?php
                            if (!empty($find_children)) {
                                foreach ($find_children as $key => $children) {
                                    $i = $key + 1;
                                    ?>
                                    <center> <h4><?php echo 'Student ' . $i . ' Details'; ?></h4></center>
                                    <div class="form-group">
                                        <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Student's First Name</label>
                                        <div class="col-lg-6">
                                            <?php echo $this->Form->input('firstname', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => "Student's First Name", 'required' => FALSE, 'name' => 'data[Child_user][firstname][]', 'value' => $children['Child_user']['firstname'])); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Student's Last Name</label>
                                        <div class="col-lg-6">
                                            <?php echo $this->Form->input('lastname', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => "Student's Last Name", 'name' => 'data[Child_user][lastname][]', 'value' => $children['Child_user']['lastname'])); ?>
                                        </div>
                                    </div>

                                    <div class="crossBtn">
                                        <input class="btn btn-default" style="float:right;margin-right: 29%;border-radius: 29px;" value="x" type="button" id="removeAdditional" child_id="<?php echo $children['Child_user']['id']; ?>" parent_id="<?php echo $children['Child_user']['user_id']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Student's Age</label>
                                        <div class="col-lg-6">
                                            <?php echo $this->Form->input('age', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => "Student's Age", 'name' => 'data[Child_user][age][]', 'value' => $children['Child_user']['age'])); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Subject</label>
                                        <div class="col-lg-6">
                                            <?php
                                            if (!empty($all_subjects)) {
                                                foreach ($all_subjects as $subject) {
                                                    $sub[$subject['Subject']['subject']] = $subject['Subject']['subject'];
                                                }
                                            }
                                            echo $this->Form->input('subject', array('class' => 'form-control', 'label' => FALSE, 'empty' => "-Subject-", 'name' => 'data[Child_user][subject][]', 'options' => @$sub, 'value' => $children['Child_user']['subject']));
                                            ?>
                                        </div>

                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            <input type="button" class="btn btn-danger" value="+" id="editmultipleStudents" style="float:right;margin-top:-17%;margin-right: 30%;">

                            <div id="showEditMultipleStudent"></div>
                            <!--Additional STudnet End-->

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Primary Phone Number<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <div class="input-group m-bot15">
                                        <span class="input-group-addon btn-white"><i class="fa fa-phone"></i></span>
                                        <?php echo $this->Form->input('primary_phone', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Primary Phone Number', 'required' => FALSE, 'value' => $student['User']['primary_phone'])); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Secondary Phone Number</label>
                                <div class="col-lg-6">
                                    <div class="input-group m-bot15">
                                        <span class="input-group-addon btn-white"><i class="fa fa-phone"></i></span>
                                        <?php echo $this->Form->input('secondary_phone', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Secondary Phone Number', 'value' => $student['User']['secondary_phone'])); ?>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Email<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <div class="input-group m-bot15">
                                        <span class="input-group-addon btn-white"><i class="fa fa-envelope"></i></span>
                                        <?php echo $this->Form->input('email', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Email', 'required' => FALSE, 'value' => $student['User']['email'])); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Address<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('address', array('class' => 'form-control', 'id'=>"autocomplete1",'label' => FALSE, 'placeholder' => 'Address', 'required' => FALSE, 'value' => $student['User']['address'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Apartment/Suite</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('suite', array('class' => 'form-control','id' => 'street_number', 'label' => FALSE, 'placeholder' => 'Apartment/Suite', 'required' => FALSE, 'value' => $student['User']['suite'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">City<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('city', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'City', 'required' => FALSE, 'value' => $student['User']['city'], 'id' => 'locality')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">State<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('state', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'State', 'required' => FALSE, 'value' => $student['User']['state'], 'id' => "administrative_area_level_1")); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Zip Code<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('zip_code', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Zip Code', 'required' => FALSE, 'value' => $student['User']['zip_code'], 'id' => "postal_code")); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Pricing Type<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    if (!empty($pricing_types)) {
                                        foreach ($pricing_types as $pt) {
                                            if($pt['Pricing_type']['id'] != '1') $pricing_type[$pt['Pricing_type']['id']] = $pt['Pricing_type']['name'];
                                        }
                                    }
                                    echo $this->Form->input('pricing_type', array('type' => 'select', 'label' => false, 'class' => 'form-control', 'empty' => '--Select Pricing Type--', 'options' => $pricing_type, 'required' => FALSE, 'value' => @$student['User']['pricing_type']));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Second Last Email</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('second_email', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Second Last Email', 'value' => @$student['User']['second_email'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Last Email</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('last_email', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Last Email', 'value' => @$student['User']['last_email'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Credit</label>


                                <div class="col-lg-2">
                                    <?php
                                    echo $this->Form->input('credit_hour', array('label' => false, 'placeholder' => '', 'class' => 'form-control fordisabled', 'required' => FALSE, 'disabled' => 'disabled', 'id' => 'hourToShow', 'value' => @$student['Total_hour']['hour']));
                                    ?>
                                    <span><i>Hours</i></span>
                                </div>

                                <div class="col-lg-2">
                                    <?php
                                    echo $this->Form->input('credit_minute', array('label' => false, 'placeholder' => '', 'class' => 'form-control fordisabled', 'required' => FALSE, 'disabled' => 'disabled', 'id' => 'minuteToshow', 'value' => @$student['Total_hour']['minutes']));
                                    ?>
                                    <span><i>Minutes</i></span>
                                </div>

                                <div class="col-lg-4">
                                    <button type="button" class="btn btn-danger" id="add_credit"><?php echo __('Add Credit'); ?></button>

                                    <button type="button" class="btn btn-danger" id ="subtract_credit"><?php echo __('Subtract Credit'); ?></button>

                                </div>



                                <input type="hidden" value="<?php echo $this->params['pass'][0]; ?>" class="student_id">
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Violin Pricing<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <label class="radio-inline">
                                        <input type="radio" name="data[User][voilin_price]" value="Yes" required="required" class="showViolinCredit" <?php
                                        if ($student['User']['voilin_price'] == 'Yes') {
                                            echo 'checked';
                                        }
                                        ?>>Yes             </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="data[User][voilin_price]" value="No" required="required" class="showViolinCredit" <?php
                                        if ($student['User']['voilin_price'] == 'No') {
                                            echo 'checked';
                                        }
                                        ?>>No
                                    </label>

                                </div>
                            </div>


                            <div class="form-group" id="showingViolinCredit" <?php if (($student['User']['voilin_price'] == 'No') || ($student['User']['voilin_price'] == '')) { ?>style="display: none;"<?php } ?>>

                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Violin Credit</label>


                                    <div class="col-lg-2">
                                        <?php
                                        echo $this->Form->input('voilin_hour', array('label' => false, 'placeholder' => '', 'class' => 'form-control fordisabled', 'required' => FALSE, 'disabled' => 'disabled', 'id' => 'voilinHours', 'value' => @$student['Voilin_hour']['voilin_hour']));
                                        ?>
                                        <span><i>Hours</i></span>
                                    </div>

                                    <div class="col-lg-2">
                                        <?php
                                        echo $this->Form->input('voilin_minute', array('label' => false, 'placeholder' => '', 'class' => 'form-control fordisabled', 'required' => FALSE, 'disabled' => 'disabled', 'id' => 'voilinMinutes', 'value' => @$student['Voilin_hour']['voilin_minute']));
                                        ?>
                                        <span><i>Minutes</i></span>
                                    </div>

                                    <div class="col-lg-4">
                                        <button type="button" class="btn btn-danger" id="add_voilin_credit"><?php echo __('Add Violin Credit'); ?></button>

                                        <button type="button" class="btn btn-danger" id ="subtract_voilin_credit"><?php echo __('Subtract Violin Credit'); ?></button>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Second Last Email</label>
                                    <div class="col-lg-6">
                                        <?php echo $this->Form->input('violin_second', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Second Last Email', 'value' => @$student['User']['violin_second'])); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Last Email</label>
                                    <div class="col-lg-6">
                                        <?php echo $this->Form->input('violin_last', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Last Email', 'value' => @$student['User']['violin_last'])); ?>
                                    </div>
                                </div>



                                <input type="hidden" value="<?php echo $this->params['pass'][0]; ?>" class="student_id">
                            </div>


                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button type="submit" class="btn btn-success"><?php echo __('Edit Student'); ?></button>
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
<style>
    .fordisabled{
        background: #fff !important;
    }
</style>