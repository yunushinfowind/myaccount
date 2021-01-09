<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Action for Mark Completed</h4>
        </div>
        <div class="modal-body">

            <div class="checkbox">
                <label>
                    <input type="radio" value="same_day_cancel" id="same_day_cancel" class="markComplete">Same Day Cancellation
<!--                    <input type="radio" id="same_day_cancel" class="markComplete" value="same_day_cancel" <?php
//                    if (@$check_value[0] == 'same_day_cancel') {
//                        echo "checked";
//                    }
                    ?>>Same Day Cancellation-->
                </label>
            </div>
            <div class="checkbox">
                <label>
<!--                    <input type="radio" value="student_no_show" id="student_no_show" class="markComplete">Student No Show
                    <input type="radio" id="student_no_show" class="markComplete"  value="student_no_show" <?php
//                    if (@$check_value[1] == 'student_no_show') {
//                        echo "checked";
//                    }
                    ?>>Student No Show-->
                </label>
            </div>
            <div class="textarea">
                <label>Remarks</label>
                <textarea id="remarks" class="form-control"><?php echo @$remark; ?></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            <button type="button" id="mark_as_completed" class="btn btn-default saveBtn">Mark Completed</button>
        </div>
    </div>
</div>
 <input type="radio" name="gender" value="male"> Male<br>
  <input type="radio" name="gender" value="female"> Female<br>