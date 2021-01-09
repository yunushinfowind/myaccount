

<script>
    $(document).ready(function () {
        $("#start_date").datepicker({
            minDate: 0,
            dateFormat: 'mm-dd-yy'
        });
        $("#end_date").datepicker({
            minDate: 0,
            dateFormat: 'mm-dd-yy'
        });
    });</script>

<script>
    $(document).ready(function () {
        $('#remove_image').on('click', function () {
            var id = $('.admin_id').val();
            $.ajax({
                url: '<?php echo BASE_URL . 'webadmin/login/remove_image'; ?>',
                type: 'post',
                dataType: 'json',
                data: {id: id},
                success: function (data) {
                    if (data.status == 'yes') {
                        alert('Image has been removed successfully!');
                        window.location.href = '<?php echo BASE_URL . 'webadmin/login/change_details'; ?>';
                    }
                }
            });
        });
    });</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#subjetc').multiselect({
            includeSelectAllOption: true
        });
    });</script>

<!--Credit card script -->
<script>
    $(document).ready(function () {
        $('#add_credit').on('click', function () {
            $('#add_credit_modal').modal('show');
        });
        $('#addCredit').on('click', function () {
            var student_id = $('.student_id').val();
            var hour = $('#hour_credit').val();
            var minutes = $('#minute_credit').val();
            $.ajax({
                url: '<?php echo BASE_URL . 'webadmin/student/add_credit'; ?>',
                type: 'post',
                dataType: 'json',
                data: {hour: hour, minutes: minutes, id: student_id},
                success: function (data) {
                    if ((data.status == 'both') || (data.status == 'hour') || (data.status == 'minute')) {
                        hour = data.credit_hours;
                        minutes = data.credit_minutes;
                        $('#hourToShow').val(hour);
                        $('#minuteToshow').val(minutes);
                        $('#hour_credit').val('');
                        $('#minute_credit').val('');
                        $('#add_credit_modal').modal('hide');
//                    } else if (data.status == 'hour') {
//                        hour = data.credit_hours;
//                        $('#hourToShow').val(hour);
//                        $('#hour_credit').val('');
//                        $('#minute_credit').val('');
//                        $('#add_credit_modal').modal('hide');
//                    } else if (data.status == 'minute') {
//                        minutes = data.credit_minutes;
//                        $('#minuteToshow').val(minutes);
//                        $('#hour_credit').val('');
//                        $('#minute_credit').val('');
//                        $('#add_credit_modal').modal('hide');
                    } else if (data.status == 'no') {
                        alert('Please add credits for student');
                    }
                }
            });
        });
        $('#subtract_credit').on('click', function () {
            $('#subtract_credit_modal').modal('show');
        });
        $('#subCredit').on('click', function () {
            var student_id = $('.student_id').val();
            var hour = $('#hourCredit').val();
            var minute = $('#minuteCredit').val();
            $.ajax({
                url: '<?php echo BASE_URL . 'webadmin/student/subtract_credit'; ?>',
                type: 'post',
                dataType: 'json',
                data: {hour: hour, minute: minute, student_id: student_id},
                success: function (data) {
                    //both start
                    if (data.status == 'hourNminute') {
                        hour = data.hours;
                        minute = data.minutes;
                        $('#hourToShow').val(hour);
                        $('#minuteToshow').val(minute);
                        $('#hourCredit').val('');
                        $('#minuteCredit').val('');
                        $('#subtract_credit_modal').modal('hide');
                    } else if (data.status == 'convertedTime') {
                        hour = data.hours;
                        minute = data.minutes;
                        $('#hourToShow').val(hour);
                        $('#minuteToshow').val(minute);
                        $('#hourCredit').val('');
                        $('#minuteCredit').val('');
                        $('#subtract_credit_modal').modal('hide');
                    } else if (data.status == 'notEnough') {
                        alert('Not enough credits in account to deduct');
                    }
                    //both end

                    //  hour status start
                    if (data.status == 'hour') {
                        hour = data.left_hours;
                        $('#hourToShow').val(hour);
                        $('#hourCredit').val('');
                        $('#subtract_credit_modal').modal('hide');
                    } else if (data.status == 'hour_failure') {
                        alert('Not enough credit in account to subtract.');
                    }
                    //hour status end
                    //minute status start
                    if (data.status == 'minute') {
                        minute = data.left_minutes;
                        $('#minuteToshow').val(minute);
                        $('#minuteCredit').val('');
                        $('#subtract_credit_modal').modal('hide');
                    } else if (data.status == 'ConvertedMinute') {
                        minute = data.minutes;
                        hour = data.hours;
                        $('#hourToShow').val(hour);
                        $('#minuteToshow').val(minute);
                        $('#hourCredit').val('');
                        $('#minuteCredit').val('');
                        $('#subtract_credit_modal').modal('hide');
                    } else if (data.status == 'noMinutes') {
                        $('#minuteCredit').val('');
                        alert('No minutes in account.');
                    }
                    //minute status end



                }
            });
        });
    });</script>
<!--Credit card script ends-->

