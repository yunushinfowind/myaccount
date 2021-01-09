<!--banner start -->
<div class="banner">
    <div class="container">
        <div class="banner_content clearfix"> <a href="#"> <img src="<?php echo $this->webroot; ?>img/logo.jpg" class="img-responsive" alt="logo" title="logo"/> </a> 


            <nav class="navbar navbar-default">
                <div class="container-fluid"> 
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <div class="menubar">
                            <ul class="list-unstyled list-inline">
                                <li> <a href="#"> Home </a> </li>
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
                    </div>
                    <!-- /.navbar-collapse --> 
                </div>
                <!-- /.container-fluid --> 
            </nav>
            <div class="col-md-12 col-sm-12 col-xs-12 ">
                <div class="pricing">
                    <h1> Pricing </h1>
                    <p> Lessons On The Go does not charge by monthly tuition with miscellaneous registration fees. We keep it simple by offering single or package pricing. Our packages cover any tutoring, language, and music lesson service. Packages also cover the cost of multiple students in a household participating in our services. Please note that packages are not eligible to split into separate payments. <br />
                        *Packages are only eligible for a refund if the client/student is relocating to an area we do not service or if we are unable to provide an instructor of good fit. In the case of relocation, proof of change in residency is required.</p>

                </div>

                <div class="right_side">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">  <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Subject</th>
                                            <th>Duration</th>
                                            <th>Single Pack</th>
                                            <th>Double Pack</th>
                                            <th>4 Pack</th>
                                            <th>8 Pack</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($prices as $key => $price) {
                                            ?>
                                            <tr>
                                                <td><?php echo $price['Subject']['subject']; ?></td>
                                                <td><?php echo $price['Price']['duration']; ?></td>
                                                <td><?php
                                                    if ($price['Price']['pack'] == 'Single Pack') {
                                                        echo '$' . $price['Price']['price'];
                                                    }
                                                    ?></td>
                                                <td><?php
                                                    if ($price['Price']['pack'] == 'Double Pack') {
                                                        echo '$' . $price['Price']['price'];
                                                    }
                                                    ?></td>
                                                <td><?php
                                                    if ($price['Price']['pack'] == '4 Pack') {
                                                        echo '$' . $price['Price']['price'];
                                                    }
                                                    ?></td>
                                                <td><?php
                                                    if ($price['Price']['pack'] == '8 Pack') {
                                                        echo '$' . $price['Price']['price'];
                                                    }
                                                    ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--banner closed -->

<div class="clearfix"> </div>