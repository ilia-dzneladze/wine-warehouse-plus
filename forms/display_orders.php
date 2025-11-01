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


    if(isset($_GET['customer_name'])){
        $name = $_GET['customer_name'];

        $sql = "SELECT O.order_id, O.order_date, O.order_status, O.expected_delivery_date, 
                    CASE 
                            WHEN O.is_sale = 1 THEN 'Customer'
                            WHEN O.is_purchase = 1 THEN 'Winemaker'
                            ELSE 'Unknown'
                    END AS entity_type
                FROM orders O
                INNER JOIN business_entity B ON O.business_entity_id = B.business_entity_id
                WHERE B.business_name = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Orders for <?php echo htmlspecialchars($name); ?> | WineWarehouse+</title>
        <link rel="stylesheet" href="css/fco.css">
        <link href="https://api.fontshare.com/v2/css?f[]=melodrama@300&f[]=clash-grotesk@400&display=swap" rel="stylesheet">

    </head>
    <body class="beige-bg center-page">
        <main>
            <section class="form-card">
            <h2>Orders for<?php echo htmlspecialchars($name); ?></h2>
            <?php
            if($result->num_rows > 0){
                echo "<table class='result-table'>
                        <tr><th>Order ID</th><th>Order Date</th><th>Status</th><th>Expected Delivery</th><th>Type</th></tr>";
                while($row = $result->fetch_assoc()){
                    echo "<tr>
                            <td>{$row['order_id']}</td>
                            <td>{$row['order_date']}</td>
                            <td>{$row['order_status']}</td>
                            <td>{$row['expected_delivery_date']}</td>
                            <td>{$row['entity_type']}</td>
                        </tr>";
                }
                echo"</table>";
            }
            else{
                echo "<p>No orders found for this entity.</p>";
            }
            ?>
            <a href="find_customer_order_entity.php" class="back-btn">Back</a>
            <a href="../main.html" class="back-btn">Go Home</a>
            </section>
        </main>
    </body>
</html>
<?php $conn->close(); ?>
