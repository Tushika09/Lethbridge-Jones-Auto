<?php
require 'db.php'; // DB connection

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Invalid request');
}

$conn->autocommit(FALSE);

// Start transaction
$conn->begin_transaction();

try {
    // --- 1. Customer ---
    $customer_id = null;//$_POST['customer_id'] ?? null;
    $customer_first_name = $_POST['customer_first_name'] ?? '';
    $customer_last_name = $_POST['customer_last_name'] ?? '';
    $customer_phone = $_POST['customer_phone'] ?? '';
    $customer_address = $_POST['customer_address'] ?? '';
    $customer_city = $_POST['customer_city'] ?? '';
    $customer_state = $_POST['customer_state'] ?? '';
    $customer_zip = $_POST['customer_zip'] ?? '';
    $customer_gender = "unk";
    $customer_dob = "2026-04-07";

    if ($customer_id != null) {
        $stmt = $conn->prepare("
            UPDATE customer 
            SET first_name=?, last_name=?, phone_number=?, address=?, city=?, state=?, zip=?, gender=?, DOB=?
            WHERE customer_id=?
        ");
        $stmt->bind_param('sssssssssi', $customer_first_name, $customer_last_name, $customer_phone, $customer_address, $customer_city, $customer_state, $customer_zip, $customer_gender, $customer_dob, $customer_id);
        $stmt->execute();
        $stmt->close();
    } else {
        $stmt = $conn->prepare("
            INSERT INTO customer (first_name, last_name, phone_number, address, city, state, zip, gender, DOB) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param('sssssssss', $customer_first_name, $customer_last_name, $customer_phone, $customer_address, $customer_city, $customer_state, $customer_zip, $customer_gender, $customer_dob);
        $stmt->execute();
        $customer_id = $conn->insert_id;
        $stmt->close();
    }

    // --- 2. Employment History (optional) ---
    $employer = $_POST['employer'] ?? '';
    $job_title = $_POST['job_title'] ?? '';
    $supervisor = $_POST['supervisor'] ?? '';
    $employer_phone = $_POST['employer_phone'] ?? '';
    $employer_address = $_POST['employer_address'] ?? '';
    $employment_start = $_POST['employment_start'] ?? '';

    if ($employer || $job_title) {
        $stmt = $conn->prepare("
            INSERT INTO customer_employment_history 
            (customer_id, employer, job_title, supervisor, phone_number, start_date)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param('isssss', $customer_id, $employer, $job_title, $supervisor, $employer_phone, $employment_start);
        $stmt->execute();
        $stmt->close();
    }

    // --- 3. Salesperson (employee) ---
    $sales_first_name = $_POST['sales_first_name'] ?? '';
    $sales_last_name = $_POST['sales_last_name'] ?? '';
    $sales_phone = $_POST['sales_phone'] ?? '';
    $commission = $_POST['commission'] ?? 0;
    $employee_job_title = "Salesperson";

    $stmt = $conn->prepare("SELECT employee_id FROM employee WHERE first_name=? AND last_name=? LIMIT 1");
    $stmt->bind_param('ss', $sales_first_name, $sales_last_name);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($employee_id);
        $stmt->fetch();
        $stmt->close();
    } else {
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO employee (first_name, last_name, phone_number, job_title) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $sales_first_name, $sales_last_name, $sales_phone, $employee_job_title);
        $stmt->execute();
        $employee_id = $conn->insert_id;
        $stmt->close();
    }

    // --- 4. Vehicle ---
    $vehicle_miles = $_POST['miles'] ?? 0;
    $vehicle_condition = $_POST['vehicle_condition'] ?? '';
    $book_price = $_POST['book_price'] ?? 0;
    $make = $_POST['make'] ?? '';
    $colour = $_POST['colour'] ?? '';

    $stmt = $conn->prepare("
        INSERT INTO vehicle (miles, vehicle_condition, book_price, make, colour) 
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param('idsss', $vehicle_miles, $vehicle_condition, $book_price, $make, $colour);
    $stmt->execute();
    $vehicle_id = $conn->insert_id;
    $stmt->close();

    // --- 5. Sale ---
    $sale_date = $_POST['sale_date'] ?? '';
    $total_due = $_POST['total_due'] ?? 0;
    $down_payment = $_POST['down_payment'] ?? 0;
    $financed_amount = $_POST['financed_amount'] ?? 0;
    $sale_price = $_POST['sale_price'] ?? 0;

    $stmt = $conn->prepare("
        INSERT INTO sale 
        (vehicle_id, customer_id, employee_id, sale_date, total_due, down_payment, financed_amount, sale_price, commission)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param('iiisddddd', $vehicle_id, $customer_id, $employee_id, $sale_date, $total_due, $down_payment, $financed_amount, $sale_price, $commission);
    $stmt->execute();
    $stmt->close();

    // --- Commit transaction ---
    $conn->commit();
    echo "<p>Sale saved successfully!</p>";

} catch (Exception $ex) {
    $conn->rollback();
    echo "<p>Error saving sale: " . $ex->getMessage() . "</p>";
}

echo '<p><a href="form_sales.php">Back to Form</a></p>';
?>
