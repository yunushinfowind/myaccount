<div class="new_ryt padding-right">
    <div class="right_side profile clearfix">
        <div class="col-md-12">
            <div class="row">
                <input type="hidden" class="viewHidden" value="month">
                <div class="col-md-6 headingLesson">
                    <h1> Schedule Lesson </h1>
                </div>
                <div class="col-md-6 timeLessons">

                    <h2 class="completehours"> 
                        <span> Completed Lessons : </span>&nbsp;

                        <span id="time">
                            <?php
                          //  pr($teacher_earnings);
                            if (empty($teacher_earnings['Teacher_earning']['hour']) && !empty($teacher_earnings['Teacher_earning']['minute'])) {
                                echo '-';
                            }
                            ?>
                        </span>
                        <br/>
                        <span>Amount Earned: </span> &nbsp; 
                        <span id="amount">
                            <?php
                            if (empty($teacher_earnings['Teacher_earning']['total_earning'])) {
                                echo '-';
                            }
                            ?>
                        </span>
                    </h2>

                </div>

            </div>
        </div>

        <div class="clearfix"> </div>
        <?php echo $this->Session->Flash(); ?>
        <!--profile_form start -->
        <div class="col-md-12">
            <?php  //pr($_SESSION); ?>
            <input type="hidden" id='SessUser' value='<?php echo $_SESSION['User']['id']; ?>'>
            <div id='calendar'></div>
        </div>
        <!--profile_form closed --> 
    </div>
</div>
</div>
</div>
<div class="clearfix"></div>
<!--dashboard closed -->

<style>

    .completehours
    {
        font-size: 20px;
        text-align: right;
        color: #2DC4C4;
    }

    .completehours span
    {
        font-size: 15px;
        /*font-style: italic;*/
        color: #000;
    }

    #calendar{
        max-width: 100% !important;
    }
    #time{
        color: #2DC4C4;
    }
    #amount{
        color: #2DC4C4;
    }
</style>