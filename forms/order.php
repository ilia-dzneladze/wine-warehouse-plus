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


        $order_date = $_POST['order_date'] ?? null;
        $order_status = $_POST['order_status'] ?? null;
        $expected_delivery_date = $_POST['expected_delivery_date'] ?? null;
        $order_type = $_POST['order_type'] ?? null;
        $payment_type_id = $_POST['payment_type_id'] ?? null;
        $business_entity_id = $_POST['business_entity_id'] ?? null;

        $is_sale = ($order_type === 'sale') ? 1 : 0;
        $is_purchase = ($order_type === 'purchase') ? 1 : 0;

        $sql = "INSERT INTO orders (
            order_date, order_status, expected_delivery_date, 
            is_sale, is_purchase, payment_type_id, business_entity_id
        ) VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("<p style='color:red;'>Prepare failed: " . $conn->error . "</p>");
        }

        $stmt->bind_param("sssiiii",
            $order_date, $order_status, $expected_delivery_date,
            $is_sale, $is_purchase, $payment_type_id, $business_entity_id
        );

        if ($stmt->execute()) {
            echo "<h2 style='color:green;'>Order successfully inserted!</h2>";
            echo "<a href='insert_order.php'>Go back to form</a>";
        } else {
            echo "<p style='color:red;'>Insert failed: " . $stmt->error . "</p>";
            echo "<a href='insert_order.php'>Go back</a>";
        }

        $stmt->close();
        $conn->close();
    }
?>
