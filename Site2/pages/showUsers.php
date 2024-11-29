<?php
$conn = new PDO('pgsql:host=localhost;dbname=PostsPhp', 'postgres', '1');

$rows = $conn->query("SELECT * FROM users")->fetchAll(PDO::FETCH_OBJ);

?>
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
    foreach ($rows as $row) {

        echo "<tr>";
        echo "<td>" . $row->username . "</td>";
        echo "<td>" . $row->email . "</td>";
        echo "<td>" . $row->password . "</td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
<?php $conn = null?>


