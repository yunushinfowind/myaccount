<!DOCTYPE html>
<html lang="en">
    <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="keyword" content="">
	<link rel="icon" type="image/png" href="<?php echo $this->webroot . 'img/favicon-32x32.png'; ?>" sizes="32x32" />

	<title>404</title>

	<!-- Bootstrap core CSS -->
	<?php echo $this->Html->css(array('../css/bootstrap-reset.css', 'style_1.css', 'style-responsive.css')); ?>
	<link href="<?php echo BASE_URL; ?>bs3/css/bootstrap.min.css" rel="stylesheet">

	<!--external css-->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.css" />
	<!-- Custom styles for this template -->


	<!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
    </head>




    <body class="body-404">

	<div class="error-head"> </div>

	<div class="container ">

	    <section class="error-wrapper text-center">
		<h1><img src="<?php echo $this->webroot . 'img/404.png'; ?>" alt=""></h1>
		<div class="error-desk">
		    <h2>page not found</h2>
		    <p class="nrml-txt">We Couldn’t Find This Page</p>
		</div>
		<a href="https://lessonsonthego.com/" class="back-btn"><i class="fa fa-home"></i> Back To Home</a>
	    </section>

	</div>
	<style>
	    .error-desk {
		margin-top: 0px;
	    }
	</style>

    </body>
</html>
