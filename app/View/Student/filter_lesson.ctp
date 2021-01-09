<div class="col-md-12">
    <div class="new_scroll mCustomScrollbar">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Teacher</th>
                        <th>Lesson Date</th>
                        <th>Duration</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($all_lessons) && isset($all_lessons)) {
                        foreach ($all_lessons as $completed) {
                            ?>
                            <tr>
                                <td><?php echo $completed['Calendar']['subject_name']; ?></td>
                                <td><?php echo $teacher_name; ?></td>
                                <td><?php echo date('m/d/Y', strtotime($completed['Calendar']['start_date'])); ?></td>
                                <td><?php echo $completed['Calendar']['schedule_time'] . ' Minutes'; ?></td>
                            </tr>
                            <?php
                        }
                    }else{
                        echo '<tr><td colspan="4">No Lessons in this period.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-md-12 detail">
    <p> Total amount of Lessons Completed : <span><?php echo $total_time; ?></span></p>
    <p> Total amount of Credit Left : <span><?php
            if (!empty($total_hour)) {
                echo $total_hour;
            } else {
                echo "-";
            }
            ?></span></p>
</div>