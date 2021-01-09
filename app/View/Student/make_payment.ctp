<div class="new_ryt padding-right">
    <div class="right_side profile clearfix">
        <div class="col-md-12 payment_make">
            <h1> Make a Payment <a href="<?php echo BASE_URL . 'student/payments' ?>" class="loginbtn"> Change Payment Method </a>
            </h1>
        </div>
        <div class="clearfix"> </div>

        <!--profile_form start -->
        <div class="profile_form">
            <?php echo $this->Session->flash(); ?>  
            <?php echo $this->Form->create('Payment', array('url' => array('controller' => 'student', 'action' => 'make_payment'), 'id' => 'AddPageForm', 'class' => 'form-horizontal make_payment', 'onsubmit' => 'submitButton.disabled=true; return true;')); ?>
            <div class="form-group">
                <div class="col-md-12">
                    <label for="inputEmail3" class="col-md-3 col-sm-4 control-label">Select Card</label>
                    <div class="col-md-5 col-sm-8">
                        <div class="select-style">
                            <?php
                            if (!empty($find_cards)) {
                                foreach ($find_cards as $key => $cards) {

                                    $card[$cards['Payment_detail']['id']] = ucfirst($cards['Payment_detail']['first_name']) . ' ' . ucfirst($cards['Payment_detail']['last_name']) . ' (' . $cards['Payment_detail']['card_type'] . ') *' . substr(base64_decode($cards['Payment_detail']['card_number']), -4);
                                }
                            }

                            echo $this->Form->input('detail_id', array('class' => 'form-control', 'label' => FALSE, 'empty' => '-Select Card-', 'type' => 'select', 'options' => @$card));
                            ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label for="inputEmail3" class="col-md-3 col-sm-4 control-label">Subject</label>
                    <div class="col-md-5 col-sm-8">
                        <div class="select-style">
                            <?php
                            foreach ($subject as $subjects) {
                                if ((($get_user['User']['voilin_price'] == 'No') && $get_user['User']['pricing_type'] <= 3) && ($subjects['Subject']['subject'] == 'Violin')) {
                                    unset($subjects);
                                    $subjects = array();
                                }
                                if (!empty($subjects['Subject']['subject'])) {
                                    $sub[$subjects['Subject']['id']] = $subjects['Subject']['subject'];
                                }
                            }
                            echo $this->Form->input('subject', array('label' => FALSE, 'type' => 'select', 'empty' => '--Subject--', 'options' => $sub, 'class' => 'subject', 'id' => 'subjectSel', 'required' => FALSE));
                            ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label for="inputEmail3" class="col-md-3 col-sm-4 control-label">Packages & Pricing</label>
                    <div class="col-md-5 col-sm-8">
                        <div class="select-style">

                            <select name="data[Payment][package_price]" class="pack form-control" id="Show_pack">
                                <option value="">-Select-</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" class="duration" name="data[Payment][duration]">
            <div class="form-group">
                <div class="col-md-12">
                    <label for="inputEmail3" class="col-md-3 col-sm-4 control-label">Quantity</label>
                    <div class="col-md-5 col-sm-8">
                        <?php echo $this->Form->input('quantity', array('label' => FALSE, 'placeholder' => 'Quantity', 'class' => 'quantity form-control', 'id' => 'quanAdded', 'required' => FALSE)); ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <label for="inputEmail3" class="col-md-3 col-sm-4 col-xs-12 control-label">Coupon Code <i> (if any) </i></label>
                    <div class="col-md-3 col-sm-4 col-xs-8">
                        <?php echo $this->Form->input('coupon_code', array('label' => FALSE, 'class' => 'coupon form-control', 'placeholder' => 'Enter coupon code')); ?>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-4">
                        <button class="applyBtn apply" type="button"> Apply </button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="data[Payment][coupon_id]" id="coupon_id">
            <div class="infor payment clearfix">
                <div class="content clearfix">
                    <div class="col-md-3 col-sm-4"> <span> Total </span></div>
                    <div class="col-md-5 col-sm-5">
                        <p class="totalAmount"></p>
                    </div>
                </div>
                <div class="content clearfix">
                    <div class="col-md-3 col-sm-4"> <span> Discount </span></div>
                    <div class="col-md-5 col-sm-5">
                        <p class="DiscountValue"></p>
                    </div>
                </div>
                <div class="content clearfix">
                    <input id="youpay" type="hidden" name="data[Payment][youpay]" value="">
                    <div class="col-md-3 col-sm-4"> <span> You Pay </span></div>
                    <div class="col-md-5 col-sm-5"><p class="AfterDiscountAmount"></p>
                    </div>
                    <input id="total_time" type="hidden" name="data[Payment][total_time]" value="">

                </div>
                <input type="hidden" id="student_id" value="<?php echo $get_user['User']['id']; ?>">

                <div class="content clearfix">
                    <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
                        <div class="checkbox">
                            <!-- label><input type="checkbox" value=""> </label>&nbsp;
                            <p><i>Auto Renew at this Rate Once Credit is Completed.</i></p -->
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-md-offset-2 col-sm-4 col-xs-6">
                    <button class="btn btn-default loginbtn submitPayment" name="submitButton" id="submitButton" type="submit">Submit Payment</button>
                </div>

                <div class="col-md-3 col-sm-5 col-xs-6">
                    <button class="btn btn-default cancel_btn mk_pymt" type="reset">Cancel</button>
                </div>

            </div>
            <?php echo $this->Form->end(); ?>
        </div>
        <!--profile_form closed --> 
    </div>
</div>
</div>
</div>
<!--dashboard closed --> 
