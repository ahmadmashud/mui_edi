<?php
//header to give the order to the browser
include "../koneksi.php";
date_default_timezone_set("Asia/Jakarta");
$jam=date('d/m/Y h:i:s');	
$tgl=date('Y-m-d');
?>

<html>
<style>
* {margin:0; padding: 0;}

body {font-family: Arial, Helvetica, sans-serif;}

/* Tombol Button Pesan */
#button {margin: 5% auto; width: 100px; text-align: center;}
#button a {
	width: 100px;
	height: 30px;
	vertical-align: middle;
	background-color: #F00;
	color: #fff;
	text-decoration: none;
	padding: 10px;
	border-radius: 5px;
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
	width: 400px;
	height: 100px;
	background: #fff;
	border-radius: 10px;
	position: relative;
	padding: 10px;
	text-align: center;
	margin: 15% auto;
}
.window h2 {
	margin: 30px 0 0 0;
}
/* Button Close */
.close-button {
	width: 6%;
	height: 20%;
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
<body>
  <table id="example1" class="table table-bordered table-striped">
  <tr>
	<th>SDS Date</th>
	<th>SDS Number</th>
	<th>Supplier</th>
	<th>Details</th>
  </tr>
  <?php
  $sql = mysql_query("SELECT * FROM tb_supplier_delivery_schedule WHERE sds_date < '$tgl' and sds_status = 'OPEN' order by sds_number");
  while ( $sdo = mysql_fetch_assoc( $sql ) ) {
  ?>				 					  
  <tr>
	<td><?php echo $sdo['sds_date']; ?></td>
	<td><?php echo $sdo['sds_number']; ?></td>
	<td><?php echo $sdo['supplier']; ?></td>
	<td><div id="button"><a href="popup1.php?#popup&sds_number=<?=$sdo['sds_number'];?>">Pesan</a></div></td>
  <?php
  }
  ?>	
</body>
</html>