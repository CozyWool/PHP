﻿<?php

$db_host = 'localhost';
$db_port = 3306;
$db_name = 'travelagency';
$db_user = 'cozywool';
$db_password = '1';
$db_driver = 'mysql';

$dsn = "$db_driver:host=$db_host;port=$db_port;dbname=$db_name";

function connectDb(): PDO
{
    global $dsn, $db_user, $db_password;
    return new PDO($dsn, $db_user, $db_password);
}