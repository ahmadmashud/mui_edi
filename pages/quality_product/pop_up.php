<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>MUI-Electronic Data Interchange</title>
<link rel="shortcut icon" href="../../favicon.ico">
<style>

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 180px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 65%;
	margin-left:25%;
}

/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

  #customers {
  font-family: "calibri";
  border-collapse: collapse; 
  width: 100%;
  }
  #customers td, #customers th {
  table-layout: fixed;
  border: 1px solid #eee;
  padding: 5px;
  }
  #customers tr:nth-child(even){background-color: #f2f2f2;}
  #customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: center;
  background-color: #f2f2f2;
  color: black;
  }
</style>
</head>
<body>

<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <div class="box-header">
	  <h3 class="box-title"><b>Quality Check</b></h3>
	</div><!-- /.box-header -->
	<?php
	include "../../koneksi.php";
	session_start();
	date_default_timezone_set("Asia/Jakarta");
	$jam=date('d/m/Y h:i:s');	
	?>
	<div style='width:900px;height:250px;overflow:auto;'>
	<table id="customers">
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
	 ?>
	 
</table>
</div>
</div>
</div>

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

