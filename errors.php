<!-- jika param type error 1 form belum lengkap -->
<?php if (isset($_GET['error']) && $_GET['error'] == 1) { ?>
    <!-- echo  alert -->
    <div class='alert alert-danger alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h4><i class='icon fa fa-ban'></i> Gagal!</h4>
        Silahkan lengkapi form.
    </div>
<?php } ?>
<!-- jika param type error 2 username atau password salah -->
<?php if (isset($_GET['error']) && $_GET['error'] == 2) { ?>
   <div class='alert alert-danger alert-dismissible'>
      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
      <h4><i class='icon fa fa-ban'></i> Gagal!</h4>
      Username atau password salah.
    </div>
<?php } ?>
<!-- jika param type error 3 hak akses belum dipilih -->
<?php if (isset($_GET['error']) && $_GET['error'] == 3) { ?>
   <div class='alert alert-danger alert-dismissible'>
      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
      <h4><i class='icon fa fa-ban'></i> Gagal!</h4>
      Silahkan pilih hak akses.
    </div>
<?php } ?>
<!-- jika param type error 4 hak akses tidak ditemukan -->
<?php if (isset($_GET['error']) && $_GET['error'] == 4) { ?>
    <div class='alert alert-danger alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h4><i class='icon fa fa-ban'></i> Gagal!</h4>
        Hak akses tidak ditemukan.
    </div>
<?php } ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 5) { ?>
    <div class='alert alert-danger alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h4><i class='icon fa fa-ban'></i> Gagal!</h4>
        Data tidak ditemukan.
    </div>
<?php } ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 6) { ?>
    <div class='alert alert-danger alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h4><i class='icon fa fa-ban'></i> Gagal!</h4>
        Gagal mengirim email.
    </div>
<?php } ?>
<?php if (isset($_GET['error']) && $_GET['error'] == 7) { ?>
    <!-- echo  alert -->
    <div class='alert alert-danger alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h4><i class='icon fa fa-ban'></i> Gagal!</h4>
         Password tidak sama.
    </div>
<?php } ?>
<?php if (isset($_GET['error']) && $_GET['error'] == 8) { ?>
    <!-- echo  alert -->
    <div class='alert alert-danger alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h4><i class='icon fa fa-ban'></i> Gagal!</h4>
         Gagal mengubah password.
    </div>
<?php } ?>
<?php if(isset($_SESSION['errors'])) { ?>
    <div class='alert alert-danger alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h4><i class='icon fa fa-ban'></i> Gagal!</h4>
        <ul>
            <?php foreach($_SESSION['errors'] as $error) { ?>
                <li><?php echo $error; ?></li>
            <?php } ?>
        </ul>
    </div>
<?php 
    unset($_SESSION['errors']);
}
?>
