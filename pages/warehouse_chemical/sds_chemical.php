<?php
session_start();
include "../../koneksi.php";
date_default_timezone_set("Asia/Jakarta");
$jam=date('d/m/Y h:i:s');
$tgl=date('Y-m-d');	
$query = "SELECT po_number FROM tb_purchase_order where edi_status='RECEIVED' and po_status = 1 and supplier='$_SESSION[supplier]' ORDER BY po_number";
$rs = mysql_query($query) or die(mysql_error());
$cbstr = "";
while ($r = mysql_fetch_array($rs))
{
	$cbstr .= "<option value='$r[po_number]'>$r[po_number]</option>";
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
	<head>
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
		<style>
		.body 
		{
			font-size: 12px;
		}
		button 
		{
			background-color: #4dc3ff;
			color: white;
			padding: 2px 2px;
			cursor: pointer;
			border: none;
			width: 45%;
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
			width: 45%;
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
						<a href="../../home_warehouse_chemical.php">
							<i class="fa fa-home"></i> <span>Home</span> 
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-file-alt"></i> <span>Purchase Order</span> 
						</a>
					</li>
					<li>
						<a href="sds_chemical.php">
							<i class="fa fa-edit"></i> <span>Supplier Delivery Schedule</span> 
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-truck"></i> <span>Delivery Order</span> 
						</a>
					</li>
					<li>
						<a href="#">
							<i class="fa fa-calculator"></i> <span>Summary</span> 
						</a>
					</li>
				</ul>
			</section>
		</aside>

		<div class="content-wrapper">
			<section class="content-header">
				<h1>&nbsp </h1>
				<ol class="breadcrumb">
					<li><a href="../../home_warehouse_chemical.php"><i class="fa fa-tachometer-alt"></i> Home</a></li>
					<li class="active">Supplier Delivery Schedule</li>
				</ol>
			</section>

			<section class="content">
				<div class="row">
					<div class="col-xs-12">
						<div class="box">              	
							<div class="box-header">
								<h3 class="box-title"><b>Supplier Delivery Schedule</b></h3>
							</div><!-- /.box-header -->
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
												<th>Details</th>
											</tr>
											<?php
											$sql = mysql_query("SELECT * FROM tb_supplier_delivery_schedule WHERE sds_date < '$tgl' and sds_status = 'OPEN' and supplier='$_SESSION[supplier]' order by sds_number");
											while ( $sdo = mysql_fetch_assoc( $sql ) )
											{
											?>				 					  
											<tr class="body">
												<td><?php echo $sdo['sds_date']; ?></td>
												<td><?php echo $sdo['sds_number']; ?></td>
												<td width=3%><a href="<?php echo 'sds_det.php?sds_number='.$sdo['sds_number'];''?>#popup">
												<center><i class="fa fa-list"></i></center></a></td>
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
												<th>Details</th>
											</tr>
											<?php
											$sql = mysql_query("SELECT * FROM tb_supplier_delivery_schedule WHERE sds_date = '$tgl' and sds_status = 'OPEN' and supplier='$_SESSION[supplier]' order by sds_number");
											while ( $sdo = mysql_fetch_assoc( $sql ) ) 
											{
											?>				 					  
											<tr class="body">
												<td><?php echo $sdo['sds_date']; ?></td>
												<td><?php echo $sdo['sds_number']; ?></td>
												<td width=3%><a href="<?php echo 'sds_det.php?sds_number='.$sdo['sds_number'];''?>#popup">
												<center><i class="fa fa-list"></i></center></a></td>
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
												<th>Details</th>
											</tr>
											<?php
											$sql = mysql_query("SELECT * FROM tb_supplier_delivery_schedule WHERE sds_date > '$tgl' and sds_status = 'OPEN' and supplier='$_SESSION[supplier]' order by sds_number");
											while ( $sdo = mysql_fetch_assoc( $sql ) ) 
											{
											?>				 					  
											<tr class="body">
												<td><?php echo $sdo['sds_date']; ?></td>
												<td><?php echo $sdo['sds_number']; ?></td>
												<td width=3%><a href="<?php echo 'sds_det.php?sds_number='.$sdo['sds_number'];''?>#popup">
												<center><i class="fa fa-list"></i></center></a></td>
											</tr>
											<?php	
											}
											?>
										</table>
									</div>
								</div>	
  
								<form action="" method="POST">		
									<table id="example1" class="table table-bordered table-striped">
										<tr>
											<td width=10% style="font-size:16px; font-family:calibri;" >PO Number</td>
											<td width=20%>
											<select class='Menu' name='pilihan1' onchange='javascript:rubah(this)'>
											<option>--Choose PO Number--</option><?php echo $cbstr; ?>
											</select>
											</td>								
											<td width=10% style="font-size:16px; font-family:calibri;" >SDS Number</td>
											<td width=20%>
											<select class='Menu' name="divkedua" id="divkedua"><option value="divkedua" selected>--Choose SDS Number--</option></select>
											</td>
											<td align="right"><button name="tambah">Search</button></td>							
											<?php																		
											if(isset($_POST['tambah']))
											{						
												$po_number = $_POST['pilihan1'];
												$sds_number = $_POST['divkedua'];							
												if ($po_number <> '--Choose PO Number--')
												{
													$query=mysql_query("select * from tb_supplier_delivery_schedule_details where po_number = '$po_number' and sds_number='$sds_number' order by item_code");
													$cek=mysql_num_rows($query);					
													$show1 = mysql_query("SELECT * FROM tb_supplier_delivery_schedule WHERE po_number = '$po_number' and sds_number='$sds_number'");						
													if(mysql_num_rows($show1) == 0)
													{											
													}
													else
													{
														$rows_sup = mysql_fetch_assoc($show1);							
													}
													?>									
										</tr>
									</table>
								</form>
  
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
										while($row=mysql_fetch_assoc($query))
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
												$query2 = mysql_query ($activated);
												$activated1 = "UPDATE tb_supplier_delivery_schedule SET sds_received_date='$jam' WHERE sds_number='".$sds_number."' ";
												$query3 = mysql_query ($activated1);
												?>
									</tr>
									<?php $no++;							  
										}
										$menu_sds = 'Supplier Delivery Schedule';
										$insert_sds = "INSERT INTO tb_activity_log (date_time, username, supplier, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[supplier]', '$_SESSION[account_status]', '$menu_sds', 'Search PO Number : ".$po_number.", SDS Number : ".$sds_number."')";
										$query_insert_sds = mysql_query ($insert_sds);	
									}
									?>
									<tr>
										<td colspan=5 align="right">
											<a href="export_csv_sds.php?sds_number=<?=$rows_sup['sds_number'];?>&po_number=<?=$rows_sup['po_number'];?>">
												<input type="button" style="width:18%;" value="Export to CSV" />
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
		<script src="../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
		<script src="../../plugins/fontawesome-free-5.0.2/svg-with-js/js/fontawesome-all.min.js" type="text/javascript"></script>
		<script src='../../plugins/fastclick/fastclick.min.js'></script>
		<script src="../../dist/js/app.min.js" type="text/javascript"></script>
		<script src="../../dist/js/demo.js" type="text/javascript"></script>
		<script type="text/javascript">
		$(function () {
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