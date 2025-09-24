<?php
//header to give the order to the browser
include "../../koneksi.php";
session_start();
date_default_timezone_set("Asia/Jakarta");
$jam = date('d/m/Y h:i:s');	
$tgl = date('Y-m-d');

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("location: ../../index.php");
    exit();
}
?>

<html>
	<head>
		<meta charset="UTF-8">
		<title>MUI-Electronic Data Interchange</title>
		<link rel="shortcut icon" href="../../favicon.ico">
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" type="text/css" />
		<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
		<link href="../../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
		<link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
		<link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
		<style>
		input[type="button"] 
		{
			background-color: #4dc3ff;
			color: white;
			padding: 2px 2px;
			cursor: pointer;
			border: none;
			width: 55%;
		}
		
		input[type="button"]:hover 
		{
			opacity: 0.8;
		}	

		* {margin:0; padding: 0;}
		body 
		{
			font-family: calibri;
			font-size: 12px;
		}

		/* Tombol Button Pesan */
		#button {margin: 5% auto; width: 100px; text-align: center;}
		#button a 
		{
			width: 100px;
			height: 30px;
			vertical-align: middle;
			background-color: #F00;
			color: #fff;
			text-decoration: none;
			padding: 10px;
			border-radius: 5px;
			border: 1px solid transparent;
		}

		/* Jendela Pop Up */
		#popup 
		{
			width: 100%;
			height: 100%;
			position: fixed;
			background: rgba(0,0,0,.7);
			top: 0;
			left: 0;
			z-index: 9999;
			visibility: hidden;
		}

		.window 
		{
			width: 78%;
			height: 53%;
			background: #fff;
			border-radius: 10px;
			position: relative;
			padding: 10px;
			margin-top: 19%;
			margin-left: 15%;
		}
		
		.window h2 
		{
			margin: 30px 0 0 0;
		}
		
		/* Button Close */
		.close-button 
		{
			width: 3%;
			height: 8%;
			line-height: 23px;
			background: #000;
			border-radius: 50%;
			border: 3px solid #fff;
			display: block;
			text-align: center;
			color: #fff;
			text-decoration: none;
			position: absolute;
			top: -10px;
			right: -10px;	
		}

		/* Memunculkan Jendela Pop Up*/
		#popup:target 
		{
			visibility: visible;
		}
		</style>
	</head>

	<body>
		<div id="popup">
			<div class="window">
			<a href="sds_product.php" class="close-button" title="Close">X</a>
			<div class="box-header">
				<h3 class="box-title"><b>Supplier Delivery Schedule</b></h3>
			</div><!-- /.box-header -->
			<div style='width:100%;height:90%;overflow:auto;'>
				<table id="example1" class="table table-bordered table-striped">
					<tr>
						<th>PO Number</th>
						<th>SDS Number</th>
						<th>Schedule Date</th>
						<th>Item Description</th>
						<th>Item Code</th>
						<th>Quantity</th>
						<th>OS Delivery</th>
					</tr>
			  
					<?php
					// Validate and sanitize input
					if (isset($_GET['sds_number'])) {
						$sds_number = mysqli_real_escape_string($conn, $_GET['sds_number']);
					} else {
						die ("Error. No ID Selected!");	
					}

					// Using prepared statements for security
					$stmt = mysqli_prepare($conn, "SELECT * FROM tb_supplier_delivery_schedule_details WHERE sds_number = ? ORDER BY item_code");
					mysqli_stmt_bind_param($stmt, "s", $sds_number);
					mysqli_stmt_execute($stmt);
					$select_sdo = mysqli_stmt_get_result($stmt);

					if (!$select_sdo) {
						die("Query failed: " . mysqli_error($conn));
					}

					while($sdo = mysqli_fetch_array($select_sdo)) {
						// Sanitize output
						$po_number = htmlspecialchars($sdo['po_number']);
						$sds_number_esc = htmlspecialchars($sdo['sds_number']);
						$schedule_date = htmlspecialchars($sdo['schedule_date']?? 'N/A');
						$item_description = htmlspecialchars($sdo['item_description'] ?? 'N/A');
						$item_code = htmlspecialchars($sdo['item_code']);
						$quantity = htmlspecialchars($sdo['quantity'] ?? 'N/A');
						$outstanding_delivery = htmlspecialchars($sdo['outstanding_delivery']?? 'N/A');
					?>
					  
					<tr>
						<td><?php echo $po_number; ?></td>
						<td><?php echo $sds_number_esc; ?></td>
						<td><?php echo $schedule_date; ?></td>
						<td><?php echo $item_description; ?></td>
						<td><?php echo $item_code; ?></td>
						<td><?php echo $quantity; ?></td>
						<td><?php echo $outstanding_delivery; ?></td>
					</tr>
	  
					<?php
					// Log activity with prepared statement
					$menu_sds = 'Supplier Delivery Schedule';
					$activity_description = "SDS Details, SDS Number: " . $sds_number . ", Part Name: " . $item_description . ", Part Number: " . $item_code . ", Quantity: " . $quantity;
					
					$stmt_log = mysqli_prepare($conn, "INSERT INTO tb_activity_log (date_time, username, supplier, account_status, menu, activity_description) VALUES (?, ?, ?, ?, ?, ?)");
					mysqli_stmt_bind_param($stmt_log, "ssssss", $jam, $_SESSION['username'], $_SESSION['supplier'], $_SESSION['account_status'], $menu_sds, $activity_description);
					mysqli_stmt_execute($stmt_log);
					mysqli_stmt_close($stmt_log);
					}

					mysqli_stmt_close($stmt);
					?>	

					<?php
					// Get SDS info with prepared statement
					$stmt2 = mysqli_prepare($conn, "SELECT * FROM tb_supplier_delivery_schedule WHERE sds_number = ?");
					mysqli_stmt_bind_param($stmt2, "s", $sds_number);
					mysqli_stmt_execute($stmt2);
					$show1 = mysqli_stmt_get_result($stmt2);
					
					$rows_sup = null;
					if(mysqli_num_rows($show1) > 0) {
						$rows_sup = mysqli_fetch_assoc($show1);
					}
					mysqli_stmt_close($stmt2);
					?>
					
					<tr>
						<td colspan=6></td>
						<td width=10% align="right">
							<?php if ($rows_sup): ?>
							<a href="export_csv_sds_det.php?sds_number=<?= urlencode($rows_sup['sds_number']); ?>">
								<input type="button" style="width:100%;" value="Export to CSV" />
							</a>
							<?php endif; ?>
						</td>
					</tr>  
				 </table>
			</div>
			</div>
		</div>

		<!-- JavaScript untuk auto-popup -->
		<script>
			window.onload = function() {
				// Auto show popup when page loads
				window.location.href = '#popup';
				
				// Close popup when clicking outside
				document.getElementById('popup').addEventListener('click', function(e) {
					if (e.target === this) {
						window.location.href = 'sds_product.php';
					}
				});
			}
		</script>
	</body>
</html>