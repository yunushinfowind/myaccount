<?php
if (!empty($data)) {
    $i = 1;
    foreach ($data as $teacher) {
        $address = explode(',', $teacher['User']['address']);
        ?>
        <tr class="gradeX">
            <td><?php echo $i; ?></td>
            <td><?php echo $teacher['User']['first_name'] . ' ' . $teacher['User']['last_name']; ?></td>
            <td><?php echo $teacher['User']['primary_phone']; ?></td>
            <td><?php
                if (!empty($teacher['User']['suite'])) {
                    echo $address[0] . ' Apt. ' . $teacher['User']['suite'] . ' ' . $address[1] . ', ' . $address[2] . ' ' . $teacher['User']['zip_code'];
                } else {
                    echo $address[0] . ' ' . $address[1] . ', ' . $address[2] . ' ' . $teacher['User']['zip_code'];
                }
                ?></td>

            <td><?php echo $teacher['User']['email']; ?></td>

            <td style="text-align: center;"><?php echo $this->Html->link('', array('action' => 'resend_signup_details', $teacher['User']['id']), array('class' => 'fa fa-envelope-o')); ?></td>
            <td class="AllActions">
                <button class="action">Actions &nbsp;<i class="fa fa-chevron-down"></i></button>
                <ul class="action-list hide1">
                    <li><a href="<?php echo BASE_URL . 'webadmin/teacher/edit_basic/' . $teacher['User']['id']; ?>"><i class="fa fa-edit"></i> &nbsp; Edit Basic Info</a></li>
                    <li><a href="<?php echo BASE_URL . 'webadmin/teacher/edit_profile/' . $teacher['User']['id']; ?>"><i class="fa fa-edit"></i> &nbsp; Edit Profile Info</a></li>
                    <li><a href="<?php echo BASE_URL . 'webadmin/teacher/view_calendar/' . $teacher['User']['id']; ?>"><i class="fa fa-calendar"></i> &nbsp; Manage Calendar</a></li>
                    <li><a href="<?php echo BASE_URL . 'webadmin/teacher/completed_lesson/', $teacher['User']['id']; ?>"><i class="fa fa-check"></i> &nbsp; Completed Lessons</a></li>
                    <li><a href="<?php echo BASE_URL . 'webadmin/teacher/pay/' . $teacher['User']['id']; ?>"><i class="fa fa-paypal"></i> &nbsp; Pay Teacher</a></li>

                </ul>
            </td>
            <td><?php if ($teacher['User']['status'] == "1") { ?>
                    <a title = "Active" href = "<?php echo BASE_URL; ?>webadmin/teacher/change_status/<?php echo $teacher['User']['id']; ?>/1"><img width = "20" alt = "tick" src = "<?php echo $this->webroot; ?>/img/tick.png"></a>
                <?php } else { ?>
                    <a title = "Inactive" href = "<?php echo BASE_URL; ?>webadmin/teacher/change_status/<?php echo $teacher['User']['id']; ?>/0"><img width = "20" alt = "tick" src = "<?php echo $this->webroot; ?>/img/cross.png"></a>
                <?php } ?></td>
            <td><?php echo date('m/d/Y', strtotime($teacher['User']['created'])); ?></td>
            <td style="text-align: center;"><?php echo $this->Form->postLink('', array('action' => 'delete_teacher', $teacher['User']['id']), array('confirm' => 'Are you sure you want to delete Teacher?', 'class' => 'fa fa-trash-o')); ?></td>
        </tr>
        <?php
        $i++;
    }
} else {
    ?>
        <tr class="gradeX"><td colspan="12" style="text-align: center;">No Record matches your search.</td></tr>
<?php } ?>
