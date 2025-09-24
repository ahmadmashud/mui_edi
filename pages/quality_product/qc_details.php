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
  <h3 class="box-title"><b>Quality Check</b></h3>
</div><!-- /.box-header -->	

<div style="overflow-x:auto;">	
<table id="example1" class="table table-bordered table-striped">
  <tr> 
    <th colspan=9 align="center">Part Information</th>
	<th colspan=60 align="center">Defect</th>
  </tr>
  <tr>
	<th>PO Number</th>
	<th>DO Number</th>
	<th>Item Description</th>
	<th>Item Code</th>
	<th>Unit</th>
	<th>Quantity Receiving</th>
	<th>Good</th>
	<th>NG</th>
	<th>% NG</th>
	<th>Weld Line</th>
	<th>Silver</th>
	<th>Crack</th>
	<th>Sort Mould</th>
	<th>Corrosive</th>
	<th>Flow Mark</th>
	<th>Sink Mark</th>
	<th>Black Dot</th>
	<th>Flashes</th>
	<th>White Mark</th>
	<th>Fleck</th>
	<th>Oily</th>
	<th>Gas Mark</th>
	<th>Broken Runner</th>
	<th>Shortage</th>
	<th>Non Standard Packing</th>
	<th>Step</th>
	<th>Excess Material</th>
	<th>Dented Scrath Wip</th>
	<th>Dirty Wip</th>
	<th>Mix Part Wip</th>
	<th>Over Cut Wip</th>
	<th>Bending Wip</th>
	<th>Dimention Wip</th>
	<th>Gate Cut Wip</th>
  </tr>
  
  <?php
  if (isset($_GET['do_number']) AND ($_GET['po_number'])) {
  $do_number			= $_GET['do_number'];
  $po_number			= $_GET['po_number'];
  }else{
  die ("Error. No ID Selected! ");	
  }
					  
  $select_sdo = mysql_query("SELECT * FROM tb_quality_control_check_details where do_number='$do_number' AND po_number='$po_number' order by part_name");
  while($sdo=mysql_fetch_array($select_sdo)){
  ?>	
				  
  <tr>
    <td><?php echo $sdo['po_number']; ?></td>
	<td><?php echo $sdo['do_number']; ?></td>
	<td><?php echo $sdo['part_name']; ?></td>
	<td><?php echo $sdo['part_number']; ?></td>
	<td><?php echo $sdo['material_unit']; ?></td>
	<td><?php echo $sdo['quantity_receiving']; ?></td>
	<td><?php echo $sdo['good']; ?></td>
	<td><?php echo $sdo['not_good']; ?></td>
	<td><?php echo $sdo['percentage_ng']; ?></td>
	<td><?php echo $sdo['weld_line']; ?></td>
	<td><?php echo $sdo['silver']; ?></td>
	<td><?php echo $sdo['crack']; ?></td>
	<td><?php echo $sdo['sort_mould']; ?></td>
	<td><?php echo $sdo['corrosive']; ?></td>
	<td><?php echo $sdo['flow_mark']; ?></td>
	<td><?php echo $sdo['sink_mark']; ?></td>
	<td><?php echo $sdo['black_dot']; ?></td>
	<td><?php echo $sdo['flashes']; ?></td>
	<td><?php echo $sdo['oily']; ?></td>
	<td><?php echo $sdo['white_mark']; ?></td>
	<td><?php echo $sdo['fleck']; ?></td>
	<td><?php echo $sdo['gas_mark']; ?></td>
	<td><?php echo $sdo['broken_runner']; ?></td>
	<td><?php echo $sdo['shortage']; ?></td>
	<td><?php echo $sdo['non_standard_packing']; ?></td>
	<td><?php echo $sdo['step']; ?></td>
	<td><?php echo $sdo['excess_material']; ?></td>
	<td><?php echo $sdo['dented_scrath_wip']; ?></td>
	<td><?php echo $sdo['dirty_wip']; ?></td>
	<td><?php echo $sdo['mix_part_wip']; ?></td>
	<td><?php echo $sdo['over_cut_wip']; ?></td>
	<td><?php echo $sdo['bending_wip']; ?></td>
	<td><?php echo $sdo['dimention_wip']; ?></td>
	<td><?php echo $sdo['gate_cut_wip']; ?></td>
  </tr>
	 <?php
	  }
	  $menu_qc = 'Quality Check';
	  $insert_qc = "INSERT INTO tb_activity_log (date_time, username, supplier, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[supplier]', '$_SESSION[account_status]', '$menu_qc', 'Quality Check Details -> PO Number : ".$po_number.", DO Number : ".$do_number."')";
	  $query_insert_qc = mysql_query ($insert_qc);
	 ?>
	 
  <?php
  $show1 = mysql_query("SELECT * FROM tb_quality_control_check_details where do_number='$do_number' AND po_number='$po_number'");						
  if(mysql_num_rows($show1) == 0){											
  }else{
  $rows_sup = mysql_fetch_assoc($show1);							
  }
  ?>
  <tr>
	<td></td>
	<td colspan=68 align="right">
	<a href="export_csv_qc_det.php?do_number=<?=$do_number;?>&po_number=<?=$po_number;?>">
	<input type="button" style="width:10%;" value="Export to CSV" />
	</a>
	</td>
  </tr>
</table>
</div>

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