<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php
                if (!isset($_COOKIE['isAuthenticated'])) {
                    ?>

                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=1">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=2">Login</a>
                    </li>
                    <?php
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=3">Show users</a>
                </li>
            </ul>
        </div>
        <ul class="navbar-nav float-left">
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
                    echo '<a href="index.php?page=4" class="nav-link text-dark">Logout</a>';
                ?>
            </li>
        </ul>
    </div>
</nav>