<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-users"></i>
                        Payroll
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="form-group col-sm-12">

                            <div class="col-lg-6 filterPayrol">

				<input type="text" id="from_payroll" class="form-control" placeholder="From: 01/01/2017">


				<input type="text" id="to_payroll" class="form-control" placeholder="To: <?php echo date("m/d/Y"); ?>">

				<button type="button" class="btn btn-warning" id="calculate_payroll_amt"><?php echo __('Calculate'); ?></button>


                            </div>
                        </div>


			<?php echo $this->Session->flash(); ?> 

			<div class="admin_pyrol">
                            <table  class="display table table-bordered table-striped ">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll" value=""></th>
                                        <th>Sr.No</th>
                                        <th>Name</th>
                                        <th>Phone Number</th>
                                        <th>Address</th>
                                        <th>Email</th>
                                        <th>Amount</th>

                                    </tr>
                                </thead>
                                <tbody class="defaultRecord">
				    <?php
				    if (!empty($all_teachers)) {
					$i = 1;
					echo "Number of teachers: ".count($all_teachers);
					foreach ($all_teachers as $teacher) {
					    if (!empty($teacher['Total_earning']) || !empty($teacher['incomplete'])) {
						$address = explode(',', $teacher['User']['address']);
						?>
	    				    <tr class="gradeX">
	    					<td><?php
                            if (!empty($teacher['Total_earning']) || !empty($teacher['incomplete'])) {
                                echo $this->Form->input('', array(
                                    'hiddenField' => false,
                                    'type' => 'checkbox', 'name' => 'data[User][foo][]', 'value' => $teacher['User']['id'], 'class' => 'userchckbox', 'amountShown' => !empty($teacher['Total_earning']) ? $teacher['Total_earning'] : 0));
                            } else {
                                echo '-';
                            }
							?> </td>
	    					<td><?php echo $i; ?></td>
	    					<td><a href="<?php echo BASE_URL . 'webadmin/teacher/pay/' . $teacher['User']['id']; ?>"><?php echo ucfirst($teacher['User']['first_name']) . ' ' . ucfirst($teacher['User']['last_name']); ?></a>
                            <?php if(!empty($teacher['incomplete'])) echo "<br/><span style='color:red;'>".$teacher['incomplete']." incomplete lessons in date range</span>"; ?>
                            </td>
	    					<td><?php echo $teacher['User']['primary_phone']; ?></td>
	    					<td><?php
							if (!empty($teacher['User']['suite'])) {
							    echo $address[0] . ' Apt. ' . $teacher['User']['suite'] . ' ' . $address[1] . ', ' . $address[2] . ' ' . $teacher['User']['zip_code'];
							} else {
							    echo $address[0] . ' ' . $address[1] . ', ' . $address[2] . ' ' . $teacher['User']['zip_code'];
							}
							?></td>

	    					<td><?php echo $teacher['User']['email']; ?></td>

	    					<td class="TeacherAmt"><?php
							if (!empty($teacher['Total_earning'])) {
							    echo '$ ' . $teacher['Total_earning'];
							} else {

							}
							?></td>

	    				    </tr>
						<?php
						$i++;
					    } else {
						//echo ' <tr class="gradeX" style="text-align:center;"><td colspan="7">No Payments.</td></tr>';
						//break;
					    }
					}
				    } else {
					echo '<tr class="grade"><td colspan="7" style="text-align:center;">No Payments!</td></tr>';
				    }
				    ?>
                                </tbody>

                                <input type="hidden" id="selectedUsers">
                                <input type="hidden" id="amt_Paid">

                            </table>


                        </div>
                        <button class="btn btn-primary PayAllTeachers" type="button" id="PaymentToTeachers">Pay</button>
                    </div>

                </section>
            </div>
        </div>
        <!-- page end-->
    </section>
</section>

<style>
    .PayAllTeachers {
        float: right;
        margin-right: 12px;
        margin-top: 14px;
        width: 77px;
    }
</style>