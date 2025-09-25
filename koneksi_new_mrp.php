<?php
$host = "103.163.138.22";
$user = "yrhmyid_admin";
$pass = "VZD$&.u(xSvc";
$dbnm = "yrhmyid_mui_mrp";
$port = 3306; // Port MySQL default

$conn_mrp = new mysqli($host, $user, $pass, $dbnm,$port);

// Check connection
if ($conn_mrp->connect_error) {
    die("Koneksi gagal: " . $conn_mrp->connect_error);
}

?>
