<?php
//header to give the order to the browser
include "../../koneksi.php";
session_start();
date_default_timezone_set("Asia/Jakarta");
$jam=date('d/m/Y h:i:s');	
$tgl=date('Y-m-d');
?>

<html>
	<head>
		<meta charset="UTF-8">
		<title>MUI-Electronic Data Interchange</title>
		<link rel="shortcut icon" href="../../favicon.ico">
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
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
			width: 100%;
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
			width: 100%;
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
						if (isset($_GET['sds_number'])) 
						{
							$sds_number = $_GET['sds_number'];
						}
							else
						{
							die ("Error. No ID Selected! ");	
						}				  
						$select_sdo = mysql_query("SELECT * FROM tb_supplier_delivery_schedule_details where sds_number='$sds_number' order by item_code");
						while($sdo=mysql_fetch_array($select_sdo)) 
						{
						?>
					  
						<tr>
							<td><?php echo $sdo['po_number']; ?></td>
							<td><?php echo $sdo['sds_number']; ?></td>
							<td><?php echo $sdo['sds_date']; ?></td>
							<td><?php echo $sdo['item_name']; ?></td>
							<td><?php echo $sdo['item_code']; ?></td>
							<td><?php echo $sdo['quantity_sds']; ?></td>
							<td><?php echo $sdo['outstanding_sdo']; ?></td>
						</tr>
	  
						<?php
						$menu_sds = 'Supplier Delivery Schedule';
						$insert_sds = "INSERT INTO tb_activity_log (date_time, username, supplier_name, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[supplier]', '$_SESSION[account_status]', '$menu_sds', 'SDS Details, SDS Number : ".$sds_number.", Part Name : ".$sdo['item_name'].", Part Number : ".$sdo['item_code'].", Quantity : ".$sdo['quantity_sds']."')";
						$query_insert_sds = mysql_query ($insert_sds);
						}
						?>	

						<?php
						$show1 = mysql_query("SELECT * FROM tb_supplier_delivery_schedule WHERE sds_number='$sds_number'");						
						if(mysql_num_rows($show1) == 0)
						{											
						}
							else
						{
							$rows_sup = mysql_fetch_assoc($show1);							
						}
						?>
						<tr>
							<td colspan=6></td>
							<td width=10% align="right">
								<a href="export_csv_sds_det.php?sds_number=<?=$rows_sup['sds_number'];?>">
									<input type="button" style="width:100%;" value="Export to CSV" />
								</a>
							</td>
						</tr>  
					</table>
				</div>
			</div>
		</div>
	</body>
</html>
