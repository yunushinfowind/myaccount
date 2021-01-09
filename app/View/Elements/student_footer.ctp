<footer class="margin0 dashfooter clearfix"> 
    <!--<div class="container">-->
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-6">
            <div class="footer_nav">
                <ul class="list-unstyled list-inline">
                    <li> <a href="https://lessonsonthego.com/contact-us/">Contact Us</a></li>
                    <li> <a href="https://lessonsonthego.com/privacy-policy/">Privacy Policy</a></li>
                    <li> <a href="https://lessonsonthego.com/terms-conditions/">Term & Condition</a></li>
                    <li> <a href="#">About Us</a></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-2 ">
            <div class="social_link">
                <ul class="list-inline list-unstyled">
                    <li> <a href="https://www.facebook.com/lessonsonthego/" target="_blank"> <i class="fa fa-facebook-official"></i> </a> </li>
                    <li> <a href="https://twitter.com/lessonsonthego" target="_blank"> <i class="fa fa-twitter-square"></i> </a> </li>
                    <li> <a href="https://plus.google.com/106675622743121539730?hl=en" target="_blank"> <i class="fa fa-google-plus"></i> </a> </li>
                </ul>

            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-4 ">
            <div class="imgs1 new_imgs1 clearfix"> 
                <div class="AuthorizeNetSeal footerImg"> <script type="text/javascript" language="javascript">var ANS_customer_id = "2a0eb0a8-41ab-4e03-988b-3ddede3d6ea9";</script> <script type="text/javascript" language="javascript" src="//verify.authorize.net/anetseal/seal.js" ></script> <a href="http://www.authorize.net/" id="AuthorizeNetText" target="_blank">Online Payment Service</a> </div>
                <div class="ssl footerImg">
                    <img src="<?php echo $this->webroot; ?>img/SSL.png" />
                </div>
                <!--div class="bbb footerImg">
                    <span class="img2"> <a href="http://www.bbb.org/houston/business-reviews/tutoring/lessons-on-the-go-llc-in-the-woodlands-tx-90021611/" target="_blank" > <img src="<?php echo $this->webroot; ?>img/bbb-logo.png" /> </a> </span>
                </div-->
            </div>
        </div>
    </div>
    <!--</div>-->


</footer>
<div class="copyright1 copyright2 copy clearfix">
    <p> Copyright@2017</p>
</div>
<div id='loadingmessage' style='display:none'>
    <img src="<?php echo $this->webroot . 'img/loader.gif'; ?>" alt="loader"/>
</div>
<!--footer closed --> 

<div class="pop">
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <h1> Further details</h1>

                <div class="details"> 
                    <div class="col-md-6 col-sm-6">
                        <span>Name</span>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <p>Deepak sharma</p>
                    </div>
                </div>

                <div class="details"> 
                    <div class="col-md-6 col-sm-6">
                        <span>Subject</span>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <p>English</p>
                    </div>
                </div>

                <div class="details"> 
                    <div class="col-md-6 col-sm-6">
                        <span>Date</span>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <p>21/12/2015</p>
                    </div>
                </div>

                <div class="details"> 
                    <div class="col-md-6 col-sm-6">
                        <span>Time</span>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <p>900:AM</p>
                    </div>
                </div>

                <div class="details"> 
                    <div class="col-md-6 col-sm-6">
                        <span>Address</span>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <p>Sector 34</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<?php echo $this->Html->script(array('bootstrap.js', 'jquery.mCustomScrollbar.js')); ?>

<script>
                    $('document').ready(function () {
                        //$('.left_side').css({'height': $('.new_ryt').innerHeight()});
                    });</script>


<script>
    jQuery(".menu-button").click(function () {
        jQuery(".dashboard_content").toggle(500);
    });</script>

<script>
    (function ($) {
        $(window).load(function () {
            $("body").mCustomScrollbar({
                theme: "minimal"
            });
        });
    })(jQuery);</script>



