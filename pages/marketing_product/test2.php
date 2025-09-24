<?php include "rentaldetails.php";
include "koneksi.php";

if(mysql_num_rows($result)== 0){
    $dispNone = "display:none";
}else{
    $dispNone = "display:block";
}

?>


<table style="width:87%;"  style="<?=$dispNone?>">
    <tr class="spaces">
        <th>S.No.</th>
        <th style="width:20%;">Rent Earned</th>
        <th>House</th>
        <th>Address of Property</th>
    </tr>
    <?php include "rentaldetails.php";
        while($row = mysql_fetch_array($result))
        {?>
    <tr>
        <td>
            <?php echo $row['house_details_id'];?>
        </td>
        <td>
            <?php echo $row['rental_annual_rent'];?>
        </td>
        <td>
            <?php echo $row['rental_tax_paid'];?>
        </td>
        <td>
            <?php echo $row['rental_town'];?>
        </td>
        <td style="width:21%;"><a class="button add" onClick="document.location.href='income_tax.php'">Edit Details</a></td>
        <td style="width:21%;"><a class="buttons delete" href="deleterental.php?id=<?php echo $row['house_details_id'];?>" onclick="return confirm('Are you sure to delete');" class="table-icon delete">Delete Property</a></td>
        <td></td>
    </tr>
    <?php
     }
    ?>
</table>