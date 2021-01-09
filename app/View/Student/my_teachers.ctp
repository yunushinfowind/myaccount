<style>
    .teacher_profile img {
        height: 150px;
        width: 150px;
    }
    .teacher_profile {
        text-align:center;
        margin-bottom:30px;
    }
    .teacher_profile h4{
        font-weight:600;
    }
    .teacher_profile a{
        color:#5b5a5a;
    }
    .teacher_profile a:focus{
        outline:none;
    }

    .teacher_bio p{  line-height: 28px;}

    .teacher_bio img {
        height: 200px;
        width: 200px;
    }
</style>
<div class="new_ryt padding-right">
    <div class="right_side clearfix">
        <?php echo $this->Session->Flash(); ?>

        <div class="clearfix"> </div>
        <div class="col-md-12">
            <?php
            if (!empty($teacher_info)) {
                foreach ($teacher_info as $teacher) {
                    ?>
                    <div class="col-md-3 teacher_profile">
                        <a href="#" data-toggle="modal" data-target="#myModal<?php echo $teacher['Teacher_information']['id']; ?>">
                            <?php
                            if (empty($teacher['Teacher_information']['image'])) {
                                ?>
                                <img src="<?php echo $this->webroot . 'img/default_user_icon.png'; ?>">
                            <?php } else { ?>
                                <img src="<?php echo $this->webroot . 'img/teacher_images/' . $teacher['Teacher_information']['image']; ?>">
                            <?php } ?>
                            <h4>

                                <?php
                                if ($teacher['User']['first_name']) {
                                    echo ucfirst($teacher['User']['first_name']) . ' ' . ucfirst($teacher['User']['last_name']);
                                }
                                ?>

                            </h4>
                            <h5><a href="<?php echo BASE_URL . 'student/message_detail/' . $teacher['User']['id']; ?>"><i>Message Teacher</i></a></h5>
                        </a>
                    </div>



                    <div class="modal fade teacher_bio" id="myModal<?php echo $teacher['Teacher_information']['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel"><?php echo ucfirst($teacher['User']['first_name']) . ' ' . ucfirst($teacher['User']['last_name']); ?></h4>
                                </div>
                                <div class="modal-body text-center">
                                    <?php
                                    if (isset($teacher['Teacher_information']['image']) && !empty($teacher['Teacher_information']['image'])) {
                                        ?>
                                        <img src="<?php echo $this->webroot . 'img/teacher_images/' . $teacher['Teacher_information']['image']; ?>">
                                    <?php } else { ?>
                                        <img src="<?php echo $this->webroot . 'img/default_user_icon.png'; ?>">
                                    <?php } ?>
                                    <p>
                                        <?php echo $teacher['Teacher_information']['biography']; ?>
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                }
            } else {
                echo "No Teachers";
            }
            ?>
        </div>
    </div>
</div>
</div>
</div>
