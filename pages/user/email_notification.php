<?php
session_start();
include "conn.php";

if (isset($_GET['document_id'])) {
$document_id = $_GET['document_id'];
}else{
die ("Error. No ID Selected! ");	
}

$th ="SELECT * FROM tb_transaction_history where document_id='$document_id'";
$query_th=mysql_query($th,$koneksi_1);
$rows_th = mysql_fetch_assoc($query_th);
$rows_th['document_id'];
$rows_th['document_name'];
$rows_th['document_number'];
$rows_th['supplier'];

$supplier = $rows_th['supplier'];
  
$email  = "SELECT email FROM tb_user WHERE supplier='$supplier' and section=''";
$query_email = mysql_query($email,$koneksi_2);
$row = mysql_fetch_array($query_email);
$cek = mysql_num_rows($query_email);
?>

<?php
ini_set( 'display_errors', 1 );   
error_reporting( E_ALL );    
$from = "transferfile-notification-noreply@ptmui.co.id";    
$to = $row['email'];    
$subject = "Transfer File Notification";    
$message = '
	
Dear '.$supplier.',

This notification is just to remind that there are some Drawing that are ready to Download with a title : '.$rows_th['document_name'].' and here are the Reference Number to download: '.$rows_th['reference_number'].'

For more details, please login to Web EDI MUI. Thank you for your attention.

Note : *** This is an automatically generated email by Web EDI MUI, please do not reply to this message. ***';   
$headers = "From:" . $from;    
mail($to,$subject,$message, $headers);    
echo "Pesan email sudah terkirim.";
?>