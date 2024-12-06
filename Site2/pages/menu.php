<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="nav nav-tabs nav-justified w-100">
                <?php
                $currentPage = !empty($_GET['page']) ? $_GET['page'] : 'tours';

                if (!isset($_COOKIE['isAuthenticated'])) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage == 'register') ? "active" : "" ?>"
                           href="index.php?page=register">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage == 'login') ? "active" : "" ?>"
                           href="index.php?page=login">Login</a>
                    </li>
                    <?php
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage == 'tours') ? "active" : "" ?>"
                       href="index.php?page=tours">Tours</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage == 'comments') ? "active" : "" ?>"
                       href="index.php?page=comments">Comments</a>
                </li>
                <?php
                $conn = connectDb();
                $query = "SELECT * FROM users
                JOIN roles ON users.role_id = roles.id
                WHERE login=:login";
                $stmt = $conn->prepare($query);
                if (!$stmt->execute([':login' => $_COOKIE['login']])) {
                    echo "<span style='color:red;'><h3>Failed to verify roles!</h3></span>";
                    exit();
                }
                $user = $stmt->fetch(PDO::FETCH_OBJ);
                if ($user->role == 'Admin') {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage == 'admin') ? "active" : "" ?>"
                           href="index.php?page=admin">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage == 'usersAdmin') ? "active" : "" ?>"
                           href="index.php?page=usersAdmin">Users Admin</a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <ul class="nav nav-tabs nav-justified ms-auto d-flex">
            <li class="nav-item">
                <?php
                if (isset($_COOKIE['isAuthenticated'])) {
                    ?>
                    <div class="d-inline-flex">
                        <?php
                        if (isset($_COOKIE['login'])) {
                            $login = $_COOKIE['login'];
                            echo '<a class="nav-link text-dark">Welcome, ' . $login . '!</a>';
                        } else if (isset($_COOKIE['email'])) {
                            $email = $_COOKIE['email'];
                            echo '<a class="nav-link text-dark">Welcome, ' . $email . '!</a>';
                        }
                        if (isset($_COOKIE['profilePicture'])) {
                            echo '<img style="max-width:42px; max-height:41px" class="img-fluid rounded-circle" src="' . $_COOKIE['profilePicture'] . '" alt="Your profile picture">';

                        } ?>
                    </div>
                    <?php
                }
                ?>
            </li>
            <li class="nav - item">
                <?php
                if (isset($_COOKIE['isAuthenticated']))
                    echo '<a href="index.php?page=logout" class="nav-link text-center">Logout</a>';
                ?>
            </li>
        </ul>
    </div>
</nav>