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
                        <i class="fa fa-dollar"></i>
                        LESSON PURCHASED
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <?php echo $this->Session->Flash(); ?>
                    <div class="panel-body">

                        <div class="adv-table">
                            <table id="dynamic-table" class="display table table-bordered table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th>Sr.no.</th>
                                        <th>Subject</th>
                                        <th>Duration</th>
                                        <th>Pack</th>
                                        <th>Subscribed On</th>
                                        <th>status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if (!empty($find_all)) {
                                        foreach ($find_all as $student) {
//                                            pr($student);
                                            ?>
                                            <tr class="gradeX">
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $student['Payment']['subject_name']; ?></td>
                                                <td><?php echo $student['Payment']['duration']; ?></td>
                                                <td><?php

                                                    if(!empty($student['Pack'])) {
                                                        echo $student['Pack']['pack'];
                                                    } else {
                                                        echo $student['Payment']['pack_name'];
                                                    }
                                                    ?></td>
                                                <td><?php echo date('m/d/Y', strtotime($student['Payment']['created'])); ?></td>
                                                <td>
                                                    <?php
                                                    if ($student['Payment']['status'] == '1'  || $student['Payment']['status'] == '2') {
                                                        ?>
                                                        <img src="<?php echo $this->webroot . 'img/tick.png'; ?>" style="width: 50px;">
                                                    <?php } elseif ($student['Payment']['status'] == '0') { ?>
                                                        <img src="<?php echo $this->webroot . 'img/cross.png'; ?>" style="width: 50px;">
                                                    <?php } ?>
                                                </td>


                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Sr.no.</th>
                                        <th>Subject</th>
                                        <th>Duration</th>
                                        <th>Pack</th>
                                        <th>Subscribed On</th>
                                        <th>status</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- page end-->
    </section>
</section>