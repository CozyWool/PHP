<?php
session_start();
ob_start();

include_once('pages/functions.php');

if (isset($_COOKIE['username']) && isset($_COOKIE['password']) && isset($_COOKIE['rememberMe'])) {
    login($_COOKIE['username'], $_COOKIE['password'], $_COOKIE['rememberMe']);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>SiteLab1</title>
</head>
<body>

<div class="container">
    <div class="row">
        <header class="col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                <nav class="col-sm-12 col-md-12 col-lg-12">
                    <?php include_once('pages/menu.php') ?>
                </nav>
            </div>
        </header>
    </div>
    <div>
        <?php
        $users = 'pages/users.txt';
        if (file_exists($users)) {
            $file = fopen($users, "r");
            $count = 0;
            while (!feof($file)) {
                fgets($file);
                $count++;
            }
            echo '<h3>Users count: ' . ($count - 1) . '</h3>';
        }
        ?>
    </div>
    <div class="row">
        <section class="col-sm-12 col-md-12 col-lg-12">
            <?php
            if (!empty($_GET['page'])) {
                $page = $_GET['page'];
                switch ($page) {
                    case 1:
                        include_once('pages/addUser.php');
                        break;
                    case 2:
                        include_once('pages/login.php');
                        break;
                    case 3:
                        include_once('pages/showUsers.php');
                        break;
                    case 4:
                        logout();
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
<?php ob_end_flush(); ?>