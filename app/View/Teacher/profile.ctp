<div class="new_ryt padding-right">
    <div class="right_side profile clearfix">
        <div class="col-md-12">
            <h2> Basic Information </h2>
        </div>
        <div class="clearfix"> </div>

        <!--profile_form start -->
        <div class="profile_form">
	    <?php echo $this->Session->flash(); ?>
	    <?php echo $this->Form->create('User', array('url' => array('controller' => 'teacher', 'action' => 'profile'), 'class' => 'clearfix', 'enctype' => 'multipart/form-data')); ?>   

            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="exampleInputEmail1">First Name<span> *</span></label>
			    <?php echo $this->Form->input('first_name', array('label' => FALSE, 'class' => 'form-control', 'placeholder' => 'First Name', 'required' => FALSE, 'id' => 'exampleInputEmail1', 'value' => $teacher_basic['User']['first_name'])); ?>
                        </div>
                    </div>
                    <div class="col-md-5 col-md-offset-1">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Last Name <span> *</span></label>
			    <?php echo $this->Form->input('last_name', array('label' => FALSE, 'class' => 'form-control', 'placeholder' => 'Last Name', 'required' => false, 'value' => $teacher_basic['User']['last_name'])); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Primary Phone Number<span> *</span></label>
			    <?php echo $this->Form->input('primary_phone', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Primary Phone Number', 'value' => $teacher_basic['User']['primary_phone'])); ?>
                        </div>
                    </div>
                    <div class="col-md-5 col-md-offset-1">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Secondary Phone Number</label>
			    <?php echo $this->Form->input('secondary_phone', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Secondary Phone Number', 'value' => $teacher_basic['User']['secondary_phone'])); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email<span> *</span></label>
			    <?php echo $this->Form->input('email', array('label' => false, 'class' => 'emailBackground form-control', 'placeholder' => 'example@gmail.com', 'value' => $teacher_basic['User']['email'])); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Address<span> *</span></label>
			    <?php echo $this->Form->input('address', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Address', 'value' => $teacher_basic['User']['address'])); ?>
                        </div>
                    </div>
                    <div class="col-md-5 col-md-offset-1">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Apartment/Suite#</label>
			    <?php echo $this->Form->input('suite', array('label' => false, 'class' => 'form-control', 'placeholder' => 'Apartment/Suite#', 'value' => $teacher_basic['User']['suite'])); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="exampleInputEmail1">City<span> *</span></label>
			    <?php echo $this->Form->input('city', array('label' => FALSE, 'class' => 'form-control', 'placeholder' => 'City', 'required' => False, 'value' => $teacher_basic['User']['city'])); ?>
                        </div>
                    </div>
                    <div class="col-md-5 col-md-offset-1">
                        <div class="form-group">
                            <label for="exampleInputEmail1">State<span> *</span></label>
			    <?php echo $this->Form->input('state', array('label' => FALSE, 'class' => 'form-control', 'placeholder' => 'State', 'value' => $teacher_basic['User']['state'])); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Zip Code<span> *</span></label>
			    <?php echo $this->Form->input('zip_code', array('label' => FALSE, 'class' => 'form-control', 'placeholder' => 'Zip Code', 'value' => $teacher_basic['User']['zip_code'])); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <button class="btn btn-default loginbtn" type="submit">Update</button>
            </div>
	    <?php echo $this->Form->end(); ?>
            <div class="col-md-12">
                <hr>
            </div>
            <div class="col-md-12">
                <h2> Profile Information </h2>
            </div>
	    <?php echo $this->Form->create('Teacher_information', array('url' => array('controller' => 'teacher', 'action' => 'profile'), 'class' => 'clearfix', 'enctype' => 'multipart/form-data')); ?>   

            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="exampleInputEmail1">First Name<span> *</span></label>
			    <?php echo $this->Form->input('first_name', array('label' => FALSE, 'placeholder' => 'First Name', 'class' => 'form-control', 'value' => @$teacher_profile['Teacher_information']['first_name'])); ?>
                        </div>
                    </div>
                    <div class="col-md-5 col-md-offset-1">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Last Name <span> *</span></label>
			    <?php echo $this->Form->input('last_name', array('label' => FALSE, 'class' => 'form-control', 'placeholder' => 'Last Name', 'value' => @$teacher_profile['Teacher_information']['last_name'])); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Age Range Taught</label>
                            <div class="select-style">
				<?php
				$age = array('5+' => '5+', '6+' => '6+', '7+' => '7+', '8+' => '8+', '9+' => '9+', '10+' => '10+');
				echo $this->Form->input('age_range_taught', array('label' => FALSE, 'type' => 'select', 'empty' => '--Select age--', 'options' => $age, 'value' => @$teacher_profile['Teacher_information']['age_range_taught']));
				?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Areas You Can Teach<span> *</span></label>
			    <?php echo $this->Form->input('areas_taught', array('label' => FALSE, 'class' => 'form-control', 'placeholder' => 'Areas you can Teach', 'value' => @$teacher_profile['Teacher_information']['areas_taught'])); ?>
                        </div>
                    </div>


                    <div class="col-md-5 col-md-offset-1">
                        <div class="form-group">
                            <label for="exampleInputEmail1" style="width:100%">Experience<span> *</span></label>
			    <?php
			    if (!empty($teacher_profile['Teacher_information']['experience'])) {
				$exp = explode(' ', $teacher_profile['Teacher_information']['experience']);
			    }
			    ?>
                            <div style="float:left; width:47%;">
				<?php
				echo $this->Form->input('exp', array('label' => FALSE, 'placeholder' => 'Experience', 'value' => @$exp[0], 'class' => 'form-control'));
				?>
                            </div>
                            <div class="select-style" style="float:right; width:47%; height: 32px;">
                                <select name="data[Teacher_information][exp_type]" class="form-control">
                                    <option value="">-Select-</option>
                                    <option value="Months" <?php
				    if ($exp[1] == 'Months') {
					echo 'selected';
				    }
				    ?>>Months</option>
                                    <option value="Years" <?php
				    if ($exp[1] == 'Years') {
					echo 'selected';
				    }
				    ?>>Years</option>
                                </select>
                            </div>
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
			    if (!empty($teacher_profile['Teacher_information']['image'])) {
				?>
    			    <img src="<?php echo $this->webroot . 'img/teacher_images/' . @$teacher_profile['Teacher_information']['image']; ?>" class="img-responsive"/>
			    <?php } ?>
                            <div class="photos2">
                                <div class="fileUpload1 btn btn-primary"> <b class="photos111"><i> Upload Photo </i> </b>
                                    <input type="file" class="upload" name='data[Teacher_information][image]'>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-11">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Biography Written in Third Person<span> *</span></label>
			    <?php echo $this->Form->input('biography', array('label' => FALSE, 'placeholder' => 'Biography', 'type' => 'textarea', 'rows' => '7', 'class' => 'form-control', 'value' => strip_tags(html_entity_decode(@$teacher_profile['Teacher_information']['biography'], ENT_QUOTES)))); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <button class="btn btn-default loginbtn" type="submit">Update</button>
            </div>
	    <?php echo $this->Form->end(); ?>
        </div>
        <!--profile_form closed --> 

    </div>
</div>
</div>
</div>
<style>
    .emailBackground{
        background-color: #fff !important; 
    }
</style>