<div class="login-box">
<?php
include "koneksi.php";
session_start();

$user_agent = $_SERVER['HTTP_USER_AGENT'];

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
    $os_platform = "Unknown OS Platform";
    $daftar_os = array(
        '/windows nt 10.0/i'    =>  'Windows 10',
        '/windows nt 6.3/i'     =>  'Windows 8.1',
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

    foreach ($daftar_os as $regex => $value) { 
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }   
    return $os_platform;
}

function getting_browser()
{
    global $user_agent;
    $browser = "Unknown Browser";
    $daftar_browser = array(
        '/msie|trident/i'       =>  'Internet Explorer',
        '/edg/i'                =>  'Microsoft Edge',
        '/firefox/i'            =>  'Firefox',
        '/safari/i'             =>  'Safari',
        '/chrome/i'             =>  'Chrome',
        '/opera/i'              =>  'Opera',
        '/netscape/i'           =>  'Netscape',
        '/maxthon/i'            =>  'Maxthon',
        '/konqueror/i'          =>  'Konqueror',
        '/mobile/i'             =>  'Handheld Browser'
    );

    foreach ($daftar_browser as $regex => $value) { 
        if (preg_match($regex, $user_agent)) {
            $browser = $value;
        }
    }
    return $browser;
}

$operating_system = get_os();
$browser = getting_browser();
$ip_address = get_client_ip_env();
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

// Menggunakan MySQLi untuk koneksi database
$query = "SELECT max(date_logout) as maxKode FROM tb_log_history";
$hasil = mysqli_query($conn, $query);
$data = mysqli_fetch_array($hasil);
$date_logout = $data['maxKode'];

$noUrut = (int) substr($date_logout, 4, 6);
$noUrut++;
$char = "LOG-";
$newID = $char . sprintf("%06s", $noUrut);
?>

<?php
error_reporting(0); 
date_default_timezone_set("Asia/Jakarta");
$jam = date('d/m/Y H:i:s');
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$op = $_GET['op'] ?? '';

if($op == "in") {
    // Gunakan prepared statements untuk keamanan
    $sql = mysqli_prepare($conn, "SELECT * FROM tb_user WHERE username = ?");
    mysqli_stmt_bind_param($sql, "s", $username);
    mysqli_stmt_execute($sql);
    $result = mysqli_stmt_get_result($sql);
    
    if(mysqli_num_rows($result) == 1) {
        $sql1 = mysqli_prepare($conn, "SELECT * FROM tb_user WHERE username = ? AND password = ?");
        mysqli_stmt_bind_param($sql1, "ss", $username, $password);
        mysqli_stmt_execute($sql1);
        $result1 = mysqli_stmt_get_result($sql1);
        
        if(mysqli_num_rows($result1) == 1) {
            $qry = mysqli_fetch_array($result1, MYSQLI_ASSOC);
            
            $_SESSION['login_id'] = $qry['login_id'];
            $_SESSION['username'] = $qry['username'];
            $_SESSION['password'] = $qry['password'];
            $_SESSION['account_status'] = $qry['account_status'];
            $_SESSION['full_name'] = $qry['full_name'];
            $_SESSION['gender'] = $qry['gender'];
            $_SESSION['section'] = $qry['section'];
            $_SESSION['position'] = $qry['position'];
            $_SESSION['supplier'] = $qry['supplier'];
            $_SESSION['email'] = $qry['email'];
            $_SESSION['material_type'] = $qry['material_type'];
            $_SESSION['activating_status'] = $qry['activating_status'];
            
            // Insert log history dengan prepared statement
            $stmt = mysqli_prepare($conn, "INSERT INTO tb_log_history (date_login, ip_address, hostname, operating_system, browser, username, account_status, section, supplier, date_logout) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssssssssss", $jam, $ip_address, $hostname, $operating_system, $browser, $username, $qry['account_status'], $qry['section'], $qry['supplier'], $newID);
            mysqli_stmt_execute($stmt);
    
            if($qry['activating_status'] == "N") {
                echo "<div class='register-logo'><b>Oops!</b> User Not Active.</div>    
                <div class='register-box-body'>
                    <p>Please contact Administrator.</p>
                    <div class='row'>
                        <div class='col-xs-8'></div>
                        <div class='col-xs-4'>
                            <button type='button' onclick='location.href=\"index.php\"' class='btn btn-block btn-warning'>Back</button>
                        </div>
                    </div>
                </div>";
            } else {
                // Redirect berdasarkan role dan section
                $redirectUrls = [
                    'Administrator' => 'home_admin.php',
                    'Supplier_Marketing_NonChemical' => 'home_marketing_product.php',
                    'Supplier_Marketing_Chemical' => 'home_marketing_chemical.php',
                    'Supplier_Delivery_NonChemical' => 'home_delivery_product.php',
                    'Supplier_Delivery_Chemical' => 'home_delivery_chemical.php',
                    'Supplier_Warehouse_NonChemical' => 'home_warehouse_product.php',
                    'Supplier_Warehouse_Chemical' => 'home_warehouse_chemical.php',
                    'Supplier_Engineering' => 'home_engineering.php',
                    'Project Control Officer_Project Control' => 'home_uploader.php',
                    '_Quality' => 'home_quality_product.php'
                ];
                
                $key = '';
                if ($qry['account_status'] == "Supplier") {
                    $key = 'Supplier_' . $qry['section'] . '_' . ($qry['material_type'] == "Chemical" ? 'Chemical' : 'NonChemical');
                } else if ($qry['account_status'] == "Project Control Officer") {
                    $key = 'Project Control Officer_Project Control';
                } else if ($qry['section'] == "Quality") {
                    $key = '_Quality';
                } else {
                    $key = $qry['account_status'];
                }
                
                if (isset($redirectUrls[$key])) {
                    header("location: " . $redirectUrls[$key]);
                    exit();
                } else {
                    echo "<script>alert('Sorry, no access defined for this role.')</script>";
                    echo "<script>location.href='index.php';</script>";
                }
            }
        } else {
            echo "<script>alert('Sorry, password incorrect.')</script>";
            echo "<script>location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Sorry, username never registered.')</script>";
        echo "<script>location.href='index.php';</script>";
    }
} else if($op == "out") {        
    session_unset();
    session_destroy();
    header("location:index.php");
    exit();
}
?>
</div>