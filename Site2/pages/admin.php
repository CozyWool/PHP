<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-12 left">
        <!--Countries-->
        <?php
        $conn = connectDb();
        $query = "SELECT * FROM countries";
        $result = $conn->query($query)->fetchAll(PDO::FETCH_OBJ);


        ?>
        <h2>Countries</h2>
        <form action="index.php?page=admin" method="post" class="input-group" id="formCountry">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Country</th>
                    <th>To Delete</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row->id) . "</td>";
                    echo "<td>" . htmlspecialchars($row->country) . "</td>";
                    echo "<td><input class='form-check-inline' type='checkbox' name='checkboxCountry" . $row->id . "'></td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
            <input type="text" class="form-control m-1" name="country" placeholder="Country">
            <input type="submit" class="btn btn-sm btn-info m-1" name="addCountry" value="Add">
            <input type="submit" class="btn btn-sm btn-danger m-1" name="deleteCountry" value="Delete">
        </form>

        <?php
        if (isset($_POST['addCountry'])) {
            $country = trim(htmlspecialchars($_POST['country']));
            if (empty($country)) {
                echo "<span style='color:red;'><h3>Fill all fields!</h3></span>";
                exit();
            }
            $conn = connectDb();
            $query = $conn->prepare("INSERT INTO countries (country) VALUES (:country)");
            try {
                $query->execute([':country' => $country]);

                echo "<h3/><span style='color:green;'>New country added!</span>";
                echo "<script>" . "window.location=document.location.href;" . "</script>";

                return true;
            } catch (PDOException $e) {
                echo "<span style='color:red;'><h3>Failed to add country!</h3> <h4>Error: " . $e->getMessage() . "</h4></span>";

                return false;
            }
        }
        if (isset($_POST['deleteCountry'])) {
            $conn = connectDb();
            try {
                foreach ($_POST as $k => $value) {
                    if (str_starts_with($k, "checkboxCountry")) {
                        $idc = substr($k, strlen("checkboxCountry"));
                        $query = $conn->prepare("DELETE FROM countries WHERE id = :id");
                        $query->execute([':id' => $idc]);
                    }
                }

                echo "<script>" . "window.location=document.location.href;" . "</script>";
                echo "<h3/><span style='color:green;'>Countries deleted!</span>";


                return true;
            } catch (PDOException $e) {
                echo "<span style='color:red;'><h3>Failed to delete countries!</h3> <h4>Error: " . $e->getMessage() . "</h4></span>";

                return false;
            }
        }
        ?>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-12 left">
        <!--Cities-->
        <?php
        $conn = connectDb();
        $query = "SELECT cities.id, cities.city, countries.country FROM cities JOIN countries ON cities.country_id = countries.id";
        $result = $conn->query($query)->fetchAll(PDO::FETCH_OBJ);


        ?>
        <h2>Cities</h2>
        <form action="index.php?page=admin" method="post" class="input-group" id="formCity">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>To Delete</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row->id) . "</td>";
                    echo "<td>" . htmlspecialchars($row->city) . "</td>";
                    echo "<td>" . htmlspecialchars($row->country) . "</td>";
                    echo "<td><input class='form-check-inline' type='checkbox' name='checkboxCity" . $row->id . "'></td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
            <input type="text" class="m-1 form-control" name="city" placeholder="City">
            <select class="m-1 form-select" name="country_id">
                <?php
                $conn = connectDb();
                $query = "SELECT * FROM countries";
                $result = $conn->query($query)->fetchAll(PDO::FETCH_OBJ);


                foreach ($result as $row) {
                    echo "<option value='" . $row->id . "'>" . $row->country . "</option>";
                }
                ?>
            </select>
            <input type="submit" class="btn btn-sm btn-info m-1" name="addCity" value="Add">
            <input type="submit" class="btn btn-sm btn-danger m-1" name="deleteCity" value="Delete">
        </form>

        <?php
        if (isset($_POST['addCity'])) {
            $city = trim(htmlspecialchars($_POST['city']));
            $country_id = trim(htmlspecialchars($_POST['country_id']));
            if (empty($city) || empty($country_id)) {
                echo "<span style='color:red;'><h3>Fill all fields!</h3></span>";
                exit();
            }

            $conn = connectDb();
            $query = $conn->prepare("INSERT INTO cities (city, country_id) VALUES (:city,:country_id)");

            try {
                $query->execute([':city' => $city, ':country_id' => $country_id]);

                echo "<h3/><span style='color:green;'>New city added!</span>";
                echo "<script>" . "window.location=document.location.href;" . "</script>";


                return true;
            } catch (PDOException $e) {
                echo "<span style='color:red;'><h3>Failed to add city!</h3> <h4>Error: " . $e->getMessage() . "</h4></span>";


                return false;
            }
        }
        if (isset($_POST['deleteCity'])) {
            $conn = connectDb();
            try {
                foreach ($_POST as $k => $value) {
                    if (str_starts_with($k, "checkboxCity")) {
                        $idc = substr($k, strlen("checkboxCity"));
                        $query = $conn->prepare("DELETE FROM cities WHERE id = :id");
                        $query->execute([':id' => $idc]);
                    }
                }

                echo "<script>" . "window.location=document.location.href;" . "</script>";
                echo "<h3/><span style='color:green;'>Cities deleted!</span>";


                return true;
            } catch (PDOException $e) {
                echo "<span style='color:red;'><h3>Failed to delete cities!</h3> <h4>Error: " . $e->getMessage() . "</h4></span>";


                return false;
            }
        }
        ?>
    </div>
