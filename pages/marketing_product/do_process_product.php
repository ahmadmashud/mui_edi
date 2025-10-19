<?php
session_start();
include('../../koneksi.php');
include('../../koneksi_new_mrp.php');
include "../../phpqrcode/qrlib.php";
date_default_timezone_set("Asia/Jakarta");
error_reporting(0);


// Main execution
try {
    $processor = new DeliveryOrderProcessor($conn, $conn_mrp);
    $processor->processDeliveryOrder();
} catch (Exception $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "')</script>";
    header("Location: do_product.php");
    exit();
}

class DeliveryOrderProcessor
{
    private $conn;
    private $conn_mrp;
    private $currentTime;
    
    public function __construct($conn, $conn_mrp)
    {
        $this->conn = $conn;
        $this->conn_mrp = $conn_mrp;
        $this->currentTime = date("Y-m-d H:i:s");
    }
    
    public function processDeliveryOrder()
    {
        if (!$this->validateSubmission()) {
            $this->redirectWithAlert('Failed to submit data, please check your data entry and try again.');
            return;
        }
        
        $formData = $this->getFormData();
        
        if (!$this->validateDoNumber($formData)) {
            return;
        }
        
        if ($formData['is_return']) {
            $this->processReturnDelivery($formData);
        } else {
            $this->processNewDelivery($formData);
        }
    }
    
    private function validateSubmission()
    {
        return isset($_POST['submit']);
    }
    
    private function getFormData()
    {
        return [
            'sdo_date' => $_POST['sdo_date'],
            'sdo_time' => $_POST['sdo_time'],
            'do_number' => $_POST['do_number'],
            'is_return' => isset($_POST['check']),
            'sdo_code' => isset($_POST['check']) ? $_POST['do_number'] . '-' . $_POST['check'] : $_POST['do_number'],
            'po_number' => $_POST['po_number'],
            'sds_number' => $_POST['sds_number'],
            'item_data' => $this->prepareItemData(),
            'department' => $_POST['department'],
            'supplier_code' => $_POST['supplier_code'],
            'supplier_initials' => $_POST['supplier_initials'],
            'pr_number' => $_POST['pr_number']
        ];
    }
    
    private function prepareItemData()
    {
        $itemData = [];
        $fields = [
            'item_name', 'item_code', 'quantity_delivery_sds', 'quantity_delivery',
            'item_type_name', 'prd_number', 'purchase_item_type', 'item_group_code',
            'pod_number', 'spesification_code', 'spesification_description',
            'item_type_category', 'item_type_sub_category', 'item_type_classification_status',
            'item_type_trading_status', 'item_type_primary_status', 'item_type_checking_status',
            'item_type_checking_result_status', 'item_type_bom_status', 'sales_category_name',
            'inventory_unit', 'procurement_type', 'procurement_unit', 'conversion_value',
            'sdsd_number', 'sds_detail_relation_id'
        ];
        
        foreach ($fields as $field) {
            $itemData[$field] = $_POST[$field] ?? [];
        }
        
        return $itemData;
    }
    
