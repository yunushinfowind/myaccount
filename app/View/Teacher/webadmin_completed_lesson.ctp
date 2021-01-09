<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-users"></i>
                        Manage Teacher(s) Information
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <?php echo $this->Session->flash(); ?> 
                            <table  class="display table table-bordered table-striped dataTable" id="dynamic-table1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Client Name</th>
                                        <th>Subject</th>
                                        <th>Address</th>
                                        <th>Date</th>
                                        <th>Duration</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if (!empty($find_students)) {
                                        foreach ($find_students as $student) {
                                            ?>
                                            <tr class="gradeX">
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo ucfirst($student['User']['first_name']) . ' ' . ucfirst($student['User']['last_name']); ?></td>
                                                <td><?php echo $student['Calendar']['subject_name']; ?></td>
                                                <!--td><?php echo $student['User']['city'] . ' , ' . $student['User']['state'] . ' , ' . $student['User']['address']; ?></td-->
                                                <td><?php
                                                    if (!empty($student['User']['address'])) {
                                                        $exploded_address = explode(',', $student['User']['address']);

                                                        if (!empty($student['User']['suite'])) {
                                                            echo $exploded_address[0] . ', Apt./Ste. ' . $student['User']['suite'] . ', ' . $exploded_address[1] . ', ' . $exploded_address[2] . ' ' . $student['User']['zip_code'];
                                                        } else {
                                                            echo $exploded_address[0] . ', ' . $exploded_address[1] . ', ' . $exploded_address[2] . ' ' . $student['User']['zip_code'];
                                                        }
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?></td>
                                                <td><?php echo date('m/d/Y', strtotime($student['Calendar']['start_date'])); ?></td>
                                                <td><?php echo $student['Calendar']['schedule_time'] . ' Minutes'; ?></td>
                                                <td><?php echo $student['Calendar']['changed_start']; ?></td>
                                                <td><?php echo $student['Calendar']['changed_end']; ?></td>
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
                                        <th>Student Name</th>
                                        <th>Subject</th>
                                        <th>Address</th>
                                        <th>Date</th>
                                        <th>Duration</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                    </tr>
                                </tfoot>
                            </table>
<!--                            <div class="row lessonErning">
                                <p>Total Lesson Earned: </p>
                                <p>Total Lesson Paid: </p>
                            </div>-->

                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- page end-->
    </section>
</section>
<style>
    .lessonErning{
        font-size: 14px;
        margin-right: 10%;
        margin: 0px auto;
    }
</style>