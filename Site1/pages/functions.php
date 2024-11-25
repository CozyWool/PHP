<?php
$users = 'pages/users.txt';

function register($name, $password, $confirmPassword, $email)
{
    $name = trim(htmlspecialchars($name));
    $password = trim(htmlspecialchars($password));
    $email = trim(htmlspecialchars($email));

    if ($name == "" || $password == "" || $email == "") {
        echo "<h3/><span style='color:red;'>Fill all required fields!</span>";
        return false;
    }
    if ($confirmPassword != $password) {
        echo "<h3/><span style='color:red;'>Passwords doesn't match!</span>";
        return false;
    }
    if (strlen($name) < 3 || strlen($name) > 30 || strlen($password) < 3 || strlen($password) > 30) {
        echo "<h3/><span style='color:red;'>Values length is between 3 and 30 symbols!</span>";
        return false;
    }
    global $users;
    $file = fopen($users, "a+");
    while ($line = fgets($file, 128)) {
        $readName = substr($line, 0, strpos($line, ":"));
        if ($readName == $name) {
            echo "<h3/><span style='color:red;'>Name is already used!</span>";
            fclose($file);
            return false;
        }
    }
    $line = $name . ':' . md5($password) . ':' . $email . "\r\n";
    fputs($file, $line);
    fclose($file);
    echo "<h3/><span style='color:green;'>New user added!</span>";
    return true;
}

?>