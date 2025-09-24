<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>MUI-Electronic Data Interchange</title>
	<link rel="shortcut icon" href="../../favicon.ico">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="../../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
	<!-- daterange picker -->
    <link href="../../plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <!-- DATA TABLES -->
    <link href="../../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
	
	<style>
		button {
		background-color: #4dc3ff;
		color: white;
		padding: 2px 2px;
		cursor: pointer;
		border: none;
		width: 100%;
	}
		button:hover {
		opacity: 0.8;
	}
	table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #ddd;
	}

	th, td {
		border: 1px solid #ddd;
		text-align: left;
		padding: 8px;
	}

	tr:nth-child(even){background-color: #f2f2f2}
	</style>
	
	<?php
	session_start();
	if(!isset($_SESSION['username'])){
		die("<script>alert('Oops! Access Failed. System Logout. You must login again.')</script>
			<script> onclick=location.href='../../index.php'</script>");
	}
	if($_SESSION['account_status']!="Supplier"){
		die("<script>alert('Oops! Access Failed. You are not Supplier.')</script>
			<script> onclick=location.href='../../index.php'</script>");
	}

	//Membuat batasan waktu sesion untuk user di PHP 
	$timeout = 60; // Set timeout menit
	$logout_redirect_url = "../../index.php"; // Set logout URL
	 
	$timeout = $timeout * 60; // Ubah menit ke detik
	if (isset($_SESSION['start_time'])) {
		$elapsed_time = time() - $_SESSION['start_time'];
		if ($elapsed_time >= $timeout) {
			session_destroy();
			echo "<script>alert('This session has timeout!'); window.location = '$logout_redirect_url'</script>";
		}
	}
	$_SESSION['start_time'] = time();
	$tgl=date('yyyy-mm-dd');
	?>
	
  </head>
  <body class="skin-blue">
    <div class="wrapper">
      
      <header class="main-header">
        <a href="#" class="logo" style="font-family:calibri; size:30px;"><i><b>MUI-</b>EDI</i></a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../../dist/img/user.jpg" class="user-image" alt="User Image"/>
                  <span class="hidden-xs"><?php echo $_SESSION['full_name']?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="../../dist/img/user.jpg" class="img-circle" alt="User Image" />
                    <p>
                      Welcome, <?php echo $_SESSION['full_name']?><br><?php echo $_SESSION['supplier']?>
                    </p>
                  </li>  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-right">
                     <a href="../login/act-logout.php" class="btn btn-default btn-flat">Logout</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active treeview">
              <a href="../../home_delivery_product.php">
                <i class="fa fa-home"></i> <span>Home</span> 
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-file-text"></i> <span>Purchase Order</span> 
              </a>
            </li>
			<li>
              <a href="sds_product.php">
                <i class="fa fa-edit"></i> <span>Supplier Delivery Schedule</span> 
              </a>
            </li>
			<li>
              <a href="do_product.php">
                <i class="fa fa-truck"></i> <span>Delivery Order</span> 
              </a>
            </li>
			<li>
              <a href="#">
                <i class="fa fa-check-square-o"></i> <span>Quality Check</span>
              </a>
            </li>
			<li>
              <a href="summary_product.php">
                <i class="fa fa-calculator"></i> <span>Summary</span> 
              </a>
            </li>
			</ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Right side column. Contains the navbar and content of the page -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            &nbsp
          </h1>
          <ol class="breadcrumb">
            <li><a href="../../home_delivery_product.php"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="active">Summary</li>
          </ol>
        </section>
		
		<?php
		error_reporting(0);
		include "../../koneksi.php";
			
		//untuk menantukan tanggal awal dan tanggal akhir data di database
		$min_tanggal=mysql_fetch_array(mysql_query("select min(po_date) as min_tanggal from tb_purchase_order_details where supplier='$_SESSION[supplier]'"));
		$max_tanggal=mysql_fetch_array(mysql_query("select max(po_date) as max_tanggal from tb_purchase_order_details where supplier='$_SESSION[supplier]'"));
		?>
		
       <!-- Main content -->
		 <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">              	
                <div class="box-header">
                  <h3 class="box-title"><b>Summary</b></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
				
				<form action="summary_product.php" method="post" name="postform">
                <table class="table table-bordered table-striped">				  
				<tr>
					<td width=11% style="font-size:16px; font-family:calibri;" >PO Date From</td>
					<td width="50">
					<div class="input-group">								  
						<input id="reservation" type="text" name="tanggal_awal" size=13 value="<?php echo $min_tanggal['min_tanggal'];?>">
					</td>
					<td width="5%" style="font-size:16px; font-family:calibri;" >Until</td>
					<td>							  
						<input id="reservation1" type="text" name="tanggal_akhir" size=13 value="<?php echo $max_tanggal['max_tanggal'];?>">
					</div><!-- /.input group -->			
					</td>
					<td width="200"><button name="cari">Search</td>
				</tr>
				</table>
				</form>
				
				<?php				
				if(isset($_POST['cari'])){
					
				$tanggal_awal=$_POST['tanggal_awal'];
				$tanggal_akhir=$_POST['tanggal_akhir'];
				
				if(empty($tanggal_awal) and empty($tanggal_akhir)){
				echo"<script>alert('Please choose po date from until first.')</script>";
				
				}else{
				
				?><i><b>Information : </b> Search result from <b><?php echo $_POST['tanggal_awal']?></b> until <b><?php echo $_POST['tanggal_akhir']?></b></i><?php
				$query="SELECT tb_purchase_order_details.po_date, tb_purchase_order_details.po_number, tb_purchase_order_details.item_description, 
				tb_purchase_order_details.item_code, tb_purchase_order_details.quantity AS po_qty,
				tb_supplier_delivery_order_details.sds_number,  
				tb_supplier_delivery_order_details.do_date, tb_supplier_delivery_order_details.do_number, 
				tb_supplier_delivery_order_details.quantity AS do_qty, 
				tb_purchase_order_details.outstanding,
				(SELECT COUNT(po_number) FROM tb_purchase_order_details WHERE po_number=po_number) AS jumlah_po 
				FROM tb_purchase_order_details 
				LEFT JOIN tb_supplier_delivery_order_details
				ON tb_purchase_order_details.po_number=tb_supplier_delivery_order_details.po_number and
				tb_purchase_order_details.item_code=tb_supplier_delivery_order_details.item_code
				WHERE tb_purchase_order_details.po_date between '$tanggal_awal' and '$tanggal_akhir' and tb_supplier_delivery_order_details.do_status = 'RECEIVED' and tb_supplier_delivery_order_details.supplier='$_SESSION[supplier]'
				ORDER BY tb_purchase_order_details.po_number, tb_purchase_order_details.item_code, 
				tb_supplier_delivery_order_details.sds_number, tb_supplier_delivery_order_details.do_number";
				
				$proses=mysql_query($query);
				$i=0; 
				while($data=mysql_fetch_assoc($proses)){
				  $row[$i]=$data;
				  $i++;
				}
				}
				?>
				
				<script>
				function SummerizeTable(table) {
				  $(table).each(function() {
					$(table).find('td').each(function() {
					  var $this = $(this);
					  var col = $this.index();
					  var html = $this.html();
					  var row = $(this).parent()[0].rowIndex; 
					  var span = 1;
					  var cell_above = $($this.parent().prev().children()[col]);

					  // look for cells one above another with the same text
					  while (cell_above.html() === html) { // if the text is the same
						span += 1; // increase the span
						cell_above_old = cell_above; // store this cell
						cell_above = $(cell_above.parent().prev().children()[col]); // and go to the next cell above
					  }

					  // if there are at least two columns with the same value, 
					  // set a new span to the first and hide the other
					  if (span > 1) {
						// console.log(span);
						$(cell_above_old).attr('rowspan', span);
						$this.hide();
					  }
					  
					});
				  });
				}
				</script>
				
				<table id="example1"> 
				  <tr> 
					<th>PO Number</th>				 
					<th>Item Description</th> 
					<th>Item Code</th>
					<th>Qty. PO</th>
					<th>SDS Number</th>
					<th>DO Date</th>
					<th>DO Number</th>
					<th>Qty. Delivery</th>
					<th>Outstanding</th>
				  </tr>

				<?php
				$n=count($row);
				$ceksummary="";
				for($i=0;$i<$n;$i++){
				  $cell=$row[$i];
				  echo '<tr>';				 				 
				  echo 
				  "
				  <td>$cell[po_number]</td>
				  <td>$cell[item_description]</td>
				  <td>$cell[item_code]</td>
				  <td align='right'>$cell[po_qty]</td>
				  <td>$cell[sds_number]</td>
				  <td>$cell[do_date]</td>
				  <td>$cell[do_number]</td>
				  <td align='right'>$cell[do_qty]</td>
				  <td align='right'>$cell[outstanding]</td>";
				  echo "</tr>";
				}
				?>
				<tr>
					<td colspan=9 align="center"> 
					<?php
					//jika data tidak ditemukan
					if(mysql_num_rows($proses)==0){
						echo"<script>alert('Summary List Not Found!')</script>";
						//echo "<font color=red><blink>Summary List Not Found!</blink></font>";
					}
					?>
					</td>
				</tr>
				
				<tr>
				<td colspan=7></td>
				<td colspan=2><button onclick="SummerizeTable('#example1')">Summerize</button></td>
				</tr>
				</table>										
				
				<?php
				}else{
					unset($_POST['cari']);
				}
				?>

                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	  
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
		  <a target="_blank" href="http://www.ptmui.co.id"><img src="../../dist/img/mui4.png"></a>         
        </div>
        Version 1.0. Copyright &copy; 2017 MUI Information Technology Department. All rights reserved
      </footer>
	  </div> <!-- wrapper -->

    <!-- jQuery 2.1.3 -->
    <script src="../../plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- DATA TABES SCRIPT -->
    <script src="../../plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="../../plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<!-- date-range-picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='../../plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/app.min.js" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js" type="text/javascript"></script>
    <!-- page script -->
    <script type="text/javascript">
      $(function () {
        $("#example1").dataTable();
        $('#example2').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": false,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
    </script>
	<!-- page script -->
    <script type="text/javascript"><!-- 
	//Date range picker
			$('#reservation').datepicker({format: 'yyyy-mm-dd'});
			$('#reservation1').datepicker({format: 'yyyy-mm-dd'});
	</script>

  </body>
</html>