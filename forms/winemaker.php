<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

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


        $wine_id = $_POST['wine_id'] ?? null;
        $business_entity_id = $_POST['business_entity_id'] ?? null;

        if (!$wine_id || !$business_entity_id) {
            die("Invalid input. Please go back and select both fields.");
        }

        $sql = "UPDATE wine SET business_entity_id = ? WHERE wine_id = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ii", $business_entity_id, $wine_id);

        if ($stmt->execute()) {
            echo "<h3>Winemaker successfully assigned.</h3>";
        } else {
            echo "<h3>Error: " . $stmt->error . "</h3>";
        }

        echo "<a href='change_winemaker.php'>Go back</a>";

        $stmt->close();
        $conn->close();
    }
?>
