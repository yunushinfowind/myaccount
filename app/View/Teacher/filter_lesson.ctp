<div class="col-md-12">
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sr.no.</th>
                    <th>Student</th>
                    <th>Subject</th>
                    <th>Address</th>
                    <th>Duration</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                if (!empty($find_lessons)) {
                    foreach ($find_lessons as $complete) {

                        $hourly_rate = $complete['hourly_rate'];
                        $time = $complete['Calendar']['schedule_time'];
                        $amount = ($hourly_rate / 60) * $time;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo ucfirst($complete['User']['first_name']) . ' ' . ucfirst($complete['User']['last_name']); ?></td>
                            <td><?php echo $complete['Calendar']['subject_name']; ?></td>
                            <td><?php
                                if (!empty($complete['User']['address'])) {
                                    $exploded_address = explode(',', $complete['User']['address']);

                                    if (!empty($complete['User']['suite'])) {
                                        echo $exploded_address[0] . ' Apt./Ste. ' . $complete['User']['suite'] . ', ' . $exploded_address[1] . ', ' . $exploded_address[2] . ' ' . $complete['User']['zip_code'];
                                    } else {
                                        echo $exploded_address[0] . ', ' . $exploded_address[1] . ', ' . $exploded_address[2] . ' ' . $complete['User']['zip_code'];
                                    }
                                } else {
                                    echo '-';
                                }
                                ?></td>
                            <td><?php echo $complete['Calendar']['schedule_time'] . ' Minutes'; ?></td>
                            <td><?php echo date('m/d/Y', strtotime($complete['Calendar']['start_date'])); ?></td>
                            <td><?php echo $complete['Calendar']['changed_start']; ?></td>
                            <td><?php echo $complete['Calendar']['changed_end']; ?></td>
                            <td><?php
                        echo '$' . number_format($amount, 2);
                                ?></td>
                        </tr>
                        <?php
                        $i++;
                    }
                } else {
                    echo '<tr><td colspan="9">No lesson for this period.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="col-md-12 detail" >
    <p> Total Lessons Taught : <?php
        if (isset($get_time) && !empty($get_time['min']) && !empty($get_time['second'])) {
            echo $get_time['min'] . ' Hours ' . $get_time['second'] . 'Min';
        } elseif (isset($get_time) && !empty($get_time['min'])) {
            echo $get_time['min'] . ' Hours';
        } elseif (isset($get_time) && $get_time['second']) {
            echo $get_time['second'] . ' Min';
        } elseif (isset($time1) && !empty($time1)) {
            echo $time1 . ' Min';
        } else {
            echo '-';
        }
        ?> </p>
    <p>Total Amount Earned: <?php
        if (!empty($calculate_earned)) {
            echo '$ '.$calculate_earned;
        } else {
            echo "-";
        }
        ?></p>
</div>