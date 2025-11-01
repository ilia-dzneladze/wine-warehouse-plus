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


    // fetch all orders
    $orders = [];
    $result = $conn->query("SELECT order_id FROM orders");
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
    }

    // fetch all wines
    $wines = [];
    $result = $conn->query("SELECT wine_id, wine_name FROM wine");
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $wines[] = $row;
        }
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Add Order Line</title>
        <style>
            body {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            form {
                padding: 30px;
                width: 400px;
            }
            input, select {
                width: 100%;
                margin-bottom: 15px;
            }
        </style>
    </head>
    <body>

        <h2>Add New Order Line</h2>

        <form action="order_line.php" method="post">

            <label for="order_id">Select Order</label>
            <select name="order_id" id="order_id" required>
                <option value="">-- Select Order --</option>
                <?php foreach ($orders as $o): ?>
                    <option value="<?= htmlspecialchars($o['order_id']) ?>">
                        <?= htmlspecialchars($o['order_id']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="wine_id">Select Wine</label>
            <select name="wine_id" id="wine_id" required>
                <option value="">-- Select Wine --</option>
                <?php foreach ($wines as $w): ?>
                    <option value="<?= htmlspecialchars($w['wine_id']) ?>">
                        <?= htmlspecialchars($w['wine_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" min="1" required>

            <label for="unit_price">Unit Price</label>
            <input type="number" step="0.01" name="unit_price" id="unit_price" required>

            <input type="submit" value="Add Order Line">
        </form>

        <a href="../main.html">go home</a>

    </body>
</html>
