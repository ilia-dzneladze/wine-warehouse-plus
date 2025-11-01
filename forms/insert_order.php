<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // --- CONNECT TO DATABASE ---
    
    $servername = "localhost";
    $username = getenv('DB_USER');
    $password = getenv('DB_PASS');
    $dbname = "WWP";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    // --- FETCH CUSTOMERS ---
    $customers = [];
    $result = $conn->query("SELECT business_entity_id, business_name FROM customer");
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $customers[] = $row;
        }
    }

    // --- FETCH WINEMAKERS ---
    $winemakers = [];
    $result = $conn->query("SELECT business_entity_id, business_name FROM winemaker");
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $winemakers[] = $row;
        }
    }


    // --- FETCH PAYMENT TYPES (for dropdown) ---
    $payments = [];
    $result = $conn->query("SELECT payment_type_id, bank FROM payment_type");
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $payments[] = $row;
        }
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Add Order</title>
        <style>
            body{
                display: flex;
                flex-direction: column;
                align-items: center;
                width: 100%;
            }

            body form{
                display: flex;
                flex-direction: column;
                justify-content: space-around;
            }

            body form input{
                margin-bottom: 15px;
            }

            body form select{
                margin-bottom: 15px;
            }

            body form .order-type{
                display: flex;
                flex-direction: row;
            }
            body form .order-type input{
                margin-right: 15px;
            }

            body form .order-type label{
                margin-bottom: 15px;
            }
        </style>
    </head>
    <body>

        <h2>Add New Order</h2>
        <form action="order.php" method="post">

            <label for="order_date">Order Date</label>
            <input type="date" name="order_date" id="order_date" required>

            <label for="order_status">Order Status</label>
            <select name="order_status" id="order_status" required>
                <option value="placed">Placed</option>
                <option value="packed">Packed</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
            </select>

            <label for="expected_delivery_date">Expected Delivery Date</label>
            <input type="date" name="expected_delivery_date" id="expected_delivery_date">

            <div id="order_type_group" class="order-type">
                <label for="sale">Sale (Customer)</label>
                <input type="radio" name="order_type" id="sale" value="sale" required>

                <label for="purchase">Purchase (Winemaker)</label>
                <input type="radio" name="order_type" id="purchase" value="purchase" required>
            </div>


            <label for="business_entity_id">Business Entity</label>
            <select name="business_entity_id" id="business_entity_id" required>
                <option value="">-- Select Business Entity --</option>

                <!-- customers -->
                <?php foreach ($customers as $c): ?>
                    <option value="<?= htmlspecialchars($c['business_entity_id']) ?>" class="entity sale">
                        <?= htmlspecialchars($c['business_name']) ?> (Customer)
                    </option>
                <?php endforeach; ?>

                <!-- winemakers -->
                <?php foreach ($winemakers as $w): ?>
                    <option value="<?= htmlspecialchars($w['business_entity_id']) ?>" class="entity purchase">
                        <?= htmlspecialchars($w['business_name']) ?> (Winemaker)
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="payment_type_id">Payment Type</label>
            <select name="payment_type_id" id="payment_type_id" required>
                <option value="">-- Select Payment Type --</option>
                <?php foreach ($payments as $p): ?>
                    <option value="<?= htmlspecialchars($p['payment_type_id']) ?>">
                        <?= htmlspecialchars($p['bank']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="submit" value="Add Order">
        </form>

        <a href="../main.html">go home</a>

        <script>
            const saleRadio = document.getElementById('sale');
            const purchaseRadio = document.getElementById('purchase');
            const entitySelect = document.getElementById('business_entity_id');
            const allOptions = [...entitySelect.options];

            // start empty
            entitySelect.innerHTML = '<option value="">-- Select Business Entity --</option>';

            function updateEntities(type) {
                entitySelect.innerHTML = '<option value="">-- Select Business Entity --</option>';
                allOptions.forEach(opt => {
                    if (!opt.classList.contains('entity')) return;
                    if (opt.classList.contains(type)) entitySelect.appendChild(opt);
                });
            }

            saleRadio.addEventListener('change', () => updateEntities('sale'));
            purchaseRadio.addEventListener('change', () => updateEntities('purchase'));
        </script>

    </body>
</html>