<!--fullcalendar script-->
<script type="text/javascript">
    $(document).ready(function () {
        view_session = '<?php
if (isset($_SESSION['view']) && !empty($_SESSION['view'])) {
    echo $_SESSION['view'];
} else {
    echo 'month';
}
?>';

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
<?php if (!empty($_SESSION['getTitle'])) { ?>
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
            defaultView: view_session,
            defaultDate: showdate,
            selectable: true,
            selectHelper: true,
            slotDuration: '00:15:00',
            allDaySlot: false,
            timezone: 'America/Chicago',
            timeFormat: {
                agenda: 'hh:mm{ - hh:mm}'
            },
            eventLimit: true,
            select: function (start, end, jsEvent, view) {
                getTitle = view.title;
                start_date = start.format();
                end_date = end.format();
                today = '<?php echo date('Y-m-d'); ?>';
                current_view = view.name;
                $('#ScheduleModal').modal('show');
                if (current_view == 'month') {
                    $('#start_date').val(start_date);
                    $('#end_date').val(end_date);
                    $('#showstart').val('');
                    $('#showend').val('');
                    $('#getView').val('month');
                    $('#getTitle').val(start_date);
                } else if (current_view == 'agendaWeek') {
                    clicked_time = start.format('h:mt');
                    clicked_Etime = end.format('h:mt');
                    var explode_start = clicked_time.split('T');
                    var explode_end = clicked_Etime.split('T');
                    var start_value = explode_start[0].split(':');
                    var end_value = explode_end[0].split(':');
                    $('#start_date').val(start_date);
                    $('#end_date').val(end_date);
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
                    $('#getTitle').val(start_date);
                } else {
                    clicked_time = start.format('h:mt');
                    clicked_Etime = end.format('h:mt');
                    var explode_start = clicked_time.split('T');
                    var explode_end = clicked_Etime.split('T');
                    var start_value = explode_start[0].split(':');
                    var end_value = explode_end[0].split(':');
                    $('#start_date').val(start_date);
                    $('#end_date').val(end_date);
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
                    $('#getTitle').val(start_date);
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
                        $('.textarea').show();
                    });
                    var id = event.id;
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo BASE_URL . 'webadmin/teacher/get_data'; ?>',
                        data: {id: id},
                        success: function (data) {
                            $('.appendData').html(data);
                        }
                    });
                    $('#UpdateSchedule').on('click', function (e) {
                        var me = $(this);
                        e.preventDefault();
                        if (me.data('requestRunning')) {
                            alert('Error in processing, Try after some time.')
                            return false;
                        }

                        //TODO: NEEDED SOMETHING QUICK, THIS IS HACKY, FIND A BETTER WAY //SEV
                        var startAsFullDate = new Date ("01/01/01 " + $('.start_time').val().replace("pm", " pm").replace("am", " am"));
                        var endAsFullDate = new Date ("01/01/01 " + $('.end_time').val().replace("pm", " pm").replace("am", " am"));

                        //alert(startAsFullDate.getTime() + " > " + endAsFullDate.getTime() + " ? ");

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
                        var teacher_id = $('#teacher_id').val();



                        $.ajax({
                            type: 'POST',
                            url: '<?php echo BASE_URL . 'webadmin/teacher/updateScheduledLesson'; ?>',
                            dataType: 'json',
                            data: {view: view, repeat_lesson: repeat_lesson, mark_completed: mark_completed, schedule_id: schedule_id, student: student, subject: subject, start_time: start_time, end_time: end_time, completed_type: completed_type, remarks: remarks, start_date: start_date, title: title, today: today, clicked_date: clicked_date, startDate: startDate, getSubjectName: getSubjectName, getTitle: getTitle, teacher_id: teacher_id},
                            success: function (data) {
                                if (data.suc == 'y') {
                                    $('#markAction').modal('hide');
                                    window.location.href = '<?php echo BASE_URL . 'webadmin/teacher/view_calendar/' + $this->Session->read('teacher_id'); ?>';
                                } else if (data.suc == 'no') {
                                    $('#SuccessNo').modal('show');
                                    me.data('requestRunning', false);
                                }
                            }
                        }
                        );
                    });
                }


                $('.removeSchedule').on('click', function () {
                    var getid = event.id;
                    var clicked_start = event._start._i;
                    var clicked_end = event._end._i;
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo BASE_URL . 'webadmin/teacher/check_recurring'; ?>',
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
                        url: '<?php echo BASE_URL . 'webadmin/teacher/remove_schedule'; ?>',
                        dataType: 'json',
                        data: {new_array: new_array, delete_id: delete_id, start_date: start_date, end_date: end_date},
                        success: function (data) {
                            if (data.status == 'success') {
                                $('#DeleteModal').modal('hide');
                                $('#markAction').modal('hide');
                                if (data.id != '') {
                                    $('#calendar').fullCalendar('removeEvent', data.id);
                                }
                                window.location.href = '<?php echo BASE_URL . 'webadmin/teacher/calendar' + $this->Session->read('teacher_id'); ?>';
                            } else if (data.status == 'no_data') {
                                alert('Please select the option you want to delete the lesson for.');
                            }
                        }

                    });
                });
            },
            eventSources: [
                {
                    url: '<?php echo BASE_URL . 'webadmin/teacher/calendardata?id=' . $this->Session->read('teacher_id'); ?>',
                    currentTimezone: 'America/Chicago',
                }
            ],
        });
    });


    $(document).ready(function () {
        var base_url = '<?php
echo BASE_URL;
?>';

        var teacher_id = $('#SessUser').val();
        var currentURL = window.location.href;
        if (currentURL == base_url + 'webadmin/teacher/view_calendar/' + teacher_id) {
            view = $('.viewHidden').val();
            centre = $('.fc-center').html();
            teacher = $('#SessUser').val();
            getCompletedLesson(centre, view, teacher);
        }
    });
    $('body').on('click', '.fc-agendaWeek-button', function () {
        view = 'week';
        centre = $('.fc-center').html();
        teacher = $('#SessUser').val();
        $('.viewHidden').val('week');
        getCompletedLesson(centre, view, teacher);
    });
    $('body').on('click', '.fc-month-button', function () {
        view = 'month';
        centre = $('.fc-center').html();
        teacher = $('#SessUser').val();
        $('.viewHidden').val('month');
        getCompletedLesson(centre, view, teacher);
    });
    $('body').on('click', '.fc-agendaDay-button', function () {
        view = 'day';
        centre = $('.fc-center').html();
        teacher = $('#SessUser').val();
        $('.viewHidden').val('day');
        getCompletedLesson(centre, view, teacher);
    });
    $('body').on('click', '.fc-next-button', function () {
        view = $('.viewHidden').val();
        centre = $('.fc-center').html();
        teacher = $('#SessUser').val();
        getCompletedLesson(centre, view, teacher);
    });
    $('body').on('click', '.fc-prev-button', function () {
        view = $('.viewHidden').val();
        centre = $('.fc-center').html();
        teacher = $('#SessUser').val();
        getCompletedLesson(centre, view, teacher);
    });
    $('body').on('click', '.fc-today-button', function () {
        view = $('.viewHidden').val();
        centre = $('.fc-center').html();
        teacher = $('#SessUser').val();
        getCompletedLesson(centre, view, teacher);
    });
    function getCompletedLesson(centre, view, teacher) {
        $.ajax({
            type: 'post',
            url: '<?php echo BASE_URL . 'webadmin/teacher/ajax_get_lesson'; ?>',
            dataType: 'json',
            data: {centre: centre, view: view, teacher: teacher},
            success: function (data) {
                if (data.status == 'true') {
                    amount = data.amount;
                    time = data.time;
                    $('#admin_time').html(time);
                    $('#admin_amount').html(amount);
                } else if (data.status == 'false') {
                    amount = data.amount;
                    time = data.time;
                    $('#admin_time').text(time);
                    $('#admin_amount').text(amount);
                }
            }
        });
    }



    $(document).ready(function () {
        $('body').on('click', '#repeat_lesson', function () {
            if ($(this).is(':checked') == true) {
                $(this).val('true');
            } else if ($(this).is(':checked') == false) {
                $(this).val('false');
            }
        });
        $('#SchedulingLesson').on('click', function () {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            var getView = $('#getView').val();
            var student = $('#student').val();
            var subject = $('#subjects').val();
            var getTitle = $('#getTitle').val();
            var start_time = $('#showstart').val();
            var end_time = $('#showend').val();
            var repeat_lesson = $('#repeat_lesson').val();
            var teacherId = $('#teacherId').val();


            //TODO: NEEDED SOMETHING QUICK, THIS IS HACKY, FIND A BETTER WAY //SEV
            var startAsFullDate = new Date ("01/01/01 " + start_time.replace("pm", " pm").replace("am", " am"));
            var endAsFullDate = new Date ("01/01/01 " + end_time.replace("pm", " pm").replace("am", " am"));

            if(startAsFullDate.getTime() > endAsFullDate.getTime()) {
                alert('End Time cannot be before Start Time');
                return false;
            }
            //

            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'webadmin/teacher/schedule_lesson'; ?>',
                dataType: 'json',
                data: {start_date: start_date, end_date: end_date, getView: getView, student: student, getTitle: getTitle, start_time: start_time, end_time: end_time, repeat_lesson: repeat_lesson, subject: subject, teacherId: teacherId},
                success: function (data) {
                    if (data.suc == 'y') {
                        var id = data.id;
                        $('#ScheduleModal').modal('hide');
                        window.location.href = '<?php echo BASE_URL . 'webadmin/teacher/view_calendar/'; ?>' + id;
                    } else if (data.suc == 'n') {
                        //alert("failure");
                        var duration = data.time_left;
                        var conflict = data.conflict;
                        var missing = data.missing;
                        if (conflict) {
                            alert("This lesson conflicts with another lesson on " + conflict + ".  Please change the lesson times or delete the conflicting lesson.");
                        } else if (duration == 0) {
                            $('#ScheduleModal').modal('hide');
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
<!--fullcalendar script ends-->

<!--datepicker for schedule lesson modal-->
<script>
    $(document).ready(function () {
        $('#showstart').timepicker();
        $('#start_time').on('click', function () {
            $('#showstart').timepicker('show');
        });
        $('#showend').timepicker();
        $('#end_time').on('click', function () {
            $('#showend').timepicker('show');
        });
    });</script>


<!-- Add Credit Modal start -->
<div class="modal fade" id="add_credit_modal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Credit <i class="fa fa-plus-circle"></i></h4>
            </div>
            <div class="modal-body">
                <!--<p>Add Credits </p>-->
                <div class="col-lg-12">
                    <div class="col-lg-5">
                        <input type="text" name="hour_credit" class="form-control" id="hour_credit">
                        <span><i>Hours</i></span>
                    </div>

                    <div class="col-lg-7">
                        <select name="minute_credit" class="form-control" id="minute_credit">
                            <option value="">-Select-</option>
                            <?php
                            for ($i = 15; $i <= 60; $i += 15) {
                                ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>

                        </select>
                        <span><i>Minutes</i></span>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-default" id="addCredit">Add Credit</button>
            </div>
        </div>
    </div>
</div>
<!-- Add Credit Modal end -->


<!-- Subtract Credit Modal start -->
<div class="modal fade" id="subtract_credit_modal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Subtract Credit <i class="fa fa-minus-circle"></i></h4>
            </div>
            <div class="modal-body">
                <!--<p>Subtract Credits </p>-->
                <div class="col-lg-12">
                    <div class="col-lg-5">
                        <input type="text" name="hour_credit" class="form-control" id="hourCredit">
                        <span><i>Hours</i></span>
                    </div>

                    <div class="col-lg-7">
                        <select name="minute_credit" class="form-control" id="minuteCredit">
                            <option value="">-Select-</option>
                            <?php
                            for ($i = 15; $i <= 60; $i += 15) {
                                ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>

                        </select>
                        <span><i>Minutes</i></span>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-default" id="subCredit">Subtract Credit</button>
            </div>
        </div>
    </div>
</div>
<!-- Subtract Credit Modal end -->

<script>
    $('body').on('change', '.stu_Select', function () {
        var stu_id = $(this).val();
        if (stu_id != '') {
            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'webadmin/teacher/gt_sub'; ?>',
                data: {stu_id: stu_id},
                success: function (data) {
                    $('#subjects').html(data);
                }
            });
        }
    });</script>


<!--modal for schedule lesson-->
<div class="modal fade" id="ScheduleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeIcon"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Schedule Lesson</h4>
            </div>
            <div class="modal-body">

                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        Student Name
                    </div>
                    <div class="col-lg-9">
                        <select class="form-control stu_Select" id="student">
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
                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        Subject
                    </div>
                    <div class="col-lg-9">
                        <select class="form-control" id="subjects">
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
                                <span class="input-group-addon" id="start_time">
                                    <span class="glyphicon glyphicon-time" ></span>
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
                                <span class="input-group-addon" id="end_time">
                                    <span class="glyphicon glyphicon-time" ></span>
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
                <input type ="hidden" value="<?php echo @$_SESSION['teacher_id']; ?>" id="teacherId">
            </div> 
            <div class="clearfix"></div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="monthModalClose">Close</button>
                <button type="button" class="btn btn-primary saveBtn" id="SchedulingLesson">Schedule</button>

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
                <input type="hidden" id="teacher_id" value="<?php echo $this->Session->read('teacher_id'); ?>">

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary saveBtn" id="UpdateSchedule">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!--modal for Success No-->
<div class="modal fade" id="SuccessNo" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color:#FF0000;">ALERT <i class="fa fa-bell-o"></i></h4>
            </div>
            <div class="modal-body">
                <p style="color:#FF0000;">You can't Mark the lesson as complete before the schedule time.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!--modal for delete-->
<div class="modal fade" id="DeleteModal" role="dialog">

</div>


<style>
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
    #start_time{
        cursor: pointer;
    }
    #end_time{
        cursor: pointer;
    }
    #Edit_start{
        cursor: pointer;
    }
    #Edit_end{
        cursor: pointer;
    }
</style>

<!--select subject on change script-->
<script>
    $('#select_sub').on('change', function () {
        var sub_id = $(this).val();
        $.ajax({
            type: 'POST',
            url: '<?php echo BASE_URL . 'webadmin/student/ajax_get_duration'; ?>',
            data: {sub_id: sub_id},
            success: function (data) {
                $(".duration").html(data);
                $('.duration').addClass('updatePrice');
                $('.duration').val('');
                $('.pack').val('');
                $(".quantity").val('');
                $('.totalAmount').html('');
                $('.DiscountValue').html('');
                $('.AfterDiscountAmount').html('');
            }
        });
    });</script>
<!--ends-->

<!--toggle script-->
<script>
    $(document).ready(function () {
        $('body').on('click', '.action', function () {
            if ($(this).next().css('display') == 'block') {
                $('.hide1').css('display', 'none');
            } else {
                $('.action-list').css('display', 'none');
                $(this).next().css('display', 'block');
            }
        });
        $(document).mouseup(function (e)
        {
            var container = $(".AllActions");
            if (!container.is(e.target)
                    && container.has(e.target).length === 0) {
                $('.hide1').css('display', 'none');
            }
        });
    });</script>

<!--toggle script ends-->

<script>
    $('body').on('click', '#assigning_teacher', function () {
        var student_id = $(this).attr('student_id');
        if (student_id != '') {
            $('#student_id').val(student_id);
            $('#TeacherAssign').modal('show');
            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'webadmin/student/finding_subject'; ?>',
                data: {student_id: student_id},
                success: function (data) {
                    $('.showingSubjects').append(data);
                }
            });
        }
    });</script>


<script>
    $('body').on('change', '#subject', function () {
        var subject = $(this).val();
        $.ajax({
            type: 'post',
            url: '<?php echo BASE_URL . 'webadmin/student/get_teachers'; ?>',
            data: {subject: subject},
            success: function (data) {
                $('#teacher').html(data);
            }
        });
    });
    $('body').on('click', '#assignTeacher', function () {
        var student_id = $('#student_id').val();
        var subject_id = $('#subject').val();
        var special_rate = $('#special_rate').val();
        var teacher_info_id = $('#teacher').val();
        var lesson_duration = $('#lesson_duration').val();
        $.ajax({
            type: 'post',
            url: '<?php echo BASE_URL . 'webadmin/student/assign_teacher'; ?>',
            dataType: 'json',
            data: {student_id: student_id, subject_id: subject_id, teacher_info_id: teacher_info_id, special_rate: special_rate, lesson_duration: lesson_duration},
            success: function (data) {
                if (data.status == 'success') {
                    window.location.href = '<?php echo BASE_URL . 'webadmin/student'; ?>';
                    alert('Teacher assigned successfully.');
                } else if (data.status == 'failure') {
                    alert('Please select Subject & Teacher.');
                }
            }
        });
    });</script>


<!--modal for assign teacher-->
<div class="modal fade" id="TeacherAssign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeIcon"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus"></i> &nbsp; Assign Teacher</h4>
            </div>
            <div class="modal-body">

                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        Subject
                    </div>
                    <div class="col-lg-9">
                        <select class="form-control showingSubjects" id="subject">

                        </select>  
                    </div>
                </div>

                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        Teacher
                    </div>
                    <div class="col-lg-9">
                        <select class="form-control" id="teacher">
                            <option value="">--Select--</option> 
                        </select>  
                    </div>
                </div>

                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        Additional Rate 
                    </div>
                    <div class="col-lg-9">
                        <div class="input-group m-bot15">
                            <span class="input-group-addon btn-white"><i class="fa fa-dollar"></i></span>
                            <input type="text" id="special_rate" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        Lesson Duration
                    </div>
                    <div class="col-lg-9">
                        <div class="input-group m-bot15">

                            <input type="text" id="lesson_duration" class="form-control">
                            <span><i>(Please add duration in minutes only.)</i></span>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="student_id" >

            </div> 
            <div class="clearfix"></div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
                <button type="button" class="btn btn-primary saveBtn" id="assignTeacher">Assign</button>

            </div>
        </div>
    </div>

</div>
<!--modal for assign teacher ends-->

<script>
    $('body').on('change', '#edit_billing_address', function () {
        var bill_add = $(this).val();
        var client_id = $('#client_id').val();
        if (bill_add == 'different') {
            $('#open_bill_add').modal('show');
            $('#StuId').val(client_id);
            $(".ForModal").css("z-index", "99999");
            $(".forZIndex").css("z-index", "-1");
        }
    });</script>

<!--new card script-->
<script>
    $('body').on('click', '#new_card_details', function () {
        var id = $('#student_id').val();
        $('#client_id').val(id);
        $('#Card_details').modal('show');
    });
    $('body').on('click', '#add_card_details', function () {
        var student_id = $('#client_id').val();
        var name_on_card = $('#name_on_card').val();
        var card_number = $('#card_number').val();
        var card_type = $('#card_type').val();
        var cvv = $('#cvv').val();
        var month = $('#month').val();
        var year = $('#year').val();
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var bill_add = $('#edit_billing_address').val();
        $.ajax({
            type: 'post',
            url: '<?php echo BASE_URL . 'webadmin/student/add_credit_card' ?>',
            dataType: 'json',
            data: {student_id: student_id, name_on_card: name_on_card, card_number: card_number, card_type: card_type, cvv: cvv, month: month, year: year, first_name: first_name, last_name: last_name, bill_add: bill_add},
            success: function (data) {
                if (data.status == 'success') {
                    var student_id = data.student_id;
                    $('#Card_details').modal('hide');
                    window.location.href = '<?php echo BASE_URL . 'webadmin/student/make_a_payment/'; ?>' + student_id;
                    alert('Credit Card added successfully.');
                } else if (data.status == 'failure') {
                    alert('All fields are required');
                }
            }
        });
    });</script>
<!--new card script ends-->

<!--new card details modal-->
<div class="modal fade forZIndex" id="Card_details" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeIcon"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Card Details &nbsp;&nbsp;<img src="<?php echo $this->webroot . 'img/creditcards.png'; ?>" style="width:50%;"></h4>
            </div>
            <div class="modal-body">

                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        Name On Card <span class="asterick">*</span>
                    </div>
                    <div class="col-lg-9">
                        <?php echo $this->Form->input('name_on_card', array('class' => 'form-control', 'id' => 'name_on_card', 'label' => FALSE)); ?>
                    </div>
                </div>

                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        Card Number<span class="asterick">*</span>
                    </div>
                    <div class="col-lg-9">
                        <?php echo $this->Form->input('card_number', array('class' => 'form-control', 'id' => 'card_number', 'label' => FALSE)); ?>
                    </div>
                </div>

                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        Card Type<span class="asterick">*</span>
                    </div>
                    <div class="col-lg-9">
                        <?php
                        $card_type = array('American Express' => 'American Express', 'Discover' => 'Discover', 'Visa' => 'Visa', 'Master Card' => 'Master Card', 'JCB' => 'JCB', 'Diners Club' => 'Diners Club');
                        echo $this->Form->input('card_type', array('class' => 'form-control', 'id' => 'card_type', 'label' => FALSE, 'type' => 'select', 'options' => $card_type, 'empty' => '-Select-'));
                        ?>
                    </div>
                </div>

                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        Cvv<span class="asterick">*</span>
                    </div>
                    <div class="col-lg-9">
                        <?php echo $this->Form->input('cvv', array('class' => 'form-control', 'id' => 'cvv', 'label' => FALSE)); ?>
                    </div>
                </div>  

                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        Expiry Date<span class="asterick">*</span>
                    </div>
                    <div class="col-lg-5">
                        <?php
                        $months = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
                        echo $this->Form->input('month', array('class' => 'form-control', 'id' => 'month', 'label' => FALSE, 'type' => 'select', 'empty' => '-Select-', 'options' => $months));
                        ?>
                    </div>
                    <div class="col-lg-4">
                        <?php
                        for ($year = 2016; $year <= 2050; $year++) {
                            $years[$year] = $year;
                        }
                        echo $this->Form->input('year', array('class' => 'form-control', 'id' => 'year', 'label' => FALSE, 'type' => 'select', 'empty' => '-Select-', 'options' => $years));
                        ?>
                    </div>
                </div> 

                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        First Name<span class="asterick">*</span>
                    </div>
                    <div class="col-lg-9">
                        <?php echo $this->Form->input('first_name', array('class' => 'form-control', 'id' => 'first_name', 'label' => FALSE)); ?>
                    </div>
                </div>


                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        Last Name<span class="asterick">*</span>
                    </div>
                    <div class="col-lg-9">
                        <?php echo $this->Form->input('last_name', array('class' => 'form-control', 'id' => 'last_name', 'label' => FALSE)); ?>
                    </div>
                </div> 

                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        Billing Address<span class="asterick">*</span>
                    </div>
                    <div class="col-lg-9">
                        <?php
                        echo $this->Form->input('billing_address', array('class' => 'form-control', 'label' => FALSE, 'type' => 'select', 'options' => array('same' => 'Same as Home Address', 'different' => 'Different Address'), 'empty' => '-Select Billing Address-', 'id' => 'edit_billing_address'));
                        ?>
                    </div>
                </div> 



                <input type="hidden" id="client_id" >
            </div> 
            <div class="clearfix"></div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
                <button type="button" class="btn btn-primary saveBtn" id="add_card_details"><i class="fa fa-plus-circle"></i>&nbsp;Card Details</button>

            </div>
        </div>
    </div>

</div>
<!--new card details modal-->

<!--Billing address modal-->
<div class="modal fade ForModal" id="open_bill_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <input type="hidden" id="StuId">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeIcon"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Billing Address</h4>
            </div>
            <div class="modal-body">

                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        Address&nbsp;<span class="asterick">*</span>
                    </div>
                    <div class="col-lg-9">
                        <input type="text" class="form-control edit_address">
                    </div>
                </div>

                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        Apartment/Suite
                    </div>
                    <div class="col-lg-9">
                        <input type="text"  class="form-control edit_apartment" >
                    </div>
                </div>

                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        City&nbsp;<span class="asterick">*</span>
                    </div>
                    <div class="col-lg-9">
                        <input type="text"  class="form-control edit_city">
                    </div>
                </div>


                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        State&nbsp;<span class="asterick">*</span>
                    </div>
                    <div class="col-lg-9">
                        <input type="text"  class="form-control edit_state">
                    </div>
                </div>


                <div class="col-md-12 form-group">
                    <div class="col-lg-3">
                        Zip Code&nbsp;<span class="asterick">*</span>
                    </div>
                    <div class="col-lg-9">
                        <input type="text"  class="form-control edit_zip_code">
                    </div>
                </div>
            </div> 
            <div class="clearfix"></div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary saveBtn" id="editBillingAddress">Add</button>

            </div>
        </div>
    </div>

</div>
<!--Billing address modal-->


<script>
    $('body').on('click', '#editBillingAddress', function () {
        var student_id = $('#StuId').val();
        var address = $('.edit_address').val();
        var apt = $('.edit_apartment').val();
        var city = $('.edit_city').val();
        var state = $('.edit_state').val();
        var zip = $('.edit_zip_code').val();
        if ((address == '') || (city == '') || (state == '') || (zip == '')) {
            alert('Fields marked wth * are required.');
        } else {
            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'webadmin/student/addDiffBillAddress'; ?>',
                dataType: 'json',
                data: {student_id: student_id, address: address, apt: apt, city: city, state: state, zip: zip},
                success: function (data) {
                    if (data.status == 'suc') {
                        $('#open_bill_add').modal('hide');
                        $(".forZIndex").css("z-index", "99999");
                        $(".ForModal").css("z-index", "-1");
                    }
                }
            });
        }
    });</script>

