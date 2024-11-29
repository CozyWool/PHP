<h3 class="text-center">Login</h3>

<main class="form-signin w-100 m-auto">
    <form action="index.php?page=2" method="post">
        <div class="form-floating mb-2">
            <input type="text" class="form-control" name="username" required>
            <label name="username">Login</label>
        </div>
        <div class="form-floating mb-2">
            <input type="password" autocomplete="password" name="password" class="form-control" required/>
            <label name="password">Password</label>
        </div>
        <div class="form-check text-start my-3 mb-2">
            <input class="form-check-input" type="checkbox" name="rememberMe">
            <label class="form-check-label" name="rememberMe">Remember Me</label>
        </div>

        <div class="mb-2">
            <button class="btn btn-primary w-100 py-2" type="submit" name="loginButton" value="Login">Login</button>
            <a href="index.php?page=1" class="btn btn-secondary w-100 py-2 mt-2">Register</a>
        </div>
    </form>
</main>
<style>
    .form-signin {
        max-width: 330px;
    }
</style>

<?php
if (isset($_POST['loginButton'])) {
    if (isset($_POST['rememberMe'])) {
        login($_POST['username'], $_POST['password'], $_POST['rememberMe'], true);
    } else {
        login($_POST['username'], $_POST['password'], needToRedirect: true);
    }
}
?>