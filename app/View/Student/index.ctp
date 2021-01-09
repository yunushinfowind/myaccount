<style>
    .studnt_dash i{
    }
    .mini-stat-icon {
        background: #eee none repeat scroll 0 0;
        border-radius: 100%;
        color: #fff;
        display: inline-block;
        float: left;
        font-size: 30px;
        height: 60px;
        line-height: 60px;
        margin-right: 10px;
        text-align: center;
        width: 60px;
    }
    .orange {
        background: #fa8564 none repeat scroll 0 0 !important;
    }
    .mini-stat {
        background: #fff none repeat scroll 0 0;
        border-radius: 3px;
        margin-bottom: 20px;
        padding: 20px;
        border:4px solid #eee;
    }
    .mini-stat-info {
        font-size: 12px;
        padding-top: 2px;
    }
    .mini-stat-info span {
        display: block;
        font-size: 24px;
        font-weight: 600;
    }
    .mini-stat .green {
        background: #aec785 none repeat scroll 0 0 !important;
    }

    .mini-stat  .purple {
        background: #a48ad4 none repeat scroll 0 0 !important;
    }
    .mini-stat  .yellow {
        background: yellow none repeat scroll 0 0 !important;
    }
    .mini-stat  .tar {
        background: #1fb5ac none repeat scroll 0 0 !important;
    }
    .right_side a{
        color:#000;
    }


</style>


<div class="new_ryt padding-right">
    <div class="right_side clearfix">
        <?php echo $this->Session->Flash(); ?>
        <div class="col-md-12">
            <div class="new_ryt_dashboard">
                <div class="next_scheduled_lesson">
                    <div class="col-md-4 col-sm-4 text-center">
                        <a href="<?php echo BASE_URL . 'student/' ?>">
                            <div class="mini-stat clearfix">
                                <div class=" mini-stat-icon orange">
                                    <i class="fa fa-dashboard"></i>
                                </div>
                                <div class="mini-stat-info ">
                                    <span>Dashboard</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 col-sm-4 text-center">
                        <a href="<?php echo BASE_URL . 'student/my_info/' ?>">
                            <div class="mini-stat clearfix">
                                <div class=" mini-stat-icon purple">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="mini-stat-info ">
                                    <span>My Info</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 col-sm-4 text-center">
                        <a href="<?php echo BASE_URL . 'student/messages/' ?>">
                            <div class="mini-stat clearfix">
                                <div class=" mini-stat-icon green">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <div class="mini-stat-info ">
                                    <span>Messages</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 col-sm-4 text-center">
                        <a href="<?php echo BASE_URL . 'student/payments/' ?>">
                            <div class="mini-stat clearfix">
                                <div class=" mini-stat-icon tar">
                                    <i class="fa fa-database"></i>
                                </div>
                                <div class="mini-stat-info ">
                                    <span>Payment </span>
                                    <h4> Information</h4>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 col-sm-4 text-center">
                        <a href="<?php echo BASE_URL . 'student/make_payment/' ?>">
                            <div class="mini-stat clearfix">
                                <div class=" mini-stat-icon yellow">
                                    <i class="fa fa-book"></i>
                                </div>
                                <div class="mini-stat-info ">
                                    <span>Make A </span>
                                    <h4>Payment</h4>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 col-sm-4 text-center">
                        <a href="<?php echo BASE_URL . 'student/purchase_history/' ?>">
                            <div class="mini-stat clearfix">
                                <div class=" mini-stat-icon orange">
                                    <i class="fa fa-dollar"></i>
                                </div>
                                <div class="mini-stat-info ">
                                    <span>Purchase </span>
                                    <h4>History</h4>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 col-sm-4 text-center">
                        <a href="<?php echo BASE_URL . 'student/completed_lessons/' ?>">
                            <div class="mini-stat clearfix">
                                <div class=" mini-stat-icon purple">
                                    <i class="fa fa-thumbs-up"></i>
                                </div>
                                <div class="mini-stat-info ">
                                    <span>Completed </span>
                                    <h4>Lessons</h4>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4 col-sm-4 text-center">
                        <a href="<?php echo BASE_URL . 'student/my_teachers/' ?>">
                            <div class="mini-stat clearfix">
                                <div class=" mini-stat-icon green">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="mini-stat-info ">
                                    <span>My Teacher's</span>

                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="next_schedule_inner">
			<h1>Next Scheduled Lesson</h1>
                        <div class="row">
                            <div class="col-xs-3"><span>Date:</span></div>

                            <div class="col-xs-9"><p><?php
                                    if (!empty($get_data['Calendar']['start_date']) && isset($get_data['Calendar']['start_date'])) {
                                        echo date('m/d/Y', strtotime($get_data['Calendar']['start_date']));
                                    } else {
                                        echo "-";
                                    }
                                    ?></p>

                            </div>


                        </div>

