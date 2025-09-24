<?php

$host = "103.163.138.22";
$user = "yrhmyid_admin";
$pass = "VZD$&.u(xSvc";
$dbnm = "yrhmyid_db_edi";
$port = 3306; // Port MySQL default

$conn = new mysqli($host, $user, $pass, $dbnm,$port);

// Check connection
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

echo "Koneksi berhasil";
?>
