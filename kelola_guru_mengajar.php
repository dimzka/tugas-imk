<?php 
    if(isset($_GET['id_guru'])){
        $id_guru = $_GET['id_guru'];
        $query = mysqli_query($koneksi, "SELECT * FROM guru WHERE id_guru='$id_guru'");
        $data = mysqli_fetch_array($query);
        if($data == null){
            echo "<script>
                window.location.href='index.php?page=kelola_kelas&error=5';
            </script>";  
        }
       
    }else{
        echo "<script>
            window.location.href='index.php?page=kelola_kelas&error=5';
        </script>";
    }

?>
<section class="content-header">
   <h1>
      Kelola Guru Mengajar
      <small>SMK Negeri 11 Garut</small>
   </h1>
</section>
<section class="content">
   <div class="box">
      <div class="box-header with-border">
         <h3 class="box-title">Daftar Guru Mengajar</h3>
         <div class="box-tools pull-right">
            <a href="index.php?page=kelola_guru_mengajar_tambah&id_guru=<?= $id_guru ?>" class="btn btn-primary btn-sm"


               data-toggle="tooltip" data-placement="top" data-original-title="
               Tambah Mata Pelajaran
               " style="margin-right: 5px;">

               <i class="fa fa-plus"></i>&nbsp; Tambah Mata Pelajaran
            </a>
         </div>
      </div>
      <div class="box-body">
         <div class="row" style="margin-bottom: 10px">
            <div class="col-md-12">
               <?php 
                  include_once 'errors.php';
                  include_once 'success.php';
               ?>
            </div>
            <!-- search -->
            <div class="col-md-4 col-md-offset-8">
               <form action="index.php" method="GET">
                  <div class="input-group">
                     <input type="hidden" name="page" value="kelola_guru_mengajar_tambah">
                        <input type="hidden" name="id_guru" value="<?= $id_guru ?>">  
                     <input type="text"  data-toggle="tooltip" data-placement="top" data-original-title="
                        Cari Mata Pelajaran "
                         name="q" class="form-control" placeholder="Cari Mata Pelajaran" value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>">
                     <span class="input-group-btn">
                        <button type="submit" 
        
                        class="btn btn-primary btn-flat"><i class="fa fa-search"></i></button>
                     </span>
                  </div>
               </form>
            </div>
         </div>
         <div class="box-body table-responsive">
         <table class="table table-bordered table-striped">
            <thead>
               <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Aksi</th>
               </tr>
            </thead>
            <tbody>
               <?php 
                  $no = 1;
                  $q = isset($_GET['q']) ? $_GET['q'] : '';
                  $query = mysqli_query($koneksi, "SELECT matapelajaran.nama as nama_matapelajaran, matapelajaran.kode_matapelajaran, guru.nama as nama_guru, guru.id_guru, mengajar.kode_mengajar from mengajar INNER JOIN matapelajaran ON mengajar.kode_matapelajaran=matapelajaran.kode_matapelajaran INNER JOIN guru ON mengajar.id_guru=guru.id_guru WHERE mengajar.id_guru='$id_guru' AND (matapelajaran.nama LIKE '%$q%' OR  matapelajaran.kode_matapelajaran LIKE '%$q%') ORDER BY matapelajaran.nama ASC");

                 while($result = mysqli_fetch_array($query)){
      
               ?>
               <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $result['nama_matapelajaran'] ?></td>
                  <td>
                     <a 
                     onclick="return swal({
                        title: 'Apakah Anda Yakin?',
                        text: 'Anda akan menghapus data ini!',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Tidak, Batalkan!',
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger',
                        buttonsStyling: false
                     }, function(){
                        window.location.href='index.php?page=kelola_guru_mengajar_hapus&kode_mengajar=<?= $result['kode_mengajar'] ?>&id_guru=<?= $id_guru ?>';
                     })"
                        data-toggle="tooltip" data-placement="top"
                     class="btn btn-danger btn-sm" title="Hapus Data">
                        <i class="fa fa-trash"></i>
                     </a>
                  </td>
               </tr>
               <?php } ?>
               <?php 
                  if (mysqli_num_rows($query) == 0) {
               ?>
               <tr>
                  <td colspan="3" align="center">Data Tidak Ditemukan</td>
               </tr>
               <?php } ?>

            </tbody>
         </table>
      </div>
      <div class="box-footer">
            <a href="index.php?page=kelola_guru" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
   </div>
</section>