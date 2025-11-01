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


    $wine_id = $_GET['id'] ?? 0;

    if (empty($wine_id)) {
        die("Error: No wine ID specified.");
    }

    $sql = "
    SELECT 
        W.*, /* Select all columns from wine */
        BE.business_name AS winemaker_name
    FROM wine AS W
    INNER JOIN business_entity AS BE 
        ON W.business_entity_id = BE.business_entity_id
    WHERE W.wine_id = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $wine_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $wine = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?= $wine ? htmlspecialchars($wine['wine_name']) : 'Wine Details' ?> - Details</title>
    </head>
    <body>
        <h2>Details for <?= $wine ? htmlspecialchars($wine['wine_name']) : 'Wine' ?></h2>

        <?php if ($wine): ?>
            <table border="1" cellpadding="6">
                <tr>
                    <th>Attribute</th>
                    <th>Value</th>
                </tr>
                <tr>
                    <td>Winemaker</td>
                    <td><?= htmlspecialchars($wine['winemaker_name']) ?></td>
                </tr>
                <tr>
                    <td>Country</td>
                    <td><?= htmlspecialchars($wine['country']) ?></td>
                </tr>
                <!-- <tr>
                    <td>Price</td>
                    <td>€<?= htmlspecialchars(number_format($wine['unit_price'], 2)) ?></td>
                </tr> -->
                 <tr>
                    <td>Harvest Year</td>
                    <td><?= htmlspecialchars($wine['harvest_year']) ?></td>
                </tr>
                 <tr>
                    <td>Natural Status</td>
                    <td><?= htmlspecialchars($wine['natural_status']) ?></td>
                </tr>
                 <tr>
                    <td>Fermentation Vessel</td>
                    <td><?= htmlspecialchars($wine['fermentation_vessel']) ?></td>
                </tr>
                <tr>
                    <td>Stock Quantity</td>
                    <td><?= htmlspecialchars($wine['quantity']) ?></td>
                </tr>
                
                <?php if ($wine['total_acidity_g_L']): ?>
                    <tr>
                        <td>Total Acidity</td>
                        <td><?= htmlspecialchars($wine['total_acidity_g_L']) ?> g/L</td>
                    </tr>
                <?php endif; ?>
                <?php if ($wine['tannin_level_mg_L']): ?>
                    <tr>
                        <td>Tannin Level</td>
                        <td><?= htmlspecialchars($wine['tannin_level_mg_L']) ?> mg/L</td>
                    </tr>
                <?php endif; ?>
                 <?php if ($wine['skin_contact_duration_days']): ?>
                    <tr>
                        <td>Skin Contact</td>
                        <td><?= htmlspecialchars($wine['skin_contact_duration_days']) ?> days</td>
                    </tr>
                <?php endif; ?>
                <?php if (!empty($wine['notes'])): ?>
                    <tr>
                        <td>Notes</td>
                        <td><?= htmlspecialchars($wine['notes']) ?></td>
                    </tr>
                <?php endif; ?>
            </table>
        <?php else: ?>
            <p>Error: Wine not found.</p>
        <?php endif; ?>

        <p><a href="wine_list.php">Back to List</a></p>
    </body>
</html>

<?php
    $stmt->close();
    $conn->close();
?>