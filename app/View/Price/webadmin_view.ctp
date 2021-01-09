<section id="main-content">
    <section class="wrapper">
        <!-- page start-->

        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-dollar"></i>
                        Manage Price(s)

                        <a href="<?php echo BASE_URL . 'webadmin/price/'; ?>" style='margin-left:800px'><input type="button" name="Manage Price" value="Back to Manage" class="manageBtn"></a>
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
                                        <th>Pricing Type</th>
                                        <th>Duration</th>
                                        <th>Pack</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th colspan="2" style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($prices as $price) {
                                        ?>
                                        <tr class="gradeX">
                                            <td><?php echo $price['Price']['pricing_type']; ?></td>
                                            <td><?php echo $price['Price']['duration']; ?></td>
                                            <td><?php echo $price['Price']['pack']; ?></td>
                                            <td><?php echo '$' . $price['Price']['price']; ?></td>
                                            <td>                                 
                                                <?php if ($price['Price']['status'] == "1") { ?>
                                                    <a title = "Deactive" href = "<?php echo BASE_URL; ?>webadmin/price/change_status/<?php echo $price['Price']['id']; ?>/1"><img width = "20" alt = "tick" src = "<?php echo $this->webroot; ?>/img/tick.png"></a>
                                                <?php } else { ?>
                                                    <a title = "active" href = "<?php echo BASE_URL; ?>webadmin/price/change_status/<?php echo $price['Price']['id']; ?>/0"><img width = "20" alt = "tick" src = "<?php echo $this->webroot; ?>/img/cross.png"></a>
                                                    <?php
                                                }
                                                ?>        

                                            </td>
                                            <td><?php echo $this->Html->link('', array('action' => 'edit_price', $price['Price']['id']), array('class' => 'fa fa-edit')); ?></td>
                                            <td style="text-align: center;"><?php echo $this->Form->postLink('', array('action' => 'delete_price', $price['Price']['id']), array('confirm' => 'Are you sure you want to delete Price?', 'class' => 'fa fa-trash-o')); ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Pricing Type</th>
                                        <th>Duration</th>
                                        <th>Pack</th>
                                        <th>Price</th>
                                        <th>Status</th>
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
<style>
    .manageBtn {
  background: #1fb5ad none repeat scroll 0 0;
  border: medium none black;
  border-radius: 5px;
  color: #fff;
  height: 30px;
}
</style>