<option value="">--Select--</option>
<?php
if (!empty($find_teachers)) {
    foreach ($find_teachers as $teachers) {
//        pr($teachers);die;
        ?>
        <option value="<?php echo $teachers['Teacher']['teacher_information_id']; ?>"><?php echo ucfirst($teachers['User']['first_name']) . ' ' . ucfirst($teachers['User']['last_name']); ?>
        </option>
        <?php
    }
}
?>