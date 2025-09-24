<?php
include "../../koneksi.php";
error_reporting(0);					
date_default_timezone_set("Asia/Jakarta");
$jam=date('d/m/Y h:i:s');
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>MUI-Electronic Data Interchange</title>
<link rel="shortcut icon" href="../../favicon.ico">
</head>
<body>
<form action="pop_up.php" method="post">
<button id="myBtn">Open Modal</button>
</form>
</body>
</html>