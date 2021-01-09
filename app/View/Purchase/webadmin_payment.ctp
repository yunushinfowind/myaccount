
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        MAKE PAYMENT
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="form">
                            <?php echo $this->Session->flash(); ?>  
                            <?php echo $this->Form->create('Payment', array('url' => array('controller' => 'purchase', 'action' => 'payment', 'prefix' => 'webadmin', $this->params['pass'][0]), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal')); ?>   

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Name On Card</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('name_on_card', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Name on Card', 'required' => FALSE, 'value' => $payment_detail['Payment_detail']['name_on_card'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Card Number</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('card_number1', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Card Number', 'required' => FALSE, 'type' => 'text', 'value' => '*********' . substr(base64_decode($payment_detail['Payment_detail']['card_number']), -4))); ?>
                                    <input type="hidden" name="data[Payment][card_number]" value="<?php echo base64_decode($payment_detail['Payment_detail']['card_number']); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Card Type</label>
                                <div class="col-lg-6">
<?php
$card_type = array('American Express' => 'American Express', 'Discover' => 'Discover', 'Visa' => 'Visa', 'Master Card' => 'Master Card', 'JCB' => 'JCB', 'Diners Club' => 'Diners Club');
echo $this->Form->input('card_type', array('label' => FALSE, 'type' => 'select', 'empty' => '--Card Type--', 'options' => $card_type, 'required' => FALSE, 'class' => 'form-control', 'value' => $payment_detail['Payment_detail']['card_type']));
?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Cvv</label>
                                <div class="col-lg-6">

<?php echo $this->Form->input('cvv1', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Cvv Number', 'type' => 'text', 'value' => '**' . substr(base64_decode($payment_detail['Payment_detail']['cvv']), -1))); ?>
                                    <input type="hidden" name="data[Payment][cvv]" value="<?php echo base64_decode($payment_detail['Payment_detail']['cvv']); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Expiry Date</label>
                                <div class="col-lg-3">
<?php
$months = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
echo $this->Form->input('month', array('class' => 'form-control', 'label' => FALSE, 'empty' => '-Select Month-', 'type' => 'select', 'options' => $months, 'value' => $payment_detail['Payment_detail']['month']));
?>
                                </div>

                                <div class="col-lg-3">
                                    <?php
                                    for ($year = 2016; $year <= 2050; $year++) {
                                        $years[$year] = $year;
                                    }

                                    echo $this->Form->input('year', array('class' => 'form-control', 'label' => FALSE, 'empty' => '-Select Year-', 'type' => 'select', 'options' => $years, 'value' => $payment_detail['Payment_detail']['year']));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">First Name</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('first_name', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'First Name', 'required' => FALSE, 'value' => $payment_detail['Payment_detail']['first_name'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Last Name</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('last_name', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Last Name', 'required' => FALSE, 'value' => $payment_detail['Payment_detail']['last_name'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Address Suite</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('address', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Address Suite', 'required' => FALSE, 'value' => $payment_detail['Payment_detail']['address'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Apt#.</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('apartment', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Apt#.', 'required' => FALSE, 'value' => $payment_detail['Payment_detail']['apartment'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">City</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('city', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'City', 'required' => FALSE, 'value' => $payment_detail['Payment_detail']['city'])); ?>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">State</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('state', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'State', 'required' => FALSE, 'value' => $payment_detail['Payment_detail']['state'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Zip Code</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('zip_code', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Zip Code', 'required' => FALSE, 'value' => $payment_detail['Payment_detail']['zip_code'])); ?>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Amount</label>
                                <div class="col-lg-6">
                                    <div class="input-group m-bot15">
                                        <span class="input-group-addon btn-white"><i class="fa fa-dollar"></i></span>
                                        <?php echo $this->Form->input('amount', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Amount', 'required' => FALSE, 'type' => 'text')); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button type="submit" class="btn btn-success"><?php echo __('Make Payment'); ?></button>
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