<script>
    $('body').on('click', '#update_assigned_teacher', function () {
        var id = $(this).attr('assigned_id');
        var specl_amt = $('.specl_amt').val();
        var special_sub = $('.special_sub').val();
        var lesson_dur = $('.lesson_dur1').val();
        if ((lesson_dur != '-') || (specl_amt != '-')) {
            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'webadmin/student/update_assigned_teacher'; ?>',
                dataType: 'json',
                data: {id: id, specl_amt: specl_amt, special_sub: special_sub, lesson_dur: lesson_dur},
                success: function (data) {
                    if (data.status == 'suc') {
                        alert('Assigned Teacher updated successfully.');
                    }
                }
            });
        } else {
            alert('Please add Amount to update Additional Rate.');
        }
    });</script>


<!--manage teachers script-->
<script>
    $('body').on('click', '#manage_teachers', function () {
        $('#allTeachers').modal('show');
        var student_id = $(this).attr('student_id');
        $.ajax({
            type: 'post',
            url: '<?php echo BASE_URL . 'webadmin/student/manage_teachers'; ?>',
            data: {student_id: student_id},
            success: function (data) {
                $('#show_teachers').html(data);
            }
        });
    });</script>
<!--manage teachers script end-->

<!--delete_assigned_teacher script -->
<script>
    $('body').on('click', '#delete_assigned_teacher', function () {
        var assigned_id = $(this).attr('assigned_id');
        var cnfrm = confirm("Are you sure you want to delete? ");
        if (cnfrm == true) {
            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'webadmin/student/delete_assigned_teacher'; ?>',
                dataType: 'json',
                data: {assigned_id: assigned_id},
                success: function (data) {
                    if (data.status == 'suc') {
                        $('#allTeachers').modal('hide');
                        alert('Assigned Teacher removed successfully.');
                    }
                }
            });
        }
    });</script>