<script>

    $('body').on('click', '.loginbtn', function (e) {
        var msg = $('.messageText').val();
        var send_to = $(this).attr('sendTo');
        var send_by = $(this).attr('sendBy');
        if (msg == '') {
            $('input[name="data[msg]"]').after('<div class="error-message">Please leave the message</div>');
        } else {
            $('.error-message').remove();
            $(this).val('');
            $.ajax({
                type: 'POST',
                url: '<?php echo BASE_URL . 'student/reply_message'; ?>',
                dataType: 'json',
                data: {msg: msg, send_to: send_to, send_by: send_by},
                success: function (data) {
                    if (data.suc == 'y') {
                        window.location.href = data.url;
                    }
                }
            });
        }

    });</script>

<script>
    $('#create_message').on('click', function () {
        $('#new_message').modal('show');
    });
    $(document).ready(function () {
        $('#uploadDocStudent').change(function (e) {
            var fileName = e.target.files[0].name;
            var number = fileName.length;
            if (number > 15) {
                var start_string = fileName.substr(0, 15);
                var end_string = fileName.substr(30, 12);
                var final_string = start_string + '...' + end_string;
                $('.showFilename').html(final_string);
            } else {
                $('.showFilename').html(fileName);
            }
        });

        //message detail file upload
        $('#MessageFile').change(function (e) {
            var file = e.target.files[0].name;
            var str_length = file.length;
            if (str_length > 15) {
                var start_string = file.substr(0, 15);
                var end_string = file.substr(30, 12);
                var final_string = start_string + '...' + end_string;
                $('.showFile').html(final_string);
            } else {
                $('.showFile').html(file);
            }
        });
    });
    $('body').on('click', '#send_message', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var file_data = $('#uploadDocStudent').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('comment', $('#comment').val());
        form_data.append('teacher', $('#teacher').val());
        $.ajax({
            url: '<?php echo BASE_URL . 'student/create_message'; ?>', // point to server-side PHP script 
            dataType: 'json', // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {
                if (data.status == 'success') {
                    window.location.href = '<?php echo BASE_URL . 'student/messages'; ?>';
                    $('#thanks').modal('show');
                } else if (data.status == 'failure') {
                    alert('Please Select Teacher and add message.');
                }
            }
        });
    });
</script>


