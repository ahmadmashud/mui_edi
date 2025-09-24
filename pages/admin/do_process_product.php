<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
$jam=date("Y-m-d H:i:s");

if(isset($_POST['submit']))
{
  include('../../koneksi.php');
		
  $do_date			= $_POST['do_date'];
  $do_time			= $_POST['do_time'];
  $do_number		= $_POST['do_number'];		
  $po_number		= $_POST['po_number'];	
  $sds_number		= $_POST['sds_number'];
  $item_description	= $_POST['item_description'];
  $item_code		= $_POST['item_code'];
  $quantity_delivery= $_POST['quantity_delivery'];
  $quantity			= $_POST['quantity'];
  $item_type		= $_POST['item_type'];
  $item_unit		= $_POST['item_unit'];
  $department		= $_POST['department'];
  $item_status		= "DELIVERY";

  $do_number =$do_number;
  $select_sdo = mysqli_query($conn,"SELECT * FROM tb_supplier_delivery_order WHERE do_number='$_POST[do_number]' and supplier='$_SESSION[supplier]' and do_status='RECEIVED'");
  $sdo_count = mysqli_num_rows($select_sdo);
					
  if ($sdo_count > 0)
  {
	echo"<script>alert('DO Number already exist!')</script>";
	echo"<script>javascript:history.back()</script>";
  }
    else
  {
  $insert_sdo_master = "INSERT INTO tb_supplier_delivery_order (date_entry, date_edit, modify_username, supplier, do_date, do_time, do_number, department, po_number, sds_number, do_status) VALUES ('$jam', '$jam', '$_SESSION[full_name]', '$_SESSION[supplier]', '$do_date', '$do_time', '$do_number', '$department', '$po_number', '$sds_number', 'DELIVERY')";
  
  
  $select_sdo_details = "SELECT * FROM tb_supplier_delivery_schedule_details WHERE (po_number = '$po_number') AND (sds_number = '$sds_number')";
  $query_select_sdo_details = mysqli_query($conn,$select_sdo_details);
  $data_count = mysqli_num_rows($query_select_sdo_details);
    
  $total_check_false = 0;
  
    
	for($i=0;$i<$data_count;$i++)
    {	
	  if ($quantity[$i] > $quantity_delivery[$i])
	  {
	    $total_check_false = $total_check_false + 1;
      }	  
	}  
	  
	
	if ($total_check_false > 0)
	{
	  echo"<script>alert('Your quantity input is greater then the quantity delivery. Please check your data and try again.')</script>";
	  echo"<script>javascript:history.back()</script>";		
	} 
	else
	{
	  for($i=0;$i<$data_count;$i++)
      {
	    $insert_sdo_details = "INSERT INTO tb_supplier_delivery_order_details (po_number, sds_number, do_number, item_description, item_code, quantity, item_type, item_unit, department) VALUES('$po_number', '$sds_number', '$do_number', '$item_description[$i]', '$item_code[$i]', '$quantity[$i]', '$item_type', '$item_unit', '$department')";
        
        $query_insert_sdo_master = mysqli_query($conn,$insert_sdo_master);
	    $query_insert_sdo_details = mysqli_query($conn,$insert_sdo_details);		
		
		$update_sds = "UPDATE tb_supplier_delivery_schedule SET shipment_status='ON THE WAY' WHERE sds_number = '$sds_number' AND po_number = '$po_number'";		
	    $query_update_sds = mysqli_query($conn,$update_sds);
		
        $update_sdo_details = "UPDATE tb_supplier_delivery_order_details SET date_entry = '$jam', date_edit = '$jam', 
	                           do_date = '$do_date', modify_username = '$_SESSION[full_name]', 
		  				       supplier = '$_SESSION[supplier]', do_status = 'DELIVERY'
							   WHERE do_number = '$do_number' AND sds_number = '$sds_number' AND po_number = '$po_number'";		
	    $query_update_sdo_details = mysqli_query($conn,$update_sdo_details);
		
		$menu_do = 'Delivery Order';
		$insert_do = "INSERT INTO tb_activity_log (date_time, username, supplier, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[supplier]', '$_SESSION[account_status]', '$menu_do', 'Entry Data -> DO No: ".$do_number_id.", PO No: ".$po_number.", SDS No: ".$sds_number.", Part Name: ".$item_description[$i].", Part Code: ".$item_code[$i].", Qty: ".$quantity[$i]."')";
		$query_insert_do = mysqli_query($conn,$insert_do);
		
	  }
	  echo"<script>alert('Data has been submitted successfully.')</script>";
	  echo"<script>javascript:history.back()</script>";	 
	}	 
}
}
else
{	
  echo"<script>alert('Failed to submitted data, please check your data entry and then try again.')</script>";
  echo"<script>javascript:history.back()</script>";
}	
?>