<!--delete_assigned_teacher script end -->

<!--manage teacher modal--> 
<div class="modal fade" id="allTeachers">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title"><i class="fa fa-users"></i> &nbsp;Manage Teachers</h3>
            </div>
            <div class="modal-body" id="show_teachers">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<!--manage teacher modal ends--> 

<!--billing address-->
<script>
    $('body').on('change', '#billing_address', function () {
        var address = $(this).val();
        if (address == 'same') {

        } else if (address == 'different') {
            $('#BillAddress').modal('show');
        }
    });
    $('body').on('click', '#addBillingAddress', function () {
        var address = $('.address_suite').val();
        var apartment = $('.apartment').val();
        var city = $('.city').val();
        var state = $('.state').val();
        var zip_code = $('.zip_code').val();
        if ((address == '') || (city == '') || (state == '') || (zip_code == '')) {
            alert('All fields marked with * are required');
        } else {
            $('#BillAddress').modal('hide');
        }
    });</script>
<!--billing address-->

<!--manage client cards script-->
<script>
    $('body').on('click', '#manage_cards', function () {
        var client_id = $(this).attr('student_id');
        $('#manage_Client_cards').modal('show');
        $.ajax({
            type: 'post',
            url: '<?php echo BASE_URL . 'webadmin/student/manage_cards'; ?>',
            data: {client_id: client_id},
            success: function (data) {
                $('#show_card').html(data);
            }
        });
    });</script>
