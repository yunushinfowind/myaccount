<!doctype html>
<html>
<head>
    <title>CLNDR Demo</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?php echo $this->webroot;?>demo/css/clndr.css">
</head>
<body>
    <div class="container">
        <div class="cal1"></div>
        <div class="cal2">
        <script type="text/template" id="template-calendar">
          
        </script>
        </div>
        <div class="cal3">
        <script type="text/template" id="template-calendar-months">
            
        </script>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
    <script src="<?php echo $this->webroot;?>demo/clndr.js"></script>
    <script src="<?php echo $this->webroot;?>demo/demo.js"></script>
</body>
</html>