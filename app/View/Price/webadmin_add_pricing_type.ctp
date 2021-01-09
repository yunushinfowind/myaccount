<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-dollar"></i>
                        Create New Pricing Type
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <?php echo $this->Session->flash(); ?>
                        <?php echo $this->Form->create('Pricing_type', array('url' => array('controller' => 'price', 'action' => 'add_pricing_type', 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal', 'enctype' => 'multipart/form-data')); ?>

                        <label>Name</label>
                        <?php echo $this->Form->input('name', array('label' => false, 'class' => 'form-control')); ?>

                        <br/><br/>

                        <?php echo $this->Form->checkbox('enabled', array('checked' => true)) ?>
                        <label>&nbsp;Enabled</label>



                        <div class="clearfix"></div>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6" style="margin-top:50px;">
                                <button type="submit" class="btn btn-success"><?php echo __('Create New Pricing Type'); ?></button>
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
