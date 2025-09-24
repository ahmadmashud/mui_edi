<?php
include "koneksi.php";
?>

<html>
	<head>
		<meta charset="UTF-8">
		<title>MUI-Electronic Data Interchange</title>
		<link rel="shortcut icon" href="../../favicon.ico">
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<!-- Bootstrap 3.3.2 -->
		<link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<!-- Font Awesome Icons -->
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<!-- Ionicons -->
		<link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
		<!-- DATA TABLES -->
		<link href="../../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
		<!-- Theme style -->
		<link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
		<!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
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
<?php
$show = mysql_query("SELECT * FROM tb_quality_control_check_details order by do_number ASC");		
if(mysql_num_rows($show) == 0){		
echo '<script>window.history.back()</script>';		
}else{
$rows = mysql_fetch_assoc($show);
}
?>

<table id="example1" class="table table-bordered table-striped">
  <tr> 
    <th colspan=9 align="center">Part Information</th>
	<th colspan=9 align="center">Balance</th>
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
	<?php$WL?>=<th>Weld Line</th>
	<th>Silver</th>
  </tr>
  <?php			  
$WL
?>	
<?php			  
$select_sdo = mysql_query("SELECT * FROM tb_quality_control_check_details order by part_name");
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
	 <?php
	  if ($sdo['weld_line']=null) {
      echo "none";
	  }
	  else {
	  ?>
	  <td><?php echo $sdo['weld_line']; ?></td>
	  <?php
	  }
	 ?>		
	<td><?php echo $sdo['silver']; ?></td>
  </tr>
<?php
	  }
?>
</table>
</div>


    <!-- DATA TABES SCRIPT -->
    <script src="../../plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="../../plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <script src="../../dist/js/demo.js" type="text/javascript"></script>
    <!-- page script -->
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


<!--
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
	<th>Dented Scrath Process</th>
	<th>Dirty Process</th>
	<th>Mix Part Process</th>
	<th>Over Cut Process</th>
	<th>Bending Process</th>
	<th>Dimention Process</th>
	<th>Broken</th>
	<th>Wrinkle</th>
	<th>Gate Cut Process</th>
	<th>White Wash</th>
	<th>Peel Off</th>
	<th>Yellowish</th>
	<th>Under Shinning</th>
	<th>Skip</th>
	<th>Bubble</th>
	<th>Rough Dot</th>
	<th>Copper Mark</th>
	<th>Over Shinning</th>
	<th>Burn Chrome</th>
	<th>Dot</th>
	<th>Pitting</th>
	<th>Bubble</th>
	<th>Not In A Position</th>
	<th>Damage</th>
	<th>Fold</th>
	<th>Over Tape</th>
	<th>Under Tape</th>
	<th>Dirty Spray</th>
	<th>Over Spray</th>
	<th>Under Spray</th>
	<th>Uneven Spray</th>
	<th>Glass</th>
	<th>Polish Mark</th>
	<th>Orange Peel</th>
	<th>Other</th>
	<th>Remark</th>
  </tr>
  
  <?php
	  if (isset($_POST['check'])) {
	  $do_number_id		= $_POST['do_number'].'-'.$_POST['check'];
	  }
	  else {
	  $do_number_id	= $_POST['do_number'];	  
	  }
	?>
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
	<td><?php echo $sdo['dented_scrath_process']; ?></td>
	<td><?php echo $sdo['dirty_process']; ?></td>
	<td><?php echo $sdo['mix_part_process']; ?></td>
	<td><?php echo $sdo['over_cut_process']; ?></td>
	<td><?php echo $sdo['bending_process']; ?></td>
	<td><?php echo $sdo['dimention_process']; ?></td>
	<td><?php echo $sdo['broken']; ?></td>
	<td><?php echo $sdo['wrinkle']; ?></td>
	<td><?php echo $sdo['gate_cut_process']; ?></td>
	<td><?php echo $sdo['white_wash']; ?></td>
	<td><?php echo $sdo['peel_off']; ?></td>
	<td><?php echo $sdo['burn_mark']; ?></td>
	<td><?php echo $sdo['yellowish']; ?></td>
	<td><?php echo $sdo['under_shinning']; ?></td>
	<td><?php echo $sdo['skip']; ?></td>
	<td><?php echo $sdo['bubble']; ?></td>
	<td><?php echo $sdo['rough_dot']; ?></td>
	<td><?php echo $sdo['copper_mark']; ?></td>
	<td><?php echo $sdo['over_shinning']; ?></td>
	<td><?php echo $sdo['burn_chrome']; ?></td>
	<td><?php echo $sdo['dot']; ?></td>
	<td><?php echo $sdo['pitting']; ?></td>
	<td><?php echo $sdo['not_in_a_position']; ?></td>
	<td><?php echo $sdo['damage']; ?></td>
	<td><?php echo $sdo['fold']; ?></td>
	<td><?php echo $sdo['over_tape']; ?></td>
	<td><?php echo $sdo['dirty_spray']; ?></td>
	<td><?php echo $sdo['over_spray']; ?></td>
	<td><?php echo $sdo['under_spray']; ?></td>
	<td><?php echo $sdo['uneven_spray']; ?></td>
	<td><?php echo $sdo['glass']; ?></td>
	<td><?php echo $sdo['polish_mark']; ?></td>
	<td><?php echo $sdo['orange_peel']; ?></td>
	<td><?php echo $sdo['other']; ?></td>
	<td><?php echo $sdo['remarks']; ?></td>
	
	. $sdo['silver']=0 . $sdo['crack']=0 . $sdo['sort_mould']=0 . $sdo['corrosive']=0 . $sdo['flow_mark']=0 . $sdo['sink_mark']=0 . $sdo['black_dot']=0 . $sdo['flashes']=0 . $sdo['oily']=0 . $sdo['white_mark']=0 . $sdo['fleck']=0 . $sdo['gas_mark']=0 . $sdo['broken_runner']=0 . $sdo['shortage']=0 . $sdo['non_standard_packing']=0 . $sdo['step']=0 . $sdo['excess_material']=0)
	-->