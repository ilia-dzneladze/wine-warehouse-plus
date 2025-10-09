-- Query to select all wines with winemaker name next to them

SELECT business_name, wine_name
FROM wine W
INNER JOIN business_entity BE ON W.business_entity_id = BE.business_entity_id;

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