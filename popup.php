
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Catatan Lamers</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  </head>

  <body>
    <div class="container">
      <div class="row"> 
        <table class="table table-bordered">
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Umur</th>
            <th>Opsi</th>
          </tr>
          <?php
           include "koneksi.php";
            $sql = mysql_query("SELECT * FROM tb_supplier_delivery_schedule WHERE sds_status = 'OPEN'");
            $no = 1;
			while ($tampil = mysql_fetch_array($sql)){
			?>
                  <tr>     
                  <td><?php echo $no; ?></td>
                  <td><?php echo $tampil['supplier']; ?></td>
                  <td><?php echo $tampil['sds_number']; ?></td>
                  <?php echo "<td><a data-id=".$tampil['sds_number']." title='Add this item' class='open-AddBookDialog btn btn-primary' href='#addBookDialog'>test</a></td>"; ?>
				  
                  </tr>
            <?php 
            $no++; 
            } 
              
            ?>

        </table>
      </div>
    </div>

<div class="modal fade" id="addBookDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <input type="text" name="bookId" id="bookId" value="" />
		
		<?php
		$sql = mysql_query("SELECT * FROM tb_supplier_delivery_schedule WHERE sds_number = bookId");
        while ($result = mysql_fetch_array($sql)){
		?>
        <form>
            <input type="hidden" name="id" value="<?php echo $result['sds_number']; ?>">
            <div class="form-group">
                <label>Nama Siswa</label>
                <input type="text" name="nama" value="<?php echo $result['sds_number']; ?>">
            </div>
            <div class="form-group">
                <label>Umur</label>
                <input type="text" name="umur" value="<?php echo $result['sds_date']; ?>">
            </div>
        </form>     
        <?php }
		?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script type="text/javascript">
$(document).on("click", ".open-AddBookDialog", function (e) {

	e.preventDefault();

	var _self = $(this);

	var myBookId = _self.data('id');
	$("#bookId").val(myBookId);

	$(_self.attr('href')).modal('show');
});
  </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>
