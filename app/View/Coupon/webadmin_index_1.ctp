<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-money"></i>&nbsp;
                        Manage Coupon(s)
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
                                        <th>#</th>
                                        <th>Coupon Type</th>
                                        <th>Coupon Code</th>
                                        <th>Discount</th>
                                        <th>Start Date</th>
                                        <th>Last Date</th>
                                        <th>Status</th>
                                        <th>Added On</th>
                                        <th colspan="2" style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
				    <?php
				    if (!empty($coupons)) {
					$i = 1;
					foreach ($coupons as $coupon) {
					    ?>
					    <tr class="gradeX">
						<td><?php echo $i . '.'; ?></td>
						<td><?php echo $coupon['Coupon']['coupon_type']; ?></td>
						<td><?php echo $coupon['Coupon']['coupon_code']; ?></td>
						<td><?php
						    if ($coupon['Coupon']['discount_type'] == '%') {
							echo $coupon['Coupon']['discount_value'] . ' ' . $coupon['Coupon']['discount_type'];
						    } else if ($coupon['Coupon']['discount_type'] == '$') {
							echo $coupon['Coupon']['discount_type'] . ' ' . $coupon['Coupon']['discount_value'];
						    }
						    ?></td>
						<td><?php echo date('m-d-Y', strtotime($coupon['Coupon']['start_date'])); ?></td>
						<td><?php echo date('m-d-Y', strtotime($coupon['Coupon']['end_date'])); ?></td>
						<td>                                                               <?php
						    $today = date("Y-m-d");
						    $date = date('Y-m-d', strtotime($coupon['Coupon']['end_date']));

						    if (($date >= $today) && ($coupon['Coupon']['status'] == '1')) {
							echo "<img src='$this->webroot" . "img/tick.png' style='width:50px;height:50px;'>";
						    } elseif ($date < $today) {
							echo "<img src='$this->webroot" . "img/cross.png' style='width:50px;height:50px;'>";
						    } elseif ($coupon['Coupon']['status'] == '0') {
							echo "<img src='$this->webroot" . "img/cross.png' style='width:50px;height:50px;'>";
						    }
						    ?>      

						</td>
						<td><?php echo date('m/d/Y', strtotime($coupon['Coupon']['created'])); ?></td>
						<td style="text-align: center;"><?php echo $this->Html->link('', array('action' => 'edit_coupon', $coupon['Coupon']['id']), array('class' => 'fa fa-edit')); ?></td>

						<td style="text-align: center;"><?php echo $this->Form->postLink('', array('action' => 'delete_coupon', $coupon['Coupon']['id']), array('confirm' => 'Are you sure you want to delete Coupon?', 'class' => 'fa fa-trash-o')); ?></td>
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
                                        <th>Coupon Type</th>
                                        <th>Coupon Code</th>
                                        <th>Discount</th>
                                        <th>Start Date</th>
                                        <th>Last Date</th>
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