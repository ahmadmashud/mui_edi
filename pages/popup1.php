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

body {
	font-family: calibri;
	font-size: 12px;
}

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
	width: 950px;
	height: 400px;
	background: #fff;
	border-radius: 10px;
	position: relative;
	padding: 10px;
	text-align: center;
	margin: 15% auto;
	margin-left: 20%;
}
.window h2 {
	margin: 30px 0 0 0;
}
/* Button Close */
.close-button {
	width: 4%;
	height: 10%;
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
	<script>
	function myFunction() {
		document.getElementById("popup");
	}
	</script>
    
    <div id="popup">
    	<div class="window">
        	<a href="popup.php" class="close-button" title="Close">X</a>
            <h2>Selamat Datang di DUMET School</h2>
				  <div style='width:900px;height:280px;overflow:auto;'>
	  <table id="example1" class="table table-bordered table-striped">
	  <tr>
		<th>PO Number</th>
		<th>SDS Number</th>
		<th>Scedule Date</th>
		<th>Item Description</th>
		<th>Item Code</th>
		<th>Quantity</th>
		<th>OS Delivery</th>
	  </tr>
			  
<?php
if (isset($_GET['sds_number'])) {
  $sds_number = $_GET['sds_number'];
}else{
  die ("Error. No ID Selected! ");	
}
				  
$select_sdo = mysql_query("SELECT * FROM tb_supplier_delivery_schedule_details order by item_code");
while($sdo=mysql_fetch_array($select_sdo)) {
?>
				  
  <tr>
	<td><?php echo $sdo['po_number']; ?></td>
	<td><?php echo $sdo['sds_number']; ?></td>
	<td><?php echo $sdo['schedule_date']; ?></td>
	<td><?php echo $sdo['item_description']; ?></td>
	<td><?php echo $sdo['item_code']; ?></td>
	<td><?php echo $sdo['quantity']; ?></td>
	<td><?php echo $sdo['outstanding_delivery']; ?></td>
  </tr>
  
<?php
		}
		?>		
		</table>
		</div>
        </div>
    </div>
</body>
</html>