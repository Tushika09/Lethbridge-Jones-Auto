-- Profit
-- total cost = (sale cost - down+payment) * (interest)

-- REMOVED SALE_ID IN WHERE STATEMENT IS THE INPUT FROM HTML/PHP

SELECT customer.first_name, customer.last_name, sale.sale_id, sale_price, down_payment, interest, (sale_price - down_payment)*interest as profit
FROM sale, customer
WHERE (sale.customer_id = customer.customer_id) AND (sale_id = 1);