<!--manage client cards script-->

<!--manage client cards-->
<div class="modal fade" id="manage_Client_cards">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title"><i class="fa fa-credit-card"></i> &nbsp;Manage Cards</h3>
            </div>
            <div class="modal-body" id="show_card">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<!--manage client cards-->

<!--Delete card detail script-->
<script>
    $('body').on('click', '#delete_added_card', function () {
        var card_id = $(this).attr('card_id');
        var cnfrm = confirm("Are you sure you want to delete? ");
        if (cnfrm == true) {
            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'webadmin/student/delete_add_card'; ?>',
                dataType: 'json',
                data: {card_id: card_id},
                success: function (data) {
                    if (data.status == 'del') {
                        alert('Card deleted successfully!');
                        $('#manage_Client_cards').modal('hide');
                    }
                }
            });
        }
    });</script>
<!--Detail card detail script-->

<!--show update modal-->
<script>
    $('body').on('click', '#edit_added_card', function () {
        var card_id = $(this).attr('card_id');
        $('#studentID').val(card_id);
        $('#edit_card_modal').modal('show');
        $.ajax({
            type: 'post',
            url: '<?php echo BASE_URL . 'webadmin/student/get_card_details'; ?>',
            data: {card_id: card_id},
            success: function (data) {
                $('#show_details').html(data);
            }
        });
    });</script>
<!--show update modal-->

<!--update/edit card modal-->
<div class="modal fade forZIndex" id="edit_card_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeIcon"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Card Details &nbsp;&nbsp;<img src="<?php echo $this->webroot . 'img/creditcards.png'; ?>" style="width:50%;"></h4>
            </div>
            <div class="modal-body" id="show_details">
            </div> 
            <input type="hidden" id="studentID">
            <div class="clearfix"></div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
                <button type="button" class="btn btn-primary saveBtn" id="edit_card_details"><i class="fa fa-edit"></i>&nbsp;Card Details</button>

            </div>
        </div>
    </div>
</div>
<!--update/edit card modal ends-->

