<?php
ob_start();
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>MUI-Electronic Data Interchange</title>
<link rel="shortcut icon" href="favicon.ico">
<style>
body, html {
    height: 100%;
    margin: 0;
}

.hero-image {
  background-image: url("dist/img/building.png");
  height: 100%;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
}

.hero-text {
  text-align: left;
  position: relative;
  left: 25%;
  transform: translate(-50%, -50%);
  color: white;
  background: rgb (191, 191, 191, 0.9);
}

.hero-text button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 10px 25px;
  color: black;
  background-color: #ddd;
  text-align: center;
  cursor: pointer;
}

.hero-text button:hover {
  background-color: #555;
  color: white;
}

<!--div.transbox {
  position: absolute;
  margin-left: 20px;
  margin-right: 50%;
  margin-top: 75px;
  width: 400px;
}-->

</style>
<Script> window.history.forward(1);</script>
</head>
<body>

<div class="hero-image">		
	<div class="transbox">
    <?php
				$page = (isset($_GET['page']))? $_GET['page'] : "main";
				switch ($page) {
					case 'act-login': include "pages/login/act-login.php"; break;
					default : include 'pages/login/form-login.php';	
				}
			?>
	</div>
</div>

</body>
</html>
