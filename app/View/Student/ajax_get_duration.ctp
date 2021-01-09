<option value="">--Select--</option>
<?php
    foreach ($getDuration as $value) {
        ?>
        <option value="<?php echo $value['Price']['duration']; ?>"><?php echo $value['Price']['duration']; ?>
        </option>
        <?php
    }
?>