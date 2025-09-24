<?php
//header to give the order to the browser
header("Content-Type: application/vnd.ms-excel");
include "../../koneksi.php";
session_start();
date_default_timezone_set("Asia/Jakarta");
$jam=date('d/m/Y h:i:s');	
?>

  <?php
  $query="SELECT tb_purchase_order_details.po_date, tb_purchase_order_details.po_number, tb_purchase_order_details.item_description, 
  tb_purchase_order_details.item_code, tb_purchase_order_details.quantity AS po_qty,
  tb_supplier_delivery_order_details.sds_number,  
  tb_supplier_delivery_order_details.do_date, tb_supplier_delivery_order_details.do_number, 
  tb_supplier_delivery_order_details.quantity AS do_qty, tb_purchase_order_details.outstanding,
  (SELECT COUNT(po_number) FROM tb_purchase_order_details WHERE po_number=po_number) AS jumlah_po 
  FROM tb_purchase_order_details 
  LEFT JOIN tb_supplier_delivery_order_details
  ON tb_purchase_order_details.po_number=tb_supplier_delivery_order_details.po_number and
  tb_purchase_order_details.item_code=tb_supplier_delivery_order_details.item_code
  WHERE tb_supplier_delivery_order_details.do_status = 'RECEIVED' and tb_supplier_delivery_order_details.supplier='$_SESSION[supplier]'
  GROUP BY tb_purchase_order_details.po_number, tb_purchase_order_details.item_description ORDER BY tb_purchase_order_details.po_number, tb_purchase_order_details.item_description";
    $proses=mysql_query($query);
    $i=0; 
    while($data=mysql_fetch_assoc($proses)){
      $row[$i]=$data;
      $i++;
    }
    foreach($row as $cell){
      if(isset($total[$cell['po_number']]['jml'])) { 
        $total[$cell['po_number']]['jml']++; 
      }else{
        $total[$cell['po_number']]['jml']=1; 
      }	
    }
    ?>
	<table id="example1" class="table table-bordered table-striped">
    <tr> 
    <th>PO Number</th> 
    <th>Item Description</th> 
    <th>Item Code</th> 
	<th>Qty. PO</th>
	<th>Qty. DO</th>
	<th>OS</th>
	</tr>
	<?php
    $n=count($row);
    $cekinstansi="";
    for($i=0;$i<$n;$i++){
      $cell=$row[$i];
      echo '<tr>';
      if($cekinstansi!=$cell['po_number']){
        echo '<td' .($total[$cell['po_number']]['jml']>1?' rowspan="' .($total[$cell['po_number']]['jml']).'">':'>') .$cell['po_number'].'</td>';
        $cekinstansi=$cell['po_number'];
      }
    ?>
	<td><?php echo $cell['item_description']; ?></td>
	<td><?php echo $cell['item_code']; ?></td>
	<td><?php echo $cell['po_qty']; ?></td>
	<td><?php echo $cell['do_qty']; ?></td>
	<td><?php echo $cell['outstanding']; ?></td>
	<?php
    }
    ?>
	</tr>
	</table>
	
<?php
//$menu_qc = 'Quality Check';
//$insert_qc = "INSERT INTO tb_activity_log (date_time, username, supplier, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[supplier]', '$_SESSION[account_status]', '$menu_qc', 'Export to CSV -> PO Number : ".$po_number.", DO Number : ".$do_number."')";
//$query_insert_qc = mysql_query ($insert_qc);

//header("Content-disposition: attachment; filename=summary.xls");
?>