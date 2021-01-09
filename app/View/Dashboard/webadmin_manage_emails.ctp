<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        <i class="fa fa-mail-reply"></i>&nbsp;
                        Manage Automatic Emails
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
			    <?php echo $this->Session->flash(); ?> 
			    <div class="mngeEmails">
				<table  class="display table table-bordered table-striped" >
				    <thead>
					<tr>
					    <th>Sr.No</th>
					    <th>Title</th>
					    <th>Send</th>
					</tr>
				    </thead>
				    <tbody>

					<tr>
					    <td><?php echo '1.'; ?></td>
					    <td>Student Resend Details</td>
					    <td><a href="<?php echo BASE_URL . 'webadmin/dashboard/student_resend/'; ?>"><button class="btn btn-success" type="button">Student Resend Details</button></a></td>
					</tr>

					<tr>
					    <td><?php echo '2.'; ?></td>
					    <td>Teacher Resend Details</td>
					    <td><a href="<?php echo BASE_URL . 'webadmin/dashboard/teacher_resend/'; ?>"><button class="btn btn-success" type="button">Teacher Resend Details</button></a></td>
					</tr>

					<tr>
					    <td><?php echo '3.'; ?></td>
					    <td>Make a Payment</td>
					    <td><a href="<?php echo BASE_URL . 'webadmin/dashboard/make_payment/'; ?>"><button class="btn btn-success" type="button">Make a Payment</button></a></td>
					</tr>

					<tr>
					    <td><?php echo '4.'; ?></td>
					    <td>Forgot Password</td>
					    <td><a href="<?php echo BASE_URL . 'webadmin/dashboard/forgot_password/'; ?>"><button class="btn btn-success" type="button">Forgot Password</button></a></td>
					</tr>

					<tr>
					    <td><?php echo '5.'; ?></td>
					    <td>Student Signup</td>
					    <td><a href="<?php echo BASE_URL . 'webadmin/dashboard/student_signup/'; ?>"><button class="btn btn-success" type="button">Student Sign-up</button></a></td>
					</tr>

					<tr>
					    <td><?php echo '6.'; ?></td>
					    <td>Teacher Signup</td>
					    <td><a href="<?php echo BASE_URL . 'webadmin/dashboard/teacher_signup/'; ?>"><button class="btn btn-success" type="button">Teacher Sign-up</button></a></td>
					</tr>

					<tr>
					    <td><?php echo '7.'; ?></td>
					    <td>Second Last Email</td>
					    <td><a href="<?php echo BASE_URL . 'webadmin/dashboard/second_last/'; ?>"><button class="btn btn-success" type="button">Second Last Email</button></a></td>
					</tr>

					<tr>
					    <td><?php echo '8.'; ?></td>
					    <td>Last Email</td>
					    <td><a href="<?php echo BASE_URL . 'webadmin/dashboard/last/'; ?>"><button class="btn btn-success" type="button">Last Email</button></a></td>
					</tr>


					<tr>
					    <td><?php echo '9.'; ?></td>
					    <td>Teacher Paid</td>
					    <td><a href="<?php echo BASE_URL . 'webadmin/dashboard/teacher_paid/'; ?>"><button class="btn btn-success" type="button">Teacher Paid</button></a></td>
					</tr>
					
					<tr>
					    <td><?php echo '10.'; ?></td>
					    <td>Message</td>
					    <td><a href="<?php echo BASE_URL . 'webadmin/dashboard/message/'; ?>"><button class="btn btn-success" type="button">Message</button></a></td>
					</tr>

				    </tbody>
				    <tfoot>
					<tr>
					    <th>Sr.No.</th>
					    <th>Title</th>
					    <th>Send</th>
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