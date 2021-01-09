<?php
if ($get_data['Calendar']['completed_type'] == 'markcompleted') {
    $result['mark_completed'] = 'marked';
}
?>
<div class="col-lg-12">
    <div class="col-lg-1">
        <i class="fa fa-edit" style="font-size: 24px;"></i>
    </div>
    <div class="col-lg-11">
        <h4 style="margin-top: 0px;">Edit Scheduled Lesson</h4>
    </div>
</div>
<div class="col-lg-12 form-group">
    <div class="col-lg-3">Student Name</div>
    <div class="col-lg-9">
        <select class="form-control student" id="student">
            <option value="" disabled="disabled">--Select--</option>
            <?php
            if (!empty($students)) {

                if ($get_data['Calendar']['completed_type'] == 'markcompleted') {
                    foreach ($students as $student) {
                        ?>
                        <option value = "<?php echo $student['Assigned_teacher']['student_id']; ?>" <?php
                        if ($get_data['Calendar']['user_id'] == $student['Assigned_teacher']['student_id']) {
                            echo 'selected';
                        } else {
                            ' disabled="disabled"';
                        }
                        ?>><?php echo ucfirst($student['Student']['User']['first_name']) . ' ' . ucfirst($student['Student']['User']['last_name']); ?>
                        </option>
                        <?php
                    }
                } else {

                    foreach ($students as $student) {
                        ?>
                        <option value ="<?php echo $student['Assigned_teacher']['student_id']; ?>" <?php
                        if ($get_data['Calendar']['user_id'] == $student['Assigned_teacher']['student_id']) {
                            echo'selected';
                        }
                        ?>><?php echo ucfirst($student['Student']['User']['first_name']) . ' ' . ucfirst($student['Student']['User']['last_name']); ?>
                        </option>
                        <?php
                    }
                }
            }
            ?>
        </select>
    </div>
</div>
<div class="col-lg-12 form-group">
    <div class="col-lg-3">Subject</div>
    <div class="col-lg-9">
        <select class="form-control subject" id="subjects">
            <option value="" disabled="disabled">--Select--</option>
            <?php
            if (!empty($students)) {
                if ($get_data['Calendar']['completed_type'] == 'markcompleted') {
                    foreach ($students as $subject) {
                        ?>
                        <option value = '<?php
                        echo $subject['Subject']['id'];
                        ?>' <?php
                                if ($get_data['Calendar']['subject'] == $subject['Subject']['id']) {
                                    echo 'selected';
                                } else {
                                    'disabled="disabled"';
                                }
                                ?>><?php echo $subject['Subject']['subject']; ?></option>
                                <?php
                            }
                        } else {
                            foreach ($students as $subject) {
                                ?>
                        <option value = '<?php echo $subject['Subject']['id']; ?>' <?php
                        if ($get_data['Calendar']['subject'] == $subject['Subject']['id']) {
                            echo 'selected';
                        }
                        ?>><?php echo $subject['Subject']['subject']; ?></option>
                                <?php
                            }
                        }
                    }
                    ?>
        </select>
    </div>
</div>
<div class="col-lg-12 form-group">
    <div class="col-lg-3">Start Time</div>
    <div class="col-lg-9">
        <div class="form-group">
            <div id="timepicker1" class="input-group date">
                <input data-format="hh:mm:ss" type="text" class="form-control start_time" id="appendStart" style="background:#fff"
                <?php
                if ($get_data['Calendar']['completed_type'] == 'markcompleted') {
                    //echo 'disabled="disabled"';
                }
                ?>
                       value="<?php echo $get_data['Calendar']['changed_start']; ?>">
                <span class="input-group-addon" id="Edit_start1">
                    <span class="glyphicon glyphicon-time" id="Edit_start"></span>
                </span>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12 form-group">
    <div class="col-lg-3">End Time</div>
    <div class="col-lg-9">
        <div class="form-group">
            <div id="timepicker2" class="input-group date">
                <input data-format="hh:mm:ss" type="text" class="form-control end_time" id="appendEnd" style="background:#fff"
                <?php
                $isMarkedComplete = false;
                if ($get_data['Calendar']['completed_type'] == 'markcompleted') {
                    //echo 'disabled="disabled"';
                }
                ?>
                       value="<?php echo $get_data['Calendar']['changed_end']; ?>">
                <span class="input-group-addon" id="Edit_end1">
                    <span class="glyphicon glyphicon-time" id="Edit_end"></span>

                </span>
            </div></div></div></div>
</div>
<div class="col-lg-12 form-group"><div class="col-lg-3"></div><div class="col-lg-9"><div class="radio"><label><input type="radio" value="markcompleted" name="completed_type" class="radioComplete"
                <?php
                if ($get_data['Calendar']['completed_type'] == 'markcompleted') {
                    $isMarkedComplete = true;
                    echo "checked='checked'";
                }
                ?>                                                                          >Mark as complete</label>
        </div>
    </div>
</div>
<div class="col-lg-12 form-group">
    <div class="col-lg-3">

    </div>
    <div class="col-lg-9">
        <div class="radio">
            <label>
                <input type="radio" value="same_day_cancellation" name="completed_type" class="radioComplete"
                <?php
                if ($get_data['Calendar']['completed_type'] == 'same_day_cancellation') {
                    $isMarkedComplete = true;
                    echo "checked='checked'";
                }
                ?>
                       >Same Day Cancellation</label>
        </div>
    </div>
</div>
<div class="col-lg-12 form-group">
    <div class="col-lg-3"></div>
    <div class="col-lg-9">
        <div class="radio">
            <label>
                <input type="radio" value="student_no_show" name="completed_type" class="radioComplete"
                <?php
                if ($get_data['Calendar']['completed_type'] == 'student_no_show') {
                    $isMarkedComplete = true;
                    echo "checked='checked'";
                }
                ?>
                       >Student No Show</label>
        </div>
    </div>
</div>
<div class="col-lg-12 textarea"
<?php
if ($get_data['Calendar']['completed_type'] != '') {
    
} else {
    echo 'style="display:none;"';
}
?>>
    <div class="col-lg-3"></div>
    <div class="col-lg-9">
        <div class="textarea">
            <textarea id="remarks" class="form-control" placeholder="Notes"><?php echo $get_data['Calendar']['completed_remarks']; ?>
            </textarea>
        </div>
    </div>
</div>
<?php
if ($get_data['Calendar']['repeat_lesson'] != 'true' && !$isMarkedComplete) {
    ?>
    <div class="col-lg-12 form-group">
        <div class="col-lg-3"></div>
        <div class="col-lg-9"><div class="checkbox"><label><input type="checkbox" id="repeatLesson" value=""
                    <?php
                    if ($get_data['Calendar']['repeat_lesson'] == 'true') {
                        echo 'checked';
                    }
                    ?>>Repeat Lesson Weekly</label></div></div></div>
        <?php
    }
    ?>
<input type="hidden" value="<?php echo @$get_data['Calendar']['id']; ?>" id="schedule_id">
<input type="hidden" id="CompleteRadioVal">
<input type="hidden" id="startDate" value="<?php echo @$get_data['Calendar']['start_date']; ?>">
<input type="hidden" id="getSubjectName" value="<?php echo @$subject['Subject']['subject']; ?>"></div>