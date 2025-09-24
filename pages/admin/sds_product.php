<?php
session_start();
include "../../koneksi.php";
date_default_timezone_set("Asia/Jakarta");
$jam=date('d/m/Y h:i:s');
$tgl=date('Y-m-d');
	
$query = "SELECT po_number FROM tb_purchase_order WHERE edi_status='RECEIVED' AND po_status = 1 ORDER BY po_number";
$rs = mysqli_query($conn, $query) or die(mysqli_error($conn));
$cbstr = "";
while ($r = mysqli_fetch_array($rs)) {
    $cbstr .= "<option value='" . htmlspecialchars($r['po_number']) . "'>" . htmlspecialchars($r['po_number']) . "</option>";
}

$timeout = 60; 
$logout_redirect_url = "../../index.php";
$timeout = $timeout * 60; 
if (isset($_SESSION['start_time'])) 
{
	$elapsed_time = time() - $_SESSION['start_time'];
	if ($elapsed_time >= $timeout) 
	{
		session_destroy();
		echo "<script>alert('This session has timeout!'); window.location = '$logout_redirect_url'</script>";
	}
}
$_SESSION['start_time'] = time();
?>

<!DOCTYPE html>
<html>
	<meta charset="UTF-8">
	<title>MUI-Electronic Data Interchange</title>
	<link rel="shortcut icon" href="../../favicon.ico">
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />-->
	<link href="../../plugins/fontawesome-free-5.0.2/svg-with-js/css/fa-svg-with-js.css" rel="stylesheet" type="text/css" />
	<link href="../../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
	<link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
	<link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
	<head>
	<style>
		.body 
		{
			font-size: 12px;
		}
			
		.header 
		{
		font-size: 13px;
		}
  
		button 
		{
			background-color: #4dc3ff;
			color: white;
			padding: 2px 2px;
			cursor: pointer;
			border: none;
			width: 100%;
		}
		
		button:hover 
		{
			opacity: 0.8;
		}
		
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
		
		select.Menu 
		{
			font-size: 14px;
			font-family: calibri;
		}
  
		/* Tombol Button Pesan */
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
			margin-left: 20%;
		}
		
		.window h2 
		{
			margin: 30px 0 0 0;
		}
		
		/* Button Close */
		.close-button 
		{
			width: 3%;
			height: 9%;
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
  
	<script type='text/javascript'>
	function createRequestObject() 
	{
		var ro;
		var browser = navigator.appName;
		if(browser == "Microsoft Internet Explorer")
		{
			ro = new ActiveXObject("Microsoft.XMLHTTP");
		}
		else
		{
			ro = new XMLHttpRequest();
		}
		return ro;
	}
	var xmlhttp = createRequestObject();
	function rubah(combobox)
	{
		var po_number = combobox.value;
		if (!po_number) return;
		xmlhttp.open('get', 'sds_data.php?po_number='+po_number, true);
		xmlhttp.onreadystatechange = function() 
		{
			if ((xmlhttp.readyState == 4) && (xmlhttp.status == 200))
			{
				document.getElementById("divkedua").innerHTML = xmlhttp.responseText;
			}
			return false;
		}
		xmlhttp.send(null);
	}
	function ceksubmit()
	{
		var div = document.getElementById("divkedua");
		if (!div.firstChild)
		{
			alert('Belum milih');
			return false;
		}
		document.forms[0].pilihan.value = div.firstChild.value;
		return true;
	}
	</script>
	</head>
  
	<body class="skin-blue">
		<div class="wrapper">
			<header class="main-header">
				<a href="#" class="logo" style="font-family:calibri; size:30px;"><i><b>MUI-</b>EDI</i></a>
				<nav class="navbar navbar-static-top" role="navigation">
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
						<i class="fas fa-bars"></i>
					</a>
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
							<li class="dropdown user user-menu">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<img src="../../dist/img/user.jpg" class="user-image" alt="User Image"/>
									<span class="hidden-xs"><?php echo $_SESSION['full_name']?></span>
								</a>
							<ul class="dropdown-menu">
								<li class="user-header">
									<img src="../../dist/img/user.jpg" class="img-circle" alt="User Image" />
									<p> Welcome, <?php echo $_SESSION['full_name']?><br><?php echo $_SESSION['supplier']?> </p>
								</li>  
								<li class="user-footer">
									<div class="pull-right">
										<a href="../login/act-logout.php?username=<?=$_SESSION['username'];?>&supplier=<?=$_SESSION['supplier'];?>" class="btn btn-default btn-flat">Logout</a>
									</div>
								</li>
							</ul>
							</li>
						</ul>
					</div>
				</nav>
			</header>
		
			<aside class="main-sidebar">
				<section class="sidebar">
					<ul class="sidebar-menu">
						<li class="header">MAIN NAVIGATION</li>
						<li class="active treeview">
							<a href="../../home_admin.php">
								<i class="fa fa-home"></i> <span>Home</span> 
							</a>
						</li>
						<li>
							<a href="po_product.php">
								<i class="fa fa-file-alt"></i> <span>Purchase Order</span> 
							</a>
						</li>
						<li>
							<a href="sds_product.php">
								<i class="fa fa-edit"></i> <span>Supplier Delivery Schedule</span> 
							</a>
						</li>
						<li class="treeview">
							<a href="#">
								<i class="fa fa-cubes"></i>
									<span>Inventory</span>
								<i class="fa fa-angle-down pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li><a href="do_product.php"><i class="fa fa-truck"></i> Delivery Order</a></li>
								<li><a href="replacement_product.php"><i class="fa fa-sync-alt"></i> Replacement</a></li>
							</ul>
						</li>
						<li>
							<a href="qc_product.php">
								<i class="fa fa-check-square"></i> <span>Quality Check</span>
							</a>
						</li>
						<li>
							<a href="summary_product.php">
								<i class="fa fa-calculator"></i> <span>Summary</span> 
							</a>
						</li>
						<li class="treeview">
							<a href="#">
								<i class="fa fa-file-image"></i>
									<span>GTF</span>
								<i class="fas fa-angle-down pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li><a href="upload_user.php"><i class="fa fa-upload"></i>Upload Drawing</a></li>
								<li><a href="transaction_history.php"><i class="fa fa-download"></i>Download Drawing</a></li>
							</ul>
						</li>
						<li>
							<a href="log_history.php">
								<i class="fa fa-history"></i> <span>Log History</span> 
							</a>
						</li>
						<li>
							<a href="user_information.php">
								<i class="fa fa-user"></i> <span>User Information</span> 
							</a>
						</li>
					</ul>
				</section>
			</aside>

			<div class="content-wrapper">
				<section class="content-header">
					<h1>&nbsp </h1>
					<ol class="breadcrumb">
						<li><a href="../../home_admin.php"><i class="fa fa-tachometer-alt"></i> Home</a></li>
						<li class="active">Supplier Delivery Schedule</li>
					</ol>
				</section>

					<section class="content">
						<div class="row">
							<div class="col-xs-12">
								<div class="box">              	
									<div class="box-header">
										<h3 class="box-title"><b>Supplier Delivery Schedule</b></h3>
									</div>
							  
								<div class="box-body">
								<table id="example1" class="table table-bordered table-striped">
								</table>
				  
								<div class='row'> 
									<div class='col-md-4'>
										<div class="box-header">
											<h4 class="box-title"><b>Previously</b></h4>
										</div>			  			  
										<table id="example1" class="table table-bordered table-striped">
											<tr>
												<th>SDS Date</th>
												<th>SDS Number</th>
												<th>Supplier</th>
												<th>Details</th>
											</tr>
											<?php
											$sql = mysqli_query($conn, "SELECT * FROM tb_supplier_delivery_schedule WHERE sds_date < '$tgl' and sds_status = 'OPEN' order by sds_number");
											while ( $sdo = mysqli_fetch_assoc( $sql ) ) 
											{
											?>				 					  
											<tr class="body">
												<td><?php echo $sdo['sds_date']; ?></td>
												<td><?php echo $sdo['sds_number']; ?></td>
												<td><?php echo $sdo['supplier_name']; ?></td>
												<td>
													<div id="button"><a href="<?php echo 'sds_det.php?sds_number='.$sdo['sds_number'];''?>#popup"><center><i class="fa fa-list"></i></center></a></div>
												</td>	
											</tr>
											<?php 	
											}
											?>
										</table>
									</div>
									
									<div class='col-md-4'>
										<div class="box-header">
											<h4 class="box-title"><b>Today</b></h4>
										</div><!-- /.box-header -->				  			  
										<table id="example1" class="table table-bordered table-striped">
											<tr>
												<th>SDS Date</th>
												<th>SDS Number</th>
												<th>Supplier</th>
												<th>Details</th>
											</tr>
											<?php
											$sql = mysqli_query($conn, "SELECT * FROM tb_supplier_delivery_schedule WHERE sds_date = '$tgl' and sds_status = 'OPEN' order by sds_number");
											while ( $sdo = mysqli_fetch_assoc( $sql ) ) 
											{
											?>				 					  
											<tr class="body">
												<td><?php echo $sdo['sds_date']; ?></td>
												<td><?php echo $sdo['sds_number']; ?></td>
												<td><?php echo $sdo['supplier_name']; ?></td>
												<td width=3%>
													<a href="<?php echo 'sds_det.php?sds_number='.$sdo['sds_number'];''?>#popup"><center><i class="fa fa-list"></i></center></a>
												</td>
											</tr>
											<?php	
											}
											?>
										</table>
									</div>
									
									<div class='col-md-4'>
										<div class="box-header">
											<h4 class="box-title"><b>Upcoming</b></h4>
										</div><!-- /.box-header -->				  			  
										<table id="example1" class="table table-bordered table-striped">
											<tr>
												<th>SDS Date</th>
												<th>SDS Number</th>
												<th>Supplier</th>
												<th>Details</th>
											</tr>
											<?php
											$sql = mysqli_query($conn, "SELECT * FROM tb_supplier_delivery_schedule WHERE sds_date > '$tgl' and sds_status = 'OPEN' order by sds_number");
											while ( $sdo = mysqli_fetch_assoc( $sql ) ) 
											{
											?>				 					  
											<tr class="body">
												<td><?php echo $sdo['sds_date']; ?></td>
												<td><?php echo $sdo['sds_number']; ?></td>
												<td><?php echo $sdo['supplier_name']; ?></td>
												<td width=3%>
													<a href="<?php echo 'sds_det.php?sds_number='.$sdo['sds_number'];''?>#popup"><center><i class="fa fa-list"></i></center></a>
												</td>
											</tr>
											<?php	
											}
											?>
										</table>
									</div> 
								</div>
								<br>
					  
								<form action="" method="POST">	
									<div style="overflow-x:auto;">  
										<table id="example1" class="table table-bordered table-striped">
											<tr>
												<td width=10% style="font-size:16px; font-family:calibri;" >PO Number</td>
												<td width=20%>
													<select class='Menu' name='pilihan1' onchange='javascript:rubah(this)'>
														<option>--Choose PO Number--</option><?php echo $cbstr; ?>
													</select>
												</td>								
												<td width=10% style="font-size:16px; font-family:calibri;" >SDS Number</td>
												<td width=40%>
													<select class='Menu' name="divkedua" id="divkedua">
														<option value="divkedua" selected>--Choose SDS Number--</option>
													</select>
												</td>
												<td width=10% align="right"><button name="tambah">Search</button></td>
														
											<?php																		
											if(isset($_POST['tambah']))
											{						
												$po_number = $_POST['pilihan1'];
												$sds_number = $_POST['divkedua'];							
												if ($po_number <> '--Choose PO Number--')
												{
													$query=mysqli_query($conn, "select * from tb_supplier_delivery_schedule_details where po_number = '$po_number' and sds_number='$sds_number' order by item_code");
													$cek=mysqli_num_rows($query);					
													?>
																
													<?php
													$show1 = mysqli_query($conn, "SELECT * FROM tb_supplier_delivery_schedule WHERE po_number = '$po_number' and sds_number='$sds_number'");						
													if(mysqli_num_rows($show1) == 0)
													{											
													}
													else
													{
														$rows_sup = mysqli_fetch_assoc($show1);							
													}
													?>											
											</tr>
										</table>
									</div>								
								</form>
								
								<div style="overflow-x:auto;">
									<table id="example1" class="table table-bordered table-striped">
										<tr>
											<td width=27%><b>PO Number &nbsp; &nbsp; : &nbsp; <?php echo $po_number?> </b></td>					
											<td width=25%><b>SDS Number &nbsp;: &nbsp; <?php echo $sds_number?> </b></td>						
											<td><b>Schedule Date &nbsp;: &nbsp; <?php echo $rows_sup['sds_date']; ?></b></td>
											<?php
											if($rows_sup['sds_status']=="OPEN")
											{
												echo"<td width=15%><b>Status : <a style='font-size:14px;color:red;'>OPEN</b></td>";
											}      
											else if($rows_sup['sds_status']=="CLOSE")
											{
												echo"<td width=15%><b>Status : <a style='font-size:14px;color:green;'>CLOSE</b></td>";
											}
												else
												{
													echo"<td width=15%><b>Status : <a style='font-size:14px;color:gray;'>CANCELLED</b></td>"; 
												}
												?>
										</tr>
									</table>
								</div>
								
								<div style="overflow-x:auto;">	
								<table id="example1" class="table table-bordered table-striped">
									<tr>
										<th>No</th>
										<th>Item Description</th>
										<th>Item Code</th>							
										<th>Quantity</th>
										<th>Outstanding Delivery</th>					  
									</tr>
											
									<?php
									if($cek)
									{
										$no = 1;
										while($row=mysqli_fetch_assoc($query))
										{
										?>
									<tr class="body">
										<?php $row['sds_number'];?>
										<?php $row['po_number'];?>
										<td width=4%><?php echo $no; ?></td>							
										<td><?php echo $row['item_description'];?></td>
										<td width=17%><?php echo $row['item_code'];?></td>							
										<td width=4%><?php echo $row['quantity'];?></td>
										<td width=14%><?php echo $row['outstanding_delivery'];?></td>
										<?php
										$activated = "UPDATE tb_supplier_delivery_schedule SET edi_status='RECEIVED' WHERE sds_number='".$sds_number."' ";
										$query2 = mysqli_query ($conn, $activated);
										$activated1 = "UPDATE tb_supplier_delivery_schedule SET sds_received_date='$jam' WHERE sds_number='".$sds_number."' ";
										$query3 = mysqli_query ($conn, $activated1);
										?>
									</tr>
									<?php $no++;							  
										}
										$menu_sds = 'Supplier Delivery Schedule';
										$insert_sds = "INSERT INTO tb_activity_log (date_time, username, supplier, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[supplier]', '$_SESSION[account_status]', '$menu_sds', 'Search PO Number : ".$po_number.", SDS Number : ".$sds_number."')";
										$query_insert_sds = mysqli_query ($conn, $insert_sds);	
									}
									?>

									<tr>
										<td colspan=4 width=10%></td>
										<td>
											<a href="export_csv_sds.php?sds_number=<?=$rows_sup['sds_number'];?>&po_number=<?=$rows_sup['po_number'];?>">
												<input type="button" style="width:100%;" value="Export to CSV" />
											</a>
										</td>
									</tr>																				
									<?php
									}							
									}
									?>	
									</table>
									</div>	
								</div>
								</div>
							</div>
						</div>
					</section>
				</div>
	  
			<footer class="main-footer">
				<div class="pull-right hidden-xs"></div>
				Version 1.1. Copyright &copy; 2017 MUI Information Technology Department. All rights reserved
			</footer>
		</div>

	<script src="../../plugins/jQuery/jQuery-2.1.3.min.js"></script>
	<script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="../../plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
	<script src="../../plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
	<script src="../../plugins/fontawesome-free-5.0.2/svg-with-js/js/fontawesome-all.min.js" type="text/javascript"></script>
	<script src="../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src='../../plugins/fastclick/fastclick.min.js'></script>
	<script src="../../dist/js/app.min.js" type="text/javascript"></script>
	<script src="../../dist/js/demo.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(function () 
	{
		$("#example1").dataTable();
		$('#example2').dataTable(
		{
			"bPaginate": true,
			"bLengthChange": false,
			"bFilter": false,
			"bSort": true,
			"bInfo": true,
			"bAutoWidth": false
		});
	});
	</script>
	</body>
</html>