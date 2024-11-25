<?php
$users = 'pages/users.txt';

function addUser($name, $password, $confirmPassword, $email)
{
    $name = trim(htmlspecialchars($name));
    $password = trim(htmlspecialchars($password));
    $confirmPassword = trim(htmlspecialchars($confirmPassword));
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

function login($username, $password, $rememberMe = false, $needToRedirect = false)
{
    $username = trim(htmlspecialchars($username));
    $password = trim(htmlspecialchars($password));

    global $users;
    if (!file_exists($users)) {
        echo "<h3 class='text-center'/><span style='color:red;'>No users found. Please register first.</span>";
        return false;
    }

    $file = fopen($users, "a+");
    if (!$file) {
        echo "<h3 class='text-center'/><span style='color:red;'>Failed to open file.</span>";
        return false;
    }
    while ($line = fgets($file, 128)) {
        $line = trim($line);
        list($readUsername, $readPassword, $readEmail) = explode(':', $line);

        if ($readUsername == $username && $readPassword == md5($password)) {
            $duration = $rememberMe ? time() + (60 * 60 * 24 * 7) : 0;

            setcookie("username", $readUsername, $duration, "/");
            setcookie("password", $password, $duration, "/");
            setcookie("email", $readEmail, $duration, "/");
            setcookie("rememberMe", $rememberMe, $duration, "/");
            setcookie("isAuthenticated", true, $duration, "/");

            fclose($file);
            if ($needToRedirect)
                header("Location: index.php?page=3");
            return true;
        }
    }
    fclose($file);
    echo "<h3 class='text-center'/><span style='color:red;'>Login failed!</span>";
}

function deleteCookie($name): void
{
    if (isset($_COOKIE[$name])) {
        setcookie($name, "", time() - 3600, "/");
    }
}

function logout(): void
{
    deleteCookie("username");
    deleteCookie("password");
    deleteCookie("rememberMe");
    deleteCookie("isAuthenticated");
    deleteCookie("email");
    header("Location: index.php?page=2");
}

?>