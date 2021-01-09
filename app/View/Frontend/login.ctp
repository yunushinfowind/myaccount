<!--banner start -->
<div class="banner">
    <div class="container">
        <div class="banner_content clearfix"> 
            <a href="https://lessonsonthego.com/"><img src="<?php echo $this->webroot; ?>img/logo.jpg" class="img-responsive" alt="logo" title="logo"/></a>

            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <div class="menubar">
                            <ul class="list-unstyled list-inline">
                                <li> <a href="https://lessonsonthego.com/"> Home </a> 
				    <ul class="list-unstyled sub-menu">
					<li><a href="https://lessonsonthego.com/pricing/">Pricing Menu</a></li>
					<li><a href="https://lessonsonthego.com/violin-pricing/">Violin Lesson Pricing</a></li>
					<li><a href="https://lessonsonthego.com/testimonials/">Testimonials</a></li>
					<li><a href="https://lessonsonthego.com/faqs/">FAQs</a></li>
					<li><a href="https://lessonsonthego.com/cancellation-policy/">Cancellation Policy</a></li>
					<li><a href="https://lessonsonthego.com/refund-referral-policy/">Refund &amp; Referral Policy</a></li>
					<li><a href="https://lessonsonthego.com/community-resources/">Community Resources</a></li>
                                    </ul>

				</li>
                                <li> <a href="https://lessonsonthego.com/tutors/"> Tutoring </a>
                                    <ul class="list-unstyled sub-menu">
					<li><a href="https://lessonsonthego.com/tutors/english-writing-tutoring/">English & Writing Tutoring</a></li>
					<li><a href="https://lessonsonthego.com/tutors/math-tutoring/">Math Subjects</a></li>
					<li><a href="https://lessonsonthego.com/tutors/science-tutoring/">All Sciences</a></li>
					<li><a href="https://lessonsonthego.com/tutors/history/">History Tutoring</a></li>
					<li><a href="https://lessonsonthego.com/tutors/french-tutoring/">French Lessons</a></li>
					<li><a href="https://lessonsonthego.com/tutors/spanish-lessons/">Spanish Lessons</a></li>
					<li><a href="https://lessonsonthego.com/tutors/">& more!</a></li>
                                    </ul>
                                </li>
                                <li> <a href="https://lessonsonthego.com/music/"> Music </a> 
                                    <ul class="list-unstyled sub-menu">
                                        <li><a href="https://lessonsonthego.com/music/violin-lessons/">Violin Lessons</a></li>
					<li><a href="https://lessonsonthego.com/music/piano-lessons/">Piano Lessons</a></li>
					<li><a href="https://lessonsonthego.com/music/guitar-lessons/">Guitar Lessons</a></li>
					<li><a href="https://lessonsonthego.com/music/drum-lessons/">Drum Lessons</a></li>
					<li><a href="https://lessonsonthego.com/music/voice-lessons/">Voice Lessons</a></li>
					<li><a href="https://lessonsonthego.com/music/cello-lessons/">Cello Lessons</a></li>
					<li><a href="https://lessonsonthego.com/music/music-theory/">Music Theory Lessons</a></li>
					<li><a href="https://lessonsonthego.com/music/song-writing/">Song Writing Lessons</a></li>
					<li><a href="https://lessonsonthego.com/music/">& more!</a></li>
                                    </ul>
                                </li>
                                <li> <a href="https://lessonsonthego.com/recitals/"> Recitals </a> 
                                    <ul class="list-unstyled sub-menu">
					<li><a href="https://lessonsonthego.com/recitals/recital-registration/">Recital Registration</a></li>
					<li><a href="https://lessonsonthego.com/recitals/commonly-asked-recital-questions/">Commonly Asked Recital Questions</a></li>
					<li><a href="https://lessonsonthego.com/recitals/practicing-for-a-recital/">Practicing for a Recital</a></li>
					<li><a href="https://lessonsonthego.com/recitals/recital-etiquette/">Recital Etiquette</a></li>
                                    </ul>
                                </li>
				<li><a href="https://lessonsonthego.com/blog/">Blog</a></li>
                                <li> <a href="https://lessonsonthego.com/contact-us/"> Contact Us! </a> </li>
                            </ul>
                        </div>


                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
	</div></div>
    <?php echo $this->Session->Flash(); ?>
    <div class="col-md-12 col-md-offset-0  col-sm-12 col-xs-12 ">
	<div class="login">
	    <h1> Login </h1>
	    <div class="login_form clearfix">
		<div class="col-md-8 col-md-offset-2">
		    <?php echo $this->Form->create('User', array('url' => array('controller' => 'frontend', 'action' => 'login'))); ?>
		    <div class="form-group">
			<label for="exampleInputEmail1">Email</label>
			<?php echo $this->Form->input('email', array('label' => FALSE, 'class' => 'form-control', 'type' => 'email', 'required' => FALSE, 'id' => 'exampleInputEmail1')); ?>
		    </div>
		    <div class="form-group">
			<label for="exampleInputPassword1">Password</label>
			<?php echo $this->Form->input('password', array('label' => FALSE, 'class' => 'form-control', 'type' => 'password', 'id' => 'exampleInputPassword1')); ?>
		    </div>
		    <div class="checkbox">
			<label>
			    <input type="checkbox">Remember me </label>
		    </div>
		    <p class="text-center">
			<button type="submit" class="btn btn-default loginbtn">Login</button>
		    </p>
		    <a href="<?php echo BASE_URL . 'frontend/forgot_password'; ?>"> Forgot Password?</a>
		    <?php echo $this->Form->end(); ?>                        
		</div>
	    </div>
	</div>
    </div>
    <!--        </div>
	</div>-->
</div>

<!--banner closed -->

<div class="clearfix"> </div>