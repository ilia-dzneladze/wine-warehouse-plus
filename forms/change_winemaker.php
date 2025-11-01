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


    // fetch all wines
    $wines = [];
    $result = $conn->query("SELECT wine_id, wine_name FROM wine");
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $wines[] = $row;
        }
    }

    // fetch all winemakers
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
        <title>Change Winemaker</title>
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

        <h2>Assign Winemaker to Wine</h2>

        <form action="winemaker.php" method="post">

            <label for="wine_id">Select Wine</label>
            <select name="wine_id" id="wine_id" required>
                <option value="">-- Select Wine --</option>
                <?php foreach ($wines as $w): ?>
                    <option value="<?= htmlspecialchars($w['wine_id']) ?>">
                        <?= htmlspecialchars($w['wine_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="business_entity_id">Select Winemaker</label>
            <select name="business_entity_id" id="business_entity_id" required>
                <option value="">-- Select Winemaker --</option>
                <?php foreach ($winemakers as $wm): ?>
                    <option value="<?= htmlspecialchars($wm['business_entity_id']) ?>">
                        <?= htmlspecialchars($wm['business_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="submit" value="Assign">
        </form>

        <a href="../main.html">go home</a>

    </body>
</html>
