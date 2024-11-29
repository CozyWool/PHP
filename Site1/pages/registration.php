<h3>Registration form</h3>
<form action="index.php?page=4" method="post">
    <div>
        <div class="form-floating mb-2">
            <input type="email" autocomplete="email" class="form-control" name="email" required>
            <label for="email">Email</label>
        </div>
        <div class="form-floating mb-2">
            <input class="form-control" name="username">
            <label for="username">Username</label>
        </div>
        <div class="form-floating mb-2">
            <input type="password" name="password" autocomplete="password" class="form-control" required>
            <label for="password">Password</label>
        </div>
        <div class="form-floating mb-2">
            <input type="password" name="confirmPassword" class="form-control" required>
            <label for="confirmPassword">Confirm password</label>
        </div>
        <div class="mb-2">
            <button type="submit" class="btn btn-primary w-100 py-2" name="registerButton" value="Register">Register</button>
            <a class="btn btn-secondary w-100 py-2 mt-2">Already registered? Sign in</a>
        </div>
    </div>
</form>
<?php
if (isset($_POST['registerButton'])) {
    register($_POST['username'], $_POST['password'], $_POST['confirmPassword'], $_POST['email']);
}
?>
