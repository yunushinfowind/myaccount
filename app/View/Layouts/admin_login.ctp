<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="ThemeBucket">
        <title>Lessons On The Go</title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <link rel="shortcut icon" type="image/x-icon" href="">

        <title>Login</title>

        <!--Core CSS -->
        <?php echo $this->Html->css(array('bootstrap.min.css', 'bootstrap-reset.css', 'font-awesome.css', 'style_1.css', 'style-responsive.css')); ?>


        <!-- Just for debugging purposes. Don't actually copy this line! -->
        <!--[if lt IE 9]>
        <script src="js/ie8-responsive-file-warning.js"></script><![endif]-->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="login-body">

        <?php echo $this->fetch('content'); ?>
        <script src="<?php echo $this->webroot; ?>js/jquery.js"></script>


    </body>
</html>
