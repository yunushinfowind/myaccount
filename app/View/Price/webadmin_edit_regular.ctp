<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-dollar"></i>
                        Edit Regular Price
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <?php echo $this->Session->flash(); ?>  
                        <?php echo $this->Form->create('Price', array('url' => array('controller' => 'price', 'action' => 'edit_regular' . '/' . $type, 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal', 'enctype' => 'multipart/form-data')); ?>   

                        <table  class="display table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Duration</th>
                                    <th>Pack</th>
                                    <th>Price ($)</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <?php
                                $i = 1;
                                foreach ($regularRate as $rate) {
                                    ?>
                                    <tr class="gradeX">

                                        <td><?php echo $i . '.'; ?></td>
                                        <td><?php
                                            if (($rate['Time']['min'] != '0') && ($rate['Time']['second'] != '0')) {
                                                echo $rate['Time']['min'] . ' Hours' . $rate['Time']['second'] . ' Minutes';
                                            } else if (($rate['Time']['min'] != '0') && ($rate['Time']['second'] == '0')) {
                                                echo $rate['Time']['min'] . ' Hours';
                                            } else if (($rate['Time']['min'] == '0') && ($rate['Time']['second'] != '0')) {
                                                echo  $rate['Time']['second'] . ' Minutes';
                                            }
                                            ?></td>
                                        <td><?php echo $rate['Price']['pack']; ?></td>
                                        <td><?php echo $this->Form->input('price' . $rate['Price']['id'], array('value' => $rate['Price']['price'], 'label' => false, 'class' => 'pricing form-control' . $rate['Price']['id'])); ?></td>
                                        <td><?php echo $this->Form->postLink('', array('action' => 'delete_regular_rate', $rate['Price']['id'], $rate['Price']['pricing_type']), array('confirm' => 'Are you sure you want to delete rate?', 'class' => 'fa fa-trash-o')); ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>

                            </tbody>
                        </table>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6" style="margin-top:50px;">
                                <button type="submit" class="btn btn-success"><?php echo __('Edit Regular Price'); ?></button>
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
