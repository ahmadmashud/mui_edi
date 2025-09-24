<?php
// pendefinisian folder font pada FPDF
define('FPDF_FONTPATH', 'FPDF/font/');
require('FPDF/fpdf.php');

// seperti sebelunya, kita membuat class anakan dari class FPDF
	session_start();
			
 class PDF extends FPDF{
	
  function Header(){
 $server = "localhost:3377";
 $user = "mymuiedi1";
 $pass = "<maman-mymuiedi1>";
 $data = "mui_edi";

 $net = new mysqli($server, $user, $pass, $data);

 if($net->connect_error){
  die("Connection failed: ".$net->connect_error);
 }
	
	if (isset($_GET['sds_number']) AND ($_GET['po_number'])) {
	$sds_number			= $_GET['sds_number'];
	$po_number			= $_GET['po_number'];
	}
	else{
		die ("Error. No ID Selected! ");	
	}
	
	$q = "select * from tb_supplier_delivery_schedule where sds_number='$sds_number' AND po_number='$po_number'";
	$h = $net->query($q) or die($net->error);
	$i = 0;
	
	while($d=$h->fetch_array()){
	  $date=$d[3];	  
	 }

	
	$this->Image('../../dist/img/mui.png',1,1,2.25);
	$this->SetTitle('MUI-Electronic Data Interchange');	
    $this->SetFont('Arial','','10');
	$this->SetFillColor(120, 120, 120); //warna dalam kolom header	
	$this->SetDrawColor(51, 51, 51);
   // membuat cell dg panjang 19 dan align center 'C'
   $this->Ln(1.5);
   $this->SetTextColor(0); 
   $this->SetFont('Arial','B','12');
   $this->Cell(19,1,'SUPPLIER DELIVERY SCHEDULE',0,0,'C');
   $this->Ln(1.3);
   $this->SetFont('Arial','B','10');
   $this->Cell(19,1,'PO Number : ' .$po_number,0,0,'L');
   $this->Ln(0.7);
   $this->Cell(15,1,'SDS Number : ' .$sds_number,0,0,'L');
   $this->Cell(4,1,'Schedule Date : ' .$date,0,0,'R');
   $this->Ln(1.2);
   $this->SetFont('Arial','B','10'); 
   $this->SetTextColor(255);
   $this->Cell(0.1);
   $this->Cell(1,1,'No','TB',0,'C',1); 
   $this->Cell(8,1,'Item Description','TB',0,'C',1); 
   $this->Cell(4,1,'Item Code','TB',0,'C',1); 
   $this->Cell(2,1,'Quantity','TB',0,'C',1); 
   $this->Cell(4,1,'Outstanding Delivery','TB',0,'C',1); 
   // panjang cell bisa disesuaikan
   $this->Ln();
  }

  function Footer(){
   $this->SetY(-2,5);
   $this->Cell(0,1,$this->PageNo(),0,0,'C');
  } 
 }

 $server = "localhost:3377";
 $user = "mymuiedi1";
 $pass = "<maman-mymuiedi1>";
 $data = "mui_edi";
 
 $net = new mysqli($server, $user, $pass, $data);

 if($net->connect_error){
  die("Connection failed: ".$net->connect_error);
 }
	
	if (isset($_GET['sds_number']) AND ($_GET['po_number'])) {
	$sds_number			= $_GET['sds_number'];
	$po_number			= $_GET['po_number'];
	}
	else{
		die ("Error. No ID Selected! ");	
	}

 $q = "select * from tb_supplier_delivery_schedule_details where sds_number='$sds_number' AND po_number='$po_number' order by item_code";
 $h = $net->query($q) or die($net->error);
 $i = 0;
 

 while($d=$h->fetch_array()){
  $cell[$i][1]=$d[12];
  $cell[$i][2]=$d[11];  
  $cell[$i][3]=$d[18];
  $cell[$i][4]=$d[19];
  $i++;
 }

 // orientasi Potrait
 // ukuran cm
 // kertas A4
 $pdf = new PDF('P','cm','A4');
 $pdf->setMargins(1,1,1,1);
 $pdf->Open();
 $pdf->AliasNbPages();
 $pdf->AddPage();

 $pdf->SetFont('Arial','','8');
 $pdf->SetFillColor(191, 191, 191); //warna dalam kolom data
 $pdf->SetTextColor(0); //warna tulisan hitam
 $pdf->SetDrawColor(51, 51, 51); //warna border
 
 //perulangan untuk membuat tabel
 for($j=0;$j<$i;$j++){	 
  $pdf->Cell(0.1);
  $pdf->Cell(1,1,$j+1,'B',0,'C');
  $pdf->Cell(8,1,$cell[$j][1],'B',0,'L');
  $pdf->Cell(4,1,$cell[$j][2],'B',0,'L');
  $pdf->Cell(2,1,$cell[$j][3],'B',0,'C');
  $pdf->Cell(4,1,$cell[$j][4],'B',0,'C');
  $pdf->Ln();
 }

 $pdf->Output(); // ditampilkan



?>

