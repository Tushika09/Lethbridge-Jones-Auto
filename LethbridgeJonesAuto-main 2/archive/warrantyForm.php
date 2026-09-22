<?php 
if(isset($_POST['submit'])){
    $warranty_id = $_POST['warranty_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST["end_date"];
    $total_cost = $_POST['total_cost'];
    $monthly_cost = $_POST['monthly_cost'];
    $cost = $_POST['cost'];
    $deductible = $_POST['deductible'];
    $sale_id = $_POST['sale_id'];

    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $phone_number = $_POST['phone_number'];
    $employee_id = $_POST['employee_id'];
    $job_title = $_POST['job_title'];


   $host = 'localhost';
   $username = "root";
   $password = "";
   $dbname = "lethbridge_autojones";

   $conn = mysqli_connect($host, $username, $password, $dbname);



            $sql1 = "INSERT INTO employee(employee_id, first_name, 
                                         last_name, job_title, phone_number
                                         )  
                      VALUES ('$employee_id', '$first_name', 
                              '$last_name', '$job_title', '$phone_number' 
                              )";  
            
                     mysqli_query($conn, $sql1);

           $sql2 = "INSERT INTO warranty(warranty_id, start_date, end_date, cost, 
                                         deductible, sale_id
                                         )
                         VALUES ('$warranty_id', '$start_date', '$end_date', '$cost', 
                                 '$deductible', '$sale_id'
                                )";

                    mysqli_query($conn, $sql2);
            

    echo "Data inserted successfully";

    mysqli_close($conn);
   
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form 3 - Warranties</title>
</head>
<body>

<form action="#" method="POST">

<table border="1" width="800">

    <!-- Top Section -->
    <tr>
        <th colspan="2">Vehicle Info</th>
        <th colspan="2">Employee (Salesperson)</th>
    </tr>

    <tr>
        <!-- Vehicle Information -->
        <td colspan="2">
            <table border = "0">
                <tr>
                   <td> Sale ID: </td> <td> <input type="text" name="sale_id"> </td>
                </tr>

                <tr>
                   <td> Warranty Sale Date: </td> <td><input type="date" name="start_date"></td>
                </tr>

                <tr>
                    <td> End Date: </td> <td><input type = "date" name = "end_date"></td>
                </tr>
                 
                <tr>
                   <td> Total Cost: </td> <td> <input type="number" step="0.01" name="total_cost"></td>
                </tr>
            
               <tr>
                   <td> Monthly Cost: </td> <td> <input type="number" step="0.01" name="monthly_cost"> </td>
               </tr>
            </table>
        </td>
        <!-- Employee Information -->
        <td colspan="2">
            <table border = "0">
                <tr> 
                    <td> Employee ID: </td> <td><input type = "text" name = "employee_id"></td>
                </tr>
                <tr>
                   <td> Last Name: </td> <td><input type="text" name="last_name"></td>
                 </tr>
                <tr>
                   <td> First Name: </td> <td><input type="text" name="first_name"></td>
                </tr>
                <tr>
                    <td> Job Title: </td> <td> <input type = "text" name = "job_title"> </td>
                </tr>
                <tr>
                    <td> Phone Number: </td> <td><input type="text" name="phone_number"></td>
                </tr>
            </table>
        </td>
        
    </tr>

    <!-- Warranty Table Header -->
    <tr>
        <th>Warranty ID</th>
        <th> Start Date</th>
        <th>Length</th>
        <th>Cost</th>
        <th>Deductible</th>
    </tr>

    <!-- Warranty Row -->
    <tr>
        <td><input type="text" name="warranty_id"></td>
        <td><input type = "date" name ="start_date"></td>
        <td><input type="text" name="length"></td>
        <td><input type="number" step="0.01" name="cost"></td>
        <td><input type="number" step="0.01" name="deductible"></td>
    </tr>

    <!-- Items Covered -->
    <tr>
        <td colspan="5">
            Items covered:<br>
            <textarea name="items_covered" rows="3" cols="90"></textarea>
        </td>
    </tr>

    <!-- More Warranties -->
    <tr>
        <td colspan="5">
            More warranties:
        </td>
    </tr>

</table>

<br>
<input type = "submit" name = "submit" value ="Submit">

</form>

<p align="center"><b>Form 3. Warranties</b></p>

</body>
</html>