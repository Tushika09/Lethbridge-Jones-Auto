<?php

$host = 'localhost';
$username = "root";
$password = "";
$dbname = "lethbridge_autojones";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed");
}

$search_type = $_POST['search_type'];
$search_value = $_POST['search_value'];
// $show_sales = $_POST['show_sales'];
$show_sales = "yes"; // Always show sales attached to warranty

if ($search_type == "id") { // warranty data
    $sql = "SELECT * FROM warranty, sale WHERE warranty_id = '$search_value' and warranty.sale_id = sale.sale_id";
} elseif ($search_type == "sale_id") {
    $sql = "SELECT * FROM warranty, sale WHERE sale_id = '$search_value' and warranty.sale_id = sale.sale_id";
} elseif ($search_type == "vehicle_id") {
    $sql = "SELECT * FROM warranty, sale WHERE sale.vehicle_id = '$search_value' and warranty.sale_id = sale.sale_id";
} else {
    $sql = "SELECT * FROM warranty, sale WHERE start_date = '$search_value' and warranty.sale_id = sale.sale_id";
}

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "No warranty found.";
    exit();
}

$emp = mysqli_fetch_assoc($result);

echo "<h2>Warranty Report</h2>";//output record

echo "<table border='1'>";
echo "<tr><td>Warranty ID</td><td>".$emp['warranty_id']."</td></tr>";
echo "<tr><td>Vehicle ID</td><td>".$emp['vehicle_id']."</td></tr>";
echo "<tr><td>Sale ID</td><td>".$emp['sale_id']."</td></tr>";
echo "<tr><td>Start Date</td><td>".$emp['start_date']."</td></tr>";
echo "<tr><td>End Date</td><td>".$emp['end_date']."</td></tr>";
echo "</table>";

echo "<br>";

//sales
if ($show_sales == "yes") {

    $sql2 = "SELECT * FROM sale, customer, vehicle WHERE vehicle.vehicle_id = '".$emp['vehicle_id']."' and vehicle.vehicle_id = sale.vehicle_id and sale.customer_id = customer.customer_id";
    $sales = mysqli_query($conn, $sql2);


    echo "<h3>Sales Records</h3>";

    echo "<table border='1'>";
    echo "<tr><td>Sale ID</td><td>Customer Name</td><td>Make and Model</td><td>Price</td><td>Commission</td><td>Customer ID</td><td>Employee ID</td></tr>";

    if (mysqli_num_rows($sales) > 0) {

        while ($row = mysqli_fetch_assoc($sales)) {

            echo "<tr>";
            echo "<td>".$row['sale_id']."</td>";
            echo "<td>".$row['first_name']." ".$row['last_name']."</td>";
            echo "<td>".$row['year']. " ".$row['make']." ".$row['model']."</td>";
            echo "<td>".$row['sale_price']."</td>";
            echo "<td>".$row['commission']."</td>";
            echo "<td>".$row['customer_id']."</td>";
            echo "<td>".$row['employee_id']."</td>";



            echo "</tr>";

        }

    } else {
        echo "<tr><td colspan='3'>No sales found</td></tr>";
    }


    echo "</table>";

}

/* CLOSE */
mysqli_close($conn);

?>