<div class="new_ryt padding-right">
    <div class="right_side tchrs_studnt clearfix">
        <div class="col-md-12">
            <h1> My Students </h1>
        </div>
        <div class="clearfix"> </div>
        <div class="col-md-12">
            <div class="table-responsive my_students">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sr.No.</th>
                            <th>Name</th>
                            <th>Student(s) Name</th>
                            <th>Age</th>
                            <th>Subject(s)</th>
                            <th>Address</th>
                            <th>Primary Phone no.</th>
                            <th>Secondary Phone No.</th>
                            <th>Email</th>
                            <th>Schedule Now</th>
                            <th>Plan My Route</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($students)) {
                            $i = 1;

                            foreach ($students as $student) {
                                if (!empty($student['User'])) {
                                    $address = explode(',', $student['User']['address']);
                                    ?>
                                    <tr>
                                        <td><?php echo $i . '.'; ?></td>
                                        <td><?php echo ucfirst($student['User']['first_name']) . ' ' . ucfirst($student['User']['last_name']); ?></td>
                                        <td><?php
                                            echo ucfirst($student['User']['student_firstname']) . ' ' . ucfirst($student['User']['student_lastname']);
                                            if (!empty($student['Child_user'])) {
                                                foreach ($student['Child_user'] as $child_user) {
                                                    echo ',<br>' . ucfirst($child_user['firstname']) . ' ' . ucfirst($child_user['lastname']);
                                                }
                                            }
                                            ?></td>
                                        <td><?php
                                            echo $student['User']['student_age'];
                                            if (!empty($student['Child_user'])) {
                                                foreach ($student['Child_user'] as $child_user) {
                                                    echo ',<br>' . $child_user['age'];
                                                }
                                            }
                                            ?></td>
                                        <td><?php
                                            echo $student['Subject']['subject'];

                                            if (!empty($student['Child_user'])) {
                                                foreach ($student['Child_user'] as $child_user) {
                                                    echo ',<br>' . $child_user['subject'];
                                                }
                                            }
                                            ?></td>
                                        <td><?php
                                            if(count($address) < 3) {
                                                $address[1] = $student['User']['city'];
                                                $address[2] = $student['User']['state'];
                                            }
                                            if (!empty($student['User']['suite'])) {
                                                echo $address[0] . ' Apt./Ste. ' . $student['User']['suite'] . ' ' . $address[1] . ', ' . $address[2] . ' ' . $student['User']['zip_code'];
                                            } else {
                                                echo $address[0] . ' ' . $address[1] . ', ' . $address[2] . ' ' . $student['User']['zip_code'];
                                            }
                                            ?></td>
                                        <td><?php echo $student['User']['primary_phone']; ?></td>
                                        <td><?php if (!empty($student['User']['secondary_phone'])) {
                                                echo $student['User']['secondary_phone'];
                                            } else {
                                                echo '-';
                                            } ?></td>
                                        <td><?php echo $student['User']['email']; ?></td>
                                        <td style="text-align: center;"><a class="button_s" href="<?php echo BASE_URL . 'teacher/calendar/'; ?>"> Schedule </a></td>
                                        <td><a href="<?php echo BASE_URL . 'teacher/student_details/' . $student['User']['id']; ?>"><i class="fa fa-road"></i></a></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                        } else {
                            echo '<tr><td colspan="11">' . "No Students." . '</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <nav class="pull-right pagi">
                <ul class="pagination">
                    <li> <a href="#" aria-label="Previous"> <span aria-hidden="true">&laquo;</span> </a> </li>
                    <!--                                    <li class="active"><a href="#">1</a></li>
                                                        <li><a href="#">2</a></li>
                                                        <li><a href="#">3</a></li>
                                                        <li><a href="#">4</a></li>
                                                        <li><a href="#">5</a></li>-->
                    <li> <a href="#" aria-label="Next"> <span aria-hidden="true">&raquo;</span> </a> </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
</div>
</div>

<!--dashboard closed -->