<div class="new_ryt padding-right">
    <div class="right_side clearfix">
        <div class="col-md-12">
            <h1><?php echo ucfirst($get_teacher['User']['first_name']) . ' ' . ucfirst($get_teacher['User']['last_name']); ?></h1>
        </div>
        <div class="clearfix"> </div>
        <div class="col-md-12 message_detail">
	    <?php
	    if (!empty($messag_thread)) {
		foreach ($messag_thread as $msg) {
		    ?>
		    <div class="col-md-12">
			<div class="<?php
			if ($msg['Message']['send_by'] != $cur_user) {
			    echo 'me_chat';
			} else {
			    echo 'other_chat';
			}
			?>">
			    <p>
				<?php
				if (!empty($msg['Message']['file'])) {

				    $ext = $msg['Message']['file'];
				    $extension = pathinfo($ext, PATHINFO_EXTENSION);

				    $filename = str_replace('_', '', strstr($msg['Message']['file'], '_'));
				    if ($extension == 'pdf') {
					?>
					<img src='<?php echo $this->webroot . 'img/pdf-icon-flourish-md.png'; ?>' class='MessagePic' > 
					<a href='<?php echo $this->webroot . 'document/' . $msg['Message']['file']; ?>' download> <i class='fa fa-download'></i></a>

				    <?php } elseif ($extension == 'jpeg' || $extension == 'jpg' || $extension == 'png' || $extension == 'gif') { ?>
					<img src='<?php echo $this->webroot . 'img/imagedown.png'; ?>' class='MessagePic' > 

					<a href='<?php echo $this->webroot . 'document/' . $msg['Message']['file']; ?>' download> <i class='fa fa-download'></i></a>
				    <?php } elseif ($extension == 'doc' || $extension == 'docx') { ?>
					<img src='<?php echo $this->webroot . 'img/word-icon.jpg'; ?>' class='MessagePic' > 

					<a href='<?php echo $this->webroot . 'document/' . $msg['Message']['file']; ?>' download> <i class='fa fa-download'></i></a>   
				    <?php } elseif ($extension == 'gif') {
					?>
					<img src='<?php echo $this->webroot . 'img/gif-image-icon.png'; ?>' class='MessagePic' > 

					<a href='<?php echo $this->webroot . 'document/' . $msg['Message']['file']; ?>' download> <i class='fa fa-download'></i></a>  
				    <?php } elseif ($extension == 'odt') {
					?>
					<img src='<?php echo $this->webroot . 'img/odt-file-icon.png'; ?>' class='MessagePic' > 

					<a href='<?php echo $this->webroot . 'document/' . $msg['Message']['file']; ?>' download> <i class='fa fa-download'></i></a>  
				    <?php } elseif ($extension == 'pptx' || $extension == 'ppt') {
					?>
					<img src='<?php echo $this->webroot . 'img/pptx-image-icon.png'; ?>' class='MessagePic' > 

					<a href='<?php echo $this->webroot . 'document/' . $msg['Message']['file']; ?>' download> <i class='fa fa-download'></i></a>  
				    <?php } ?>
	    		    <p class="filename"><?php
				    if (strlen($filename) > 7) {
					echo substr($filename, 0, 5) . '...' . substr($msg['Message']['file'], -6);
				    } else {
					echo substr($filename, 0, 7);
				    }
				    ?></p>
			    <?php }
			    ?>  
				<?php echo @$msg['Message']['message']; ?> </p>
			    <p class="date_form"><span> <?php echo date('M d, Y', strtotime($msg['Message']['created'])) ?></span><i><?php
				    $created = strtotime($msg['Message']['created']);
				    $time = time() - $created;
				    $getTime = secondsToTime($time);
				    if (!empty($getTime['d']) && $getTime['d'] != 0) {
					echo $getTime['d'];
					if ($getTime['d'] > 1) {
					    echo ' days ago';
					} else {
					    echo ' day ago';
					}
				    } else if (!empty($getTime['h']) && $getTime['h'] != 0) {
					echo $getTime['h'];
					if ($getTime['h'] > 1) {
					    echo ' hours ago';
					} else {
					    echo ' hour ago';
					}
				    } else if (!empty($getTime['m']) && $getTime['m'] != 0) {
					echo $getTime['m'];
					if ($getTime['m'] > 1) {
					    echo ' minutes ago';
					} else {
					    echo ' minute ago';
					}
				    } else if (!empty($getTime['s']) && $getTime['s'] != 0) {
					echo $getTime['s'];
					if ($getTime['s'] > 1) {
					    echo ' seconds ago';
					} else {
					    echo ' second ago';
					}
				    }
				    ?></i></p>
			</div>
		    </div>
		    <?php
		}
	    } else {
		?>
    	    <div class="col-md-6 col-md-offset-4"><div class="NoMess"><?php echo "No Messages yet!"; ?></div></div>
	    <?php }
	    ?>
            <div class="clearfix"> </div>
	    <?php echo $this->Form->create('Message', array('url' => array('controller' => 'teacher', 'action' => 'message_detail', $this->params['pass'][0]), 'class' => 'profile_form', 'enctype' => 'multipart/form-data')); ?>  
	    <?php echo $this->Form->input('message', array('label' => FALSE, 'id' => 'message', 'class' => 'messageText form-control', 'type' => 'textarea', 'rows' => 3)); ?>
            <div class="btns">
                <div class="photos2 file_up">
                    <div class="fileUpload1 btn btn-primary">
                        <b class="photos111">
                            <img src="<?php echo $this->webroot; ?>img/up_img.png" alt="fileattch">
                            <i> Upload File </i> 
                        </b>
			<?php echo $this->Form->input('file', array('label' => FALSE, 'class' => 'upload', 'type' => 'file', 'id' => 'MessageFile')); ?>
                        <input type='hidden' value='<?php echo $this->params['pass'][0]; ?>' name='data[Message][send_to]' />
                        <input type='hidden' value='<?php echo $cur_user; ?>' name='data[Message][send_by]' />
                    </div>
                </div>
                <button type='submit' class="loginbtn send"> Send </button>
                <div class="showFile" style="margin-left: 10px;margin-top: 6px;"></div>  
            </div>
	    <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
</div>
</div>
<div class="clearfix"></div>

<?php

function secondsToTime($time) {
    $secondsInAMinute = 60;
    $secondsInAnHour = 60 * $secondsInAMinute;
    $secondsInADay = 24 * $secondsInAnHour;
// extract days
    $days = floor($time / $secondsInADay);
// extract hours
    $hourSeconds = $time % $secondsInADay;
    $hours = floor($hourSeconds / $secondsInAnHour);
// extract minutes
    $minuteSeconds = $hourSeconds % $secondsInAnHour;
    $minutes = floor($minuteSeconds / $secondsInAMinute);
// extract the remaining seconds
    $remainingSeconds = $minuteSeconds % $secondsInAMinute;
    $seconds = ceil($remainingSeconds);
// return the final array
    $obj = array(
	'd' => (int) $days,
	'h' => (int) $hours,
	'm' => (int) $minutes,
	's' => (int) $seconds,
    );
    return $obj;
}
?>
<style>
    .NoMess{
        color: red;
        padding:10px 0px;
        font-size: 18px;
        font-weight: bold;
    }
    .MessagePic{
        width: 130px;
        height: 130px;
    }
    .other_chat a {
        float: right;
        /*margin-top: -40px;*/
    }
    .filename {
        color: grey;
        font-size: 13px;
        font-style: italic;
        margin-top: 0;
    }
    .me_chat a {
        float: right;
        /*margin-top: -40px;*/
    }
</style>