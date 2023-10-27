<!-- Sukses -->
<?php
if (isset($_GET['success']) && $_GET['success'] == 1) {
?>
    <div class='alert alert-success alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h4><i class='icon fa fa-check'></i> Sukses!</h4>
        Data berhasil disimpan.
    </div>
<?php } ?>

<?php
if (isset($_GET['success']) && $_GET['success'] == 2) {
?>
    <div class='alert alert-success alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h4><i class='icon fa fa-check'></i> Sukses!</h4>
        Data berhasil diubah.
    </div>
<?php } ?>

<?php
if (isset($_GET['success']) && $_GET['success'] == 3) {
?>
    <div class='alert alert-success alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h4><i class='icon fa fa-check'></i> Sukses!</h4>
        Data berhasil dihapus.
    </div>
<?php } ?>

<?php
if (isset($_GET['success']) && $_GET['success'] == 4) {
?>
    <div class='alert alert-success alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h4><i class='icon fa fa-check'></i> Sukses!</h4>
        Data berhasil masuk! <br>
        Loading...
    </div>
    <!-- script redirect otomatis -->
    <script type="text/javascript">
        setTimeout(function() {
            window.location.href = "index.php";
        }, 2000);
    </script>
<?php } ?>

<?php
if (isset($_GET['success']) && $_GET['success'] == 5) {
?>
    <div class='alert alert-success alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h4><i class='icon fa fa-check'></i> Sukses!</h4>
        Data berhasil keluar!
    </div>
<?php } ?>
<?php
if (isset($_GET['success']) && $_GET['success'] == 6) {
?>
    <div class='alert alert-success alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h4><i class='icon fa fa-check'></i> Sukses!</h4>
         Silahkan cek email inbox/spam.
    </div>
<?php } ?>
<?php
if (isset($_GET['success']) && $_GET['success'] == 7) {
?>
    <div class='alert alert-success alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h4><i class='icon fa fa-check'></i> Sukses!</h4>
         Mengubah password berhasil.
    </div>
<?php } ?>
<?php  if(isset($_SESSION['success'])) { ?>
    <div class='alert alert-success alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h4><i class='icon fa fa-check'></i> Sukses!</h4>
        <?php echo $_SESSION['success']; ?>
    </div>
<?php  unset($_SESSION['success']);} ?>