<div class="modal fade" id="new_message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">New Message</h4>
            </div>
            <form enctype="multipart/form-data" id="studentMessage" method="post">
                <div class="modal-body">
                    <div class="col-md-12 form-group">
                        <div class="col-lg-3">Teacher</div>
                        <div class="col-lg-9">
                            <select class="form-control" id="teacher">
                                <option value="">--Select--</option>
                                <?php
                                if (!empty($teacher)) {
                                    foreach ($teacher as $teachers) {
                                        if (!empty($teachers)) {
                                            ?>
                                            <option value = '<?php echo $teachers['User']['id']; ?>'><?php echo ucfirst($teachers['User']['first_name']) . ' ' . ucfirst($teachers['User']['last_name']); ?></option>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </select>  
                        </div>
                    </div>

                    <div class="col-lg-12 form-group">
                        <div class="col-lg-3">Message</div>
                        <div class="col-lg-9">
                            <textarea class="form-control" rows="3" id="comment"></textarea>
                        </div>
                    </div>

                    <div class="col-lg-12 form-group">
                        <div class="col-lg-3">Upload Doc</div>
                        <div class="col-lg-9">
                            <label class="btn btn-primary btn-file saveBtn">
                                <i class="fa fa-upload"></i> &nbsp;Upload <input type="file" style="display: none;" id="uploadDocStudent">
                            </label>
                            <div class="showFilename"></div>
                        </div>
                    </div>

                </div> 
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary saveBtn" id="send_message">Send</button>
                </div>

            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="thanks" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Message Sent</h4>
            </div>
            <div class="modal-body">
                <p>Your Message sent successfully!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
    .saveBtn{
        background: #42acd1;
        border: #42acd1;
    }
    .saveBtn:hover{
        background: #0c9090;
        border: #42acd1;
    }
</style>

<script>
    $(document).ready(function () {
        $('#filterStart').datepicker();
        $('#filterEnd').datepicker();
    });
    $('#filterData').on('click', function () {
        studentId = $('#studentId').val();
        start_date = $('#filterStart').val();
        end_date = $('#filterEnd').val();
        if ((start_date == '') && (end_date == '')) {
            alert('Please select Dates.');
        } else if (start_date == '') {
            alert('Please select Start Date.');
        } else if (end_date == '') {
            alert('Please select End Date.');
        } else if ((start_date != '') && (end_date != '')) {
            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'student/filter_lesson'; ?>',
                data: {studentId: studentId, start_date: start_date, end_date: end_date},
                success: function (data) {
                    $('#appendLesson').html(data);
                }
            });
        }
    });</script>


<script>
    $('body').on('change', '#billing_address', function () {
        value = $(this).val();
        if (value == 'different') {
            $('#bill_address').modal('show');
        }
    });</script>
<script>
    $('body').on('click', '#addBillAdd', function () {
        var add = $('#add').val();
        var apt = $('#apt').val();
        var city = $('#city').val();
        var state = $('#state').val();
        var zip = $('#zip').val();
        if ((add == '') || (city == '') || (state == '') || (zip == '')) {
            alert('Fields marked with * are required.');
        } else {
            $('#bill_address').modal('hide');
        }
    });</script>

<script>
    $('body').on('change', '#billingAddress', function () {
        value = $(this).val();
        if (value == 'different') {
            $('.billing_address_pop').modal('show');
        }
    });</script>
<script>
    $('body').on('click', '.addBillAdd_app', function () {
        var address_app = $('.address_app').val();
        var apt_app = $('.apt_app').val();
        var city_app = $('.city_app').val();
        var state_app = $('.state_app').val();
        var zip_app = $('.zip_app').val();
        if ((address_app == '') || (city_app == '') || (state_app == '') || (zip_app == '')) {
            alert('Fields marked with * are required.');
        } else {
            $('.billing_address_pop').modal('hide');
        }
    });</script>

<script>
    $('body').on('click', '#addStudent', function () {
        $('#aditionalStduent').modal('show');
    });
    $('body').on('click', '#additionalStduentDetails', function () {
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var age = $('#age').val();
        var subject = $('#subject').val();
        if ((firstname == '') || (age == '')) {
            alert('Please fill out the mandatory fields.');
        } else if ((firstname != '') || (age != '')) {
            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'student/add_additional_student'; ?>',
                dataType: 'json',
                data: {firstname: firstname, lastname: lastname, age: age, subject: subject},
                success: function (data) {
                    if (data.status == 'success') {
                        alert('Student added successfully!');
                    } else if (data.status == 'failure') {
                        alert('Error adding additional student.');
                    }
                    window.location.href = '<?php echo BASE_URL . 'student/additional_student'; ?>';
                }
            });
        }
    });</script>

<!--Additional Student details modal-->
<div class="modal fade forZIndex" id="aditionalStduent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeIcon"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Student</h4>
            </div>
            <div class="modal-body">

                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        First Name <span class="asterick">*</span>
                    </div>
                    <div class="col-lg-9">
                        <?php echo $this->Form->input('firstname', array('class' => 'form-control', 'id' => 'firstname', 'label' => FALSE, 'placeholder' => 'First Name')); ?>
                    </div>
                </div>

                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        Last Name
                    </div>
                    <div class="col-lg-9">
                        <?php echo $this->Form->input('lastname', array('class' => 'form-control', 'id' => 'lastname', 'label' => FALSE, 'placeholder' => 'Last Name')); ?>
                    </div>
                </div>

                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        Age <span class="asterick">*</span> 
                    </div>
                    <div class="col-lg-9">
                        <?php
                        echo $this->Form->input('age', array('class' => 'form-control', 'id' => 'age', 'label' => FALSE, 'placeholder' => 'Age'));
                        ?>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        Subject <span class="asterick">*</span> 
                    </div>
                    <div class="col-lg-9">
                        <?php
                        if (!empty($subjects)) {
                            foreach ($subjects as $subject) {
                                $sub[$subject['Subject']['subject']] = $subject['Subject']['subject'];
                            }
                        }
                        echo $this->Form->input('subject', array('class' => 'form-control', 'id' => 'subject', 'label' => FALSE, 'empty' => '-Select-', 'options' => @$sub, 'type' => 'select'));
                        ?>
                    </div>
                </div>
            </div> 
            <div class="clearfix"></div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
                <button type="button" class="btn btn-primary saveBtn" id="additionalStduentDetails"><i class="fa fa-plus-circle"></i>&nbsp;Student Details</button>
            </div>
        </div>
    </div>

