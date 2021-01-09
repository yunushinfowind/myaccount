<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-dollar"></i> &nbsp;
                        Pay Teacher
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>

                    <div class="panel-body">

                        <div class="EditAmount" style="float: right; margin-right:50px;">
                            <button type="submit" class="btn btn-danger"><?php echo __('Update Earnings'); ?></button>
                        </div>
                        <div class="form">
                            <?php echo $this->Session->flash(); ?>  
                            <?php echo $this->Form->create('Teacher_earning', array('url' => array('controller' => 'teacher', 'action' => 'pay', $this->params['pass'][0], 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal', 'enctype' => 'multipart/form-data')); ?>   

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Outstanding Amount</label>
                                <div class="col-lg-6">
                                    <div class="input-group m-bot15">
                                        <span class="input-group-addon btn-white"><i class="fa fa-dollar"></i></span>
                                        <?php echo $this->Form->input('total_earning', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Outstanding Amount', 'disabled' => 'disabled', 'value' => @$Teacher_earning['Teacher_earning']['total_earning'])); ?>
                                    </div>

                                </div>
                            </div>


                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Date Range</label>
                                <div class="col-lg-6">
                                    <div class="col-lg-4">
                                        <input type="text" id="from" class="form-control" placeholder="From: 01/01/2017">
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="text" id="to" class="form-control" placeholder="To: <?php echo date("m/d/Y"); ?>">
                                    </div>
                                    <div class="col-lg-4">
                                        <button type="button" class="btn btn-info" id="calculate_amt"><?php echo __('Calculate'); ?></button>
                                    </div>
                                </div>
                            </div>

                           
                            <div class="col-md-12">

                                <table class="display table table-bordered table-striped" id="DefaultData" >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student Name</th>
                                            <th>Lesson Date</th>
                                            <th>Subject</th>
                                            <th>Earned Date</th>
                                            <th>Schedule Time</th>
                                            <th>Amount</th>
                                            <th>Select To Pay</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                      //  pr($earnings);
                                        if (!empty($earnings)) {
                                            $i = 1;
                                            foreach ($earnings as $result) {
                                                ?>
                                                <tr class="gradeX">
                                                    <td><?php echo $i . '.'; ?></td>
                                                    <td><?php echo $result['User']['first_name'] . ' ' . $result['User']['last_name']; ?></td>
                                                    <td><?php echo date('m/d/Y', strtotime($result['Calendar']['start_date'])); ?></td>
                                                    <td><?php echo $result['Calendar']['subject_name']; ?></td>
                                                    <td><?php echo date('m/d/Y', strtotime($result['Earning']['earned_date'])); ?></td>
                                                    <td><?php echo $result['Converted_time']; ?></td>
                                                    <td><?php echo '$ ' . $result['Amount']; ?></td>
                                                    <td><?php
                                                        echo $this->Form->input('', array(
                                                            'hiddenField' => false,
                                                            'type' => 'checkbox', 'value' => $result['Calendar']['id'], 'class' => 'Paychckbox', 'amount' => $result['Amount'], 'student_id' => $result['User']['id']));
                                                        ?> </td>


                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        } else {
                                            echo '<tr class="gradeX">
                    <td colspan="8" style="text-align:center;">No Results.</td></tr>';
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Student Name</th>
                                            <th>Lesson Date</th>
                                            <th>Subject</th>
                                            <th>Earned Date</th>
                                            <th>Schedule Time</th>
                                            <th>Amount</th>
                                            <th>Select To Pay</th>
                                        </tr>
                                    </tfoot>
                                </table>

                                <input type="hidden" id="selectedTeachers" name="data[Teacher_earning][calendar_id]">

                                <div class="ShowRecords"></div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Amount Earned</label>
                                <div class="col-lg-6">
                                    <div class="input-group m-bot15">
                                        <span class="input-group-addon btn-white"><i class="fa fa-dollar"></i></span>
                                        <?php echo $this->Form->input('amount_earned', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Amount Earned', 'disabled' => 'disabled', 'id' => 'amt_earned')); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Pay<span class="asterick"> *</span></label>
                                <div class="col-lg-6">
                                    <div class="input-group m-bot15">
                                        <span class="input-group-addon btn-white"><i class="fa fa-dollar"></i></span>
                                        <?php echo $this->Form->input('amount', array('class' => 'form-control', 'label' => FALSE, 'placeholder' => 'Amount', 'required' => FALSE)); ?>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="teacher_id" value="<?php echo $this->params['pass'][0]; ?>">
                            <input type="hidden" name="data[Teacher_earning][from_date]" id="show_from">
                            <input type="hidden" name="data[Teacher_earning][to_date]" id="show_to">


                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-6">
                                    <button type="submit" class="btn btn-success"><?php echo __('Pay Teacher'); ?></button>
                                </div>
                            </div>
                            <?php echo $this->Form->end(); ?>
                        </div>


                    </div>
                </section>
            </div>
        </div>
    </section>
</section>
<style>
    table.table {
        margin-bottom: 15px !important;
    }
</style>
