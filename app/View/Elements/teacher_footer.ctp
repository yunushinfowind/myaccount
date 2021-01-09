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

<link href="<?php echo $this->webroot . 'fullcalendar/fullcalendar.css'; ?>" rel="stylesheet" />
<link href="<?php echo $this->webroot . 'css/jquery.timepicker.css'; ?>" rel="stylesheet" />
<link href="<?php echo $this->webroot . 'fullcalendar/fullcalendar.print.css'; ?>" rel="stylesheet"  media="print"  />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
<script  src="<?php echo $this->webroot; ?>js/bootstrap.js"></script> 
<script src="//momentjs.com/downloads/moment.js"></script>
<script src="<?php echo $this->webroot . 'js/jquery.timepicker.min.js'; ?>" ></script>
<script src="<?php echo $this->webroot . 'fullcalendar/fullcalendar.min2.js'; ?>"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


<script>
                    $('document').ready(function () {
                        // $('.left_side').css({'height': $('.new_ryt').innerHeight()});
                    });</script>


<!--script for full-calendar-->
<script>

    $(document).ready(function () {
        $(document).ajaxStart(function () {
//            $("#loadingmessage").show();
        }).ajaxStop(function () {
//            $("#loadingmessage").hide();
        })

        sess = '<?php
if (!empty($_SESSION['view'])) {
    echo $_SESSION['view'];
}
?>';
        if (sess != '') {
            view = sess;
            $('.viewHidden').val(view);
        } else {
            view = 'month';
        }


<?php
if (!empty($_SESSION['getTitle'])) {
    ?>
            showdate = '<?php echo date('Y-m-d', strtotime($_SESSION['getTitle'])); ?>';
<?php } else { ?>
            showdate = '<?php echo date('Y-m-d'); ?>';
<?php }
?>
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultView: view,
            defaultDate: showdate,
            selectable: true,
            selectHelper: true,
            slotDuration: '00:15:00',
            allDaySlot: false,
            timezone: 'America/Chicago',
            timeFormat: {
                agenda: 'hh:mm{ - hh:mm}'
            },
            dayClick: function (date, view, jsEvent) {
                clicked_date = date.format();
                $('#SelectedTime').val(clicked_date);
                $('#monthModal').modal('show');
            },
            select: function (start, end, jsEvent, view) {
                getTitle = view.title;
                clicked_date = start.format();
                clicked_Edate = end.format();
                today = '<?php echo date('Y-m-d'); ?>';
                $('#monthModal').modal('show');
                if (view.name == 'month') {
                    $('#start_date').val(clicked_date);
                    $('#end_date').val(clicked_Edate);
                    $('#showstart').val('');
                    $('#showend').val('');
                    $('#getView').val('month');
                    $('#getTitle').val(clicked_date);
                } else if (view.name == 'agendaWeek') {
                    clicked_time = start.format('h:mt');
                    clicked_Etime = end.format('h:mt');
                    var explode_start = clicked_time.split('T');
                    var explode_end = clicked_Etime.split('T');
                    var start_value = explode_start[0].split(':');
                    var end_value = explode_end[0].split(':');
                    $('#start_date').val(clicked_date);
                    $('#end_date').val(clicked_Edate);
                    if (start_value[1] == '0a') {
                        $('#showstart').val(start_value[0] + ':00am');
                    } else if (start_value[1] == '0p') {
                        $('#showstart').val(start_value[0] + ':00pm');
                    } else {
                        $('#showstart').val(explode_start + 'm');
                    }
                    if (end_value[1] == '0a') {
                        $('#showend').val(end_value[0] + ':00am');
                    } else if (end_value[1] == '0p') {
                        $('#showend').val(end_value[0] + ':00pm');
                    } else {
                        $('#showend').val(explode_end + 'm');
                    }
                    $('#getView').val('agendaWeek');
                    $('#getTitle').val(clicked_date);
                } else {
                    clicked_time = start.format('h:mt');
                    clicked_Etime = end.format('h:mt');
                    var explode_start = clicked_time.split('T');
                    var explode_end = clicked_Etime.split('T');
                    var start_value = explode_start[0].split(':');
                    var end_value = explode_end[0].split(':');
                    $('#start_date').val(clicked_date);
                    $('#end_date').val(clicked_Edate);
                    if (start_value[1] == '0a') {
                        $('#showstart').val(start_value[0] + ':00am');
                    } else if (start_value[1] == '0p') {
                        $('#showstart').val(start_value[0] + ':00pm');
                    } else {
                        $('#showstart').val(explode_start + 'm');
                    }
                    if (end_value[1] == '0a') {
                        $('#showend').val(end_value[0] + ':00am');
                    } else if (end_value[1] == '0p') {
                        $('#showend').val(end_value[0] + ':00pm');
                    } else {
                        $('#showend').val(explode_end + 'm');
                    }
                    $('#getView').val('agendaDay');
                    $('#getTitle').val(clicked_date);
                }
            },
            eventMouseover: function (event, jsEvent, view) {
                $(jsEvent.target).attr('title', event.title);
            },
            eventClick: function (event, jsEvent, view) {
                var title = event.title;
                var date = event.start._i;
                var splitted_date = date.split('T');
                var clicked_date = splitted_date[0];
                var get_view = view.name;
                $('#title').val(title);
                $('#recurr_title').val(title);
                $('#start_date').val(clicked_date);
                $('#recurr_start_date').val(clicked_date);
                $('#returnView').val(get_view);
                $('#recurr_returnView').val(get_view);
                $('#markAction').modal('show');
                $('#returnTitle').val(clicked_date);
                $(document).ready(function () {
                    /*setTimeout(function () {
                        $('#timepicker1').timepicker();
                    }, 2000);
                    setTimeout(function () {
                        $('#timepicker2').timepicker();
                    }, 2000);*/
                    setTimeout(function() {
                        editLessonTimepicker();
                    },1000);

                });
                if ($('#markAction').hasClass('in') == false) {
                    $('#UpdateSchedule').attr('disabled', false);
                    $('body').on('click', '.markcompleted', function () {
                        if ($(this).is(':checked') == true) {
                            $('.chck_radio').show();
                            $(this).val('on');
                        } else if ($(this).is(':checked') == false) {
                            $(this).val('off');
                            $('.chck_radio').hide();
                        }
                    });
                    $('body').on('click', '#repeatLesson', function () {
                        if ($(this).is(':checked') == true) {
                            $(this).val('true');
                        } else if ($(this).is(':checked') == false) {
                            $(this).val('false');
                        }
                    });
                    $('body').on('click', '.radioComplete', function () {
                        if ($(this).is(':checked') == true) {
                            $('#CompleteRadioVal').val($(this).val());
                        }
                        $('#remarks').val('');
                        $('.textarea').show();
                    });
                    var id = event.id;
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo BASE_URL . 'teacher/find_data'; ?>',
                        data: {id: id},
                        success: function (data) {
                            $('.appendData').html(data);
                        }
                    });
                    $('body').on('click', '#UpdateSchedule', function (e) {
                       // alert('1');
                        var me = $(this);
                        e.preventDefault();
                        if (me.data('requestRunning')) {
                            alert('Error in processing, Try after some time.')
                            return false;
                        }

                        //TODO: NEEDED SOMETHING QUICK, THIS IS HACKY, FIND A BETTER WAY //SEV
                        var startAsFullDate = new Date ("01/01/01 " + $('.start_time').val().replace("pm", " pm").replace("am", " am"));
                        var endAsFullDate = new Date ("01/01/01 " + $('.end_time').val().replace("pm", " pm").replace("am", " am"));

                        if(startAsFullDate.getTime() > endAsFullDate.getTime()) {
                            alert('End Time cannot be before Start Time');
                            return false;
                        }

                        me.data('requestRunning', true);
                        $('#UpdateSchedule').attr('disabled', 'disabled');
                        var date = event.start._i;
                        var split_date = date.split('T');
                        var clicked_date = split_date[0];
                        var today = '<?php echo date('Y-m-d h:ia'); ?>';
                        var title = $('#title').val();
                        var start_date = $('#start_date').val();
                        var startDate = $('#startDate').val();
                        var view = $('#returnView').val();
                        var mark_completed = $('.markcompleted').val();
                        var repeat_lesson = $('#repeatLesson').val();
                        var schedule_id = $('#schedule_id').val();
                        var student = $('.student').val();
                        var subject = $('.subject').val();
                        var getSubjectName = $('#getSubjectName').val();
                        var start_time = $('.start_time').val();
                        var end_time = $('.end_time').val();
                        var completed_type = $('#CompleteRadioVal').val();
                        var remarks = $('#remarks').val();
                        var getTitle = $('#returnTitle').val();
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo BASE_URL . 'teacher/save_schedule'; ?>',
                            dataType: 'json',
                            cache: false,
                            data: {view: view, repeat_lesson: repeat_lesson, mark_completed: mark_completed, schedule_id: schedule_id, student: student, subject: subject, start_time: start_time, end_time: end_time, completed_type: completed_type, remarks: remarks, start_date: start_date, title: title, today: today, clicked_date: clicked_date, startDate: startDate, getSubjectName: getSubjectName, getTitle: getTitle},
                            success: function (data) {
                                if (data.suc == 'y') {

                                    $('#markAction').modal('hide');

                                    window.location.href = '<?php echo BASE_URL . 'teacher/calendar'; ?>';
                                } else if (data.suc == 'no') {
                                    $('#dataFailure').modal('show');
                                    me.data('requestRunning', false);
                                }
                                
                            }
                        }
                        );
                    });
                }
                $('body').on('click', '.removeSchedule', function () {
                    var getid = event.id;
                    var clicked_start = event._start._i;
                    var clicked_end = event._end._i;
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo BASE_URL . 'teacher/check_recurring'; ?>',
                        data: {getid: getid, clicked_start: clicked_start, clicked_end: clicked_end},
                        success: function (data) {
                            $('#DeleteModal').modal('show');
                            $('#DeleteModal').html(data);
                        }
                    });
                });
                $('body').on('click', '#DeletedSchedule', function () {
                    var delete_id = $('#idToDelete').val();
                    var start_date = $('#getstartDate').val();
                    var end_date = $('#endDate').val();
                    var value = $('#GetVlu').val();
                    var new_array = '';
                    if (value == 'non_recurr') {
                        new_array = 'no_recurring';
                    } else {
                        $('.deleteAll').each(function () {
                            if ($(this).is(":checked")) {
                                new_array = $(this).val();
                            }
                        });
                    }
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo BASE_URL . 'teacher/remove_schedule'; ?>',
                        dataType: 'json',
                        data: {new_array: new_array, delete_id: delete_id, start_date: start_date, end_date: end_date},
                        success: function (data) {
                            if (data.status == 'success') {
                                $('#DeleteModal').modal('hide');
                                $('#markAction').modal('hide');
                                if (data.id != '') {
                                    $('#calendar').fullCalendar('removeEvent', data.id);
                                }
                                window.location.href = '<?php echo BASE_URL . 'teacher/calendar'; ?>';
                            } else if (data.status == 'no_data') {
                                alert('Please select the option you want to delete the lesson for.');
                            }
                        }

                    });
                });
            },
            eventLimit: true,
            eventSources: [
                {
                    url: '<?php echo BASE_URL . 'teacher/calendarjson'; ?>',
                    currentTimezone: 'America/Chicago'
                }
            ],
        });
        $(document).ready(function () {
            var base_url = '<?php
echo BASE_URL;
?>';
            var currentURL = window.location.href;
            if (currentURL == base_url + 'teacher/calendar') {

                view = $('.viewHidden').val();
                centre = $('.fc-center').html();
                getCompletedLesson(centre, view);
            }
        });
        $('.fc-agendaWeek-button').on('click', function () {
            view = 'week';
            centre = $('.fc-center').html();
            $('.viewHidden').val('week');
            getCompletedLesson(centre, view);
        });
        $('.fc-month-button').on('click', function () {
            view = 'month';
            centre = $('.fc-center').html();
            $('.viewHidden').val('month');
            getCompletedLesson(centre, view);
        });
        $('.fc-agendaDay-button').on('click', function () {
            view = 'day';
            centre = $('.fc-center').html();
            $('.viewHidden').val('day');
            getCompletedLesson(centre, view);
        });
        $('.fc-next-button').on('click', function () {
            view = $('.viewHidden').val();
            centre = $('.fc-center').html();
            getCompletedLesson(centre, view);
        });
        $('.fc-prev-button').on('click', function () {
            view = $('.viewHidden').val();
            centre = $('.fc-center').html();
            getCompletedLesson(centre, view);
        });
        $('.fc-today-button').on('click', function () {
            view = $('.viewHidden').val();
            centre = $('.fc-center').html();
            getCompletedLesson(centre, view);
        });
        function getCompletedLesson(centre, view) {
            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'teacher/ajax_get_lesson'; ?>',
                dataType: 'json',
                data: {centre: centre, view: view},
                success: function (data) {
                    if (data.status == 'true') {
                        amount = data.amount;
                        time = data.time;
                        $('#time').html(time);
                        $('#amount').html(amount);
                    } else if (data.status == 'false') {
                        amount = data.amount;
                        time = data.time;
                        $('#time').text(time);
                        $('#amount').text(amount);
                    }
                }
            });
        }


        $(document).ready(function () {
            $('#student').val('');
            $('#subjects').val('');
        });
        $('body').on('click', '#monthModalClose, #closeIcon', function () {
            $('#student').val('');
            $('#subjects').val('');
        });
        $('body').on('click', '#repeat_lesson', function () {
            if ($(this).is(':checked') == true) {
                $(this).val('true');
            } else if ($(this).is(':checked') == false) {
                $(this).val('false');
            }
        });
        //Schedule students for month view
        $('#Scheduled').on('click', function () {
            var view = $('#getView').val();
            var student = $('#student').val();
            var subject = $('#subjects').val();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var start_time = $('#showstart').val();
            var end_time = $('#showend').val();
            var repeat_lesson = $('#repeat_lesson').val();
            var getTitle = $('#getTitle').val();
//            alert(getTitle);


            //TODO: NEEDED SOMETHING QUICK, THIS IS HACKY, FIND A BETTER WAY //SEV
            var startAsFullDate = new Date ("01/01/01 " + start_time.replace("pm", " pm").replace("am", " am"));
            var endAsFullDate = new Date ("01/01/01 " + end_time.replace("pm", " pm").replace("am", " am"));

            if(startAsFullDate.getTime() > endAsFullDate.getTime()) {
                alert('End Time cannot be before Start Time');
                return false;
            }
            //

            $.ajax({
                type: 'POST',
                url: '<?php echo BASE_URL . 'teacher/scheduled'; ?>',
                dataType: 'json',
                data: {student: student, subject: subject, start_time: start_time, end_time: end_time, start_date: start_date, end_date: end_date, view: view, repeat_lesson: repeat_lesson, getTitle: getTitle},
                success: function (data) {
                    if (data.suc == 'y') {
                        //alert("success");
                        var id = data.id;
                        if (data.repeat == 'repeat') {
                            //alert("data.repeat == 'repeat'");
                            window.location.href = '<?php echo BASE_URL . 'teacher/calendar_recurring/'; ?>' + id;
                        } else if ((data.repeat == '') && (data.repeat == 'unrepeat')) {
                            //alert("(data.repeat == '') && (data.repeat == 'unrepeat')");
                            window.location.href = '<?php echo BASE_URL . 'teacher/calendar'; ?>';
                        } else {
                            //alert("else");
                            $('#monthModal').modal('hide');
                            window.location.href = '<?php echo BASE_URL . 'teacher/calendar'; ?>';
                        }
                    } else if (data.suc == 'n') {
                        var duration = data.time_left;
                        var conflict = data.conflict;
                        var missing = data.missing;
                        if (conflict) {
                            alert("This lesson conflicts with another lesson with this student on " + conflict + ".  Please change the lesson times or delete the conflicting lesson.");
                        } else if (duration == 0) {
                            $('#monthModal').modal('hide');
                            alert("You can't schedule lesson,as there is only " + duration + " minutes left for the student.");
                        } else if(missing) {
                            alert("Please select a name, subject, start time, and end time.");
                        } else {
                            alert("An unspecified error has occurred.");
                        }
                    }
                }
            });
        });
    });</script>

