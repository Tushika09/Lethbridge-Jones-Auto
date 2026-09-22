<?php
require 'db.php';

$per_page = 5;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $per_page;

// YEAR FILTER
$year_filter = isset($_GET['year']) ? (int)$_GET['year'] : 0;
$where = "";
if ($year_filter > 0) {
    $where = "WHERE YEAR(s.sale_date) = $year_filter";
}

// TOTAL RECORDS (WITH FILTER)
$count_sql = "SELECT COUNT(*) AS cnt FROM sale s $where";
$total_res = $conn->query($count_sql);
$total_row = $total_res->fetch_assoc();
$total = (int)$total_row['cnt'];
$total_pages = max(1, (int)ceil($total / $per_page));

// GRAND TOTALS (WITH FILTER)
$totals_sql = "SELECT 
    SUM(s.sale_price) AS total_sale_price,
    -- SUM(s.total_due) AS total_total_due,
    SUM(s.down_payment) AS total_down_payment,
    -- SUM(s.financed_amount) AS total_financed,
    SUM(s.commission) AS total_commission
FROM sale s
$where";

$totals_result = $conn->query($totals_sql);
$totals = $totals_result->fetch_assoc();

// MAIN QUERY
$sql = "SELECT s.sale_id, s.sale_date, s.down_payment, s.sale_price, s.commission,
               c.first_name AS cust_first_name, c.last_name AS cust_last_name,
               e.first_name AS emp_first_name, e.last_name AS emp_last_name,
               v.make, v.model, v.year
        FROM sale s
        LEFT JOIN customer c ON s.customer_id = c.customer_id
        LEFT JOIN employee e ON s.employee_id = e.employee_id
        LEFT JOIN vehicle v ON s.vehicle_id = v.vehicle_id
        $where
        ORDER BY s.sale_id DESC
        LIMIT $per_page OFFSET $offset";

$result = $conn->query($sql);

// PAGE TOTALS
$page_sale_price = 0;
// $page_total_due = 0;
$page_down_payment = 0;
// $page_financed = 0;
$page_commission = 0;
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Sales Report</title>
<style>
body{font-family:Times New Roman,serif;margin:10px;color:#000}
table{width:100%;border-collapse:collapse}
th,td{border:1px solid #000;padding:6px;font-size:14px;vertical-align:top}
th{background:#eee}
nav a{margin:0 5px;text-decoration:none}
form{margin-bottom:10px}
</style>
</head>
<body>

<h2>Sales Report</h2>

<!-- YEAR FILTER -->
<form method="GET">
    <label>Filter by Year:</label>
    <select name="year">
        <option value="">All</option>
        <?php for ($y = date("Y"); $y >= 2020; $y--): ?>
            <option value="<?php echo $y; ?>" <?php if ($year_filter == $y) echo "selected"; ?>>
                <?php echo $y; ?>
            </option>
        <?php endfor; ?>
    </select>
    <button type="submit">Filter</button>
</form>

<table>
<tr>
<th>ID</th><th>Date</th><th>Customer</th><th>Salesperson</th><th>Vehicle</th>
<th>Sale Price</th><th>Down Payment</th><th>Commission</th>
</tr>

<?php if ($result && $result->num_rows > 0): ?>
<?php while ($row = $result->fetch_assoc()): 

// accumulate page totals
$page_sale_price += $row['sale_price'];
// $page_total_due += $row['total_due'];
$page_down_payment += $row['down_payment'];
// $page_financed += $row['financed_amount'];
$page_commission += $row['commission'];

?>
<tr>
<td><?php echo htmlspecialchars($row['sale_id']); ?></td>
<td><?php echo htmlspecialchars($row['sale_date']); ?></td>

<td>
<?php 
echo !empty($row['cust_first_name']) 
    ? htmlspecialchars($row['cust_first_name'].' '.$row['cust_last_name']) 
    : 'No Customer'; 
?>
</td>

<td>
<?php 
echo !empty($row['emp_first_name']) 
    ? htmlspecialchars($row['emp_first_name'].' '.$row['emp_last_name']) 
    : 'No Employee'; 
?>
</td>

<td>
<?php 
echo !empty($row['make']) 
    ? htmlspecialchars($row['make'].' '.$row['model'].' '.$row['year']) 
    : 'No Vehicle'; 
?>
</td>

<td><?php echo number_format($row['sale_price'], 2); ?></td>
<!-- <td><?php echo number_format($row['total_due'], 2); ?></td> -->
<td><?php echo number_format($row['down_payment'], 2); ?></td>
<!-- <td><?php echo number_format($row['financed_amount'], 2); ?></td> -->
<td><?php echo number_format($row['commission'], 2); ?></td>
</tr>
<?php endwhile; ?>

<!-- PAGE TOTAL -->
<tr>
<th colspan="5">PAGE TOTAL</th>
<th><?php echo number_format($page_sale_price, 2); ?></th>
<!-- <th><?php echo number_format($page_total_due, 2); ?></th> -->
<th><?php echo number_format($page_down_payment, 2); ?></th>
<!-- <th><?php echo number_format($page_financed, 2); ?></th> -->
<th><?php echo number_format($page_commission, 2); ?></th>
</tr>

<!-- GRAND TOTAL -->
<tr>
<th colspan="5">GRAND TOTAL</th>
<th><?php echo number_format($totals['total_sale_price'], 2); ?></th>
<!-- <th><?php echo number_format($totals['total_total_due'], 2); ?></th> -->
<th><?php echo number_format($totals['total_down_payment'], 2); ?></th>
<!-- <th><?php echo number_format($totals['total_financed'], 2); ?></th> -->
<th><?php echo number_format($totals['total_commission'], 2); ?></th>
</tr>

<?php else: ?>
<tr><td colspan="10">No sales records found.</td></tr>
<?php endif; ?>

</table>

<p>Page <?php echo $page; ?> of <?php echo $total_pages; ?></p>

<nav>
<?php if ($page > 1): ?>
<a href="?page=1&year=<?php echo $year_filter; ?>">First</a>
<a href="?page=<?php echo $page-1; ?>&year=<?php echo $year_filter; ?>">Previous</a>
<?php endif; ?>

<?php if ($page < $total_pages): ?>
<a href="?page=<?php echo $page+1; ?>&year=<?php echo $year_filter; ?>">Next</a>
<a href="?page=<?php echo $total_pages; ?>&year=<?php echo $year_filter; ?>">Last</a>
<?php endif; ?>
</nav>

<p><a href="form_sales.php">Back to Sales Form</a></p>

</body>
</html>