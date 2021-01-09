<section id="main-content">
    <section class="wrapper">
        <!-- page start-->

        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-bars"></i>
                        Manage Package 
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
			    <?php echo $this->Session->flash(); ?> 
			    <div class="admin_pack">
				<table  class="display table table-bordered table-striped" <?php if (!empty($packs)) {
				echo 'id="dynamic-table"';
			    } ?>>
				    <thead>
					<tr>
					    <th>Sr.No.</th>
					    <th>Package</th>
					    <th>Order</th>
					    <th>Status</th>
					    <th>Added On</th>
					    <th>Action</th>
					</tr>
				    </thead>
				    <tbody>
					<?php
					if (!empty($packs)) {
					    $i = 1;
					    foreach ($packs as $pack) {
						?>
						<tr class="gradeX">
						    <td><?php echo $i; ?></td>
						    <td><?php echo $pack['Pack']['pack']; ?></td>
						    <td><?php echo $pack['Pack']['order']; ?></td>

						    <td>                                 
							<?php if ($pack['Pack']['status'] == "1") { ?>
	    						<a title = "Active" href = "<?php echo BASE_URL; ?>webadmin/pack/change_status/<?php echo $pack['Pack']['id']; ?>/1"><img width = "20" alt = "tick" src = "<?php echo $this->webroot; ?>img/tick.png"></a>
							<?php } else { ?>
	    						<a title = "Inactive" href = "<?php echo BASE_URL; ?>webadmin/pack/change_status/<?php echo $pack['Pack']['id']; ?>/0"><img width = "20" alt = "tick" src = "<?php echo $this->webroot; ?>img/cross.png"></a>
							    <?php
							}
							?>        

						    </td>
						    <td><?php echo date('m/d/Y', strtotime($pack['Pack']['created'])); ?></td>
						    <td><?php echo $this->Html->link('', array('action' => 'edit_pack', $pack['Pack']['id']), array('class' => 'fa fa-edit')); ?>
						<?php echo $this->Form->postLink('', array('action' => 'delete_pack', $pack['Pack']['id']), array('confirm' => 'Are you sure you want to delete Pack?', 'class' => 'fa fa-trash-o')); ?></td>
						</tr>
						<?php
						$i++;
					    }
					}
					?>
				    </tbody>
				    <tfoot>
					<tr>
					    <th>Package</th>
					    <th>Status</th>
					    <th>Added On</th>
					    <th colspan="2" style="text-align: center;">Action</th>
					</tr>
				    </tfoot>
				</table>
			    </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- page end-->
    </section>
</section>