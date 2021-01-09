<section id="main-content">
    <section class="wrapper">
        <!-- page start-->

        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-clock-o"></i>
                        Manage Duration(s)
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <?php echo $this->Session->flash(); ?> 
                            <table  class="display table table-bordered table-striped" id="dynamic-table">
                                <thead>
                                    <tr>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>Added On</th>
                                        <th colspan="2" style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($durations)) {
                                        foreach ($durations as $duration) {
                                            ?>
                                            <tr class="gradeX">
                                                <td><?php echo $duration['Duration']['duration']; ?></td>
                                                <td>                                 
                                                    <?php if ($duration['Duration']['status'] == "1") { ?>
                                                        <a title = "Active" href = "<?php echo BASE_URL; ?>webadmin/duration/change_status/<?php echo $duration['Duration']['id']; ?>/1"><img width = "20" alt = "tick" src = "<?php echo $this->webroot; ?>img/tick.png"></a>
                                                    <?php } else { ?>
                                                        <a title = "Inactive" href = "<?php echo BASE_URL; ?>webadmin/duration/change_status/<?php echo $duration['Duration']['id']; ?>/0"><img width = "20" alt = "tick" src = "<?php echo $this->webroot; ?>img/cross.png"></a>
                                                        <?php
                                                    }
                                                    ?>        

                                                </td>
                                                <td><?php echo date('M d, Y', strtotime($duration['Duration']['created'])); ?></td>
                                                   <td><?php echo $this->Html->link('', array('action' => 'edit_duration', $duration['Duration']['id']), array('class' => 'fa fa-edit')); ?></td>
                                                <td style="text-align: center;"><?php echo $this->Form->postLink('', array('action' => 'delete_duration', $duration['Duration']['id']), array('confirm' => 'Are you sure you want to delete Duration?', 'class' => 'fa fa-trash-o')); ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>Added On</th>
                                        <th colspan="2" style="text-align: center;">Action</th>
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