<option value="">--Select--</option>
<?php
foreach ($find_pack as $value) {
    ?>
    <option value="<?php echo $value['Price']['pack']; ?>"><?php echo $value['Price']['pack']; ?>
    </option>
    <?php
}
?>