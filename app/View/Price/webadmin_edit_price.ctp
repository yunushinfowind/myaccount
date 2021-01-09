<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-dollar"></i>
                        Edit <?php echo $currentPricingType['Pricing_type']['name']; ?> Details
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <?php echo $this->Session->flash(); ?>
                        <?php echo $this->Form->create('Pricing_type', array('url' => array('controller' => 'price', 'action' => 'update_pricing_type' . '/' . $type, 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal', 'enctype' => 'multipart/form-data')); ?>

                        <label>Name</label>
                        <?php echo $this->Form->input('name', array('value' => $currentPricingType['Pricing_type']['name'], 'label' => false, 'class' => 'form-control')); ?>

                        <br/><br/>

                        <?php echo $this->Form->checkbox('enabled', array('checked' => $currentPricingType['Pricing_type']['enabled'])) ?>
                        <label>&nbsp;Enabled</label>



                        <div class="clearfix"></div>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6" style="margin-top:50px;">
                                <button type="submit" class="btn btn-success"><?php echo __('Update '.$currentPricingType['Pricing_type']['name'].' Details'); ?></button>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
            </div>



    </section>
    </div>
    </div>

        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-dollar"></i>
                        Edit <?php echo $currentPricingType['Pricing_type']['name']; ?>
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <?php echo $this->Session->flash(); ?>
                        <?php echo $this->Form->create('Price', array('url' => array('controller' => 'price', 'action' => 'edit_price' . '/' . $type, 'prefix' => 'webadmin'), 'id' => 'AddPageForm', 'class' => 'cmxform form-horizontal', 'enctype' => 'multipart/form-data')); ?>

                        <div class="violiNpric">
                            <table  class="display table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th style="text-align: center;">Sr.No.</th>
                                    <th style="text-align: center;">Duration</th>
                                    <th style="text-align: center;">Pack</th>
                                    <th style="text-align: center;">Order</th>
                                    <th style="text-align: center;">Price ($)</th>
                                    <th style="text-align: center;">Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (!empty($currentRate)) {
                                    $i = 1;
                                    foreach ($currentRate as $rate) {
                                        ?>
                                        <tr class="gradeX">
                                            <td style="text-align: center;"><?php echo $i . '.'; ?></td>
                                            <td style="text-align: center;"><?php
                                                if (!empty($rate['Duration']['min']) && !empty($rate['Duration']['second'])) {
                                                    echo $rate['Duration']['min'] . ' Hours ' . $rate['Duration']['second'] . ' Minutes';
                                                } elseif (!empty($rate['Duration']['min']) && empty($rate['Duration']['second'])) {
                                                    echo $rate['Duration']['min'] . ' Hours';
                                                } elseif (empty($rate['Duration']['min']) && !empty($rate['Duration']['second'])) {
                                                    echo $rate['Duration']['second'] . ' Minutes';
                                                } else {
                                                    echo '-';
                                                }
                                                ?></td>
                                            <td style="text-align: center;">

                                                <?php echo $rate['Pack']['pack']; ?></td>
                                            <td><?php echo $this->Form->input('order' . $rate['Price']['id'], array('value' => $rate['Price']['order'], 'label' => false, 'class' => 'form-control')); ?>  </td>
                                            <td style="text-align: center;"><?php echo $this->Form->input('price' . $rate['Price']['id'], array('value' => $rate['Price']['price'], 'label' => false, 'class' => 'form-control pricing' . $rate['Price']['id'])); ?></td>

                                            <td style="text-align: center;"><a href="<?php echo BASE_URL . 'webadmin/price/delete_price/' . $rate['Price']['id']; ?>" onclick="return confirm('Are you sure?');"><i class="fa fa-trash-o"></i></a></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                } else {
                                    echo '<td colspan="5"> No Price for '. $currentPricingType['Pricing_type']['name'].'.</td>';
                                }
                                ?>

                                </tbody>
                            </table>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6" style="margin-top:50px;">
                                <button type="submit" class="btn btn-success"><?php echo __('Edit '.$currentPricingType['Pricing_type']['name']); ?></button>
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
