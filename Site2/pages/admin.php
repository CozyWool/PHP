<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-6 left">
        <!--Countries-->
        <?php
        $conn = connectDb();
        $query = "SELECT * FROM countries";
        $result = $conn->query($query)->fetchAll(PDO::FETCH_OBJ);
        $conn = null;

        ?>

        <form action="index.php?page=admin" method="post" class="input-group" id="formCountry">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>To Delete</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row->id) . "</td>";
                    echo "<td>" . htmlspecialchars($row->country) . "</td>";
                    echo "<td><input type='checkbox' name='checkbox" . $row->id . "'>" . htmlspecialchars($row->country) . "</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
            <input type="text" class="m-1" name="country" placeholder="Country">
            <input type="submit" class="btn btn-sm btn-info m-1" name="addCountry" value="Add">
            <input type="submit" class="btn btn-sm btn-danger m-1" name="deleteCountry" value="Delete">
        </form>

        <?php
        if (isset($_POST['addCountry'])) {
            $country = trim(htmlspecialchars($_POST['country']));
            if (empty($country)) {
                exit();
            }
            $conn = connectDb();
            $query = $conn->prepare("INSERT INTO countries (country) VALUES (:country)");
            try {
                $query->execute([':country' => $country]);

                echo "<h3/><span style='color:green;'>New country added!</span>";
                echo "<script>" . "window.location=document.location.href;" . "</script>";
                $conn = null;
                return true;
            } catch (PDOException $e) {
                echo "<span style='color:red;'><h3>Failed to add country!</h3> <h4>Error: " . $e->getMessage() . "</h4></span>";
                $conn = null;
                return false;
            }
        }
        if (isset($_POST['deleteCountry'])) {
            $conn = connectDb();
            try {
                $query = $conn->prepare("INSERT INTO countries (country) VALUES (:country)");
                foreach ($_POST as $k => $value) {
                    if (str_starts_with($k, "checkbox")) {
                        $idc = substr($k, strlen("checkbox"));
                        $query = $conn->prepare("DELETE FROM countries WHERE id = :id");
                        $query->execute([':id' => $idc]);
                    }
                }

                echo "<script>" . "window.location=document.location.href;" . "</script>";
                echo "<h3/><span style='color:green;'>Countries deleted!</span>";
                $conn = null;
                return true;
            } catch (PDOException $e) {
                echo "<span style='color:red;'><h3>Failed to delete country!</h3> <h4>Error: " . $e->getMessage() . "</h4></span>";
                $conn = null;
                return false;
            }
        }
        ?>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 left">
        <!--Cities-->
    </div>
</div>

<hr/>
<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-6 left">
        <!--Hotels-->
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 left">
        <!--Images-->
    </div>
</div>
