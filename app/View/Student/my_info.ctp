
<div class="new_ryt padding-right">
 
    <div class="right_side profile clearfix">
        <div class="col-md-12">
            <h2> Basic Information </h2>
        </div>
        <div class="clearfix"> </div>
        <!--profile_form start -->
        <div class="profile_form">
            <?php echo $this->Session->Flash(); ?>
            <?php echo $this->Form->create('User', array('url' => array('controller' => 'student', 'action' => 'my_info'), 'class' => 'clearfix', 'enctype' => 'multipart/form-data')); ?>   

            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="exampleInputEmail1">First Name<span> *</span></label>
                            <?php echo $this->Form->input('first_name', array('label' => FALSE, 'placeholder' => 'First Name', 'class' => 'form-control', 'value' => @$student['User']['first_name'])); ?>
                        </div>
                    </div>
                    <div class="col-md-5 col-md-offset-1">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Last Name <span> *</span></label>
                            <?php echo $this->Form->input('last_name', array('label' => FALSE, 'class' => 'form-control', 'placeholder' => 'Last Name', 'value' => @$student['User']['last_name'])); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Student's First Name<span> *</span></label>
                            <?php echo $this->Form->input('student_firstname', array('label' => FALSE, 'placeholder' => 'Student First Name', 'class' => 'form-control', 'value' => @$student['User']['student_firstname'])); ?>
                        </div>
                    </div>
                    <div class="col-md-5 col-md-offset-1">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Student's Last Name <span> *</span></label>
                            <?php echo $this->Form->input('student_lastname', array('label' => FALSE, 'class' => 'form-control', 'placeholder' => 'Student Last Name', 'value' => @$student['User']['student_lastname'])); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Student's Age<span> *</span></label>
                            <?php echo $this->Form->input('student_age', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Student Age', 'value' => @$student['User']['student_age'])); ?>
                        </div>
                    </div>

                    <div class="col-md-5 col-md-offset-1">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Subject<span> *</span></label>
                            <?php
                            if (!empty($all_subjects)) {
                                foreach ($all_subjects as $subjects) {
                                    $sub[$subjects['Subject']['subject']] = $subjects['Subject']['subject'];
                                }
                            }
                            echo $this->Form->input('subject', array('label' => false, 'class' => 'form-control', 'type' => 'select', 'empty' => '-Select-','options'=>@$sub,'value'=>$student['User']['subject']));
                            ?>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Add Additional Student</label>
                            <div class="crossBtn">
                                <input type="button" class="fileUpload1 btn btn-default" value="+" id="addAdditional" style="color:#fff;border-color: #2dc4c4;background-color: #2dc4c4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if (!empty($this->request->data['Child_user'])) {
                for ($i = 0; $i < count($this->request->data['Child_user']['firstname']); $i++) {
                    ?>
                    <div class="mainStart">
                        <div style=" margin-right: 9%;text-align: center;"><h4>Additional Student Information</h4></div>
                        <input type="button" class="fileUpload1 btn btn-success" value="-" id="hideAdditional" style="float:right;margin-right: 30px; ">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Student's First Name<span> *</span></label>
                                        <input type="text" name="data[Child_user][firstname][]" placeholder="Students First Name" class="form-control" value="<?php echo $this->request->data['Child_user']['firstname'][$i]; ?>">
                                    </div>
                                </div>
                                <div class="col-md-5 col-md-offset-1">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Student's Last Name<span> *</span></label>
                                        <input type="text" class="form-control" name="data[Child_user][lastname][]" placeholder="Students Last Name" value="<?php echo $this->request->data['Child_user']['lastname'][$i]; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Student's Age<span> *</span></label>
                                        <input type="text" name="data[Child_user][age][]" placeholder="Students Age" class="form-control" value="<?php echo $this->request->data['Child_user']['age'][$i]; ?>">
                                    </div>
                                </div>
                                <div class="col-md-5 col-md-offset-1"><div class="form-group">
                                        <label for="exampleInputEmail1">Subject<span> *</span></label>
                                        <select name="data[Child_user][subject][]" class="form-control">
                                            <option value="">-Select-</option><?php
                                            if (!empty($all_subjects)) {
                                                foreach ($all_subjects as $subject) {
                                                    ?>
                                                    <option value="<?php echo $subject['Subject']['subject']; ?>" <?php
                                                    if ($subject['Subject']['subject'] == $this->request->data['Child_user']['subject'][$i]) {
                                                        echo 'selected';
                                                    }
                                                    ?>><?php echo $subject['Subject']['subject']; ?></option><?php
                                                        }
                                                    }
                                                    ?></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>

            <?php
            if (!empty($additional)) {

                foreach ($additional as $additinl_clients) {
                    ?>
                    <div class="mainStart">
                        <div style=" margin-right: 9%;text-align: center;"><h4>Additional Student Information</h4></div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Student's First Name<span> *</span></label>
                                        <input type="text" name="data[Child_user][firstname][]" placeholder="Students First Name" class="form-control" value="<?php echo $additinl_clients['Child_user']['firstname']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-5 col-md-offset-1">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Student's Last Name<span> *</span></label>
                                        <input type="text" class="form-control" name="data[Child_user][lastname][]" placeholder="Students Last Name" value="<?php echo $additinl_clients['Child_user']['lastname']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="crossBtn">
                            <input class="btn btn-default" style="float:right;margin-right: 30px;border-radius: 29px;" value="x" type="button" id="removeAdditionl" child_id="<?php echo $additinl_clients['Child_user']['id']; ?>">
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Student's Age<span> *</span></label>
                                        <input type="text" name="data[Child_user][age][]" placeholder="Students Age" class="form-control" value="<?php echo $additinl_clients['Child_user']['age']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-5 col-md-offset-1"><div class="form-group">
                                        <label for="exampleInputEmail1">Subject<span> *</span></label>
                                        <select name="data[Child_user][subject][]" class="form-control">
                                            <option value="">-Select-</option><?php
                                            if (!empty($all_subjects)) {
                                                foreach ($all_subjects as $subject) {
                                                    ?>
                                                    <option value="<?php echo $subject['Subject']['subject']; ?>" <?php
                                                    if ($subject['Subject']['subject'] == $additinl_clients['Child_user']['subject']) {
                                                        echo 'selected';
                                                    }
                                                    ?>><?php echo $subject['Subject']['subject']; ?></option><?php
                                                        }
                                                    }
                                                    ?></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
            }
            ?>
            <div class="appendAdditional"></div>

            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Primary Phone Number<span> *</span></label>
<?php echo $this->Form->input('primary_phone', array('label' => FALSE, 'class' => 'form-control', 'placeholder' => 'Primary Phone Number', 'value' => @$student['User']['primary_phone'])); ?>
                        </div>
                    </div>
                    <div class="col-md-5 col-md-offset-1">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Secondary Phone Number</label>
<?php echo $this->Form->input('secondary_phone', array('label' => FALSE, 'class' => 'form-control', 'placeholder' => 'Secondary Phone Number', 'value' => @$student['User']['secondary_phone'])); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email<span> *</span></label>
<?php echo $this->Form->input('email', array('label' => false, 'class' => 'emailBackground form-control', 'value' => @$student['User']['email'])); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Address<span> *</span></label>
<?php echo $this->Form->input('address', array('label' => FALSE, 'class' => 'form-control', 'placeholder' => 'Address', 'value' => @$student['User']['address'])); ?>
                        </div>
                    </div>
                    <div class="col-md-5 col-md-offset-1">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Suite/Apt.#</label>
<?php echo $this->Form->input('suite', array('label' => FALSE, 'class' => 'form-control', 'placeholder' => 'Suite/Apt.#', 'value' => @$student['User']['suite'])); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="exampleInputEmail1">City<span> *</span></label>
<?php echo $this->Form->input('city', array('label' => FALSE, 'class' => 'form-control', 'placeholder' => 'City', 'value' => @$student['User']['city'])); ?>
                        </div>
                    </div>
                    <div class="col-md-5 col-md-offset-1">
                        <div class="form-group">
                            <label for="exampleInputEmail1">State<span> *</span></label>
<?php echo $this->Form->input('state', array('label' => FALSE, 'class' => 'form-control', 'placeholder' => 'State', 'value' => @$student['User']['state'])); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Zip Code<span> *</span></label>
<?php echo $this->Form->input('zip_code', array('label' => FALSE, 'class' => 'form-control', 'placeholder' => 'Zip Code', 'value' => @$student['User']['zip_code'])); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5 uploadPic">
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="widthfull">Upload Photo<span> *</span></label>
                            <?php
                            if (!empty($student['User']['image'])) {
                                ?>
                                <img src="<?php echo $this->webroot . 'img/student_images/' . @$student['User']['image']; ?>" class="img-responsive"/>
<?php } ?>
                            <div class="photos2">
                                <div class="fileUpload1 btn btn-primary"> <b class="photos111"><i> Upload Photo </i> </b>
                                    <input type="file" class="upload" name='data[User][image]'>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <button class="btn btn-default loginbtn" type="submit">Update</button>
            </div>
<?php echo $this->Form->end(); ?>

            <!--profile_form closed --> 
        </div>
    </div>

</div>
</div>
<!--dashboard closed --> 
<style>
    .alert-success{
        background-color: #42acd1;
        color: #fff; 
    }
    .emailBackground{
        background-color: #fff !important; 
    }
</style>