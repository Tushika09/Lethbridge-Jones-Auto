<?php
require 'db.php';

$per_page = 5;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $per_page;

// YEAR FILTER
$year_filter = isset($_GET['year']) ? (int)$_GET['year'] : 0;
$where = "";
if ($year_filter > 0) {
    $where = "WHERE YEAR(p.purchase_date) = $year_filter";
}

// TOTAL RECORDS (WITH FILTER)
$count_sql = "SELECT COUNT(*) AS cnt FROM purchase p $where";
$total_res = $conn->query($count_sql);
$total_row = $total_res->fetch_assoc();
$total = (int)$total_row['cnt'];
$total_pages = max(1, (int)ceil($total / $per_page));

// GRAND TOTALS (WITH FILTER)
$totals_sql = "SELECT 
    SUM(p.price_paid) AS total_price_paid
FROM purchase p
$where";

$totals_result = $conn->query($totals_sql);
$totals = $totals_result->fetch_assoc();

// MAIN QUERY
$sql = "SELECT p.vehicle_id, p.purchase_date, p.location, p.auction, p.price_paid,
               v.make, v.model, v.year, v.colour, v.miles, v.vehicle_condition, v.book_price
        FROM purchase p
        LEFT JOIN vehicle v ON p.vehicle_id = v.vehicle_id
        $where
        ORDER BY p.vehicle_id DESC
        LIMIT $per_page OFFSET $offset";

$result = $conn->query($sql);

// PAGE TOTALS
$page_price_paid = 0;
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Purchase Report</title>
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

<h2>Purchase Report</h2>

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
<th>ID</th><th>Date</th><th>Vehicle</th><th>Color</th><th>Miles</th><th>Condition</th><th>Book Price</th><th>Location</th><th>Auction</th><th>Price Paid</th>
</tr>

<?php if ($result && $result->num_rows > 0): ?>
<?php while ($row = $result->fetch_assoc()):

$page_price_paid += $row['price_paid'];

?>
<tr>
<td><?php echo htmlspecialchars($row['vehicle_id']); ?></td>
<td><?php echo htmlspecialchars($row['purchase_date']); ?></td>
<td><?php echo htmlspecialchars($row['make'].' '.$row['model'].' '.$row['year']); ?></td>
<td><?php echo htmlspecialchars($row['colour']); ?></td>
<td><?php echo htmlspecialchars($row['miles']); ?></td>
<td><?php echo htmlspecialchars($row['vehicle_condition']); ?></td>
<td><?php echo number_format($row['book_price'], 2); ?></td>
<td><?php echo htmlspecialchars($row['location']); ?></td>
<td><?php echo htmlspecialchars($row['auction']); ?></td>
<td><?php echo number_format($row['price_paid'], 2); ?></td>
</tr>
<?php endwhile; ?>

<!-- PAGE TOTAL -->
<tr>
<th colspan="9">PAGE TOTAL</th>
<th><?php echo number_format($page_price_paid, 2); ?></th>
</tr>

<!-- GRAND TOTAL -->
<tr>
<th colspan="9">GRAND TOTAL</th>
<th><?php echo number_format($totals['total_price_paid'], 2); ?></th>
</tr>

<?php else: ?>
<tr><td colspan="10">No purchase records found.</td></tr>
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

<p><a href="form_purchase.php">Back to Purchase Form</a></p>

</body>
</html>