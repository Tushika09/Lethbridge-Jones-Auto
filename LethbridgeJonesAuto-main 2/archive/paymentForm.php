<?php 
if(isset($_POST['submit'])){
    $customer_id = $_POST['customer_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $DOB = $_POST['DOB'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];

    $payment_number = $_POST['payment_number'];
    $sale_id = $_POST['sale_id'];
    $due_date = $_POST['due_date'];
    $paid_date = $_POST['paid_date'];
    $amount_due = $_POST['amount_due'];
    $amount_paid = $_POST['amount_paid'];
    $bank_account = $_POST['bank_account'];


   $host = 'localhost';
   $username = "root";
   $password = "";
   $dbname = "lethbridge_autojones";

   $conn = mysqli_connect($host, $username, $password, $dbname);
   
   $sql1 = "INSERT INTO customer(customer_id, first_name, last_name, 
                                 gender, DOB, phone_number, address, city, state, zip)
                    VALUES ('$customer_id', '$first_name', '$last_name', 
                            '$gender', '$DOB', '$phone_number', '$address', 
                            '$city', '$state', '$zip')";
    
                    mysqli_query($conn, $sql1);

   $sql2 = "INSERT INTO payment(payment_number, sale_id, 
                                due_date, paid_date, amount_due, 
                                amount_paid, bank_account) 
                      VALUES ('$payment_number', '$sale_id', 
                              '$due_date', '$paid_date', '$amount_due', 
                              '$amount_paid', '$bank_account'
                              )";  
            
                     mysqli_query($conn, $sql2);

    echo "Data inserted successfully";

    mysqli_close($conn);
   
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Form 4 - Payment</title>
</head>
<body>

<form action="#" method="POST">

<table border="1" width = "800">
  
    <!-- Top Section -->
    <tr>
       <th colspan="6">Customer Information</th>
    </tr>

        <!-- Customer Information -->
    <tr>
        <td> Customer ID: </td> <td><input type="text" name="customer_id"></td>
        <td> First Name: </td> <td><input type="text" name="first_name"></td>
        <td> Last Name: </td> <td><input type="text" name="last_name"></td>
    </tr>

    <tr>
        <td>Gender: </td> <td><input type="text" name="gender"></td>
        <td>Date of Birth: </td><td><input type="date" name="DOB"></td>
        <td>Phone Number: </td><td><input type="number" name="phone_number"></td>
    </tr>

    <tr>
        <td>Address:</td><td><input type="text" name="address"></td>
        <td>City:</td><td><input type="text" name="city"></td>
        <td>State:</td><td><input type="text" name="state"></td>
    </tr>

    <tr>
        <td>Zip:</td><td><input type="text" name="zip"></td>  
    </tr>
      
    <tr>
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
</table>

<br>
<input type = "submit" name = "submit" value ="Submit">
</form>

<p align="center"><b>Form 4. Payment</b></p>

</body>
</html>

