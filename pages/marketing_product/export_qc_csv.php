<?php

include "conn.php";

// Load plugin PHPExcel nya
require_once 'PHPExcel/PHPExcel.php';

// Panggil class PHPExcel nya
$csv = new PHPExcel();

// Settingan awal fil excel
$csv->getProperties()->setCreator('MUI IT-Department')
             ->setLastModifiedBy('MUI IT-Department')
             ->setTitle("Quality Check")
             ->setSubject("DO Number")
             ->setDescription("Quality Check")
             ->setKeywords("Quality Check");

// Buat header tabel nya pada baris ke 1
$csv->setActiveSheetIndex(0)->setCellValue('A1', "NO"); 
$csv->setActiveSheetIndex(0)->setCellValue('B1', "PO Number"); 
$csv->setActiveSheetIndex(0)->setCellValue('C1', "DO Number"); 
$csv->setActiveSheetIndex(0)->setCellValue('D1', "Item Description"); 
$csv->setActiveSheetIndex(0)->setCellValue('E1', "Item Code"); 
$csv->setActiveSheetIndex(0)->setCellValue('F1', "Unit"); 
$csv->setActiveSheetIndex(0)->setCellValue('G1', "Quantity Receiving"); 
$csv->setActiveSheetIndex(0)->setCellValue('H1', "Good");
$csv->setActiveSheetIndex(0)->setCellValue('I1', "NG");
$csv->setActiveSheetIndex(0)->setCellValue('J1', "%NG");

// Buat query untuk menampilkan semua data siswa
	if (isset($_GET['do_number']) AND ($_GET['po_number'])) {
	$do_number			= $_GET['do_number'];
	$po_number			= $_GET['po_number'];
	}
	else{
		die ("Error. No ID Selected! ");	
	}
$sql = $pdo->prepare("SELECT * FROM tb_quality_control_check_details where do_number='$do_number' AND po_number='$po_number' order by part_name");
$sql->execute(); // Eksekusi querynya

$no = 1; // Untuk penomoran tabel, di awal set dengan 1
$numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 2
while($data = $sql->fetch()){ // Ambil semua data dari hasil eksekusi $sql
  $csv->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
  $csv->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['po_number']);
  $csv->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['do_number']);
  $csv->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['part_name']);
  $csv->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['part_number']);
  $csv->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['material_unit']);
  $csv->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['quantity_receiving']);
  $csv->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['good']);
  $csv->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data['not_good']);
  $csv->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data['percentage_ng']);
  
  // Khusus untuk no telepon. kita set type kolom nya jadi STRING
  //$csv->setActiveSheetIndex(0)->setCellValueExplicit('E'.$numrow, $data['telp'], PHPExcel_Cell_DataType::TYPE_STRING);
  
  //$csv->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['alamat']);
  
  $no++; // Tambah 1 setiap kali looping
  $numrow++; // Tambah 1 setiap kali looping
}

// Set orientasi kertas jadi LANDSCAPE
$csv->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

// Set judul file excel nya
$csv->getActiveSheet(0)->setTitle("Quality Check");
$csv->setActiveSheetIndex(0);

// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Quality Check.csv"'); // Set nama file excel nya
header('Cache-Control: max-age=0');

$write = new PHPExcel_Writer_CSV($csv);
$write->save('php://output');
?>