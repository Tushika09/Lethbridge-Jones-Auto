<?php ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Form 2 - Sales</title>
<style>
body{font-family:Times New Roman,serif;margin:10px;color:#000}
table{width:100%;border-collapse:collapse}
.outer{border:2px solid #000}
.outer td,.outer th{border:1px solid #000;vertical-align:top;padding:4px}
.center{text-align:center}
.section-title{font-size:22px;font-weight:bold}
.smallinput{width:98%;box-sizing:border-box;font-family:inherit;font-size:16px}
.btn{padding:8px 16px;font-size:16px}
</style>
</head>
<body>
<form method="post" action="save_sales.php">
<table class="outer">
<tr>
<td colspan="2" class="center section-title">Sale</td>
<td colspan="4" class="center section-title">Salesperson</td>
</tr>
<tr>
<td style="width:20%">Date<br><br>Total due<br><br>Down payment<br><br>Financed Amount</td>
<td style="width:20%">
<input class="smallinput" type="date" name="sale_date" required><br><br>
<input class="smallinput" type="number" step="0.01" name="total_due" required><br><br>
<input class="smallinput" type="number" step="0.01" name="down_payment" required><br><br>
<input class="smallinput" type="number" step="0.01" name="financed_amount" required>
</td>
<td style="width:20%">Last Name<br><br>First Name<br><br>Phone<br><br>Commission</td>
<td colspan="3">
<input class="smallinput" type="text" name="sales_last_name" required><br><br>
<input class="smallinput" type="text" name="sales_first_name" required><br><br>
<input class="smallinput" type="text" name="sales_phone"><br><br>
<input class="smallinput" type="number" step="0.01" name="commission">
</td>
</tr>
<tr>
<td colspan="2" class="center section-title">Customer</td>
<td colspan="4" class="center section-title">Employment History</td>
</tr>
<tr>
<td style="width:20%">
    <!-- Customer ID -->
    <br><br>Phone<br><br>Last Name<br><br>First Name<br><br>Address<br><br>City<br><br>State<br><br>Zip</td>
<td style="width:20%">
<!-- <input class="smallinput" type="text" name="customer_id"> --><br><br>
<input class="smallinput" type="text" name="customer_phone"><br><br>
<input class="smallinput" type="text" name="customer_last_name" required><br><br>
<input class="smallinput" type="text" name="customer_first_name" required><br><br>
<input class="smallinput" type="text" name="customer_address"><br><br>
<input class="smallinput" type="text" name="customer_city"><br><br>
<input class="smallinput" type="text" name="customer_state"><br><br>
<input class="smallinput" type="text" name="customer_zip">
</td>
<td style="width:20%">Employer<br><br>Title<br><br>Super.<br><br>Phone<br><br>Address<br><br>Start</td>
<td colspan="3">
<input class="smallinput" type="text" name="employer"><br><br>
<input class="smallinput" type="text" name="job_title"><br><br>
<input class="smallinput" type="text" name="supervisor"><br><br>
<input class="smallinput" type="text" name="employer_phone"><br><br>
<input class="smallinput" type="text" name="employer_address"><br><br>
<input class="smallinput" type="date" name="employment_start">
</td>
</tr>
<tr>
<td colspan="2" class="center section-title">Vehicle Info</td>
<td colspan="4"></td>
</tr>
<tr>
<td style="width:20%">Miles<br><br>Condition<br><br>Book Price</td>
<td style="width:20%">
<input class="smallinput" type="number" name="miles" min="0"><br><br>
<input class="smallinput" type="text" name="vehicle_condition"><br><br>
<input class="smallinput" type="number" step="0.01" name="book_price">
</td>
<td style="width:20%">Sale Price<br><br>Style (Sedan, SUV, ...)<br><br>Interior Color</td>
<td colspan="3">
<input class="smallinput" type="number" step="0.01" name="sale_price" required><br><br>
<input class="smallinput" type="text" name="style"><br><br>
<input class="smallinput" type="text" name="interior_color">
</td>
</tr>
</table>
<br>
<button class="btn" type="submit">Save Sale</button>
</form>
</body>
</html>
