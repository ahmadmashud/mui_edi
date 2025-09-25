<?php
session_start();
include('../../koneksi.php');
include('../../koneksi_new_mrp.php');
include "../../phpqrcode/qrlib.php";
date_default_timezone_set("Asia/Jakarta");
$jam=date("Y-m-d H:i:s");
error_reporting(0); 




//$query = "SELECT max(sdod_code) as maxCode FROM tb_supplier_delivery_order_details";
//$hasil = mysqli_query($conn,$query);
//$data = mysql_fetch_array($hasil);
//$sdod_code = $data['maxCode'];
//$noUrut = (int) substr($sdod_code, 6, 6);
//$noUrut++;
//$char = "SDOD-";
//$sdod_code = $char . sprintf("%06s", $noUrut); 
//$sdod_code = "SDOD-";

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


  //$seq_sdod       = "SELECT sdod_code FROM tb_supplier_delivery_order_details where do_number='$_POST[do_number]'";
  //$result_seq     = mysqli_query($conn,$seq_sdod);
  //$seq        	  = mysql_fetch_array($result_seq);
  //$sdod_code_seq  = $seq['sdod_code'];
  //$sdod_code_seq  = (int) substr($sdod_code, -1);

  $select_sdo = mysqli_query($conn,"SELECT * FROM tb_supplier_delivery_order WHERE do_number='$_POST[do_number]' and supplier_name='$_SESSION[supplier]' and sdo_status='RECEIVED'");
  $sdo_count = mysqli_num_rows($select_sdo);

  if ($sdo_count > 0)
  {
	echo"<script>alert('DO Number already exist!')</script>";
	echo"<script>javascript:history.back()</script>";
  }
    else
  {
	  
  $select_sdo_ret = mysqli_query($conn,"SELECT * FROM tb_supplier_delivery_order WHERE do_number='$_POST[do_number]' and supplier_name='$_SESSION[supplier]' and sdo_status='RETURNED'");
  $sdo_count_ret = mysqli_num_rows($select_sdo_ret);
					
  if ($_POST['check']) {
	    
  //$insert_sdo_master = "INSERT INTO tb_supplier_delivery_order (date_entry, date_edit, modify_username, supplier_name, sdo_date, sdo_time, sdo_code, do_number, department, po_number, sds_number, sdo_status) VALUES ('$jam', '$jam', '$_SESSION[full_name]', '$_SESSION[supplier]', '$do_date', '$do_time', '$do_number_id', '$do_number', '$department', '$po_number', '$sds_number', 'DELIVERY')";
  $insert_sdo_master = "INSERT INTO tb_supplier_delivery_order (date_entry, date_edit, modify_username, sdo_code, do_number, sdo_date, sdo_time, department, sds_number, po_number, pr_number, supplier_code, supplier_name, supplier_initials, sdo_status, sdo_received_date, sdo_received_time, sdo_returned_date, sdo_returned_time) VALUES ('$jam', '$jam', '$_SESSION[full_name]', '$sdo_code', '$do_number', '$sdo_date', '$sdo_time', '$department', '$sds_number', '$po_number', '$pr_number', '$supplier_code', '$_SESSION[supplier]', '$supplier_initials', 'DELIVERY', '-', '-', '-', '-')";
   
  $select_sdo_details = "SELECT * FROM tb_supplier_delivery_schedule_details WHERE (po_number = '$po_number') AND (sds_number = '$sds_number')";
  $query_select_sdo_details = mysqli_query($conn,$select_sdo_details);
  $data_count = mysqli_num_rows($query_select_sdo_details);
    
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
	  echo"<script>alert('Your quantity input is greater then the quantity delivery. Please check your data and try again.')</script>";
	  echo"<script>javascript:history.back()</script>";		
	} 
	else
	{
	  for($i=0;$i<$data_count;$i++)
      {
		
		$select_sdo_details_double = mysqli_query($conn,"SELECT * FROM tb_supplier_delivery_order_details WHERE sdo_code='$sdo_code' and do_number='$do_number' and item_code='$item_code[$i]'");
		$sdo_count_double = mysqli_num_rows($select_sdo_details_double);
		
		if ($sdo_count_double > 0)
		  {
		    echo"<script>alert('Item code with this DO Number already exist!')</script>";
			echo"<script>javascript:history.back()</script>";
		  }
			else
		  {
		
			//$insert_sdo_details = "INSERT INTO tb_supplier_delivery_order_details (po_number, sds_number, sdo_code, do_number, item_name, item_code, quantity_sds, item_type_name, inventory_unit, department) VALUES('$po_number', '$sds_number', '$sdo_code', '$do_number', '$item_name[$i]', '$item_code[$i]', '$quantity_delivery[$i]', '$item_type_name', '$inventory_unit', '$department')";

			$insert_sdo_details = "INSERT INTO tb_supplier_delivery_order_details (date_entry, date_edit, modify_username, sdod_code, sdod_code_seq, sdo_code, do_number, sdo_date, sdo_time, sds_number, sdsd_number, po_number, pod_number, pr_number, prd_number, department, supplier_code, supplier_name, supplier_initials, purchase_item_type, item_code, item_group_code, item_name, spesification_code, spesification_description, item_type_category, item_type_sub_category, item_type_name, item_type_classification_status, item_type_trading_status, item_type_primary_status, item_type_checking_status, item_type_checking_result_status, item_type_bom_status, sales_category_name, inventory_unit, procurement_type, procurement_unit, conversion_value, quantity_delivery, sdo_status) VALUES('$jam', '$jam', '$_SESSION[full_name]', '$sdod_code[$i]', '$sdod_code_seq', '$sdo_code', '$do_number', '$sdo_date', '$sdo_time', '$sds_number', '$sdsd_number', '$po_number', '$pod_number', '$pr_number', '$prd_number', '$department', '$supplier_code', '$_SESSION[supplier]','$supplier_initials', '$purchase_item_type', '$item_code[$i]', '$item_group_code', '$item_name[$i]', '$spesification_code', '$spesification_description', '$item_type_category', '$item_type_sub_category', '$item_type_name', '$item_type_classification_status', '$item_type_trading_status', '$item_type_primary_status', '$item_type_checking_status', '$item_type_checking_result_status', '$item_type_bom_status', '$sales_category_name', '$inventory_unit', '$procurement_type', '$procurement_unit', '$conversion_value', '$quantity_delivery[$i]', '$sdo_status')";
			
			$query_insert_sdo_master = mysqli_query($conn,$insert_sdo_master);
			$query_insert_sdo_details = mysqli_query($conn,$insert_sdo_details);		
			
			$update_sds = "UPDATE tb_supplier_delivery_schedule SET shipment_status='ON THE WAY' WHERE sds_number = '$sds_number' AND po_number = '$po_number'";		
			$query_update_sds = mysqli_query($conn,$update_sds);
			
			$update_sdo_details = "UPDATE tb_supplier_delivery_order_details SET date_entry = '$jam', date_edit = '$jam', 
								   sdo_date = '$sdo_date', modify_username = '$_SESSION[full_name]', 
								   supplier_name = '$_SESSION[supplier]', sdo_status = 'DELIVERY'
								   WHERE do_number = '$do_number' AND sds_number = '$sds_number' AND po_number = '$po_number' AND sdo_status = '$sdo_status'";		
			$query_update_sdo_details = mysqli_query($conn,$update_sdo_details);

			$menu_do = 'Delivery Order';
			$insert_do = "INSERT INTO tb_activity_log (date_time, username, supplier, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[supplier]', '$_SESSION[account_status]', '$menu_do', 'Entry Data -> DO No: ".$sdo_code.", PO No: ".$po_number.", SDS No: ".$sds_number.", Part Name: ".$item_name[$i].", Part Code: ".$item_code[$i].", Qty: ".$quantity_delivery[$i]."')";
			$query_insert_do = mysqli_query($conn,$insert_do);
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
	//$insert_sdo_master = "INSERT INTO tb_supplier_delivery_order (date_entry, date_edit, modify_username, supplier, do_date, do_time, do_number_id, do_number, department, po_number, sds_number, do_status) VALUES ('$jam', '$jam', '$_SESSION[full_name]', '$_SESSION[supplier]', '$do_date', '$do_time', '$do_number_id', '$do_number', '$department', '$po_number', '$sds_number', 'DELIVERY')";

	$insert_sdo_master = "INSERT INTO tb_supplier_delivery_order (date_entry, 
	date_edit, modify_username, sdo_code, do_number, sdo_date, sdo_time, department,
	 sds_number, po_number, pr_number, supplier_code, supplier_name, 
	 supplier_initials, sdo_status, sdo_received_date, sdo_received_time, sdo_returned_date, sdo_returned_time) VALUES ('$jam', '$jam', '$_SESSION[full_name]', '$sdo_code', '$do_number', '$sdo_date', '$sdo_time', '$department', '$sds_number', '$po_number', '$pr_number', '$supplier_code', '$_SESSION[supplier]', '$supplier_initials', 'DELIVERY', '-', '-', '-', '-')";
   
	$select_sdo_details = "SELECT * FROM tb_supplier_delivery_schedule_details WHERE (po_number = '$po_number') AND (sds_number = '$sds_number')";
	$query_select_sdo_details = mysqli_query($conn,$select_sdo_details);
	$data_count = mysqli_num_rows($query_select_sdo_details);
    
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
	  echo"<script>alert('Your quantity input is greater then the quantity delivery. Please check your data and try again.')</script>";
	  echo"<script>javascript:history.back()</script>";		
	} 
	else
	{

	  for($i=0;$i<$data_count;$i++)
      {
		  
		$select_sdo_details_double = mysqli_query($conn,"SELECT * FROM tb_supplier_delivery_order_details WHERE sdo_code='$sdo_code' and do_number='$do_number' and item_code='$item_code[$i]'");
		$sdo_count_double = mysqli_num_rows($select_sdo_details_double);
		
		if ($sdo_count_double > 0)
		  {
		    echo"<script>alert('Item code with this DO Number already exist!')</script>";
			echo"<script>javascript:history.back()</script>";
		  }
			else
		  {
			$conn->autocommit(FALSE);
			try{
				$conn->begin_transaction();
				//$insert_sdo_details = "INSERT INTO tb_supplier_delivery_order_details (po_number, sds_number, do_number_id, do_number, item_description, item_code, quantity, item_type, item_unit, department) VALUES('$po_number', '$sds_number', '$sdo_code', '$do_number', '$item_name[$i]', '$item_code[$i]', '$quantity_delivery[$i]', '$item_type_name', '$inventory_unit', '$department')";

				$insert_sdo_details = "INSERT INTO tb_supplier_delivery_order_details (date_entry, date_edit, modify_username, sdod_code, sdod_code_seq, sdo_code, do_number, sdo_date, sdo_time, sds_number, sdsd_number, po_number, pod_number, pr_number, prd_number, department, supplier_code, supplier_name, supplier_initials, purchase_item_type, item_code, item_group_code, item_name, spesification_code, spesification_description, item_type_category, item_type_sub_category, item_type_name, item_type_classification_status, item_type_trading_status, item_type_primary_status, item_type_checking_status, item_type_checking_result_status, item_type_bom_status, sales_category_name, inventory_unit, procurement_type, procurement_unit, conversion_value, quantity_delivery, sdo_status) VALUES('$jam', '$jam', '$_SESSION[full_name]', '$sdod_code[$i]', '$sdod_code_seq', '$sdo_code', '$do_number', '$sdo_date', '$sdo_time', '$sds_number', '$sdsd_number', '$po_number', '$pod_number', '$pr_number', '$prd_number', '$department', '$supplier_code', '$_SESSION[supplier]','$supplier_initials', '$purchase_item_type', '$item_code[$i]', '$item_group_code', '$item_name[$i]', '$spesification_code', '$spesification_description', '$item_type_category', '$item_type_sub_category', '$item_type_name', '$item_type_classification_status', '$item_type_trading_status', '$item_type_primary_status', '$item_type_checking_status', '$item_type_checking_result_status', '$item_type_bom_status', '$sales_category_name', '$inventory_unit', '$procurement_type', '$procurement_unit', '$conversion_value', '$quantity_delivery[$i]', '$sdo_status')";

				$query_insert_sdo_master = $conn->query($insert_sdo_master);
				$query_insert_sdo_details = $conn->query($insert_sdo_details);		
				
				$update_sds = "UPDATE tb_supplier_delivery_schedule SET shipment_status='ON THE WAY' WHERE sds_number = '$sds_number' AND po_number = '$po_number'";		
				$query_update_sds = $conn->query($update_sds);
				
				//$update_sdo_details = "UPDATE tb_supplier_delivery_order_details SET date_entry = '$jam', date_edit = '$jam', sdo_date = '$sdo_date', modify_username = '$_SESSION[full_name]', supplier_name = '$_SESSION[supplier]', sdo_status = 'DELIVERY' WHERE do_number = '$do_number' AND sds_number = '$sds_number' AND po_number = '$po_number' AND sdo_status = '$sdo_status'";		
				//$query_update_sdo_details = mysqli_query($conn,$update_sdo_details);
				
				
				// INSERT to trans_delivery_order (tb_supplier_delivery_order)
				$supplier_id = getSupplier($conn_mrp, $_SESSION["supplier"])['id'];
				$sds_detail_id = getSdsDetailId($conn_mrp, $sds_number)['detail_id'];
			
				$query_trans_do = "INSERT INTO trans_delivery_order
				(trans_date, description, doc_num, flag_status, flag_active, created_by, 
				created_at, updated_by, updated_at, 
				generated_id, prs_supplier_id)VALUES(
				'$jam','from edi', '$do_number', 1, 1, 'edi',now(),'edi',now(),'123',$supplier_id)";
				$conn->query($query_trans_do);

				$trans_do_id = $conn->insert_id;
				
				// INSERT to trans_delivery_order (tb_supplier_delivery_order_details)
				$query_trans_do_detail = "INSERT INTO trans_delivery_order_detail
				(description, qty, flag_status, created_by, created_at, updated_by, updated_at,
				generated_id, trans_do_id, sds_detail_id)VALUES(
				'delivery from edi',$quantity_delivery[0], 1, 'edi', now(), 'edi', now(), '123', '$trans_do_id',
				$sds_detail_id)";
				mysqli_query($conn,$query_trans_do_detail);

				// UPDATE SDS STATUS
				$query_sds_status = "UPDATE trans_supplier_delivery_schedule SET flag_shipment = 2, flag_status = 2	WHERE doc_num = '$sds_number'";
				mysqli_query($conn,$query_sds_status);
				
				$query_sds_status = "UPDATE trans_supplier_delivery_schedule SET flag_shipment = 2, flag_status = 2	WHERE doc_num = '$sds_number'";
				mysqli_query($conn_mrp,$query_sds_status);
				// update sds set flag_shipment = 2 (completly recived),
				// flag_status: 2 (close): if qty full sent from edi
				$conn->commit();
			}catch (mysqli_sql_exception $e) {
				$conn->rollback();
				
    			echo "Transaction rolled back due to an error: " . $e->getMessage();
				die;
			}

			// $supplier_id = 1;
			// $po_detail_id = 1;// sds d
			// $stmt = $conn_mrp->prepare("CALL sp_trans_rr_import_do(?,?,?,?,?,?,?)");	
			// $stmt->bind_param("ssi", $jam, $email, $usia);
			// $stmt->execute();

			// $sds = "select * from vw_app_list_trans_sds_hd";			
			// $query_insert_sdo_master = mysqli_query($conn_mrp,$sds);
			// $test =mysqli_fetch_array($query_insert_sdo_master);


			$menu_do = 'Delivery Order';
			$insert_do = "INSERT INTO tb_activity_log (date_time, username, supplier, account_status, menu, activity_description) VALUES ('$jam', '$_SESSION[username]', '$_SESSION[supplier]', '$_SESSION[account_status]', '$menu_do', 'Entry Data -> DO No. : ".$sdo_code.", PO No. : ".$po_number.", SDS No. : ".$sds_number.", Part Name : ".$item_name[$i].", Part Code : ".$item_code[$i].", Qty. : ".$quantity_delivery[$i]."')";
			$query_insert_do = mysqli_query($conn,$insert_do);
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

function getSupplier($conn_mrp, $supplier_name){
	$query_supplier = "select * from yrhmyid_mui_mrp.mst_person_supplier where description = '$supplier_name'";
	$stmt = $conn_mrp->prepare($query_supplier);
	// if ($stmt === false) {
    // var_dump("Error preparing statement: " . $conn->error);
	// }
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	return $row;
}

function getSdsDetailId($conn_mrp, $sds_number){
	$query = "select
				tsds.id, tsdsd.id as detail_id
			from
				trans_supplier_delivery_schedule tsds
			inner join trans_supplier_delivery_schedule_detail tsdsd on
				tsdsd.trans_sds_id = tsds.id
			where
				tsds.doc_num = '$sds_number'";
	$stmt = $conn_mrp->prepare($query);
	// if ($stmt === false) {
    // var_dump("Error preparing statement: " . $conn->error);
	// }
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	return $row;
}
?>