<!--for messaging-->

<script>
    $('#create_message').on('click', function () {
        $('#new_message').modal('show');
    });
    $(document).ready(function () {
        //pop-up message file upload
        $('#uploadDocpopup').change(function (e) {
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
        BASE_URL = "<?php echo BASE_URL; ?>";
        var file_data = $('#uploadDocpopup').prop('files')[0];

        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('comment', $('#comment').val());
        form_data.append('student', $('#student_name').val());
        $.ajax({
            url: '<?php echo BASE_URL . 'teacher/create_message'; ?>', // point to server-side PHP script 
            dataType: 'json', // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {

                if (data.status == 'success') {
                    // $('#thanks').modal('show');
                    window.location.href = '<?php echo BASE_URL . 'teacher/messages'; ?>';

                } else if (data.status == 'failure') {
                    alert('Please Select Student and add message.');
                }
            }
        });
    });</script>

<!--styling-->
<style>
    body {
        margin: 40px 10px;
        padding: 0;
        font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
        font-size: 14px;
    }
    #calendar {
        max-width: 900px;
        margin: 0 auto;
    }
</style>

<!--modal for schedule lesson-->
<div class="modal fade" id="monthModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeIcon"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Schedule Lesson</h4>
            </div>
            <div class="modal-body">

                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        Name
                    </div>
                    <div class="col-lg-9">
                        <select class="form-control schedule_student" id="student">
                            <option value="">--Select--</option>
                            <?php
                            if (!empty($students)) {
                                foreach ($students as $student) {
                                    if (!empty($student['User'])) {
                                        ?>
                                        <option value = '<?php echo $student['Assigned_teacher']['student_id']; ?>' stu_id="<?php echo $student['Assigned_teacher']['student_id']; ?>"><?php echo ucfirst($student['User']['first_name']) . ' ' . ucfirst($student['User']['last_name']); ?></option>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </select>  
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        Subject
                    </div>
                    <div class="col-lg-9">
                        <select class="form-control" id="subjects" disabled="disabled">
                            <option value="">--Select--</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12 form-group">
                    <div class="col-lg-3">Start Time</div>
                    <div class="col-lg-9">
                        <div class="form-group">
                            <div id="datetimepicker1" class="input-group date">
                                <input data-format="dd/MM/yyyy hh:mm:ss" type="text" class="form-control" id="showstart" value="">
                                <span class="input-group-addon" id="start1">
                                    <span class="glyphicon glyphicon-time" id="start_time"></span>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-12 form-group">
                    <div class="col-lg-3">End Time</div>
                    <div class="col-lg-9">
                        <div class="form-group">
                            <div id="datetimepicker2" class="input-group date">
                                <input data-format="dd/MM/yyyy hh:mm:ss" type="text" class="form-control" id="showend"></input>
                                <span class="input-group-addon" id="end1">
                                    <span class="glyphicon glyphicon-time" id="end_time"></span>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-12 form-group">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-9">
                        <div class="checkbox">
                            <label><input type="checkbox" id="repeat_lesson" value="">Repeat Lesson Weekly</label>
                        </div>
                    </div>
                </div>

                <input type="hidden" value="" id="start_date">
                <input type="hidden" value="" id="end_date">
                <input type="hidden" value="" id="startTiming">
                <input type="hidden" value="" id="endTiming">
                <input type="hidden" value="" id="getView">
                <input type ="hidden" value="" id="total_time">
                <input type ="hidden" value="" id="getTitle">
            </div> 
            <div class="clearfix"></div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="monthModalClose">Close</button>
                <button type="button" class="btn btn-primary saveBtn" id="Scheduled">Schedule</button>

            </div>
        </div>
    </div>

</div>

<!--modal for editing the scheduled lesson--> 
<div class="modal fade" id="markAction" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Actions on Schedule</h4>
            </div>
            <div class="modal-body">

                <div class="appendData"></div>

                <div class="col-lg-12">
                    <div class="col-lg-1" style="margin: 5px 0;">
                        <a data-target="#DeleteModal" data-toggle="modal"  class="removeSchedule"><i class="fa fa-trash-o" style="font-size:27px;"></i></a>
                    </div>
                    <div class="col-lg-11">
                        <a class="removeSchedule" data-target="#DeleteModal" data-toggle="modal"><h4>Delete Scheduled Lesson</h4></a>
                    </div>
                </div>
                <div class="clearfix"></div>

                <input type="hidden" id="returnView" value="">
                <input type="hidden" id="returnTitle" value="">
                <input type="hidden" id="title" value="">

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary saveBtn" id="UpdateSchedule">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!--modal for delete-->
<div class="modal fade" id="DeleteModal" role="dialog">

</div>

<!--modal for creating new message-->
<div class="modal fade" id="new_message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">New Message</h4>
            </div>
            <form enctype="multipart/form-data" id="myForm" method="post">
                <div class="modal-body">

                    <div class="col-md-12 form-group">
                        <div class="col-lg-3">
                            Name
                        </div>
                        <div class="col-lg-9">
                            <select class="form-control" id="student_name">
                                <option value="">--Select--</option>
                                <?php
                                if (!empty($students)) {
                                    foreach ($students as $student) {
                                        if (!empty($student['User'])) {
                                            ?>
                                            <option value = '<?php echo $student['Assigned_teacher']['student_id']; ?>'><?php echo ucfirst($student['User']['first_name']) . ' ' . ucfirst($student['User']['last_name']); ?></option>
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
                                <i class="fa fa-upload"></i> &nbsp;Upload <input type="file" style="display: none;" id="uploadDocpopup">



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

<!--modal for data Failure-->
<div class="modal fade" id="dataFailure" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color:#FF0000;">ALERT <i class="fa fa-bell-o"></i></h4>
            </div>
            <div class="modal-body">
                <p style="color:#FF0000;">You can't mark a lesson as complete before the scheduled time.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!--Complete modal-->
<div class="modal fade" id="complte_modal" role="dialog">

</div>

<!-- Don't show Modal -->
<div class="modal fade" id="dontShow" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color:red;">Alert! <i class="fa fa-bell-o" ></i></h4>
            </div>
            <div class="modal-body">
                <p>Lessons cannot be marked as completed before the scheduled time.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!--styling-->
<style>
    .saveBtn{
        background: #42acd1;
        border: #42acd1;
    }
    .saveBtn:hover {
        background: #0c9090;
        border: #42acd1;
    }

    .fc-event{
        cursor: pointer;
    }
    .removeSchedule{
        color: #333333;
        cursor: pointer;
    }
    .removeSchedule:hover{
        color:#0C9090;
    }
    #start1{
        cursor: pointer;
    }
    #end1{
        cursor: pointer;
    }
    #Edit_start1{
        cursor: pointer;
    }
    #Edit_end1{
        cursor: pointer;
    }
</style>

<!--script showing timepicker-->
<script type="text/javascript">
    $('#showstart').timepicker({
        minuteStep: 15,
        scrollDefault: 'now',
    });
    $('#start_time').on('click', function () {
        $('#showstart').timepicker('show');
    });
    $('#showend').timepicker({
        minuteStep: 15,
        scrollDefault: 'now'
    });
    $('#end_time').on('click', function () {
        $('#showend').timepicker('show');
    });</script>

<script>
    jQuery(".menu-button").click(function () {
        jQuery(".dashboard_content").toggle(500);
    });</script>

<script>
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 600) {
            jQuery('.dashfooter, .copyright1').addClass('addd');
        } else {
            jQuery('.dashfooter, .copyright1').removeClass('addd');
        }
    });</script>

