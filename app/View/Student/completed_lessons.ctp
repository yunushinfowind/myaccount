<div class="new_ryt padding-right">
    <div class="right_side purchase clearfix">
        <div class="col-md-12">
            <h1> Filter Lessons </h1>
        </div>

        <div class="col-md-12">

            <div class="col-md-12 filterSearch">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="usr">Start Date:</label>
                        <input type="text" class="form-control" id="filterStart">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="pwd">End Date:</label>
                        <input type="text" class="form-control" id="filterEnd">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">

                        <button type="button" id="filterData" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </div>


        </div>

        <div class="clearfix"></div>

        <div class="col-md-12">
            <h1> Completed Lessons </h1>
        </div>

        <div class="clearfix"></div>
        <input type="hidden" id="studentId" value="<?php echo $user_id; ?>">
        <div id="appendLesson">
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
                                if (!empty($completed_lesson) && isset($completed_lesson)) {
                                    foreach ($completed_lesson as $completed) {
                                        ?>
                                        <tr>
                                            <td><?php echo $completed['Calendar']['subject_name']; ?></td>
                                            <td><?php echo $teacher_name; ?></td>
                                            <td><?php echo date('m/d/Y', strtotime($completed['Calendar']['start_date'])); ?></td>
                                            <td><?php
                                                if (!empty($completed['converted_time'])) {
                                                    echo $completed['converted_time'];
                                                } else {
                                                    echo '-';
                                                }
                                                ?></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="4">No Lessons completed.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12 detail">
<!--                <div class="col-md-6" style="float:left;">
                    <p style="text-align: left;">Current Lesson Quantity:<span> </span></p>
                    <p style="text-align: left;">Amount of Completed Credit:<span> <?php
                            if (!empty($total_hour)) {
                                echo $total_hour;
                            } else {
                                echo "-";
                            }
                            ?></span></p>
                    <p style="text-align: left;">Current Amount of Credit Available:<span> </span></p>
                </div>-->
                <div class="col-md-6" style="float:right;">
                    <p> Total Amount of Lessons Completed : <span><?php
                            if (!empty($set_time['min']) && !empty($set_time['second'])) {
                                echo $set_time['min'] . ' Hours ' . $set_time['second'] . ' Minutes';
                            } elseif (!empty($set_time['min']) && empty($set_time['second'])) {
                                echo $set_time['min'] . ' Hours ';
                            } elseif (empty($set_time['min']) && !empty($set_time['second'])) {
                                echo $set_time['second'] . ' Minutes';
                            } else {
                                echo '-';
                            }
                            ?></span></p>
<!--                    <p> Total Amount of Credit Left : <span></span></p>-->
                </div> 
            </div>
        </div>

    </div>
</div>
</div>
</div>

<!--dashboard closed -->


<style>
    .filterSearch{
        background: none repeat scroll 0 0 #eee;
        padding: 7px 0;
    }

    .filterSearch .form-group
    {
        margin-bottom: 0;
    }
    #filterData{
        border-radius: 4px;
        margin-top: 26px;
        background: none repeat scroll 0 0 #f47121;
        border: 0 none;
        color: #fff;
        font-size: 14px;
        margin: 20px 0;
        width: 170px;
    }


</style>