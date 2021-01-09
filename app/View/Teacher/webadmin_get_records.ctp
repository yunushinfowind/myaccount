<table class="display table table-bordered table-striped" >
    <thead>
        <tr>
            <th>#</th>
            <th>Student Name</th>
            <th>Lesson Date</th>
            <th>Subject</th>
            <th>Earned Date</th>
            <th>Schedule Time</th>
            <th>Amount</th>
            <th>Select To Pay</th>
        </tr>
    </thead>
    <tbody>
    <?php
    //  pr($earnings);
    if (!empty($earnings)) {
        $i = 1;
        foreach ($earnings as $result) {
            ?>
            <tr class="gradeX">
                <td><?php echo $i . '.'; ?></td>
                <td><?php echo $result['User']['first_name'] . ' ' . $result['User']['last_name']; ?></td>
                <td><?php echo date('m/d/Y', strtotime($result['Calendar']['start_date'])); ?></td>
                <td><?php echo $result['Calendar']['subject_name']; ?></td>
                <td><?php echo date('m/d/Y', strtotime($result['Earning']['earned_date'])); ?></td>
                <td><?php echo $result['Converted_time']; ?></td>
                <td><?php echo '$ ' . $result['Amount']; ?></td>
                <td><?php
                    echo $this->Form->input('', array(
                        'hiddenField' => false,
                        'type' => 'checkbox', 'value' => $result['Calendar']['id'], 'class' => 'Paychckbox', 'amount' => $result['Amount'], 'student_id' => $result['User']['id']));
                    ?> </td>


            </tr>
            <?php
            $i++;
        }
    } else {
        echo '<tr class="gradeX">
                    <td colspan="8" style="text-align:center;">No Results.</td></tr>';
    }
    ?>
    </tbody>
    <tfoot>
        <tr>
            <th>#</th>
            <th>Student Name</th>
            <th>Lesson Date</th>
            <th>Subject</th>
            <th>Earned Date</th>
            <th>Schedule Time</th>
            <th>Amount</th>
            <th>Select To Pay</th>
        </tr>
    </tfoot>
</table>

