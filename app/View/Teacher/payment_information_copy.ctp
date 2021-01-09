<div class="new_ryt">
    <div class="right_side profile clearfix">
        <div class="col-md-12 payment_make">
            <h2>Bank Detail </h2>
        </div>
        <div class="clearfix"> </div>
        <!--profile_form start -->
        <div class="profile_form">
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->Form->create('Bank_detail', array('url' => array('controller' => 'teacher', 'action' => 'payment_information'), 'class' => 'clearfix')); ?>  
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Account Holder Name<span class="asterick">*</span></label>
                            <?php echo $this->Form->input('account_holder_name', array('label' => FALSE, 'placeholder' => 'Account Holder Name', 'class' => 'form-control', 'required' => FALSE, 'value' => @$detail['Bank_detail']['account_holder_name'])); ?>
                        </div>
                    </div>
                    <div class="col-md-5 col-md-offset-1">

                        <div class="form-group">
                            <label for="exampleInputPassword1">Account Number<span class="asterick">*</span></label>
                            <?php
                            if (!empty($decoded_number)) {
                                echo $this->Form->input('account_number1', array('label' => FALSE, 'placeholder' => 'Account Number', 'class' => 'account_number1', 'type' => 'text', 'required' => FALSE, 'value' => @$decoded_number, 'disabled' => 'disabled'));
                                ?>
                                <button class="addCard btn btn-default loginbtn" type="button" >Add New</button>
                                <?php
                            } else {
                                echo $this->Form->input('account_number', array('label' => FALSE, 'placeholder' => 'Account Number', 'class' => 'account_number form-control', 'type' => 'text', 'required' => FALSE));
                            }
                            ?>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="col-md-5">

                        <div class="form-group">
                            <label for="exampleInputPassword1">Routing Number<span class="asterick">*</span></label>
                            <?php
                            if (!empty($decodeRoute)) {
                                echo $this->Form->input('routing_number1', array('label' => FALSE, 'placeholder' => 'Routing Number', 'class' => 'routing_number1', 'type' => 'text', 'required' => FALSE, 'value' => @$decodeRoute, 'disabled' => 'disabled'));
                                ?>
                                <button class="addroute btn btn-default loginbtn" type="button" >Add New</button>
                                <?php
                            } else {
                                echo $this->Form->input('routing_number', array('label' => FALSE, 'placeholder' => 'Routing Number', 'class' => 'routing_number form-control', 'type' => 'text', 'required' => FALSE));
                            }
                            ?>
                        </div>

                    </div>


                    <div class="col-md-5 col-md-offset-1">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Account Type<span class="asterick">*</span></label>
                            <div class="select-style cardType">
                                <?php
                                echo $this->Form->input('account_type', array('label' => FALSE, 'type' => 'select', 'empty' => '--Select Account Type--', 'options' => array('C' => 'Checking', 'S' => 'Saving'), 'required' => FALSE, 'value' => @$detail['Bank_detail']['account_type']));
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="col-md-12">
                <button class="btn btn-default loginbtn" type="submit">Save</button>
                <button class="btn btn-default cancel_btn" type="reset">Cancel</button>

            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
</div>


</div>
<!--dashboard closed --> 
<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
<script>
    $('body').on('click', '.addCard', function () {
        $(this).prev().children().remove();
        $(this).prev().append('<?php echo $this->Form->input('account_number', array('label' => FALSE, 'placeholder' => 'Account Number', 'class' => 'account_number formcontrol', 'type' => 'text', 'required' => FALSE, 'name' => 'data[Bank_detail][account_number]')); ?>');
    });
    $('body').on('click', '.addroute', function () {
        $(this).prev().children().remove();
        $(this).prev().append('<?php echo $this->Form->input('routing_number', array('label' => FALSE, 'placeholder' => 'Routing Number', 'class' => 'routing_number formcontrol', 'type' => 'text', 'required' => FALSE, 'name' => 'data[Bank_detail][routing_number]')); ?>');

    });
</script>


<style>
    .addCard{
        position: absolute;
        right: 64px;
        top: 11px;
    }

    .addCvv{
        position: absolute;
        right: 64px;
        top: 11px;
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
</style>