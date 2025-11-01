<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Advanced Wine Search</title>
    <style>
        body { 
            display:flex; 
            flex-direction:column; 
            align-items:center; 
        }
        form { 
            padding:30px; 
            width:500px; 
        }
        form div {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        label {
            display: block;
            margin-bottom: 0;
            width: 200px; 
        }
        input, select { 
            flex-grow: 1;
            padding: 5px;
        }
        input[type="submit"] {
            width: 100%;
        }
    </style>
</head>
<body>
    <h2>Advanced Wine Search</h2>
    <form action="wine_list.php" method="get">
        <p style="text-align: center; font-style: italic;">All search fields are optional.</p>
        <div>
            <label for="winemaker_name">Winemaker</label>
            <input type="text" name="winemaker_name" id="winemaker_name" placeholder="e.g., Kvevri Cellars">
        </div>
        
        <div>
            <label for="country">Country</label>
            <input type="text" name="country" id="country" placeholder="e.g., Georgia">
        </div>

        <!-- <div>
            <label for="max_price">Max Price ($)</label>
            <input type="number" name="max_price" id="max_price" step="0.01" placeholder="e.g., 25.00">
        </div> -->
        
        <div>
            <label for="harvest_year">Harvest Year</label>
            <input type="number" name="harvest_year" id="harvest_year" placeholder="e.g., 2021">
        </div>

        <div>
            <label for="status">Natural Status</label>
            <select id="status" name="status">
                <option value="">-- Any Status --</option>
                <option value="conventional">Conventional</option>
                <option value="sustainable">Sustainable</option>
                <option value="organic/bio">Organic/Bio</option>
                <option value="biodynamic">Biodynamic</option>
                <option value="natural">Natural</option>
            </select>
        </div>

        <div>
            <label for="vessel">Fermentation Vessel</label>
            <select id="vessel" name="vessel">
                <option value="">-- Any Vessel --</option>
                <option value="stainless_steel">Stainless Steel</option>
                <option value="oak_barrel">Oak Barrel</option>
                <option value="wooden_vat">Wooden Vat</option>
                <option value="concrete_tank">Concrete Tank</option>
                <option value="qvevri">Qvevri</option>
            </select>
        </div>
        
        <div>
            <label for="min_stock">Min. Stock Qty</label>
            <input type="number" name="min_stock" id="min_stock" placeholder="e.g., 50">
        </div>
        
        <div>
            <label for="min_acidity">Min. Total Acidity</label>
            <input type="number" name="min_acidity" id="min_acidity" step="0.1" placeholder="e.g., 6">
        </div>
        
        <div>
            <label for="min_tannin">Min. Tannin Level</label>
            <input type="number" name="min_tannin" id="min_tannin" placeholder="e.g., 300">
        </div>
        
        <div>
            <label for="min_skin_contact">Min. Skin Contact (days)</label>
            <input type="number" name="min_skin_contact" id="min_skin_contact" placeholder="e.g., 20">
        </div>

        <input type="submit" value="Search">
    </form>
    <a href="../searches.html">Back to list</a>
</body>
</html>