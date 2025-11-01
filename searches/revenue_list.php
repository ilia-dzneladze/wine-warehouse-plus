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


    $customer_name = $_GET['customer_name'] ?? '';

    $sql = "
    SELECT 
        BE.business_name AS customer_name,
        SUM(OL.quantity * OL.unit_price) AS total_revenue
    FROM business_entity AS BE
    INNER JOIN orders AS O ON BE.business_entity_id = O.business_entity_id
    INNER JOIN order_line AS OL on O.order_id = OL.order_id
    WHERE O.is_sale = 1
    ";

    if (!empty($customer_name)) {
        $sql .= " AND BE.business_name LIKE ?";
    }

    $sql .= " GROUP BY BE.business_name ORDER BY total_revenue DESC";

    $stmt = $conn->prepare($sql);

    if (!empty($customer_name)) {
        $like = '%' . $customer_name . '%';
        $stmt->bind_param("s", $like);
    }

    $stmt->execute();
    $result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Customer Revenue List</title>
    </head>
    <body>
        <h2>Customer Revenue Results</h2>
        <table border="1" cellpadding="6">
            <tr><th>Customer Name</th><th>Total Revenue (€)</th></tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>
                        <a href="revenue_detail.php?customer=<?= urlencode($row['customer_name']) ?>">
                            <?= htmlspecialchars($row['customer_name']) ?>
                        </a>
                    </td>
                    <td><?= htmlspecialchars(number_format($row['total_revenue'], 2)) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <p><a href="revenue_search.php">Back to Search</a></p>
    </body>
</html>

<?php
    $stmt->close();
    $conn->close();
?>
