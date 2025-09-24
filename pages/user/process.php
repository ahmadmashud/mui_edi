<?php
include "config.php";
session_start();
date_default_timezone_set("Asia/Jakarta");
$jam=date('d/m/Y h:i:s');	
$tgl=date('Y-m-d');
$jamm= date("H:i:s");
?>

<?php
if (isset($_GET['document_id'])) 
{
	$document_id = $_GET['document_id'];
}
	else
{
	die ("Error. No ID Selected! ");	
}
?>
  
<?php
$select_th="SELECT * FROM tb_transaction_history WHERE status='READY' and document_id='$document_id'";
$query_select_th=mysql_query($select_th);
$status_th = mysql_num_rows($query_select_th);
if ($status_th > 0)
{		
	echo"<script>alert('Your Reference Number still Active. Supplier must download the file first. Thank You.')</script>";
	echo"<script>javascript:history.back()</script>";
} 
	else 
{  
	$th1 ="SELECT * FROM tb_transaction_history where document_id='$document_id'";
	$query_sql1=mysql_query($th1);
	$rows1 = mysql_fetch_assoc($query_sql1);
	$rows1['document_id'];
	$rows1['document_name'];
	$rows1['document_number'];
	$rows1['supplier'];
	$supplier = $rows1['supplier'];
	
	$sql ="SELECT * FROM tb_reference_number where status='UNUSE' and document_id='' and document_name='' and 
	document_number='' group by status order by ref_numb_id";
	$query_sql=mysql_query($sql);
	$rows = mysql_fetch_assoc($query_sql);
	$rows['ref_numb_id'];
	$rows['code'];
		
	function random($panjang)
	{
	$karakter= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
	$string = '';
	for ($i = 0; $i < $panjang; $i++) 
	{
	$pos = rand(0, strlen($karakter)-1);
	$string .= $karakter{$pos};
	}
	return $string;
	}
	$reference_number 	= random(6);
	
	$select_ref = mysql_query("SELECT * FROM tb_reference_number WHERE code='$reference_number'");
    $ref_count = mysql_num_rows($select_ref);				
    if ($ref_count > 0)
    {
		echo"<script>alert('Reference Number already exist. Please process again.')</script>";
		echo"<script>javascript:history.back()</script>";
    }
		else
    {
	
		$update_th = "UPDATE tb_transaction_history SET reference_number='$reference_number', status='READY', request_status='ACCEPTED'
		WHERE document_id = '$document_id'";		
		$query_update_th = mysql_query($update_th);
		
		$insert_refnumber = "INSERT INTO tb_reference_number (ref_numb_id, code, status, document_id, document_name, document_number, supplier) VALUES ('$document_id', '$reference_number', 'USE', '$document_id', '$rows1[document_name]', '$rows1[document_number]', '$rows1[supplier]')";
		$query_insert_refnumber = mysql_query ($insert_refnumber);

		$update_refnumb = "UPDATE tb_reference_number SET date='$tgl', time='$jamm'
		WHERE ref_numb_id = '$document_id' and code='$reference_number'";							
		$uprefnumb=mysql_query($update_refnumb);
	}
		?>
	
		<!--<a href="<?php echo 'send_form_email.php?document_id='.$data['document_id'];''?>"><center>Want to send email notification?</a>-->
	
		<?php					
		$menu_rf = 'Update Ref.Numb';
		$insert_ref = "INSERT INTO tb_activity_log (date_time, username, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[account_status]', '$menu_rf', 'Download Data -> id: ".$document_id.", Ref. Number: ".$reference_number.", Doc.Name : ".$rows1['document_name'].", Doc.Numb : ".$rows1['document_number'].", Supplier : ".$rows1['supplier']."')";
		$query_insert_ref = mysql_query ($insert_ref);	

		echo"<script>alert('Your Reference Number has been Active.')</script>";
		
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

		This notification just to remind that there are some Drawing that are ready to be Downloaded with Document Number ".$rows1['document_number']."
		and Document Name : ".$rows1['document_name']." 
		and here are the New Reference Number to download: ".$reference_number."

		For more details, please login to Web EDI MUI. Thank you for your attention.

		Note : *** This is an automatically generated email by Web EDI MUI, please do not reply to this message. ***";
		 
		// create email headers
		$headers = 'From: '.$email_from."\r\n".
		"CC: ";
		'Reply-To: '.$email_from."\r\n" .
		'X-Mailer: PHP/' . phpversion();
		@mail($email_to, $email_subject, $email_message, $headers);  
	
	echo"<script>alert('Your email has been sent.')</script>";
	echo"<script>javascript:history.back()</script>";   
}
?>  
 
<!--
  $sql_process = mysql_query("SELECT * FROM tb_transaction_history where status='DOWNLOADED' and process_status='NOT ACTIVE'
						where document_id='$document_id'");
  while($result = mysql_fetch_assoc($sql_process)){	
  $result['document_id'];
  $result['document_name'];
  $result['document_number'];
  
  $sql_process2 = mysql_query("SELECT * FROM tb_reference_number where status='UNUSE' and document_id='' and document_number='' and document_name='' and date='' and time='' group by status");
  while($result1 = mysql_fetch_assoc($sql_process2)){	
  $result1['code'];
  
  $update_th_refnumb = "UPDATE tb_transaction_history SET status='READY', process_status='ACTIVE', reference_number='$result1[code]'
  WHERE document_id = '$result[document_id]'";							
  $upthref=mysql_query($update_th_refnumb,$koneksi_1);
  
  $update_refnumb = "UPDATE tb_reference_number SET status='USE', document_id='$result[document_id]', document_name='$result[document_name]', document_number='$result[document_number]', date='$tgl', time='$jamm'
  WHERE document_id = '$result[document_id]'";							
  $uprefnumb=mysql_query($update_refnumb,$koneksi_1);	
  
  
  
  	echo '<table style="border: 1px outset;" align="center" width=30%>
    <tr><td align="center" height=80px>Your email has been sent.</td></tr>
	<tr><td style="background:#f2f2f2;" font-family="Arial" align="right" height=40px><a href="upload_user.php"><button>Back</button></a></td></tr>
	</table>';	
  }
  }
?>
-->
  
