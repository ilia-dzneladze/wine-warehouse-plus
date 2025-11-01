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

$winemaker = $_GET['winemaker'] ?? '';

$sql = "
SELECT 
    W.wine_name,
    OL.quantity,
    OL.unit_price,
    (OL.quantity * OL.unit_price) AS total
FROM business_entity AS BE
INNER JOIN wine AS W ON BE.business_entity_id = W.business_entity_id
INNER JOIN order_line AS OL ON W.wine_id = OL.wine_id
INNER JOIN orders AS O ON OL.order_id = O.order_id
WHERE O.is_purchase = 1 AND BE.business_name = ?
ORDER BY W.wine_name
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $winemaker);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($winemaker) ?> - Expenditure Details</title>
    <link rel="stylesheet" href="../css/winemaker.css">
</head>
    <body class="beige-bg center-page">
        <main>
            <section class="form-card">
                <h2><?= htmlspecialchars($winemaker) ?></h2>
                <?php if ($result->num_rows > 0): ?>
                    <table class="result-table">
                        <tr>
                            <th>Wine</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['wine_name']) ?></td>
                                <td><?= htmlspecialchars($row['quantity']) ?></td>
                                <td><?= htmlspecialchars(number_format($row['unit_price'],2)) ?> €</td>
                                <td><?= htmlspecialchars(number_format($row['total'],2)) ?> €</td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                <?php else: ?>
                    <p>No expenditure records found for this winemaker.</p>
                <?php endif; ?>
                <a href="winemaker_list.php" class="back-btn">Back</a>
                <a href="../index.html" class="back-btn">Go Home</a>
            </section>
        </main>
    </body>
</html>
<?php
$stmt->close();
$conn->close();
?>
