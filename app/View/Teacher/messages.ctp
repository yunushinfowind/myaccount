<div class="new_ryt padding-right page-wrap">
    <div class="right_side tchr_msg clearfix">
        <div class="col-sm-12">
            <div class="col-md-6">
                <h1> Messages </h1>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-success" id="create_message"><i class="fa fa-plus"></i> Create a new message</button>

            </div>
        </div>
        <div class="clearfix"> </div>
        <div class="mess_page">
	    <?php
	    if (!empty($all_message)) {
		foreach ($all_message as $message) {
		    if (!empty($message['User']) && isset($message['User'])) {
			?>
	    	    <a href ="<?php echo BASE_URL . 'teacher/message_detail/' . $message['User']['id'] . '#message'; ?>">
	    		<div class="col-md-12">
	    		    <div class="messages <?php
				if (($message['Message']['message_status'] == 'unread') && ($message['Message']['send_by'] != $teacherInfo['User']['id'])) {
				    echo "bg_grey";
				}
				?> clearfix">
				     <?php
				     if (!empty($message['User']['image'])) {
					 ?>
					<img src="<?php echo $this->webroot . 'img/student_images/' . $message['User']['image']; ?>" class="img-circle" />
				    <?php } else { ?>
					<img src="<?php echo $this->webroot . 'img/default_user_icon.png'; ?>" class="img-circle" />
				    <?php } ?>
	    			<h4><?php echo ucfirst($message['User']['first_name']) . ' ' . ucfirst($message['User']['last_name']); ?><?php if ($message['Count'] > 0) { ?><p class="showCount"><?php echo $message['Count']; ?></p><?php } ?><span><?php echo date('h:i a', strtotime($message['Message']['created'])); ?></span></h4>
	    			<p><?php
					if (!empty($message['Message']['file'])) {

					    $ext = $message['Message']['file'];
					    $extension = pathinfo($ext, PATHINFO_EXTENSION);
					    if ($extension == 'pdf') {
						?>
		    			    <img src='<?php echo $this->webroot . 'img/pdf-icon-flourish-md.png'; ?>' class='MessagePic' > 


					    <?php } elseif ($extension == 'jpeg' || $extension == 'jpg' || $extension == 'png' || $extension == 'gif') { ?>
		    			    <img src='<?php echo $this->webroot . 'img/imagedown.png'; ?>' class='MessagePic' > 

					    <?php } elseif ($extension == 'doc' || $extension == 'docx') { ?>
		    			    <img src='<?php echo $this->webroot . 'img/word-icon.jpg'; ?>' class='MessagePic' > 

						<?php
					    }
					}
					?>
					<?php echo @$message['Message']['message']; ?>       
	    			</p>
	    		    </div>
	    		</div>
	    	    </a>
			<?php
		    }
		}
	    } else {
		?>
    	    <div class="col-md-12 ">
    		<div class="NoMess">
			<?php echo "No message."; ?>
    		</div>
    	    </div>
	    <?php }
	    ?>
        </div>
    </div>
</div>
</div>
</div>
<style>
    #create_message {
        background-color: #2dc4c4;
        float: right;
        margin-top: 26px;
        border:#2dc4c4;
    }
    .NoMess {
        color: red;
        font-size: 18px;
        font-weight: bold;
        padding: 10px 0;
    }
    .messages h4 p.showCount {
        border: 1px solid #000;
        border-radius: 44%;
        padding: 4px;
        float: right;
        margin-right: 30px;
        margin-top: 30px;
    }
</style>