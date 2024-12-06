<h2>Select Tours</h2>
<hr>
<form action="index.php?page=tours" method="post">
    <div class="col-sm-3 col-md-3 col-lg-3">
        <select name="country_id" class="form-select">
            <?php
            $conn = connectDb();
            $countryQuery = "SELECT id, country FROM countries ORDER BY country";
            $result = $conn->query($countryQuery)->fetchAll(PDO::FETCH_OBJ);
            foreach ($result as $country) {
                echo "<option value='" . htmlspecialchars($country->id) . "'>" . htmlspecialchars($country->country) . "</option>";
            }
            ?>
        </select>
        <input type="submit" name="selectCountry" value="Select Country" class="btn btn-xs btn-primary">
    </div>
    <?php
    if (isset($_POST['selectCountry'])) {
        echo '<br/>';
        $country_id = $_POST['country_id'];
        if ($country_id == 0) {
            exit();
        }
        $cityQuery = $conn->prepare("SELECT id, city FROM cities WHERE country_id = :country_id ORDER BY city");
        if (!$cityQuery->execute(['country_id' => $country_id])) {
            echo "<span style='color:red;'><h3>Failed to fetch cities!</h3></span>";
        }
        $result = $cityQuery->fetchAll(PDO::FETCH_OBJ);
        ?>
        <div class="col-sm-3 col-md-3 col-lg-3">
            <select name="city_id" class="form-select">
                <option value="-1">Select city</option>
                <?php
                foreach ($result as $city) {
                    echo "<option value='" . htmlspecialchars($city->id) . "'>" . htmlspecialchars($city->city) . "</option>";
                }
                ?>
            </select>
        </div>

        <input type="submit" name="selectCity" value="Select City" class="btn btn-xs btn-secondary">
        <?php

    }

    if (isset($_POST['selectCity'])) {
        $city_id = $_POST['city_id'];
        if ($city_id == 0) {
            exit();
        }
        $hotelQuery = $conn->prepare('SELECT co.country, ci.city, ho.hotel, ho.cost, ho.stars, ho.id FROM hotels AS ho
                                            JOIN cities AS ci ON ci.id = ho.city_id
                                            JOIN countries AS co ON co.id = ho.country_id
                                            WHERE ho.city_id = :city_id');
        if (!$hotelQuery->execute(['city_id' => $city_id])) {
            echo "<span style='color:red;'><h3>Failed to fetch hotels!</h3></span>";
        }
        $hotelResult = $hotelQuery->fetchAll(PDO::FETCH_OBJ);
    }

    if (isset($hotelResult)) {
        ?>
        <table class="table table-striped text-center">
            <thead class="fw-bold">
            <tr>
                <td>Hotel</td>
                <td>Country</td>
                <td>City</td>
                <td>Cost</td>
                <td>Stars</td>
                <td>Link</td>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($hotelResult as $hotel) {
                $link = 'pages/hotel_info.php?id=' . $hotel->id;
                ?>
                <tr>
                    <td><?php echo $hotel->hotel ?></td>
                    <td><?php echo $hotel->country ?></td>
                    <td><?php echo $hotel->city ?></td>
                    <td><?php echo $hotel->cost ?></td>
                    <td><?php echo $hotel->stars ?></td>
                    <td><a href='<?php echo $link ?>' class='btn btn-primary btn-sm' target='_blank'>More</a></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <?php
    }
    ?>
</form>