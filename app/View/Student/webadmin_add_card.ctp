<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Add Card Details
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="form">
                            <?php echo $this->Session->flash(); ?>  
                            <?php echo $this->Form->create('Payment_detail', array('url' => array('controller' => 'student', 'action' => 'add_card', $this->params['pass'][0], 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal')); ?>   

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Name On Card</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('name_on_card', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Name On Card')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Card Number</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('card_number', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Card Number', 'type' => 'text')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Card Type</label>
                                <div class="col-lg-6">
                                    <?php
                                    $card_type = array('American Express' => 'American Express', 'Discover' => 'Discover', 'Visa' => 'Visa', 'Master Card' => 'Master Card', 'JCB' => 'JCB', 'Diners Club' => 'Diners Club');

                                    echo $this->Form->input('card_type', array('class' => 'form-control', 'label' => FALSE, 'type' => 'select', 'options' => $card_type, 'empty' => '-Select-'));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Cvv</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('cvv', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Cvv', 'type' => 'text')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Expiry Date</label>
                                <div class="col-lg-3">
                                    <?php
                                    $months = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
                                    echo $this->Form->input('month', array('class' => 'form-control', 'label' => FALSE, 'empty' => '-Select-', 'type' => 'select', 'options' => $months));
                                    ?>
                                </div>

                                <div class="col-lg-3">
                                    <?php
                                    for ($year = 2016; $year <= 2050; $year++) {
                                        $years[$year] = $year;
                                    }
                                    echo $this->Form->input('year', array('class' => 'form-control', 'label' => FALSE, 'empty' => '-Select-', 'type' => 'select', 'options' => $years));
                                    ?>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">First Name</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('first_name', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'First Name', 'type' => 'text')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Last Name</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('last_name', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Last Name', 'type' => 'text')); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-4 control-label">Billing Address</label>
                                <div class="col-lg-6">
                                    <?php
                                    echo $this->Form->input('billing_address', array('class' => 'form-control', 'label' => FALSE, 'type' => 'select', 'options' => array('same' => 'Same as Home Address', 'different' => 'Different Address'), 'empty' => '-Select Billing Address-', 'id' => 'billing_address'));
                                    ?>
                                </div>
                            </div>

                            <div class="modal fade" id="BillAddress" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeIcon"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Add Billing Address</h4>
                                        </div>
                                        <div class="modal-body">

                                            <div class="col-md-12 form-group">
                                                <div class="col-lg-3">
                                                    Address Suite&nbsp;<span class="asterick">*</span>
                                                </div>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control address_suite" name="data[Payment_detail][address]">
                                                </div>
                                            </div>

                                            <div class="col-md-12 form-group">
                                                <div class="col-lg-3">
                                                    Apartment
                                                </div>
                                                <div class="col-lg-9">
                                                    <input type="text"  class="form-control apartment" name="data[Payment_detail][apartment]">
                                                </div>
                                            </div>

                                            <div class="col-md-12 form-group">
                                                <div class="col-lg-3">
                                                    City&nbsp;<span class="asterick">*</span>
                                                </div>
                                                <div class="col-lg-9">
                                                    <input type="text"  class="form-control city" name="data[Payment_detail][city]">
                                                </div>
                                            </div>


                                            <div class="col-md-12 form-group">
                                                <div class="col-lg-3">
                                                    State&nbsp;<span class="asterick">*</span>
                                                </div>
                                                <div class="col-lg-9">
                                                    <input type="text"  class="form-control state" name="data[Payment_detail][state]">
                                                </div>
                                            </div>


                                            <div class="col-md-12 form-group">
                                                <div class="col-lg-3">
                                                    Zip Code&nbsp;<span class="asterick">*</span>
                                                </div>
                                                <div class="col-lg-9">
                                                    <input type="text"  class="form-control zip_code" name="data[Payment_detail][zip_code]">
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="clearfix"></div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary saveBtn" id="addBillingAddress">Add</button>

                                        </div>
                                    </div>
                                </div>

                            </div>


                            <input type="hidden" id="student_id" value="<?php echo $this->params['pass'][0]; ?>">
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button type="submit" class="btn btn-primary" ><?php echo __('Add Card Details'); ?></button>
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
