<?php ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Form 1 - Purchase</title>
<style>
body{font-family:Times New Roman,serif;margin:10px;color:#000}
table{width:100%;border-collapse:collapse}
.outer{border:2px solid #000}
.outer td,.outer th{border:1px solid #000;vertical-align:top;padding:4px}
.center{text-align:center}
.section-title{font-size:22px;font-weight:bold}
.smallinput{width:98%;box-sizing:border-box;font-family:inherit;font-size:16px}
textarea{width:98%;box-sizing:border-box;font-family:inherit;font-size:16px;resize:vertical}
label{display:block;margin:4px 0}
.btn{padding:8px 16px;font-size:16px}
</style>
</head>
<body>
<form method="post" action="save_purchase.php">
<table class="outer">
<tr>
<td colspan="5" class="center section-title">Purchase</td>
</tr>
<tr>
<td style="width:18%">Date<br><br>Location<br><br>Seller<br><br>Auction (Yes/No)</td>
<td colspan="4">
<input class="smallinput" type="date" name="purchase_date" required><br><br>
<input class="smallinput" type="text" name="seller" required><br><br>
<input class="smallinput" type="text" name="location" required><br><br>
<select class="smallinput" name="auction" required>
<option value="">Select</option>
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</td>
</tr>
<tr>
<td colspan="5" class="center" style="font-size:18px">Vehicle Info</td>
</tr>
<tr>
<td style="width:32%">Make<br><br>Model<br><br>Year<br><br>Color<br><br>Miles<br><br>Condition<br><br>Book Price<br><br>Price Paid</td>
<td style="width:16%">
<input class="smallinput" type="text" name="make" required><br><br>
<input class="smallinput" type="text" name="model" required><br><br>
<input class="smallinput" type="number" name="year" min="1900" max="2100" required><br><br>
<input class="smallinput" type="text" name="colour"><br><br>
<input class="smallinput" type="number" name="miles" min="0"><br><br>
<input class="smallinput" type="text" name="vehicle_condition"><br><br>
<input class="smallinput" type="number" step="0.01" name="book_price"><br><br>
<input class="smallinput" type="number" step="0.01" name="price_paid" required><br><br>
</td>
<td style="width:7%" class="center">#</td>
<td style="width:22%" class="center">Problem</td>
<td style="width:23%" class="center">Est. Repair cost / Actual cost</td>
</tr>
<tr>
<td colspan="2"></td>
<td class="center">1</td>
<td><input class="smallinput" type="text" name="problem_1"></td>
<td>
<input class="smallinput" type="number" step="0.01" name="est_repair_cost_1" placeholder="Est. Repair Cost"><br><br>
<input class="smallinput" type="number" step="0.01" name="actual_cost_1" placeholder="Actual Cost">
</td>
</tr>
<tr>
<td colspan="2"></td>
<td class="center">2</td>
<td><input class="smallinput" type="text" name="problem_2"></td>
<td>
<input class="smallinput" type="number" step="0.01" name="est_repair_cost_2" placeholder="Est. Repair Cost"><br><br>
<input class="smallinput" type="number" step="0.01" name="actual_cost_2" placeholder="Actual Cost">
</td>
</tr>
<tr>
<td colspan="2"></td>
<td class="center">3</td>
<td><input class="smallinput" type="text" name="problem_3"></td>
<td>
<input class="smallinput" type="number" step="0.01" name="est_repair_cost_3" placeholder="Est. Repair Cost"><br><br>
<input class="smallinput" type="number" step="0.01" name="actual_cost_3" placeholder="Actual Cost">
</td>
</tr>
<tr>
<td colspan="2"></td>
<td class="center">4</td>
<td><input class="smallinput" type="text" name="problem_4"></td>
<td>
<input class="smallinput" type="number" step="0.01" name="est_repair_cost_4" placeholder="Est. Repair Cost"><br><br>
<input class="smallinput" type="number" step="0.01" name="actual_cost_4" placeholder="Actual Cost">
</td>
</tr>
<tr>
<td colspan="2"></td>
<td class="center">5</td>
<td><input class="smallinput" type="text" name="problem_5"></td>
<td>
<input class="smallinput" type="number" step="0.01" name="est_repair_cost_5" placeholder="Est. Repair Cost"><br><br>
<input class="smallinput" type="number" step="0.01" name="actual_cost_5" placeholder="Actual Cost">
</td>
</tr>
</table>
<br>
<button class="btn" type="submit">Save Purchase</button>
</form>
</body>
</html>