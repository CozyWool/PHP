<h3>Upload form</h3>

<form action="index.php?page=1" method="post" enctype="multipart/form-data">
    <div>
        <div class="form-group mb-2">
            <label for="myFile">Select file for upload:</label>
            <input type="file" class="form-control" name="myFile" required accept="image/*">
        </div>
        <div class="mb-2">
            <button type="submit" class="btn btn-primary w-100 py-2" name="uploadButton" value="Upload">Send image
            </button>
        </div>
    </div>
</form>

<?php
if (isset($_POST['uploadButton'])) {
    if ($_FILES["myFile"]["error"] != 0) {
        echo "<h3/><span style='color: red'>Upload error code: " . $_FILES["myFile"]["error"] . " </span><br>";
        exit();
    }
    if ($_FILES["myFile"]["type"] != "image/jpeg" && $_FILES["myFile"]["type"] != "image/png" && $_FILES["myFile"]["type"] != "image/jpg") {
        echo "<h3/><span style='color: red'>Only images are allowed!</span><br>";
        exit();
    }
    $conn = connectDb();

    $path = "./images/" . $_FILES["myFile"]["name"];
    if (is_uploaded_file($_FILES["myFile"]["tmp_name"])) {
        move_uploaded_file($_FILES["myFile"]["tmp_name"], "./images/" . $_FILES["myFile"]["name"]);
    }
    $query = $conn->prepare("INSERT INTO images (path) VALUES (:path)");
    if (!$query->execute([':path' => $path])) {
        echo "<h3/><span style='color: red'>Failed to uplode image in database!</span><br>";
    }


    echo "<h3/><span style='color: green'>Image uploaded successfully!</span><br>";
}
?>