<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Edit Basic Information
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="form">
                            <?php echo $this->Session->flash(); ?>  
                            <?php echo $this->Form->create('User', array('url' => array('controller' => 'teacher', 'action' => 'edit_basic', $this->params['pass'][0], 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal', 'enctype' => 'multipart/form-data')); ?>   
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">First Name<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('first_name', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'First Name', 'required' => FALSE, 'value' => $teacher['User']['first_name'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Last Name<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('last_name', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Last Name', 'required' => FALSE, 'value' => $teacher['User']['last_name'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Primary Phone Number<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <div class="input-group m-bot15">
                                        <span class="input-group-addon btn-white"><i class="fa fa-phone"></i></span>
                                        <?php echo $this->Form->input('primary_phone', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Primary Phone Number', 'required' => FALSE, 'value' => $teacher['User']['primary_phone'])); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Secondary Phone Number</label>
                                <div class="col-lg-6">
                                    <div class="input-group m-bot15">
                                        <span class="input-group-addon btn-white"><i class="fa fa-phone"></i></span>
                                        <?php echo $this->Form->input('secondary_phone', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Secondary Phone Number', 'value' => $teacher['User']['secondary_phone'])); ?>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Email<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <div class="input-group m-bot15">
                                        <span class="input-group-addon btn-white"><i class="fa fa-envelope"></i></span>
                                        <?php echo $this->Form->input('email', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Email', 'required' => FALSE, 'value' => $teacher['User']['email'])); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Address<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('address', array('class' => 'form-control', 'id' => 'autocomplete2', 'label' => FALSE, 'placeholder' => 'Address', 'required' => FALSE, 'value' => $teacher['User']['address'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Apartment/Suite</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('suite', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Apartment/Suite', 'required' => FALSE, 'value' => $teacher['User']['suite'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">City<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('city', array('class' => 'form-control','id' => 'teacher_city', 'label' => FALSE, 'placeholder' => 'City', 'required' => FALSE, 'value' => $teacher['User']['city'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">State<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('state', array('class' => 'form-control', 'id' => 'teacher_state','label' => FALSE, 'placeholder' => 'State', 'required' => FALSE, 'value' => $teacher['User']['state'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Zip Code<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('zip_code', array('class' => 'form-control','id' => 'teacher_zip', 'label' => FALSE, 'placeholder' => 'Zip Code', 'required' => FALSE, 'value' => $teacher['User']['zip_code'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Hourly Rate ($)<span class="asterick">*</span></label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('hourly_rate', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Hourly Rate', 'required' => FALSE, 'value' => $teacher['User']['hourly_rate'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button type="submit" class="btn btn-success"><?php echo __('Edit basic Information'); ?></button>
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
