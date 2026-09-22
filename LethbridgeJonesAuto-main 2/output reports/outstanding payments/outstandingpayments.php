<?php

$conn = mysqli_connect("localhost", "root", "", "lethbridge_autojones");

if (!$conn) {
    die("Connection failed");
}

$sql = "
WITH TC AS (
    SELECT TCsub.TCID, TCsub.total_cost
    FROM (
        SELECT sale_id AS TCID, (sale_price - down_payment)*(1+interest) + down_payment AS total_cost
        FROM sale
    ) AS TCsub
),

PTD AS (
    SELECT customer.first_name, customer.last_name, customer.customer_id, sale.sale_id, paid_to_date
    FROM customer, sale,
        (SELECT sale_id, SUM(payment.amount_paid) AS paid_to_date
         FROM payment
         GROUP BY sale_id) AS summed
    WHERE (customer.customer_id = sale.customer_id)
    AND (sale.sale_id = summed.sale_id)
    AND (sale.open_closed = 'open')
)

SELECT PTD.first_name, PTD.last_name, PTD.customer_id, PTD.sale_id, PTD.paid_to_date, TC.total_cost,
(TC.total_cost - PTD.paid_to_date) AS remaining
FROM PTD, TC
WHERE (PTD.sale_id = TC.TCID)
";

$result = mysqli_query($conn, $sql);

echo "<h2>Outstanding Payments Report</h2>";

echo "<table border='1'>";
echo "<tr>
        <td>First Name</td>
        <td>Last Name</td>
        <td>Customer ID</td>
        <td>Sale ID</td>
        <td>Paid To Date</td>
        <td>Total Cost</td>
        <td>Remaining</td>
      </tr>";

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row['first_name']."</td>";
        echo "<td>".$row['last_name']."</td>";
        echo "<td>".$row['customer_id']."</td>";
        echo "<td>".$row['sale_id']."</td>";
        echo "<td>".$row['paid_to_date']."</td>";
        echo "<td>".$row['total_cost']."</td>";
        echo "<td>".$row['remaining']."</td>";
        echo "</tr>";
    }

} else {
    echo "<tr><td colspan='7'>No outstanding payments</td></tr>";
}

echo "</table>";

mysqli_close($conn);

?>