<?php 
    if(isset($_GET['kode_kelas'])){
        $kode_kelas = $_GET['kode_kelas'];
        $query = mysqli_query($koneksi, "SELECT kelas.tingkat, kelas.jurusan, kelas.tahun_ajaran, kelas.kelas, kelas.kode_kelas as kode_kelas FROM kelas   WHERE kelas.kode_kelas='$kode_kelas'");
        $data = mysqli_fetch_array($query);
        if($data == null){
            echo "<script>
                window.location.href='index.php?page=kelola_kelas&error=5';
            </script>";  
        }
        $nama = $data['tingkat']." ".$data['jurusan']." ".$data['kelas']." - ".$data['tahun_ajaran'];
        
    }else{
        echo "<script>
            window.location.href='index.php?page=kelola_kelas&error=5';
        </script>";
    }

  $total_siswa_query = mysqli_query($koneksi, "SELECT COUNT(*) AS total_siswa from kelassiswa WHERE kode_kelas='$kode_kelas'");
  $resultTotalSiswa = mysqli_fetch_array($total_siswa_query);
  $total_kelas_siswa = $resultTotalSiswa['total_siswa'];
?>
<section class="content-header">
   <h1>
      Kelola Kelas Siswa
      <small>SMK Negeri 11 Garut</small>
   </h1>
</section>
<section class="content">
   <div class="box">
      <div class="box-header with-border">
         <h3 class="box-title">Daftar Kelas Siswa</h3>
         <div class="box-tools pull-right">
            <a href="index.php?page=kelola_kelas_siswa_tambah&kode_kelas=<?= $kode_kelas ?>" class="btn btn-primary btn-sm"


               data-toggle="tooltip" data-placement="top" data-original-title="
               Tambah Siswa Baru
               " style="margin-right: 5px;">

               <i class="fa fa-plus"></i>&nbsp; Tambah Anggota Siswa
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
                     <input type="hidden" name="page" value="kelola_kelas_siswa">
                        <input type="hidden" name="kode_kelas" value="<?= $kode_kelas ?>">  
                     <input type="text"  data-toggle="tooltip" data-placement="top" data-original-title="
                        Untuk mencari kelas_siswa, masukkan nama kelas_siswa"
                         name="q" class="form-control" placeholder="Cari Siswa" value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>">
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
                  <th>NIS</th>
                  <th>Nama</th>
                  <th>Jenis Kelamin</th>
                  <th>Aksi</th>
               </tr>
            </thead>
            <tbody>
               <?php 
                  $no = 1;
                  $q = isset($_GET['q']) ? $_GET['q'] : '';
                  $query = mysqli_query($koneksi, "SELECT siswa.nis from kelassiswa INNER JOIN siswa ON kelassiswa.nis=siswa.nis WHERE kelassiswa.kode_kelas='$kode_kelas' AND (siswa.nama LIKE '%$q%' OR siswa.nis LIKE '%$q%')");
                  $kelas_siswa = mysqli_query($koneksi, "SELECT siswa.nama, siswa.nis, siswa.jenis_kelamin, kelassiswa.kode_kelas from kelassiswa INNER JOIN siswa ON kelassiswa.nis=siswa.nis WHERE kelassiswa.kode_kelas='$kode_kelas' AND (siswa.nama LIKE '%$q%' OR  siswa.nis LIKE '%$q%') ORDER BY siswa.nama ASC");
                  $countData = mysqli_num_rows($query);
                  $arrayKelasSiswa = mysqli_fetch_all($kelas_siswa, MYSQLI_ASSOC);
                    foreach ($arrayKelasSiswa as $result){
      
               ?>
               <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $result['nis'] ?></td>
                  <td><?= $result['nama'] ?></td>
                  <td><?= $result['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
             

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
                        window.location.href='index.php?page=kelola_kelas_siswa_hapus&nis=<?= $result['nis'] ?>&kode_kelas=<?= $result['kode_kelas'] ?> '
                     })"

               
                        data-toggle="tooltip" data-placement="top"
                     
                     class="btn btn-danger btn-sm" title="Hapus Siswa">
                        <i class="fa fa-trash"></i>
                     </a>
                  </td>
               </tr>
               <?php } ?>
               <?php 
                  if ($countData == 0) {
               ?>
               <tr>
                  <td colspan="5" align="center">Data Tidak Ditemukan</td>
               </tr>
               <?php } ?>

            </tbody>
         </table>
      </div>
      <div class="box-footer">
            <a href="index.php?page=kelola_kelas" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
   </div>
</section>