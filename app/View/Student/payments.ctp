<div class="new_ryt padding-right">
    <div class="right_side profile clearfix">
        <?php
        if (!empty($student)) {
            foreach ($student as $student_data) {
                ?>
                <div class="col-md-12 payment_make">
                    <h2> Credit Card Details <a href="<?php echo BASE_URL . 'student/make_payment' ?>" class="loginbtn"> Make a Payment </a> </h2>
                </div>
                <div class="clearfix"> </div>

                <!--profile_form start -->
                <div class="profile_form">
                    <!--nocache-->
                    <?php echo $this->Session->flash(); ?>
                    <!--/nocache-->
                    <?php echo $this->Form->create('Payment_detail', array('url' => array('controller' => 'student', 'action' => 'payments'), 'class' => 'clearfix')); ?>  
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name On Card<span class="asterick">*</span></label>
                                    <?php echo $this->Form->input('name_on_card', array('label' => FALSE, 'placeholder' => 'Name On Card', 'class' => 'form-control', 'required' => FALSE, 'value' => $student_data['Payment_detail']['name_on_card'])); ?>
                                </div>
                            </div>
                            <div class="col-md-5 col-md-offset-1">

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Card Number<span class="asterick">*</span></label>
                                    <?php
                                    echo $this->Form->input('card_number', array('label' => FALSE, 'placeholder' => 'Card Number', 'class' => 'card_number form-control', 'type' => 'text', 'required' => FALSE, 'value' => '*****' . substr(base64_decode($student_data['Payment_detail']['card_number']), -4)));
                                    ?>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Card Type<span class="asterick">*</span></label>
                                    <div class="select-style cardType">
                                        <?php
                                        $card_type = array('American Express' => 'American Express', 'Discover' => 'Discover', 'Visa' => 'Visa', 'Master Card' => 'Master Card', 'JCB' => 'JCB', 'Diners Club' => 'Diners Club');
                                        echo $this->Form->input('card_type', array('label' => FALSE, 'type' => 'select', 'empty' => '--Card Type--', 'options' => $card_type, 'required' => FALSE, 'value' => $student_data['Payment_detail']['card_type']));
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-md-offset-1">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">CVV<span class="asterick">*</span></label>
                                    <?php
                                    echo $this->Form->input('cvv', array('label' => false, 'class' => 'cvvNum form-control', 'placeholder' => 'CVV Number', 'type' => 'text', 'required' => FALSE, 'value' => '**' . substr(base64_decode($student_data['Payment_detail']['cvv']), -1)));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Expiry Date<span class="asterick">*</span></label>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="select-style expiryMonth">
                                                <?php
                                                $months = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
                                                echo $this->Form->input('month', array('type' => 'select', 'label' => FALSE, 'empty' => '--Select Month--', 'options' => $months, 'required' => FALSE, 'value' => $student_data['Payment_detail']['month']));
                                                ?>

                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <div class="select-style expiryYear">
                                                <?php
                                                for ($year = 2016; $year <= 2050; $year++) {
                                                    $years[$year] = $year;
                                                }
                                                ?>
                                                <?php echo $this->Form->input('year', array('label' => FALSE, 'type' => 'select', 'empty' => '--Select Year--', 'options' => $years, 'required' => FALSE, 'value' => $student_data['Payment_detail']['year'])); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-md-offset-1">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mark as Primary :<span class="asterick">*</span></label>
                                    <?php
                                    if (!empty($student_data['Payment_detail']['account_type'])) {

                                        if (($student_data['Payment_detail']['account_type'] == 'primary')) {
                                            $checked = 'checked';

                                            echo $this->Form->input('account_type', array('label' => false, 'class' => 'form-control mark-as-primary', 'type' => 'checkbox', $checked));
                                        } else {

                                            echo $this->Form->input('account_type', array('label' => false, 'class' => 'form-control mark-as-primary', 'type' => 'checkbox'));
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <h2> Billing Address </h2>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">First Name<span class="asterick">*</span></label>
                                    <?php echo $this->Form->input('first_name', array('label' => FALSE, 'class' => 'form-control', 'placeholder' => 'First Name', 'required' => FALSE, 'value' => $student_data['Payment_detail']['first_name'])); ?>
                                </div>
                            </div>
                            <div class="col-md-5 col-md-offset-1">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Last Name<span class="asterick">*</span></label>
                                    <?php echo $this->Form->input('last_name', array('label' => FALSE, 'placeholder' => 'Last Name', 'class' => 'form-control', 'required' => FALSE, 'value' => $student_data['Payment_detail']['last_name'])); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Address <span class="asterick">*</span></label>
                                    <?php echo $this->Form->input('address', array('label' => FALSE, 'placeholder' => 'Address', 'class' => 'form-control', 'type' => 'text', 'required' => FALSE, 'value' => $student_data['Payment_detail']['address'])); ?>
                                </div>
                            </div>
                            <div class="col-md-5 col-md-offset-1">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Apartment/Suite</label>
                                    <?php echo $this->Form->input('apartment', array('label' => FALSE, 'class' => 'form-control', 'placeholder' => 'Apartment/Suite', 'required' => FALSE, 'value' => $student_data['Payment_detail']['apartment'])); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">City<span class="asterick">*</span></label>
                                    <?php echo $this->Form->input('city', array('label' => FALSE, 'placeholder' => 'City', 'class' => 'form-control', 'required' => FALSE, 'value' => $student_data['Payment_detail']['city'])); ?>
                                </div>
                            </div>
                            <div class="col-md-5 col-md-offset-1">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">State<span class="asterick">*</span></label>
                                    <?php echo $this->Form->input('state', array('label' => FALSE, 'placeholder' => 'State', 'class' => 'form-control', 'required' => FALSE, 'value' => $student_data['Payment_detail']['state'])); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Zip Code<span class="asterick">*</span></label>
                                    <?php echo $this->Form->input('zip_code', array('label' => FALSE, 'class' => 'form-control', 'placeholder' => 'Zip Code', 'required' => FALSE, 'value' => $student_data['Payment_detail']['zip_code'])); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="data[Payment_detail][id]" value="<?php echo $student_data['Payment_detail']['id']; ?>">
                    <div class="col-md-12">
                        <button class="btn btn-default loginbtn" type="submit">Save</button>       
                        <?php
                        if (!empty($student_data['Payment_detail']['account_type'])) {
                            if ($student_data['Payment_detail']['account_type'] != 'primary') {
                                ?>
                                <a href="<?php echo BASE_URL . 'student/delete_card_detail/' . $student_data['Payment_detail']['id']; ?>"><button class="btn btn-default delete_detail_btn" type="button">Delete</button></a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
                <?php
            }
            ?>
            <?php
        } else {
            ?>
            <div class="col-md-12 payment_make">
                <h2> Credit Card Details <a href="<?php echo BASE_URL . 'student/make_payment' ?>" class="loginbtn"> Make a Payment </a> </h2>
            </div>
            <div class="clearfix"> </div>

            <!--profile_form start -->
            <div class="profile_form">
                <?php echo $this->Form->create('Payment_detail', array('url' => array('controller' => 'student', 'action' => 'payments'), 'class' => 'clearfix')); ?>  
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name On Card<span class="asterick">*</span></label>
                                <?php echo $this->Form->input('name_on_card', array('label' => FALSE, 'placeholder' => 'Name On Card', 'class' => 'form-control', 'required' => FALSE)); ?>
                            </div>
                        </div>
                        <div class="col-md-5 col-md-offset-1">

                            <div class="form-group">
                                <label for="exampleInputPassword1">Card Number<span class="asterick">*</span></label>
                                <?php
                                echo $this->Form->input('card_number', array('label' => FALSE, 'placeholder' => 'Card Number', 'class' => 'card_number form-control', 'type' => 'text', 'required' => FALSE));
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Card Type<span class="asterick">*</span></label>
                                <div class="select-style cardType">
                                    <?php
                                    $card_type = array('American Express' => 'American Express', 'Discover' => 'Discover', 'Visa' => 'Visa', 'Master Card' => 'Master Card', 'JCB' => 'JCB', 'Diners Club' => 'Diners Club');
                                    echo $this->Form->input('card_type', array('label' => FALSE, 'type' => 'select', 'empty' => '--Card Type--', 'options' => $card_type, 'required' => FALSE));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-md-offset-1">
                            <div class="form-group">
                                <label for="exampleInputPassword1">CVV<span class="asterick">*</span></label>
                                <?php
                                echo $this->Form->input('cvv', array('label' => false, 'class' => 'cvvNum form-control', 'placeholder' => 'CVV Number', 'type' => 'text', 'required' => FALSE));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Expiry Date<span class="asterick">*</span></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="select-style expiryMonth">
                                            <?php
                                            $months = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
                                            echo $this->Form->input('month', array('type' => 'select', 'label' => FALSE, 'empty' => '--Select Month--', 'options' => $months, 'required' => FALSE));
                                            ?>

                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="select-style expiryYear">
                                            <?php
                                            for ($year = 2016; $year <= 2026; $year++) {
                                                $years[$year] = $year;
                                            }
                                            ?>
                                            <?php echo $this->Form->input('year', array('label' => FALSE, 'type' => 'select', 'empty' => '--Select Year--', 'options' => $years, 'required' => FALSE)); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-md-offset-1">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mark as Primary</label>


                                <?php
                                echo $this->Form->input('account_type', array('label' => false, 'class' => 'form-control', 'type' => 'checkbox'));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Billing Address<span class="asterick">*</span></label>
                                <div class="select-style cardType">
                                    <?php
                                    echo $this->Form->input('billing_address', array('label' => FALSE, 'type' => 'select', 'empty' => '--Select Billing Address--', 'options' => array('same' => 'Same as Home Address', 'different' => 'Different Address'), 'required' => FALSE, 'id' => 'billing_address'));
                                    ?>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="modal fade" tabindex="-1" role="dialog" id="bill_address">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"><i class="fa fa-plus-circle"></i>&nbsp;Billing Address</h4>
                            </div>

                            <div class="modal-body">

                                <div class="col-md-12 form-group">
                                    <div class="col-lg-3">
                                        Address&nbsp;<span class="asterick">*</span>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="add" name="data[Payment_detail][address]">
                                    </div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <div class="col-lg-3">
                                        Apartment/Suite
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="text"  class="form-control" id="apt" name="data[Payment_detail][apartment]">
                                    </div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <div class="col-lg-3">
                                        City&nbsp;<span class="asterick">*</span>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="text"  class="form-control" id="city" name="data[Payment_detail][city]">
                                    </div>
                                </div>


                                <div class="col-md-12 form-group">
                                    <div class="col-lg-3">
                                        State&nbsp;<span class="asterick">*</span>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="text"  class="form-control" id="state" name="data[Payment_detail][state]">
                                    </div>
                                </div>


                                <div class="col-md-12 form-group">
                                    <div class="col-lg-3">
                                        Zip Code&nbsp;<span class="asterick">*</span>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="text"  class="form-control" id="zip" name="data[Payment_detail][zip_code]">
                                    </div>
                                </div>
                            </div> 
                            <div class="clearfix"></div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" style="background: #42acd1;border-color: #42acd1;" id="addBillAdd">Add Billing Address</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">First Name<span class="asterick">*</span></label>
                                <?php echo $this->Form->input('first_name', array('label' => FALSE, 'placeholder' => 'First Name', 'class' => 'form-control', 'required' => FALSE)); ?>
                            </div>
                        </div>
                        <div class="col-md-5 col-md-offset-1">

                            <div class="form-group">
                                <label for="exampleInputPassword1">Last Name<span class="asterick">*</span></label>
                                <?php
                                echo $this->Form->input('last_name', array('label' => FALSE, 'placeholder' => 'Last Name', 'class' => 'form-control', 'type' => 'text', 'required' => FALSE));
                                ?>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <button class="btn btn-default loginbtn" type="submit">Save</button>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        <?php } ?>
        <div class="show_credit_detail"></div>
        <button class="btn btn-default credit_card_Detail cancel_btn" type="button">Add Additional Account</button>
        <!--profile_form closed --> 

    </div>
</div>
</div>


</div>
<!--dashboard closed --> 
<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script>
    $('body').on('click', '.addCard', function () {
        $(this).prev().children().remove(); //Remove field html
        $(this).prev().append('<?php echo $this->Form->input('card_number', array('label' => FALSE, 'placeholder' => 'Card Number', 'class' => 'card_number formcontrol', 'type' => 'text', 'required' => FALSE, 'name' => 'data[Payment_detail][card_number]')); ?>');
    });
    $('body').on('click', '.addCvv', function () {
        $(this).prev().children().remove(); //Remove field html
        $(this).prev().append('<?php echo $this->Form->input('cvv', array('label' => FALSE, 'placeholder' => 'Cvv Number', 'class' => 'cvvNum formcontrol', 'type' => 'text', 'required' => FALSE, 'name' => 'data[Payment_detail][cvv]')); ?>');

    });
    $('.credit_card_Detail').on('click', function () {
        $('.show_credit_detail').append('<div class="profile_form"><form accept-charset="utf-8" method="post" id="Payment_detailPaymentsForm" class="clearfix" action="/student/payments"><div style="display:none;"><input type="hidden" value="POST" name="_method"></div><div class="row"><div class="col-md-12"><div class="col-md-5"><div class="form-group"><label for="exampleInputEmail1">Name On Card<span class="asterick">*</span></label><div class="input text"><input type="text" id="Payment_detailNameOnCard" maxlength="255" class="form-control" placeholder="Name On Card" name="data[Payment_detail][name_on_card]"></div></div></div><div class="col-md-5 col-md-offset-1"><div class="form-group"><label for="exampleInputPassword1">Card Number<span class="asterick">*</span></label><div class="input text"><input type="text" id="Payment_detailCardNumber" class="card_number form-control" placeholder="Card Number" name="data[Payment_detail][card_number]"></div></div></div></div></div><div class="row"><div class="col-md-12"><div class="col-md-5"><div class="form-group"><label for="exampleInputEmail1">Card Type<span class="asterick">*</span></label><div class="select-style cardType"><div class="input select"><select id="Payment_detailCardType" name="data[Payment_detail][card_type]"><option value="">--Card Type--</option><option value="American Express">American Express</option><option value="Discover">Discover</option><option value="Visa">Visa</option><option value="Master Card">Master Card</option><option value="JCB">JCB</option><option value="Diners Club">Diners Club</option></select></div></div></div></div><div class="col-md-5 col-md-offset-1"><div class="form-group"><label for="exampleInputPassword1">CVV<span class="asterick">*</span></label><div class="input text"><input type="text" id="Payment_detailCvv" placeholder="CVV Number" class="cvvNum form-control" name="data[Payment_detail][cvv]"></div></div></div></div></div><div class="row"><div class="col-md-12"><div class="col-md-5"><div class="form-group"><label for="exampleInputEmail1">Expiry Date<span class="asterick">*</span></label><div class="row"><div class="col-md-6"><div class="select-style expiryMonth"><div class="input select"><select id="Payment_detailMonth" name="data[Payment_detail][month]"><option value="">--Select Month--</option><option value="01">January</option><option value="02">February</option><option value="03">March</option><option value="04">April</option><option value="05">May</option><option value="06">June</option><option value="07">July</option><option value="08">August</option><option value="09">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select></div></div></div><div class="col-md-6"><div class="select-style expiryYear"><div class="input select"><select id="Payment_detailYear" name="data[Payment_detail][year]"><option value="">--Select Year--</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option></select></div></div></div></div></div></div><div class="col-md-5 col-md-offset-1"><div class="form-group"><label for="exampleInputPassword1">Mark as Primary<span class="asterick">*</span></label><input type="checkbox" id="Payment_detailAccountType" class="form-control" name="data[Payment_detail][account_type]"></div></div></div></di<div class="row"><div class="col-md-12"><div class="col-md-5"><div class="form-group"><label for="exampleInputEmail1">Billing Address<span class="asterick">*</span></label><div class="select-style cardType"><select id="billingAddress" name="data[Payment_detail][billing_address]"><option value="">--Select Billing Address--</option><option value="same">Same as Home Address</option><option value="different">Different Address</option></select></div></div></div></div></div><div class="modal fade billing_address_pop" tabindex="-1" role="dialog"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title"><i class="fa fa-plus-circle"></i>&nbsp;Billing Address</h4></div><div class="modal-body"><div class="col-md-12 form-group"><div class="col-lg-3">Address&nbsp;<span class="asterick">*</span></div><div class="col-lg-9"><input type="text" class="form-control address_app" name="data[Payment_detail][address]"></div></div><div class="col-md-12 form-group"><div class="col-lg-3">Apartment/Suite</div><div class="col-lg-9"><input type="text"  class="form-control apt_app" name="data[Payment_detail][apartment]"></div></div><div class="col-md-12 form-group"><div class="col-lg-3">City&nbsp;<span class="asterick">*</span></div><div class="col-lg-9"><input type="text"  class="form-control city_app" name="data[Payment_detail][city]"></div></div><div class="col-md-12 form-group"><div class="col-lg-3">State&nbsp;<span class="asterick">*</span></div><div class="col-lg-9"><input type="text"  class="form-control state_app" name="data[Payment_detail][state]"></div></div><div class="col-md-12 form-group"><div class="col-lg-3">Zip Code&nbsp;<span class="asterick">*</span></div><div class="col-lg-9"><input type="text"  class="form-control zip_app" name="data[Payment_detail][zip_code]"></div></div></div><div class="clearfix"></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button type="button" class="btn btn-primary addBillAdd_app" style="background: #42acd1;border-color: #42acd1;">Add Billing Address</button></div></div></div></div><div class="row"><div class="col-md-12"><div class="col-md-5"><div class="form-group"><label for="exampleInputEmail1">First Name<span class="asterick">*</span></label><div class="input text"><input type="text" id="Payment_detailFirstName" maxlength="255" placeholder="First Name" class="form-control" name="data[Payment_detail][first_name]"></div></div></div><div class="col-md-5 col-md-offset-1"><div class="form-group"><label for="exampleInputEmail1">Last Name<span class="asterick">*</span></label><div class="input text"><input type="text" id="Payment_detailLastName" maxlength="255" class="form-control" placeholder="Last Name" name="data[Payment_detail][last_name]"></div></div></div></div></div><div class="col-md-12"><button type="submit" class="btn btn-default loginbtn">Save</button></div></form></div>');
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
    .credit_card_Detail{
        margin: 0px 15px;
        /*width: 17%;*/
    }
    #Payment_detailAccountType {
        cursor: pointer;
        left: 157px;
        position: absolute;
        top: -6px;
        width: auto;
    }
    #Payment_detailAccountType.mark-as-primary {
        cursor: pointer;
        left: 171px;
        position: absolute;
        top: -48px;
        width: auto;
    }

</style>



