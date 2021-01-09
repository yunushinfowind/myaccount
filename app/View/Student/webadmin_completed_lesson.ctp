<?php
$id = $this->params['pass'][0];
?>
<section id="main-content">
    <section class="wrapper">
        <!-- page start-->

        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-check"></i>
                        COMPLETED LESSON    
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>

                    <div class="panel-body">



                        <div class="adv-table">
                            <table id="dynamic-table1" class="display table table-bordered table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Subject</th>
                                        <th>Teacher</th>
                                        <th>Duration</th>
                                        <th>Completed On</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    //pr($completed_lessons);
                                    if (!empty($completed_lessons)) {
                                        foreach ($completed_lessons as $lesson) {
                                            ?>
                                            <tr class="gradeX">
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $lesson['Calendar']['subject_name']; ?></td>
                                                <td><?php echo ucfirst($lesson['teacher']['first_name']) . ' ' . ucfirst($lesson['teacher']['last_name']); ?></td>
                                                <td><?php echo $lesson['time']; ?></td>
                                                <td><?php echo date('m/d/Y', strtotime($lesson['Calendar']['start_date'])); ?></td>

                                                <td><?php echo date('h:i a', strtotime($lesson['Calendar']['time'])); ?></td>
                                                <td><?php echo date('h:i a', strtotime($lesson['Calendar']['end_time'])); ?></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                    ?>


                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Subject</th>
                                        <th>Teacher</th>
                                        <th>Duration</th>
                                        <th>Completed On</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                    </tr>
                                </tfoot>

                            </table>


                        </div>

                        <div class="completeLesson_right" style="float: right; margin: -37px -150px 0 -15px">
                            <p>Total Amount of Lessons Completed : <span style="font-weight: bold;"><?php
                                    if (!empty($total_time)) {
                                        echo $total_time;
                                    } else {
                                        echo '-';
                                    }
                                    ?></span></p>
                            <p> Total Amount of Credit Left : <span style="font-weight: bold;"><?php
                                    if (!empty($total_hour)) {
                                        echo $total_hour;
                                    } else {
                                        echo "-";
                                    }
                                    ?></span></p>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- page end-->
    </section>
</section>
