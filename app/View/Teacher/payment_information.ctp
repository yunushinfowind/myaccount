<div class="new_ryt">
    <div class="right_side profile clearfix">
        <?php
        if (!empty($detail)) {
            foreach ($detail as $details) {
                ?>
                <?php echo $this->Session->flash(); ?>
                <div class="col-md-12 payment_make">
                    <h2>Bank Details</h2>
                </div>
                <div class="clearfix"> </div>
                <div class="profile_form">

                    <?php echo $this->Form->create('Bank_detail', array('url' => array('controller' => 'teacher', 'action' => 'payment_information'), 'class' => 'clearfix')); ?>  

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="card-holder-name">Account Holder Name<span class="asterick">*</span></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->input('account_holder_name', array('label' => FALSE, 'class' => 'form-control', 'required' => FALSE, 'placeholder' => 'Account Holder Name', 'value' => @$details['Bank_detail']['account_holder_name'])); ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="card-number">Account Number<span class="asterick">*</span></label>
                        <div class="col-sm-9">
                            <?php
                            echo $this->Form->input('account_number', array('label' => FALSE, 'placeholder' => 'Account Number', 'class' => 'account_number form-control', 'type' => 'text', 'required' => FALSE, 'value' => '*************' . substr(base64_decode($details['Bank_detail']['account_number']), -4)));
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="card-number">Routing Number<span class="asterick">*</span></label>
                        <div class="col-sm-9">
                            <?php
                            echo $this->Form->input('routing_number', array('label' => FALSE, 'placeholder' => 'Routing Number', 'class' => 'routing_number form-control', 'type' => 'text', 'required' => FALSE, 'value' => '************' . substr(base64_decode($details['Bank_detail']['routing_number']), -4)));
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="cvv">Account Type<span class="asterick">*</span></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->input('account_type', array('class' => 'form-control col-sm-2', 'label' => FALSE, 'type' => 'select', 'empty' => '-Select Account Type-', 'options' => array('C' => 'Checking', 'S' => 'Savings'), 'required' => FALSE, 'value' => @$details['Bank_detail']['account_type'])); ?>                
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="bank">Set this account as Your Primary Account ?<span class="asterick">*</span></label>
                        <div class="col-sm-9">  
                            <div class="radio">
                                <label><input type="radio" name="data[Bank_detail][bank_account]" value='Yes' <?php
                                    if ($details['Bank_detail']['bank_account'] == 'Y') {
                                        echo 'checked';
                                    }
                                    ?>>Yes</label>
                                <label><input type="radio" name="data[Bank_detail][bank_account]" value='No' <?php
                                    if ($details['Bank_detail']['bank_account'] == 'N') {
                                        echo 'checked';
                                    }
                                    ?>>No</label>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <?php if (!empty($details)) {
                        ?>
                        <input type = "hidden" value="<?php echo $details['Bank_detail']['id']; ?>" name = "data[Bank_detail][id]">
                    <?php } ?>


                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">

                            <button type="submit" class="btn btn-success loginbtn">Save</button>

                            <?php
                            if (!empty($details) && $details['Bank_detail']['bank_account'] == 'N') {
                                ?>
                                <a href="<?php echo BASE_URL . 'teacher/delete_bank_detail/' . $details['Bank_detail']['id']; ?>"><button type="button" class="btn btn-success delete_detail_btn">Delete</button></a>
                            <?php } ?>

                        </div>

                    </div>

                    <?php echo $this->Form->end(); ?>
                </div>

            <?php } ?>
            <div class="show_bank_detail"></div>
            <button class="btn btn-default add_bank_detail cancel_btn" type="button">Add Additional Account</button>
        <?php } else {
            ?>
            <div class="col-md-12 payment_make">
                <h2>Bank Details</h2>
            </div>
            <div class="clearfix"> </div>
            <div class="profile_form">
                <?php echo $this->Session->flash(); ?>
                <?php echo $this->Form->create('Bank_detail', array('url' => array('controller' => 'teacher', 'action' => 'payment_information'), 'class' => 'clearfix')); ?>  

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="card-holder-name">Account Holder Name<span class="asterick">*</span></label>
                    <div class="col-sm-9">
                        <?php echo $this->Form->input('account_holder_name.', array('label' => FALSE, 'class' => 'form-control', 'required' => FALSE, 'placeholder' => 'Account Holder Name')); ?>

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="card-number">Account Number<span class="asterick">*</span></label>
                    <div class="col-sm-9">
                        <?php
                        echo $this->Form->input('account_number.', array('label' => FALSE, 'placeholder' => 'Account Number', 'class' => 'account_number form-control', 'type' => 'text', 'required' => FALSE));
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="card-number">Routing Number<span class="asterick">*</span></label>
                    <div class="col-sm-9">
                        <?php
                        echo $this->Form->input('routing_number.', array('label' => FALSE, 'placeholder' => 'Routing Number', 'class' => 'routing_number form-control', 'type' => 'text', 'required' => FALSE));
                        ?>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="cvv">Account Type<span class="asterick">*</span></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->input('account_type.', array('class' => 'form-control col-sm-2', 'label' => FALSE, 'type' => 'select', 'empty' => '-Select Account Type-', 'options' => array('C' => 'Checking', 'S' => 'Savings'), 'required' => FALSE)); ?>                
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="bank">Set this account as Your Primary Account ?<span class="asterick">*</span></label>
                        <div class="col-sm-9">
                            <div class="radio">
                                <label><input type="radio" name="data[Bank_detail][bank_account]" value='Y'>Yes</label>
                                <label><input type="radio" name="data[Bank_detail][bank_account]" value='N'>No</label>
                            </div>           
                        </div>
                    </div>


                    <div class="clearfix"></div>

                    <div class="show_bank_detail"></div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <?php if (empty($detail)) { ?>
                                <button class="btn btn-default add_bank_detail cancel_btn" type="button">Add Additional Account</button>
                            <?php } ?>
                            <button type="submit" class="btn btn-success loginbtn">Save</button>

                        </div>

                    </div>

                    <?php echo $this->Form->end(); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>


</div>
<!--dashboard closed --> 
<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
<script>
    $('body').on('click', '.addCard', function () {

        $(this).parent().prev().children().remove();
        $(this).parent().prev().append('<?php echo $this->Form->input('account_number', array('label' => FALSE, 'placeholder' => 'Account Number', 'class' => 'account_number form-control', 'type' => 'text', 'required' => FALSE, 'name' => 'data[Bank_detail][account_number]')); ?>');
    });
    $('body').on('click', '.addroute', function () {
        $(this).parent().prev().children().remove();
        $(this).parent().prev().append('<?php echo $this->Form->input('routing_number', array('label' => FALSE, 'placeholder' => 'Routing Number', 'class' => 'routing_number form-control', 'type' => 'text', 'required' => FALSE, 'name' => 'data[Bank_detail][routing_number]')); ?>');

    });



</script>

<script>
    $('body').on('click', '.add_bank_detail', function () {
        $('.show_bank_detail').append('<div class="profile_form"><form method="post" id="Bank_detailPaymentInformationForm" class="clearfix" action=""><div style="display:none;"><input type="hidden" value="POST" name="_method"></div><div class="form-group"><label for="card-holder-name" class="col-sm-3 control-label">Account Holder Name<span class="asterick">*</span></label><div class="col-sm-9"><div class="input text"><input type="text" id="Bank_detailAccountHolderName" maxlength="255" placeholder="Account Holder Name" class="form-control" name="data[Bank_detail][account_holder_name]"></div></div></div><div class="form-group"><label for="card-number" class="col-sm-3 control-label">Account Number<span class="asterick">*</span></label><div class="col-sm-9"><div class="input text"><input type="text" id="Bank_detailAccountNumber" class="account_number form-control" placeholder="Account Number" name="data[Bank_detail][account_number]"></div></div></div><div class="form-group"><label for="card-number" class="col-sm-3 control-label">Routing Number<span class="asterick">*</span></label><div class="col-sm-9"><div class="input text"><input type="text" id="Bank_detailRoutingNumber" class="routing_number form-control" placeholder="Routing Number" name="data[Bank_detail][routing_number]"></div></div></div><div class="form-group"><label for="cvv" class="col-sm-3 control-label">Account Type<span class="asterick">*</span></label><div class="col-sm-9"><div class="input select"><select id="Bank_detailAccountType" class="form-control col-sm-2" name="data[Bank_detail][account_type]"><option value="">-Select Account Type-</option><option value="C">Checking</option><option value="S">Savings</option></select></div></div></div><div class="form-group"><label for="bank" class="col-sm-3 control-label">Set this account as Your Primary Account ?<span class="asterick">*</span></label> <div class="col-sm-9"><div class="radio"><label><input type="radio" value="Y" name="data[Bank_detail][bank_account]">Yes</label><label><input type="radio" value="N" name="data[Bank_detail][bank_account]">No</label></div></div></div><div class="clearfix"></div><div class="form-group"><div class="col-sm-offset-3 col-sm-9"><button class="btn btn-success loginbtn" type="submit">Save</button></div></div></form></div>');

    });
</script>

<style>
    .addCard{
        /*        position: absolute;
                right: 64px;
                top: 11px;*/
        margin-top: 0px;
    }

    .addroute{
        /*        position: absolute;
                right: 64px;
                top: 11px;*/
        margin-top: 0px;
    }
    .expiryMonth .error-message{
        position: absolute;
        top:40px;
        clear: both;
    }
    .expiryYear .error-message{
        position: absolute;
        top:40px;
        clear: both;
    }
    .cardType .error-message{
        position: absolute;
        top:67px;
        clear: both;
    }
    .add_bank_detail{
        margin: 0px 15px;
    }
</style>