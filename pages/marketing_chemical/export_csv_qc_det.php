<?php
//header to give the order to the browser
header("Content-Type: application/vnd.ms-excel");
include "../../koneksi.php";
?>

<table id="example1">
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
	<?php
	  if ($sdo['weld_line']==0) {
	  }
	  else {
	  echo '<th>Weld Line</th>';
	  echo '<td>'.$sdo['weld_line'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['silver']==0) {
	  }
	  else {
	  echo '<th>Silver</th>';
	  echo '<td>'.$sdo['silver'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['crack']==0) {
	  }
	  else {
	  echo '<th>Crack</th>';
	  echo '<td>'.$sdo['crack'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['sort_mould']==0) {
	  }
	  else {
	  echo '<th>Sort Mould</th>';
	  echo '<td>'.$sdo['sort_mould'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['corrosive']==0) {
	  }
	  else {
	  echo '<th>Corrosive</th>';
	  echo '<td>'.$sdo['corrosive'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['flow_mark']==0) {
	  }
	  else {
	  echo '<th>Flow Mark</th>';
	  echo '<td>'.$sdo['flow_mark'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['sink_mark']==0) {
	  }
	  else {
	  echo '<th>Sink Mark</th>';
	  echo '<td>'.$sdo['sink_mark'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['black_dot']==0) {
	  }
	  else {
	  echo '<th>Black Dot</th>';
	  echo '<td>'.$sdo['black_dot'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['flashes']==0) {
	  }
	  else {
	  echo '<th>Flashes</th>';
	  echo '<td>'.$sdo['flashes'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['oily']==0) {
	  }
	  else {
	  echo '<th>Oily</th>';
	  echo '<td>'.$sdo['oily'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['white_mark']==0) {
	  }
	  else {
	  echo '<th>White Mark</th>';
	  echo '<td>'.$sdo['white_mark'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['fleck']==0) {
	  }
	  else {
	  echo '<th>Fleck</th>';
	  echo '<td>'.$sdo['fleck'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['gas_mark']==0) {
	  }
	  else {
	  echo '<th>Gas Mark</th>';
	  echo '<td>'.$sdo['gas_mark'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['broken_runner']==0) {
	  }
	  else {
	  echo '<th>Broken Runner</th>';
	  echo '<td>'.$sdo['broken_runner'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['shortage']==0) {
	  }
	  else {
	  echo '<th>Shortage</th>';
	  echo '<td>'.$sdo['shortage'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['non_standard_packing']==0) {
	  }
	  else {
	  echo '<th>Non Standard Packing</th>';
	  echo '<td>'.$sdo['non_standard_packing'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['step']==0) {
	  }
	  else {
	  echo '<th>Step</th>';
	  echo '<td>'.$sdo['step'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['excess_material']==0) {
	  }
	  else {
	  echo '<th>Excess Material</th>';
	  echo '<td>'.$sdo['excess_material'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['dented_scrath_wip']==0) {
	  }
	  else {
	  echo '<th>Dented Scrath WIP</th>';
	  echo '<td>'.$sdo['dented_scrath_wip'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['dirty_wip']==0) {
	  }
	  else {
	  echo '<th>Dirty WIP</th>';
	  echo '<td>'.$sdo['dirty_wip'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['mix_part_wip']==0) {
	  }
	  else {
	  echo '<th>Mix Part WIP</th>';
	  echo '<td>'.$sdo['mix_part_wip'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['over_cut_wip']==0) {
	  }
	  else {
	  echo '<th>Over Cut WIP</th>';
	  echo '<td>'.$sdo['over_cut_wip'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['bending_wip']==0) {
	  }
	  else {
	  echo '<th>Bending WIP</th>';
	  echo '<td>'.$sdo['bending_wip'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['dimention_wip']==0) {
	  }
	  else {
	  echo '<th>Dimention WIP</th>';
	  echo '<td>'.$sdo['dimention_wip'].'</td>';
	  }
	?>
	
	<?php
	  if ($sdo['gate_cut_wip']==0) {
	  }
	  else {
	  echo '<th>Gate Cut WIP</th>';
	  echo '<td>'.$sdo['gate_cut_wip'].'</td>';
	  }
	?>
  </tr>
  
  <?php
  }
  ?>
</table>

<?php
header("Content-disposition: attachment; filename=qualitycheck.xls");
?>