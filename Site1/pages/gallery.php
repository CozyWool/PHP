<h3>Gallery page</h3>
<form action="index.php?page=3" method="post">
    <div class="form-floating mb-2">
        <select class="form-control form-select" name="ext" required>
            <?php
            $path = 'images/';
            if ($dir = opendir($path)) {
                $ar = array();
                while (($file = readdir($dir)) !== false) {
                    $fullname = $path . $file;
                    $pos = strpos($fullname, '.');
                    $ext = substr($fullname, $pos + 1);
                    if (!in_array($ext, $ar)) {
                        $ar[] = $ext;
                        echo "<option>". $ext . "</option>";
                    }
                }
                closedir($dir);
            }
            ?>
        </select>
        <label for="email">Select graphics extensions to display:</label>
    </div>
    <input type="submit" value="Show pictures" class="btn btn-primary w-100 py-2" name="showButton"/>
</form>

<?php
if (isset($_POST['showButton'])) {
    $ext = $_POST['ext'];
    if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == '.') {
        if($ext != '.')
            $ar = glob($path . "*." . $ext);
        else
            $ar = glob($path . "*.*");
        echo "<div class='panel panel-primary'>";
        echo "<h3 class='panel-title'>Gallery content</h3>";
        foreach($ar as $a){
            echo "<a href='" .$a. "' target='_blank'><img src='" .$a. "' style='height: 200px !important; margin: 5px' alt='picture' class='img-fluid'/></a>";
        }
        echo "</div>";
    }
}
?>