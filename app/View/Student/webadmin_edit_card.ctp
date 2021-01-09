<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Edit Card Details
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="form">
                            <?php echo $this->Session->flash(); ?>  
                            <?php echo $this->Form->create('Payment_detail', array('url' => array('controller' => 'student', 'action' => 'edit_card', $this->params['pass'][0], 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal')); ?>   

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Name On Card</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('name_on_card', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Name On Card', 'value' => @$find_data['Payment_detail']['name_on_card'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Card Number</label>
                                <div class="col-lg-6">
                                    <?php
                                    if (!empty($find_data['Payment_detail']['card_number'])) {
                                        echo $this->Form->input('card_number', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Card Number', 'type' => 'text', 'value' => '*****' . substr(base64_decode(@$find_data['Payment_detail']['card_number']), -4)));
                                    } else {
                                        echo $this->Form->input('card_number', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Card Number', 'type' => 'text'));
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Card Type</label>
                                <div class="col-lg-6">
                                    <?php
                                    $card_type = array('American Express' => 'American Express', 'Discover' => 'Discover', 'Visa' => 'Visa', 'Master Card' => 'Master Card', 'JCB' => 'JCB', 'Diners Club' => 'Diners Club');

                                    echo $this->Form->input('card_type', array('class' => 'form-control', 'label' => FALSE, 'type' => 'select', 'options' => $card_type, 'empty' => '-Select-', 'value' => @$find_data['Payment_detail']['card_type']));
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Cvv</label>
                                <div class="col-lg-6">
                                    <?php
                                    if (!empty($find_data['Payment_detail']['cvv'])) {
                                        echo $this->Form->input('cvv', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Cvv', 'type' => 'text', 'value' => '**' . substr(base64_decode($find_data['Payment_detail']['cvv']), -1)));
                                    } else {
                                        echo $this->Form->input('cvv', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Cvv', 'type' => 'text'));
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Expiry Date</label>
                                <div class="col-lg-3">
                                    <?php
                                    $months = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
                                    echo $this->Form->input('month', array('class' => 'form-control', 'label' => FALSE, 'empty' => '-Select-', 'type' => 'select', 'options' => $months, 'value' => @$find_data['Payment_detail']['month']));
                                    ?>
                                </div>

                                <div class="col-lg-3">
                                    <?php
                                    for ($year = 2016; $year <= 2050; $year++) {
                                        $years[$year] = $year;
                                    }
                                    echo $this->Form->input('year', array('class' => 'form-control', 'label' => FALSE, 'empty' => '-Select-', 'type' => 'select', 'options' => $years, 'value' => @$find_data['Payment_detail']['year']));
                                    ?>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">First Name</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('first_name', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'First Name', 'type' => 'text', 'value' => @$find_data['Payment_detail']['first_name'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Last Name</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('last_name', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Last Name', 'type' => 'text', 'value' => @$find_data['Payment_detail']['last_name'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Address Suite</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('address', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Address Suite', 'type' => 'text', 'value' => @$find_data['Payment_detail']['address'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Apt.#</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('apartment', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Apartment Suite', 'type' => 'text', 'value' => @$find_data['Payment_detail']['apartment'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">City</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('city', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'City', 'type' => 'text', 'value' => @$find_data['Payment_detail']['city'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">State</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('state', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'State', 'type' => 'text', 'value' => @$find_data['Payment_detail']['state'])); ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Zip Code</label>
                                <div class="col-lg-6">
                                    <?php echo $this->Form->input('zip_code', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Zip Code', 'type' => 'text', 'value' => @$find_data['Payment_detail']['zip_code'])); ?>
                                </div>
                            </div>

<!--                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Mark as Primary</label>
                                <div class="col-lg-1">
                                    <?php
//                                    if (!empty($find_data['Payment_detail']['account_type'])) {
//                                        if ($find_data['Payment_detail']['account_type'] == 'primary') {
//                                            $cheked = 'checked';
//                                        }
//                                    }
                                    ?>
                                    <?php // echo $this->Form->input('account_type', array('class' => 'form-control', 'label' => FALSE, 'type' => 'checkbox', @$cheked)); ?>
                                </div>
                            </div>-->

                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button type="submit" class="btn btn-success"><?php echo __('Edit Card Details'); ?></button>
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
