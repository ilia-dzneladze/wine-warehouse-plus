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
    $payment_type_id = $_POST['payment_type_id'] ?? null;

    if (!$order_id || !$payment_type_id) {
        $status = "error";
        $message = "Invalid input. Please go back and select both fields.";
    } else {

        $status = "success";
        $message = "Payment type successfully assigned to Order #{$order_id}!";
    }
} else {
    $status = "error";
    $message = "This page must be accessed via the form submission.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Type Connection</title>
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

        .card {
            background: #ffffff;
            padding: 40px 50px;
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 15px;
        }

        p {
            font-size: 16px;
            color: #555;
            margin-bottom: 25px;
        }

        .success {
            color: #28a745;
            font-weight: 600;
        }

        .error {
            color: #e74c3c;
            font-weight: 600;
        }

        a {
            display: inline-block;
            text-decoration: none;
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        a:hover {
            background: #0056b3;
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

    <div class="card">
        <h2><?= $status === 'success' ? 'Success!' : 'Error' ?></h2>
        <p class="<?= $status ?>"><?= htmlspecialchars($message) ?></p>
        <a href="change_payment_type.php">Go Back</a>
    </div>

    <footer>Payment Type Connector - Test Mode (No Database Connected)</footer>

</body>
</html>
