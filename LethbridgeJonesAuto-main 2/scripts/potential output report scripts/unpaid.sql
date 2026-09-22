-- RETURNS ALL OUTSTANDING PAYMENTS LEFT TO BE MADE FOR EACH SALE
-- REMAINDER TO BE PAID = TOTAL COST - PAID TO DATE
-- TOTAL COST = (SALE_PRICE - DOWN_PAYMENT)*(1+INTEREST)

-- USING COMMON TABLE EXPRESSIONS

-- TC has sale id and total cost of the sale
-- PTD has customer info and amount paid to date for a given sale ID
-- Output has all reasonably needed info

WITH TC AS (SELECT TCsub.TCID, TCsub.total_cost
	FROM (SELECT sale_id as TCID, (sale_price - down_payment)*(1+interest) + down_payment as total_cost
		FROM sale) as TCsub),

PTD AS (SELECT customer.first_name, customer.last_name, customer.customer_id, sale.sale_id, paid_to_date
	FROM customer, sale, (SELECT sale_id, SUM(payment.amount_paid) AS paid_to_date
		FROM payment
		GROUP BY sale_id
		) AS summed
	WHERE (customer.customer_id = sale.customer_id) AND (sale.sale_id = summed.sale_id) AND (sale.open_closed = 'open'))

SELECT PTD.first_name, PTD.last_name, PTD.customer_id, PTD.sale_id, PTD.paid_to_date, TC.total_cost, (TC.total_cost - PTD.paid_to_date) as remaining 
FROM PTD, TC
WHERE (PTD.sale_id = TC.TCID);