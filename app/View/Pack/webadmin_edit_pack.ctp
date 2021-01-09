<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Edit Package
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="form">
                            <?php echo $this->Session->flash(); ?>  
                            <?php echo $this->Form->create('Pack', array('url' => array('controller' => 'pack', 'action' => 'edit_pack', $this->params['pass'][0], 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal', 'enctype' => 'multipart/form-data')); ?>   

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Pack</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('pack', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Pack', 'required' => FALSE, 'value' => $pack['Pack']['pack'])); ?>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Total Duration</label>
                                <div class="col-lg-3">
                                    <?php echo $this->Form->input('hours', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Hours', 'required' => FALSE, 'value' => @$pack['Pack']['hours'])); ?>
                                </div>
                                <div class="col-lg-3">
                                    <?php
                                    for ($i = 5; $i <= 60; $i+=5) {
                                        $min[$i] = $i . ' Minutes';
                                    }
                                    echo $this->Form->input('minutes', array('class' => 'form-control', 'label' => FALSE, 'empty' => '-Select Minutes-', 'required' => FALSE, 'type' => 'select', 'options' => $min, 'value' => @$pack['Pack']['minutes']));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Order</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('order', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Order', 'required' => FALSE, 'value' => $pack['Pack']['order'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button type="submit" class="btn btn-primary"><?php echo __('Edit Package'); ?></button>
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
