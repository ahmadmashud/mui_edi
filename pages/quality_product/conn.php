<?php
//$host = 'localhost:3377'; 
//$username = 'mymuiedi1'; 
//$password = '<maman-mymuiedi1>'; 
//$database = 'mui_edi'; 
$host = "192.168.1.114:3477";
$user = "it-dba";
$pass = "MuiMumun40";
$dbnm = "edi";

// Koneksi ke MySQL dengan PDO
$pdo = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
?>
