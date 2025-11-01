<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    
    $servername = "localhost";
    $username = getenv('DB_USER');
    $password = getenv('DB_PASS');
    $dbname = "WWP";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    // fetch winemakers from view
    $winemakers = [];
    $result = $conn->query("SELECT business_entity_id, business_name FROM winemaker");

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $winemakers[] = $row;
        }
    }

    $conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Wine</title>


    <style>
        body{
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        body form{
            display: flex;
            flex-direction: column;
            justify-content: space-around;
        }

        body form input{
            margin-bottom: 15px;
        }

        body form select{
            margin-bottom: 15px;
        }

        body form textarea{
            margin-bottom: 15px;
        }

        body form .wine_color{
            display: flex;
            flex-direction: row;
        }
        body form .wine_color input{
            margin-right: 15px;
        }

        body form .wine_color label{
            margin-bottom: 15px;
        }

        body form .special_case{
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>


    <h2>Add New Wine</h2>
    <form action="wine.php" method="post">
        <label for="wine_name">Wine Name</label>
        <input type="text" name="wine_name">

        <label for="unit_price">Price</label>
        <input type="number" name="unit_price" id="unit_price">

        <label for="country">Country</label>
        <select name="country" id="country">
            <option value="Georgia">Georgia</option>
            <option value="France">France</option>
            <option value="Italy">Italy</option>
            <option value="Portugal">Portugal</option>
            <option value="Spain">Spain</option>
        </select>

        <label for="winemaker">Winemaker</label>
        <select name="business_entity_id" id="winemaker" required>
            <option value="">-- Choose a winemaker --</option>
            <?php foreach ($winemakers as $wm): ?>
                <option value="<?= htmlspecialchars($wm['business_entity_id']) ?>">
                    <?= htmlspecialchars($wm['business_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>


        <div class="wine_color">
            <label for="red">Red</label>
            <input type="radio" name="type" value="is_redwine" id="red">

            <label for="white">White</label>
            <input type="radio" name="type" value="is_whitewine" id="white">

            <label for="amber">Amber</label>
            <input type="radio" name="type" value="is_amberwine" id="amber">

            <label for="sparkling">Sparkling</label>
            <input type="radio" name="type" value="is_sparklingwine" id="sparkling">
        </div>

        <label for="fermentation_vessel">Fermentation Vessel</label>
        <select name="fermentation_vessel">
            <option value="stainless_steel">Stainless Steel</option>
            <option value="oak_barrel">Oak Barrel</option>
            <option value="wooden_vat">Wooden Vat</option>
            <option value="concrete_tank">Concrete Tank</option>
            <option value="qvevri">Qvevri</option>
        </select>

        <label for="natural_status">Natural Status</label>
        <select name="natural_status" id="natural_status">
            <option value="conventional">Conventional</option>
            <option value="sustainable">Sustainable</option>
            <option value="organic/bio">Organic/Bio</option>
            <option value="biodynamic">Biodynamic</option>
            <option value="natural">Natural</option>
        </select>
       
        <label for="harvest_year">Harvest Year</label>
        <input type="text" name="harvest_year">

        <div class="special_case">
            <label for="total_acidity_g_L" class="is_whitewine">Total Acidity (g/L)</label>
            <input type="number" name="total_acidity_g_L" class="is_whitewine">

            <label for="serving_temperature_C" class="is_whitewine">Serving Temeprature (Celsius)</label>
            <input type="number" name="serving_temperature_C" class="is_whitewine">

            <label for="tannin_level_mg_L" class="is_redwine">Tannin Level (mg/L)</label>
            <input type="number" name="tannin_level_mg_L" class="is_redwine">

            <label for="skin_contact_duration_days" class="is_amberwine">Skin Contact Duration (Days)</label>
            <input type="number" name="skin_contact_duration_days" class="is_amberwine">

            <label for="carbonation_g_L" class="is_sparklingwine">Carbonation (g/L)</label>
            <input type="number" name="carbonation_g_L" class="is_sparklingwine">
        </div>
        
        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" id="quantity">

        <label for="notes">Notes</label>
        <textarea name="notes" id=""></textarea>

        <input type="submit" value="Submit">
    </form>

    <a href="../main.html">go home</a>

    <script>
        // hide all special case fields by default
        document.querySelectorAll('.is_redwine, .is_whitewine, .is_amberwine, .is_sparklingwine')
            .forEach(el => el.style.display = 'none');

        const red = document.querySelector("#red");
        const white = document.querySelector("#white");
        const amber = document.querySelector("#amber");
        const sparkling = document.querySelector("#sparkling");

        // add event listeners to each radio
        red.addEventListener("change", () => {
            if (red.checked) {
                document.querySelectorAll('.is_redwine').forEach(el => el.style.display = 'block');
            } else {
                document.querySelectorAll('.is_redwine').forEach(el => el.style.display = 'none');
            }
            document.querySelectorAll('.is_whitewine, .is_amberwine, .is_sparklingwine')
                .forEach(el => el.style.display = 'none');
        });

        white.addEventListener("change", () => {
            if (white.checked) {
                document.querySelectorAll('.is_whitewine').forEach(el => el.style.display = 'block');
            } else {
                document.querySelectorAll('.is_whitewine').forEach(el => el.style.display = 'none');
            }
            document.querySelectorAll('.is_redwine, .is_amberwine, .is_sparklingwine')
                .forEach(el => el.style.display = 'none');
        });

        amber.addEventListener("change", () => {
            if (amber.checked) {
                document.querySelectorAll('.is_amberwine').forEach(el => el.style.display = 'block');
            } else {
                document.querySelectorAll('.is_amberwine').forEach(el => el.style.display = 'none');
            }
            document.querySelectorAll('.is_redwine, .is_whitewine, .is_sparklingwine')
                .forEach(el => el.style.display = 'none');
        });

        sparkling.addEventListener("change", () => {
            if (sparkling.checked) {
                document.querySelectorAll('.is_sparklingwine').forEach(el => el.style.display = 'block');
            } else {
                document.querySelectorAll('.is_sparklingwine').forEach(el => el.style.display = 'none');
            }
            document.querySelectorAll('.is_redwine, .is_whitewine, .is_amberwine')
                .forEach(el => el.style.display = 'none');
        });
    </script>

</body>
</html>
