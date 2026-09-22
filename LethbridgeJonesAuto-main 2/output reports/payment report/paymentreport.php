<?php

$host = 'localhost';
$username = "root";
$password = "";
$dbname = "lethbridge_autojones";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed");
}

$sale_id = $_POST['sale_id'];
$payment_number = $_POST['payment_number'];

$sql = "SELECT * FROM payment WHERE sale_id = '$sale_id' and payment_number = '$payment_number'"; //payment
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "No payment found.";
    exit();
}

$payment = mysqli_fetch_assoc($result);

echo "<h2>Payment Report</h2>"; // output

echo "<table border='1'>";
echo "<tr><td>Payment Number</td><td>".$payment['payment_number']."</td></tr>";
echo "<tr><td>Sale ID</td><td>".$payment['sale_id']."</td></tr>";
echo "<tr><td>Due Date</td><td>".$payment['due_date']."</td></tr>";
echo "<tr><td>Paid Date</td><td>".$payment['paid_date']."</td></tr>";
echo "<tr><td>Amount Due</td><td>".$payment['amount_due']."</td></tr>";
echo "<tr><td>Amount Paid</td><td>".$payment['amount_paid']."</td></tr>";
echo "<tr><td>Bank Account #</td><td>".$payment['bank_account']."</td></tr>";
echo "</table>";

echo "<br>";

mysqli_close($conn);

?>

<!DOCTYPE html>
<html>
<body>

