<!--banner start -->
<div class="banner">
    <div class="container">
        <div class="banner_content clearfix"> 
            <a href="#"><img src="<?php echo $this->webroot; ?>img/logo.jpg" class="img-responsive" alt="logo" title="logo"/></a>

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
                                <li> <a href="<?php echo BASE_URL; ?>"> Home </a> </li>
                                <li> <a href="#"> Tutoring </a>
                                    <ul class="list-unstyled sub-menu">
                                        <li> <a href="#"> English &amp; Writing </a>
                                        <li> <a href="#"> Math Subjects </a>
                                        <li> <a href="#"> All Sciences </a>
                                        <li> <a href="#"> Physics </a>
                                        <li> <a href="#"> History </a>
                                        <li> <a href="#"> Frenchs </a>
                                        <li> <a href="#"> Spanish </a>
                                        <li> <a href="#"> &amp; more! </a>
                                    </ul>
                                </li>
                                <li> <a href="#"> Music </a> 
                                    <ul class="list-unstyled sub-menu">
                                        <li> <a href="#"> Violin Lessons </a>
                                        <li> <a href="#"> Piano Lessons </a>
                                        <li> <a href="#"> Guitar Lessons </a>
                                        <li> <a href="#"> Cello Lessons </a>
                                        <li> <a href="#"> Flute Lessons </a>
                                        <li> <a href="#"> Voice Lessons </a>
                                        <li> <a href="#"> Music Theory </a>
                                        <li> <a href="#"> Song Writing </a>
                                        <li> <a href="#"> &amp; more! </a>
                                    </ul>
                                </li>
                                <li> <a href="#"> Recitals </a> 
                                    <ul class="list-unstyled sub-menu">
                                        <li> <a href="#"> Recital Registration </a>
                                        <li> <a href="#"> Commonly Asked Recital Questions </a>
                                        <li> <a href="#"> Practicing for a Recital </a>
                                        <li> <a href="#"> Recital Etiquette </a>
                                    </ul>
                                </li>
                                <li> <a href="#"> Contact Us! </a> </li>
                            </ul>
                        </div>


                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
            <?php echo $this->Session->Flash(); ?>
            <div class="col-md-6 col-md-offset-3  col-sm-12 col-xs-12 ">
                <div class="login">
                
                </div>
            </div>
        </div>
    </div>
</div>

<!--banner closed -->

<div class="clearfix"> </div>