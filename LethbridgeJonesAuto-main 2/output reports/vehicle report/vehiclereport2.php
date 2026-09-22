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
$in_stock = $_POST['in_stock'];

if ($in_stock == "no") { // Find vehicles that have already been sold
    if ($search_type == "vehicle_id") { // vehicle data
        $sql = "SELECT * FROM vehicle, sale WHERE vehicle.vehicle_id = '$search_value' and sale.vehicle_id = vehicle.vehicle_id";
    } elseif ($search_type == "make") {
        $sql = "SELECT * FROM vehicle, sale WHERE vehicle.make = '$search_value' and sale.vehicle_id = vehicle.vehicle_id";
    } elseif ($search_type == "model") {
        $sql = "SELECT * FROM vehicle, sale WHERE vehicle.model = '$search_value' and sale.vehicle_id = vehicle.vehicle_id";
    } else {
        $sql = "SELECT * FROM vehicle, sale WHERE vehicle.model = '$search_value' and sale.vehicle_id = vehicle.vehicle_id";
    }
} else {    // Find vehicles still in stock
    if ($search_type == "vehicle_id") { // vehicle data
        $sql = "SELECT * FROM vehicle WHERE vehicle_id = '$search_value' and vehicle_id not in (select vehicle_id from sale)";
    } elseif ($search_type == "make") {
        $sql = "SELECT * FROM vehicle WHERE make = '$search_value'and vehicle_id not in (select vehicle_id from sale)";
    } elseif ($search_type == "model") {
        $sql = "SELECT * FROM vehicle WHERE model = '$search_value'and vehicle_id not in (select vehicle_id from sale)";
    } else {
        $sql = "SELECT * FROM vehicle WHERE model = '$search_value'and vehicle_id not in (select vehicle_id from sale)";
    }
}

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "No vehicle found.";
    exit();
}

$emp = mysqli_fetch_assoc($result);

echo "<h2>Vehicle Search Results</h2>";//output record

echo "<table border='1'>";
echo "<tr><td>ID</td><td>".$emp['vehicle_id']."</td></tr>";
echo "<tr><td>Make and Model</td><td>".$emp['year']. " ".$emp['make']." ".$emp['model']."</td></tr>";
echo "<tr><td>Colour</td><td>".$emp['colour']."</td></tr>";
echo "<tr><td>Miles</td><td>".$emp['miles']."</td></tr>";
echo "<tr><td>Condition</td><td>".$emp['vehicle_condition']."</td></tr>";
echo "<tr><td>Book Price</td><td>".$emp['book_price']."</td></tr>";
echo "</table>";

echo "<br>";

//sales
if ($in_stock == "no") {

    $sql2 = "SELECT * FROM sale, customer WHERE vehicle_id = '".$emp['vehicle_id']."' and sale.customer_id = customer.customer_id";
    $sales = mysqli_query($conn, $sql2);


    echo "<h3>Sales Records</h3>";

    echo "<table border='1'>";
    echo "<tr><td>Sale ID</td><td>Customer Name</td><td>Price</td><td>Commission</td><td>Customer ID</td><td>Employee ID</td></tr>";

    if (mysqli_num_rows($sales) > 0) {

        while ($row = mysqli_fetch_assoc($sales)) {

            echo "<tr>";
            echo "<td>".$row['sale_id']."</td>";
            echo "<td>".$row['first_name']." ".$row['last_name']."</td>";
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

    echo "<br>";
}

/* CLOSE */
mysqli_close($conn);

?>