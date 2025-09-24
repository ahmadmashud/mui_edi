<?php
//header to give the order to the browser
include "config.php";
session_start();
date_default_timezone_set("Asia/Jakarta");
$jam=date('d/m/Y h:i:s');	
$tgl=date('Y-m-d');
$jamm= date("H:i:s");
?>

<html>
	<meta charset="UTF-8">
	<title>MUI-Electronic Data Interchange</title>
	<link rel="shortcut icon" href="../../favicon.ico">
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="../../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
	<link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
	<link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
	<style>
	input[type="button"] 
	{
		background-color: #4dc3ff;
		color: white;
		padding: 2px 2px;
		cursor: pointer;
		border: none;
		width: 55%;
	}
	
	input[type="button"]:hover 
	{
		opacity: 0.8;
	}	

	* {margin:0; padding: 0;}

	body 
	{
		font-family: calibri;
		font-size: 12px;
	}

	/* Tombol Button Pesan */
	#button {margin: 5% auto; width: 100px; text-align: center;}
	#button a 
	{
		width: 100px;
		height: 30px;
		vertical-align: middle;
		background-color: #F00;
		color: #fff;
		text-decoration: none;
		padding: 10px;
		border-radius: 5px;
		border: 1px solid transparent;
	}

	/* Jendela Pop Up */
	#popup 
	{
		width: 100%;
		height: 100%;
		position: fixed;
		background: rgba(0,0,0,.7);
		top: 0;
		left: 0;
		z-index: 9999;
		visibility: hidden;
	}

	.window 
	{
		width: 350px;
		height: 270px;
		background: #fff;
		border-radius: 10px;
		position: relative;
		padding: 10px;
		text-align: center;
		margin : 0 auto;
		top: 30%
	}
	
	.window h2 
	{
		margin: 30px 0 0 0;
	}
	
	/* Button Close */
	.close-button 
	{
		width: 8%;
		height: 13%;
		line-height: 23px;
		background: #000;
		border-radius: 50%;
		border: 3px solid #fff;
		display: block;
		text-align: center;
		color: #fff;
		text-decoration: none;
		position: absolute;
		top: -7px;
		right: -10px;	
	}

	/* Memunculkan Jendela Pop Up*/
	#popup:target 
	{
		visibility: visible;
	}
	</style>

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
	$select_status_download ="SELECT * FROM tb_transaction_history WHERE status='Ready' and document_id='$document_id'";
	$select_status_download_query = mysql_query($select_status_download);
	$status_download_count = mysql_num_rows($select_status_download_query);
	if ($status_download_count > 0)
	{	
		echo"<script>alert('The file has not been downloaded. Please download the file first. Thank you')</script>";
		echo"<script>javascript:history.back()</script>";
	}
	else 
	{
	?>

	<div id="popup">
		<div class="window">
			<a href="transaction_history.php" class="close-button" title="Close">X</a>	
			<div class="box-header">
				<h3 class="box-title"><b>Please entry a reason.</b></h3>
			</div><!-- /.box-header -->
			<div style='width:320px;height:300px;overflow:auto;'>
				<form action="" method="POST">
					<table id="example1" class="table table-bordered table-striped">
						<tr>				    	
							<td>
								<textarea name="reason" rows="2" cols="30" required ></textarea>
							</td>
						</tr>
						<tr>
							<td>
								<button name="submit">Submit</button>
							</td>
						</tr>
				</form>
  
				<?php
				if(isset($_POST['submit']))
				{		
					$reason	= $_POST['reason'];
					
					$sql = mysql_query("SELECT * FROM tb_transaction_history where status='Downloaded' and document_id='$document_id' ORDER BY document_id DESC");
					if(mysql_num_rows($sql) > 0)
					{
					$no = 1;
					while($data = mysql_fetch_assoc($sql))
					{	
						$data['reference_number'];
						$data['document_name'];											
								
						$update_th_reason = "UPDATE tb_transaction_history SET reason='$reason', request_status = 'REQUESTED' where document_id = '$document_id'";
						$query_update_th_reason = mysql_query ($update_th_reason);	
						
						echo '<td>Your Reason :' .$reason.'</td>';
				  
						$menu_dr = 'Re-download Drawing';
						$insert_dr = "INSERT INTO tb_activity_log (date_time, username, supplier, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[supplier]', '$_SESSION[account_status]', '$menu_dr', 'Download Data -> id: ".$data['document_id'].", Name : ".$data['document_name'].", Number: ".$data['document_number'].", Reason: ".$reason."')";
						$query_insert_dr = mysql_query ($insert_dr);	
					}
					}
				}
	}
				
	?>
					</table>
			</div>
		</div>
	</div>