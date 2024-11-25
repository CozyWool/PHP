<?php
if (!isset($_COOKIE['name'])) {
    setcookie("name", "Vlad", time()+60*60*24, "/", "", 0);
    setcookie("volume", "1", time()+60*60*24, "/", "", 0);
    echo 'Обновите страницу...';
}
else{
    $_COOKIE['volume']++;
    setcookie("volume", $_COOKIE['volume']);
    echo 'Name: ' . $_COOKIE['name'] . "<br/>";
    echo 'Volume: ' . $_COOKIE['volume'] . "<br/>";
}