<!--update card details script-->
<script>
    $('body').on('click', '#edit_card_details', function () {
        var payment_id = $('#studentID').val();
        var name_on_card = $('#edit_name_on_card').val();
        var card_number = $('#edit_card_number').val();
        var card_type = $('#edit_card_type').val();
        var cvv = $('#edit_cvv').val();
        var month = $('#edit_month').val();
        var year = $('#edit_year').val();
        var first_name = $('#edit_first_name').val();
        var last_name = $('#edit_last_name').val();
        var address = $('#edit_address').val();
        var apt = $('#edit_apt').val();
        var city = $('#edit_city').val();
        var state = $('#edit_state').val();
        var zip_code = $('#edit_zip_code').val();
        if ((name_on_card == '') || (card_number == '') || (card_type == '') || (cvv == '') || (month == '') || (year == '') || (first_name == '') || (last_name == '') || (address == '') || (city == '') || (state == '') || (zip_code == '')) {
            alert('Fields marked with * are required.');
        } else {
            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'webadmin/student/edit_card_details'; ?>',
                dataType: 'json',
                data: {payment_id: payment_id, name_on_card: name_on_card, card_number: card_number, card_type: card_type, cvv: cvv, month: month, year: year, first_name: first_name, last_name: last_name, address: address, apt: apt, city: city, state: state, zip_code: zip_code},
                success: function (data) {
                    if (data.status == 'success') {
                        $('#edit_card_modal').modal('hide');
                        alert('Card Details updated successfully.');
                    } else if(data.status == 'failure') {
                        alert('Card validation error: ' + data.message);
                    }
                }
            });
        }
    });</script>
<!--update card details script ends-->

<script>
    $('body').on('change', '#get_pack', function () {
        var price_id = $(this).val();
        if (price_id != '') {
            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'webadmin/student/get_pack_price'; ?>',
                dataType: 'json',
                data: {price_id: price_id},
                success: function (data) {
                    if (data.status == 'success') {
                        $('.show_amt').val(data.price);
                    }
                }
            });
        }
    });</script>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASbigdwTxJcSjYocQYPyjG4gG7wsfWLq8&v=3.exp&sensor=false&libraries=places"></script>
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
<script>
    var placeSearch, autocomplete;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };
    function initialize() {
        autocomplete = new google.maps.places.Autocomplete(
                (document.getElementById('autocomplete1')),
                {types: ['geocode']});
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            fillInAddress1();
        });
        autocomplete1 = new google.maps.places.Autocomplete(
                (document.getElementById('autocomplete2')),
                {types: ['geocode']});
        google.maps.event.addListener(autocomplete1, 'place_changed', function () {
            fillInAddress2();
        });
    }

    function fillInAddress1() {
        var activityLocation = $("#autocomplete1").val();
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': activityLocation}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK)
            {
                $.each(results[0].address_components, function (ckey, value) {
                    $.each(results[0].address_components[ckey].types, function (inkey, value1) {
//                        if (results[0].address_components[ckey].types[inkey] == "street_number") {
//                            street_number = results[0].address_components[ckey].long_name;
//                            $("#street_number").val(street_number);
//
//                        }
                        if (results[0].address_components[ckey].types[inkey] == "locality") {
                            city = results[0].address_components[ckey].long_name;
                            $("#locality").val(city);
                        }
                        if (results[0].address_components[ckey].types[inkey] == "administrative_area_level_1") {
                            state = results[0].address_components[ckey].short_name;
                            $("#administrative_area_level_1").val(state);
                        }
//                        console.log(results);

                        if (results[0].address_components[ckey].types[inkey] == "postal_code") {
                            zip = results[0].address_components[ckey].short_name;
                            $("#postal_code").val(zip);
                        }
                    });
                });
                var lat = results[0].geometry.location.lat();
                var lng = results[0].geometry.location.lng();
                $('#latitude').val(lat);
                $('#longitude').val(lng);
            } else
            {
                lat = '';
                lng = '';
                $("#map-canvas").removeClass('map-canvas');
                $('#maperror').show();
                $("#maperror").html('<font color="red" >Please enter a valid address.</font>');
                return false;
            }
        });
    }

    function fillInAddress2() {
        var activityLocation = $("#autocomplete2").val();
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': activityLocation}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK)
            {
                $.each(results[0].address_components, function (ckey, value) {
                    $.each(results[0].address_components[ckey].types, function (inkey, value1) {
                        if (results[0].address_components[ckey].types[inkey] == "locality") {
                            city = results[0].address_components[ckey].long_name;
                            $("#teacher_city").val(city);
                        }
                        if (results[0].address_components[ckey].types[inkey] == "administrative_area_level_1") {
                            state = results[0].address_components[ckey].short_name;
                            $("#teacher_state").val(state);
                        }
                        if (results[0].address_components[ckey].types[inkey] == "postal_code") {
                            zip = results[0].address_components[ckey].short_name;
                            $("#teacher_zip").val(zip);
                        }
                    });
                });
                var lat = results[0].geometry.location.lat();
                var lng = results[0].geometry.location.lng();
                $('#latitude1').val(lat);
                $('#longitude1').val(lng);
            } else
            {
                lat = '';
                lng = '';
                $("#map-canvas").removeClass('map-canvas');
                $('#maperror').show();
                $("#maperror").html('<font color="red" >Please enter a valid address.</font>');
                return false;
            }
        });
    }

</script>
<script>
    $('body').on('click', '.showViolinCredit', function () {
        var clicked_vlu = $(this).val();
        if (clicked_vlu == 'Yes') {
            $('#showingViolinCredit').show();
        } else if (clicked_vlu == 'No') {
            $('#showingViolinCredit').hide();
        }
    });</script>


<script>
    $(document).ready(function () {
        $('#add_voilin_credit').on('click', function () {
            $('#add_voilin_credit_modal').modal('show');
        });
        $('#addVoilinCredit').on('click', function () {
            var student_id = $('.student_id').val();
            var voilin_hour = $('#voilin_hour_credit').val();
            var voilin_minutes = $('#voilin_minute_credit').val();
            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'webadmin/student/add_voilin'; ?>',
                dataType: 'json',
                data: {student_id: student_id, voilin_hour: voilin_hour, voilin_minutes: voilin_minutes},
                success: function (data) {
                    hour = data.voilin_hours;
                    minutes = data.voilin_minutes;
                    $('#voilinHours').val(hour);
                    $('#voilinMinutes').val(minutes);
                    $('#voilin_hour_credit').val('');
                    $('#voilin_minute_credit').val('');
                    $('#add_voilin_credit_modal').modal('hide');
                }
            });
        });
        $('#subtract_voilin_credit').on('click', function () {
            $('#subtract_voilin_modal').modal('show');
        });
        $('#subVoilinCredit').on('click', function () {
            var student_id = $('.student_id').val();
            var voilinHour = $('#hourVoilin').val();
            var voilinMinutes = $('#minuteVoilin').val();
            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'webadmin/student/subtract_voilin_credit'; ?>',
                dataType: 'json',
                data: {student_id: student_id, voilinHour: voilinHour, voilinMinutes: voilinMinutes},
                success: function (data) {
                    if (data.status == 'convertedTime') {
                        var hours = data.hours;
                        var minutes = data.minutes;
                        $('#voilinHours').val(hours);
                        $('#voilinMinutes').val(minutes);
                        $('#hourVoilin').val('');
                        $('#minuteVoilin').val('');
                        $('#subtract_voilin_modal').modal('hide');
                    } else if (data.status == 'hour') {
                        var left_hours = data.left_hours;
                        $('#voilinHours').val(left_hours);
                        $('#hourVoilin').val('');
                        $('#minuteVoilin').val('');
                        $('#subtract_voilin_modal').modal('hide');
                    } else if (data.status == 'ConvertedMinute') {
                        var minutes = data.minutes;
                        var hours = data.hours;
                        $('#voilinHours').val(hours);
                        $('#voilinMinutes').val(minutes);
                        $('#hourVoilin').val('');
                        $('#minuteVoilin').val('');
                        $('#subtract_voilin_modal').modal('hide');
                    } else if (data.status == 'no') {

                    }
                }
            });
        });
    });</script>


