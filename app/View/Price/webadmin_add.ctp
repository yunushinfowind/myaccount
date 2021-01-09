<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Add Pricing
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="form">
			    <?php echo $this->Session->flash(); ?>  
			    <?php echo $this->Form->create('Price', array('url' => array('controller' => 'price', 'action' => 'add', 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal', 'enctype' => 'multipart/form-data')); ?>   

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Pricing Type<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
				    <?php
				    //$pricing_type = array('3' => 'Old Rate', '2' => 'Regular Price', '1' => 'Violin Price');
                    foreach ($pricing_types as $pt) {
                        $pricing_type[$pt['Pricing_type']['id']] = $pt['Pricing_type']['name'];
                    }
				    echo $this->Form->input('pricing_type', array('type' => 'select', 'label' => false, 'class' => 'form-control', 'empty' => '--Select Pricing Type--', 'options' => $pricing_type, 'required' => FALSE));
				    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Pack<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
				    <?php
				    foreach ($packs as $pack) {
					$packs_are[$pack['Pack']['pack'] . ',' . $pack['Pack']['duration']] = $pack['Pack']['pack'];
				    }
				    ?>
				    <?php echo $this->Form->input('pack', array('type' => 'select', 'label' => FALSE, 'class' => 'form-control', 'empty' => '--Select Pack--', 'options' => $packs_are, 'required' => FALSE)); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Price<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <div class="input-group m-bot15">
                                        <span class="input-group-addon btn-white"><i class="fa fa-dollar"></i></span>
					<?php echo $this->Form->input('price', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Price', 'required' => FALSE)); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button type="submit" class="btn btn-primary"><?php echo __('Add Pricing'); ?></button>
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
