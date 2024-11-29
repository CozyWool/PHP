<?php

$db_host = 'localhost';
$db_port = 5432;
$db_name = 'PhpSite2';
$db_user = 'postgres';
$db_password = '1';
$db_driver = 'pgsql';

$dsn = "$db_driver:host=$db_host;port=$db_port;dbname=$db_name";

function connectDb(): PDO
{
    global $dsn, $db_user, $db_password;
    $conn = new PDO($dsn, $db_user, $db_password);
    return $conn;
}