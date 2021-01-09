<?php
if (!empty($student_detail)) {
    ?>
    <h5 class="">Teachers for <b><i><?php echo '"' . ucfirst($student_detail['User']['first_name']) . ' ' . ucfirst($student_detail['User']['last_name']) . '"'; ?></i></b></h5>

<?php } ?>
<table class="table table-striped" id="tblGrid">
    <thead id="tblHead">
        <tr>
            <th class="text-center">Sr.No.</th>
            <th class="text-center">Teacher</th>
            <th class="text-center">Subject</th>
            <th class="text-center">Additional Rate ($) </th>
            <th class="text-center">Lesson Duration</th>
            <th class="text-center">Edit</th>
            <th class="text-center">Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($teachers)) {
            $i = 1;
            foreach ($teachers as $detail) {
                ?>
                <tr>
                    <td class="text-center"><?php echo $i . '.'; ?></td>
                    <td class="text-center"><?php echo ucfirst($detail['Teacher']['Teacher_information']['first_name']) . ' ' . ucfirst($detail['Teacher']['Teacher_information']['last_name']); ?></td>
                    <td class="text-center">
                        <select class="form-control special_sub">
                            <option>--Select--</option>
                            <?php
                            foreach ($subjects as $subject) {
                                ?>
                                <option value="<?php echo $subject['Subject']['id']; ?>" <?php
                                if ($detail['Subject']['subject'] == $subject['Subject']['subject']) {
                                    echo 'selected';
                                }
                                ?>><?php echo $subject['Subject']['subject']; ?></option>
                                    <?php } ?>
                        </select>
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control specl_amt" value="<?php
                        if (!empty($detail['Assigned_teacher']['special_amount'])) {
                            echo $detail['Assigned_teacher']['special_amount'];
                        } else {
                            echo '-';
                        }
                        ?>">

                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control lesson_dur1" value="<?php
                        if (!empty($detail['Assigned_teacher']['lesson_duration'])) {
                            echo $detail['Assigned_teacher']['lesson_duration'];
                        } else {
                            echo '-';
                        }
                        ?>">
                    </td>
                    <td class="text-center" id="update_assigned_teacher" assigned_id="<?php echo $detail['Assigned_teacher']['id']; ?>" style="cursor: pointer;"><i class="fa fa-save"></i></td>
                    <td class="text-center" id="delete_assigned_teacher" assigned_id="<?php echo $detail['Assigned_teacher']['id']; ?>" style="cursor: pointer;"><i class="fa fa-trash-o"></i></td>
                </tr>
                <?php
                $i++;
            }
        } else {
            ?>
            <tr>
                <td colspan="5"><i>No teachers assigned.</i></td>

            </tr>
            <?php
        }
        ?>
    </tbody>
</table>