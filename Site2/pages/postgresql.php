<?php
//$connection = pg_connect('host=localhost port=5432 user=postgres password=1 dbname=ProductsDb');
//$result = pg_query($connection, 'SELECT * FROM public."Products"');
//
//$rows = pg_fetch_all($result, mode: PDO::FETCH_OBJ);
//foreach ($rows as $row) {
//    echo $row['Id'] . ' - ' . $row['Name'] . ' - ' . $row['Price'] . '<br/>';
//}

//$pdo = new PDO('pgsql:host=localhost;dbname=ProductsDb', 'postgres', '1');
//$sql = 'SELECT * FROM public."Products"';
//
//$rs = $pdo->query($sql);
//
//$rows = $rs->fetchAll(PDO::FETCH_OBJ);
//
//foreach ($rows as $row) {
//    echo $row->Id . ' - ' . $row->Name . ' - ' . $row->Price . '<br/>';
//}

$conn = new PDO('pgsql:host=localhost;dbname=PostsPhp', 'postgres', '1');

$sql = 'SELECT * FROM public."posts"';

$rs = $conn->query($sql);

$rows = $rs->fetchAll(PDO::FETCH_OBJ);
?>

<table class="table table-sm table-hover table-bordered table-striped">
    <thead>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Body</th>
        <th>Author</th>
        <th>Created at</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($rows as $row) {
        echo "<tr>";
        echo "<td>" . $row->id . "</td>";
        echo "<td>" . $row->title . "</td>";
        echo "<td>" . $row->body . "</td>";
        echo "<td>" . $row->author . "</td>";
        echo "<td>" . $row->created_at . "</td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>



