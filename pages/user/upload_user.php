<?php
error_reporting(0); 
session_start();
date_default_timezone_set("Asia/Jakarta");
$jam=date('d/m/Y h:i:s');

if(!isset($_SESSION['username']))
{
	die("<script>alert('<b>Oops!</b> Access Failed.
	<p>System Logout. You must login again.</p>')</script>
	<script> onclick=location.href='../../index.php'</script>");
}
if($_SESSION['account_status']!="Project Control Officer")
{
    die("<script>alert('<b>Oops!</b> Access Failed.
	<p>You are not Project Control Officer.</p>')</script>
	<script> onclick=location.href='../../index.php''</script>");
}

//$timeout = 60;
//$logout_redirect_url = "../../index.php"; 
//$timeout = $timeout * 60; 
//if (isset($_SESSION['start_time'])) 
//{
//    $elapsed_time = time() - $_SESSION['start_time'];
//   if ($elapsed_time >= $timeout) 
//	{
//        session_destroy();
//        echo "<script>alert('This session has timeout!'); window.location = '$logout_redirect_url'</script>";
//    }
//}
//$_SESSION['start_time'] = time();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>MUI-Global Transfer File</title>
		<link rel="shortcut icon" href="../../favicon.ico">
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="../../bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<link href="../../plugins/fontawesome-free-5.0.2/svg-with-js/css/fa-svg-with-js.css" rel="stylesheet" type="text/css" />
		<!--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />-->
	    <link href="../../bootstrap/css/ionicons.min.css" rel="stylesheet" type="text/css" />
	    <link href="../../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
	    <link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
	    <link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
	    <link href="../../dist/css/font-awesome.css" rel="stylesheet" type="text/css" />
	</head>

	<body class="skin-blue">
		<div class="wrapper">
			<header class="main-header">
				<a href="#" class="logo" style="font-family:calibri; size:30px;"><i><b>MUI-</b>GTF</i></a>
			<nav class="navbar navbar-static-top" role="navigation">
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<i class="fas fa-bars"></i>
				</a>
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<li class="dropdown user user-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img src="../../dist/img/user.jpg" class="user-image" alt="User Image"/>
							<span class="hidden-xs"><?php echo $_SESSION['full_name']?></span>
						</a>
				<ul class="dropdown-menu">
					<li class="user-header">
						<img src="../../dist/img/user.jpg" class="img-circle" alt="User Image" />
						<p> Welcome, <?php echo $_SESSION['full_name']?><br><?php echo $_SESSION['supplier']?> </p>
					</li>  
					<li class="user-footer">
						<div class="pull-right">
							<a href="../login/act-logout.php?username=<?=$_SESSION['username'];?>&supplier=<?=$_SESSION['supplier'];?>" class="btn btn-default btn-flat">Logout</a>
						</div>
					</li>
				</ul>
					</li>
				</ul>
			</div>
			</nav>
		</header>

		<aside class="main-sidebar">
				<section class="sidebar">
					<ul class="sidebar-menu">
						<li class="header">MAIN NAVIGATION</li>
						<li class="active treeview">
							<a href="../../home_uploader.php">
								<i class="fas fa-home"></i> <span>Home</span> 
							</a>
						</li>
						<li>
							<a href="upload_user.php">
								<i class="fas fa-upload"></i> <span>Upload Document</span> 
							</a>
						</li>
						<li>
							<a href="transaction_history.php">
								<i class="fas fa-history"></i> <span>Transaction History</span> 
							</a>
						</li>
					</ul>
				</section>
		</aside>

		<div class="content-wrapper">
			<section class="content-header">
				<h1> &nbsp </h1>
					<ol class="breadcrumb">
						<li><a href="../../home_uploader.php"><i class="fas fa-tachometer-alt"></i>Home</a></li>
						<li class="active">Upload Document</li>
					</ol>
			</section>
	
			<?php
			include('config.php');
			if($_POST['upload'])
			{
				$allowed_ext		= array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'rar', 'zip');
				$file_name			= $_FILES['file']['name'];
				$file_ext			= strtolower(end(explode('.', $file_name)));
				$file_size			= $_FILES['file']['size'];
				$file_tmp			= $_FILES['file']['tmp_name'];
				$reference_number	= $_POST['reference_number'];
				$number				= $_POST['number'];
				$nama				= $_POST['nama'];
				$supplier			= $_POST['supplier'];
				$tgl				= date("Y-m-d");
				$waktu				= date("H:i:s");

				if(in_array($file_ext, $allowed_ext) === true)
				{
					if($file_size < 512000000)
					{	
						$select_th = mysql_query("SELECT * FROM tb_transaction_history WHERE reference_number='$_POST[reference_number]'");
						$th_count = mysql_num_rows($select_th);
											
						if ($th_count > 0)
						{
							echo"<script>alert('Reference Number already exist. Please Refresh first.')</script>";
							echo"<script>javascript:history.back()</script>";
						}
							else
						{
							$lokasi = '../../upload_files/'.$nama.'.'.$file_ext;
							move_uploaded_file($file_tmp, $lokasi);
							$in = ("INSERT INTO tb_transaction_history (document_id, upload_date, upload_time, reference_number, document_number, document_name, document_type, document_size, supplier, uploader, file) VALUES (NULL, '$tgl', '$waktu', '$reference_number', '$number', '$nama', '$file_ext', '$file_size', '$supplier', '$_SESSION[full_name]', '$lokasi')");
							$intrhi=mysql_query($in);
							$document_id=NULL;
							if($in){
								echo"<script>alert('File successfully uploaded!')</script>";
							}						
							else
							{
								echo"<script>alert('ERROR: File upload failed!')</script>";
							}																										
						}
							$update_status = "UPDATE tb_transaction_history SET status='READY', request_status = 'NONE' WHERE reference_number = '$reference_number'";		
							$upsta=mysql_query($update_status);							
							
							$sql = mysql_query("SELECT * FROM tb_transaction_history where status='Ready' and reference_number='$reference_number'");
							if(mysql_num_rows($sql) > 0)
							{
							$no = 1;
							while($data = mysql_fetch_assoc($sql))
							{	
								$data['document_id'];	
								
								$insert_refnumber = "INSERT INTO tb_reference_number (ref_numb_id, code, status, document_id, document_name, document_number, supplier) VALUES ('$data[document_id]', '$reference_number', 'USE', '$data[document_id]', '$nama', '$number', '$supplier')";
								$query_insert_refnumber = mysql_query ($insert_refnumber);
								
								$update_refnumber = "UPDATE tb_reference_number SET date='$tgl', time='$waktu'
								WHERE code = '$reference_number'";							
								$upref=mysql_query($update_refnumber);
																		
								$th ="SELECT * FROM tb_transaction_history where document_id='$data[document_id]'";
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
								
								$email_cc=mysql_query("SELECT supplier_email FROM tb_user WHERE supplier='$supplier' and section='Engineering'");
								while($ecc=mysql_fetch_array($email_cc))
								{	
									$ecc['supplier_email']; 
									$cc=$ecc['supplier_email']; 
								}
																	
								$email2  = "SELECT email FROM tb_user WHERE supplier='PRODUCTION' and section='PRODUCTION'";
								$query_email2 = mysql_query($email2);
								$row2 = mysql_fetch_array($query_email2);
						 
								// EDIT THE 2 LINES BELOW AS REQUIRED
								$email_from="transferfile-notification-noreply@ptmui.co.id";
								$email_to = $row['email'];
								$email_subject = "Transfer File Notification";
								$email_message = "
								Dear ".$supplier.",
								
								This notification just to remind that there are some Drawing that are ready to be Downloaded with Document Number : ".$rows_th['document_number']."
								and Document Name : ".$rows_th['document_name']."
								and here are the Reference Number to download: ".$rows_th['reference_number']."
								
								For more details, please login to Web EDI MUI. Thank you for your attention.
								
								Note : *** This is an automatically generated email by Web EDI MUI, please do not reply to this message. ***";
							 
								// create email headers
								$headers = 'From: '.$email_from."\r\n".
								"CC: ".$cc."";
								//$headers .= 'Cc: purchasing@ptmui.co.id' . "\r\n"; can
								//"CC: purchasing@ptmui.co.id, staffprod@ptmui.co.id";		
								'Reply-To: '.$email_from."\r\n" .
								'X-Mailer: PHP/' . phpversion();
								@mail($email_to, $email_subject, $email_message, $headers, $Cc);  

								echo"<script>alert('Your email has been sent.')</script>";
								echo"<script>javascript:history.back()</script>";
																				
								$menu_upload = 'Upload document';
								$insert_upload = "INSERT INTO tb_activity_log (date_time, username, supplier, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[supplier]', '$_SESSION[account_status]', '$menu_upload', 'Download Data -> id: ".$data['document_id'].", Ref. Numb: ".$_POST['reference_number'].", Name : ".$_POST['nama'].", Number: ".$_POST['number']."')";
								$inupl=mysql_query($insert_upload);
							}	  
					    }													
					}
					else
					{
						echo"<script>alert('ERROR: The maximum file size is 512 Mb!')</script>";
					}
				}
				else
				{ 
					echo"<script>alert('ERROR: File extension not allowed!')</script>";
				}
			}
			?>
	
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<div class="box">              	
						<div class="box-header">
							<h3 class="box-title"><b>Upload Document</b></h3>
						</div><!-- /.box-header -->
				  
						<?php
						$query = "SELECT supplier FROM tb_user where material_type = 'PART' group by supplier order by supplier";
						$rs = mysql_query($query) or die(mysql_error());
						$cbstr = "";
						while ($r = mysql_fetch_array($rs))
						{
							$cbstr .= "<option value='$r[supplier]'>$r[supplier]</option>";
						}
					
						//$query1 = "SELECT code FROM tb_reference_number where status = 'unuse' group by status";
						//$result_code = mysql_query($query1) or die(mysql_error());
						//$rfnm = "";
						//while ($rc = mysql_fetch_array($result_code))
						//{
						//		$rfnm .= "$rc[code]";
						//}
				
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
						?>
	
						<div class="box-body">
							<form action="" method="post" enctype="multipart/form-data">
								<table width="100%" border="0" bgcolor="#eee" cellpadding="0" cellspacing="0">
									<tr>				    	
										<td width="15%"><b>Reference Number</b></td><td><b>:</b></td>
										<td>
											<input type="text" name="reference_number" value="<?php echo $reference_number  ?>" disabled="disabled" />
											<input type="hidden" name="reference_number" value="<?php echo $reference_number  ?>" />
										</td>
									</tr>
									<tr>
										<td width="15%"><b>Document Number</b></td><td><b>:</b></td><td><input type="text" name="number" size="40" required /></td>
									</tr>
									<tr>
										<td width="15%"><b>Document Name</b></td><td><b>:</b></td><td><input type="text" name="nama" size="40" required /></td>
									</tr>
									<tr>
										<td width="10%"><b>Supplier</b></td><td><b>:</b></td><td><select class='Menu' name='supplier' onchange='javascript:rubah(this)'><option>--Choose Supplier--</option>
										<?php echo $cbstr; ?>
										</select></td>	
									</tr>
									<tr>
										<td width="15%"><b>Choose File</b></td><td><b>:</b></td><td><input type="file" name="file" required /></td>
									</tr>
									<tr>
										<td>&nbsp;</td><td>&nbsp;</td><td><input type="submit" name="upload" value="Upload" /></td>
									</tr>
								</table>
							</form>
						</div>
					</div>
				</div>
			</div>
	    </section>
	    </div>
	  
		<footer class="main-footer">
	    <div class="pull-right hidden-xs"></div>
			Version 1.0. Copyright &copy; 2018 MUI Information Technology Department. All rights reserved
		</footer>
		</div>
	  
		<script src="../../plugins/jQuery/jQuery-2.1.3.min.js"></script>
		<script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="../../plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
		<script src="../../plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
		<script src="../../plugins/fontawesome-free-5.0.2/svg-with-js/js/fontawesome-all.min.js" type="text/javascript"></script> 
		<script src="../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
		<script src='../../plugins/fastclick/fastclick.min.js'></script>
		<script src="../../dist/js/app.min.js" type="text/javascript"></script>
		<script src="../../dist/js/demo.js" type="text/javascript"></script>
		<script type="text/javascript">
		$(function () 
		{
			$("#example1").dataTable();
			$('#example2').dataTable(
			{
			  "bPaginate": true,
			  "bLengthChange": false,
			  "bFilter": false,
			  "bSort": true,
			  "bInfo": true,
			  "bAutoWidth": false
			});
		});
		</script>
		
	</body>
	
</html>