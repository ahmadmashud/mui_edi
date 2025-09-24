<?php
//header to give the order to the browser
header("Content-Type: application/vnd.ms-excel");
include "../../koneksi.php";
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
					  
$select_sdo = mysql_query("SELECT * FROM tb_quality_control_check_details where do_number='$do_number' AND po_number='$po_number' order by item_name");
while($sdo=mysql_fetch_array($select_sdo)){
?>		
			  
  <tr>
	<td><?php echo $sdo['po_number']; ?></td>
	<td><?php echo $sdo['do_number']; ?></td>
	<td><?php echo $sdo['item_name']; ?></td>
	<td><?php echo $sdo['item_code']; ?></td>
	<td><?php echo $sdo['item_type_name']; ?></td>
	<td><?php echo $sdo['quantity_receiving']; ?></td>
	<td><?php echo $sdo['quantity_good']; ?></td>
	<td><?php echo $sdo['quantity_not_good']; ?></td>
	<td><?php echo $sdo['percentage_not_good']; ?></td>
  </tr>
  
<?php
}
?>

</table>

<?php
header("Content-disposition: attachment; filename=qualitycheck.xls");
?>