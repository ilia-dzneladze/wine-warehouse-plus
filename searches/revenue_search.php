<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Revenue Search</title>
    <style>
        body { 
            display:flex; 
            flex-direction:column; 
            align-items:center; 
        }
        form { 
            padding:30px; 
            width:400px; 
        }
        input { 
            width:100%; 
            margin-bottom:15px; 
        }
    </style>
</head>
<body>
    <h2>Search Customer Revenue</h2>
    <form action="revenue_list.php" method="get">
        <label for="customer_name">Customer Name (optional)</label>
        <input type="text" name="customer_name" id="customer_name" placeholder="Enter customer name">
        <input type="submit" value="Search">
    </form>
    <a href="../searches.html">Back to list</a>
</body>
</html>
