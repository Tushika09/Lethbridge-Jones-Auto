<?php

$conn = mysqli_connect("localhost", "root", "", "lethbridge_autojones");

if (!$conn) {
    die("Connection failed");
}

$vehicle_id = $_POST['vehicle_id'];

$sql = "
SELECT sale_id, total_cost
FROM (
    SELECT sale_id, (sale_price - down_payment)*(1+interest) + down_payment AS total_cost
    FROM sale
    WHERE vehicle_id = '$vehicle_id'
) AS TC";

$result = mysqli_query($conn, $sql);

echo "<h2>Total Cost Report</h2>";

echo "<table border='1'>";
echo "<tr><td>Sale ID</td><td>Total Cost</td></tr>";

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row['sale_id']."</td>";
        echo "<td>".$row['total_cost']."</td>";
        echo "</tr>";
    }

} else {
    echo "<tr><td colspan='2'>No results found</td></tr>";
}

echo "</table>";

mysqli_close($conn);

?>