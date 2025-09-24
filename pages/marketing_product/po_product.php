<?php
session_start();
if(!isset($_SESSION['username']))
{
	die("<script>alert('<b>Oops!</b> Access Failed.
	<p>System Logout. You must login again.</p>')</script>
	<script> onclick=location.href='../../index.php'</script>");
}
if($_SESSION['account_status']!="Supplier" and $_SESSION['section']!="Marketing" and $_SESSION['section']!="Chemical")
{
    die("<script>alert('<b>Oops!</b> Access Failed.
	<p>You are not Supplier.</p>')</script>
	<script> onclick=location.href='../../index.php''</script>");
}

//$timeout = 60;
//$logout_redirect_url = "../../index.php";  
//$timeout = $timeout * 60; 
//if (isset($_SESSION['start_time'])) 
//{
//    $elapsed_time = time() - $_SESSION['start_time'];
//    if ($elapsed_time >= $timeout) 
//	{
//       session_destroy();
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
	    <link href="../../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
	    <link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
	    <link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    	<style>
		.body 
			{
				font-size: 12px;
			}
		</style>
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
					<li><a href="../../home_admin.php"><i class="fa fa-tachometer-alt"></i>Home</a></li>
					<li class="active">Purchase Order</li>
				</ol>
			</section>

			<section class="content">
				<div class="row">
					<div class="col-xs-12">
						<div class="box">              	
							<div class="box-header">
								<h3 class="box-title"><b>Purchase Order</b></h3>
							</div><!-- /.box-header -->
							<div class="box-body">
								<form>
									<div style="overflow-x:auto;">
										<table id="example1" class="table table-bordered table-striped">
											<thead>
											<tr>
											  <th>PO Date</th>
											  <th>PO Number</th>
											  <th>Supplier</th>
											  <th>Terms</th>
											  <th>Curr.</th>
											  <th>Total</th>
											  <th>PPN</th>
											  <th>Subtotal</th>
											  <th>Details</th>
											  <th>Status</th>
											</tr>
											</thead>
											<tbody>
											<?php
											include "../../koneksi.php";								
											$tampilPeg=mysqli_query($conn,"SELECT * FROM tb_purchase_order where supplier_name='$_SESSION[supplier]' ORDER BY po_number");
											while($peg=mysqli_fetch_array($tampilPeg))
											{								
											?>          
											<tr class="body">
											  <td><?php echo $peg['po_date'];?></td>
											  <td><?php echo $peg['po_number'];?></td>
											  <td><?php echo $peg['supplier_name'];?></td>
											  <td><?php echo $peg['purchase_terms'];?></td>
											  <td><?php echo $peg['currency'];?></td>
											  <?php $peg['total'];?>
											  <?php
											  $number = $peg['total'];
											  $number_format = number_format($number,0,",",",");
											  ?>
											  <td align="right"><?php echo $number_format;?></td>
											  <?php $peg['ppn_value'];?>
											  <?php
											  $number = $peg['ppn_value'];
											  $number_format = number_format($number,0,",",",");
											  ?>
											  <td align="right"><?php echo $number_format;?></td>
											  <?php $peg['subtotal'];?>
											  <?php
											  $number = $peg['subtotal'];
											  $number_format = number_format($number,0,",",",");
											  ?>
											  <td align="right"><?php echo $number_format;?></td>							
											  <td><a href="<?php echo 'pdf_po.php?id='.$peg['po_number'];''?>"><center><i style="color:red" class="fa fa-file-pdf"></i></center></a></td>				
											  <?php
											  if($peg['edi_status']=="SENT")
											  {
												  echo"<td><center><i class='fa fa-folder' style='font-size:20px;color:red;'></i></center></td>";
											  } 
											  else 
											  {
												  echo"<td><center><i class='fa fa-folder-open' style='font-size:20px;color:green;'></i></center></td>";
											  }							
											}
											?>
											</tr>
											</tbody>
										</table>
									</div>
								</form>
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