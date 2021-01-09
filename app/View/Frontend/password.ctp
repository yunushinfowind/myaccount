<!--banner start -->
<div class="banner">
    <div class="container">
        <div class="banner_content clearfix"> <a href="#"> <img src="<?php echo $this->webroot; ?>img/logo.jpg" class="img-responsive" alt="logo" title="logo"/> </a>




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

                </div><!-- /.container-fluid -->
            </nav>

            <div class="col-md-8 col-md-offset-2  col-sm-12 col-xs-12 ">
                <div class="login">
                    <h1>Password</h1>
                    <h5 class="text-center">Choose your new password.</h5>
                    <div class="change_pass clearfix">
                        <div class="col-md-6 col-md-offset-3">
                            <?php echo $this->Form->create('User', array('url' => array('controller' => 'frontend', 'action' => 'password', $this->params['pass'][0]), 'class' => 'form-horizontal')); ?>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Password:</label>
                                <div class="col-sm-9">
                                    <?php echo $this->Form->input('password', array('label' => FALSE, 'class' => 'form-control', 'id' => 'inputEmail3', 'type' => 'password')); ?>
                                </div>
                            </div>

                            <div class="row"> <div class="col-md-12 col-sm-12 col-xs-12">
                                    <button type="submit" class="btn btn-default loginbtn">Set Password</button>
                                    <p>
                                    </p>
                                </div> 
                            </div>
                            <?php echo $this->Form->end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--banner closed -->
<div class="clearfix"> </div>