    private function validateDoNumber($formData)
    {
        $doNumber = $formData['do_number'];
        $supplier = $_SESSION['supplier'];
        
        // Check for existing RECEIVED DO
        $selectSdo = mysqli_query($this->conn, 
            "SELECT * FROM tb_supplier_delivery_order 
             WHERE do_number='$doNumber' 
             AND supplier_name='$supplier' 
             AND sdo_status='RECEIVED'");
        
        if (mysqli_num_rows($selectSdo) > 0) {
            $this->redirectWithAlert('DO Number already exist!');
            return false;
        }
        
        // Check for existing RETURNED DO if not a return
        if (!$formData['is_return']) {
            $selectSdoRet = mysqli_query($this->conn,
                "SELECT * FROM tb_supplier_delivery_order 
                 WHERE do_number='$doNumber' 
                 AND supplier_name='$supplier' 
                 AND sdo_status='RETURNED'");
            
            if (mysqli_num_rows($selectSdoRet) > 0) {
                $this->redirectWithAlert('DO Number already exist! If that DO Number reuse for return, please check return checkbox.');
                return false;
            }
        }
        
        return true;
    }
    
    private function processReturnDelivery($formData)
    {
        if (!$this->validateDeliveryQuantities($formData)) {
            return;
        }
        
        $this->insertDeliveryOrder($formData, true);
    }
    
    private function processNewDelivery($formData)
    {
        if (!$this->validateDeliveryQuantities($formData)) {
            return;
        }
        
        $this->insertDeliveryOrder($formData, false);
    }
    
    private function validateDeliveryQuantities($formData)
    {
        $itemData = $formData['item_data'];
        
        foreach ($itemData['quantity_delivery'] as $index => $quantity) {
            if ($quantity > $itemData['quantity_delivery_sds'][$index]) {
                $this->redirectWithAlert('Your quantity input is greater than the quantity delivery. Please check your data and try again.');
                return false;
            }
        }
        
        return true;
    }

    private function hasPartialDelivery(array $formData): bool
    {
        $itemData = $formData['item_data'];
        
        foreach ($itemData['quantity_delivery'] as $index => $quantity) {
            if ($quantity < $itemData['quantity_delivery_sds'][$index]) {
                return true;
            }
        }
        
        return false;
    }

    private function updateOutstandingQtySds(array $formData)
    {
        $itemData = $formData['item_data'];
        
        foreach ($itemData['quantity_delivery'] as $index => $quantity) {
            if ($quantity < $itemData['quantity_delivery_sds'][$index]) {
                $os_sdo =  $itemData['quantity_delivery_sds'][$index] - $quantity;
                $query = "UPDATE tb_supplier_delivery_schedule_details 
                            SET outstanding_sdo = ?
                            where po_number = ? and sds_number= ? and supplier_name= ? and item_code = ?";
                 
                $stmt = $this->conn->prepare($query);
                $types = str_repeat('s', 5);
                $params = $this->prepareUpdateParameterOutstandingSds($os_sdo,$formData,$itemData['item_code'][$index],$index);
             
                $stmt->bind_param($types, ...$params);

                $stmt->execute();
                $stmt->close();
            }
        }
        
    }

    
    private function prepareUpdateParameterOutstandingSds($os_sdo, $formData, $itemCode, $index)
        {
        return [ 
                $os_sdo,
                $formData['po_number'],
                $formData['sds_number'], 
                $_SESSION['supplier'],
                $itemCode
            ];
    }

    private function insertDeliveryOrder($formData, $isReturn)
    {
        $this->conn->autocommit(FALSE);
        
        try {
            $this->conn->begin_transaction();
            
            // Insert master delivery order
            $this->insertMasterDeliveryOrder($formData);
            
            // Insert delivery order details
            $transDoId = $this->insertDeliveryOrderDetails($formData);
            
            if($this->hasPartialDelivery($formData)){
                $this->updateOutstandingQtySds($formData);
            }else{
                $this->updateShipmentStatus($formData);
            }
            
            // Log activity
            $this->logActivity($formData);
            $this->conn->commit();
            $this->redirectWithAlert('Data has been submitted successfully.');
            
        } catch (mysqli_sql_exception $e) {
            $this->conn->rollback();
            $this->redirectWithAlert('Transaction rolled back due to an error: ' . $e->getMessage());
        }
    }
    
    private function insertMasterDeliveryOrder($formData)
    {
        $query = "INSERT INTO tb_supplier_delivery_order 
                 (date_entry, date_edit, modify_username, sdo_code, do_number, 
                  sdo_date, sdo_time, department, sds_number, po_number, pr_number, 
                  supplier_code, supplier_name, supplier_initials, sdo_status, 
                  sdo_received_date, sdo_received_time, sdo_returned_date, sdo_returned_time) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'DELIVERY', '-', '-', '-', '-')";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "ssssssssssssss", 
            $this->currentTime, $this->currentTime, $_SESSION['full_name'],
            $formData['sdo_code'], $formData['do_number'], $formData['sdo_date'],
            $formData['sdo_time'], $formData['department'], $formData['sds_number'],
            $formData['po_number'], $formData['pr_number'], $formData['supplier_code'],
            $_SESSION['supplier'], $formData['supplier_initials']
        );
        
        $stmt->execute();
        $stmt->close();
    }
    
