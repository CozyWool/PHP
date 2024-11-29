<?php


function register($name, $password, $confirmPassword, $email): bool
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
    $conn = new PDO('pgsql:host=localhost;dbname=PostsPhp', 'postgres', '1');

    $query = $conn->prepare("SELECT username FROM users WHERE username = :name");
    $query->execute(['name' => $name]);

    if ($query->rowCount() > 0) {
        echo "<h3/><span style='color:red;'>Name is already used!</span>";
        $conn = null;

        return false;
    }
    $hashed_password = password_hash($password,  PASSWORD_DEFAULT);

    $query = $conn->prepare("INSERT INTO users (username, password, email) VALUES (:name, :password, :email)");
    $query->bindParam('name', $name);
    $query->bindParam('password', $hashed_password);
    $query->bindParam('email', $email);
    if (!$query->execute()) {
        echo "<h3/><span style='color:red;'>Something went wrong!</span>";
        $conn = null;
        return false;
    }

    echo "<h3/><span style='color:green;'>New user added!</span>";
    $conn = null;
    login($name, $password, false, true);
    return true;
}

function login($username, $password, $rememberMe = false, $needToRedirect = false) : bool
{
    $username = trim(htmlspecialchars($username));
    $password = trim(htmlspecialchars($password));

    $conn = new PDO('pgsql:host=localhost;dbname=PostsPhp', 'postgres', '1');

    $query = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $query->execute(['username' => $username]);
    $user = $query->fetch(PDO::FETCH_OBJ);
    if (password_verify($password, $user->password) && $username == $user->username) {
        $duration = $rememberMe ? time() + (60 * 60 * 24 * 7) : 0;

        setcookie("username", $username, $duration, "/");
        setcookie("password", $password, $duration, "/");
        setcookie("email", $user->email, $duration, "/");
        setcookie("rememberMe", $rememberMe, $duration, "/");
        setcookie("isAuthenticated", true, $duration, "/");

        if ($needToRedirect)
            header("Location: index.php?page=3");
        $conn = null;
        return true;
    }

    echo "<h3 class='text-center'/><span style='color:red;'>Login failed!</span>";
    return false;
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