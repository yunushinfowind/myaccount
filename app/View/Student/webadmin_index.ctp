<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-users"></i>
                        Student(s) Information
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>

                    <div class="panel-body">
                        <?php echo $this->Session->flash(); ?>  
                        <div class="adv-table">
                            <!--div class="col-md-6 searchTable">
                                <input type="text" class="form-control" placeholder="Search" id="searchField">

                                <input type="button"  id="searchButn" value="Go" class="btn btn-danger">
                            </div-->
                            <div class="admin_studnt">  
                                <table class="display table table-bordered table-striped dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Student(s) Name</th>
                                            <th>Age</th>
                                            <th>Subject</th>
                                            <th>Phone Number</th>
                                            <th>Address</th>
                                            <th>Email</th>
                                            <th>Status<br/>
                                                <select id="active_filter" data-status-index="8">
                                                    <option value="">All</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </th>
                                            <th>Added On</th>
                                            <th>Resend Sign-up Details</th>
                                            <th>Actions</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody class="appendDetails">
                                        <?php
                                        $i = 1;
                                        if (!empty($find_student)) {
                                            foreach ($find_student as $student) {
                                                $address = "";
                                                if (isset($student['User']['address']) && !empty($student['User']['address'])) {
                                                    $address = explode(',', $student['User']['address']);
                                                }
                                                ?>
                                                <tr class="<?php
                                                if (isset($student['Total_hour']) && $student['Total_hour']['total_time'] > 0) {

                                                    echo 'PaymentDone';
                                                } else {
                                                    echo 'PaymentPending';
                                                }
                                                ?> gradeX">
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo ucfirst($student['User']['first_name']) . ' ' . ucfirst($student['User']['last_name']); ?></td>
                                                    <td><?php
                                                        echo ucfirst($student['User']['student_firstname']) . ' ' . ucfirst($student['User']['student_lastname']);
                                                        if (!empty($student['Child_user'])) {
                                                            foreach ($student['Child_user'] as $child_user) {
                                                                echo ',<br>' . $child_user['firstname'] . ' ' . $child_user['lastname'];
                                                            }
                                                        }
                                                        ?></td>
                                                    <td><?php
                                                        echo $student['User']['student_age'];
                                                        if (!empty($student['Child_user'])) {
                                                            foreach ($student['Child_user'] as $child_user) {
                                                                echo ',<br>' . $child_user['age'];
                                                            }
                                                        }
                                                        ?></td>
                                                    <td><?php
                                                        echo $student['User']['subject'];
                                                        if (!empty($student['Child_user'])) {
                                                            foreach ($student['Child_user'] as $child_user) {
                                                                echo ',<br>' . $child_user['subject'];
                                                            }
                                                        }
                                                        ?></td>

                                                    <td><?php echo $student['User']['primary_phone']; ?></td>
                                                    <td><?php
                                                        if (!empty($teacher['User']['suite'])) {
                                                            echo $address[0] . ' Apt. ' . $student['User']['suite'] . ' ' . $address[1] . ', ' . $address[2] . ' ' . $student['User']['zip_code'];
                                                        } else if (!empty($address['0']) && !empty($address[1]) && !empty($address[2])) {
                                                            echo $address[0] . ' ' . $address[1] . ', ' . $address[2] . ' ' . $student['User']['zip_code'];
                                                        } elseif (!empty($student['User']['address'])) {
                                                            echo $student['User']['address']. ' ' . $student['User']['city']. ' ' . $student['User']['state'] . ' ' . $student['User']['zip_code'];
                                                        }
                                                        ?></td>
                                                    <td><?php echo $student['User']['email']; ?></td>
                                                    <td>                                 
                                                        <?php if ($student['User']['status'] == "1") { ?>
                                                            <span style="display:none;">1</span>
                                                            <a title = "Active" href = "<?php echo BASE_URL; ?>webadmin/student/change_status/<?php echo $student['User']['id']; ?>/0"><img width = "20" alt = "tick" src = "<?php echo $this->webroot; ?>img/tick.png"></a>
                                                        <?php } else { ?>
                                                            <span style="display:none;">0</span>
                                                            <a title = "Inactive" href = "<?php echo BASE_URL; ?>webadmin/student/change_status/<?php echo $student['User']['id']; ?>/1"><img width = "20" alt = "tick" src = "<?php echo $this->webroot; ?>img/cross.png"></a>
                                                            <?php
                                                        }
                                                        ?>        

                                                    </td>
                                                    <td><?php echo date('m/d/Y', strtotime($student['User']['created'])); ?></td>
                                                    <td style="text-align: center;"><?php echo $this->Html->link('', array('action' => 'resend_signup_details', $student['User']['id']), array('class' => 'fa fa-envelope-o')); ?></td>
                                                    <td class="AllActions">
                                                        <button class="action">Actions &nbsp;<i class="fa fa-chevron-down"></i></button>
                                                        <ul class="action-list hide1">
                                                            <li><a href="<?php echo BASE_URL . 'webadmin/student/edit_student/' . $student['User']['id']; ?>"><i class="fa fa-edit"></i> &nbsp; Edit Student</a></li>
                                                            <li><a href="<?php echo BASE_URL . 'webadmin/student/purchases/' . $student['User']['id']; ?>"><i class="fa fa-dollar"></i> &nbsp; Purchases</a></li>
                                                            <li><a href="<?php echo BASE_URL . 'webadmin/student/completed_lesson/', $student['User']['id']; ?>"><i class="fa fa-check"></i> &nbsp; Completed Lessons</a></li>
                                                            <li><a href="<?php echo BASE_URL . 'webadmin/student/make_a_payment/' . $student['User']['id']; ?>"><i class="fa fa-dollar"></i> &nbsp; Make a Payment</a></li>
                                                            <li id="manage_cards" student_id="<?php echo $student['User']['id']; ?>"><a href="javascript:;" ><i class="fa fa-credit-card"></i> &nbsp; Manage Cards</a></li>                 
                                                            <li id="assigning_teacher" student_id="<?php echo $student['User']['id']; ?>"><a href="javascript:;" ><i class="fa fa-user-plus"></i> &nbsp; Assign Teacher</a></li>
                                                            <li id="manage_teachers" student_id="<?php echo $student['User']['id']; ?>"><a href="javascript:;" ><i class="fa fa-users"></i> &nbsp; Manage Teachers</a></li>

                                                        </ul>
                                                    </td>
                                                    <td class="text-center">   <?php echo $this->Form->postLink('', array('action' => 'delete_student', $student['User']['id']), array('confirm' => 'Are you sure you want to delete Student?', 'class' => 'fa fa-trash-o')); ?></td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        } else {
                                            echo '<tr class="gradeX"><td colspan="13" style="text-align:center;">No Students added yet.</td></tr>';
                                        }
                                        ?>


                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Student(s) Name</th>
                                            <th>Age</th>
                                            <th>Subject</th>
                                            <th>Phone Number</th>
                                            <th>Address</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Added On</th>
                                            <th>Resend Sign-up Details</th>
                                            <th>Actions</th>
                                            <th>Delete</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</section>

<style>
    .PaymentDone {
        color: #118712;
    }
    .PaymentPending {
        color: #fe1a14;
    }

</style>