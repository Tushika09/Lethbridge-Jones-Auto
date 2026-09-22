<?php

$conn = mysqli_connect("localhost", "root", "", "lethbridge_autojones");

if (!$conn) {
    die("Connection failed");
}

$sale_id = $_POST['sale_id'];

$sql = "
SELECT customer.first_name, customer.last_name, sale.sale_id, sale_price, down_payment, interest,
(sale_price - down_payment)*interest AS profit
FROM sale, customer
WHERE (sale.customer_id = customer.customer_id)
AND (sale.sale_id = '$sale_id')";

$result = mysqli_query($conn, $sql);

echo "<h2>Profit Report</h2>";

echo "<table border='1'>";
echo "<tr>
        <td>First Name</td>
        <td>Last Name</td>
        <td>Sale ID</td>
        <td>Sale Price</td>
        <td>Down Payment</td>
        <td>Interest</td>
        <td>Profit</td>
      </tr>";

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row['first_name']."</td>";
        echo "<td>".$row['last_name']."</td>";
        echo "<td>".$row['sale_id']."</td>";
        echo "<td>".$row['sale_price']."</td>";
        echo "<td>".$row['down_payment']."</td>";
        echo "<td>".$row['interest']."</td>";
        echo "<td>".$row['profit']."</td>";
        echo "</tr>";
    }

} else {
    echo "<tr><td colspan='7'>No results found</td></tr>";
}

echo "</table>";

mysqli_close($conn);

?>