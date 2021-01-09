
<div class="new_ryt padding-right">
    <div class="right_side tchr_pymt_dtlc clearfix">
        <div class="col-md-12">
            <h1> Filter Lessons </h1>
        </div>

        <div class="col-md-12">

            <div class="col-md-12 filterSearch">
		
		    <div class="filterSearch_inner">
			 
		    <div class="col-sm-6 col-md-3">
			<div class="form-group">
			    <label for="usr">Start Date:</label>
			    <input type="text" class="form-control" id="filterStart">
			</div>
		    </div>
			 
		    <div class="col-sm-6 col-md-3">
			<div class="form-group">
			    <label for="pwd">End Date:</label>
			    <input type="text" class="form-control" id="filterEnd">
			</div>
		    </div>
			 
		    <div class="col-sm-12 col-md-4">
			<div class="form-group">

			    <button type="button" id="filterData" class="btn btn-primary loginbtn" >Filter</button>
			</div>
		    </div>
		</div>
		</div>
          


        </div>

        <div class="clearfix"></div>

        <div class="col-md-12">
            <h1> Lesson History  </h1>
        </div>
        <div id="appendLesson">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sr.no.</th>
                                <th>Client</th>
                                <th>Subject</th>
                                <th>Address</th>
                                <th>Duration</th>
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
			    <?php
			    $i = 1;
			    if (!empty($completd)) {

				foreach ($completd as $complete) {

				    $time = $complete['Calendar']['schedule_time'];
				    $hourly_rate = $complete['hourly_rate'];
				    $amount = ($hourly_rate / 60) * $time;
				    ?>
				    <tr>
					<td><?php echo $i; ?></td>
					<td><?php echo ucfirst($complete['User']['first_name']) . ' ' . ucfirst($complete['User']['last_name']); ?></td>
					<td><?php echo $complete['Calendar']['subject_name']; ?></td>
					<td><?php
					    if (!empty($complete['User']['address'])) {
						$exploded_address = explode(',', $complete['User']['address']);

						if (!empty($complete['User']['suite'])) {
						    echo $exploded_address[0] . ' Apt./Ste. ' . $complete['User']['suite'] . ', ' . $exploded_address[1] . ', ' . $exploded_address[2] . ' ' . $complete['User']['zip_code'];
						} else {
						    echo $exploded_address[0] . ', ' . $exploded_address[1] . ', ' . $exploded_address[2] . ' ' . $complete['User']['zip_code'];
						}
					    } else {
						echo '-';
					    }
					    ?></td>
					<td><?php echo $complete['converted_time']; ?></td>
					<td><?php echo date('m/d/Y', strtotime($complete['Calendar']['start_date'])); ?></td>
					<td><?php echo $complete['Calendar']['changed_start']; ?></td>
					<td><?php echo $complete['Calendar']['changed_end']; ?></td>
					<td><?php
					    echo '$' . number_format($amount, 2);
					    ?></td>
				    </tr>
				    <?php
				    $i++;
				}
			    } else {
				echo '<tr><td colspan="9">' . 'No lessons.' . '</td></tr>';
			    }
			    ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-12 detail" >
                <p> Total Lessons Taught : <?php
		    if (!empty($total_earned)) {
			echo $total_earned;
		    } else {
			echo '-';
		    }
		    ?> </p>
                <p>Total Amount Earned: <?php
		    if (!empty($amount_earned)) {
			echo '$ ' . $amount_earned;
		    } else {
			echo "-";
		    }
		    ?></p>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!--dashboard closed -->
<div class="clearfix"> </div>
<style>
    .filterSearch{
        background: none repeat scroll 0 0 #eee;
        padding: 7px 0;
    }

    .filterSearch .form-group
    {
        margin-bottom: 0;
    }
    #filterData{
        border-radius: 4px;
        margin-top: 26px;
    }

    #filterData:focus{
        background-color: #da5d31;
    }
</style>
