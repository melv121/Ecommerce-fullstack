UPDATE articles 
SET promotion_price = 799.99,
    promotion_start = CURRENT_DATE,
    promotion_end = DATE_ADD(CURRENT_DATE, INTERVAL 7 DAY)
WHERE id = 1;

UPDATE articles 
SET promotion_price = 19.99,
    promotion_start = CURRENT_DATE,
    promotion_end = DATE_ADD(CURRENT_DATE, INTERVAL 14 DAY)
WHERE id = 2;
