<?php

session_start();
include "config.php";

if (isset($_GET['document_id'])) {
$document_id = $_GET['document_id'];


$th ="SELECT * FROM tb_transaction_history where document_id='$document_id'";
$query_th=mysql_query($th);
$rows_th = mysql_fetch_assoc($query_th);
$rows_th['document_id'];
$rows_th['document_name'];
$rows_th['document_number'];
$rows_th['supplier'];

$supplier = $rows_th['supplier'];
  
$email  = "SELECT email FROM tb_user WHERE supplier='$supplier' and section='Engineering'";
$query_email = mysql_query($email);
$row = mysql_fetch_array($query_email);
$cek = mysql_num_rows($query_email);

$email1  = "SELECT email FROM tb_user WHERE supplier='PURCHASING' and section='PURCHASING'";
$query_email1 = mysql_query($email1);
$row1 = mysql_fetch_array($query_email1);

$email2  = "SELECT email FROM tb_user WHERE supplier='PRODUCTION' and section='PRODUCTION'";
$query_email2 = mysql_query($email2);
$row2 = mysql_fetch_array($query_email2);
 
    // EDIT THE 2 LINES BELOW AS REQUIRED
	$email_from="newreferencenumber-notification-noreply@ptmui.co.id";
    $email_to = $row['email'];
    $email_subject = "New Reference Number Notification";
	$email_message = "
	Dear ".$supplier.",

	This notification just to remind that there are some Drawing that are ready to be Downloaded with Document Number ".$rows_th['document_number']."
	and Document Name : ".$rows_th['document_name']." 
	and here are the New Reference Number to download: ".$rows_th['reference_number']."

	For more details, please login to Web EDI MUI. Thank you for your attention.

	Note : *** This is an automatically generated email by Web EDI MUI, please do not reply to this message. ***";
 

// create email headers
$headers = 'From: '.$email_from."\r\n".
"CC: purchasing@ptmui.co.id, staffprod@ptmui.co.id";
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);  
?>
 
<!-- include your own success html here -->
 
<?php
 echo '<table style="border: 1px outset;" align="center" width=30%>
	   <tr><td align="center" height=80px>Your email has been sent.</td></tr>
	   <tr><td style="background:#f2f2f2;" font-family="Arial" align="right" height=40px><a href="upload_user.php"><button>Back</button></a></td></tr>
	   </table>';		

}else{
die ("Error. No ID Selected! ");	
}
?>