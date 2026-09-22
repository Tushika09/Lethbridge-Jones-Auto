<?php 
if(isset($_POST['submit'])){
    $customer_id = $_POST['customer_id'];
    $employee_id = $_POST['employee_id'];
    $vehicle_id = $_POST['vehicle_id'];
    $sale_date = $_POST['sale_date'];
    $sale_price = $_POST['sale_price'];
    $down_payment = $_POST['down_payment'];
    $finance_term_length = $_POST['finance_term_length'];
    $interest = $_POST['interest'];
    $commission = $_POST['commission'];
    $open_closed = "open"; // All sales start as open, closed when fully paid off

   $host = 'localhost';
   $username = "root";
   $password = "";
   $dbname = "lethbridge_autojones";

   $conn = mysqli_connect($host, $username, $password, $dbname);
   
   $sql1 = "INSERT INTO sale(vehicle_id, customer_id, sale_date, sale_price, down_payment, finance_term_length, interest, commission, employee_id, open_closed)
                    VALUES ('$vehicle_id', '$customer_id', '$sale_date', 
                            '$sale_price', '$down_payment', '$finance_term_length', '$interest', 
                            '$commission', '$employee_id', '$open_closed')";
    
                    mysqli_query($conn, $sql1);

    echo "Data inserted successfully";

    mysqli_close($conn);
   
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>New Customer</title>
</head>
<body>

<form action="#" method="POST">

<table border="1" width = "800">
  
    <!-- Top Section -->
    <tr>
       <th colspan="6">Sale Information</th>
    </tr>

        <!-- Sale Information -->
    <tr>
        <td> Customer ID: </td> <td><input type="number" name="customer_id"></td>
        <td> Employee ID: </td> <td><input type="number" name="employee_id"></td>
        <td> Vehicle ID: </td> <td><input type="number" name="vehicle_id"></td>
    </tr>

    <tr>
        <td>Sale Date: </td> <td><input type="date" name="sale_date"></td>
        <td>Sale Price: </td><td><input type="number" name="sale_price"></td>
        <td>Down Payment: </td><td><input type="number" name="down_payment"></td>
    </tr>

    <tr>
        <td>Finance Term Length:</td><td><input type="number" name="finance_term_length"></td>
        <td>interest:</td><td><input type="number" name="interest"></td>
        <td>Commission:</td><td><input type="number" name="commission"></td>
          
    <!-- <tr>
        <th>Payment Number</th>
        <th>Sale ID </th>
        <th>Due Date </th>
        <th>Payment Date </th>
        <th>Amount Due</th>
        <th> Amount Paid </th>
        <th>Bank Account</th>

    </tr>

    <tr>
        <td><input type ="number" name="payment_number"></td>
        <td><input type ="text" name="sale_id"></td>
        <td><input type ="date"  name="due_date"></td>
        <td><input type = "date" name = "paid_date"></td>
        <td><input type = "number" step = "0.01" name = "amount_due"></td>
        <td><input type ="number" step = "0.01" name = "amount_paid"></td>
        <td><input type="text" name="bank_account"></td>
    </tr>
</table> -->

<br>
<input type = "submit" name = "submit" value ="Submit">
</form>

<p align="center"><b>New Sale</b></p>

</body>
</html>