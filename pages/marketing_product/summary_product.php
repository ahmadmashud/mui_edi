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
		<link href="../../plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
		<link href="../../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
		<link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
		<link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
		<style>
  		.body 
		{
			font-size: 12px;
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
		</style>
	
		<?php
		session_start();
		if(!isset($_SESSION['username']))
		{
			die("<script>alert('Oops! Access Failed. System Logout. You must login again.')</script>
			<script> onclick=location.href='../../index.php'</script>");
		}
		if($_SESSION['account_status']!="Supplier")
		{
			die("<script>alert('Oops! Access Failed. You are not Supplier.')</script>
			<script> onclick=location.href='../../index.php'</script>");
		}
	
		//$timeout = 60; 
		//$logout_redirect_url = "../../index.php";  
		//$timeout = $timeout * 60;
		//if (isset($_SESSION['start_time'])) 
		//{
		//	$elapsed_time = time() - $_SESSION['start_time'];
		//	if ($elapsed_time >= $timeout) 
		//	{
		//		session_destroy();
		//		echo "<script>alert('This session has timeout!'); window.location = '$logout_redirect_url'</script>";
		//	}
		//}
		//$_SESSION['start_time'] = time();
		$tgl=date('yyyy-mm-dd');
		?>
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
					<h1>&nbsp; </h1>
					<ol class="breadcrumb">
						<li><a href="../../home_marketing_product.php"><i class="fa fa-tachometer-alt"></i>Home</a></li>
						<li class="active">Summary</li>
					</ol>
				</section>
		
				<?php
				error_reporting(0);
				include "../../koneksi.php";
				date_default_timezone_set("Asia/Jakarta");
				$jam=date('d/m/Y h:i:s');
				$tgl=date('Y-m-d');
				?>
		
				<section class="content">
					<div class="row">
						<div class="col-xs-12">
							<div class="box">              	
								<div class="box-header">
									<h3 class="box-title"><b>Summary</b></h3>
								</div><!-- /.box-header -->
								<div class="box-body">
									<table id="example1" class="table table-bordered table-striped">
										<tr>
											<td width=88%></td>
											<td align="right"><a href="export_summary.php"><input type="button" class="button" value="Export to CSV"></a></td>
										</tr>
									</table>
				
									<?php
									$query="SELECT tb_purchase_order_details.po_date, tb_purchase_order_details.po_number, tb_purchase_order_details.item_name, 
									tb_purchase_order_details.item_code, SUM(tb_purchase_order_details.quantity_order) AS po_qty, tb_purchase_order_details.supplier_name,
									tb_supplier_delivery_order_details.sds_number,  
									tb_supplier_delivery_order_details.do_date, tb_supplier_delivery_order_details.do_number, 
									SUM(tb_supplier_delivery_order_details.quantity_delivery) AS do_qty, tb_purchase_order_details.outstanding_receiving,
									(SELECT COUNT(po_number) FROM tb_purchase_order_details WHERE po_number= '$po_number') AS jumlah_po 
									FROM tb_purchase_order_details 
									LEFT JOIN tb_supplier_delivery_order_details
									ON tb_purchase_order_details.po_number=tb_supplier_delivery_order_details.po_number and
									tb_purchase_order_details.item_code=tb_supplier_delivery_order_details.item_code
									WHERE tb_supplier_delivery_order_details.do_status = 'RECEIVED' and tb_supplier_delivery_order_details.supplier_name='$_SESSION[supplier]'
									GROUP BY tb_purchase_order_details.po_number, tb_purchase_order_details.item_code ORDER BY tb_purchase_order_details.po_number, tb_purchase_order_details.item_name";
									$proses=mysql_query($query);
									$i=0; 
									while($data=mysql_fetch_assoc($proses))
									{
										$row[$i]=$data;
										$i++;
									}
									foreach($row as $cell)
									{
										if(isset($total[$cell['po_number']]['jml'])) 
										{ 
											$total[$cell['po_number']]['jml']++; 
										}
											else
										{
											$total[$cell['po_number']]['jml']=1; 
										}	
									}
									?>
	
									<div style="overflow-x:auto;">
									<table id="example1" class="table table-bordered table-striped">
										<tr> 
											<th>PO Number</th>
											<th>Supplier</th> 
											<th>Item Description</th> 
											<th>Item Code</th> 
											<th>Qty. PO</th>
											<th>Qty. DO</th>
											<th>OS</th>
										</tr>
									<?php
									$n=count($row);
									$cekinstansi="";
									for($i=0;$i<$n;$i++)
									{
										$cell=$row[$i];
										echo '<tr class="body">';
										if($cekinstansi!=$cell['po_number'])
										{
											echo '<td' .($total[$cell['po_number']]['jml']>1?' rowspan="' .($total[$cell['po_number']]['jml']).'">':'>') .$cell['po_number'].'</td>';
											$cekinstansi=$cell['po_number'];
										}
										echo "<td>$cell[supplier_name]</td><td>$cell[item_name]</td><td>$cell[item_code]</td><td>$cell[po_qty]</td><td>$cell[do_qty]</td><td>$cell[outstanding_receiving]</td>";
										echo "</tr>";
									}
									echo "</table>";
									echo "</div>";
									?>
								</div><!-- /.box-body -->
							</div><!-- /.box -->
						</div><!-- /.col -->
					</div><!-- /.row -->
				</section><!-- /.content -->
			</div><!-- /.content-wrapper -->
	  
			<footer class="main-footer">
				<div class="pull-right hidden-xs"></div>
				Version 1.1. Copyright &copy; 2017 MUI Information Technology Department. All rights reserved
			</footer>
		</div> <!-- wrapper -->

		<script src="../../plugins/jQuery/jQuery-2.1.3.min.js"></script>
		<script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="../../plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
		<script src="../../plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
		<script src="../../plugins/fontawesome-free-5.0.2/svg-with-js/js/fontawesome-all.min.js" type="text/javascript"></script>
		<script src="../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
		<script src="../../plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
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
		<script type="text/javascript">
		$('#reservation').datepicker({format: 'yyyy-mm-dd'});
		$('#reservation1').datepicker({format: 'yyyy-mm-dd'});
		</script>
	</body>
</html>