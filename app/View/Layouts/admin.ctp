<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="ThemeBucket">

        <title>Lessons On The Go</title>
        <meta name="description" content="">
        <meta name="keywords" content="">

        <link rel="icon" type="image/png" href="<?php echo $this->webroot . 'img/favicon-32x32.png'; ?>" sizes="32x32" />
        <title>Lessons</title>
        <link href="<?php echo BASE_URL; ?>bs3/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.css" />
	<?php echo $this->Html->css(array('../css/bootstrap-reset.css', 'style_1.css', 'style-responsive.css')); ?>
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>js/data-tables/DT_bootstrap.css" />

    </head>
    <body onload="initialize()" >
        <section id="container">
	    <?php echo $this->element('admin_header'); ?>
	    <?php echo $this->element('admin_sidebar'); ?>
	    <?php echo $this->fetch('content'); ?>
	    
        </section>

        <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="<?php echo $this->webroot; ?>js/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
        <script src="<?php echo $this->webroot; ?>js/jquery.js"></script>
        <script src="<?php echo $this->webroot; ?>bs3/js/bootstrap.min.js"></script>
        <script class="include" type="text/javascript" src="<?php echo $this->webroot; ?>js/jquery.dcjqaccordion.2.7.js"></script>
        <script src="<?php echo $this->webroot; ?>js/jquery.scrollTo.min.js"></script>
        <script src="<?php echo $this->webroot; ?>js/easypiechart/jquery.easypiechart.js"></script>
        <script src="<?php echo $this->webroot; ?>js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
        <script src="<?php echo $this->webroot; ?>js/jquery.nicescroll.js"></script>
        <script src="<?php echo $this->webroot; ?>js/easypiechart/jquery.easypiechart.js"></script>
        <script src="<?php echo $this->webroot; ?>js/sparkline/jquery.sparkline.js"></script>
        <script src="<?php echo $this->webroot; ?>js/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $this->webroot; ?>js/advanced-datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/data-tables/DT_bootstrap.js"></script>
        <script src="<?php echo $this->webroot; ?>js/scripts.js"></script>
        <script src="<?php echo $this->webroot; ?>js/dynamic_table_init.js"></script>


        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/bootstrap-multiselect.css" type="text/css" />
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/bootstrap-multiselect.js"></script>


        <!--fullcalendar-->
        <link href="<?php echo $this->webroot . 'fullcalendar/fullcalendar.css'; ?>" rel="stylesheet" />
        <link href="<?php echo $this->webroot . 'fullcalendar/fullcalendar.print.css'; ?>" rel="stylesheet"  media="print"  />
        <script src="//momentjs.com/downloads/moment.js"></script>
        <script src="<?php echo $this->webroot . 'fullcalendar/fullcalendar.min2.js'; ?>"></script>
        <!--fullcalendar-->
        <link href="<?php echo $this->webroot . 'css/jquery.timepicker.css'; ?>" rel="stylesheet" />
        <script src="<?php echo $this->webroot . 'js/jquery.timepicker.min.js'; ?>" ></script>
        <script src="<?php echo $this->webroot . 'js/select_script.js'; ?>" ></script>
        <style>
            .panel{
                overflow:hidden !important;
            }
        </style>
	<?php echo $this->element('webadmin_script'); ?>
    </body>
</html>

