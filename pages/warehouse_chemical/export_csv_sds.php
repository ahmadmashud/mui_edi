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
<th>Scedule Date</th>
<th>Item Description</th>
<th>Item Code</th>
<th>Quantity</th>
<th>OS Delivery</th>
</tr>
<?php
if (isset($_GET['po_number']) and ($_GET['sds_number'])) {
  $po_number			= $_GET['po_number'];
  $sds_number			= $_GET['sds_number'];
}else{
  die ("Error. No ID Selected! ");	
}
					  
$select_sdo = mysql_query("SELECT * FROM tb_supplier_delivery_schedule_details where sds_number='$sds_number' order by item_code");
while($sdo=mysql_fetch_array($select_sdo))
{
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

<?php
  	$menu_sds = 'Supplier Delivery Schedule';
	$insert_sds = "INSERT INTO tb_activity_log (date_time, username, supplier, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[supplier]', '$_SESSION[account_status]', '$menu_sds', 'Export to CSV PO Number : ".$po_number.", SDS Number : ".$sds_number."')";
	$query_insert_sds = mysql_query ($insert_sds);
header("Content-disposition: attachment; filename=supplierdeliveryschedule.xls");
?>