<!-- Add Credit Modal start -->
<div class="modal fade" id="add_voilin_credit_modal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Violin Credit <i class="fa fa-plus-circle"></i></h4>
            </div>
            <div class="modal-body">
                <!--<p>Add Credits </p>-->
                <div class="col-lg-12">
                    <div class="col-lg-5">
                        <input type="text"  class="form-control" id="voilin_hour_credit">
                        <span><i>Hours</i></span>
                    </div>

                    <div class="col-lg-7">
                        <select class="form-control" id="voilin_minute_credit">
                            <option value="">-Select-</option>
                            <?php
                            for ($i = 15; $i <= 60; $i += 15) {
                                ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>

                        </select>
                        <span><i>Minutes</i></span>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-default" id="addVoilinCredit">Add Credit</button>
            </div>
        </div>
    </div>
</div>
<!-- Add Credit Modal end -->


<!-- Subtract Credit Modal start -->
<div class="modal fade" id="subtract_voilin_modal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Subtract Credit <i class="fa fa-minus-circle"></i></h4>
            </div>
            <div class="modal-body">
                <!--<p>Subtract Credits </p>-->
                <div class="col-lg-12">
                    <div class="col-lg-5">
                        <input type="text" name="hour_credit" class="form-control" id="hourVoilin">
                        <span><i>Hours</i></span>
                    </div>

                    <div class="col-lg-7">
                        <select name="minute_credit" class="form-control" id="minuteVoilin">
                            <option value="">-Select-</option>
                            <?php
                            for ($i = 15; $i <= 60; $i += 15) {
                                ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>

                        </select>
                        <span><i>Minutes</i></span>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-default" id="subVoilinCredit">Subtract Credit</button>
            </div>
        </div>
    </div>
</div>
<!-- Subtract Credit Modal end -->


<script>
    $('body').on('change', '#select_sub', function () {
        var student_id = $('#student_id').val();
        var subject = $(this).val();
        if (subject != '') {
            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'webadmin/student/show_pack'; ?>',
                data: {student_id: student_id, subject: subject},
                success: function (data) {
                    $('#get_pack').html(data);
                }
            });
        }
    });</script>


<script>
    $('body').on('click', '.EditAmount', function () {
        $('#UpdateTeacherEarning').modal('show');
    });
    $('body').on('click', '#updteEarning', function () {
        var BASE_URL = '<?php echo BASE_URL; ?>';
        var teacher_id = $('#teacher_id').val();
        var totalEarning = $('#totalEarning').val();
        if (totalEarning != '') {
            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'webadmin/teacher/update_earnings'; ?>',
                dataType: 'json',
                data: {teacher_id: teacher_id, totalEarning: totalEarning},
                success: function (data) {
                    if (data.status == 'success') {
                        alert('Teacher Earnings updated successfully');
                        window.location.href = BASE_URL + 'webadmin/teacher/pay/' + teacher_id;
                    }
                }
            });
        } else {
            alert('Please enter Earning to update.');
        }
    });</script>

<!-- Update Teacher Earning Modal start -->
<div class="modal fade" id="UpdateTeacherEarning" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Earning <i class="fa fa-dollar"></i></h4>
            </div>
            <div class="modal-body">
                <div class="col-lg-12 form-group">
                    <div class="col-lg-4">
                        Earning<span class="asterick">*</span>
                    </div>
                    <div class="col-lg-8">
                        <div class="input-group m-bot15">
                            <span class="input-group-addon btn-white"><i class="fa fa-dollar"></i></span>
                            <div class="input text">
                                <input type="text" id="totalEarning" value="<?php echo @$earnings['Teacher_earning']['total_earning']; ?>" placeholder="Earnings" class="form-control" name="data[Teacher_earning][total_earning]">
                            </div>                                    </div>
                    </div>
                </div>

            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger" id="updteEarning">Update</button>
            </div>
        </div>
    </div>
</div>
<!-- Update Teacher Earning Modal end -->


<script>
    $(function () {
        $("#from").datepicker({
            onSelect: function (dateStr)
            {
                $("#to").datepicker("option", {minDate: new Date(dateStr)})
            }
        });
        $("#to").datepicker({
        });
    });</script>

<script language="JavaScript">
    $('body').on('click', '#PaymentToTeachers', function () {
        var from = $('#from_payroll').val();
        var to = $('#to_payroll').val();
        var ids = $("#selectedUsers").val();
        var amount = $("#amt_Paid").val();
        if (ids != '') {
            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'webadmin/teacher/pay_all'; ?>',
                data: {ids: ids, amount: amount, from: from, to: to},
                dataType: 'json',
                success: function (data) {
                    if (data.status == 'success') {
                        alert('Payment successful.');
                        window.location.href = '<?php echo BASE_URL . 'webadmin/teacher/payroll'; ?>';
                    } else if (data.status == 'failure') {
                        window.location.href = '<?php echo BASE_URL . 'webadmin/teacher/payroll'; ?>';
                        alert('Payment unsuccessful.');
                    }
                }
            });
        }
    });
// Select All
    $('body').on('click', '#selectAll', function () {
        sum = [];
        usrArr = [];
        if ($(this).is(':checked') == true) {
            $('.userchckbox').prop("checked", true);
            var checkedValues = $('.userchckbox:checked').map(function () {
                usrArr.push($(this).val());
                sum.push($(this).attr("amountShown"));
            }).get();
            usrArr = usrArr.join(',');
            userstr1 = sum.join(',');
            $('#selectedUsers').val(usrArr);
            $("#amt_Paid").val(userstr1);
        } else {
            $('.userchckbox').prop("checked", false);
            $('#selectedUsers').val('');
            $("#amt_Paid").val('');
        }
    });
    //payroll
    $('body').on('change', '.userchckbox', function () {
        usersArr = [];
        sum = [];
        $("input[type=checkbox]:checked").each(function () {
            usersArr.push($(this).val());
            sum.push($(this).attr("amountShown"));
        });
        userstr = usersArr.join(',');
        userstr1 = sum.join(',');
        $("#selectedUsers").val(userstr);
        $('#amt_Paid').val(userstr1);
    });</script>

<script>
    $('body').on('click', '#calculate_amt', function () {
        var start_date = $('#from').val();
        var end_date = $('#to').val();
        var teacher_id = $('#teacher_id').val();
        if(end_date == '') {
            end_date = "<?php echo date("m/d/Y"); ?>";
            $('#to').val(end_date);
        }
        if (start_date != '' && end_date != '') {

            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'webadmin/teacher/get_records'; ?>',
                data: {start_date: start_date, end_date: end_date, teacher_id: teacher_id},
                success: function (data) {
                    $('#show_from').val(start_date);
                    $('#show_to').val(end_date);
                    $('#DefaultData').hide();
                    $('.ShowRecords').html(data);
                }
            });
        } else {
            alert('Please select both the dates.');
        }
    });</script>