    private function insertDeliveryOrderDetails($formData)
    {
        $itemData = $formData['item_data'];
        $transDoId = null;
        $supplierId = $this->getSupplierId($_SESSION['supplier']);
        
        // Insert master delivery order for MRP system
        if ($supplierId) {
            $transDoId = $this->insertTransDeliveryOrder($formData, $supplierId);
        }
        
        foreach ($itemData['item_code'] as $index => $itemCode) {
            // Check for duplicate items
            if ($this->isDuplicateItem($formData['sdo_code'], $formData['do_number'], $itemCode)) {
                throw new Exception("Item code with this DO Number already exist!");
            }
            
            // Insert detail record
            $this->insertDeliveryOrderDetail($formData, $itemData, $index);
            
            // Insert MRP system detail record
            if ($transDoId) {
                $this->insertTransDeliveryOrderDetail(
                    $formData, $itemData, $index, $transDoId
                );
            }
        }
        
        return $transDoId;
    }
    
    private function insertDeliveryOrderDetail($formData, $itemData, $index)
    {
       try {
        $params = $this->prepareInsertParameterDeliveryOrder($formData, $itemData, $index);
            $query = "INSERT INTO tb_supplier_delivery_order_details 
                    (date_entry, date_edit, modify_username, sdo_code, do_number, 
                    sdo_date, sdo_time, sds_number, sdsd_number, po_number, pod_number, 
                    pr_number, prd_number, department, supplier_code, supplier_name, 
                    supplier_initials, purchase_item_type, item_code, item_group_code, 
                    item_name, spesification_code, spesification_description, 
                    item_type_category, item_type_sub_category, item_type_name, 
                    item_type_classification_status, item_type_trading_status, 
                    item_type_primary_status, item_type_checking_status, 
                    item_type_checking_result_status, item_type_bom_status, 
                    sales_category_name, inventory_unit, procurement_type, 
                    procurement_unit, conversion_value, quantity_delivery, sdo_status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->conn->prepare($query);

          
            // Bind parameters
            $types = str_repeat('s', 39);
            $stmt->bind_param($types, ...$params);
            
            $stmt->execute();
            $stmt->close();
            
        } catch(Exception $e) {
            error_log("Insert Error: " . $e->getMessage());
            error_log("Query: " . $query);
            error_log("Session full_name: " . ($_SESSION['full_name'] ?? 'NOT SET'));
            
            throw new Exception("Failed to insert delivery order details: " . $e->getMessage());
        }
        
    }


    private function prepareInsertParameterDeliveryOrder($formData, $itemData, $index)
        {
    return [
        $this->currentTime,
        $this->currentTime,
        $_SESSION['full_name'] ?? '',
        $formData['sdo_code'] ?? '',
        $formData['do_number'] ?? '',
        $formData['sdo_date'] ?? '',
        $formData['sdo_time'] ?? '',
        $formData['sds_number'] ?? '',
        $itemData['sdsd_number'][$index] ?? '',
        $formData['po_number'] ?? '',
        $itemData['pod_number'][$index] ?? '',
        $formData['pr_number'] ?? '',
        $itemData['prd_number'][$index] ?? '',
        $formData['department'] ?? '',
        $formData['supplier_code'] ?? '',
        $_SESSION['supplier'] ?? '',
        $formData['supplier_initials'] ?? '',
        $itemData['purchase_item_type'][$index] ?? '',
        $itemData['item_code'][$index] ?? '',
        $itemData['item_group_code'][$index] ?? '',
        $itemData['item_name'][$index] ?? '',
        $itemData['spesification_code'][$index] ?? '',
        $itemData['spesification_description'][$index] ?? '',
        $itemData['item_type_category'][$index] ?? '',
        $itemData['item_type_sub_category'][$index] ?? '',
        $itemData['item_type_name'][$index] ?? '',
        $itemData['item_type_classification_status'][$index] ?? '',
        $itemData['item_type_trading_status'][$index] ?? '',
        $itemData['item_type_primary_status'][$index] ?? '',
        $itemData['item_type_checking_status'][$index] ?? '',
        $itemData['item_type_checking_result_status'][$index] ?? '',
        $itemData['item_type_bom_status'][$index] ?? '',
        $itemData['sales_category_name'][$index] ?? '',
        $itemData['inventory_unit'][$index] ?? '',
        $itemData['procurement_type'][$index] ?? '',
        $itemData['procurement_unit'][$index] ?? '',
        $itemData['conversion_value'][$index] ?? '',
        $itemData['quantity_delivery'][$index] ?? 0,
        'DELIVERY'
    ];
}
    
    private function insertTransDeliveryOrder($formData, $supplierId)
    {
        $query = "INSERT INTO trans_delivery_order
                 (trans_date, description, doc_num, flag_status, flag_active, 
                  created_by, created_at, updated_by, updated_at, generated_id, prs_supplier_id)
                 VALUES (?, 'from edi', ?, 1, 1, 'edi', NOW(), 'edi', NOW(), '123', ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssi", $this->currentTime, $formData['do_number'], $supplierId);
        $stmt->execute();
        $transDoId = $this->conn->insert_id;
        $stmt->close();
        
        return $transDoId;
    }
    
    private function insertTransDeliveryOrderDetail($formData, $itemData, $index, $transDoId)
    {
        $query = "INSERT INTO trans_delivery_order_detail
                 (description, qty, flag_status, created_by, created_at, 
                  updated_by, updated_at, generated_id, trans_do_id, sds_detail_id)
                 VALUES ('delivery from edi', ?, 1, 'edi', NOW(), 'edi', NOW(), 
                         '123', ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", 
            $itemData['quantity_delivery'][$index], 
            $transDoId, 
            $itemData['sds_detail_relation_id'][$index]
        );
        $stmt->execute();
        $stmt->close();
    }
    
    private function updateShipmentStatus($formData)
    {
        // Update main system
        $query = "UPDATE tb_supplier_delivery_schedule 
                 SET shipment_status='ON THE WAY' 
                 WHERE sds_number = ? AND po_number = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $formData['sds_number'], $formData['po_number']);
        $stmt->execute();
        $stmt->close();
        
        // Update MRP system
        $queryMrp = "UPDATE trans_supplier_delivery_schedule 
                    SET flag_shipment = 2, flag_status = 2 
                    WHERE doc_num = ?";
        
        $stmtMrp = $this->conn_mrp->prepare($queryMrp);
        $stmtMrp->bind_param("s", $formData['sds_number']);
        $stmtMrp->execute();
        $stmtMrp->close();
    }
    
    private function isDuplicateItem($sdoCode, $doNumber, $itemCode)
    {
        $query = "SELECT * FROM tb_supplier_delivery_order_details 
                 WHERE sdo_code = ? AND do_number = ? AND item_code = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sss", $sdoCode, $doNumber, $itemCode);
        $stmt->execute();
        $result = $stmt->get_result();
        $isDuplicate = $result->num_rows > 0;
        $stmt->close();
        
        return $isDuplicate;
    }
    
    private function getSupplierId($supplierName)
    {
        $query = "SELECT id FROM yrhmyid_mui_mrp.mst_person_supplier 
                 WHERE description = ?";
        
        $stmt = $this->conn_mrp->prepare($query);
        $stmt->bind_param("s", $supplierName);
        $stmt->execute();
        $result = $stmt->get_result();
        $supplier = $result->fetch_assoc();
        $stmt->close();
        
        return $supplier ? $supplier['id'] : null;
    }
    
    private function logActivity($formData)
    {
        $itemData = $formData['item_data'];
        $activityDescription = "Entry Data -> DO No: {$formData['sdo_code']}, " .
                              "PO No: {$formData['po_number']}, " .
                              "SDS No: {$formData['sds_number']}";
        
        // Log first item as representative
        if (!empty($itemData['item_name'])) {
            $activityDescription .= ", Part Name: {$itemData['item_name'][0]}, " .
                                  "Part Code: {$itemData['item_code'][0]}, " .
                                  "Qty: {$itemData['quantity_delivery'][0]}";
        }
        
        $query = "INSERT INTO tb_activity_log 
                 (date_time, username, supplier, account_status, menu, activity_description) 
                 VALUES (?, ?, ?, ?, 'Delivery Order', ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "sssss", 
            $this->currentTime, $_SESSION['username'], $_SESSION['supplier'],
            $_SESSION['account_status'], $activityDescription
        );
        $stmt->execute();
        $stmt->close();
    }
    
    private function redirectWithAlert($message)
    {
        echo "<script>alert('$message')</script>";
      header("Location: do_product.php");
        exit();
    }
}
?>