<script>
    $(function () {
        $("#filterStart").datepicker();
        $("#filterEnd").datepicker();
    });
    $('#filterData').on('click', function () {
        start_date = $('#filterStart').val();
        end_date = $('#filterEnd').val();
        if ((start_date == '') && (end_date == '')) {
            alert('Please select dates to filter.');
        } else if ((start_date == '') && (end_date != '')) {
            alert('Please select Start Date.');
        } else if ((start_date != '') && (end_date == '')) {
            alert('Please select End Date.');
        } else {

            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'teacher/filter_lesson'; ?>',
                data: {start_date: start_date, end_date: end_date},
                success: function (data) {
                    $('#appendLesson').html(data);
                }
            });
        }
    });</script>




<script>
    $('body').on('click', '#close_2_me', function () {
        var teacher_id = $('.teacher_id').val();
        var student_id = $('.student_id').val();
        $.ajax({
            type: 'post',
            url: '<?php echo BASE_URL . 'teacher/student_close_me'; ?>',
            dataType: 'json',
            data: {teacher_id: teacher_id, student_id: student_id},
            success: function (data) {

                if ((data.suc == 'true') || (data.suc == 'second_case')) {
                    $('.student_id').val(data.stu_id);
                    var origin = $('.teacher_address').val();
                    $('iframe').attr('src', 'https://www.google.com/maps/embed/v1/directions?key=AIzaSyAvb0UZPOMyOGXg9WV5x7fzEuo0AlB1dQA&origin=' + origin + '&destination=' + data.address);
                    complete_address = data.name + '<br/>' + data.full_address + '<br/>' + data.phone_number;
                    $('.student_address').html(complete_address);
                    $('.student_subject').html('-');
                    $('.student_schedule').html('-');
                } else if (data.suc == 'false') {
                    alert('No Closest Student found!');
                }
            }
        });
    });</script>

