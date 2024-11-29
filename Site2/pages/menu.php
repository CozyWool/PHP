<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="nav nav-tabs nav-justified">
                <?php
                $currentPage = !empty($_GET['page']) ? $_GET['page'] : 'tours';

                if (!isset($_COOKIE['isAuthenticated'])) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage == 'register') ? "active" : "" ?>" href="index.php?page=register">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage == 'login') ? "active" : "" ?>" href="index.php?page=login">Login</a>
                    </li>
                    <?php
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage == 'tours') ? "active" : "" ?>" href="index.php?page=tours">Tours</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage == 'comments') ? "active" : "" ?>" href="index.php?page=comments">Comments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentPage == 'admin') ? "active" : "" ?>" href="index.php?page=admin">Admin</a>
                </li>
            </ul>
        </div>
        <ul class="nav nav-tabs nav-justified float-left">
            <li class="nav-item">
                <?php
                if (isset($_COOKIE['username'])) {
                    $username = $_COOKIE['username'];
                    echo '<a class="nav-link text-dark">Welcome, ' . $username . '!</a>';
                } else if (isset($_COOKIE['email'])) {
                    $email = $_COOKIE['email'];
                    echo '<a class="nav-link text-dark">Welcome, ' . $email . '!</a>';
                }
                ?>
            </li>
            <li class="nav-item">
                <?php
                if (isset($_COOKIE['isAuthenticated']))
                    echo '<a href="index.php?page=logout" class="nav-link text-dark">Logout</a>';
                ?>
            </li>
        </ul>
    </div>
</nav>