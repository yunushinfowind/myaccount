<section id="main-content">
    <section class="wrapper">
        <!-- page start-->

        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-dollar"></i>
                        Manage Price(s)
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
                    <div class="panel-body">

                        <?php
                        $pricing_type_color = array('0' => 'orange', '1' => 'green', '2' => 'pink', '3' => 'tar', '4' => 'yellow-b' );
                        $i = 0;
                        foreach ($pricing_types as $pt) {
                        ?>
                        <div class="col-md-4">
                            <div class="mini-stat clearfix">
                                <a href="<?php echo BASE_URL . 'webadmin/price/edit_price/'.  $pt['Pricing_type']['id'] ?>">
                                    <span class="mini-stat-icon <?php if( $pt['Pricing_type']['enabled']) echo $pricing_type_color[$i%5]; ?>"><i class="fa fa-dollar"></i></span>
                                    <div class="mini-stat-info">
                                        <span><?php echo $pt['Pricing_type']['name']; ?> </span>

                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php
                            $i++;
                        }
                        ?>

<!--
                        <div class="col-md-4">
                            <div class="mini-stat clearfix">
                                <a href="<?php echo BASE_URL . 'webadmin/price/old_rate' ?>">
                                    <span class="mini-stat-icon orange"><i class="fa fa-dollar"></i></span>
                                    <div class="mini-stat-info">
                                        <span>Old </span>
                                        Rate
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mini-stat clearfix">
                                <a href="<?php echo BASE_URL . 'webadmin/price/regular_price'; ?>">
                                    <span class="mini-stat-icon green"><i class="fa fa-dollar"></i></span>
                                    <div class="mini-stat-info">
                                        <span>Regular</span>
                                        Pricing
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mini-stat clearfix">
                                <a href="<?php echo BASE_URL . 'webadmin/price/violin_price'; ?>">
                                    <span class="mini-stat-icon pink"><i class="fa fa-dollar"></i></span>
                                    <div class="mini-stat-info">
                                        <span>Violin</span>
                                        Pricing
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>
-->
                    <div class="col-md-3"></div>


                </section>
            </div>
        </div>

        <!-- page end-->
    </section>
</section>