<option value="">--Select--</option>
<?php
if (!empty($all_subjects)) {
    foreach ($all_subjects as $subject) {
        if (($user['User']['voilin_price'] == 'No') && ($subject['Subject']['subject'] == 'Voilon')) {
            unset($subject);
            $subject = array();
        }
        if (!empty($subject['Subject']['subject'])) {
            ?>
            <option value = '<?php echo $subject['Subject']['id']; ?>'><?php echo ucfirst($subject['Subject']['subject']); ?></option>
            <?php
        }
    }
}
?>