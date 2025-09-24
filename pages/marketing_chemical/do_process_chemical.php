<?php
session_start();
include('../../koneksi.php');
date_default_timezone_set("Asia/Jakarta");
$jam=date("Y-m-d H:i:s");
error_reporting(0); 

if(isset($_POST['submit']))
{
		
  $sdo_date								= $_POST['sdo_date'];
  $sdo_time								= $_POST['sdo_time'];
  $do_number							= $_POST['do_number'];
  if (isset($_POST['check'])) {
  $sdo_code								= $_POST['do_number'].'-'.$_POST['check'];
  }
  else {
  $sdo_code								= $_POST['do_number'];	  
  }  
  $po_number							= $_POST['po_number'];	
  $sds_number							= $_POST['sds_number'];
  $sdsd_number							= $_POST['sdsd_number'];
  $item_name							= $_POST['item_name'];
  $item_code							= $_POST['item_code'];
  $quantity_delivery_sds				= $_POST['quantity_delivery_sds'];
  $quantity_delivery					= $_POST['quantity_delivery'];
  $item_type_name						= $_POST['item_type_name'];
  $pr_number							= $_POST['pr_number'];
  $prd_number							= $_POST['prd_number'];
  $purchase_item_type					= $_POST['purchase_item_type'];
  $item_group_code						= $_POST['item_group_code'];
  $supplier_code						= $_POST['supplier_code'];
  $pod_number							= $_POST['pod_number'];
  $supplier_initials					= $_POST['supplier_initials'];
  $spesification_code					= $_POST['spesification_code'];
  $spesification_description			= $_POST['spesification_description'];
  $item_type_category					= $_POST['item_type_category'];
  $item_type_sub_category				= $_POST['item_type_sub_category'];
  $item_type_classification_status		= $_POST['item_type_classification_status'];
  $item_type_trading_status				= $_POST['item_type_trading_status'];
  $item_type_primary_status				= $_POST['item_type_primary_status'];
  $item_type_checking_status			= $_POST['item_type_checking_status'];
  $item_type_checking_result_status		= $_POST['item_type_checking_result_status'];
  $item_type_bom_status					= $_POST['item_type_bom_status'];
  $sales_category_name					= $_POST['sales_category_name'];
  $inventory_unit						= $_POST['inventory_unit'];
  $procurement_type						= $_POST['procurement_type'];
  $procurement_unit						= $_POST['procurement_unit'];
  $conversion_value						= $_POST['conversion_value'];
  $department							= $_POST['department'];
  $sdo_status							= "DELIVERY";
  
  $select_sdo = mysql_query("SELECT * FROM tb_supplier_delivery_order WHERE do_number='$_POST[do_number]' and supplier_name='$_SESSION[supplier]' and do_status='RECEIVED'");
  $sdo_count = mysql_num_rows($select_sdo);
					
  if ($sdo_count > 0)
  {
	echo"<script>alert('DO Number already exist!')</script>";
	echo"<script>javascript:history.back()</script>";
  }
    else
  {
	  
  	$select_sdo_ret = mysql_query("SELECT * FROM tb_supplier_delivery_order WHERE do_number='$_POST[do_number]' and supplier_name='$_SESSION[supplier]' and do_status='RETURNED'");
 	$sdo_count_ret = mysql_num_rows($select_sdo_ret);
					
  	if ($_POST['check']) 
	{
	    
  		$insert_sdo_master = "INSERT INTO tb_supplier_delivery_order (date_entry, date_edit, modify_username, sdo_code, do_number, sdo_date, sdo_time, department, sds_number, po_number, pr_number, supplier_code, supplier_name, supplier_initials, sdo_status, sdo_received_date, sdo_received_time, sdo_returned_date, sdo_returned_time) VALUES ('$jam', '$jam', '$_SESSION[full_name]', '$sdo_code', '$do_number', '$sdo_date', '$sdo_time', '$department', '$sds_number', '$po_number', '$pr_number', '$supplier_code', '$_SESSION[supplier]', '$supplier_initials', 'DELIVERY', '-', '-', '-', '-')";
   
  		$select_sdo_details = "SELECT * FROM tb_supplier_delivery_schedule_details WHERE (po_number = '$po_number') AND (sds_number = '$sds_number')";
  		$query_select_sdo_details = mysql_query ($select_sdo_details);
  		$data_count = mysql_num_rows($query_select_sdo_details);
    
  		$total_check_false = 0;
  
    
		for($i=0;$i<$data_count;$i++)
		{	
		if ($quantity_delivery[$i] > $quantity_delivery_sds[$i])
		{
			$total_check_false = $total_check_false + 1;
		}	  
		}  
	  
	
	if ($total_check_false > 0)
	{
	  echo"<script>alert('Your quantity_delivery input is greater then the quantity_delivery delivery. Please check your data and try again.')</script>";
	  echo"<script>javascript:history.back()</script>";		
	} 
	else
	{
	  for($i=0;$i<$data_count;$i++)
      {
		  
		$select_sdo_details_double = mysql_query("SELECT * FROM tb_supplier_delivery_order_details WHERE sdo_code='$sdo_code' and do_number='$do_number' and item_code='$item_code[$i]'");
		$sdo_count_double = mysql_num_rows($select_sdo_details_double);
		
		if ($sdo_count_double > 0)
		  {
		    echo"<script>alert('Item code with this DO Number already exist!')</script>";
			echo"<script>javascript:history.back()</script>";
		  }
			else
		  {
			$insert_sdo_details = "INSERT INTO tb_supplier_delivery_order_details (date_entry, date_edit, modify_username, sdod_code, sdod_code_seq, sdo_code, do_number, sdo_date, sdo_time, sds_number, sdsd_number, po_number, pod_number, pr_number, prd_number, department, supplier_code, supplier_name, supplier_initials, purchase_item_type, item_code, item_group_code, item_name, spesification_code, spesification_description, item_type_category, item_type_sub_category, item_type_name, item_type_classification_status, item_type_trading_status, item_type_primary_status, item_type_checking_status, item_type_checking_result_status, item_type_bom_status, sales_category_name, inventory_unit, procurement_type, procurement_unit, conversion_value, quantity_delivery, sdo_status) VALUES('$jam', '$jam', '$_SESSION[full_name]', '$sdod_code[$i]', '$sdod_code_seq', '$sdo_code', '$do_number', '$sdo_date', '$sdo_time', '$sds_number', '$sdsd_number', '$po_number', '$pod_number', '$pr_number', '$prd_number', '$department', '$supplier_code', '$_SESSION[supplier]','$supplier_initials', '$purchase_item_type', '$item_code[$i]', '$item_group_code', '$item_name[$i]', '$spesification_code', '$spesification_description', '$item_type_category', '$item_type_sub_category', '$item_type_name', '$item_type_classification_status', '$item_type_trading_status', '$item_type_primary_status', '$item_type_checking_status', '$item_type_checking_result_status', '$item_type_bom_status', '$sales_category_name', '$inventory_unit', '$procurement_type', '$procurement_unit', '$conversion_value', '$quantity_delivery[$i]', '$sdo_status')";
			
			$query_insert_sdo_master = mysql_query ($insert_sdo_master);
			$query_insert_sdo_details = mysql_query ($insert_sdo_details);		
			
			$update_sds = "UPDATE tb_supplier_delivery_schedule SET shipment_status='ON THE WAY' WHERE sds_number = '$sds_number' AND po_number = '$po_number'";		
			$query_update_sds = mysql_query($update_sds);
			
			$update_sdo_details = "UPDATE tb_supplier_delivery_order_details SET date_entry = '$jam', date_edit = '$jam', 
								   sdo_date = '$sdo_date', modify_username = '$_SESSION[full_name]', 
								   supplier = '$_SESSION[supplier]', do_status = 'DELIVERY'
								   WHERE do_number = '$do_number' AND sds_number = '$sds_number' AND po_number = '$po_number' AND do_status = '$do_status'";		
			$query_update_sdo_details = mysql_query($update_sdo_details);
			
			$menu_do = 'Delivery Order';
			$insert_do = "INSERT INTO tb_activity_log (date_time, username, supplier, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[supplier]', '$_SESSION[account_status]', '$menu_do', 'Entry Data -> DO No: ".$sdo_code.", PO No: ".$po_number.", SDS No: ".$sds_number.", Part Name: ".$item_name[$i].", Part Code: ".$item_code[$i].", Qty: ".$quantity_delivery[$i]."')";
			$query_insert_do = mysql_query ($insert_do);
		  }
	  }
	  echo"<script>alert('Data has been submitted successfully.')</script>";
	  echo"<script>javascript:history.back()</script>";	 
	}	 
  }
  else if($sdo_count_ret > 0) {
	echo"<script>alert('DO Number already exist! If that DO Number reuse for return, please check return checkbox.')</script>";
	echo"<script>javascript:history.back()</script>";
  }
  else 
  {
	$insert_sdo_master = "INSERT INTO tb_supplier_delivery_order (date_entry, date_edit, modify_username, sdo_code, do_number, sdo_date, sdo_time, department, sds_number, po_number, pr_number, supplier_code, supplier_name, supplier_initials, sdo_status, sdo_received_date, sdo_received_time, sdo_returned_date, sdo_returned_time) VALUES ('$jam', '$jam', '$_SESSION[full_name]', '$sdo_code', '$do_number', '$sdo_date', '$sdo_time', '$department', '$sds_number', '$po_number', '$pr_number', '$supplier_code', '$_SESSION[supplier]', '$supplier_initials', 'DELIVERY', '-', '-', '-', '-')";
   
  $select_sdo_details = "SELECT * FROM tb_supplier_delivery_schedule_details WHERE (po_number = '$po_number') AND (sds_number = '$sds_number')";
  $query_select_sdo_details = mysql_query ($select_sdo_details);
  $data_count = mysql_num_rows($query_select_sdo_details);
    
  $total_check_false = 0;
  
    
	for($i=0;$i<$data_count;$i++)
    {	
	  if ($quantity_delivery[$i] > $quantity_delivery_sds[$i])
	  {
	    $total_check_false = $total_check_false + 1;
      }	  
	}  
	  
	
	if ($total_check_false > 0)
	{
	  echo"<script>alert('Your quantity_delivery input is greater then the quantity_delivery delivery. Please check your data and try again.')</script>";
	  echo"<script>javascript:history.back()</script>";		
	} 
	else
	{
	  for($i=0;$i<$data_count;$i++)
      {
		  
		$select_sdo_details_double = mysql_query("SELECT * FROM tb_supplier_delivery_order_details WHERE sdo_code='$sdo_code' and do_number='$do_number' and item_code='$item_code[$i]'");
		$sdo_count_double = mysql_num_rows($select_sdo_details_double);
		
		if ($sdo_count_double > 0)
		  {
		    echo"<script>alert('Item code with this DO Number already exist!')</script>";
			echo"<script>javascript:history.back()</script>";
		  }
			else
		  {
			$insert_sdo_details = "INSERT INTO tb_supplier_delivery_order_details (date_entry, date_edit, modify_username, sdod_code, sdod_code_seq, sdo_code, do_number, sdo_date, sdo_time, sds_number, sdsd_number, po_number, pod_number, pr_number, prd_number, department, supplier_code, supplier_name, supplier_initials, purchase_item_type, item_code, item_group_code, item_name, spesification_code, spesification_description, item_type_category, item_type_sub_category, item_type_name, item_type_classification_status, item_type_trading_status, item_type_primary_status, item_type_checking_status, item_type_checking_result_status, item_type_bom_status, sales_category_name, inventory_unit, procurement_type, procurement_unit, conversion_value, quantity_delivery, sdo_status) VALUES('$jam', '$jam', '$_SESSION[full_name]', '$sdod_code[$i]', '$sdod_code_seq', '$sdo_code', '$do_number', '$sdo_date', '$sdo_time', '$sds_number', '$sdsd_number', '$po_number', '$pod_number', '$pr_number', '$prd_number', '$department', '$supplier_code', '$_SESSION[supplier]','$supplier_initials', '$purchase_item_type', '$item_code[$i]', '$item_group_code', '$item_name[$i]', '$spesification_code', '$spesification_description', '$item_type_category', '$item_type_sub_category', '$item_type_name', '$item_type_classification_status', '$item_type_trading_status', '$item_type_primary_status', '$item_type_checking_status', '$item_type_checking_result_status', '$item_type_bom_status', '$sales_category_name', '$inventory_unit', '$procurement_type', '$procurement_unit', '$conversion_value', '$quantity_delivery[$i]', '$sdo_status')";
			
			$query_insert_sdo_master = mysql_query ($insert_sdo_master);
			$query_insert_sdo_details = mysql_query ($insert_sdo_details);		
			
			$update_sds = "UPDATE tb_supplier_delivery_schedule SET shipment_status='ON THE WAY' WHERE sds_number = '$sds_number' AND po_number = '$po_number'";		
			$query_update_sds = mysql_query($update_sds);
			
			$update_sdo_details = "UPDATE tb_supplier_delivery_order_details SET date_entry = '$jam', date_edit = '$jam', 
								   sdo_date = '$sdo_date', modify_username = '$_SESSION[full_name]', 
								   supplier = '$_SESSION[supplier]', do_status = 'DELIVERY'
								   WHERE do_number = '$do_number' AND sds_number = '$sds_number' AND po_number = '$po_number' AND do_status = '$do_status'";		
			$query_update_sdo_details = mysql_query($update_sdo_details);
			
			$menu_do = 'Delivery Order';
			$insert_do = "INSERT INTO tb_activity_log (date_time, username, supplier, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[supplier]', '$_SESSION[account_status]', '$menu_do', 'Entry Data -> DO No: ".$sdo_code.", PO No: ".$po_number.", SDS No: ".$sds_number.", Part Name: ".$item_name[$i].", Part Code: ".$item_code[$i].", Qty: ".$quantity_delivery[$i]."')";
			$query_insert_do = mysql_query ($insert_do);
		  }
	  }
	  echo"<script>alert('Data has been submitted successfully.')</script>";
	  echo"<script>javascript:history.back()</script>";	 
	}
  } 
  }
}
else
{	
  echo"<script>alert('Failed to submitted data, please check your data entry and then try again.')</script>";
  echo"<script>javascript:history.back()</script>";
}	
?>

