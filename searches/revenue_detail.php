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


    $customer = $_GET['customer'] ?? '';

    $sql = "
    SELECT 
        BE.business_name,
        W.wine_name,
        OL.quantity,
        OL.unit_price,
        (OL.quantity * OL.unit_price) AS total_price,
        O.order_date
    FROM business_entity AS BE
    INNER JOIN orders AS O ON BE.business_entity_id = O.business_entity_id
    INNER JOIN order_line AS OL ON O.order_id = OL.order_id
    INNER JOIN wine AS W ON OL.wine_id = W.wine_id
    WHERE O.is_sale = 1 AND BE.business_name = ?
    ORDER BY O.order_date DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $customer);
    $stmt->execute();
    $result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?= htmlspecialchars($customer) ?> - Revenue Details</title>
    </head>
    <body>
        <h2>Revenue Details for <?= htmlspecialchars($customer) ?></h2>
        <table border="1" cellpadding="6">
            <tr>
                <th>Order Date</th>
                <th>Wine</th>
                <th>Quantity</th>
                <th>Unit Price (€)</th>
                <th>Total (€)</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['order_date']) ?></td>
                    <td><?= htmlspecialchars($row['wine_name']) ?></td>
                    <td><?= htmlspecialchars($row['quantity']) ?></td>
                    <td><?= htmlspecialchars(number_format($row['unit_price'], 2)) ?></td>
                    <td><?= htmlspecialchars(number_format($row['total_price'], 2)) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <p><a href="revenue_list.php">Back to List</a></p>
    </body>
</html>

<?php
    $stmt->close();
    $conn->close();
?>
