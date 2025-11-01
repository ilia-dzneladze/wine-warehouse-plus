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


    $bank = trim($_POST['bank'] ?? '');
    $method = trim($_POST['method'] ?? '');

    if (empty($bank) || empty($method)) {
        die("<p style='color:red; text-align:center;'>Please fill in all fields.</p>
             <p style='text-align:center;'><a href='insert_payment_type_form.html'>Go back</a></p>");
    }

   
    $sql = "INSERT INTO payment_type (bank, method) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("<p style='color:red; text-align:center;'>Prepare failed: " . htmlspecialchars($conn->error) . "</p>");
    }

    $stmt->bind_param("ss", $bank, $method);

    if ($stmt->execute()) {
        $status = "success";
        $message = "Payment type added successfully.<br><br>
                    <strong>Bank:</strong> " . htmlspecialchars($bank) . "<br>
                    <strong>Method:</strong> " . htmlspecialchars($method);
    } else {
        $status = "error";
        $message = "Error inserting data: " . htmlspecialchars($stmt->error);
    }

    $stmt->close();
    $conn->close();

} else {
    $status = "error";
    $message = "This page must be accessed via the form submission.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Insert Payment Type</title>
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
            color: #a77028ff;
            font-weight: 600;
        }

        .error {
            color: #e74c3c;
            font-weight: 600;
        }

        a {
            display: inline-block;
            text-decoration: none;
            background: #975027ff;
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
        <h2><?= $status === 'success' ? 'Success' : 'Error' ?></h2>
        <p class="<?= $status ?>"><?= $message ?></p>

        <a href="insert_payment_type_form.html">Add Another</a><br><br>
        <a href="../main.html">Back to List</a>
    </div>

    <footer>Database Insert Mode (Connected to db_idzneladze)</footer>

</body>
</html>
