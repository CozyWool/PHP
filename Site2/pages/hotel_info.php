<?php
include_once("dbConnection.php");

if (isset($_GET['id'])) {
$hotel_id = $_GET['id'];
$conn = connectDb();
$query = $conn->prepare("SELECT * FROM hotels WHERE id = :id");
if (!$query->execute(array('id' => $hotel_id))) {
    echo "<span style='color:red;'><h3>Failed to fetch hotel with id" . $hotel_id . "!</h3></span>";
}
$hotelResult = $query->fetch(PDO::FETCH_OBJ);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <title>Hotel info</title>
</head>
<body>
<div>
    <div><h2 style="display: inline-block; margin: 0px 50px;" class="text-uppercase text-center">
            Hotel: <?php echo $hotelResult->hotel ?></h2>
        <?php
        for ($i = 0; $i < $hotelResult->stars; $i++) {
            echo "<img src='../images/star.png' alt='Hotel Stars' width='20px'/>";
        }
        ?></div>
    <h3 class="text-uppercase">Info: <?php echo $hotelResult->info ?></h3>
    <div class="row">
        <div class="col-md-6 text-center">
            <h3>Images</h3>
            <?php
            $query = "SELECT image_path FROM images WHERE hotel_id = :hotel_id";
            $stmt = $conn->prepare($query);
            if (!$stmt->execute(array(':hotel_id' => $hotel_id))) {
                echo "<span style='color:red;'><h3>Failed to fetch hotel images!</h3></span>";
            }
            $imageResult = $stmt->fetchAll(PDO::FETCH_OBJ);
            ?>
            <ul id="gallery">
                <?php

                foreach ($imageResult as $image) {
                    ?>
                    <li>
                        <img src="../<?php echo $image->image_path ?>" alt="Hotel Image"/>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</div>

<?php
} else {
    echo "<span style='color:red;'><h3>Please specify the id of hotel!</h3></span>";
}
?>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>
