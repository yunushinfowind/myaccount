<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-dollar"></i>
                        Edit Old Rate Price
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <?php echo $this->Session->flash(); ?>  
                        <?php echo $this->Form->create('Price', array('url' => array('controller' => 'price', 'action' => 'edit_rate' . '/' . $type, 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal', 'enctype' => 'multipart/form-data')); ?>   

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
                                foreach ($oldRate as $rate) {
                                    ?>
                                    <tr class="gradeX">
                                        <td><?php echo $i . '.'; ?></td>
                                        <td><?php
                                            if (($time['min'] != '0') && ($time['second'] != '0')) {
                                                echo $time['min'] . ' Hours' . $time['second'] . ' Minutes';
                                            } elseif (($time['min'] == '0') && ($time['second'] != '0')) {
                                                echo  $time['second'] . ' Minutes';
                                            } elseif (($time['min'] != '0') && ($time['second'] == '0')) {
                                                echo $time['min'] . ' Hours';
                                            }
                                            ?></td>
                                        <td><?php echo $rate['Price']['pack']; ?></td>
                                        <td><?php echo $this->Form->input('price' . $rate['Price']['id'], array('value' => $rate['Price']['price'], 'label' => false, 'class' => 'form-control pricing' . $rate['Price']['id'])); ?></td>
                                        <td><?php echo $this->Form->postLink('', array('action' => 'delete_old_rate', $rate['Price']['id'], $rate['Price']['pricing_type']), array('confirm' => 'Are you sure you want to delete rate?', 'class' => 'fa fa-trash-o')); ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>

                            </tbody>
                            <tfoot>
<!--                                <tr>
                                    <th>Duration</th>
                                    <th>Pack</th>
                                    <th>Price</th>
                                    <th>Delete</th>
                                </tr>-->
                            </tfoot>
                        </table>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6" style="margin-top:50px;">
                                <button type="submit" class="btn btn-success"><?php echo __('Edit Old Price'); ?></button>
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
