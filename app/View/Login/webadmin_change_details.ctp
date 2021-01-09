<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        ADMIN
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="form">
			    <?php echo $this->Session->flash(); ?>  
			    <?php echo $this->Form->create('Admin', array('url' => array('controller' => 'login', 'action' => 'change_details', 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal', 'enctype' => 'multipart/form-data')); ?>   

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Username</label>
                                <div class="col-lg-6">
				    <?php echo $this->Form->input('username', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'User Name', 'required' => FALSE, 'value' => @$admin_detail['Admin']['username'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Email</label>
                                <div class="col-lg-6">
				    <?php echo $this->Form->input('email', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Email', 'required' => FALSE, 'value' => @$admin_detail['Admin']['email'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Image</label>
                                <div class="col-lg-6">
				    <?php
				    if (!empty($admin_detail['Admin']['image'])) {
					?>
    				    <img src="<?php echo $this->webroot . 'img/admin_images/' . $admin_detail['Admin']['image']; ?>" style="width: 100px;height:100px;"> &nbsp; &nbsp;
    				    <i class="fa fa-times" id="remove_image" style="cursor: pointer;"></i>

				    <?php } ?>
				    <?php echo $this->Form->input('image', array('label' => FALSE, 'type' => 'file', 'style' => 'margin-top:10px;')); ?>
                                </div>
                            </div>
                            <input type="hidden" value="<?php echo $admin_detail['Admin']['id']; ?>" class="admin_id">

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button type="submit" class="btn btn-success"><?php echo __('Add Details'); ?></button>
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
