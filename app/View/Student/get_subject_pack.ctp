<option value="">-Select-</option>

<?php
if (!empty($find)) {
    foreach ($find as $pack) {
        ?>
        <option value="<?php echo $pack['Price']['id']; ?>"><?php echo $pack['Pack']['pack'] . ' ($' . $pack['Price']['price'] . ') '; ?></option>
        <?php
    }
}
?>