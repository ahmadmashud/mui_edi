<?php
session_start();
include "../../koneksi.php";
error_reporting(0);					
date_default_timezone_set("Asia/Jakarta");
$jam=date('d/m/Y h:i:s');
	
$query = "SELECT po_number FROM tb_quality_control_check_details where supplier_name='$_SESSION[supplier]' GROUP BY po_number";
$rs = mysql_query($query) or die(mysql_error());
$cbstr = "";
while ($r = mysql_fetch_array($rs))
{
	$cbstr .= "<option value='$r[po_number]'>$r[po_number]</option>";
}

//$timeout = 60;
//$logout_redirect_url = "../../index.php"; 
//$timeout = $timeout * 60; 
//if (isset($_SESSION['start_time'])) 
//{
//    $elapsed_time = time() - $_SESSION['start_time'];
//    if ($elapsed_time >= $timeout) 
//	{
//        session_destroy();
//        echo "<script>alert('This session has timeout!'); window.location = '$logout_redirect_url'</script>";
//    }
//}
//$_SESSION['start_time'] = time();
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
		<link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
		<link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
		<style>
  		.body 
		{
			font-size: 12px;
		}
		
		input[type="button"],
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
		}
  
		/* Tombol Button Pesan */
		#button a 
		{
			width: 100%;
			height: 30px;
			vertical-align: middle;
			background-color: #4dc3ff;
			color: #fff;
			text-decoration: none;
			padding: 2px 2px;
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
			margin-left: 10%;
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
			xmlhttp.open('get', 'qc_data.php?po_number='+po_number, true);
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
										<p>Welcome, <?php echo $_SESSION['full_name']?><br><?php echo $_SESSION['supplier']?></p>
									</li>  
									<li class="user-footer">
										<div class="pull-right">
											<a href="../login/act-logout.php?username=<?=$_SESSION['username'];?>&supplier_name=<?=$_SESSION['supplier'];?>" class="btn btn-default btn-flat">Logout</a>
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
							<a href="../../home_marketing_product.php">
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
						<li>
							<a href="do_product.php">
								<i class="fa fa-truck"></i> <span>Delivery Order</span> 
							</a>
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
						<li>
							<a href="transaction_history.php">
								<i class="fa fa-file-image"></i> <span>GTF</span> 
							</a>
						</li>
					</ul>
				</section>
			</aside>

			<div class="content-wrapper">
				<section class="content-header">
					<h1> &nbsp </h1>
					<ol class="breadcrumb">
						<li><a href="../../home_marketing_product.php"><i class="fa fa-tachometer-alt"></i> Home</a></li>
						<li class="active">Quality Check</li>
					</ol>
				</section>

				<section class="content">
					<div class="row">
						<div class="col-xs-12">
							<div class="box">              	
								<div class="box-header">
									<h3 class="box-title"><b>Quality Check</b></h3>
								</div><!-- /.box-header -->
								<div class="box-body">
									<form action="" method="POST">
										<div style="overflow-x:auto;">
											<table id="example1" class="table table-bordered table-striped">
												<tr>
													<td width=10% style="font-size:16px; font-family:calibri;" >PO Number</td>
													<td width=20%>
														<select class='Menu' name='pilihan1' onchange='javascript:rubah(this)'>
															<option>--Choose PO Number--</option>
															<?php echo $cbstr; ?>
														</select>
													</td>								
													<td width=10% style="font-size:16px; font-family:calibri;">DO Number</td>
													<td width=40%><select class='Menu' name="divkedua" id="divkedua"><option value="divkedua" selected>--Choose DO Number--</option></select></td>
													<td width=10% align="right"><button name="tambah">Search</button></td>								
					
													<?php
													if(isset($_POST['tambah']))
													{						
														$po_number = $_POST['pilihan1'];
														$do_number = $_POST['divkedua'];

														if ($po_number <> '--Choose PO Number--')
														{
															$query=mysql_query("select item_name, item_code, item_type_name, quantity_receiving, if(quantity_not_good=0,quantity_receiving,sum(quantity_good)) AS sgood, sum(quantity_not_good) AS snot_good, ((sum(quantity_not_good)/quantity_receiving)*100) AS percentage_not_good from tb_quality_control_check_details where po_number = '$po_number' and do_number='$do_number' group by item_code order by item_code");
															$cek=mysql_num_rows($query);
																		
															$activated = "UPDATE tb_quality_control_check_details SET edi_status='RECEIVED' WHERE po_number='$po_number' ";
															$query2 = mysql_query ($activated);						
													?>																	
												</tr>								
											</table>
										</div>
									</form>
						
									<table id="example1" class="table table-bordered table-striped">
										<tr>
											<td width=11%><b>PO Number &nbsp; &nbsp; : &nbsp; <?php echo $po_number?> </b></td>					
											<td width=25%><b>DO Number &nbsp;: &nbsp; <?php echo $do_number?> </b></td>																
										</tr>
									</table>
	
									<div style="overflow-x:auto;">	
										<table id="example1" class="table table-bordered table-striped">
											<tr>
												<th>No</th>
												<th>Item Description</th>
												<th>Item Code</th>														
												<th>Unit</th>
												<th>Qty. Receiving</th>
												<th>Good</th>
												<th>NG</th>
												<th>% NG</th>					  
											</tr>
						
											<?php
											if($cek)
											{
												$no = 1;
												$total_qty_receiving = 0;
												$total_sgood = 0;
												$total_snotgood = 0;
												while($row=mysql_fetch_assoc($query))
												{
													?> 
													<tr class="body">
													<?php $row['sds_number'];?>
													<?php $row['po_number'];?>
													<td width=4%><?php echo $no; ?></td>							
													<td><?php echo $row['item_name'];?></td>
													<td width=17%><?php echo $row['item_code'];?></td>
													<td width=7%><?php echo $row['item_type_name'];?></td>
													<td width=10% align="right"><?php echo $row['quantity_receiving'];?></td>
													<td width=6% align="right"><?php echo $row['sgood'];?></td>
													<td width=6% align="right"><?php echo $row['snot_good'];?></td>
													<?php $row['percentage_ng'];?>
													<?php
													$number = $row['percentage_not_good'];
													$number_format = number_format($number,2,",",",");
													?>
													<td align="right"><?php echo $number_format; echo" %";?></td>
													<?php $row['percentage_not_good'];?>
													<?php
													$number = $row['percentage_not_good'];
													$number_format = number_format($number,2,",",",");
													?>	
													</tr>	
	
													<?php $no++;
													$total_qty_receiving = $total_qty_receiving + $row['quantity_receiving'];
													$total_sgood = $total_sgood + $row['sgood'];
													$total_snotgood = $total_snotgood + $row['snot_good'];
													$total_notgood = ($total_snotgood/$total_qty_receiving)*100;
												}
											}
											$menu_qc = 'Quality Check';
											$insert_qc = "INSERT INTO tb_activity_log (date_time, username, supplier, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[supplier]', '$_SESSION[account_status]', '$menu_qc', 'Search PO Number : ".$po_number.", DO Number : ".$do_number."')";
											$query_insert_qc = mysql_query ($insert_qc);
											?>
	  
											<tr class="body">
												<th colspan=4>Total</th>
												<td width=10% align="right"><?php echo $total_qty_receiving?></td>
												<td width=6% align="right"><?php echo $total_sgood?></td>
												<td width=6% align="right"><?php echo $total_snotgood?></td>	
												<?php
												$number = $total_notgood;
												$number_format = number_format($number,2,",",",");
												?>
												<td width=6% align="right"><?php echo $number_format; echo" %"; ?></td>
											</tr>
	
											<tr>
												<td colspan=5></td>
												<td>
													<div id="button"><a href="#popup">Details</a></div>
													<div id="popup">
														<div class="window">
															<a href="qc_product.php" class="close-button" title="Close">X</a>
															<div class="box-header">
																<h3 class="box-title"><b>Quality Check</b></h3>
															</div><!-- /.box-header -->
															<div style='width:100%;height:90%;overflow:auto;'>
																<table id="example1" class="table table-bordered table-striped">
																	<tr> 
																		<th colspan=9 align="center">Part Information</th>
																		<th colspan=60 align="center">Defect</th>
																	</tr>																	
																	<tr>
																		<th>PO Number</th>
																		<th>DO Number</th>
																		<th>Item Description</th>
																		<th>Item Code</th>
																		<th>Unit</th>
																		<th>Quantity Receiving</th>
																		<th>Good</th>
																		<th>NG</th>
																		<th>% NG</th>
																		<th>Weld Line</th>
																		<th>Silver</th>
																		<th>Crack</th>
																		<th>Sort Mould</th>
																		<th>Corrosive</th>
																		<th>Flow Mark</th>
																		<th>Sink Mark</th>
																		<th>Black Dot</th>
																		<th>Flashes</th>
																		<th>White Mark</th>
																		<th>Fleck</th>
																		<th>Oily</th>
																		<th>Gas Mark</th>
																		<th>Broken Runner</th>
																		<th>Shortage</th>
																		<th>Non Standard Packing</th>
																		<th>Step</th>
																		<th>Excess Material</th>
																		<th>Dented Scrath Wip</th>
																		<th>Dirty Wip</th>
																		<th>Mix Part Wip</th>
																		<th>Over Cut Wip</th>
																		<th>Bending Wip</th>
																		<th>Dimention Wip</th>
																		<th>Gate Cut Wip</th>
																	</tr>
																	<?php				  
																	$select_sdo = mysql_query("select po_number, do_number, item_name, item_code, item_type_name, quantity_receiving, if(quantity_not_good=0,quantity_receiving,sum(quantity_good)) AS sgood, sum(quantity_not_good) AS snot_good, ((sum(quantity_not_good)/quantity_receiving)*100) AS percentage_not_good, sum(weld_line) AS wl, sum(silver) AS s, sum(crack) AS c, sum(sort_mould) AS sm, sum(corrosive) AS co, sum(flow_mark) AS fm, sum(sink_mark) AS sim, sum(black_dot) AS bd, sum(flashes) AS f, sum(oily) AS o, sum(white_mark) AS wm, sum(fleck) AS fl, sum(gas_mark) AS gm, sum(broken_runner) AS br, sum(shortage) AS sh, sum(non_standard_packing) AS nsp, sum(step) AS st, sum(excess_material) AS em, sum(dented_scrath_wip) AS dsw, sum(dirty_wip) AS dw, sum(mix_part_wip) AS mpw, sum(over_cut_wip) AS ocw, sum(bending_wip) AS bw, sum(dimention_wip) AS diw, sum(gate_cut_wip) AS gcw from tb_quality_control_check_details where po_number = '$po_number' and do_number='$do_number' group by item_code order by item_code");
																	while($sdo=mysql_fetch_array($select_sdo)){
																	?>	
																		<tr class="body">
																			<td><?php echo $sdo['po_number']; ?></td>
																			<td><?php echo $sdo['do_number']; ?></td>
																			<td><?php echo $sdo['item_name']; ?></td>
																			<td><?php echo $sdo['item_code']; ?></td>
																			<td><?php echo $sdo['item_type_name']; ?></td>
																			<td><?php echo $sdo['quantity_receiving']; ?></td>
																			<td><?php echo $sdo['sgood']; ?></td>
																			<td><?php echo $sdo['snot_good']; ?></td>
																			<?php $sdo['percentage_not_good'];?>
																			<?php
																			$number = $sdo['percentage_not_good'];
																			$number_format = number_format($number,2,",",",");
																			?>
																			<td align="right"><?php echo $number_format; echo" %";?></td>
																			<td><?php echo $sdo['wl']; ?></td>
																			<td><?php echo $sdo['s']; ?></td>
																			<td><?php echo $sdo['c']; ?></td>
																			<td><?php echo $sdo['sm']; ?></td>
																			<td><?php echo $sdo['co']; ?></td>
																			<td><?php echo $sdo['fm']; ?></td>
																			<td><?php echo $sdo['sim']; ?></td>
																			<td><?php echo $sdo['bd']; ?></td>
																			<td><?php echo $sdo['f']; ?></td>
																			<td><?php echo $sdo['o']; ?></td>
																			<td><?php echo $sdo['wm']; ?></td>
																			<td><?php echo $sdo['fl']; ?></td>
																			<td><?php echo $sdo['gm']; ?></td>
																			<td><?php echo $sdo['br']; ?></td>
																			<td><?php echo $sdo['sh']; ?></td>
																			<td><?php echo $sdo['nsp']; ?></td>
																			<td><?php echo $sdo['st']; ?></td>
																			<td><?php echo $sdo['em']; ?></td>
																			<td><?php echo $sdo['dsw']; ?></td>
																			<td><?php echo $sdo['dw']; ?></td>
																			<td><?php echo $sdo['mpw']; ?></td>
																			<td><?php echo $sdo['ocw']; ?></td>
																			<td><?php echo $sdo['bw']; ?></td>
																			<td><?php echo $sdo['diw']; ?></td>
																			<td><?php echo $sdo['gcw']; ?></td>
																		</tr>
																	<?php
																	}
																	$menu_qc = 'Quality Check';
																	$insert_qc = "INSERT INTO tb_activity_log (date_time, username, supplier, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[supplier]', '$_SESSION[account_status]', '$menu_qc', 'Quality Check Details -> PO Number : ".$po_number.", DO Number : ".$do_number."')";
																	$query_insert_qc = mysql_query ($insert_qc);
																	?>
																	<?php
																	$show1 = mysql_query("SELECT * FROM tb_quality_control_check_details where do_number='$do_number' AND po_number='$po_number'");						
																	if(mysql_num_rows($show1) == 0)
																	{											
																	}
																	else
																	{
																		$rows_sup = mysql_fetch_assoc($show1);							
																	}
																	?>
																	<tr>
																		<td></td>
																		<td colspan=68 align="right">
																			<a href="export_csv_qc_det.php?do_number=<?=$do_number;?>&po_number=<?=$po_number;?>">
																				<input type="button" style="width:10%;" value="Export to CSV" />
																			</a>
																		</td>
																	</tr>
																</table>
															</div>
														</div>
													</div>
												</td>
												<td colspan=2>
													<a href="export_csv_qc.php?do_number=<?=$do_number;?>&po_number=<?=$po_number;?>">
														<input type="button" class="button" value="Export to CSV" />
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
		<script src="../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
		<script src="../../plugins/fontawesome-free-5.0.2/svg-with-js/js/fontawesome-all.min.js" type="text/javascript"></script>
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