<?php
//header to give the order to the browser
header("Content-Type: application/vnd.ms-excel");
include "../../koneksi.php";
session_start();
date_default_timezone_set("Asia/Jakarta");
$jam=date('d/m/Y h:i:s');	
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
					  			  
$select_sdo = mysql_query("select po_number, do_number, item_name, item_code, item_type_name, quantity_receiving, if(quantity_not_good=0,quantity_receiving,sum(quantity_good)) AS sgood, sum(quantity_not_good) AS snot_good, ((sum(quantity_not_good)/quantity_receiving)*100) AS percentage_not_good, sum(weld_line) AS wl, sum(silver) AS s, sum(crack) AS c, sum(sort_mould) AS sm, sum(corrosive) AS co, sum(flow_mark) AS fm, sum(sink_mark) AS sim, sum(black_dot) AS bd, sum(flashes) AS f, sum(oily) AS o, sum(white_mark) AS wm, sum(fleck) AS fl, sum(gas_mark) AS gm, sum(broken_runner) AS br, sum(shortage) AS sh, sum(non_standard_packing) AS nsp, sum(step) AS st, sum(excess_material) AS em, sum(dented_scrath_wip) AS dsw, sum(dirty_wip) AS dw, sum(mix_part_wip) AS mpw, sum(over_cut_wip) AS ocw, sum(bending_wip) AS bw, sum(dimention_wip) AS diw, sum(gate_cut_wip) AS gcw from tb_quality_control_check_details where po_number = '$po_number' and do_number='$do_number' group by item_code order by item_code");
while($sdo=mysql_fetch_array($select_sdo)){
?>		
			  
  <tr>
	<td><?php echo $sdo['po_number']; ?></td>
	<td><?php echo $sdo['do_number']; ?></td>
	<td><?php echo $sdo['item_name']; ?></td>
	<td><?php echo $sdo['item_code']; ?></td>
	<td><?php echo $sdo['item_type_name']; ?></td>
	<td><?php echo $sdo['quantity_receiving']; ?></td>
	<td><?php echo $sdo['sgood']; ?></td>
	<td><?php echo $sdo['snot_good']; ?></td>
	<td><?php echo $sdo['percentage_not_good']; ?></td>
	<td><?php echo $sdo['wl']; ?></td>
	<td><?php echo $sdo['s']; ?></td>
	<td><?php echo $sdo['c']; ?></td>
	<td><?php echo $sdo['sm']; ?></td>
	<td><?php echo $sdo['co']; ?></td>
	<td><?php echo $sdo['fm']; ?></td>
	<td><?php echo $sdo['sim']; ?></td>
	<td><?php echo $sdo['bd']; ?></td>
	<td><?php echo $sdo['f']; ?></td>
	<td><?php echo $sdo['o']; ?></td>
	<td><?php echo $sdo['wm']; ?></td>
	<td><?php echo $sdo['fl']; ?></td>
	<td><?php echo $sdo['gm']; ?></td>
	<td><?php echo $sdo['br']; ?></td>
	<td><?php echo $sdo['sh']; ?></td>
	<td><?php echo $sdo['nsp']; ?></td>
	<td><?php echo $sdo['st']; ?></td>
	<td><?php echo $sdo['em']; ?></td>
	<td><?php echo $sdo['dsw']; ?></td>
	<td><?php echo $sdo['dw']; ?></td>
	<td><?php echo $sdo['mpw']; ?></td>
	<td><?php echo $sdo['ocw']; ?></td>
	<td><?php echo $sdo['bw']; ?></td>
	<td><?php echo $sdo['diw']; ?></td>
	<td><?php echo $sdo['gcw']; ?></td>
  </tr>
  
<?php
}
  	  $menu_qc = 'Quality Check';
	  $insert_qc = "INSERT INTO tb_activity_log (date_time, username, supplier, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[supplier]', '$_SESSION[account_status]', '$menu_qc', 'Export to CSV Details -> PO Number : ".$po_number.", DO Number : ".$do_number."')";
	  $query_insert_qc = mysql_query ($insert_qc);
?>

</table>

<?php
header("Content-disposition: attachment; filename=qualitycheckdetails.xls");
?>