<html>
<head>
<title>MUI-Electronic Data Interchange</title>
<style>
*, *:before, *:after {
  box-sizing: border-box;
}

body {
  font-family: calibri;
}

a {
  text-decoration: none;
  color: #FFF;
  font-size: 16px;
}
a:hover {
  color: #00ffff;
}

.form {
  background: rgba(255, 255, 255, 0.01);
  padding: 30px;
  width: 350px;
  margin: 50px 0px 0px 500px;
  border: 1px solid white;
}

.form:hover {
	box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 1), 0 6px 20px 0 rgba(0, 0, 0, 0.2);
}

input[type=text],input[type=password] {
    width: 100%;
    padding: 15px;
    border: none;
    background: rgba(255, 255, 255, 0.2);
	color: white;
	font-size: 16px;	
}

<!-- border used
  input[type=text],{
  background: rgba(255, 255, 255, 0.2);
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border: none;
  border-bottom: 2px solid blue;
}-->

.button {
    background-color: rgb(0, 191, 255, 0.3);
	border:none;
    color: white;
    padding: 13px;
    text-align: center;
    font-size: 20px;
	font-family: calibri;
	width: 100%;
}

/* The container */
.container {
    display: block;
    position: relative;
    cursor: pointer;
    font-size: 16px;
	font-family: calibri;
}

/* Hide the browser's default radio button */
.container input {
    position: absolute;
    opacity: 0;
}

/* Create a custom radio button */
.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 20px;
    width: 20px;
    background-color: #eee;
    border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container input:checked ~ .checkmark {
    background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the indicator (dot/circle) when checked */
.container input:checked ~ .checkmark:after {
    display: block;
}

/* Style the indicator (dot/circle) */
.container .checkmark:after {
 	top: 7px;
	left: 7px;
	width: 7px;
	height: 7px;
	border-radius: 50%;
	background: white;
}

</style>
</head>

<div class="tab-content">
  <div class="form">
  <p style ="color:white; font-size:28px;">Login</p>
    <form action="index.php?page=act-login&op=in" method="POST">

      <input type="text" placeholder="username" name="username" required><p></p>
	  <input type="password" placeholder="password" name="password" required><p></p>
	  <button type="submit" name="login" class="button button-block">Login</button>
	  
	   <p align="right"><a href="resetpass.php">Reset Password</a><br>
       <a href="forgotpass.php" >Forgot Password</a></p>	   	 
	  
	  <!--<div class="container">
	    <label style="margin-left:9%; color: #808080;">Reset Password
		  <input type="radio" name="reset_password" value="reset_password" onclick='window.location.assign("/interchange/resetpass.php")'/>
		  <span class="checkmark"></span>
	    </label>
		
	  <div class="container">
	    <label style="margin-left:9%; color: #808080;">Forgot Password
		  <input type="radio" name="forgot_password" value="forgot_password" onclick='window.location.assign("/interchange/forgotpass.php")'/>
		  <span class="checkmark"></span>
	    </label>	 
      </div>
	  </div>-->
	  
	</form> 	
  </div>	
</div>
</html>