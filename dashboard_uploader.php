<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>MUI-Global Transfer File</title>
		<link rel="shortcut icon" href="favicon.ico">
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<!--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />-->
		<link href="plugins/fontawesome-free-5.0.2/svg-with-js/css/fa-svg-with-js.css" rel="stylesheet" type="text/css" />
		<link href="../../bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<link href="../../bootstrap/css/ionicons.min.css" rel="stylesheet" type="text/css" />
		<link href="../../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
		<link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
		<link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
	<?php
	include "koneksi.php";
	$upload=mysql_query("SELECT * FROM tb_transaction_history where status='READY' and request_status='NONE'");
	$result_upload=mysql_num_rows($upload);	
	$request_redownload=mysql_query("SELECT * FROM tb_transaction_history where status='DOWNLOADED' and request_status='REQUESTED'");
	$result_request_redownload=mysql_num_rows($request_redownload);
	?>
	
		<section class="content">
			<div class="row">
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="info-box">
						<a href="pages/user/transaction_history.php" class="small-box-footer"><span class="info-box-icon bg-aqua">
							<i class="fas fa-upload"></i></span>
						</a>
						<div class="info-box-content">
							<span class="info-box-text">New Upload</span>
							<span class="info-box-number"><?=$result_upload?><small></small></span>
						</div>
					</div>
				</div><!-- /.col -->
  
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="info-box">
						<a href="pages/user/transaction_history.php" class="small-box-footer"><span class="info-box-icon bg-teal">
							<i class="fas fa-redo"></i></span>
						</a>
						<div class="info-box-content">
							<span class="info-box-text">New Request Re-download</span>
							<span class="info-box-number"><?=$result_request_redownload?><small></small></span>
						</div>
					</div>
				</div><!-- /.col -->
			
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="info-box">
						<a href="MUI-EDI User Guide Upload Drawing.pdf" class="small-box-footer"><span class="info-box-icon bg-maroon">
							<i class="fas fa-book"></i></span>
						</a>
						<div class="info-box-content">
							<span class="info-box-text">User Guide</span>
							<span class="info-box-number">Manual Instruction<small></small></span>
						</div>
					</div>
				</div>			
			</div>
		</section>
			
		<script src="../../plugins/jQuery/jQuery-2.1.3.min.js"></script>
		<script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="../../plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
		<script src="plugins/fontawesome-free-5.0.2/svg-with-js/js/fontawesome-all.min.js" type="text/javascript"></script>
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
