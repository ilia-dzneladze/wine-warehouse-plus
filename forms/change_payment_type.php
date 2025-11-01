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


$orders = [];
$result = $conn->query("SELECT order_id FROM orders");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

$payment_types = [];
$result = $conn->query("SELECT payment_type_id, bank FROM payment_type");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $payment_types[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assign Payment Type to Order</title>
    <style>
        body {
            background: linear-gradient(135deg, #f3f4f6, #e9ecef);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            background: #ffffff;
            padding: 35px 40px;
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            width: 370px;
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }

        label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #34495e;
        }

        select {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            font-size: 15px;
            transition: border-color 0.3s ease;
        }

        select:focus {
            border-color: #007bff;
            outline: none;
        }

        input[type="submit"] {
            padding: 12px;
            background: #007bff;
            color: white;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background: #0056b3;
        }

        a {
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #0056b3;
        }

        footer {
            position: absolute;
            bottom: 10px;
            color: #888;
            font-size: 13px;
        }
    </style>
</head>
<body>

    <h2>Assign Payment Type to an Order</h2>

    <form action="payment_type_connector.php" method="post">
        <label for="order_id">Select Order</label>
        <select name="order_id" id="order_id" required>
            <option value="">-- Select Order --</option>
            <?php foreach ($orders as $o): ?>
                <option value="<?= htmlspecialchars($o['order_id']) ?>">
                    Order #<?= htmlspecialchars($o['order_id']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="payment_type_id">Select Payment Type (Bank)</label>
        <select name="payment_type_id" id="payment_type_id" required>
            <option value="">-- Select Bank --</option>
            <?php foreach ($payment_types as $pt): ?>
                <option value="<?= htmlspecialchars($pt['payment_type_id']) ?>">
                    <?= htmlspecialchars($pt['bank']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="submit" value="Assign">
    </form>

    <a href="../main.html">Go Home</a>

    <footer>Payment Assignment Form - Connected to Database</footer>

</body>
</html>
