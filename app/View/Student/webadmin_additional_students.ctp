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
                        <i class="fa fa-user-plus"></i>
                        Additional Students
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>

                    <div class="panel-body">



                        <div class="adv-table">
                            <table id="dynamic-table" class="display table table-bordered table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Subject</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($get_all)) {
                                        $i = 1;
                                        foreach ($get_all as $teacher) {
                                            ?>
                                            <tr class="gradeX">
                                                <td><?php echo $i . '.'; ?></td>
                                                <td><?php echo ucfirst($teacher['Child_user']['firstname']) . ' ' . ucfirst($teacher['Child_user']['lastname']); ?></td>
                                                <td><?php echo $teacher['Child_user']['age'] . ' Years'; ?></td>
                                                <td><?php echo $teacher['Child_user']['subject']; ?></td>
                                                <td><?php echo $this->Html->link('', array('action' => 'edit_additional', $teacher['Child_user']['id']), array('class' => 'fa fa-edit')); ?></td>
                                                <td><?php echo $this->Form->postLink('', array('action' => 'delete_additional', $teacher['Child_user']['id'], $teacher['Child_user']['user_id']), array('confirm' => 'Are you sure you want to delete Student?', 'class' => 'fa fa-trash-o')); ?></td>
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
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Subject</th>
                                        <th>Edit</th>
                                        <th>Delete</th>

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
