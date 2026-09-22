<!-- INSTRUCTIONS:
Enter all employee info -->

<?php 
if(isset($_POST['submit'])){
    // $employee_id = $_POST['employee_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $job_title = $_POST['job_title'];
    $phone_number = $_POST['phone_number'];


   $host = 'localhost';
   $username = "root";
   $password = "";
   $dbname = "lethbridge_autojones";

   $conn = mysqli_connect($host, $username, $password, $dbname);
   
   $sql1 = "INSERT INTO employee(first_name, last_name, 
                                 job_title, phone_number)
                    VALUES ('$first_name', '$last_name', 
                            '$job_title', '$phone_number')";
    
                    mysqli_query($conn, $sql1);

    echo "Data inserted successfully";

    mysqli_close($conn);
   
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>New employee</title>
</head>
<body>

<form action="#" method="POST">

<table border="1" width = "800">
  
    <!-- Top Section -->
    <tr>
       <th colspan="6">Employee Information</th>
    </tr>

        <!-- Employee Information -->
    <tr>
        <!-- <td> Employee ID: </td> <td><input type="text" name="employee_id"></td> -->
        <td> First Name: </td> <td><input type="text" name="first_name"></td>
        <td> Last Name: </td> <td><input type="text" name="last_name"></td>
    </tr>

    <tr>
        <td>Job Title: </td> <td><input type="text" name="job_title"></td>
        <td>Phone Number: </td><td><input type="number" name="phone_number"></td>
    </tr>

<br>
<input type = "submit" name = "submit" value ="Submit">
</form>

<p align="center"><b>New employee</b></p>

</body>
</html>