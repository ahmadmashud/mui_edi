<?php
session_start();
include "../../koneksi.php";
date_default_timezone_set("Asia/Jakarta");
$jam=date('d/m/Y h:i:s');	
 
$id = $_REQUEST['id'];
$query = "SELECT * FROM tb_supplier_delivery_schedule WHERE po_number='".$id."'";
$qu = mysqli_query($conn,$query);
$num = mysqli_num_rows($qu);
if($num > 0) {
$query1 = "SELECT * FROM tb_purchase_order WHERE po_number='".$id."' LIMIT 1";	
$qu1 = mysqli_query($conn,$query1);
$num1 = mysqli_num_rows($qu1);
$activated = "UPDATE tb_purchase_order SET edi_status='RECEIVED' WHERE po_number='".$id."' ";
$query2 = mysqli_query($conn,$activated);
if($num1 > 0) {
$result=mysqli_fetch_object($qu1);
header('Content-Type: application/pdf');
header('Content-disposition: attachment;filename=MUI/PO.pdf');
readfile('documents/MUI/PO.pdf');
echo $result->po_pdf_image;
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
$query3 = mysqli_query($conn,$activated1);

$menu = 'Purchase Order';
$insert = "INSERT INTO tb_activity_log (date_time, username, supplier, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[supplier]', '$_SESSION[account_status]', '$menu', 'Download PO Number : ".$id."')";
$query_update_po = mysqli_query($conn,$insert);
?>

<?php
// CLEAN FILENAME
function jin_gfile($txt) {
$txt = preg_replace("/[^a-zA-Z0-9s.]/", "_", trim($txt));
return $txt;
}
?>

