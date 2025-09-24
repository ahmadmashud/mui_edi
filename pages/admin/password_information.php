<?php
session_start();
if(!isset($_SESSION['username'])){
    die("<script>alert('<b>Oops!</b> Access Failed.
		<p>System Logout. You must login again.</p>')</script>
		<script> onclick=location.href='../../index.php'</script>");
}
if($_SESSION['account_status']!="Administrator"){
    die("<script>alert('<b>Oops!</b> Access Failed.
		<p>You are not Administrator.</p>')</script>
		<script> onclick=location.href='../../index.php''</script>");
}

$timeout = 60;
$logout_redirect_url = "../../index.php"; 
 
$timeout = $timeout * 60; 
if (isset($_SESSION['start_time'])) {
    $elapsed_time = time() - $_SESSION['start_time'];
    if ($elapsed_time >= $timeout) {
        session_destroy();
        echo "<script>alert('This session has timeout!'); window.location = '$logout_redirect_url'</script>";
    }
}
$_SESSION['start_time'] = time();
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
    <!-- DATA TABLES -->
    <link href="../../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="../../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

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
                     <a href="../login/act-logout.php?username=<?=$_SESSION['username'];?>&supplier=<?=$_SESSION['supplier'];?>" class="btn btn-default btn-flat">Logout</a>
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
              <a href="../../home_admin.php">
                <i class="fa fa-home"></i> <span>Home</span> 
              </a>
            </li>
            <li>
              <a href="po_product.php">
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
              <a href="qc_product.php">
                <i class="fa fa-check-square-o"></i> <span>Quality Check</span>
              </a>
            </li>
			<li>
              <a href="summary_product.php">
                <i class="fa fa-calculator"></i> <span>Summary</span> 
              </a>
            </li>
			<li>
              <a href="transaction_history.php">
                <i class="fa fa-history"></i> <span>Transaction History</span> 
              </a>
            </li>
			<li>
              <a href="user_information.php">
                <i class="fa fa-user"></i> <span>User Information</span> 
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
            <li><a href="../../home_admin.php"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="active">Ask Password</li>
          </ol>
        </section>

       <!-- Main content -->
		 <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">              	
                <div class="box-header">
                  <h3 class="box-title"><b>Ask Password</b></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Password Code</th>
                        <th>Request Date</th>
						<th>Username</th>
                        <th>Email</th>
                        <th>Password Type</th>
						<th>IP Address</th>
						<th>Computer Name</th>
						<th>Operating System</th>
						<th>Browser</th>
                      </tr>
                    </thead>
                    <tbody>
						<?php
							include "../../koneksi.php";								
							$tampilPeg=mysql_query("SELECT * FROM tb_ask_password ORDER BY password_code");
							while($peg=mysql_fetch_array($tampilPeg)){								
						?>          
                      <tr>
                        <td><?php echo $peg['password_code'];?></td>
                        <td><?php echo $peg['request_date'];?></td>
						<td><?php echo $peg['username'];?></td>
                        <td><?php echo $peg['email'];?></td>
                        <td><?php echo $peg['password_type'];?></td>
						<td><?php echo $peg['ip_address'];?></td>
						<td><?php echo $peg['hostname'];?></td>
						<td><?php echo $peg['operating_system'];?></td>
						<td><?php echo $peg['browser'];?></td>
						<?php } ?>
					  </tr>
                    </tbody>
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

  </body>
</html>