<?php
//header to give the order to the browser
header("Content-Type: application/vnd.ms-excel");
include "../../koneksi.php";
session_start();
date_default_timezone_set("Asia/Jakarta");
$jam=date('d/m/Y h:i:s');
?>

<table id="example1">
  <tr>
	<th>PO Number</th>
	<th>SDS Number</th>
	<th>DO Date</th>
	<th>DO Number</th>
	<th>Item Description</th>
	<th>Item Code</th>
	<th>Quantity</th> 
  </tr>
  
  <?php
  if (isset($_GET['id'])) {
	$sdo_code	= 	$_GET['id'];
  }else{
	die ("Error. No ID Selected! ");	
  }	
				  
  $select_sdo = mysql_query("SELECT * FROM tb_supplier_delivery_order_details WHERE sdo_code='$sdo_code'");
  while($sdo=mysql_fetch_array($select_sdo)){
  ?>	
				  
  <tr>
	<td><?php echo $sdo['po_number']; ?></td>
	<td><?php echo $sdo['sds_number']; ?></td>
	<td><?php echo $sdo['sdo_date']; ?></td>
	<td><?php echo $sdo['do_number']; ?></td>
	<td><?php echo $sdo['item_name']; ?></td>
	<td><?php echo $sdo['item_code']; ?></td>
	<td><?php echo $sdo['quantity_delivery']; ?></td>
  </tr>
  
  <?php
  }
  ?>
</table>

<?php
$menu_do = 'Delivery Order';
$insert_do = "INSERT INTO tb_activity_log (date_time, username, supplier, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[supplier]', '$_SESSION[account_status]', '$menu_do', 'Download DO History -> DO Number : ".$sdo_code."')";
$query_insert_do = mysql_query ($insert_do);
	
header("Content-disposition: attachment; filename=supplierdeliveryorder.xls");
?>
