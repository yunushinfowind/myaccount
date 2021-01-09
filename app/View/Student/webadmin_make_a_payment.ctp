<?php
$id = $this->params['pass'][0];
?>
<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-dollar"></i>
                        MAKE A PAYMENT
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="form">
                            <?php echo $this->Session->flash(); ?>  
                            <?php echo $this->Form->create('Payment', array('url' => array('controller' => 'student', 'action' => 'make_a_payment', 'prefix' => 'webadmin', $this->params['pass'][0]), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal', 'onsubmit' => 'submitButton.disabled=true; return true;')); ?>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Select Card&nbsp;<span class="asterick">*</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    if (!empty($find_cards)) {
                                        foreach ($find_cards as $cards) {
                                            $card[$cards['Payment_detail']['id']] = ucfirst($cards['Payment_detail']['first_name']) . ' ' . ucfirst($cards['Payment_detail']['last_name']) . ' (' . $cards['Payment_detail']['card_type'] . ') *' . substr(base64_decode($cards['Payment_detail']['card_number']), -4);
                                        }
                                    }
                                    echo $this->Form->input('detail_id', array('class' => 'form-control', 'label' => FALSE, 'empty' => '-Select Card-', 'type' => 'select', 'options' => @$card, 'required' => FALSE));
                                    ?>
                                </div>
                            </div>



                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Subject&nbsp;<span class="asterick">*</span></label>
                                <div class="col-lg-6">
                                    <?php
                                    foreach ($subjects as $all_subjects) {
                                        //print_r( $all_subjects);echo("<br/>");
                                        if ((($user['User']['voilin_price'] == 'No') && $user['User']['pricing_type'] <= 3) && ($all_subjects['Subject']['subject'] == 'Violin')) {
                                            //echo $user['User']['voilin_price'].", ".$user['User']['pricing_type'].", ".$all_subjects['Subject']['subject']."<br/>";
                                            unset($all_subjects);
                                            $all_subjects = array();
                                        }
                                        if (!empty($all_subjects['Subject']['subject'])) {
                                            $sub[$all_subjects['Subject']['id']] = $all_subjects['Subject']['subject'];
                                        }
                                    }
                                    echo $this->Form->input('subject', array('class' => 'form-control', 'label' => FALSE, 'empty' => '-Select-', 'required' => FALSE, 'type' => 'select', 'options' => @$sub, 'id' => 'select_sub'));
                                    ?>

                                </div>
                            </div>


                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Pack&nbsp;<span class="asterick">*</span></label>
                                <div class="col-lg-6">
                                    <select name="data[Payment][pack]" class="form-control pack" id="get_pack">
                                        <option value="">-Select-</option>

                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Amount&nbsp;<span class="asterick">*</span></label>
                                <div class="col-lg-6">
                                    <div class="input-group m-bot15">
                                        <span class="input-group-addon btn-white"><i class="fa fa-dollar"></i></span>
                                        <?php echo $this->Form->input('amount', array('class' => 'form-control show_amt', 'label' => FALSE, 'placeholder' => 'Amount', 'required' => FALSE, 'type' => 'text')); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Notes</label>
                                <div class="col-lg-6">

                                    <?php echo $this->Form->input('notes', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Notes', 'type' => 'textarea')); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 auto-renew-check">
                                    <div class="checkbox auto-renew">
                                        <label><input type="checkbox" value=""> </label>&nbsp;
                                        <p><i>Auto Renew at this Rate Once Credit is Completed.</i></p>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" id="student_id" value="<?php echo $id; ?>">
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button type="submit" class="btn btn-success" name="submitButton" id="submitButton"><?php echo __('Make Payment'); ?></button>


                                    <button type="button" class="btn btn-danger" id="new_card_details"><?php echo __('Add New Card'); ?></button>
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
<style>
    .auto-renew > p {
        float: left;
        font-size: 16px;
        margin-top: 0;
    }.auto-renew-check{
        margin-left: 182px;
    }
</style>
