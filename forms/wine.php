<?php
    // error handling
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // submit only when POST request is sent to server
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        
    $servername = "localhost";
    $username = getenv('DB_USER');
    $password = getenv('DB_PASS');
    $dbname = "WWP";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


        if ($conn->connect_error) {
            die("<p style='color:red;'>Connection failed: " . $conn->connect_error . "</p>");
        }

        // convert empty strings to NULL
        function nullIfEmpty($v) {
            return ($v === '' || !isset($v)) ? null : $v;
        }

        // collect and sanitize data
        $wine_name   = $_POST['wine_name'] ?? null;
        $country     = $_POST['country'] ?? null;
        $unit_price  = nullIfEmpty($_POST['unit_price'] ?? null);
        $natural_status = $_POST['natural_status'] ?? 'conventional';
        $fermentation_vessel = $_POST['fermentation_vessel'] ?? 'stainless_steel';
        $harvest_year = nullIfEmpty($_POST['harvest_year'] ?? null);
        $quantity     = nullIfEmpty($_POST['quantity'] ?? null);
        $notes        = $_POST['notes'] ?? null;

        $total_acidity_g_L         = nullIfEmpty($_POST['total_acidity_g_L'] ?? null);
        $serving_temperature_C     = nullIfEmpty($_POST['serving_temperature_C'] ?? null);
        $tannin_level_mg_L         = nullIfEmpty($_POST['tannin_level_mg_L'] ?? null);
        $skin_contact_duration_days= nullIfEmpty($_POST['skin_contact_duration_days'] ?? null);
        $carbonation_g_L           = nullIfEmpty($_POST['carbonation_g_L'] ?? null);

        // this is for the radio button, 
        $is_redwine       = isset($_POST['type']) && $_POST['type'] === 'is_redwine' ? 1 : 0;
        $is_whitewine     = isset($_POST['type']) && $_POST['type'] === 'is_whitewine' ? 1 : 0;
        $is_amberwine     = isset($_POST['type']) && $_POST['type'] === 'is_amberwine' ? 1 : 0;
        $is_sparklingwine = isset($_POST['type']) && $_POST['type'] === 'is_sparklingwine' ? 1 : 0;

        $business_entity_id = $_POST['business_entity_id'] ?? null;

        // SQL query for INSERT
        $sql = "INSERT INTO wine (
            wine_name, country, unit_price, natural_status, fermentation_vessel, harvest_year,
            is_whitewine, is_redwine, is_amberwine, is_sparklingwine,
            total_acidity_g_L, serving_temperature_C, tannin_level_mg_L,
            skin_contact_duration_days, carbonation_g_L, notes, business_entity_id, quantity
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("<p>Prepare failed: " . $conn->error . "</p>");
        }

        $stmt->bind_param(
            "ssdssiiiiiiiiissii",
            $wine_name, $country, $unit_price, $natural_status, $fermentation_vessel, $harvest_year,
            $is_whitewine, $is_redwine, $is_amberwine, $is_sparklingwine,
            $total_acidity_g_L, $serving_temperature_C, $tannin_level_mg_L,
            $skin_contact_duration_days, $carbonation_g_L, $notes, $business_entity_id, $quantity
        );

        // execute & show result
        if ($stmt->execute()) {
            // green color for success
            echo "<h2 style='color:green;'>Wine successfully inserted!</h2>";
            echo "<a href='insert_wine.php'>Go back to form</a>";
        } else {
            // red for fail + error
            echo "<p style='color:red;'>Insert failed: " . $stmt->error . "</p>";
            echo "<a href='insert_wine.phpl'>Go back to form</a>";
        }

        $stmt->close();
        $conn->close();
    }
?>
