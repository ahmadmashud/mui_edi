<?php
//include "phpqrcode/qrlib.php";

//Parameter 1 menentukan teks atau data yang akan dikodekan.Parameter 2 file output untuk PNG gambar yang dihasilkan.Parameter 3 adalah tingkat koreksi kesalahan untuk barcode yang dihasilkan. Parameter 4 menentukan ukuran diukur dalam pixel. Parameter 5 menentukan batas margin putih di sekitar barcode.

//QRcode::png("http://www.dumetschool.com", "image.png", "L", 4, 4);
//echo "<img src='image.png' />";
?>

<?php
include "../../koneksi.php";
session_start();
include "../../phpqrcode/qrlib.php";
define('_MPDF_PATH','../../mpdf/');
include(_MPDF_PATH . "mpdf.php");

if (isset($_GET['sdo_code'])) 
{
	$sdo_code= $_GET['sdo_code'];
}
else
{
	die ("Error. No ID Selected! ");	
}
 
//setting dan nama file pdf
$nama_dokumen='MUI Do Number';
$mpdf=new mPDF('utf-8', 'A4', 11, 'Georgia');
ob_start();
 
 
//direktory tempat menyimpan hasil generate qrcode jika folder belum dibuat maka secara otomatis akan membuat terlebih dahulu
$tempdir = "../../temp/"; 
if (!file_exists($tempdir))
mkdir($tempdir);

$show_barcode = mysql_query("SELECT * FROM tb_supplier_delivery_order where sdo_code='$sdo_code'");	
while ($print_code = mysql_fetch_assoc($show_barcode)) 
{
	$do_number = $print_code['do_number'];
}
?>
<html>
	<body>
		<p>MUI DO NUMBER</p>
		<?php
			//Isi dari QRCode Saat discan
			$isi_teks1 = $do_number;
			//Nama file yang akan disimpan pada folder temp 
			$namafile1 = "do_number.png";
			//Kualitas dari QRCode 
			$quality1 = 'H'; 
			//Ukuran besar QRCode
			$ukuran1 = 8; 
			$padding1 = 0; 
			QRCode::png($isi_teks1,$tempdir.$namafile1,$quality1,$ukuran1,$padding1);
		?>
		<img src="../../temp/<?php echo $namafile1; ?>" width="200px">
	</body>
</html>

<?php
$html = ob_get_contents();
ob_end_clean();
$mpdf->WriteHTML(utf8_encode($html));
$mpdf->Output("".$nama_dokumen.".pdf" ,'D');
?>