</div>

<hr/>
<div class="row">
    <div class="col-sm-6 col-md-6 col-lg-12 left">
        <!--Hotels-->
        <?php
        $conn = connectDb();
        $query = "SELECT h.id, h.hotel, h.stars, h.cost, h.info, c.country, ct.city FROM hotels AS h 
    JOIN countries AS c ON h.country_id = c.id 
    JOIN cities AS ct ON h.city_id = ct.id";
        $result = $conn->query($query)->fetchAll(PDO::FETCH_OBJ);


        ?>

        <h2>Hotels</h2>
        <form action="index.php?page=admin" method="post" class="input-group" id="formHotel">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Hotel</th>
                    <th>Stars</th>
                    <th>Cost</th>
                    <th>Info</th>
                    <th>Country</th>
                    <th>City</th>
                    <th>To Delete</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row->id) . "</td>";
                    echo "<td>" . htmlspecialchars($row->hotel) . "</td>";
                    echo "<td>" . htmlspecialchars($row->stars) . "</td>";
                    echo "<td>" . htmlspecialchars($row->cost) . "</td>";
                    echo "<td>" . htmlspecialchars($row->info) . "</td>";
                    echo "<td>" . htmlspecialchars($row->country) . "</td>";
                    echo "<td>" . htmlspecialchars($row->city) . "</td>";
                    echo "<td><input type='checkbox' name='checkboxHotel" . $row->id . "'></td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
            <input type="text" class="form-control" name="hotel" placeholder="Hotel">
            <input type="number" class="form-control" name="stars" placeholder="Stars">
            <input type="text" class="form-control" name="cost" placeholder="Cost">
            <textarea class="form-control" name="info" placeholder="Info"></textarea>
            <select class="form-select m-1" name="city_country_id">
                <?php
                $conn = connectDb();
                $query = "SELECT cities.id, city, country_id, country FROM cities 
                              JOIN countries ON cities.country_id = countries.id";
                $result = $conn->query($query)->fetchAll(PDO::FETCH_OBJ);


                foreach ($result as $row) {
                    echo "<option value='" . $row->id . ':' . $row->country_id . "'>" . $row->country . ' : ' . $row->city . "</option>";
                }
                ?>
            </select>
            <input type="submit" class="btn btn-sm btn-info m-1" name="addHotel" value="Add">
            <input type="submit" class="btn btn-sm btn-danger m-1" name="deleteHotel" value="Delete">
        </form>

        <?php
        if (isset($_POST['addHotel'])) {
            $hotel = trim(htmlspecialchars($_POST['hotel']));
            $stars = trim(htmlspecialchars($_POST['stars']));
            $cost = trim(htmlspecialchars($_POST['cost']));
            $info = trim(htmlspecialchars($_POST['info']));
            list($city_id, $country_id) = explode(':', trim(htmlspecialchars($_POST['city_country_id'])));
            if (empty($hotel) || empty($stars) || empty($cost) || empty($info) || empty($city_id) || empty($country_id)) {
                echo "<span style='color:red;'><h3>Fill all fields!</h3></span>";
                exit();
            }

            $conn = connectDb();
            $query = $conn->prepare("INSERT INTO hotels(hotel, country_id, city_id, stars, cost, info)
	                                       VALUES (:hotel, :country_id, :city_id, :stars, :cost, :info);");

            try {
                $query->execute([
                    ':hotel' => $hotel,
                    ':country_id' => $country_id,
                    ':city_id' => $city_id,
                    ':stars' => $stars,
                    ':cost' => $cost,
                    ':info' => $info]);

                echo "<h3/><span style='color:green;'>New hotel added!</span>";
                echo "<script>" . "window.location=document.location.href;" . "</script>";


                return true;
            } catch (PDOException $e) {
                echo "<span style='color:red;'><h3>Failed to add hotel!</h3> <h4>Error: " . $e->getMessage() . "</h4></span>";

                return false;
            }
        }
        if (isset($_POST['deleteHotel'])) {
            $conn = connectDb();
            try {
                foreach ($_POST as $k => $value) {
                    if (str_starts_with($k, "checkboxHotel")) {
                        $idc = substr($k, strlen("checkboxHotel"));
                        $query = $conn->prepare("DELETE FROM hotels WHERE id = :id");
                        $query->execute([':id' => $idc]);
                    }
                }

                echo "<h3/><span style='color:green;'>Hotels deleted!</span>";
                echo "<script>" . "window.location=document.location.href;" . "</script>";


                return true;
            } catch (PDOException $e) {
                echo "<span style='color:red;'><h3>Failed to delete hotels!</h3> <h4>Error: " . $e->getMessage() . "</h4></span>";

                return false;
            }
        }
        ?>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 left">
        <!--Images-->
    </div>
</div>
