<html>
<head>
</head>
<?php
include "../../koneksi.php";
 
$po_number = $_GET['po_number'];

echo "<select name='divkedua'>"; 
$rs = mysql_query ("SELECT sds_number FROM tb_supplier_delivery_schedule WHERE po_number='$po_number' and sds_status = 'OPEN' order by sds_number ASC");
while ($r = mysql_fetch_array($rs))
{	
echo "<option value=".$r[sds_number].">".$r[sds_number]."</option>";}
echo "</select>";
?>
</html>
