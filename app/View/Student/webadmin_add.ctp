<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Add Student
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="form form2 ">
                            <?php echo $this->Session->flash(); ?>  
                            <?php echo $this->Form->create('User', array('url' => array('controller' => 'student', 'action' => 'add', 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal', 'enctype' => 'multipart/form-data')); ?>   

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">First Name<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('first_name', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'First Name', 'required' => FALSE)); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Last Name<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('last_name', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Last Name', 'required' => FALSE)); ?>
                                </div>
                            </div>



                            <div class="form-group">

                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Student's First Name<span class="asterick"> *</span></label>
                                <div class="col-lg-6 stu_fnme">
                                    <?php echo $this->Form->input('student_firstname', array('class' => 'form-control ', 'label' => FALSE, 'placeholder' => "Student's First Name", 'required' => FALSE)); ?>
                                    <input type="button" class="btn btn-danger" value="+" id="multipleStudents"> 
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Student's Last Name</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('student_lastname', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => "Student's Last Name")); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Student's Age</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('student_age', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => "Student's Age")); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Subject<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    if (!empty($all_subjects)) {
                                        foreach ($all_subjects as $subjects) {
                                            $sub[$subjects['Subject']['subject']] = $subjects['Subject']['subject'];
                                        }
                                    }
                                    echo $this->Form->input('subject', array('class' => 'form-control', 'label' => FALSE, 'type' => 'select', 'empty' => "-Select-", 'options' => @$sub, 'required' => FALSE));
                                    ?>
                                </div>
                            </div>

                            <div id="showMultipleStudent"></div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Primary Phone Number<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <div class="input-group m-bot15">
                                        <span class="input-group-addon btn-white"><i class="fa fa-phone"></i></span>
                                        <?php echo $this->Form->input('primary_phone', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Primary Phone Number', 'required' => FALSE)); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Secondary Phone Number</label>
                                <div class="col-lg-6">
                                    <div class="input-group m-bot15">
                                        <span class="input-group-addon btn-white"><i class="fa fa-phone"></i></span>
                                        <?php echo $this->Form->input('secondary_phone', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Secondary Phone Number')); ?>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Email<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <div class="input-group m-bot15">
                                        <span class="input-group-addon btn-white"><i class="fa fa-envelope"></i></span>
                                        <?php echo $this->Form->input('email', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Email', 'required' => FALSE)); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Address<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <input id="autocomplete1" placeholder="Enter your address"  type="text" name="data[User][address]" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Apartment/Suite</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('suite', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Apartment/Suite', 'required' => FALSE, 'id' => 'street_number')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">City<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('city', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'City', 'required' => FALSE, 'id' => 'locality')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">State<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('state', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'State', 'required' => FALSE, 'id' => "administrative_area_level_1")); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Zip Code<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('zip_code', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Zip Code', 'required' => FALSE, 'id' => "postal_code")); ?>
                                </div>
                            </div>
                            <input type="hidden" id="latitude" name="data[User][latitude]">
                            <input type="hidden" id="longitude" name="data[User][longitude]">

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Pricing Type<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    if (!empty($pricing_types)) {
                                        foreach ($pricing_types as $pt) {
                                            if($pt['Pricing_type']['id'] != '1') $pricing_type[$pt['Pricing_type']['id']] = $pt['Pricing_type']['name'];
                                        }
                                    }
                                    echo $this->Form->input('pricing_type', array('type' => 'select', 'label' => false, 'class' => 'form-control', 'empty' => '--Select Pricing Type--', 'options' => $pricing_type, 'required' => FALSE));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Second Last Email</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('second_email', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Second Last Email', 'required' => FALSE)); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Last Email</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('last_email', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Last Email', 'required' => FALSE)); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Credit</label>


                                <div class="col-lg-3">
                                    <?php
                                    echo $this->Form->input('credit_hour', array('label' => false, 'placeholder' => '', 'class' => 'form-control', 'required' => FALSE, 'id' => 'hourToShow'));
                                    ?>
                                    <span><i>Hours</i></span>
                                </div>

                                <div class="col-lg-3">
                                    <?php
                                    echo $this->Form->input('credit_minute', array('type' => 'select', 'label' => false, 'empty' => '-Select Minutes-', 'class' => 'form-control', 'required' => FALSE, 'id' => 'minuteToshow', 'options' => array('15' => '15', '30' => '30', '45' => '45')));
                                    ?>
                                    <span><i>Minutes</i></span>
                                </div>


                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-2 control-label">Violin Pricing<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <label class="radio-inline">
                                        <input type="radio" name="data[User][voilin_price]" value="Yes" required="required" class="showViolinCredit">Yes             </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="data[User][voilin_price]" value="No" required="required" class="showViolinCredit" >No
                                    </label>

                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group" id="showingViolinCredit" style="display: none;">
                                    <div class="form-group">
                                        <label for="inputEmail1" class="col-lg-3 col-sm-2 control-label">Violin Credit</label>
                                        <div class="col-lg-3">
                                            <?php
                                            echo $this->Form->input('voilin_hour', array('label' => false, 'placeholder' => '', 'class' => 'form-control', 'required' => FALSE));
                                            ?>
                                            <span><i>Hours</i></span>
                                        </div>

                                        <div class="col-lg-3">
                                            <?php
                                            echo $this->Form->input('voilin_minute', array('type' => 'select', 'label' => false, 'empty' => '-Select Minutes-', 'class' => 'form-control', 'required' => FALSE, 'options' => array('15' => '15', '30' => '30', '45' => '45')));
                                            ?>
                                            <span><i>Minutes</i></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Second Last Email</label>
                                        <div class="col-lg-6">
                                            <?php echo $this->Form->input('violin_second', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Second Last Email', 'required' => FALSE)); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Last Email</label>
                                        <div class="col-lg-6">
                                            <?php echo $this->Form->input('violin_last', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Last Email', 'required' => FALSE)); ?>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button type="submit" class="btn btn-primary"><?php echo __('Add Student'); ?></button>
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

