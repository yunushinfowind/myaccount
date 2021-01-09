<table class="table table-striped" id="tblGrid">
    <thead id="tblHead">
        <tr>
            <th class="text-center">Sr.No.</th>
            <th class="text-center">Name</th>
            <th class="text-center">Card Number</th>
            <th class="text-center" colspan="2">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($find_cards)) {
            $i = 1;
            foreach ($find_cards as $cards) {
                ?>
                <tr>
                    <td class="text-center"><?php echo $i . '.'; ?></td>
                    <td class="text-center"><?php echo $cards['Payment_detail']['name_on_card']; ?></td>
                    <td class="text-center"><?php echo '********'.substr(base64_decode($cards['Payment_detail']['card_number']),-4); ?></td>
                    <td class="text-center" id="delete_added_card" card_id="<?php echo $cards['Payment_detail']['id']; ?>" style="cursor: pointer;"><i class="fa fa-trash-o"></i></td>
                    <td class="text-center" id="edit_added_card" card_id="<?php echo $cards['Payment_detail']['id']; ?>" style="cursor: pointer;"><i class="fa fa-edit"></i></td>
                </tr>
                <?php
                $i++;
            }
        } else {
            ?>
            <tr>
                <td colspan="4"><i>No Cards.</i></td>

            </tr>
            <?php
        }
        ?>
    </tbody>
</table>