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


$winemaker_name = $_GET['winemaker_name'] ?? '';

$sql = "
SELECT 
    BE.business_name AS winemaker_name,
    SUM(OL.quantity * OL.unit_price) AS total_expenditure
FROM business_entity AS BE
INNER JOIN wine AS W ON BE.business_entity_id = W.business_entity_id
INNER JOIN order_line AS OL ON W.wine_id = OL.wine_id
INNER JOIN orders AS O ON OL.order_id = O.order_id
WHERE O.is_purchase = 1
";

if (!empty($winemaker_name)) {
    $sql .= " AND BE.business_name LIKE ?";
}

$sql .= " GROUP BY BE.business_name ORDER BY total_expenditure DESC";

$stmt = $conn->prepare($sql);
if (!empty($winemaker_name)) {
    $like = '%' . $winemaker_name . '%';
    $stmt->bind_param("s", $like);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winemaker Expenditure Results</title>
    <link rel="stylesheet" href="../css/winemaker.css">
</head>
    <body class="beige-bg center-page">
        <main>
            <section class="form-card">
                <h2>Winemaker Expenditure Results</h2>
                <?php if ($result->num_rows > 0): ?>
                    <table class="result-table">
                        <tr>
                            <th>Winemaker Name</th>
                            <th>Total Expenditure</th>
                        </tr>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <a href="winemaker_detail.php?winemaker=<?= urlencode($row['winemaker_name']) ?>">
                                        <?= htmlspecialchars($row['winemaker_name']) ?>
                                    </a>
                                </td>
                                <td><?= htmlspecialchars(number_format($row['total_expenditure'],2))?> €</td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                <?php else: ?>
                    <p>No winemakers found.</p>
                <?php endif; ?>
                <a href="winemaker_search.php" class="back-btn">Back</a>
                <a href="../index.html" class="back-btn">Go Home</a>
            </section>
        </main>
    </body>
</html>
<?php
$stmt->close();
$conn->close();
?>