<!--                    </div>

                    <div class="next_schedule_inner">-->
                        <div class="row">
                            <div class="col-xs-3"><span>Time:</span></div>

                            <div class="col-xs-9"><p><?php
                                    if (!empty($get_data['Calendar']['changed_start']) && isset($get_data['Calendar']['changed_start'])) {
                                        echo $get_data['Calendar']['changed_start'];
                                    } else {
                                        echo "-";
                                    }
                                    ?></p>

                            </div>


                        </div>

                    <!--</div>-->


                    <!--<div class="next_schedule_inner">-->
                        <div class="row">
                            <div class="col-xs-3"><span>Duration:</span></div>

                            <div class="col-xs-9"><p><?php
                                    if (!empty($get_data['Calendar']['schedule_time']) && isset($get_data['Calendar']['schedule_time'])) {
                                        echo $get_data['Calendar']['schedule_time'] . ' Minutes';
                                    } else {
                                        echo "-";
                                    }
                                    ?></p>
                            </div>
                        </div>
                    <!--</div>-->

                    <!--<div class="next_schedule_inner">-->
                        <div class="row">
                            <div class="col-xs-3"><span>Teacher:</span></div>
                            <div class="col-xs-9">
                                <p><?php
                                    if (!empty($find_teacher)) {
                                        echo ucfirst($find_teacher['User']['first_name']) . ' ' . ucfirst($find_teacher['User']['last_name']);
                                    } else {
                                        echo "-";
                                    }
                                    ?></p>

                            </div>
                            <div class="col-md-7"> 
                                <?php if (!empty($find_teacher) && isset($find_teacher)) { ?>
                                    <img class="studentpageImage img-responsive mCS_img_loaded" src="<?php echo $this->webroot . 'img/teacher_images/' . $find_teacher['Teacher_information']['image']; ?>">
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="clearfix"> </div>


        <div class="right_side purchase clearfix">
            <div class="col-md-12">
                <h1> Purchase History </h1>
            </div>
            <div class="clearfix"> </div>
            <div class="col-md-12">

                <div class="table-responsive my_students">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Invoice Number</th>
                                <th>Transaction Status</th>
                                <th>Date</th>
                                <th>Customer Name</th>
                                <th>Card Type</th>
                                <th>Payment Method</th>
                                <th>Subject</th>
                                <th>Total Amount</th>
                                <th>Package Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($transactions)) {
                                foreach ($transactions as $transact) {
                                    ?>
                                    <tr>
                                        <td><?php
                                            if ($transact['Payment']['transaction_id'] != 0) {
                                                echo $transact['Payment']['transaction_id'];
                                            } else {
                                                echo "-";
                                            }
                                            ?></td>
                                        <td><?php
                                            if (!empty($transact['Payment']['invoice_number'])) {
                                                echo $transact['Payment']['invoice_number'];
                                            } else {
                                                echo "-";
                                            }
                                            ?></td>
                                        <td><?php echo ucfirst($transact['Payment']['role']); ?></td>
                                        <td><?php echo date('m/d/Y', strtotime($transact['Payment']['payment_on'])); ?></td>
                                        <td><?php echo ucfirst($transact['Payment']['first_name']) . ' ' . ucfirst($transact['Payment']['last_name']); ?></td>
                                        <td><?php echo $transact['Payment']['card_type']; ?></td>
                                        <td><?php
                                            if($transact['Payment']['card_number']) {
                                                $decoded = base64_decode($transact['Payment']['card_number']);
                                                echo str_repeat('*', strlen($decoded) - 4) . substr($decoded, -4);
                                            } else {
                                                echo "-";
                                            }
                                            ?></td>
                                        <td><?php echo $transact['Payment']['subject_name']; ?></td>
                                        <td><?php echo '$' . $transact['Payment']['amount']; ?></td>
                                        <td><?php echo $transact['Payment']['pack_name'] . ',' . ' ' . $transact['Payment']['duration']; ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<td colspan="11">No Lessons has been purchased.</td>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6 detail1">
                    <h4 style="font-style: italic;font-weight: bold;margin-left: 35px;">Violin Credits & Purchases</h4>
                    <p>Total Lessons Purchased: <span><?php
                            if (!empty($violin_purchased) && isset($violin_purchased)) {
                                if (!empty($violin_purchased['min']) && !empty($violin_purchased['second'])) {
                                    echo $violin_purchased['min'] . ' Hours ' . $violin_purchased['second'] . ' Minutes';
                                } elseif (!empty($violin_purchased['min']) && empty($violin_purchased['second'])) {
                                    echo $violin_purchased['min'] . ' Hours';
                                } elseif (empty($violin_purchased['min']) && !empty($violin_purchased['second'])) {
                                    echo $violin_purchased['second'] . ' Minutes';
                                } else {
                                    echo '-';
                                }
                            } else {
                                echo '-';
                            }
                            ?></span></p>
                    <p>Total Credits added: <span><?php
                            if (!empty($converted_credits1) && isset($converted_credits1)) {
                                if (!empty($converted_credits1['min']) && !empty($converted_credits1['second'])) {
                                    echo $converted_credits1['min'] . ' Hours ' . $converted_credits1['second'] . ' Minutes';
                                } elseif (!empty($converted_credits1['min']) && empty($converted_credits1['second'])) {
                                    echo $converted_credits1['min'] . ' Hours ' . $converted_credits1['second'] . ' Minutes';
                                } elseif (empty($converted_credits1['min']) && !empty($converted_credits1['second'])) {
                                    echo $converted_credits1['second'] . ' Minutes';
                                } else {
                                    echo '-';
                                }
                            } else if (!empty($converted_credits_negative1) && isset($converted_credits_negative1)) {
                                if (!empty($converted_credits_negative1['min']) && !empty($converted_credits_negative1['second'])) {
                                    echo ($converted_credits_negative1['min'] + 1) . ' Hours ' . $converted_credits_negative1['second'] . ' Minutes';
                                } elseif (!empty($converted_credits_negative1['min']) && empty($converted_credits_negative1['second'])) {
                                    echo ($converted_credits_negative1['min'] + 1) . ' Hours ' . $converted_credits_negative1['second'] . ' Minutes';
                                } elseif (empty($converted_credits_negative1['min']) && !empty($converted_credits_negative1['second'])) {
                                    echo $converted_credits_negative1['second'] . ' Minutes';
                                } else {
                                    echo '-';
                                }
                            } else {
                                echo '-';
                            }
                            ?></span></p>

                    <p>Total Amount of Credit Left: <span><?php
                            if (!empty($converted_total1) && isset($converted_total1)) {
                                if (!empty($converted_total1['min']) && !empty($converted_total1['second'])) {
                                    if ($converted_total1['min'] <= '-1') {
                                        echo ($converted_total1['min'] + 1) . ' Hours ' . $converted_total1['second'] . ' Minutes';
                                    } else {
                                        echo $converted_total1['min'] . ' Hours ' . $converted_total1['second'] . ' Minutes';
                                    }
                                } elseif (!empty($converted_total1['min']) && empty($converted_total1['second'])) {
                                    echo $converted_total1['min'] . ' Hours ';
                                } elseif (empty($converted_total1['min']) && !empty($converted_total1['second'])) {
                                    echo $converted_total1['second'] . ' Minutes';
                                } else {
                                    echo '-';
                                }
                            } else {
                                echo '0';
                            }
                            ?></span></p>

                </div>
                <div class="col-md-6 detail">
                    <h4 style="font-style: italic;font-weight: bold;text-align: center;">Other Credits & Purchases</h4>
                    <p> Total Lessons Purchased : <span><?php
                            if (!empty($other_purchased) && isset($other_purchased)) {
                                if (!empty($other_purchased['min']) && !empty($other_purchased['second'])) {
                                    echo $other_purchased['min'] . ' Hours ' . $other_purchased['second'] . ' Minutes';
                                } elseif (!empty($other_purchased['min']) && empty($other_purchased['second'])) {
                                    echo $other_purchased['min'] . ' Hours ';
                                } elseif (empty($other_purchased['min']) && !empty($other_purchased['second'])) {
                                    echo $other_purchased['second'] . ' Minutes';
                                } else {
                                    echo '-';
                                }
                            } else {
                                echo '-';
                            }
                            ?></span></p>
                    <p>Total Credits added: <span><?php
                            if (!empty($converted_credits) && isset($converted_credits)) {
                                if (!empty($converted_credits['min']) && !empty($converted_credits['second'])) {
                                    echo $converted_credits['min'] . ' Hours ' . $converted_credits['second'] . ' Minutes';
                                } elseif (!empty($converted_credits['min']) && empty($converted_credits['second'])) {
                                    echo $converted_credits['min'] . ' Hours ' . $converted_credits['second'] . ' Minutes';
                                } elseif (empty($converted_credits['min']) && !empty($converted_credits['second'])) {
                                    echo $converted_credits['second'] . ' Minutes';
                                } else {
                                    echo '-';
                                }
                            } else if (!empty($converted_credits_negative) && isset($converted_credits_negative)) {
                                if (!empty($converted_credits_negative['min']) && !empty($converted_credits_negative['second'])) {
                                    echo ($converted_credits_negative['min'] + 1) . ' Hours ' . $converted_credits_negative['second'] . ' Minutes';
                                } elseif (!empty($converted_credits_negative['min']) && empty($converted_credits_negative['second'])) {
                                    echo ($converted_credits_negative['min'] + 1) . ' Hours ' . $converted_credits_negative['second'] . ' Minutes';
                                } elseif (empty($converted_credits_negative['min']) && !empty($converted_credits_negative['second'])) {
                                    echo $converted_credits_negative['second'] . ' Minutes';
                                } else {
                                    echo '-';
                                }
                            } else {
                                echo '-';
                            }
                            ?></span></p>

                    <p>Total Amount of Credit Left: <span><?php
                            if (!empty($converted_total) && isset($converted_total)) {
                                if (!empty($converted_total['min']) && !empty($converted_total['second'])) {
                                    if ($converted_total['min'] <= '-1') {
                                        echo ($converted_total['min'] + 1) . ' Hours ' . $converted_total['second'] . ' Minutes';
                                    } else {
                                        echo $converted_total['min'] . ' Hours ' . $converted_total['second'] . ' Minutes';
                                    }
                                } elseif (!empty($converted_total['min']) && empty($converted_total['second'])) {
                                    echo $converted_total['min'] . ' Hours ';
                                } elseif (empty($converted_total['min']) && !empty($converted_total['second'])) {
                                    echo $converted_total['second'] . ' Minutes';
                                } else {
                                    echo '-';
                                }
                            } else {
                                echo '0';
                            }
                            ?></span></p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<style>
    .studentpageImage{
        position: absolute;
        top: -21px;
        width: 100px;
        border-radius: 17%;
    }
</style>  