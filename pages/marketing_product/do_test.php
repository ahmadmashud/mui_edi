<?php
session_start();
include "../../koneksi.php";
include 'pagination1.php';
date_default_timezone_set("Asia/Jakarta");
$jam=date('d/m/Y h:i:s');
$tgl=date('Y-m-d');
$time=date('h:i:s');

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
  <title>MUI-Electronic Data Interchange</title>
  <link rel="shortcut icon" href="../../favicon.ico">
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.2/moment.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
  <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
  <link href="../../plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
  <link href="../../plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
  <link href="../../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
  <link href="../../plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
  <link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
  <link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
  <style>
  button {
  background-color: #4dc3ff;
  color: white;
  padding: 2px 2px;
  cursor: pointer;
  border: none;
  width: 100%;
  }
  button:hover {
  opacity: 0.8;
  }
  #doinput {
  color: black;
  size: 12px;
  height:29px;
  font-family:calibri;
  }
  #myInput {
  background-image: url('../../dist/img/iconsearch.png');
  background-position: 4px 2px;
  background-repeat: no-repeat;
  width: 20%;
  font-size: 14px;
  padding: 1px 4px 3px 30px;
  border: 2px solid #ddd;
  margin-left: 80%;
  margin-bottom: 5px;
  }
  #customers {
  font-family: "calibri";
  border-collapse: collapse;
  width: 100%;
  }
  #customers td, #customers th {
  border: 1px solid #eee;
  padding: 8px;
  }
  #customers tr:nth-child(even){background-color: #f2f2f2;}
  #customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: center;
  background-color: #f2f2f2;
  color: black;
  }
  
  /* Tombol Button Pesan */
#button {width: 100%;}
#button a {
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
#popup {
	width: 100%;
	height: 100%;
	position: fixed;
	background: rgba(0,0,0,.7);
	top: 0;
	left: 0;
	z-index: 9999;
	visibility: hidden;
}

.window {
	width: 78%;
	height: 53%;
	background: #fff;
	border-radius: 10px;
	position: relative;
	padding: 10px;
	margin-top: 19%;
	margin-left: 20%;
}
.window h2 {
	margin: 30px 0 0 0;
}
/* Button Close */
.close-button {
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
#popup:target {
	visibility: visible;
}
  </style>

  <Script language=Javascript>
  <!--
  function isNumberKey(evt)
  {
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 
  && (charCode < 48 || charCode > 57))
  return false;
  return true;
  }
  //-->
  </Script>
