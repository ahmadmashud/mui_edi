<?php
session_start();
include "../../koneksi.php";
error_reporting(0);					
date_default_timezone_set("Asia/Jakarta");
$jam=date('d/m/Y h:i:s');
$tgl=date('Y-m-d');
$time=date('h:i:s');
	
	$query = "SELECT do_number FROM tb_quality_control_check_details where not_good > 0 GROUP BY do_number order by do_number DESC";
	$rs = mysql_query($query) or die(mysql_error());
	$cbstr = "";
	while ($r = mysql_fetch_array($rs))
	{
		$cbstr .= "<option value='$r[do_number]'>$r[do_number]</option>";
	}

	
	/*function kdauto($tabel, $inisial){
		$struktur   = mysql_query("SELECT * FROM $tabel");
		$field      = mysql_field_name($struktur,0);
		$panjang    = mysql_field_len($struktur,0);
		$qry  = mysql_query("SELECT max(".$field.") FROM ".$tabel);
		$row  = mysql_fetch_array($qry);
		if ($row[0]=="") {
		$angka=0;
		}
		else {
		$angka= substr($row[0], strlen($inisial));
		}
		$angka++;
		$angka      =strval($angka);
		$tmp  ="";
		for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
		$tmp=$tmp."0";
		}
		return $inisial.$tmp.$angka;
		}*/
		
		
		$code_date=mysql_query("SELECT * FROM tb_replacement");
        /* script menentukan bulan */
        $array_bln = array(1=>"01","02","03", "04", "05","06","07","08","09","10","11","12");
        $bln = $array_bln[date('n')];

        /* script menentukan tahun */ 
        $thn = date('Y');
        $tahun = substr($thn, -4);
		
$noUrut = (int) substr($replacement_number, 16, 5);

$query_new_no = mysql_query("select * from tb_replacement where replacement_date = DATE(now())");
if (mysql_num_rows($query_new_no)>=1){
	$result = mysql_fetch_array($query_new_no);
	$noUrut = $result['noUrut'] + 1 ;
}else {
	$noUrut = 1;
}

// baca nomor urut transaksi dari id transaksi terakhir


$char = "MUI/$tahun/$bln/REP-";
$replacement_number = $char . sprintf("%05s", $noUrut);