</div>
<!--Additional Student details modal-->

<script>
    $('body').on('click', '#EditAdditionl', function () {
        var id = $(this).attr('studeID');
        $('#parent_id').val(id);
        $.ajax({
            type: 'post',
            url: '<?php echo BASE_URL . 'student/get_additional'; ?>',
            data: {id: id},
            success: function (data) {
                $('#EditAddSTudent').modal('show');
                $('#showData').html(data);
            }
        });
    });
    $('body').on('click', '#EditadditionalStduent', function () {
        var stu_id = $('#parent_id').val();
        var fname = $('#first_name').val();
        var lname = $('#last_name').val();
        var age = $('#stu_age').val();
        var subject = $('#stu_subject').val();
        $.ajax({
            type: 'post',
            url: '<?php echo BASE_URL . 'student/edit_add'; ?>',
            data: {stu_id: stu_id, fname: fname, lname: lname, age: age, subject: subject},
            dataType: 'json',
            success: function (data) {
                if (data.status == 'true') {
                    alert('Additional Student updated successfully!');
                    window.location.href = '<?php echo BASE_URL . 'student/additional_student'; ?>';
                }
            }
        });
    });</script>

<!--Additional Student details modal-->
<div class="modal fade forZIndex" id="EditAddSTudent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeIcon"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Student</h4>
            </div>
            <div class="modal-body" id="showData">


            </div> 
            <input type="hidden" id="parent_id">
            <div class="clearfix"></div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
                <button type="button" class="btn btn-primary saveBtn" id="EditadditionalStduent"><i class="fa fa-plus-circle"></i>&nbsp;Edit Student Details</button>

            </div>
        </div>
    </div>

</div>
<!--Additional Student details modal-->


<script>
    $('body').on('click', '#addAdditional', function () {
        $('.appendAdditional').append("<div class='mainStart'><div style='margin-right: 9%;text-align: center;'><h4>Additional Student Information</h4></div><input type='button' class='fileUpload1 btn btn-success' value='-' id='hideAdditional' style='float:right;margin-right: 30px;'><div class='row'><div class='col-md-12'><div class='col-md-5'><div class='form-group'><label for='exampleInputEmail1'>Student's First Name<span> *</span></label><input type='text' name='data[Child_user][firstname][]' placeholder='First Name' class='form-control'></div></div><div class='col-md-5 col-md-offset-1'><div class='form-group'><label for='exampleInputPassword1'>Student's Last Name<span> *</span></label><input type='text' class='form-control' name='data[Child_user][lastname][]' placeholder='Last Name'></div></div></div></div><div class='row'><div class='col-md-12'><div class='col-md-5'><div class='form-group'><label for='exampleInputPassword1'>Student's Age<span> *</span></label><input type='text' name='data[Child_user][age][]' placeholder='Age' class='form-control'></div></div><div class='col-md-5 col-md-offset-1'><div class='form-group'><label for='exampleInputEmail1'>Subject<span> *</span></label><select name='data[Child_user][subject][]' class='form-control'><option value=''>-Select-</option><?php
                        if (!empty($all_subjects)) {
                            foreach ($all_subjects as $subject) {
                                ?><option value='<?php echo $subject['Subject']['subject']; ?>'><?php echo $subject['Subject']['subject']; ?></option><?php
                            }
                        }
                        ?></select></div></div></div></div></div>");
    });
    $('body').on('click', '#hideAdditional', function () {
        $(this).parent().remove();
    });
    $('body').on('click', '#removeAdditionl', function () {
        var ask = confirm('Are you sure?');
        var child_id = $(this).attr('child_id');
        if (ask == true) {
            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'student/ajax_remove_additional'; ?>',
                data: {child_id: child_id},
                dataType: 'json',
                success: function (data) {
                    if (data.status == 'success') {
                        alert('Additional Student removed from account.');
                        window.location.href = '<?php echo BASE_URL . 'student/my_info'; ?>';
                    }
                }
            });
        }
    });
</script>



