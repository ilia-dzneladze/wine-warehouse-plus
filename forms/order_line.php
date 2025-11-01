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


        $order_id = $_POST['order_id'] ?? null;
        $wine_id = $_POST['wine_id'] ?? null;
        $quantity = $_POST['quantity'] ?? null;
        $unit_price = $_POST['unit_price'] ?? null;

        if (!$order_id || !$wine_id || !$quantity || !$unit_price) {
            die("Invalid input. Please go back and fill in all fields.");
        }

        $sql = "INSERT INTO order_line (quantity, unit_price, wine_id, order_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("idii", $quantity, $unit_price, $wine_id, $order_id);

        if ($stmt->execute()) {
            echo "<h3>Order line successfully inserted.</h3>";
        } else {
            echo "<h3>Error: " . $stmt->error . "</h3>";
        }

        echo "<a href='insert_order_line.php'>Go back</a>";

        $stmt->close();
        $conn->close();
    }
?>
