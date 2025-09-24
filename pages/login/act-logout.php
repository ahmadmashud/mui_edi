<?php
include "../../koneksi.php";
date_default_timezone_set("Asia/Jakarta");
$jam=date('d/m/Y H:i:s');
$tgl=date('Y-m-d');

if (isset($_GET['username']) AND ($_GET['supplier_name'])) 
{
	$username			= $_GET['username'];
	$supplier			= $_GET['supplier_name'] ?? "";
}
	else
{
	die ("Error. No ID Selected! ");	
}

// membaca kode barang terbesar
$query = "SELECT max(date_logout) as maxKode FROM tb_log_history";
$hasil = mysqli_query($conn,$query);
$data  = mysqli_fetch_array($hasil);
$date_logout = $data['maxKode'];

$activated = "UPDATE tb_log_history SET date_logout='$jam' WHERE username='$username' and supplier='$supplier' and date_logout='$date_logout'";
$query2 = mysqli_query ($conn,$activated);
	
unset($_SESSION['username']);
unset($_SESSION['account_status']);
session_destroy();
header("location:../../../interchange/index.php");	
?>


