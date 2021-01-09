<option value="">--Select--</option>
<?php
if (!empty($get)) {
    foreach ($get as $subject) {
        if (!empty($subject['Assigned_teacher'])) {
            ?>
            <option value = '<?php echo $subject['Subject']['id']; ?>'><?php echo $subject['Subject']['subject']; ?></option>

            <?php
        }
    }
}
?>