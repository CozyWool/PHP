<h3 class="text-center">Register</h3>

<main class="form-register w-100 m-auto">
    <form action="index.php?page=1" method="post" enctype="multipart/form-data">
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
            <div class="form-group mb-2">
                <label for="profilePicture">Select a profile picture</label>
                <input type="file" class="form-control" name="profilePicture" required accept="image/*">
            </div>
            <div class="mb-2">
                <button type="submit" class="btn btn-primary w-100 py-2" name="registerButton" value="Register">Add
                    user
                </button>
                <a href=index.php?page=2" class="btn btn-secondary w-100 py-2 mt-2">Already registered? Login</a>
            </div>
        </div>
    </form>
</main>
<style>
    .form-register {
        max-width: 330px;
    }
</style>

<?php
if (isset($_POST['registerButton'])) {
    register($_POST['username'], $_POST['password'], $_POST['confirmPassword'], $_POST['email']);
}
?>