/*
$result_new_no = mysql_query($query_new_no);
$result2 = mysql_fetch_array($result_new_no);
$replacement_number = $data['newno']

if ($result_new_no > 0)
{
	$noUrut++;
} else {
	$noUrut = (int) substr($replacement_number, 16, 5);
}

$query = mysql_query("SELECT * FROM tb_replacement where bulan=MONTH(now()) AND tahun=YEAR(now()) ORDER by replacement_number DESC LIMIT 1");
if (mysql_num_rows($query)>=1){
   $data = mysql_fetch_array($query);
   $nomor = $data['nomor']+1;
}else{
   $nomor = 1;
}*/
	
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
  <!--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />-->
  <link href="../../plugins/fontawesome-free-5.0.2/svg-with-js/css/fa-svg-with-js.css" rel="stylesheet" type="text/css" />
  <link href="../../plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
  <link href="../../plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
  <link href="../../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
  <link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
  <link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
  <style>
  			.body 
			{
				font-size: 12px;
			}
			
  input[type="button"],
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

  select.Menu {
  font-size: 14px;
  }
  
  /* Tombol Button Pesan */
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
	margin-left: 10%;
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
  <h1> &nbsp </h1>
  <ol class="breadcrumb">
  <li><a href="../../home_admin.php"><i class="fa fa-tachometer-alt"></i> Home</a></li>
  <li class="active">Replacement</li>
  </ol>
  </section>

  <section class="content">
  <div class="row">
  <div class="col-xs-12">
  <div class="box">              	
  <div class="box-header">
	<h3 class="box-title"><b>Replacement</b></h3>
  </div><!-- /.box-header -->
  <div class="box-body">
  <form action="" method="POST">		
  <table id="example1" class="table table-bordered table-striped">
  <tr><td width=3% style="font-size:16px; font-family:calibri;" >DO Number</td>
  <td width=20%>
  <select class='Menu' name='pilihan1' onchange='javascript:rubah(this)'>
  <option>--Choose DO Number--</option>
  <?php echo $cbstr; ?>
  </select></td>								
  <td width=3% align="right"><button name="tambah">Search</button></td>									
					
  <?php
  if(isset($_POST['tambah'])){						
  $do_number = $_POST['pilihan1'];

  if ($do_number <> '--Choose PO Number--'){
  $query=mysql_query("select po_number, do_number, part_name, part_number, quantity_receiving, sum(not_good) AS snot_good, material_type, material_unit from tb_quality_control_check_details where do_number='$do_number' group by part_number order by part_number");
  //$cek=mysql_num_rows($query);
  
  
  $show1 = mysql_query("SELECT * FROM tb_supplier_delivery_order WHERE do_number = '$do_number'");						
  if(mysql_num_rows($show1) == 0){											
  }else{
  $rows_do = mysql_fetch_assoc($show1);							
  }
						
  //$activated = "UPDATE tb_quality_control_check_details SET edi_status='RECEIVED' WHERE po_number='$po_number' ";
  //$query2 = mysql_query ($activated);						
  ?>																	
  </tr>
  </form>
  </table>
						
  <table id="example1" class="table table-bordered table-striped">
  <tr>
  <td><b>PO Number &nbsp;: &nbsp; <?php echo $rows_do['po_number']; ?> </b></td>
  <td><b>SDS Number &nbsp;: &nbsp; <?php echo $rows_do['sds_number']; ?> </b></td>     
  <td><b>DO Number &nbsp;: &nbsp; <?php echo $do_number ?> </b></td>
  <td><b>DO Date &nbsp;: &nbsp; <?php echo $rows_do['do_date']; ?> </b></td> 
  </tr>
  </table>

  <form action="replacement_process_product.php" method="POST">
  <table id="example1" class="table table-bordered table-striped">
  <tr>
  <th>No</th>
  <th>Item Description</th>
  <th>Item Code</th>														
  <th>Qty. Delivery</th>
  <th>Qty. NG</th>
  <th>Qty. Replacement</th>				  
  </tr>
						
  <?php
  //if($cek){
  $no = 1;
  //$total_qty_receiving = 0;
  //$total_sgood = 0;
  //$total_snotgood = 0;
  while($row=mysql_fetch_array($query)){
  ?> 
  
	<tr class="body">
	<td><?php echo $no; ?></td>	
	<input type="hidden" name="do_number" value="<?php echo $row['do_number'] ?>" >
	<input type="hidden" name="po_number" value="<?php echo $row['po_number'] ?>" >	
	<td>
	<input type="text" name="part_name[]" size=70% value="<?php echo $row['part_name'];?>" disabled="disabled">
	<input type="hidden" name="part_name[]" size=70% value="<?php echo $row['part_name'];?>">
	</td>
	<td>
	<input type="text" name="part_number[]" size=41% value="<?php echo $row['part_number'];?>" disabled="disabled">
	<input type="hidden" name="part_number[]" size=41% value="<?php echo $row['part_number'];?>">
	</td>
	<td>
	<input type="text" name="quantity_receiving" size=3% value="<?php echo $row['quantity_receiving'];?>" disabled="disabled">
	<input type="hidden" name="quantity_receiving" value="<?php echo $row['quantity_receiving'];?>">
	</td>
	<td>
	<input type="text" name="not_good" size=3% value="<?php echo $row['snot_good'];?>" disabled="disabled">
	<input type="hidden" name="not_good" value="<?php echo $row['snot_good'];?>">
	</td>
	<input type="hidden" name="quantity_not_good[]" size="10px" value="<?php echo $row['snot_good'];?>">
	<td width=14%><input type="text" onkeypress="return isNumberKey(event)" name="quantity[]" size="12px" value="<?php echo $row['snot_good'];?>"></td>
	<input type="hidden" name="material_type" value="<?php echo $row['material_type'] ?>" >
	<input type="hidden" name="material_unit" value="<?php echo $row['material_unit'] ?>" >
	<input type="hidden" name="department" value="<?php echo $rows_do['department'] ?>" >
	<input type="hidden" name="sds_number" value="<?php echo $rows_do['sds_number'] ?>" >
	</tr>
	
	  <?php $no++;
	  $total_qty_receiving = $total_qty_receiving + $row['quantity_receiving'];
	  $total_not_good = $total_not_good + $row['snot_good'];
	  }
	  //}
	  $menu_replacement = 'Replacement';
	  $insert_rep = "INSERT INTO tb_activity_log (date_time, username, supplier, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[supplier]', '$_SESSION[account_status]', '$menu_replacement', 'Search DO Number : ".$do_number."')";
	  $query_insert_rep = mysql_query ($insert_rep);
	  ?>
	  
	<tr>
	  <th colspan=3>Total</th>
	  <td width=10% align="right"><?php echo $total_qty_receiving?></td>
	  <td width=10% align="right"><?php echo $total_not_good?></td>			
	  </td>
	</tr>
	</table>
	
	<table id="example1" class="table table-bordered table-striped">
	<tr class="body">
	  <td width=15%><b>Replacement Number <a style="color:red">*</a></b></td>
	  <td width=21%>
	  <input type="text" name="replacement_number" id="replacement_number" size=27% value="<?php echo $replacement_number; ?>" disabled="disabled" />
	  <input type="hidden" name="replacement_number" id="replacement_number" size=27% value="<?php echo $replacement_number; ?>" />
	  </td>
	  <td width=15%><b>Replacement Date <a style="color:red">*</a></b></td>
	  <td width=13%>
		<div class="input-group">								  
		  <input id="reservation" type="text" name="replacement_date" size=13 value="<?php echo $tgl; ?>" required>
		</div>
	  </td>						  						
	  <td width=2%>
		<div class="input-group date" id="datetimepicker1">
		  <input type="text" name="replacement_time" size=10 value="<?php echo $time; ?>" required>
		<span class="input-group-addon">
		<span class="glyphicon glyphicon-calendar" style='font-size:11px;'></span>
		</span>
	    </div>
	  </td>
	  <td width=13%><button name="submit" id="submit">Submit</button></td>
	  </tr>
		
	<!--<tr>
	  <td colspan=5></td>	  
	
	  <td colspan=2><a href="export_csv_qc.php?do_number=<?=$do_number;?>&po_number=<?=$po_number;?>">
	  <input type="button" class="button" value="Export to CSV" />
	  </a></td>
	</tr>	-->
	  
	  <?php
	  }							
	  }	
	  ?>	
  </table>	
  </form>  
  </div>
  </div>
  </div>
  </div>
  </section>
  </div>
	  
  <footer class="main-footer">
  <div class="pull-right hidden-xs">
  </div>
  Version 1.1. Copyright &copy; 2017 MUI Information Technology Department. All rights reserved
  </footer>
  </div>

  <script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="../../plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
  <script src="../../plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
  <script src="../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
  <script src="../../plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
  <script src="../../plugins/fontawesome-free-5.0.2/svg-with-js/js/fontawesome-all.min.js" type="text/javascript"></script>
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
  
</body>
</html>