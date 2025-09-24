<?php
//header to give the order to the browser
error_reporting(0);
include "../../koneksi.php";
include "../../phpqrcode/qrlib.php";
session_start();
date_default_timezone_set("Asia/Jakarta");
$jam=date('d/m/Y h:i:s');	
$tgl=date('Y-m-d');

$tempdir = "../../temp/"; 
if (!file_exists($tempdir))
    mkdir($tempdir);
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>MUI-Electronic Data Interchange</title>
        <link rel="shortcut icon" href="../../favicon.ico">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="../../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
        <style>
        input[type="button"] 
        {
            background-color: #4dc3ff;
            color: white;
            padding: 2px 2px;
            cursor: pointer;
            border: none;
            width: 55%;
        }

        input[type="button"]:hover {opacity: 0.8;}	

    *   {margin:0; padding: 0;}

        body 
        {
            font-family: calibri;
            font-size: 12px;
        }

        /* Tombol Button Pesan */
        #button {margin: 5% auto; width: 100px; text-align: center;}
        #button a 
        {
            width: 100px;
            height: 30px;
            vertical-align: middle;
            background-color: #F00;
            color: #fff;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid transparent;
        }

        /* Jendela Pop Up */
        #popup 
        {
            width: 100%;
            height: 100%;
            position: fixed;
            background: rgba(0,0,0,.7);
            top: 0;
            left: 0;
            z-index: 9999;
            visibility: hidden;
        }

        .window 
        {
            width: 920px;
            height: 400px;
            background: #fff;
            border-radius: 10px;
            position: relative;
            padding: 10px;
            text-align: center;
            margin: 15% auto;
            margin-left: 20%;
        }

        .window h2 {margin: 30px 0 0 0;}
        /* Button Close */
        .close-button 
        {
            width: 3%;
            height: 8%;
            line-height: 23px;
            background: #000;
            border-radius: 50%;
            border: 3px solid #fff;
            display: block;
            text-align: center;
            color: #fff;
            text-decoration: none;
            position: absolute;
            top: -10px;
            right: -10px;	
        }

        /* Memunculkan Jendela Pop Up*/
        #popup:target {visibility: visible;}
        </style>
    </head>

    <body>
    <div id="popup">
        <div class="window">
            <a href="do_product.php" class="close-button" title="Close">X</a>
            <div class="box-header">
                <h3 class="box-title"><b>MUI DO NUMBER</b></h3>
            </div><!-- /.box-header -->
            <div style='width:900px;height:280px;overflow:auto;'>
            <?php
            if (isset($_GET['sdo_code'])) 
            {
                $sdo_code= $_GET['sdo_code'];
            }
            else
            {
                die ("Error. No ID Selected! ");	
            }

            include "konfig.php";
            $query = "SELECT * FROM tb_supplier_delivery_order where sdo_code='$sdo_code'";
            $arsip1 = $db1->prepare($query);
            $arsip1->execute();
            $res1 = $arsip1->get_result();
            while ($row = $res1->fetch_assoc()) 
            {
                $do_number = $row['sdo_code'];
                $sds_number = $row['sds_number'];

                //Isi dari QRCode Saat discan
                $isi_teks1 = $do_number;
                //Nama file yang akan disimpan pada folder temp 
                $namafile1 = $do_number.".png";
                //Kualitas dari QRCode 
                $quality1 = 'H'; 
                //Ukuran besar QRCode
                $ukuran1 = 6; 
                $padding1 = 4; 
                QRCode::png($isi_teks1,$tempdir.$namafile1,$quality1,$ukuran1,$padding1);
                ?>			
                <img src="../../temp/<?php echo $namafile1; ?>">
            <?php 
            } 
            ?>

            <table width=100%> 
    			<tr>
					<td align="center">
						<a href="qrcode_pdf.php?sdo_code=<?=$sdo_code;?>">
							<input type="button" style="width:15%;" value="Export to PDF" />
						</a>
					</td>
				</tr>
            </table>
            </div>
        </div> 
    </div>
    </body>
</html>

