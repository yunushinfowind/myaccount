<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <span class="fa fa-calendar"></span>
                Calendar
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                    <a href="javascript:;" class="fa fa-cog"></a>
                    <a href="javascript:;" class="fa fa-times"></a>
                </span>
            </header>
            <div class="panel-body">
                <!-- page start-->
                <div class="row">
		    <input type="hidden" class="viewHidden" value="month">
		    <div class="col-md-6"></div>
		    <div class="col-md-6">

			<h5 class="admin_completehours"> 
			    <span class="admin_cal"> Completed Lessons : </span>&nbsp;

			    <span id="admin_time"  class="admin_show">
				<?php
				if (empty($teacher_earnings['Teacher_earning']['hour']) && !empty($teacher_earnings['Teacher_earning']['minute'])) {
				    echo '-';
				}
				?>
			    </span>
			    </h5>
			<h5 class="admin_completehours"> 
			    <span class="admin_cal">Amount Earned : </span> &nbsp; 
			    <span id="admin_amount" class="admin_show">
				<?php
				if (empty($teacher_earnings['Teacher_earning']['total_earning'])) {
				    echo '-';
				}
				?>
			    </span>
			</h5>

		    </div>
                    <aside class="col-lg-12">
			<input type="hidden" id="SessUser" value="<?php echo $this->params['pass'][0]; ?>">
                        <div id="calendar" class="has-toolbar">

			</div>
                    </aside>
                </div>
                <!-- page end-->
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->

<style>
    .fc-toolbar{
        margin-bottom: 5em !important;
    }
</style>