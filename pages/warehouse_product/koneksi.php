<?php
$host = "localhost:3377";
$user = "mymuiedi1";
$pass = "<maman-mymuiedi1>";
$dbnm = "mui_edi";
$conn = mysql_connect ($host, $user, $pass);
if ($conn) {
$buka = mysql_select_db ($dbnm);
if (!$buka) {
die ("Database tidak dapat dibuka");
}
} else {
die ("Server MySQL tidak terhubung");
}
?>