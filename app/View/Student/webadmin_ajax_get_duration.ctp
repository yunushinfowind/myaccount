<option value="">--Select--</option>
<?php
if (!empty($get_duration)) {
    foreach ($get_duration as $value) {
        ?>
        <option value="<?php echo $value['Price']['duration']; ?>"><?php echo $value['Price']['duration']; ?>
        </option>
        <?php
    }
   
}
?>
