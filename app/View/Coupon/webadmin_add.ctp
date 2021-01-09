<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Add Coupon
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="form">
                            <?php echo $this->Session->flash(); ?>  
                            <?php echo $this->Form->create('Coupon', array('url' => array('controller' => 'coupon', 'action' => 'add', 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal', 'enctype' => 'multipart/form-data')); ?>   

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Coupon Type<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    $coupon_type = array('Single User' => 'Single User', 'Multi User' => 'Multi User');
                                    echo $this->Form->input('coupon_type', array('class' => 'form-control', 'label' => FALSE, 'empty' => '--Coupon Type--', 'required' => FALSE, 'type' => 'select', 'options' => $coupon_type));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Coupon Code<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    echo $this->Form->input('coupon_code', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Coupon Code', 'required' => FALSE));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Discount Type<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    $discount_type = array('%' => '%', '$' => '$');
                                    echo $this->Form->input('discount_type', array('class' => 'form-control', 'label' => FALSE, 'empty' => '--Discount Type--', 'required' => FALSE, 'type' => 'select', 'options' => $discount_type));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Discount Value<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    echo $this->Form->input('discount_value', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Discount Value', 'required' => FALSE));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label"> Coupon Start Date<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    echo $this->Form->input('start_date', array('class' => 'form-control', 'id' => 'start_date', 'label' => FALSE, 'required' => FALSE, 'placeholder' => '--Select Start Date--'));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Coupon End Date<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    echo $this->Form->input('end_date', array('class' => 'form-control', 'id' => 'end_date', 'label' => FALSE, 'required' => FALSE, 'placeholder' => '--Select End Date--'));
                                    ?>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button type="submit" class="btn btn-success"><?php echo __('Add Coupon'); ?></button>
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

