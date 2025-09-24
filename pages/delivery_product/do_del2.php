<?php
session_start();
include "koneksi.php";
date_default_timezone_set("Asia/Jakarta");
$jam=date('d/m/Y h:i:s');
$tgl=date('Y-m-d');
$time=date('h:i:s');
?>



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
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
	<style>
		button {
		background-color: #4dc3ff;
		color: white;
		padding: 2px 2px;
		cursor: pointer;
		border: none;
		width: 20%;
	}
		button:hover {
		opacity: 0.8;
	}
	</style>
	<SCRIPT language=Javascript>
       <!--
       function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
       //-->
    </SCRIPT>
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
                      Welcome, <?php echo $_SESSION['full_name']?> <br><?php echo $_SESSION['supplier']?>
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
              <a href="../../home_delivery.php">
                <i class="fa fa-home"></i> <span>Home</span> 
              </a>
            </li>
            <li>
              <a href="#">
                <i class="fa fa-file-text"></i> <span>Purchase Order</span> 
              </a>
            </li>
			<li>
              <a href="sds_del.php">
                <i class="fa fa-edit"></i> <span>Delivery Schedule</span> 
              </a>
            </li>
			<li>
              <a href="do_del.php">
                <i class="fa fa-truck"></i> <span>Delivery Order</span> 
              </a>
            </li>
			<li>
              <a href="#">
                <i class="fa fa-check-square-o"></i> <span>Quality Check</span>
              </a>
            </li>
			<li>
              <a href="#">
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
            <li><a href="../../home_delivery.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Delivery Order</li>
          </ol>
        </section>

        <!-- Main content -->
		 <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">              	
                <div class="box-header">
                  <h3 class="box-title"><b>Delivery Order</b></h3>
                </div><!-- /.box-header -->
                <div class="box-body">					
					<form action="do_process_del.php" method="post" name='autoSumForm'>
				  <?php						
				    error_reporting(0);
					
					$select_sds_details = mysql_query("SELECT * FROM tb_supplier_delivery_schedule WHERE shipment_status!='COMPLETELY RECEIVED' and supplier='$_SESSION[supplier]'");
					$sds_details_count = mysql_num_rows($select_sds_details);
						
					if ($sds_details_count = 0)
					{
					  echo"<script>alert('Delivery Order List Not Found.')</script>";
					}
					else
					{ 
					  $select_sds_fifo = mysql_query("SELECT * FROM tb_supplier_delivery_schedule WHERE sds_status='OPEN' and edi_status='RECEIVED' order by sds_number");
					  if(mysql_num_rows($select_sds_fifo) == 0)
					  {
					    echo"<script>alert('Delivery Order List Not Found!')</script>";		
					  }
					  else
					  {
					  $sds_fifo = mysql_fetch_assoc($select_sds_fifo);													  
					  }
					  
					  $select_sds_details1 = mysql_query("SELECT * FROM tb_supplier_delivery_schedule WHERE shipment_status!='COMPLETELY RECEIVED' and shipment_status='ON THE WAY'");
					  $sds_details_count1 = mysql_num_rows($select_sds_details1);
					  
					  if ($sds_details_count1 > 0)
					  {
					  ?>
					    <table id="example1" class="table table-bordered table-striped">
						  <tr>
						    <td><b>PO Number &nbsp; &nbsp; : &nbsp; <?php echo $sds_fifo['po_number'];?> </b></td>					
						    <td><b>SDS Number &nbsp;: &nbsp; <?php echo $sds_fifo['sds_number'];?> </b></td>
						    <td align="right"><b>Shipment Status &nbsp;: &nbsp; <?php echo $sds_fifo['shipment_status'];?> </b></td>
						  </tr>
						</table>
					  <?php
					  } 
					  else 
					  {
					  ?>						  
						
					  <?php
					  $show1 = mysql_query("SELECT * FROM tb_supplier_delivery_schedule_details order by sds_number");						
					  $rows = mysql_fetch_assoc($show1);													  
					  ?>
						
					  <table id="example1" class="table table-bordered table-striped">
					    <tr>
						  <td><b>PO Number &nbsp; &nbsp; : &nbsp; <?php echo $sds_fifo['po_number'];?> </b></td>					
						  <td><b>SDS Number &nbsp;: &nbsp; <?php echo $sds_fifo['sds_number'];?> </b></td>
						  <td align="right"><b>Shipment Status &nbsp;: &nbsp; <?php echo $sds_fifo['shipment_status'];?> </b></td>
						 </tr>
					  </table>
							
					  <table id="example1" class="table table-bordered table-striped">
					    <thead>
						  <tr>
							<th>No.</th>
						    <th>Item Description</th>
						    <th>Item Code</th>
						    <th>Quantity Delivery <a style="color:red">*</a></th>
						  </tr>
						</thead>
					    <tbody>
						
						<?php
						  $po_number			=$sds_fifo['po_number'];
						  $sds_number			=$sds_fifo['sds_number'];
						  $item_description 	=$rows['item_description'];
						  $item_code			=$rows['item_code'];
						  $item_type			=$rows['item_type'];
						  $item_unit			=$rows['item_unit'];
															
						  $tampilPeg=mysql_query("SELECT * FROM tb_supplier_delivery_schedule_details where po_number = '$po_number' and sds_number='$sds_number' ORDER BY sds_number");
						  $no = 1;
						  while($peg=mysql_fetch_array($tampilPeg))
						  {								
			  			?>
								
						  <tr>
							<td width=4%><?php echo $no; ?></td>	
							<td>
							<input type="text" name="item_description[]" size=85% value="<?php echo $peg['item_description'];?>" disabled="disabled">
							<input type="hidden" name="item_description[]" value="<?php echo $peg['item_description'];?>">
							</td>
							<td width=20%>
							<input type="text" name="item_code[]" value="<?php echo $peg['item_code'];?>" disabled="disabled">
							<input type="hidden" name="item_code[]" value="<?php echo $peg['item_code'];?>">
							</td>
							<input type="hidden" name="quantity_delivery[]" size="12px" value="<?php echo $peg['outstanding_delivery'];?>">
							<td width=14%><input type="text" onkeypress="return isNumberKey(event)" name="quantity[]" size="12px" value="<?php echo $peg['outstanding_delivery'];?>" required></td>								
						  <?php $no++;	
						  }
						  ?>
						  </tr>
					    </tbody>
					  </table>
								
					  <table id="example1" class="table table-bordered table-striped">
					    <tr>
						  <td width=12%><b>Delivery Date <a style="color:red">*</a></b></td>
						  <td width=14%>
				   		    <div class="input-group">								  
							  <input id="reservation" type="text" name="do_date" size=12 value="<?php echo $tgl; ?>" required>
							</div><!-- /.input group -->
				  		  </td>						  						
						  <td width=14% >
						    <div class="input-group date" id="datetimepicker1">
							  <input type="text" name="do_time" size=13 value="<?php echo $time; ?>" required>
							  <span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar" style='font-size:13px;'></span>
							  </span>
							</div>
				  		  </td>
						  <td width=12%><b>DO Number <a style="color:red">*</a></b></td>
	  					  <td width=23%><input type="text" name="do_number" size=26% id="do_number" required></td>
						  <td><button name="submit">Submit</button></td>
						</tr>			
						<input type="hidden" name="po_number" value="<?php echo $po_number; ?>" >
						<input type="hidden" name="sds_number" value="<?php echo $sds_number; ?>" >
						<input type="hidden" name="item_type" value="<?php echo $item_type; ?>" >
						<input type="hidden" name="item_unit" value="<?php echo $item_unit; ?>" >
				  </form>
				  
					<?php
					  }
					}
					?>
						
                  </table>
				  
				  <div class="box-header">
					<h3 class="box-title"><b>Delivery History</b></h3>
				  </div><!-- /.box-header -->
				  
				  <table id="example1" class="table table-bordered table-striped">
					  <tr>
					    <th align="middle" width=10%>Delivery Date</th>
						<th width=10%>Delivery Time</th>
					    <th width=12%>DO Number</th>
					    <th width=8%>Status</th>
						<th width=10%>Received/ Return Date</th>
						<th width=10%>Received/ Return Time</th>
					    <th>Remark</th>
					  </tr>					
				  <?php
				  $select_sdo = mysql_query("SELECT * FROM tb_supplier_delivery_order");
				  while($sdo=mysql_fetch_array($select_sdo))
				  {
				  ?>					  
					  <tr>
						<td><?php echo $sdo['do_date']; ?></td>
						<td><?php echo $sdo['do_time']; ?></td>
						<td><?php echo $sdo['do_number']; ?></td>
						<td><?php echo $sdo['do_status']; ?></td>
						<td><?php echo $sdo['received_returned_date']; ?></td>
						<td><?php echo $sdo['received_returned_time']; ?></td>
						<td><?php echo $sdo['remark']; ?></td>
					  </tr>
					<?php
				  }
				  ?>					
				  </table>
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
    <script type="text/javascript"><!-- 
	//Date range picker
			$('#reservation').datepicker({format: 'yyyy-mm-dd'});
	</script>

  </body>
</html>