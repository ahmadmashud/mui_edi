<?php
require('fpdf/fpdf.php'); 
 
$pdf = new FPDF('P', 'cm', 'A4');

$pdf->AddPage(); 
$pdf->SetFont('Arial', '', 24);

$pdf->Cell(10, 3, "Hello, World!");

	
$pdf->Output();

?>