<script>
    $('body').on('change', '.Paychckbox', function () {
        teaacherArr = [];
        var sum = 0;
        $("input[type=checkbox]:checked").each(function () {
            teaacherArr.push($(this).val());
            sum += Number($(this).attr("amount"));
            teacherstr = teaacherArr.join(',');
        });
        $("#selectedTeachers").val(teacherstr);
        $('#amt_earned').val(sum);
    });</script>

<script>
    $('body').on('click', '#multipleStudents', function () {
        $('#showMultipleStudent').append("<div class='studentShow'><div class='form-group'><label for='inputEmail1' class='col-lg-3 col-sm-4 control-label'>Student's First Name</label><div class='col-lg-6'><input type='text' placeholder='First Name' class='form-control' name='data[Child_user][firstname][]'></div><input type='button' class='btn btn-info' value='-' id='removeStudents'></div><div class='form-group'><label for='inputEmail1' class='col-lg-3 col-sm-4 control-label'>Student's Last Name</label><div class='col-lg-6'><input type='text' placeholder='Last Name' class='form-control' name='data[Child_user][lastname][]'></div></div><div class='form-group'><label for='inputEmail1' class='col-lg-3 col-sm-4 control-label'>Student's Age</label><div class='col-lg-6'><input type='text' placeholder='Age' class='form-control' name='data[Child_user][age][]'></div></div><div class='form-group'><label for='inputEmail1' class='col-lg-3 col-sm-4 control-label'>Subject</label><div class='col-lg-6'><select  class='form-control' name='data[Child_user][subject][]'><option value=''>-Select-</option><?php
                            if (!empty($all_subjects)) {
                                foreach ($all_subjects as $subject) {
                                    ?><option value='<?php echo $subject['Subject']['subject']; ?>'><?php echo $subject['Subject']['subject']; ?></option><?php
                                }
                            }
                            ?></select></div></div></div>");
    });
    $('body').on('click', '#removeStudents', function () {
        $('#removeStudents').parent().parent().remove();
    });</script>

<script>
    $(function () {
        $("#from_payroll").datepicker({
            onSelect: function (dateStr)
            {
                $("#to_payroll").datepicker("option", {minDate: new Date(dateStr)})
            }
        });
        $("#to_payroll").datepicker({
        });
    });
    $('body').on('click', '#calculate_payroll_amt', function () {

        var from = $('#from_payroll').val();
        var to = $('#to_payroll').val();
        if(to == '') {
            to = "<?php echo date("m/d/Y"); ?>";
            $('#to_payroll').val(to);
        }

        if (from != '' && to != '') {
            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'webadmin/teacher/find_all_lesson'; ?>',
                data: {from: from, to: to},
                beforeSend: function () {
                    $("#loading").show();
                },
                complete: function () {
                    $("#loading").hide();
                },
                success: function (data) {
                    $('#amt_Paid').val('');
                    $('#selectedUsers').val('');
                    $('.defaultRecord').html(data);
                }
            });
        } else if (from == '' || to == '') {
            alert('Please select both the dates.');
        }
    });</script>



<script>
    $('body').on('click', '#editmultipleStudents', function () {
        $('#showEditMultipleStudent').append("<div class='studentShow'><center><h4>New Student Details</h4></center><div class='form-group'><label for='inputEmail1' class='col-lg-2 col-sm-2 control-label'>Student's First Name</label><div class='col-lg-6'><input type='text' placeholder='First Name' class='form-control' name='data[Child_user][firstname][]'></div><input type='button' class='btn btn-info' value='-' id='removeStudents'></div><div class='form-group'><label for='inputEmail1' class='col-lg-2 col-sm-2 control-label'>Student's Last Name</label><div class='col-lg-6'><input type='text' placeholder='Last Name' class='form-control' name='data[Child_user][lastname][]'></div></div><div class='form-group'><label for='inputEmail1' class='col-lg-2 col-sm-2 control-label'>Student's Age</label><div class='col-lg-6'><input type='text' placeholder='Age' class='form-control' name='data[Child_user][age][]'></div></div><div class='form-group'><label for='inputEmail1' class='col-lg-2 col-sm-2 control-label'>Subject</label><div class='col-lg-6'><select  class='form-control' name='data[Child_user][subject][]'><option value=''>-Select-</option><?php
                            if (!empty($all_subjects)) {
                                foreach ($all_subjects as $subject) {
                                    ?><option value='<?php echo $subject['Subject']['subject']; ?>'><?php echo $subject['Subject']['subject']; ?></option><?php
                                }
                            }
                            ?></select></div></div></div>");
    });
    $('body').on('click', '#removeStudents', function () {
        $('#removeStudents').parent().parent.remove();
    });</script>

<script>
    $('body').on('click', '#removeAdditional', function () {
        var ask = confirm('Are you sure?');
        var child_id = $(this).attr('child_id');
        var parent_id = $(this).attr('parent_id');
        if (ask == true) {
            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'webadmin/student/ajax_delete_additional'; ?>',
                data: {child_id: child_id},
                dataType: 'json',
                success: function (data) {
                    if (data.status == 'success') {
                        alert('Additional Student removed.');
                        window.location.href = '<?php echo BASE_URL . 'webadmin/student/edit_student/'; ?>' + parent_id;
                    }
                }
            });
        }
    });</script>

<script>
    $('body').on('click', '#searchButn', function () {
        var search = $('#searchField').val();
        if (search == '') {
            alert('Please enter keyword to search.');
            window.location.href = '<?php echo BASE_URL . 'webadmin/student'; ?>';
        } else if (search != '') {
            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'webadmin/student/ajax_search'; ?>',
                data: {search: search},
                success: function (data) {
                    $('.appendDetails').html(data);
                }
            });
        }
    });</script>

<script>
    $('body').on('click', '#searchTeacher', function () {
        var search = $('#searchFieldTeacher').val();
        if (search == '') {
            alert('Please enter to search.');
            window.location.href = '<?php echo BASE_URL . 'webadmin/teacher'; ?>';
        } else if (search != '') {
            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'webadmin/teacher/ajax_search'; ?>',
                data: {search: search},
                success: function (data) {
                    $('.searchResults').html(data);
                }
            });
        }
    });
</script>

<script>
    $('body').on('change', '.subjectOrder', function () {
        var subject_id = $(this).attr('subject_id');
        var order = $(this).val();

        if ((order != '') && ($.isNumeric(order))) {
            $.ajax({
                type: 'post',
                url: '<?php echo BASE_URL . 'webadmin/subject/order'; ?>',
                data: {subject_id: subject_id, order: order},
                dataType: 'json',
                success: function (data) {
                    if (data.status == 'saved') {
                        //$(this).css('border', '1px solid #e2e2e4');
                        alert('Order saved successfully.');

                    }
                }
            });
        } else {
            alert('Please enter a number for order.');
            //  $(this).css('border', '1px solid red');
        }
    });



    function fnFilterColumn ( i )
    {
        $('.dataTable').dataTable().fnFilter(
            $("#active_filter").children("option:selected").val(),
            i
        );
    }

    $(document).ready(function () {


        $('.dataTable').DataTable({
            "order": [[0, "asc"]]
        });

        $("#active_filter").change( function() { fnFilterColumn( $("#active_filter").data("status-index") ); } );







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