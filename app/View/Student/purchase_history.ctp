<div class="new_ryt padding-right">
    <div class="right_side purchase clearfix">
        <div class="col-md-12 purchseHistry">
            <h1> Purchase History </h1>
        </div>
        <div class="clearfix"> </div>
        <div class="col-md-12">
            <div class="new_scroll mCustomScrollbar">
                <div class="table-responsive my_students">

                    <?php echo $this->Session->flash(); ?>  
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Transaction ID</th>
                                <th>Invoice Number</th>
                                <th>Status</th>
                                <th>Purchased On</th>
                                <th>Customer Name</th>
                                <th>Payment Method</th>
                                <th>Card Number</th>
                                <th>Subject</th>
                                <th>Total Amount</th>
                                <th>Package Option</th>
                                <th>Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($transactions)) {
                                $i = 1;
                                foreach ($transactions as $transact) {
                                    ?>
                                    <tr <?php if ($transact['Payment']['status'] == '1') { ?>class="PaymentDone" <?php } elseif ($transact['Payment']['status'] == '0') { ?>class="PaymentPending"<?php } ?>>
                                        <td><?php echo $i . '.'; ?></td>
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
                                        <td> <?php
                                            if ($transact['Payment']['status'] == '1') {
                                                echo 'Paid';
                                            } else if ($transact['Payment']['status'] == '2') {
                                                echo 'Adjusted';
                                            } else {
                                                echo'Pending';
                                            }
                                            ?></td>
                                        <td><?php echo date('m/d/Y', strtotime($transact['Payment']['payment_on'])); ?></td>
                                        <td><?php echo ucfirst($transact['Payment']['first_name']) . ' ' . ucfirst($transact['Payment']['last_name']); ?></td>
                                        <td><?php echo $transact['Payment']['card_type']; ?></td>
                                        <td><?php
                                            if (!empty($transact['Payment']['card_number'])) {
                                                $decoded = base64_decode($transact['Payment']['card_number']);
                                                echo str_repeat('*', strlen($decoded) - 4) . substr($decoded, -4);
                                            }
                                            ?></td>
                                        <td><?php echo $transact['Payment']['subject_name']; ?></td>
                                        <td><?php echo '$' . $transact['Payment']['amount']; ?></td>
                                        <td><?php
                                            if (!empty($transact['Price']['pack'])) {
                                                echo $transact['Price']['pack'];
                                            } else {
                                                echo '-';
                                            }
                                            ?></td>

                                        <td>
                                            <?php
                                            if (!empty($transact['Time']['min']) && !empty($transact['Time']['second'])) {
                                                echo $transact['Time']['min'] . ' Hours ' . $transact['Time']['second'] . ' Minutes';
                                            } elseif (!empty($transact['Time']['min']) && empty($transact['Time']['second'])) {
                                                echo $transact['Time']['min'] . ' Hours';
                                            } elseif (empty($transact['Time']['min']) && !empty($transact['Time']['second'])) {
                                                echo $transact['Time']['second'] . ' Minutes';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            } else {
                                echo '<td colspan="12">No lessons have been purchased.</td>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6 detail1">
            <h4 style="font-style: italic;font-weight: bold;">Violin Credits & Purchases</h4>
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
                        echo '-';
                    }
                    ?></span></p>

        </div>
        <div class="col-md-6 detail">
            <h4 style="font-style: italic;font-weight: bold;">Other Credits & Purchases</h4>
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
                        echo '-';
                    }
                    ?></span></p>
        </div>
    </div>

</div>
</div>




</div>

<!--dashboard closed --> 
<style>
    .PaymentDone td{
        color: #118712 !important;
    }
    .PaymentPending td{
        color: #FE1A14 !important;
    }
</style>