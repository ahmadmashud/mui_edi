<?php
//header to give the order to the browser
include "config.php";
session_start();
date_default_timezone_set("Asia/Jakarta");
$jam=date('d/m/Y h:i:s');	
$tgl=date('Y-m-d');
$jamm= date("H:i:s");

//7hari 604800 detik
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
		width: 300px;
		height: 210px;
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
	$select_upload_date = mysql_query("SELECT upload_date from tb_transaction_history WHERE document_id='$document_id'");
	$show_upload_date = mysql_fetch_assoc($select_upload_date);
	$upload_date = $show_upload_date['upload_date'];
	
	$now = new DateTime($upload_date);
	$the_interval = new DateInterval('P0Y0M7D');
	$now->add($the_interval);
	$now->format('Y-m-d');

	if ($tgl >= $now->format('Y-m-d')) {
		echo "<script>alert('Your link download has been expired. Please contact Project Control Officer to get new link for download. Thank You.')</script>";
		echo "<script>javascript:history.back()</script>";
	}
	else
	{
	$select_status_download ="SELECT * FROM tb_transaction_history WHERE status='Downloaded' and document_id='$document_id'";
	$select_status_download_query = mysql_query($select_status_download);
	$status_download_count = mysql_num_rows($select_status_download_query);
	if ($status_download_count > 0)
	{
		
		echo"<script>alert('You are already download this file, if you want to download this file again. Please contact Project Control Officer or click Req. Re-download to get the New Reference Number. Thank You.')</script>";
		echo"<script>javascript:history.back()</script>";
	}
	else 
	{
	?>

	<div id="popup">
		<div class="window">
			<a href="transaction_history.php" class="close-button" title="Close">X</a>	
			<div class="box-header">
				<h3 class="box-title"><b>Entry Reference Number</b></h3>
			</div><!-- /.box-header -->
			<div style='width:290px;height:200px;overflow:auto;'>
				<form action="" method="POST">
					<table id="example1" class="table table-bordered table-striped">
						<tr>				    	
							<td>
							<input type="text" name="reference_number" required />
							</td>
							<td>
							<button name="submit">Submit</button>
							</td>
						</tr>
				</form>
  
				<?php
				if(isset($_POST['submit']))
				{		
					$reference_number	= $_POST['reference_number'];
					
					$sql = mysql_query("SELECT * FROM tb_transaction_history where status='Ready' and reference_number='$reference_number' ORDER BY document_id DESC");
					if(mysql_num_rows($sql) > 0)
					{
						$no = 1;
						while($data = mysql_fetch_assoc($sql))
						{	
							$data['reference_number'];
							$data['document_name'];
							$data['file'];
				  
							if ($reference_number = $data['reference_number']) 
							{  
								echo '<td><a href="'.$data['file'].'">'.$data['document_name'].'</a></td>';
								// Menghitung waktu berakhirnya link					
							} 
							else 
							{
								echo 'Your Reference Number Not Valid, Please Contact Project Control Officer to get the Valid Number. Thank You';
							}
							
							$update_drawing = "UPDATE tb_transaction_history SET downloader='$_SESSION[full_name]', download_date='$tgl', download_time='$jamm', status='DOWNLOADED', request_status='NONE' WHERE document_id = '$data[document_id];'";		
							$query_update_drawing = mysql_query($update_drawing);	  
	  
							$select_dr = "SELECT * FROM tb_transaction_history WHERE document_id = '".$data['document_id']."'";
							$query_select_dr = mysql_query ($select_dr);
							$data_count = mysql_num_rows($query_select_dr);		
							$download_seq = $data['download_seq'];
						
							for($i=0;$i<$data_count;$i++) 
							{	
								$download_seq = $download_seq + 1;
							} 

							$update_download_seq = "UPDATE tb_transaction_history SET download_seq = '$download_seq' WHERE document_id = '$data[document_id];'";		
							$query_update_download_seq = mysql_query($update_download_seq);
						
							$menu_dr = 'Download Drawing';
							$insert_dr = "INSERT INTO tb_activity_log (date_time, username, supplier, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[supplier]', '$_SESSION[account_status]', '$menu_dr', 'Download Data -> id: ".$data['document_id'].", Name : ".$data['document_name'].", Number: ".$data['document_number']."')";
							$query_insert_dr = mysql_query ($insert_dr);
						}	  
					}
				}
	}
	}
	?>
  
					</table>
			</div>
		</div>
	</div>
