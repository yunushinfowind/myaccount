<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Change Password
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="form">
                            <?php echo $this->Session->flash(); ?>  
                            <?php echo $this->Form->create('Admin', array('url' => array('controller' => 'login', 'action' => 'change_password', 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal')); ?>   

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Old Password</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('old_password', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Old Password', 'required' => FALSE, 'type' => 'password')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">New Password</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('new_password', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'New Password', 'required' => FALSE, 'type' => 'password')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Confirm Password</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('confirm_password', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Confirm Password', 'required' => FALSE, 'type' => 'password')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button type="submit" class="btn btn-success"><?php echo __('Change Password'); ?></button>
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
