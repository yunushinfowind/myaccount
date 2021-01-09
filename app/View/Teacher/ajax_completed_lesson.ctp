<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Mark as Completed</h4>
        </div>
        <div class="modal-body text-center">

        </div>
        <table class="pack-tbl">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Duration</th>
                    <th>Pack</th>
                    <!--<th>Mark</th>-->
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $data['Subject']['subject']; ?></td>
                    <td><?php echo $data['Payment']['duration']; ?></td>
                    <td><?php echo $data['Payment']['pack']; ?></td>
                </tr>
            <input type="hidden" class="PayId" value="<?php echo $data['Payment']['id']; ?>">
            <?php
            $pack = $data['Payment']['pack'];
            if ($pack == 'Single Pack') {
                $pck_val = 1;
            } elseif ($pack == 'Double Pack') {
                $pck_val = 2;
            } else {
                $exp_pck = explode(' ', $pack);
                $pck_val = $exp_pck[0];
            }
            $less_comp = explode(',', @$data['Payment']['completed_lesson']);
            for ($p = 1; $p <= $pck_val; $p++) {
                ?>
                <tr><td>
                        <input type="checkbox" class="mark_completed form-control" value ="<?php echo $p; ?>" name="completed" <?php
                        if (!empty($less_comp) && in_array($p, $less_comp)) {
                            echo 'checked';
                        }
                        ?>>
                               <?php // echo $this->Form->input('completed', array('label' => FALSE, 'type' => 'checkbox', 'class' => 'mark_completed', 'value' => $p, 'name' => 'completed')) ?>
                    </td><td><?php echo 'Lesson ' . $p; ?></td></tr>
                <?php
            }
            ?>

            </tbody>
        </table>
        <div class="clearfix"></div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

        </div>
    </div>

</div>
</div>
<style>
    .pack-tbl td {
        padding: 10px;
    }
    .pack-tbl th {
        padding: 10px;
    }
</style>