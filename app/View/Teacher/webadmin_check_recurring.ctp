
<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Delete Scheduled Lesson</h4>
        </div>
        <div class="modal-body">
            <p>Do you want to delete the Scheduled Lesson?</p>
            <input type="hidden" id="idToDelete" value="<?php echo $id; ?>">
            <input type="hidden" id="getstartDate" value="<?php echo $start_date; ?>">
            <input type="hidden" id="endDate" value="<?php echo $end_date; ?>">
            <input type ="hidden" value="<?php
            if (isset($recurred_id) && !empty($recurred_id)) {
                echo "recurr";
            } else {
                echo "non_recurr";
            }
            ?>" id="GetVlu">
                   <?php
                   if (isset($recurred_id) && !empty($recurred_id)) {
                       ?>
                <div class="radio">
                    <label><input type="radio" name="optradio" id="recurring" class="deleteAll" value="recurring">Recurring</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="optradio" id="non_recurring" class="deleteAll" value="non_recurring">Non- Recurring</label>
                </div>

            <?php } ?>
        </div>
        <div class="modal-footer">
           
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
             <button type="button" id="DeletedSchedule" class="btn btn-primary saveBtn">Delete</button>
        </div>
    </div>
</div>