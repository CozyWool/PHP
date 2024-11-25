<?php
session_start();

echo 'id= ' . session_id() . "<br/>";
echo "From second file num= ". $_SESSION["num"] . "<br/>";
?>
<a href="session1.php">Back to session 1</a>

