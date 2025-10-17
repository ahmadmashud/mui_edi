<?php
$minDate = mysqli_fetch_array(mysqli_query($conn, "SELECT MIN(sdo_date) as min_date FROM tb_supplier_delivery_order WHERE supplier_name='{$_SESSION['supplier']}'"));
$maxDate = mysqli_fetch_array(mysqli_query($conn, "SELECT MAX(sdo_date) as max_date FROM tb_supplier_delivery_order WHERE supplier_name='{$_SESSION['supplier']}'"));
?>

<form action="#popup" method="post" name="postform">
    <div class="table-responsive"> 
        <table class="table table-bordered table-striped">                  
            <tr>
                <td width="5%"><b>From</b></td>
                <td width="8%">
                    <div class="input-group">                                  
                        <input id="reservation1" type="text" name="tanggal_awal" value="<?php echo $minDate['min_date']; ?>">
                    </div>
                </td>
                <td width="5%"><b>Until</b></td>
                <td width="8%">
                    <div class="input-group">
                        <input id="reservation2" type="text" name="tanggal_akhir" value="<?php echo $maxDate['max_date']; ?>">
                    </div>
                </td>
                <td width="10%"><button type="submit" name="cari" id="cari">Search</button></td>
                <td></td>
            </tr>
        </table>
    </div>
</form>

<?php
if (isset($_POST['cari'])) {
    $startDate = $_POST['tanggal_awal'];
    $endDate = $_POST['tanggal_akhir'];
    
    if (empty($startDate) && empty($endDate)) {
        echo "<script>alert('Please choose date range first.')</script>";
    } else {
        echo "<i><b>Information : </b> Search result from <b>{$startDate}</b> until <b>{$endDate}</b></i>";
        // Add your search logic here
    }
}
?>