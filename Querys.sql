-- Query to how many wines each winemaker has
SELECT business_name, COUNT(W.business_entity_id) AS wine_amount
FROM wine W
INNER JOIN business_entity BE ON W.business_entity_id = BE.business_entity_id
GROUP BY BE.business_entity_id, BE.business_name;


-- Query to see which business_entity_id uses which bank
SELECT business_name, bank
FROM business_entity BE
INNER JOIN orders O ON BE.business_entity_id = O.business_entity_id
INNER JOIN payment_type P ON O.payment_type_id = P.payment_type_id;

-- Query to select business entity and its orders
SELECT 
    BE.business_name,
    BE.phone,
    BE.email,
    O.order_date,
    O.order_status,
    O.expected_delivery_date
FROM business_entity AS BE
INNER JOIN orders AS O 
    ON BE.business_entity_id = O.business_entity_id;

-- Query to select orders and their payment type details
SELECT 
    O.order_id,
    O.order_date,
    PT.bank
FROM orders AS O 
INNER JOIN payment_type AS PT 
    ON O.payment_type_id = PT.payment_type_id
WHERE O.payment_type_id = PT.payment_type_id;


-- Query for all natural wines 
SELECT wine_id, wine_name, country, unit_price, 
natural_status, fermentation_vessel, harvest_year
FROM wine W
WHERE natural_status = 'natural'; 


-- Displays the name and the price of cheap wines
SELECT wine_name, unit_price
FROM wine
WHERE unit_price < 25.00;

-- Query for how many cheap wines are in the database
SELECT COUNT(unit_price) AS cheap_wines 
FROM wine 
WHERE unit_price < 25.00;


-- Query for Winemakers and their wines
SELECT 
    BE.business_name AS winemaker_name,
    W.wine_name,
    W.unit_price
FROM business_entity AS BE
INNER JOIN wine AS W 
    ON BE.business_entity_id = W.business_entity_id
;

-- Query for Quantity of each wine sold
SELECT 
    W.wine_name,
    SUM(OL.quantity) AS total_quantity_sold
FROM wine AS W
INNER JOIN order_line AS OL 
    ON W.wine_id = OL.wine_id
INNER JOIN orders AS O 
    ON OL.order_id = O.order_id
WHERE O.is_sale = 1
GROUP BY W.wine_name
ORDER BY total_quantity_sold DESC;

-- Query for total expenditure by winemaker
SELECT 
    BE.business_name AS winemaker_name,
    SUM(OL.quantity * OL.unit_price) AS total_expenditure
FROM business_entity AS BE
    INNER JOIN wine AS W 
        ON BE.business_entity_id = W.business_entity_id
    INNER JOIN order_line AS OL 
        ON W.wine_id = OL.wine_id
    INNER JOIN orders AS O 
        ON OL.order_id = O.order_id
WHERE O.is_purchase = 1
GROUP BY BE.business_name
ORDER BY total_expenditure DESC;

-- Query for total revenue from customer
SELECT 
	BE.business_name AS customer_name,
    SUM(OL.quantity * OL.unit_price) AS total_revenue
FROM business_entity AS BE
INNER JOIN orders AS O ON BE.business_entity_id = O.business_entity_id
INNER JOIN order_line AS OL on O.order_id = OL.order_id
WHERE O.is_sale = 1
GROUP BY BE.business_name
ORDER BY total_revenue DESC;

-- Query for selecting all qvevri wines
SELECT wine_id, wine_name, unit_price, natural_status, harvest_year
FROM wine
WHERE fermentation_vessel = "qvevri";