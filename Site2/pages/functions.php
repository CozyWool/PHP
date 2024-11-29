<?php
function register($login, $password, $confirmPassword, $email): bool
{
    $login = trim(htmlspecialchars($login));
    $password = trim(htmlspecialchars($password));
    $confirmPassword = trim(htmlspecialchars($confirmPassword));
    $email = trim(htmlspecialchars($email));

    if ($login == "" || $password == "" || $email == "") {
        echo "<h3/><span style='color:red;'>Fill all required fields!</span>";
        return false;
    }
    if ($confirmPassword != $password) {
        echo "<h3/><span style='color:red;'>Passwords doesn't match!</span>";
        return false;
    }
    if (strlen($login) < 3 || strlen($login) > 30 || strlen($password) < 3 || strlen($password) > 30) {
        echo "<h3/><span style='color:red;'>Values length is between 3 and 30 symbols!</span>";
        return false;
    }
    $conn = connectDb();

    $query = $conn->prepare("SELECT login FROM users WHERE login = :login");
    $query->execute(['login' => $login]);

    if ($query->rowCount() > 0) {
        echo "<h3/><span style='color:red;'>Name is already used!</span>";
        $conn = null;

        return false;
    }

    $roleQuery = $conn->prepare("SELECT id FROM roles WHERE role = :role");
    $roleQuery->execute(['role' => 'User']);
    $role = $roleQuery->fetch(PDO::FETCH_OBJ);

    if (!$role) {
        echo "<h3/><span style='color:red;'>Role 'User' does not exist!</span>";
    }

    if ($_FILES["profilePicture"]["error"] != 0) {
        echo "<h3/><span style='color: red'>Upload error code: " . $_FILES["profilePicture"]["error"] . " </span><br>";
        exit();
    }
    if ($_FILES["profilePicture"]["type"] != "image/jpeg" && $_FILES["profilePicture"]["type"] != "image/png" && $_FILES["profilePicture"]["type"] != "image/jpg") {
        echo "<h3/><span style='color: red'>Only images are allowed!</span><br>";
        exit();
    }

    $profilePicturePath = '';
    if (is_uploaded_file($_FILES["profilePicture"]["tmp_name"])) {
        $fileName = explode('.', $_FILES["profilePicture"]["name"]);
        $ext = end($fileName);
        $profilePicturePath = "./images/" . $login . "_profilePicture." . $ext;
        move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $profilePicturePath);
    }
    if ($profilePicturePath == '') {
        echo "<h3/><span style='color: red'>Failed to load profile picture!</span>";
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = $conn->prepare("INSERT INTO users (login, password, email, role_id, profile_picture) VALUES (:login, :password, :email, :role_id, :profile_picture)");

    if (!$query->execute([
        'login' => $login,
        'password' => $hashed_password,
        'email' => $email,
        'role_id' => $role->id,
        'profile_picture' => $profilePicturePath
    ])) {
        echo "<h3/><span style='color:red;'>Something went wrong!</span>";
        $conn = null;
        return false;
    }

    echo "<h3/><span style='color:green;'>New user added!</span>";
    $conn = null;
//    login($name, $password, false, true);
    return true;
}

function login($username, $password, $rememberMe = false, $needToRedirect = false): bool
{
    $username = trim(htmlspecialchars($username));
    $password = trim(htmlspecialchars($password));

    $conn = connectDb();

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