<?php
session_start();
ob_start();

include_once('pages/functions.php');
include_once('pages/dbConnection.php');

if (isset($_COOKIE['username']) && isset($_COOKIE['password']) && isset($_COOKIE['rememberMe'])) {
    login($_COOKIE['username'], $_COOKIE['password'], $_COOKIE['rememberMe']);
}
$pages = [
    'register' => 'pages/register.php',
    'login' => 'pages/login.php',
    'tours' => 'pages/tours.php',
    'comments' => 'pages/comments.php',
    'admin' => 'pages/admin.php',
    'usersAdmin' => 'pages/usersAdmin.php',
];
$currentPage = !empty($_GET['page']) ? $_GET['page'] : 'tours';
?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <title>Travel agency</title>
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
        <div class="row">
            <section class="col-sm-12 col-md-12 col-lg-12">
                <?php

                switch ($currentPage) {
                    case 'register':
                        include_once($pages['register']);
                        break;
                    case 'login':
                        include_once($pages['login']);
                        break;
                    case 'tours':
                        include_once($pages['tours']);
                        break;
                    case 'comments':
                        include_once($pages['comments']);
                        break;
                    case 'admin':
                        include_once($pages['admin']);
                        break;
                    case 'usersAdmin':
                        include_once($pages['usersAdmin']);
                        break;
                    case 'logout':
                        logout();
                        break;
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