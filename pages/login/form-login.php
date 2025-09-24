<html>
	<head>
		<title>MUI-Electronic Data Interchange</title>
		<meta name="viewport" content="width=device-width , initial-scale=1">
		<style>
		*, *:before, *:after 
		{
			box-sizing: border-box;
		}

		body 
		{
			font-family: calibri;
		}

		.form 
		{
			width: 300px;
			height: auto;
			margin: 0 auto;
			margin-top: 130px;
			background: rgba(255, 255, 255, 0.01);
			border: 1px solid white;
			/*background-color: #f0f0f0;
			box-shadow: 2px 2px 16px 0px #757575;*/
			padding: 9px 20px;
		}

		.form:hover 
		{
			box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 1), 0 6px 20px 0 rgba(0, 0, 0, 0.2);
		}

		::-webkit-input-placeholder { /* Chrome/Opera/Safari */color: white;}

		input[type=text],input[type=password] 
		{
			width: 100%;
			padding: 13px 10px;
			margin: 5px 0px;
			background: rgba(255, 255, 255, 0.2);
			border:1px solid;
			color: #fff;
			font-size: 16px;
			/*background-color: #dbdbdb;
			border: 3px solid #dbdbdb;
			color: #757575;*/
			transition: all 0.7s;
		}

		.button 
		{
			width: 100%;
			font-size: 19px;
			color: #f5f5f5;
			padding: 12px;
			margin: 5px 0;
			background-color: hsl(195, 100%, 50%);
			/*background-color: #004d40;*/
			border: none;
			transition: all 0.4s;
		}

		.form p a 
		{
			text-decoration: none;
			font-size: 14px;
			color: #fff;
			margin-right: 8px;
		}

		.center p a:hover
		{
			color: #00ffff;
		}

		@media screen and (min-width:1500px) 
		{
			.form 
			{
				width: 350px;
			}
		}

		@media screen and (max-width:900px) 
		{
			.button 
			{
				width: 100%;
			}

			.input[type=text],input[type=password] 
			{
				font-size: 16px;
				width: 100%;
				padding: 13px 3%;
			}

			.form 
			{
				width: 230px;
			}

			.form p 
			{
				font-size: 12px;
			}
		}

		@media screen and (max-width:350px) 
		{
			.form 
			{
				padding: 20px;
				width: 75%;
			}
		}
		</style>
	</head>
	<body>
		<div class="tab-content">
			<div class="form">
				<p style ="color:white; font-size:28px;">Login</p>
				<form action="index.php?page=act-login&op=in" method="POST">
					<input type="text" placeholder="username" name="username" required><p></p>
					<input type="password" placeholder="password" name="password" required><p></p>
					<button type="submit" name="login" class="button button-block">Login</button>
					<p align="right"><a href="resetpass.php">Reset Password</a><br>
					<a href="forgotpass.php" >Forgot Password</a></p>	   	 	 	  
				</form> 	
			</div>	
		</div>
	</body>
</html>