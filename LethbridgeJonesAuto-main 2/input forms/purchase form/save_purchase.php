<?php
require 'db.php'; // include your DB connection

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request');
}
// Start transaction


   $host = 'localhost';
   $username = "root";
   $password = "";
   $dbname = "lethbridge_autojones";

   $conn = mysqli_connect($host, $username, $password, $dbname);

// try {
    //throw new Exception('Testing error handling'); // <-- Remove this line after testing
    // --- 1. Collect vehicle data ---
    $make = $_POST['make'] ?? '';
    $model = $_POST['model'] ?? '';
    $year = $_POST['year'] ?? '';
    $colour = $_POST['colour'] ?? '';
    $miles = $_POST['miles'] ?? '';
    $vehicle_condition = $_POST['vehicle_condition'] ?? '';
    $book_price = $_POST['book_price'] ?? 0;

    // Insert vehicle
    $stmt = $conn->prepare("INSERT INTO vehicle (make, model, year, colour, miles, vehicle_condition, book_price) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssisisd', $make, $model, $year, $colour, $miles, $vehicle_condition, $book_price);
    $stmt->execute();
    $vehicle_id = $conn->insert_id;
    $stmt->close();

    // --- 2. Collect purchase data ---
    $purchase_date = $_POST['purchase_date'] ?? '';
    $location = $_POST['location'] ?? '';
    $seller = $_POST['seller'] ?? '';
    $auction = $_POST['auction'] ?? '';
    // Convert auction to integer
    if ($auction == 'Yes') {
        $auction = 1;
    } else {$auction = 0;}
    $price_paid = $_POST['price_paid'] ?? 0;

    // Insert purchase
    $stmt = $conn->prepare("INSERT INTO purchase (vehicle_id, purchase_date, location, seller, auction, price_paid) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('isssid', $vehicle_id, $purchase_date, $location, $seller, $auction, $price_paid);
    $stmt->execute();
    $purchase_id = $conn->insert_id;
    $stmt->close();

    // --- 3. Collect problem/repair data ---
    // --- Collect problems ---
    $problems = [];
    for ($i = 1; $i <= 5; $i++) {
        $p = trim($_POST["problem_$i"] ?? '');
        $e = $_POST["eestimated_repair_cost$i"] ?? 0;
        $a = $_POST["actual_repair_cost$i"] ?? 0;

        // Only insert if any value exists
        if ($p !== '' || $e !== '' || $a !== '') {

            // Validate numeric fields
            $e = is_numeric($e) ? floatval($e) : 0;
            $a = is_numeric($a) ? floatval($a) : 0;

            $problems[] = [$i, $p, $e, $a];
        }
    }

    // --- Insert problems if any ---
    // if (!empty($problems)) {
    //     $stmt2 = $conn->prepare("INSERT INTO problem (vehicle_id, problem_type, problem_description, eestimated_repair_cost, actual_repair_cost) VALUES (?, ?, ?, ?, ?)");
    //     foreach ($problems as $row) {
    //         [$no, $p, $e, $a] = $row;
    //         $stmt2->bind_param('issdd', $vehicle_id, $no, $p, $e, $a); // numeric as float
    //         $stmt2->execute();
    //     }
    //     $stmt2->close();
    // }
    // --- Done ---
    echo "<p>Purchase saved successfully!</p>";
// } 
// catch (Exception $ex) {
//     // Rollback if anything failed
//     $conn->rollback();
//     $message = 'Error saving purchase: ' . $ex->getMessage();
//     echo "<p>Error saving purchase: $message</p>";
// }
echo '<p><a href="form_purchase.php">Back to Form</a></p>';

?>