 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wine Results</title>
</head>
<body>
    <h1>Budget Wines</h1>

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


// If price is provided, filter; otherwise show all wines
if (!empty($_GET['price'])) {
    $price = (float)$_GET["price"];
    $sql = "SELECT * FROM wine WHERE unit_price <= $price ORDER BY unit_price ASC";
    echo "<h2>Wines under $$price:</h2>";
} else {
    $sql = "SELECT * FROM wine ORDER BY unit_price ASC";
    echo "<h2>All Wines:</h2>";
}

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)) {
    $wine_name = $row["wine_name"];
    $unit_price = $row["unit_price"];
    $id = $row["wine_id"];
    echo "<p><a href='cheapwines_detail.php?id=$id'>$wine_name</a> - \$$unit_price</p>";
}

mysqli_close($conn);
?>


<br>
<a href="cheapwines_search.php">← Back to Search</a>

</body>
</html>