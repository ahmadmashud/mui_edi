<?php
$hostname = "localhost";
$username = "it-dba";
$password = "MuiMumun40";
 
// mengatur koneksi dan disimpan dalam satu variabel
$koneksi_1 = mysql_connect($hostname, $username, $password);
$koneksi_2 = mysql_connect($hostname, $username, $password, true);
 
// mengatur pemilihan database sesuai koneksi
mysql_select_db('gtf', $koneksi_1 );
mysql_select_db('mui_edi', $koneksi_2 );

//fungsi untuk mengkonversi size file
function formatBytes($bytes, $precision = 2) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 

    $bytes /= pow(1024, $pow); 

    return round($bytes, $precision) . ' ' . $units[$pow]; 
} 
?>