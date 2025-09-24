<?php
include "../../koneksi.php";
session_start();
date_default_timezone_set("Asia/Jakarta");
$jam=date('d/m/Y h:i:s');	
?>

<html>
<head>
  <meta charset="UTF-8">
  <title>MUI-Electronic Data Interchange</title>
  <link rel="shortcut icon" href="../../favicon.ico">
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
  <link href="../../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
  <link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
  <link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
  <style>
  input[type="button"] {
  background-color: #4dc3ff;
  color: white;
  padding: 2px 2px;
  cursor: pointer;
  border: none;
  width: 55%;
  }
  input[type="button"]:hover {
  opacity: 0.8;
  }		
  </style>
</head>

<div class="box-header">
	<h3 class="box-title"><b>Supplier Delivery Schedule</b></h3>
</div><!-- /.box-header -->	
	
<table id="example1" class="table table-bordered table-striped">
  <tr>
	<th>PO Number</th>
	<th>SDS Number</th>
	<th>Scedule Date</th>
	<th>Item Description</th>
	<th>Item Code</th>
	<th>Quantity</th>
    <th>OS Delivery</th>
  </tr>
  
<?php
if (isset($_GET['sds_number'])) {
  $sds_number = $_GET['sds_number'];
}else{
  die ("Error. No ID Selected! ");	
}
					  
$select_sdo = mysql_query("SELECT * FROM tb_supplier_delivery_schedule_details where sds_number='$sds_number' order by item_code");
while($sdo=mysql_fetch_array($select_sdo)) {
?>
				  
  <tr>
	<td><?php echo $sdo['po_number']; ?></td>
	<td><?php echo $sdo['sds_number']; ?></td>
	<td><?php echo $sdo['schedule_date']; ?></td>
	<td><?php echo $sdo['item_description']; ?></td>
	<td><?php echo $sdo['item_code']; ?></td>
	<td><?php echo $sdo['quantity']; ?></td>
	<td><?php echo $sdo['outstanding_delivery']; ?></td>
  </tr>
  
<?php
}
$menu_sds = 'Supplier Delivery Schedule';
$insert_sds = "INSERT INTO tb_activity_log (date_time, username, supplier, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[supplier]', '$_SESSION[account_status]', '$menu_sds', 'SDS Information -> Details, SDS Number : ".$sds_number."')";
$query_insert_sds = mysql_query ($insert_sds);
?>

<?php
$show1 = mysql_query("SELECT * FROM tb_supplier_delivery_schedule WHERE sds_number='$sds_number'");						
if(mysql_num_rows($show1) == 0){											
}else{
$rows_sup = mysql_fetch_assoc($show1);							
}
?>
<tr>
<td></td>
<td colspan=7 align="right">
  <a href="export_csv_sds_det.php?sds_number=<?=$rows_sup['sds_number'];?>">
	<input type="button" style="width:18%;" value="Export to CSV" />
  </a>
</td>
</tr>
</table>

  <script src="../../plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
  <script src="../../plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
  <script src="../../dist/js/demo.js" type="text/javascript"></script>
  <script type="text/javascript">
  $(function () {
  $("#example1").dataTable();
  $('#example2').dataTable({
  "bPaginate": true,
  "bLengthChange": false,
  "bFilter": false,
  "bSort": true,
  "bInfo": true,
  "bAutoWidth": false
  });
  });
  </script>
</html>
</html>