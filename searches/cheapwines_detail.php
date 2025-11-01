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

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Query only existing columns
    $sql = "SELECT wine_id, wine_name, unit_price, country, natural_status, fermentation_vessel, harvest_year
            FROM wine
            WHERE wine_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?= htmlspecialchars($row['wine_name']) ?> - Wine Details</title>
        </head>
        <body>
            <h1>Wine Details</h1>
            <h2><?= htmlspecialchars($row['wine_name']) ?></h2>
            <p><strong>Price:</strong> $<?= number_format($row['unit_price'], 2) ?></p>
            <p><strong>Country:</strong> <?= htmlspecialchars($row['country']) ?></p>
            <p><strong>Natural Status:</strong> <?= htmlspecialchars($row['natural_status']) ?></p>
            <p><strong>Fermentation Vessel:</strong> <?= htmlspecialchars($row['fermentation_vessel']) ?></p>
            <p><strong>Harvest Year:</strong> <?= htmlspecialchars($row['harvest_year']) ?></p>

            <p><a href="cheapwines_detail.php">← Back to Results</a></p>
        </body>
        </html>
        <?php
    } else {
        echo "<p>Wine not found.</p>";
    }

    $stmt->close();
} else {
    echo "<p>No wine selected.</p>";
}

$conn->close();
?>