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
$show_sales = $_POST['show_sales'];

if ($search_type == "id") { // customer data
    $sql = "SELECT * FROM customer WHERE customer_id = '$search_value'";
} elseif ($search_type == "first_name") {
    $sql = "SELECT * FROM customer WHERE first_name = '$search_value'";
} else {
    $sql = "SELECT * FROM customer WHERE last_name = '$search_value'";
}

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "No customer found.";
    exit();
}

$emp = mysqli_fetch_assoc($result);

echo "<h2>Customer Report</h2>";//output record

echo "<table border='1'>";
echo "<tr><td>ID</td><td>".$emp['customer_id']."</td></tr>";
echo "<tr><td>Name</td><td>".$emp['first_name']." ".$emp['last_name']."</td></tr>";
echo "<tr><td>Phone number</td><td>".$emp['phone_number']."</td></tr>";
echo "</table>";

echo "<br>";

//sales
if ($show_sales == "yes") {

    $sql2 = "SELECT * FROM sale WHERE customer_id = '".$emp['customer_id']."'";
    $sales = mysqli_query($conn, $sql2);

    $total_sales = 0;
    $number_of_purchases = 0;

    echo "<h3>Sales Records</h3>";

    echo "<table border='1'>";
    echo "<tr><td>Sale ID</td><td>Price</td><td>Commission</td></tr>";

    if (mysqli_num_rows($sales) > 0) {

        while ($row = mysqli_fetch_assoc($sales)) {

            echo "<tr>";
            echo "<td>".$row['sale_id']."</td>";
            echo "<td>".$row['sale_price']."</td>";
            echo "<td>".$row['commission']."</td>";
            echo "</tr>";

            $total_sales = $total_sales + $row['sale_price'];
            $number_of_purchases = $number_of_purchases + 1;
        }

    } else {
        echo "<tr><td colspan='3'>No sales found</td></tr>";
    }

    echo "</table>";

    echo "<br>";
    echo "<h3>Total Spent: ".$total_sales."<h3>";
    echo "<h3>Number of Purchases: ".$number_of_purchases."<h3><br>";
}

/* CLOSE */
mysqli_close($conn);

?>