<?php
// CONECT DATABASE
include "koneksi.php";
date_default_timezone_set("Asia/Jakarta");
$jam=date('d/m/Y h:i:s');	
 
$id = $_REQUEST['id'];
$query = "SELECT * FROM tb_supplier_delivery_schedule WHERE po_number='".$id."'";
$qu = mysql_query($query);
$num = mysql_numrows($qu);
if($num > 0) {
$query1 = "SELECT * FROM tb_purchase_order WHERE po_number='".$id."' LIMIT 1";	
$qu1 = mysql_query($query1);
$num1 = mysql_numrows($qu1);
$activated = "UPDATE tb_purchase_order SET edi_status='RECEIVED' WHERE po_number='".$id."' ";
$query2 = mysql_query ($activated);
if($num1 > 0) {
	$result=mysql_fetch_object($qu1);
	header('Content-Type: application/pdf');
    header('Content-disposition: attachment;filename=MUI/PO.pdf');
    readfile('documents/MUI/PO.pdf');
	echo $result->po_pdf;
} else {
	echo "File Not Valid!";
}
}      
else
{
echo"<script>alert('SDS Number for $id Not Found!')</script>";
echo"<script>javascript:history.back()</script>";
}		
	
	$activated1 = "UPDATE tb_purchase_order SET po_received_date='$jam' WHERE po_number='".$id."' ";
	$query3 = mysql_query ($activated1);

?>

<?php
// CLEAN FILENAME
function jin_gfile($txt) {
	$txt = preg_replace("/[^a-zA-Z0-9s.]/", "_", trim($txt));
	return $txt;
}
?>

