<table class="table table-sm table-hover table-bordered table-striped">
    <thead>
    <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Password</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $users = 'pages/users.txt';
    if (file_exists($users)) {
        $file = fopen($users, "r");
        while ($line = fgets($file, 128)) {
            list($username, $password, $email) = explode(":", $line);
            echo "<tr>";
            echo "<td>" . $username . "</td>";
            echo "<td>" . $email . "</td>";
            echo "<td>" . $password . "</td>";
            echo "</tr>";
        }
        fclose($file);
    }
    ?>
    </tbody>
</table>


