<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        MANAGE CREDENTIALS
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="form">
			    <?php echo $this->Session->flash(); ?>  
			    <?php echo $this->Form->create('Authorize', array('url' => array('controller' => 'setting', 'action' => 'authorize_credentials', 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal')); ?>   

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Mode</label>
                                <div class="col-lg-6">
				    <?php
				    $options = array('live' => 'Live', 'sandbox' => 'Sandbox');
				    echo $this->Form->input('mode', array('class' => 'form-control', 'label' => FALSE, 'empty' => '-Select-', 'required' => FALSE, 'type' => 'select', 'options' => $options, 'value' => @$credentials['Authorize']['mode']));
				    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Live Key</label>
                                <div class="col-lg-6">
				    <?php echo $this->Form->input('live_key', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Live Key', 'required' => FALSE, 'value' => @$credentials['Authorize']['live_key'])); ?>
                                </div>
                            </div>

			    <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Live Secret</label>
                                <div class="col-lg-6">
				    <?php echo $this->Form->input('live_secret', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Live Secret', 'required' => FALSE, 'value' => @$credentials['Authorize']['live_secret'])); ?>
                                </div>
                            </div>

			    <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Sandbox Key</label>
                                <div class="col-lg-6">
				    <?php echo $this->Form->input('sandbox_key', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Sandbox Key', 'required' => FALSE, 'value' => @$credentials['Authorize']['sandbox_key'])); ?>
                                </div>
                            </div>

			    <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Sandbox Secret</label>
                                <div class="col-lg-6">
				    <?php echo $this->Form->input('sandbox_secret', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Sandbox Secret', 'required' => FALSE, 'value' => @$credentials['Authorize']['sandbox_secret'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button type="submit" class="btn btn-success"><?php echo __('Update'); ?></button>
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
