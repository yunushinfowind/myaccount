<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-dollar"></i>
                        Old Rate Price
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <?php echo $this->Session->flash(); ?>  
                        <?php echo $this->Form->create('Price', array('url' => array('controller' => 'price', 'action' => 'old_rate', 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal', 'enctype' => 'multipart/form-data')); ?>   
			<div class="ol_rate">
                        <table  class="display table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sr.No.</th>
                                    <th>Duration</th>
                                    <th>Pack</th>
                                    <th>Order</th>
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
                                            if (($rate['Time']['min'] != '0') && ($rate['Time']['second'] != '0')) {
                                                echo $rate['Time']['min'] . ' Hours' . $rate['Time']['second'] . ' Minutes';
                                            } elseif (($rate['Time']['min'] == '0') && ($rate['Time']['second'] != '0')) {
                                                echo $rate['Time']['second'] . ' Minutes';
                                            } elseif (($rate['Time']['min'] != '0') && ($rate['Time']['second'] == '0')) {
                                                echo $rate['Time']['min'] . ' Hours';
                                            }
                                            ?></td>
                                        <td>

                                            <?php echo $rate['Pack']['pack']; ?>
                                        </td>
                                        <td><?php echo $this->Form->input('order' . $rate['Price']['id'], array('class' => 'form-control', 'label' => FALSE, 'value' => $rate['Price']['order'])); ?></td>
                                        <td><?php echo $this->Form->input('price' . $rate['Price']['id'], array('value' => $rate['Price']['price'], 'label' => false, 'class' => 'form-control pricing' . $rate['Price']['id'])); ?></td>
                                        <td>
                                            <a href="<?php echo BASE_URL . 'webadmin/price/delete_old_rate/' . $rate['Price']['id']; ?>" onclick="return confirm('Are you sure?');"><i class="fa fa-trash-o"></i></a></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>

                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
		    </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6" style="margin-top:50px;">
                                <button type="submit" class="btn btn-primary"><?php echo __('Edit Old Price'); ?></button>
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
