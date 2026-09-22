-- PAID TO DATE QUERY
-- given sale id, find how much the customer has paid to date
-- SALE.SALE_ID = 1 IN LINE 10 IS WHERE THE QUERIED SALE NUMBER NEEDS TO GO.

SELECT customer.first_name, customer.last_name, customer.customer_id, sale.sale_id, paySum
FROM customer, sale, (SELECT sale_id, SUM(payment.amount_paid) AS paySum
	FROM payment
	GROUP BY sale_id
	) AS summed
WHERE (customer.customer_id = sale.customer_id) AND (sale.sale_id = summed.sale_id) AND (sale.sale_id = 1)