-- Total cost
-- total cost = (sale cost - down+payment) * (1+interest)

SELECT sale_id, total_cost
	FROM (SELECT sale_id, (sale_price - down_payment)*(1+interest) + down_payment as total_cost
		FROM sale) as TC