<?php
$user_agent     =   $_SERVER['HTTP_USER_AGENT'];
function get_client_ip_env() 
{
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
	$ipaddress = getenv('HTTP_CLIENT_IP');
	else if(getenv('HTTP_X_FORWARDED_FOR'))
	$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if(getenv('HTTP_X_FORWARDED'))
	$ipaddress = getenv('HTTP_X_FORWARDED');
	else if(getenv('HTTP_FORWARDED_FOR'))
	$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if(getenv('HTTP_FORWARDED'))
	$ipaddress = getenv('HTTP_FORWARDED');
	else if(getenv('REMOTE_ADDR'))
	$ipaddress = getenv('REMOTE_ADDR');
	else
	$ipaddress = 'UNKNOWN IP Address';
	return $ipaddress;
}

function get_os()
{ 
    global $user_agent;
    $os_platform    =   "Unknown OS Platform";
    $daftar_os      =   array
	(
		'/windows nt 6.2/i'     =>  'Windows 8',
		'/windows nt 6.1/i'     =>  'Windows 7',
		'/windows nt 6.0/i'     =>  'Windows Vista',
		'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
		'/windows nt 5.1/i'     =>  'Windows XP',
		'/windows xp/i'         =>  'Windows XP',
		'/windows nt 5.0/i'     =>  'Windows 2000',
		'/windows me/i'         =>  'Windows ME',
		'/win98/i'              =>  'Windows 98',
		'/win95/i'              =>  'Windows 95',
		'/win16/i'              =>  'Windows 3.11',
		'/macintosh|mac os x/i' =>  'Mac OS X',
		'/mac_powerpc/i'        =>  'Mac OS 9',
		'/linux/i'              =>  'Linux',
		'/ubuntu/i'             =>  'Ubuntu',
		'/iphone/i'             =>  'iPhone',
		'/ipod/i'               =>  'iPod',
		'/ipad/i'               =>  'iPad',
		'/android/i'            =>  'Android',
		'/blackberry/i'         =>  'BlackBerry',
		'/webos/i'              =>  'Mobile'
    );

    foreach ($daftar_os as $regex => $value) 
	{ 
        if (preg_match($regex, $user_agent))
		{
            $os_platform    =   $value;
        }
    }   
    return $os_platform;
}

function getting_browser()
{
    global $user_agent;
	$browser        =   "Unknown Browser";
    $daftar_browser  =   array
	(
		'/msie/i'       =>  'Internet Explorer',
		'/firefox/i'    =>  'Firefox',
		'/safari/i'     =>  'Safari',
		'/chrome/i'     =>  'Chrome',
		'/opera/i'      =>  'Opera',
		'/netscape/i'   =>  'Netscape',
		'/maxthon/i'    =>  'Maxthon',
		'/konqueror/i'  =>  'Konqueror',
		'/mobile/i'     =>  'Handheld Browser'
	);

    foreach ($daftar_browser as $regex => $value) 
	{ 
        if (preg_match($regex, $user_agent)) 
		{
            $browser    =   $value;
        }
    }
    return $browser;
}
$operating_system   =   get_os();
$browser   			=   getting_browser();
$ip_address 		= get_client_ip_env();
$hostname			= gethostbyaddr($_SERVER['REMOTE_ADDR']);
?>

<?php
if(isset($_POST['submit']))
{
	include('../../koneksi.php');	
	$password_code		= $_POST['password_code'];
	$request_date		= $_POST['request_date'];
	$username			= $_POST['username'];
	$email				= $_POST['email'];
	$password_type		= $_POST['password_type'];

	$sql = mysql_query("SELECT * FROM tb_user WHERE username='$username'");
	if(mysql_num_rows($sql)==1)
	{
		$sql = mysql_query("SELECT * FROM tb_user WHERE username='$username' and email='$email'");
		if(mysql_num_rows($sql)==1)
		{
			$qry = mysql_fetch_array($sql);
			$input = mysql_query("INSERT INTO tb_ask_password VALUES('$password_code', '$request_date', '$username', '$email', '$password_type', '$ip_address', '$hostname', '$operating_system', '$browser')") or die(mysql_error());
			echo"<script>alert('Thank you for requesting forgotten password submission. Your request will be processed immediatelly and we will send you a password information to your email as soon as possible.')</script>";
			echo"<script>onclick=location.href='../../index.php'</script>";
		}
			else
		{	
			echo"<script>alert('Sorry, email never registered.')</script>";
			echo"<script>onclick=location.href='../../forgotpass.php'</script>";
		}
	}
		else
	{	
		echo"<script>alert('Sorry, username never registered.')</script>";
		echo"<script>onclick=location.href='../../forgotpass.php'</script>";
	}
}
?>
