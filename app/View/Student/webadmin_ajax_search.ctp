<?php
$i = 1;
if (!empty($data)) {
    foreach ($data as $student) {
        $address = explode(',', $student['User']['address']);
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
            <td><?php echo ucfirst($student['User']['student_firstname']) . ' ' . ucfirst($student['User']['student_lastname']); ?></td>
            <td><?php echo $student['User']['subject']; ?></td>
            <td><?php echo $student['User']['primary_phone']; ?></td>
            <td><?php
                if (!empty($teacher['User']['suite'])) {
                    echo $address[0] . ' Apt. ' . $student['User']['suite'] . ' ' . $address[1] . ', ' . $address[2] . ' ' . $student['User']['zip_code'];
                } else {
                    echo $address[0] . ' ' . $address[1] . ', ' . $address[2] . ' ' . $student['User']['zip_code'];
                }
                ?></td>
            <td><?php echo $student['User']['email']; ?></td>
            <td>                                 
                <?php if ($student['User']['status'] == "1") { ?>
                    <a title = "Active" href = "<?php echo BASE_URL; ?>webadmin/student/change_status/<?php echo $student['User']['id']; ?>/1"><img width = "20" alt = "tick" src = "<?php echo $this->webroot; ?>/img/tick.png"></a>
                <?php } else { ?>
                    <a title = "Inactive" href = "<?php echo BASE_URL; ?>webadmin/student/change_status/<?php echo $student['User']['id']; ?>/0"><img width = "20" alt = "tick" src = "<?php echo $this->webroot; ?>/img/cross.png"></a>
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
    ?>
    <tr class="gradeX">
        <td colspan="12" style="text-align: center;">No Record matches your search!</td>
    </tr>
    <?php
}
?>