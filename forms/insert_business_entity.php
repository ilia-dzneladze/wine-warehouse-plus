<?php
    
    $servername = "localhost";
    $username = getenv('DB_USER');
    $password = getenv('DB_PASS');
    $dbname = "WWP";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $business_name = $_POST['business_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $is_customer = isset($_POST['is_customer']) ? 1 : 0;
    $is_winemaker = isset($_POST['is_winemaker']) ? 1 : 0;
    $loyalty_points = $_POST['loyalty_points'] ?: NULL;
    $country = $_POST['country'];

    $sql = "INSERT INTO business_entity 
            (business_name, phone, address, email, is_customer, is_winemaker, loyalty_points, country)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssiiis", $business_name, $phone, $address, $email, $is_customer, $is_winemaker, $loyalty_points, $country);

    $success = $stmt->execute();
    $error_message = $stmt->error;

    $stmt->close();
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Insert Business Entity | WineWarehouse+</title>
        <link rel="stylesheet" href="css/fco.css">
        <link href="https://api.fontshare.com/v2/css?f[]=melodrama@300&f[]=clash-grotesk@400&display=swap" rel="stylesheet">
    </head>
    <body class="beige-bg center-page">
        <main>
            <section class="form-card">
                <h2>Insert Business Entity</h2>
                <?php if ($success): ?>
                    <p><strong>Success!</strong> The business entity <em><?php echo htmlspecialchars($business_name); ?></em> was added to the database.</p>
                <?php else: ?>
                    <p><strong>Error:</strong> <?php echo htmlspecialchars($error_message); ?></p>
                <?php endif; ?>
                
                <a href="../index.html" class="back-btn">Back to Main Page Page</a> <br>
                <a href="../main.html" class="back-btn">Go Home</a>
            </section>
        </main>
    </body>
</html>
