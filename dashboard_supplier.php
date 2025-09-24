<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  <title>MUI-Electronic Data Interchange</title>
  <link rel="shortcut icon" href="favicon.ico">
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
  <link href="../../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
  <link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
  <link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
	include "koneksi.php";
	//$po=mysql_query("SELECT * FROM tb_purchase_order where supplier='$_SESSION[supplier]' and edi_status= 'sent'");
	//$jmlpo = mysql_num_rows($po);
	
	//$ds=mysql_query("SELECT * FROM tb_supplier_delivery_schedule where supplier='$_SESSION[supplier]' and edi_status= 'sent'");
	//$jmlds = mysql_num_rows($ds);
	
	//$qc=mysql_query("SELECT * FROM tb_quality_control_check_details where supplier='$_SESSION[supplier]' and edi_status= 'sent'");
	//$jmlqc = mysql_num_rows($qc);
	
	$tf=mysql_query("SELECT * FROM tb_transaction_history where status= 'READY' and process_status='ACTIVE' and supplier='$_SESSION[supplier]'");
    $jmltf = mysql_num_rows($tf);
	
	//$pegawai=mysql_query("SELECT * FROM tb_suppliers");
	//$jmlsupplier = mysql_num_rows($pegawai);
?>
<section class="content">
  <div class="row">
  
  	<div class="col-md-4 col-sm-6 col-xs-12">
	</div><!-- /.col -->
	
	<div class="col-md-4 col-sm-6 col-xs-12">
	</div><!-- /.col -->	
	
	<div class="col-md-4 col-sm-6 col-xs-12">
	</div>
	
	<div class="col-md-4 col-sm-6 col-xs-12">
	</div>
	
	<div class="col-md-4 col-sm-6 col-xs-12">
	 <div class="info-box">
	  <a href="pages/supplier/transaction_history.php" class="small-box-footer"><span class="info-box-icon bg-orange"><i class="ion-ios-download"></i></span></a>
	 <div class="info-box-content">
	  <span class="info-box-text">Upcoming <br>Transfer File</span>
	  <span class="info-box-number"><?=$jmltf?><small></small></span>
	 </div>
	</div>
	</div>
	
	<div class="col-md-4 col-sm-6 col-xs-12">
	 <div class="info-box">
	  <a href="MUI-EDI User Guide Rev.01.pdf" class="small-box-footer"><span class="info-box-icon bg-green"><i class="ion-ios-book-outline"></i></span></a>
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
  <script src="../../plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
  <script src="../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
  <script src='../../plugins/fastclick/fastclick.min.js'></script>
  <script src="../../dist/js/app.min.js" type="text/javascript"></script>
  <script src="../../dist/js/demo.js" type="text/javascript"></script>
  <script type="text/javascript">
  $(function () {
  $("#example1").dataTable();
  $('#example2').dataTable({
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