<script>
    $('body').on('change', '.schedule_student', function () {
        $('#subjects').attr('disabled', 'disabled');
        var stu_id = $(this).val();
        if (stu_id != '') {
            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'teacher/get_sub'; ?>',
                data: {stu_id: stu_id},
                success: function (data) {
                    $('#subjects').html(data);
                    $('#subjects').removeAttr('disabled');
                }
            });
        }
    });</script>

<script>
    $('body').on('click', '#closest_student', function () {
        var teacher_id = $('.teacher_id').val();
        var student_id = $('.student_id').val();
        $.ajax({
            type: 'post',
            url: '<?php echo BASE_URL . 'teacher/closest_student'; ?>',
            dataType: 'json',
            data: {teacher_id: teacher_id, student_id: student_id},
            success: function (data) {
                if ((data.suc == 'true') || (data.suc == 'second_case')) {
//                    var origin = $('.teacher_address').val();
                    var origin = data.previous_address;
                    $('iframe').attr('src', 'https://www.google.com/maps/embed/v1/directions?key=AIzaSyAvb0UZPOMyOGXg9WV5x7fzEuo0AlB1dQA&origin=' + origin + '&destination=' + data.address);
                    complete_address = data.name + '<br/>' + data.full_address + '<br/>' + data.phone_number;
                    $('.student_address').html(complete_address);
                    $('.student_subject').html('-');
                    $('.student_schedule').html('-');
                } else if (data.suc == 'false') {
                    alert('No Closest Student found!');
                }
            }
        });
    });
</script>

<script type="text/javascript">
    function editLessonTimepicker() {

        $('#appendStart').timepicker({
            minuteStep: 15,
            scrollDefault: 'now',
        });
        $('#Edit_start').on('click', function () {
            $('#appendStart').timepicker('show');
        });
        $('#appendEnd').timepicker({
            minuteStep: 15,
            scrollDefault: 'now'
        });
        $('#Edit_end').on('click', function () {
            $('#appendEnd').timepicker('show');
        });


    }


</script>