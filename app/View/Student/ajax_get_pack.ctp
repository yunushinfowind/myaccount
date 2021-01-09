<option value="">--Select--</option>
<?php
    foreach ($getPack as $value) {
        ?>
        <option value="<?php echo $value['Price']['pack']; ?>"><?php echo $value['Price']['pack']; ?>
        </option>
        <?php
    }
?>