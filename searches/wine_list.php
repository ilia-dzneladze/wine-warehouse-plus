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


    $winemaker_name = $_GET['winemaker_name'] ?? '';
    $country = $_GET['country'] ?? '';
    $max_price = $_GET['max_price'] ?? '';
    $harvest_year = $_GET['harvest_year'] ?? '';
    $status = $_GET['status'] ?? '';
    $vessel = $_GET['vessel'] ?? '';
    $min_stock = $_GET['min_stock'] ?? '';
    $min_acidity = $_GET['min_acidity'] ?? '';
    $min_tannin = $_GET['min_tannin'] ?? '';
    $min_skin_contact = $_GET['min_skin_contact'] ?? '';

    $sql = "
    SELECT 
        W.wine_id, 
        W.wine_name, 
        W.unit_price, 
        BE.business_name AS winemaker_name
    FROM wine AS W
    INNER JOIN business_entity AS BE 
        ON W.business_entity_id = BE.business_entity_id
    WHERE 1=1
    ";

    $params = [];
    $types = "";

    if (!empty($winemaker_name)) {
        $sql .= " AND BE.business_name LIKE ?";
        $types .= "s";
        $params[] = "%" . $winemaker_name . "%";
    }
    if (!empty($country)) {
        $sql .= " AND W.country LIKE ?";
        $types .= "s";
        $params[] = "%" . $country . "%";
    }
    // if (!empty($max_price)) {
    //     $sql .= " AND W.unit_price <= ?";
    //     $types .= "d";
    //     $params[] = $max_price;
    // }
    if (!empty($harvest_year)) {
        $sql .= " AND W.harvest_year = ?";
        $types .= "i";
        $params[] = $harvest_year;
    }
    if (!empty($status)) {
        $sql .= " AND W.natural_status = ?";
        $types .= "s";
        $params[] = $status;
    }
    if (!empty($vessel)) {
        $sql .= " AND W.fermentation_vessel = ?";
        $types .= "s";
        $params[] = $vessel;
    }
    if (!empty($min_stock)) {
        $sql .= " AND W.quantity >= ?";
        $types .= "i";
        $params[] = $min_stock;
    }
    if (!empty($min_acidity)) {
        $sql .= " AND W.total_acidity_g_L >= ?";
        $types .= "d"; 
        $params[] = $min_acidity;
    }
    if (!empty($min_tannin)) {
        $sql .= " AND W.tannin_level_mg_L >= ?";
        $types .= "i";
        $params[] = $min_tannin;
    }
    if (!empty($min_skin_contact)) {
        $sql .= " AND W.skin_contact_duration_days >= ?";
        $types .= "i";
        $params[] = $min_skin_contact;
    }

    $sql .= " ORDER BY W.wine_name ASC";

    $stmt = $conn->prepare($sql);

    if (!empty($types)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Wine Search Results</title>
    </head>
    <body>
        <h2>Wine Search Results</h2>
        <table border="1" cellpadding="6">
            <tr>
                <th>Wine Name</th>
                <th>Winemaker</th>
                <th>Price (€)</th>
                <th>Details</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['wine_name']) ?></td>
                    <td><?= htmlspecialchars($row['winemaker_name']) ?></td>
                    <td><?= htmlspecialchars(number_format($row['unit_price'], 2)) ?></td>
                    <td>
                        <a href="wine_detail.php?id=<?= $row['wine_id'] ?>">
                            View Details
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
            
            <?php if ($result->num_rows === 0): ?>
                <tr>
                    <td colspan="4" style="text-align:center;">No wines found matching your criteria.</td>
                </tr>
            <?php endif; ?>
        </table>

        <p><a href="wine_search.php">Back to Search</a></p>
    </body>
</html>

<?php
    $stmt->close();
    $conn->close();
?>