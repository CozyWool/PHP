<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>Site1</title>
</head>
<body>

<div class="container">
    <div class="row">
        <header class="col-sm-12 col-md-12 col-lg-12">
        </header>
    </div>
    <div class="row">
        <nav class="col-sm-12 col-md-12 col-lg-12">
            <?php include_once('pages/menu.php') ?>
            <?php include_once('pages/functions.php') ?>
        </nav>
    </div>
    <div class="row">
        <section class="col-sm-12 col-md-12 col-lg-12">
            <?php
                if(!empty($_GET['page'])){
                    $page = $_GET['page'];
                    switch ($page) {
                        case 1:
                            include_once('pages/home.php');
                            break;
                        case 2:
                            include_once('pages/upload.php');
                            break;
                        case 3:
                            include_once('pages/gallery.php');
                            break;
                        case 4:
                            include_once('pages/registration.php');
                            break;
                    }
                }
            ?>
        </section>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>