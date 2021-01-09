<section id="main-content">
    <section class="wrapper">
        <!-- page start-->

        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-users"></i>
                        Manage Purchase History

                        <?php echo $this->Session->flash();?>
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <?php echo $this->Session->flash(); ?> 
                            <table  class="display table table-bordered table-striped" id="dynamic-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student's Name</th>
                                        <th>Subject</th>
                                        <th>Duration</th>
                                        <th>Pack</th>
                                        <th>Phone Number</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Subscribed On</th>
                                        <th>Direct Purchase</th>
                                        <th>Manual Purchase</th>
                                        <th>Assign Teacher</th>
                                    </tr>
                                </thead>  
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if (!empty($payment_details)) {
                                        foreach ($payment_details as $student) {
                                            ?>
                                    <tr class="gradeX">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $student['User']['student_firstname'] . ' ' . $student['User']['student_lastname']; ?></td>
                                        <td><?php echo $student['Subject']['subject']; ?></td>
                                        <td><?php echo $student['Payment']['duration']; ?></td>
                                        <td><?php echo $student['Payment']['pack']; ?></td>
                                        <td><?php echo $student['User']['primary_phone']; ?></td>
                                        <td><?php echo $student['User']['email']; ?></td>
                                        <td><?php echo $student['User']['address']; ?></td>
                                        <td><?php echo date('M d, Y', strtotime($student['Payment']['created'])); ?></td>
                                        <td>
                                                    <?php if ($student['Payment']['status'] == 0) { ?>
                                            <a href="<?php echo BASE_URL . 'webadmin/purchase/make_payment/'.$student['Payment']['id']; ?>/"><img src="<?php echo $this->webroot . 'img/Purchase_button.gif'; ?>" alt="purchase" style="width:105px;"></a>
                                                        <?php
                                                    } elseif ($student['Payment']['status'] == 1) {
                                                        ?>
                                <center><img src="<?php echo $this->webroot . 'img/complted.jpg'; ?>" alt="purchase" style="width:50px;height: 50px;"></center>
                                                        <?php
                                                    }
                                                    ?>
                                        </td>
                                        <td>
                                            <?php if ($student['Payment']['status'] == 0) { ?>
                                            <a href="<?php echo BASE_URL.'webadmin/purchase/payment/'.$student['Payment']['id'];?>"><img src="<?php echo $this->webroot.'img/buy.png'?>" style="width:50px; height:50px;"></a>
                                            <?php } elseif($student['Payment']['status'] == 1){?>
                                            <img src="<?php echo $this->webroot.'img/tick.png'?>" style="width:50px; height:50px;">
                                            <?php }?>
                                        </td>
                                        <td style="text-align: center;">
                                                    <?php
                                                    if ($student['Payment']['teacher_assigned'] == '') {
                                                        echo $this->Html->link('', array('action' => 'assign_teacher', $student['User']['id'], $student['Payment']['id']), array('class' => 'fa fa-user-plus'));
                                                    } elseif ($student['Payment']['teacher_assigned'] != '') {
                                                        echo $this->Html->link('', array('action' => 'remove_teacher', $student['Payment']['id']), array('class' => 'fa fa-user-times'));
                                                    }
                                                    ?></td>
                                    </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Student's Name</th>
                                        <th>Subject</th>
                                        <th>Duration</th>
                                        <th>Pack</th>
                                        <th>Phone Number</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Added On</th>
                                        <th>Direct Purchase</th>
                                        <th>Manual Purchase</th>
                                        <th>Assign Teacher</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- page end-->
    </section>
</section>
<style>
    .student_image{
        width: 50px;
        height: 50px;
    }
</style>