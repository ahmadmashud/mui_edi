<?php

include "conn.php";

// Load plugin PHPExcel nya
require_once 'PHPExcel/PHPExcel.php';

// Panggil class PHPExcel nya
$csv = new PHPExcel();

// Settingan awal fil excel
$csv->getProperties()->setCreator('MUI IT-Department')
             ->setLastModifiedBy('MUI IT-Department')
             ->setTitle("Supplier Delivery Order")
             ->setSubject("DO Number")
             ->setDescription("Supplier Delivery Order Details")
             ->setKeywords("Data Supplier Delivery Order Details");

// Buat header tabel nya pada baris ke 1
$csv->setActiveSheetIndex(0)->setCellValue('A1', "NO"); 
$csv->setActiveSheetIndex(0)->setCellValue('B1', "PO Number");
$csv->setActiveSheetIndex(0)->setCellValue('C1', "SDS Number");
$csv->setActiveSheetIndex(0)->setCellValue('D1', "Delivery Date");
$csv->setActiveSheetIndex(0)->setCellValue('E1', "DO Number");
$csv->setActiveSheetIndex(0)->setCellValue('F1', "Item Description"); 
$csv->setActiveSheetIndex(0)->setCellValue('G1', "Item Code"); 
$csv->setActiveSheetIndex(0)->setCellValue('H1', "Quantity"); 

// Buat query untuk menampilkan semua data siswa
	if (isset($_GET['id'])) {
	$do_number			= $_GET['id'];
	}
	else{
		die ("Error. No ID Selected! ");	
	}
$sql = $pdo->prepare("SELECT * FROM tb_supplier_delivery_order_details where do_number='$do_number'");
$sql->execute(); // Eksekusi querynya

$no = 1; // Untuk penomoran tabel, di awal set dengan 1
$numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 2
while($data = $sql->fetch()){ // Ambil semua data dari hasil eksekusi $sql
  $csv->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
  $csv->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['po_number']);
  $csv->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['sds_number']);
  $csv->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['do_date']);
  $csv->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['do_number']);
  $csv->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['item_description']);
  $csv->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['item_code']);
  $csv->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['quantity']);
  
  // Khusus untuk no telepon. kita set type kolom nya jadi STRING
  //$csv->setActiveSheetIndex(0)->setCellValueExplicit('E'.$numrow, $data['telp'], PHPExcel_Cell_DataType::TYPE_STRING);
  
  //$csv->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['alamat']);
  
  $no++; // Tambah 1 setiap kali looping
  $numrow++; // Tambah 1 setiap kali looping
}

// Set orientasi kertas jadi LANDSCAPE
$csv->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

// Set judul file excel nya
$csv->getActiveSheet(0)->setTitle("DO Details");
$csv->setActiveSheetIndex(0);

// Proses file excel
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="DO Details.csv"'); // Set nama file excel nya
header('Cache-Control: max-age=0');

$write = new PHPExcel_Writer_CSV($csv);
$write->save('php://output');
?>