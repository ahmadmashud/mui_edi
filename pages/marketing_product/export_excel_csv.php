<?php
//header to give the order to the browser
header("Content-Type: application/vnd.ms-excel");
include "koneksi.php";
?>
<table id="example1" class="table table-bordered table-striped">
<tr>
<th align="center" width=10%>PO Number</th>
<th width=10%>SDS Number</th>
<th width=12%>DO Date</th>
<th width=8%>DO Number</th>
<th width=10%>Item Description</th>
<th width=10%>Item Code</th>
<th>Quantity</th>
</tr>
<?php
if (isset($_GET['id'])) {
	$do_number			= $_GET['id'];
	}
	else{
		die ("Error. No ID Selected! ");	
	}					  
$select_sdo = mysql_query("SELECT * FROM tb_supplier_delivery_order_details WHERE do_number='$do_number'");
while($sdo=mysql_fetch_array($select_sdo))
{
?>					  
<tr>
<td><?php echo $sdo['po_number']; ?></td>
<td><?php echo $sdo['sds_number']; ?></td>
<td><?php echo $sdo['do_date']; ?></td>
<td><?php echo $sdo['do_number']; ?></td>
<td><?php echo $sdo['item_description']; ?></td>
<td><?php echo $sdo['item_code']; ?></td>
<td><?php echo $sdo['quantity']; ?></td>
</tr>
<?php
}
?>
</table>
<?php
header("Content-disposition: attachment; filename=supplierdeliveryorder.xls");
?>
