<?php
// https://stackoverflow.com/questions/2510434/format-bytes-to-kilobytes-megabytes-gigabytes
function formatBitsToBytes($size, $precision = 2)
{
    $size /= 8;
    $base = log($size, 1024);
    $suffixes = array('', 'K', 'M', 'G', 'T');

    return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
}

?>
    <h3>Gallery page</h3>
    <form action="index.php?page=2" method="post">
        <div class="form-floating mb-2">
            <select class="form-control form-select" name="id" required>
                <?php
                $conn = connectDb();
                $query = $conn->query("SELECT * FROM images ORDER BY id ASC");
                $result = $query->fetchAll(PDO::FETCH_OBJ);
                foreach ($result as $image) {
                    echo "<option value='" . $image->id . "'>" . substr($image->path, strlen('./images/')) . "</option>";
                }
                ?>
            </select>
            <label for="id">Select image to display:</label>
        </div>
        <input type="submit" value="Show picture" class="btn btn-primary w-100 py-2" name="showButton"/>
    </form>

<?php
if (isset($_POST['showButton'])) {
    $conn = connectDb();
    $query = $conn->prepare("SELECT * FROM images WHERE id = :id");
    if (!$query->execute([':id' => $_POST['id']]))
        echo "<h3/><span style='color: red'>Image not found in database!</span><br>";
    $path = $query->fetch(PDO::FETCH_OBJ)->path;
    $filename = substr($path, strlen('./images/'));
    ?>
    <div class='panel panel-primary'>
        <h3 class='panel-title'>Gallery content</h3>

        <a href='<?php echo $path ?>' target='_blank'><img src='<?php echo $path ?>'
                                                           style='height: 500px !important; margin: 5px'
                                                           alt='picture' class='img-fluid'/></a>
        <h4><?php echo $filename ?>, <?php echo formatBitsToBytes(filesize($path)) . 'bytes' ?></h4>
    </div>
    <?php
}
?>