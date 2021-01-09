<style>
    .mini-stat-icon {
        background: #eee none repeat scroll 0 0;
        border-radius: 100%;
        color: #fff;
        display: inline-block;
        float: left;
        font-size: 30px;
        height: 60px;
        line-height: 60px;
        margin-right: 10px;
        text-align: center;
        width: 60px;
    }
    .orange {
        background: #fa8564 none repeat scroll 0 0 !important;
    }
    .mini-stat {
        background: #fff none repeat scroll 0 0;
        border-radius: 3px;
        margin-bottom: 20px;
        padding: 20px;
        border:4px solid #eee;
    }
    .mini-stat-info {
        font-size: 12px;
        padding-top: 2px;
    }
    .mini-stat-info span {
        display: block;
        font-size: 24px;
        font-weight: 600;
    }
    .mini-stat .green {
        background: #aec785 none repeat scroll 0 0 !important;
    }

    .mini-stat  .purple {
        background: #a48ad4 none repeat scroll 0 0 !important;
    }
    .mini-stat  .yellow {
        background: yellow none repeat scroll 0 0 !important;
    }
    .mini-stat  .tar {
        background: #1fb5ac none repeat scroll 0 0 !important;
    }
    .right_side a{
        color:#000;
    }


</style>

<div class="new_ryt padding-right">
  
	<div class="right_side clearfix">
	    <?php echo $this->Session->Flash(); ?>
	    <div class="col-md-12">
		<div class="new_ryt_dashboard">

		    <div class="col-md-4 col-sm-4 text-center">
			<a href="<?php echo BASE_URL . 'teacher/' ?>">
			    <div class="mini-stat clearfix">
				<div class=" mini-stat-icon orange">
				    <i class="fa fa-dashboard"></i>
				</div>
				<div class="mini-stat-info ">
				    <span>Dashboard</span>
				</div>
			    </div>
			</a>
		    </div>

		    <div class="col-md-4 col-sm-4 text-center">
			<a href="<?php echo BASE_URL . 'teacher/profile/' ?>">
			    <div class="mini-stat clearfix">
				<div class=" mini-stat-icon purple">
				    <i class="fa fa-user"></i>
				</div>
				<div class="mini-stat-info ">
				    <span>Profile</span>
				</div>
			    </div>
			</a>
		    </div>

		    <div class="col-md-4 col-sm-4 text-center">
			<a href="<?php echo BASE_URL . 'teacher/messages/' ?>">
			    <div class="mini-stat clearfix">
				<div class=" mini-stat-icon green">
				    <i class="fa fa-envelope"></i>
				</div>
				<div class="mini-stat-info ">
				    <span>Messages</span>
				</div>
			    </div>
			</a>
		    </div>

		    <div class="col-md-4 col-sm-4 text-center">
			<a href="<?php echo BASE_URL . 'teacher/payment_detail/' ?>">
			    <div class="mini-stat clearfix">
				<div class=" mini-stat-icon purple">
				    <i class="fa fa-list"></i>
				</div>
				<div class="mini-stat-info ">
				    <span>Lesson </span>
				    <h4> History</h4>
				</div>
			    </div>
			</a>
		    </div>

		    <div class="col-md-4 col-sm-4 text-center">
			<a href="<?php echo BASE_URL . 'teacher/calendar/' ?>">
			    <div class="mini-stat clearfix">
				<div class=" mini-stat-icon green">
				    <i class="fa fa-clock-o"></i>
				</div>
				<div class="mini-stat-info ">
				    <span>Schedule </span>
				    <h4>Lesson</h4>
				</div>
			    </div>
			</a>
		    </div>

		    <div class="col-md-4 col-sm-4 text-center">
			<a href="<?php echo BASE_URL . 'teacher/my_students/' ?>">
			    <div class="mini-stat clearfix">
				<div class=" mini-stat-icon tar">
				    <i class="fa fa-mortar-board"></i>
				</div>
				<div class="mini-stat-info ">
				    <span>My Student's</span>

				</div>
			    </div>
			</a>
		    </div>

		    <div class="next_schedule">
			<h1>Next Scheduled Lesson</h1>
			<div class="row">
			    <div class="col-xs-3"><span>Name</span></div>
			    <div class="col-xs-9"><p><?php
				    if (!empty($get_data) && isset($get_data)) {
					echo ucfirst($get_data['User']['first_name']) . ' ' . ucfirst($get_data['User']['last_name']);
				    } else {
					echo "-";
				    }
				    ?></p>
			    </div>
			</div>

			<div class="row">
			    <div class="col-xs-3"><span>Subject</span></div>
			    <div class="col-xs-9"><p><?php
				    if (!empty($get_data) && isset($get_data)) {
					echo ucfirst($get_data['Calendar']['subject_name']);
				    } else {
					echo "-";
				    }
				    ?></p></div>
			</div>

			<div class="row">
			    <div class="col-xs-3"><span>Date</span></div>
			    <div class="col-xs-9"><p><?php
				    if (!empty($get_data) && isset($get_data)) {
					echo date('m/d/Y', strtotime($get_data['Calendar']['start_date']));
				    } else {
					echo '-';
				    }
				    ?></p></div>
			</div>

			<div class="row">
			    <div class="col-xs-3"><span>Time</span></div>
			    <div class="col-xs-9"><p><?php
				    if (!empty($get_data) && isset($get_data)) {
					echo date('g:i a', strtotime($get_data['Calendar']['changed_start']));
				    } else {
					echo '-';
				    }
				    ?></p></div>
			</div>

			<div class="row">
			    <div class="col-xs-3"><span>Address</span></div>
			    <div class="col-xs-9"><p><?php
				    if (!empty($get_data) && isset($get_data)) {
					$exploded_address = explode(',', $get_data['User']['address']);
					if (!empty($get_data['User']['suite'])) {
					    echo $exploded_address[0] . ' Apt./Ste. ' . $get_data['User']['suite'] . ', ' . $exploded_address[1] . ', ' . $exploded_address[2] . ' ' . $get_data['User']['zip_code'];
					} else {
					    echo $exploded_address[0] . ', ' . $exploded_address[1] . ', ' . $exploded_address[2] . ' ' . $get_data['User']['zip_code'];
					}
				    } else {
					echo "-";
				    }
				    ?></p></div>
			</div>
		    </div>
		</div>
	    </div>
	    <div class="clearfix"> </div>

	</div>
    
</div>
</div>
</div>
<!--dashboard closed --> 