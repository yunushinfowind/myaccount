
<?php
$hasData = false;
if (!empty($all_teachers)) {
    $i = 1;
    echo "Number of teachers: ".count($all_teachers);
    foreach ($all_teachers as $teacher) {
        if (!empty($teacher['Total_earning']) || !empty($teacher['incomplete'])) {
            $hasData = true;
            $address = explode(',', $teacher['User']['address']);
            ?>
            <tr class="gradeX">
                <td><?php
                    if (!empty($teacher['Total_earning']) || !empty($teacher['incomplete'])) {
                        echo $this->Form->input('', array(
                            'hiddenField' => false,
                            'type' => 'checkbox', 'name' => 'data[User][foo][]', 'value' => $teacher['User']['id'], 'class' => 'userchckbox', 'amountShown' => !empty($teacher['Total_earning']) ? $teacher['Total_earning'] : 0));
                    } else {
                        echo '-';
                    }
                    ?> </td>
                <td><?php echo $i; ?></td>
                <td><a href="<?php echo BASE_URL . 'webadmin/teacher/pay/' . $teacher['User']['id']; ?>"><?php echo ucfirst($teacher['User']['first_name']) . ' ' . ucfirst($teacher['User']['last_name']); ?></a>
                    <?php if(!empty($teacher['incomplete'])) echo "<br/><span style='color:red;'>".$teacher['incomplete']." incomplete lessons in date range</span>"; ?>
                </td>
                <td><?php echo $teacher['User']['primary_phone']; ?></td>
                <td><?php
                    if (!empty($teacher['User']['suite'])) {
                        echo $address[0] . ' Apt. ' . $teacher['User']['suite'] . ' ' . $address[1] . ', ' . $address[2] . ' ' . $teacher['User']['zip_code'];
                    } else {
                        echo $address[0] . ' ' . $address[1] . ', ' . $address[2] . ' ' . $teacher['User']['zip_code'];
                    }
                    ?></td>

                <td><?php echo $teacher['User']['email']; ?></td>

                <td class="TeacherAmt"><?php
                    if (!empty($teacher['Total_earning'])) {
                        echo '$ ' . $teacher['Total_earning'];
                    } else {

                    }
                    ?></td>

            </tr>
            <?php
            $i++;
        } else {
            //echo ' <tr class="gradeX" style="text-align:center;"><td colspan="7">No Payments.</td></tr>';
            //break;
        }
    }
} else {
    echo '<tr class="grade"><td colspan="7" style="text-align:center;">No Payments!</td></tr>';
}

if(!$hasData) {
    echo '<tr class="grade"><td colspan="7" style="text-align:center;">No Payments!</td></tr>';
}
?>
