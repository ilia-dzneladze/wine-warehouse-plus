<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Wine Search</title>
</head>
<body>
    <h1>Find Budget Wines</h1>
    <form action="cheapwines_list.php" method="get">
        <label for="price">Enter maximum price ($):</label><br>
        <input type="number" id="price" name="price" placeholder="e.g. 50" min="3" step="0.5" required><br><br>
        <button type="submit">Search</button>
    </form>
    <a href="../searches.html">back home</a>
</body>
</html>