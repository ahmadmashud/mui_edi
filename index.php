<?php
ob_start();
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>MUI-Electronic Data Interchange</title>
<link rel="shortcut icon" href="favicon.ico">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body, html {
    height: 100%;
	margin: 0;
}

.hero-image {
  width: 100%;
  height: 100vh;
  background-image: url("dist/img/Background2.png");
  background-size: cover;
  background-repeat: no-repeat;
  position: absolute;
}

.logo-image {
  position: absolute;
  margin: 0 0 98px 15px;
}

@media screen and (max-width:900px) {
  #hero-image {
    background-size: 100% 100%;
  }
}

</style>
<script> window.history.forward(1);</script>
</head>

<body>

<div class="hero-image">

  <a target="_blank" href="http://ptmui.co.id"><img src="dist/img/logo-white.png" alt="logo-image" class="logo-image"></a>

  <div class="transbox">
    <?php
	  $page = (isset($_GET['page']))? $_GET['page'] : "main";
	  switch ($page) 
	  {
	  case 'act-login': include "pages/login/act-login.php"; break;
	  default : include 'pages/login/form-login.php';	
	  }
	?>
  </div>
  
</div>

</body>
</html>