</head>
<body onLoad="document.postform.elements['do_number'].focus();" class="skin-blue">
  <div class="wrapper">
  <header class="main-header">
  <a href="#" class="logo" style="font-family:calibri; size:30px;"><i><b>MUI-</b>EDI</i></a>
  <nav class="navbar navbar-static-top" role="navigation">
	<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
	<span class="sr-only">Toggle navigation</span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
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
	<i class="fa fa-file-text"></i> <span>Purchase Order</span> 
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
	<i class="fa fa-check-square-o"></i> <span>Quality Check</span>
	</a>
	</li>
	<li>
	<a href="summary_product.php">
	<i class="fa fa-calculator"></i> <span>Summary</span> 
	</a>
	</li>
  </ul>
  </section>
  </aside>

  <div class="content-wrapper">
  <section class="content-header">
  <h1>&nbsp</h1>
  <ol class="breadcrumb">
  <li><a href="../../home_marketing_product.php"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Delivery Order</li>
  </ol>
  </section>

  <section class="content">
  <div class="row">
  <div class="col-xs-12">
  <div class="box">              	
	<div class="box-header">
	<h3 class="box-title"><b>Delivery Order</b></h3>
	</div>
	<div class="box-body">					
	<form action="do_process_product.php" method="post" name='autoSumForm'>
	<?php						
	error_reporting(0);
	$select_sds_details = mysql_query("SELECT * FROM tb_supplier_delivery_schedule WHERE shipment_status!='COMPLETELY RECEIVED' and supplier='$_SESSION[supplier]'");
	$sds_details_count = mysql_num_rows($select_sds_details);
	if ($sds_details_count = 0)
	{
	echo"<script>alert('Delivery Order List Not Found.')</script>";
	}
	else
	{ 
	$select_sds_fifo = mysql_query("SELECT * FROM tb_supplier_delivery_schedule WHERE sds_status='OPEN' and supplier='$_SESSION[supplier]' order by sds_number");
	if(mysql_num_rows($select_sds_fifo) == 0)
	{
	echo"<script>alert('Delivery Order List Not Found!')</script>";		
	}
	else
	{
	$sds_fifo = mysql_fetch_assoc($select_sds_fifo);													  
	}
	$select_sds_details1 = mysql_query("SELECT * FROM tb_supplier_delivery_schedule WHERE shipment_status!='COMPLETELY RECEIVED' and supplier='$_SESSION[supplier]' and shipment_status='ON THE WAY'");
	$sds_details_count1 = mysql_num_rows($select_sds_details1);
	if ($sds_details_count1 > 0)
	{
	?>
	<table id="example1" class="table table-bordered table-striped">
	<tr>
	<td><b>PO Number &nbsp; &nbsp; : &nbsp; <?php echo $sds_fifo['po_number'];?> </b></td>					
	<td><b>SDS Number &nbsp;: &nbsp; <?php echo $sds_fifo['sds_number'];?> </b></td>
	<td align="right"><b>Shipment Status &nbsp;: &nbsp; <?php echo $sds_fifo['shipment_status'];?> </b></td>
	</tr>
	</table>
	<?php
	} 
	else 
	{
	?>						  
	<?php
	$show1 = mysql_query("SELECT * FROM tb_supplier_delivery_schedule_details where supplier='$_SESSION[supplier]' order by sds_number");	
	$rows = mysql_fetch_assoc($show1);													  
	?>					
	<table id="example1" class="table table-bordered table-striped">
	<tr>
	<td><b>PO Number &nbsp; &nbsp; : &nbsp; <?php echo $sds_fifo['po_number'];?> </b></td>					
	<td><b>SDS Number &nbsp;: &nbsp; <?php echo $sds_fifo['sds_number'];?> </b></td>
	<td align="right"><b>Shipment Status &nbsp;: &nbsp; <?php echo $sds_fifo['shipment_status'];?> </b></td>
	</tr>
	</table>
	<table id="example1" class="table table-bordered table-striped">
	<thead>
	<tr>
	<th>No.</th>
	<th>Item Description</th>
	<th>Item Code</th>
	<th>Quantity Delivery <a style="color:red">*</a></th>
	</tr>
	</thead>
	<tbody>						
	<?php
	$po_number			=$sds_fifo['po_number'];
	$sds_number			=$sds_fifo['sds_number'];
	$item_description 	=$rows['item_description'];
	$item_code			=$rows['item_code'];
	$item_type			=$rows['item_type'];
	$item_unit			=$rows['item_unit'];
	$department			=$rows['department'];
	$tampilPeg=mysql_query("SELECT * FROM tb_supplier_delivery_schedule_details where po_number = '$po_number' and sds_number='$sds_number' and supplier='$_SESSION[supplier]' ORDER BY sds_number");
	$no = 1;
	while($peg=mysql_fetch_array($tampilPeg))
	{								
	?>
								
	<tr>
	<td width=4%><?php echo $no; ?></td>	
	<td>
	<input type="text" name="item_description[]" size=85% value="<?php echo $peg['item_description'];?>" disabled="disabled">
	<input type="hidden" name="item_description[]" value="<?php echo $peg['item_description'];?>">
	</td>
	<td width=20%>
	<input type="text" name="item_code[]" value="<?php echo $peg['item_code'];?>" disabled="disabled">
	<input type="hidden" name="item_code[]" value="<?php echo $peg['item_code'];?>">
	</td>
	<input type="hidden" name="quantity_delivery[]" size="12px" value="<?php echo $peg['outstanding_delivery'];?>">
	<td width=14%><input type="text" onkeypress="return isNumberKey(event)" name="quantity[]" size="12px" value="<?php echo $peg['outstanding_delivery'];?>" required></td>	
	<input type="hidden" name="item_type" value="<?php echo $peg['item_type'] ?>" >
	<input type="hidden" name="item_unit" value="<?php echo $peg['item_unit'] ?>" >
	<input type="hidden" name="department" value="<?php echo $peg['department'] ?>" >
	<?php $no++;	
	}
	?>
	</tr>
	</tbody>
	</table>
								
	<table id="example1" class="table table-bordered table-striped">
	<tr>
	<td width=12%><b>Delivery Date <a style="color:red">*</a></b></td>
	<td width=14%>
	<div class="input-group">								  
	<input id="reservation" type="text" name="do_date" size=12 value="<?php echo $tgl; ?>" required>
	</div><!-- /.input group -->
	</td>						  						
	<td width=14% >
	<div class="input-group date" id="datetimepicker1">
	<input type="text" name="do_time" size=12 value="<?php echo $time; ?>" required>
	<span class="input-group-addon">
	<span class="glyphicon glyphicon-calendar" style='font-size:11px;'></span>
	</span>
	</div>
	</td>
	<td width=12%><b>DO Number <a style="color:red">*</a></b></td>
	<td width=23%><input type="text" name="do_number" size=26% id="do_number" required></td>
	<div class="checkbox icheck">
	<td><input type="checkbox" name="check" value="RET"> <b>Return</b></td>
	</div>
	<td>						 						    
	<button name="submit" id="submit">Submit</button>
	</td>
	<td><div id="button"><a href="#popup">Details</a></div></td>
	</tr>			
	<input type="hidden" name="po_number" value="<?php echo $po_number; ?>" >
	<input type="hidden" name="sds_number" value="<?php echo $sds_number; ?>" >
	<?php
	}
	}
	?>
	</table>
	</form>		
	
	
	<div id="popup">
    <div class="window">
	  <a href="#" class="close-button" title="Close">X</a>
	<div class="box-header">
	<h3 class="box-title"><b>Delivery History</b></h3>
	</div><!-- /.box-header -->
	<?php
	$min_tanggal=mysql_fetch_array(mysql_query("select min(do_date) as min_tanggal from tb_supplier_delivery_order where supplier='$_SESSION[supplier]'"));
	$max_tanggal=mysql_fetch_array(mysql_query("select max(do_date) as max_tanggal from tb_supplier_delivery_order where supplier='$_SESSION[supplier]'"));
	?>
				  
	<form action="#popup" method="post" name="postform">
	<table class="table table-bordered table-striped">				  
	<tr>
	<td width=5% style="font-size:14px; font-family:calibri;" ><b>From</b></td>
	<td width=8%>
	<div class="input-group">								  
	<input id="reservation1" type="text" name="tanggal_awal" size=10%5 value="<?php echo $min_tanggal['min_tanggal'];?>">
	</div>
	</td>
	<td width=5% style="font-size:14px; font-family:calibri;" ><b>Until</b></td>
	<td width=8%>
	<div class="input-group">
	<input id="reservation2" type="text" name="tanggal_akhir" size=10% value="<?php echo $max_tanggal['max_tanggal'];?>">
	</div><!-- /.input group -->			
	</td>
	<td width=10%><button name="cari" id="cari">Search</td>
	<td></td>
	</tr>
	</table>
	</form>
	

	<?php					
	if(isset($_POST['cari'])){
	$tanggal_awal=$_POST['tanggal_awal'];
	$tanggal_akhir=$_POST['tanggal_akhir'];
					
	if(empty($tanggal_awal) and empty($tanggal_akhir)){
	echo"<script>alert('Please choose po date from until first.')</script>";
	}else{
	?><i><b>Information : </b> Search result from <b><?php echo $_POST['tanggal_awal']?></b> until <b><?php echo $_POST['tanggal_akhir']?></b></i><?php
	$query=mysql_query("select * from tb_supplier_delivery_order where do_date between '$tanggal_awal' and '$tanggal_akhir'");
	}
	?>			
				
	<table id="example1" class="table table-bordered table-striped"> 
	<tr>
	<th width=3% align="center">No.</th>
	<th align="center" width=10%>Delivery Date</th>
	<th width=10%>Delivery Time</th>
	<th width=12%>DO Number</th>
	<th width=8%>Status</th>
	<th width=10%>Received/ Return Date</th>
	<th width=10%>Received/ Return Time</th>
	<th>Remark</th>
	<th>Download</th>
	</tr>
	<?php
	$no=0;
	while($row=mysql_fetch_array($query)){
	?>
	<tr>
	<td><?php echo $no=$no+1; ?></td>
	<td><?php echo $row['do_date']; ?></td>
	<td><?php echo $row['do_time']; ?></td>
	<td><?php echo $row['do_number']; ?></td>
	<td><?php echo $row['do_status']; ?></td>
	<td><?php echo $row['received_returned_date']; ?></td>
	<td><?php echo $row['received_returned_time']; ?></td>
	<td><?php echo $row['remark']; ?></td>
	<td width=3%><a href="<?php echo 'export_csv_do.php?id='.$row['do_number'];''?>"><center><i class="fa fa-download"></i></center></a></td>
	</tr>
	<?php
	}
	$menu_do = 'Delivery Order';
	$insert_do = "INSERT INTO tb_activity_log (date_time, username, supplier, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[supplier]', '$_SESSION[account_status]', '$menu_do', 'Delivery History -> Search DO Number : ".$do_number.", DO Date From ".$tanggal_awal.", Until ".$tanggal_akhir."')";
	$query_insert_do = mysql_query ($insert_do);
	?>
	<tr>
	<td colspan="9" align="center"> 
	<?php
	if(mysql_num_rows($query)==0){
	echo "<font color=red><blink>Data not found!</blink></font>";
	}
	?>
	</td>
	</tr>
	</table>
	<?php
	}else{
	unset($_POST['cari']);
	}
	?>
	</div>
	</div>
	
	<?php		  			  
	if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
	$keyword=$_REQUEST['keyword'];
	$reload = "do_product.php?pagination=true&keyword=$keyword";
	$query =  "SELECT * FROM tb_supplier_delivery_order WHERE do_number LIKE '%$keyword%' and supplier='$_SESSION[supplier]' ORDER BY do_date";
	$result = mysql_query($sql);
	}else{
	$reload = "do_product.php?pagination=true";
	$sql =  "SELECT * FROM tb_supplier_delivery_order where supplier='$_SESSION[supplier]' ORDER BY do_date";
	$result = mysql_query($sql);
	}
        
	$rpp = 10;
	$page = intval($_GET["page"]);
	if($page<=0) $page = 1;  
	$tcount = mysql_num_rows($result);
	$tpages = ($tcount) ? ceil($tcount/$rpp) : 1; // total pages, last page number
	$count = 0;
	$i = ($page-1)*$rpp;
	$no_urut = ($page-1)*$rpp;
	?>
	<div>
	<table id="customers">
	<thead>
	<tr>
	<th>No.</th>
	<th>Delivery Date</th>
	<th>Delivery Time</th>
	<th>DO Number</th>
	<th>Status</th>
	<th>Received/ Returned Date</th>
	<th>Received/ Returned Time</th>
	<th>Remark</th>
	<th>Download</th>
	</tr>
	</thead>
	<tbody>
	<?php
	while(($count<$rpp) && ($i<$tcount)) {
	mysql_data_seek($result,$i);
	$row = mysql_fetch_array($result);
	?>
	<tr>
	<td width="8px"><?php echo ++$no_urut;?> </td>
	<td width=10%><?php echo $row ['do_date']; ?> </td>
	<td width=10%><?php echo $row ['do_time']; ?> </td>
	<td width=18%><?php echo $row ['do_number']; ?> </td>
	<td width=10px><?php echo $row ['do_status']; ?> </td>
	<td width=12px><?php echo $row ['received_returned_date']; ?> </td>
	<td width=12px><?php echo $row ['received_returned_time']; ?> </td>
	<td><?php echo $row ['remark']; ?></td>
	<td width=10px><a href="<?php echo 'export_csv_do.php?id='.$row['do_number'];''?>"><center><i class="fa fa-download"></i></center></a></td>
	</tr>
	<?php
	$i++; 
	$count++;
	}
	?>
	</tbody>
	</table>
	<div style="text-align:right"><?php echo paginate_one($reload, $page, $tpages); ?></div>
	</div>				  			  
	</div><!-- /.box-body -->
  </div><!-- /.box -->
  </div><!-- /.col -->
  </div><!-- /.row -->
  </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
	  
