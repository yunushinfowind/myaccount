<div class="col-md-12 form-group">
    <div class="col-lg-3">
        Name On Card <span class="asterick">*</span>
    </div>
    <div class="col-lg-9">
        <?php echo $this->Form->input('name_on_card', array('class' => 'form-control', 'id' => 'edit_name_on_card', 'label' => FALSE, 'value' => $payment_detail['Payment_detail']['name_on_card'])); ?>
    </div>
</div>

<div class="col-md-12 form-group">
    <div class="col-lg-3">
        Card Number<span class="asterick">*</span>
    </div>
    <div class="col-lg-9">
        <?php echo $this->Form->input('card_number', array('class' => 'form-control', 'id' => 'edit_card_number', 'label' => FALSE, 'value' => '*******' . substr(base64_decode($payment_detail['Payment_detail']['card_number']), -4))); ?>
    </div>
</div>

<div class="col-md-12 form-group">
    <div class="col-lg-3">
        Card Type<span class="asterick">*</span>
    </div>
    <div class="col-lg-9">
        <?php
        $card_type = array('American Express' => 'American Express', 'Discover' => 'Discover', 'Visa' => 'Visa', 'Master Card' => 'Master Card', 'JCB' => 'JCB', 'Diners Club' => 'Diners Club');
        echo $this->Form->input('card_type', array('class' => 'form-control', 'id' => 'edit_card_type', 'label' => FALSE, 'type' => 'select', 'options' => $card_type, 'empty' => '-Select-', 'value' => $payment_detail['Payment_detail']['card_type']));
        ?>
    </div>
</div>

<div class="col-md-12 form-group">
    <div class="col-lg-3">
        Cvv<span class="asterick">*</span>
    </div>
    <div class="col-lg-9">
        <?php echo $this->Form->input('cvv', array('class' => 'form-control', 'id' => 'edit_cvv', 'label' => FALSE, 'value' => '**' . substr(base64_decode($payment_detail['Payment_detail']['cvv']), -1))); ?>
    </div>
</div>  

<div class="col-md-12 form-group">
    <div class="col-lg-3">
        Expiry Date<span class="asterick">*</span>
    </div>
    <div class="col-lg-5">
        <?php
        $months = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
        echo $this->Form->input('month', array('class' => 'form-control', 'id' => 'edit_month', 'label' => FALSE, 'type' => 'select', 'empty' => '-Select-', 'options' => $months, 'value' => $payment_detail['Payment_detail']['month']));
        ?>
    </div>
    <div class="col-lg-4">
        <?php
        for ($year = 2016; $year <= 2050; $year++) {
            $years[$year] = $year;
        }
        echo $this->Form->input('year', array('class' => 'form-control', 'id' => 'edit_year', 'label' => FALSE, 'type' => 'select', 'empty' => '-Select-', 'options' => $years, 'value' => $payment_detail['Payment_detail']['year']));
        ?>
    </div>
</div> 

<div class="col-md-12 form-group">
    <div class="col-lg-3">
        First Name<span class="asterick">*</span>
    </div>
    <div class="col-lg-9">
        <?php echo $this->Form->input('first_name', array('class' => 'form-control', 'id' => 'edit_first_name', 'label' => FALSE, 'value' => $payment_detail['Payment_detail']['first_name'])); ?>
    </div>
</div>

<div class="col-md-12 form-group">
    <div class="col-lg-3">
        Last Name<span class="asterick">*</span>
    </div>
    <div class="col-lg-9">
        <?php echo $this->Form->input('last_name', array('class' => 'form-control', 'id' => 'edit_last_name', 'label' => FALSE, 'value' => $payment_detail['Payment_detail']['last_name'])); ?>
    </div>
</div> 

<div class="col-md-12 form-group">
    <div class="col-lg-3">
        Address<span class="asterick">*</span>
    </div>
    <div class="col-lg-9">
        <?php echo $this->Form->input('address', array('class' => 'form-control', 'id' => 'edit_address', 'label' => FALSE, 'value' => $payment_detail['Payment_detail']['address'])); ?>
    </div>
</div> 

<div class="col-md-12 form-group">
    <div class="col-lg-3">
        Apartment/Suite
    </div>
    <div class="col-lg-9">
        <?php echo $this->Form->input('apartment', array('class' => 'form-control', 'id' => 'edit_apt', 'label' => FALSE, 'value' => $payment_detail['Payment_detail']['apartment'])); ?>
    </div>
</div> 

<div class="col-md-12 form-group">
    <div class="col-lg-3">
        City<span class="asterick">*</span>
    </div>
    <div class="col-lg-9">
        <?php echo $this->Form->input('city', array('class' => 'form-control', 'id' => 'edit_city', 'label' => FALSE, 'value' => $payment_detail['Payment_detail']['city'])); ?>
    </div>
</div> 

<div class="col-md-12 form-group">
    <div class="col-lg-3">
        State<span class="asterick">*</span>
    </div>
    <div class="col-lg-9">
        <?php echo $this->Form->input('state', array('class' => 'form-control', 'id' => 'edit_state', 'label' => FALSE, 'value' => $payment_detail['Payment_detail']['state'])); ?>
    </div>
</div> 

<div class="col-md-12 form-group">
    <div class="col-lg-3">
        Zip Code<span class="asterick">*</span>
    </div>
    <div class="col-lg-9">
        <?php echo $this->Form->input('zip_code', array('class' => 'form-control', 'id' => 'edit_zip_code', 'label' => FALSE, 'value' => $payment_detail['Payment_detail']['zip_code'])); ?>
    </div>
</div> 