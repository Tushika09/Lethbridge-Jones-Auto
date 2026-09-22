<?php

$conn = mysqli_connect("localhost", "root", "", "lethbridge_autojones");

if (!$conn) {
    die("Connection failed");
}

$sale_id = $_POST['sale_id'];

$sql = "
SELECT customer.first_name, customer.last_name, customer.customer_id, sale.sale_id, paySum
FROM customer, sale,
    (SELECT sale_id, SUM(payment.amount_paid) AS paySum
     FROM payment
     GROUP BY sale_id) AS summed
WHERE (customer.customer_id = sale.customer_id)
AND (sale.sale_id = summed.sale_id)
AND (sale.sale_id = '$sale_id')";

$result = mysqli_query($conn, $sql);

echo "<h2>Paid To Date Report</h2>";

echo "<table border='1'>";
echo "<tr>
        <td>First Name</td>
        <td>Last Name</td>
        <td>Customer ID</td>
        <td>Sale ID</td>
        <td>Total Paid</td>
      </tr>";

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row['first_name']."</td>";
        echo "<td>".$row['last_name']."</td>";
        echo "<td>".$row['customer_id']."</td>";
        echo "<td>".$row['sale_id']."</td>";
        echo "<td>".$row['paySum']."</td>";
        echo "</tr>";
    }

} else {
    echo "<tr><td colspan='5'>No results found</td></tr>";
}

echo "</table>";

mysqli_close($conn);

?>