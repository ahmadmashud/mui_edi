<?php

include "conn.php";

// Load plugin PHPExcel nya
require_once 'PHPExcel/PHPExcel.php';

// Panggil class PHPExcel nya
$csv = new PHPExcel();

// Settingan awal fil excel
$csv->getProperties()->setCreator('MUI IT-Department')
             ->setLastModifiedBy('MUI IT-Department')
             ->setTitle("Supplier Delivery Schedule Details")
             ->setSubject("SDS Number")
             ->setDescription("Supplier Delivery Schedule Details")
             ->setKeywords("Data Supplier Delivery Schedule Details");

// Buat header tabel nya pada baris ke 1
$csv->setActiveSheetIndex(0)->setCellValue('A1', "NO"); // Set kolom A1 dengan tulisan "NO"
$csv->setActiveSheetIndex(0)->setCellValue('B1', "PO Number"); // Set kolom B1 dengan tulisan "NIS"
$csv->setActiveSheetIndex(0)->setCellValue('C1', "SDS Number"); // Set kolom C1 dengan tulisan "NAMA"
$csv->setActiveSheetIndex(0)->setCellValue('D1', "Schedule Date"); // Set kolom D1 dengan tulisan "JENIS KELAMIN"
$csv->setActiveSheetIndex(0)->setCellValue('E1', "Item Description"); // Set kolom E1 dengan tulisan "TELEPON"
$csv->setActiveSheetIndex(0)->setCellValue('F1', "Item Code"); // Set kolom F1 dengan tulisan "ALAMAT"
$csv->setActiveSheetIndex(0)->setCellValue('G1', "Quantity"); // Set kolom F1 dengan tulisan "ALAMAT"
$csv->setActiveSheetIndex(0)->setCellValue('H1', "OS Delivery"); // Set kolom F1 dengan tulisan "ALAMAT"

// Buat query untuk menampilkan semua data siswa
	if (isset($_GET['sds_number']) AND ($_GET['po_number'])) {
	$sds_number			= $_GET['sds_number'];
	$po_number			= $_GET['po_number'];
	}
	else{
		die ("Error. No ID Selected! ");	
	}
$sql = $pdo->prepare("SELECT * FROM tb_supplier_delivery_schedule_details where sds_number='$sds_number' AND po_number='$po_number' order by item_code");
$sql->execute(); // Eksekusi querynya

$no = 1; // Untuk penomoran tabel, di awal set dengan 1
$numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 2
while($data = $sql->fetch()){ // Ambil semua data dari hasil eksekusi $sql
  $csv->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
  $csv->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['po_number']);
  $csv->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['sds_number']);
  $csv->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['schedule_date']);
  $csv->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['item_description']);
  $csv->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['item_code']);
  $csv->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['quantity']);
  $csv->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['outstanding_delivery']);
  
  // Khusus untuk no telepon. kita set type kolom nya jadi STRING
  //$csv->setActiveSheetIndex(0)->setCellValueExplicit('E'.$numrow, $data['telp'], PHPExcel_Cell_DataType::TYPE_STRING);
  
  //$csv->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['alamat']);
  
  $no++; // Tambah 1 setiap kali looping
  $numrow++; // Tambah 1 setiap kali looping
}

// Set orientasi kertas jadi LANDSCAPE
$csv->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

// Set judul file excel nya
$csv->getActiveSheet(0)->setTitle("SDS Details");
$csv->setActiveSheetIndex(0);

// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="SDS Details.csv"'); // Set nama file excel nya
header('Cache-Control: max-age=0');

$write = new PHPExcel_Writer_CSV($csv);
$write->save('php://output');
?>