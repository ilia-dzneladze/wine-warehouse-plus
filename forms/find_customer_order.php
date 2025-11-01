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


$entities = $conn->query("SELECT business_name FROM business_entity ORDER BY business_name ASC");

$orders = $conn->query("SELECT order_id FROM orders ORDER BY order_id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Find Customer or Order | WineWarehouse+</title>
<link rel="stylesheet" href="css/fco.css">
<link href="https://api.fontshare.com/v2/css?f[]=melodrama@300&f[]=clash-grotesk@400&display=swap" rel="stylesheet">

</head>
<body class="beige-bg center-page">
<main>
<section class="form-card">
<h2>Find Orders or Entities</h2>
<p>Select a customer or winemaker or an order ID to view details.</p>

<form method="GET">
    <h3>Search Orders by Name</h3>
    <select name="customer_name" required>
        <option value="" disabled selected>Choose an entity</option>
        <?php while($row = $entities->fetch_assoc()) {
            echo "<option value='{$row['business_name']}'>{$row['business_name']}</option>";
        } ?>
    </select><br>
    <button type="submit">Find Orders</button>
</form>

<hr class="hr">

<form method="GET">
    <h3>Search Entity by Order ID</h3>
    <select name="order_id" required>
        <option value="" disabled selected>Choose an order ID</option>
        <?php while($row = $orders->fetch_assoc()){
            echo "<option value='{$row['order_id']}'>{$row['order_id']}</option>";
        }?>
    </select><br>
    <button type="submit">Find Entity</button>
</form>

<hr class="hr">

<?php
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

    echo "<h2>Orders for {$name}</h2>";
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
        echo "</table>";
    }
    else{
        echo "<p>No orders found for this entity.</p>";
    }
}


if(isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $sql = "SELECT B.business_name, B.email, B.phone, B.address, 
                   CASE 
                        WHEN O.is_sale = 1 THEN 'Customer'
                        WHEN O.is_purchase = 1 THEN 'Winemaker'
                        ELSE 'Unknown'
                   END AS entity_type
            FROM orders O
            INNER JOIN business_entity B ON O.business_entity_id = B.business_entity_id
            WHERE O.order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h2>Entity for Order ID: {$order_id}</h2>";
    if($result->num_rows > 0)
        {
        while($row = $result->fetch_assoc()){
            echo "<p><strong>Name:</strong> {$row['business_name']} ({$row['entity_type']})</p>";
            echo "<p><strong>Email:</strong> {$row['email']}</p>";
            echo "<p><strong>Phone:</strong> {$row['phone']}</p>";
            echo "<p><strong>Address:</strong> {$row['address']}</p>";
        }
    }
    else{
        echo "<p>No entity found for this order ID.</p>";
    }
}
?>

<a href="../main.html" class="back-btn">Go Home</a>
</section>
</main>
</body>
</html>
<?php $conn->close(); ?>
