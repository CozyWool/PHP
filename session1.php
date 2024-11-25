<?php
session_start();
echo 'id= ' . session_id() . "<br/>";

$num = 100;
$_SESSION['num'] = $num;
echo "From first file num= $num <br/>";
?>

<a href="session2.php">Go to session 2</a>
