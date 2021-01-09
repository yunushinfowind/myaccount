<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-users"></i>
                        Transactions
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <?php echo $this->Session->flash(); ?> 
                            <table  class="display table table-bordered table-striped" id="">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>From Date</th>
                                        <th>To Date</th>
                                        <th>Amount</th>
                                        <th>Cleared On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($FindTeacher)) {
                                        $i = 1;
                                        foreach ($FindTeacher as $teacher) {
                                            $address = explode(',', $teacher['User']['address']);
                                            ?>
                                    <tr class="gradeX">
                                        <td><?php echo $i; ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>From Date</th>
                                        <th>To Date</th>
                                        <th>Amount</th>
                                        <th>Cleared On</th>
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