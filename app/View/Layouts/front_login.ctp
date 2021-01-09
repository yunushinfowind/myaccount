<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<link rel="icon" type="image/png" href="<?php echo $this->webroot . 'img/favicon-32x32.png'; ?>" sizes="32x32" />
        <title>Lessons On The Go</title>

        <!-- Bootstrap -->
	<?php echo $this->Html->css(array('bootstrap.css', 'style.css', 'responsive.css')); ?>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.css" />

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
              <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->
    </head>
    <body>
	<?php echo $this->element('login_header'); ?>
	<?php echo $this->fetch('content'); ?>
	<?php echo $this->element('login_footer'); ?>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
        <!-- Include all compiled plugins (below), or include individual files as needed --> 
	<?php echo $this->Html->script('bootstrap.js'); ?>
	
    </body>
</html>