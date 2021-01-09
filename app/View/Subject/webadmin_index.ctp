<section id="main-content">
    <section class="wrapper">
        <!-- page start-->

        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-book"></i>
                        Manage Subject(s)
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
			    <?php echo $this->Session->flash(); ?> 
			    <div class="admin_subject">
				<table  class="display table table-bordered table-striped" id="<?php if (!empty($subjects)) {
				echo 'dynamic-table';
			    }
			    ?>">
				    <thead>
					<tr>
					    <th>Sr.No.</th>
					    <th>Subject</th>
					    <th>Status</th>
					    <th>Order</th>
					    <th>Added On</th>
					    <th>Edit</th>
					    <th>Delete</th>
					</tr>
				    </thead>
				    <tbody>
					<?php
					if (!empty($subjects)) {
					    $i = 1;
					    foreach ($subjects as $subject) {
						?>

						<tr class="gradeX">
						    <td><?php echo $i . '.'; ?></td>
						    <td><?php echo $subject['Subject']['subject']; ?></td>
						    <td>                                 
							<?php if ($subject['Subject']['status'] == "1") { ?>
	    						<a title = "Active" href = "<?php echo BASE_URL; ?>webadmin/subject/change_status/<?php echo $subject['Subject']['id']; ?>/1"><img width = "20" alt = "tick" src = "<?php echo $this->webroot; ?>img/tick.png"></a>
							<?php } else { ?>
	    						<a title = "Inactive" href = "<?php echo BASE_URL; ?>webadmin/subject/change_status/<?php echo $subject['Subject']['id']; ?>/0"><img width = "20" alt = "tick" src = "<?php echo $this->webroot; ?>img/cross.png"></a>
							    <?php
							}
							?>        

						    </td>
						    <td><?php echo $this->Form->input('order', array('class' => 'form-control subjectOrder', 'label' => FALSE, 'value' => $subject['Subject']['order'], 'subject_id' => $subject['Subject']['id'])); ?></td>
						    <td><?php echo date('m/d/Y', strtotime($subject['Subject']['created'])); ?></td>
						    <td><?php echo $this->Html->link('', array('action' => 'edit_subject', $subject['Subject']['id']), array('class' => 'fa fa-edit')); ?></td>
						    <td><?php echo $this->Form->postLink('', array('action' => 'delete_subject', $subject['Subject']['id']), array('confirm' => 'Are you sure you want to delete Subject?', 'class' => 'fa fa-trash-o')); ?></td>
						</tr>
						<?php
						$i++;
					    }
					}
					?>
				    </tbody>
				    <tfoot>
					<tr><th>Sr.No.</th>
					    <th>Subject</th>
					    <th>Status</th>
					    <th>Order</th>
					    <th>Added On</th>
					    <th>Edit</th>
					    <th>Delete</th>
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