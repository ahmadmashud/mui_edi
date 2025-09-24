<html>
<head>
</head>
<?php
include "../../koneksi.php";
 
$po_number = $_GET['po_number'];

echo "<select name='divkedua'>"; 
$rs = mysql_query ("SELECT do_number FROM tb_quality_control_check_details WHERE po_number='$po_number' group by do_number ASC");
while ($r = mysql_fetch_array($rs))
{	
echo "<option value=".$r[do_number].">".$r[do_number]."</option>";}
echo "</select>";
?>
</html>
