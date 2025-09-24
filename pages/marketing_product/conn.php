<?php
$host = 'localhost:3377'; 
$username = 'mymuiedi1'; 
$password = '<maman-mymuiedi1>'; 
$database = 'mui_edi'; 

// Koneksi ke MySQL dengan PDO
$pdo = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
?>