<footer class="main-footer">
  <div class="pull-right hidden-xs">
  <a target="_blank" href="http://www.ptmui.co.id"><img src="../../dist/img/mui4.png"></a> 
  </div>
  Version 1.0. Copyright &copy; 2017 MUI Information Technology Department. All rights reserved
</footer>
</div> <!-- wrapper -->

  <script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="../../plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
  <script src="../../plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
  <script src="../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
  <script src="../../plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
  <script src="../../plugins/iCheck/icheck.min.js" type="text/javascript"></script>
  <script src='../../plugins/fastclick/fastclick.min.js'></script>
  <script src="../../dist/js/app.min.js" type="text/javascript"></script>
  <script src="../../dist/js/demo.js" type="text/javascript"></script>
  <script type="text/javascript">
  $(function () {
  $('#reservation').datepicker({format: 'yyyy-mm-dd'});
  });
  </script>
  <script type="text/javascript">
  $("#datetimepicker1").datetimepicker({
  format: 'HH:mm:ss'
  });
  </script>
  <script type="text/javascript">
  $('#reservation1').datepicker({format: 'yyyy-mm-dd'});
  $('#reservation2').datepicker({format: 'yyyy-mm-dd'});
  </script>
  <script>
  $(function () {
	$('input').iCheck({
	checkboxClass: 'icheckbox_square-blue',
	radioClass: 'iradio_square-blue',
	increaseArea: '10%' // optional
	});
  });
  </script>
</body>
</html>
