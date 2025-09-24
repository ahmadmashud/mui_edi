<?php
session_start();
if(!isset($_SESSION['username']))
{
    die("<script>alert('<b>Oops!</b> Access Failed.
	<p>System Logout. You must login again.</p>')</script>
	<script> onclick=location.href='index.php'</script>");
}
if($_SESSION['account_status']!="Supplier" and $_SESSION['section']!="Engineering")
{
    die("<script>alert('Oops! Access Failed. You are not Supplier.')</script>
       <script> onclick=location.href='index.php'</script>");
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>MUI-Electronic Data Interchange</title>
		<link rel="shortcut icon" href="favicon.ico">
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
		<!--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />-->
		<link href="plugins/fontawesome-free-5.0.2/svg-with-js/css/fa-svg-with-js.css" rel="stylesheet" type="text/css" />   
		<link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
		<link href="plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
		<link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
		<link href="plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
		<link href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
	</head>

	<body class="skin-blue">
		<div class="wrapper">     
			<header class="main-header">
				<a href="#" class="logo" style="font-family:calibri; size:30px;"><i><b>MUI-</b>EDI</i></a>
				<nav class="navbar navbar-static-top" role="navigation">
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
						<i class="fa fa-bars"></i>
					</a>
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="dist/img/user.jpg" class="user-image" alt="User Image"/>
								<span class="hidden-xs"><?php echo $_SESSION['full_name']?></span>
							</a>
							<ul class="dropdown-menu">
								<li class="user-header">
									<img src="dist/img/user.jpg" class="img-circle" alt="User Image" />
									<p> Welcome, <?php echo $_SESSION['full_name']?><br><?php echo $_SESSION['supplier']?> </p>
								</li>
								<li class="user-footer">
									<div class="pull-right">
										<a href="pages/login/act-logout.php?username=<?=$_SESSION['username'];?>&supplier=<?=$_SESSION['supplier'];?>" class="btn btn-default btn-flat">Logout</a>
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
							<a href="home_engineering.php">
								<i class="fa fa-home"></i> <span>Home</span> 
							</a>
						</li>
						<li>
							<a href="#">
								<i class="fa fa-file-alt"></i> <span>Purchase Order</span> 
							</a>
						</li>
						<li>
							<a href="#">
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
								<li><a href="#"><i class="fa fa-truck"></i> Delivery Order</a></li>
								<li><a href="#"><i class="fa fa-sync-alt"></i> Replacement</a></li>
							</ul>
						</li>
						<li>
							<a href="#">
								<i class="fa fa-check-square"></i> <span>Quality Check</span>
							</a>
						</li>
						<li>
							<a href="#">
								<i class="fa fa-calculator"></i> <span>Summary</span> 
							</a>
						</li>
						<li>
							<a href="pages/engineering/transaction_history.php">
								<i class="fa fa-download"></i> <span>GTF</span> 
							</a>
						</li>
					</ul>
				</section>
			</aside>

			<div class="content-wrapper">
				<section class="content-header">
					<h1> &nbsp </h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-tachometer-alt"></i> Home</a></li>
						<li class="active">Dashboard</li>
					</ol>
				</section>

				<section class="content">
					<div class="row">
						<?php
						$page = (isset($_GET['page']))? $_GET['page'] : "main";
						switch ($page) 
						{
							default : include 'dashboard_engineering.php';
						}
						?> 
					</div>
				</section>   
			</div>
	  
			<footer class="main-footer">
				<div class="pull-right hidden-xs"></div>
				Version 1.1. Copyright &copy; 2017 MUI Information Technology Department. All rights reserved
			</footer>
		</div><!-- ./wrapper -->

		<script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
		<!--<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.min.js" type="text/javascript"></script>-->
		<script> $.widget.bridge('uibutton', $.ui.button); </script>
		<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>    
		<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
		<script src="plugins/fontawesome-free-5.0.2/svg-with-js/js/fontawesome-all.min.js" type="text/javascript"></script>
		<script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
		<script src="plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
		<script src='plugins/fastclick/fastclick.min.js'></script>
		<script src="dist/js/app.min.js" type="text/javascript"></script>
		<script src="../../plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
		<script src="../../plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
		<script src="dist/js/demo.js" type="text/javascript"></script>
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