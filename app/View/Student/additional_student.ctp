<div class="right_side purchase clearfix">
    <div class="col-md-12">
        <div class="col-md-6">
            <h1> Additional Students </h1>
        </div>
        <div class="col-md-6">
            <button class="btn btn-success" type="button" style="float: right;margin-right: 10px;margin-top: 20px;background: #42acd1;border-color: #42acd1;" id='addStudent'>+</button>
        </div>
    </div>
    <div class="clearfix"> </div>
    <div class="col-md-12">  

        <div class="table-responsive my_students">
            <?php echo $this->Session->flash(); ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sr.no</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Age</th>
                        <th>Subject</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($students)) {
                        $i = 1;
                        foreach ($students as $student) {
                            ?>
                            <tr>
                                <td><?php echo $i . '.'; ?></td>
                                <td><?php echo ucfirst($student['Child_user']['firstname']); ?></td>
                                <td><?php echo ucfirst($student['Child_user']['lastname']); ?></td>
                                <td><?php echo $student['Child_user']['age']; ?></td>
                                <td><?php echo $student['Child_user']['subject']; ?></td>
                                <td>
                                    <a href="javascript:;" studeID='<?php echo $student['Child_user']['id']; ?>' id='EditAdditionl'><i class="fa fa-edit"></i></a>

                                    <a href="<?php echo BASE_URL . 'student/delete_additional/' . $student['Child_user']['id']; ?>" ><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                    } else {
                        echo '<td colspan="11">No Additional Student.</td>';
                    }
                    ?>



                </tbody>
            </table>
        </div>


    </div>
</div>