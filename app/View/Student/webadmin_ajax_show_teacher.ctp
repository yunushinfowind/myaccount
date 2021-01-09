<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Teacher's</h4>
        </div>
        <div class="modal-body">
            <table>
                <thead>
                <th>S.no.</th>
                <th>Teacher Name</th>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    if (!empty($user_info) && isset($user_info)) {
                        foreach ($user_info as $user) {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo ucfirst($user['User']['first_name']) . ' ' . ucfirst($user['User']['last_name']); ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                    } else {
                        ?>
                <td style="text-align: center;"><?php echo "No Teachers"; ?></td> 
                <?php }
                ?>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>