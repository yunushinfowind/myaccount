<div class="new_ryt padding-right">
    <div class="right_side clearfix">
        <div class="student">
            <div class="col-md-12">
                <h1> My Student's Details</h1>

                <div class="student_details">
                    <div class="col-md-4 col-sm-4">
                        <span>Subject</span>
                    </div>

                    <div class="col-md-8 col-sm-8">
                        <p class="student_subject"><?php
                            if (!empty($get_data)) {
                                echo $get_data['Calendar']['subject_name'];
                            } else {
                                echo '-';
                            }
                            ?></p>
                    </div>
                </div>


                <div class="student_details">
                    <div class="col-md-4 col-sm-4">
                        <span>Schedule Date & Time</span>

                    </div>

                    <div class="col-md-8 col-sm-8">
                        <p class="student_schedule"><?php
                            if (!empty($get_data)) {
                                echo date('m/d/Y h:i a', strtotime($get_data['Calendar']['start_date'] . ' ' . $get_data['Calendar']['time']));
                            } else {
                                echo '-';
                            }
                            ?></p>

                    </div>
                </div>



                <div class="student_details">
                    <div class="col-md-4 col-sm-4">
                        <span>Student Address</span>
                    </div>

                    <div class="col-md-8 col-sm-8" >
                        <p class="student_address"><?php
                            if (!empty($get_data)) {
                                $address = explode(',', $get_data['User']['address']);
                                if (!empty($get_data['User']['suite'])) {
                                    echo ucfirst($get_data['User']['first_name']) . ' ' . ucfirst($get_data['User']['last_name']) . '<br>' . $address[0] . ' Apt. ' . $get_data['User']['suite'] . ' ' . $address[1] . ', ' . $address[2] . ' ' . $get_data['User']['zip_code'] . '<br>' . $get_data['User']['primary_phone'];
                                } else {
                                    echo ucfirst($get_data['User']['first_name']) . ' ' . ucfirst($get_data['User']['last_name']) . '<br>' . $address[0] . ' ' . $address[1] . ', ' . $address[2] . ' ' . $get_data['User']['zip_code'] . '<br>' . $get_data['User']['primary_phone'];
                                }
                            } elseif (!empty($getData)) {
                                $address = explode(',', $getData['User']['address']);
                                if (!empty($getData['User']['suite'])) {
                                    echo ucfirst($getData['User']['first_name']) . ' ' . ucfirst($getData['User']['last_name']) . '<br>' . $address[0] . ' Apt. ' . $getData['User']['suite'] . ' ' . $address[1] . ', ' . $address[2] . ' ' . $getData['User']['zip_code'] . '<br>' . $getData['User']['primary_phone'];
                                } else {
                                    echo ucfirst($getData['User']['first_name']) . ' ' . ucfirst($getData['User']['last_name']) . '<br>' . $address[0] . ' ' . $address[1] . ', ' . $address[2] . ' ' . $getData['User']['zip_code'] . '<br>' . $getData['User']['primary_phone'];
                                }
                            } else {
                                echo '-';
                            }
                            ?>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12">
            <div class="button">
                <button type="submit" class="btn btn-default loginbtn" id="close_2_me">Closest Student to My House</button>
                <button type="submit" class="btn btn-default loginbtn" id="closest_student">Closest Student Nearby</button>



            </div>
        </div>

        <div class="col-md-12">
            <div class="map">
                <div class="col-md-4 col-sm-4">
                    <span>View Route on Map</span>

                </div>

                <!--<div id="map-canvas"></div>-->
                <iframe width="600" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/directions?key=AIzaSyAvb0UZPOMyOGXg9WV5x7fzEuo0AlB1dQA&origin=<?php echo $teacher_info['User']['address']; ?>&destination=<?php
                if (!empty($get_data)) {
                    echo $get_data['User']['address'];
                } elseif (!empty($getData)) {
                    echo $getData['User']['address'];
                };
                ?>"></iframe>
                <div class="col-md-8 col-sm-8">
                </div>
            </div>
            <input type ="hidden" class="teacher_address" value="<?php echo $teacher_info['User']['address']; ?>">
            <input type ="hidden" class="teacher_id" value="<?php echo $teacher_id; ?>">
            <input type ="hidden" class="student_id" value="<?php echo $this->params['pass'][0]; ?>">
            <input type="hidden" class="stu_lat" value="<?php echo $student_info['User']['latitude']; ?>">
            <input type="hidden" class="stu_lng" value="<?php echo $student_info['User']['longitude']; ?>">

        </div>

        <div class="clearfix"> </div>

    </div>
</div>
</div>
</div>

<!--dashboard closed -->
<div class="clearfix"></div>
<style>
    #map-canvas {
        height:331px;
        float: left;
        width: 598px;
    }

</style>