<option value="">-Select-</option>
<?php
if (!empty($find)) {
    foreach ($find as $packs) {
        ?>
        <option value="<?php echo $packs['Price']['id']; ?>"><?php echo $packs['Pack']['pack'] . ' ($' . $packs['Price']['price'] . ')'; ?></option>
        <?php
    }
}?>