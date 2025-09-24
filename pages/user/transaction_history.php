<?php
error_reporting(0); 
session_start();
date_default_timezone_set("Asia/Jakarta");
$jam=date('d/m/Y h:i:s');
$tgl= date("Y-m-d");
$jamm= date("H:i:s");

if(!isset($_SESSION['username'])){
    die("<script>alert('<b>Oops!</b> Access Failed.
		<p>System Logout. You must login again.</p>')</script>
		<script> onclick=location.href='../../index.php'</script>");
}
if($_SESSION['account_status']!="Project Control Officer"){
    die("<script>alert('<b>Oops!</b> Access Failed.
		<p>You are not Project Control Officer.</p>')</script>
		<script> onclick=location.href='../../index.php''</script>");
}

$timeout = 60;
$logout_redirect_url = "../../index.php"; 
 
$timeout = $timeout * 60; 
if (isset($_SESSION['start_time'])) {
    $elapsed_time = time() - $_SESSION['start_time'];
    if ($elapsed_time >= $timeout) {
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
		<title>MUI-Global Transfer File</title>
		<link rel="shortcut icon" href="../../favicon.ico">
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="../../plugins/fontawesome-free-5.0.2/svg-with-js/css/fa-svg-with-js.css" rel="stylesheet" type="text/css" />
		<!--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />-->
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
			<a href="#" class="logo" style="font-family:calibri; size:30px;"><i><b>MUI-</b>GTF</i></a>
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
					<a href="../../home_uploader.php">
						<i class="fas fa-home"></i> <span>Home</span> 
					</a>
				</li>
				<li>
					<a href="upload_user.php">
						<i class="fas fa-upload"></i> <span>Upload Document</span> 
					</a>
				</li>
				<li>
					<a href="transaction_history.php">
						<i class="fas fa-history"></i> <span>Transaction History</span> 
					</a>
				</li>
			</ul>
		</section>
		</aside>

		<div class="content-wrapper">
		  <section class="content-header">
			<h1> &nbsp </h1>
			<ol class="breadcrumb">
				<li><a href="../../home_uploader.php"><i class="fas fa-tachometer-alt"></i>Home</a></li>
				<li class="active">Transaction History</li>
			</ol>
		  </section>
		  <section class="content">
			  <div class="row">
				  <div class="col-xs-12">
					  <div class="box">              	
						  <div class="box-header">
								<h3 class="box-title"><b>Transaction History</b></h3>
						  </div><!-- /.box-header -->
						  <div class="box-body">
							  <table id="example1" class="table table-bordered table-striped">
								  <thead>
									  <tr>
										  <th>No.</th>
										  <th>Upload Date</th>
										  <th>Ref. Number</th>
										  <th>Document Name</th>
										  <th>Supplier</th>
										  <th>Status</th>
										  <th>Req. Status</th>
										  <th>Reason</th>
										  <th>Resend Ref.Numb</th>
									  </tr>
								  </thead>
								  <tbody>
									<?php
									include('config.php');
									$sql = mysql_query("SELECT * FROM tb_transaction_history ORDER BY document_id DESC");
									if(mysql_num_rows($sql) == 0)
									{
										echo"<script>alert('No data to display.')</script>";
									} 
									else 
									{
										$no = 1;
										while($data = mysql_fetch_assoc($sql))
										{						
										?>									
											<tr class="body">
												<?php $data['document_id']; ?>
												<td align="center"><?php echo $no; ?></td>
												<td align="center"><?php echo $data['upload_date']; ?> </td>
												<td><?php echo $data['reference_number']; ?> </td>
												<td><?php echo $data['document_name']; ?> </td>
												<td><?php echo $data['supplier']; ?> </td>
												<!--<?php	echo '<td><a href="'.$data['file'].'">'.$data['document_name'].'</a></td>'; ?>-->
												<!--<td align="center"><?php echo $data['document_type'];?></td>
												<td align="center"><?php echo formatBytes($data['document_size']); ?></td>-->
												<td align="center"><?php echo $data['status']; ?></td>
												<td align="center"><?php echo $data['request_status']; ?></td>
												<td align="center"><?php echo $data['reason']; ?></td>
												<td width=3%><a href="<?php echo 'process.php?document_id='.$data['document_id'];''?>"><center><i class="fas fa-sync-alt"></i></center></a></td>
											</tr>
										<?php
										$no++;
										}
									}
									?>
										</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</section>
		</div>
	  
		<footer class="main-footer">
			<div class="pull-right hidden-xs"></div>
				Version 1.0. Copyright &copy; 2018 MUI Information Technology Department. All rights reserved
		</footer>
		</div>
	  
		<script src="../../plugins/jQuery/jQuery-2.1.3.min.js"></script>
	    <script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	    <script src="../../plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
	    <script src="../../plugins/fontawesome-free-5.0.2/svg-with-js/js/fontawesome-all.min.js" type="text/javascript"></script>
	    <script src="../../plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
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