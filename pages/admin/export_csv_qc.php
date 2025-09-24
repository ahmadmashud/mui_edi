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
	<th>DO Number</th>
	<th>Item Description</th>
	<th>Item Code</th>
	<th>Unit</th>
	<th>Quantity Receiving</th>
	<th>Good</th>
	<th>NG</th>
	<th>% NG</th>
  </tr>
  
<?php
if (isset($_GET['do_number']) AND ($_GET['po_number'])) {
  $do_number			= $_GET['do_number'];
  $po_number			= $_GET['po_number'];
}else{
  die ("Error. No ID Selected! ");	
}
					  
$select_sdo = mysql_query("SELECT * FROM tb_quality_control_check_details where do_number='$do_number' AND po_number='$po_number' order by part_name");
while($sdo=mysql_fetch_array($select_sdo)){
?>		
			  
  <tr>
	<td><?php echo $sdo['po_number']; ?></td>
	<td><?php echo $sdo['do_number']; ?></td>
	<td><?php echo $sdo['part_name']; ?></td>
	<td><?php echo $sdo['part_number']; ?></td>
	<td><?php echo $sdo['material_unit']; ?></td>
	<td><?php echo $sdo['quantity_receiving']; ?></td>
	<td><?php echo $sdo['good']; ?></td>
	<td><?php echo $sdo['not_good']; ?></td>
	<td><?php echo $sdo['percentage_ng']; ?></td>
  </tr>
  
<?php
}
?>

</table>

<?php
$menu_qc = 'Quality Check';
$insert_qc = "INSERT INTO tb_activity_log (date_time, username, supplier, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[supplier]', '$_SESSION[account_status]', '$menu_qc', 'Export to CSV -> PO Number : ".$po_number.", DO Number : ".$do_number."')";
$query_insert_qc = mysql_query ($insert_qc);

header("Content-disposition: attachment; filename=qualitycheck.xls");
?>