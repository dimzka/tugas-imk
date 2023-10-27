<?php
  $id_guru = $_SESSION['id'];
?>
<section class="content-header">
   <h1>
       Kelola Kehadiran
      <small>SMK Negeri 11 Garut</small>
   </h1>

</section>
<section class="content">
   <div class="box">
      <div class="box-header with-border">
         <h3 class="box-title">Daftar Kelas</h3>
        
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
            <div class="col-md-3 col-md-offset-9">
               <form action="index.php?page=kelola_kehadiran_siswa_mapel&q=<?= isset($_GET['q']) ? $_GET['q'] : '' ?>&halaman=<?= isset($_GET['halaman']) ? $_GET['halaman'] : '' ?>" method="get">
                  <div class="input-group">
                        <input type="hidden" name="page" value="kelola_kehadiran_siswa_mapel">
                     <input type="text"  data-toggle="tooltip" data-placement="top" data-original-title="
                        Untuk mencari kelas, masukkan nama kelas, jurusan."
                         name="q" class="form-control" placeholder="Cari Kelas" value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>">
                     <span class="input-group-btn">
                        <button type="submit" 
        
                        class="btn btn-primary btn-flat"><i class="fa fa-search"></i></button>
                     </span>
                  </div>
               </form>
            </div>
         </div>
         <div class="box-body table-responsive">
         <table class="table table-bordered ">
            <thead>
               <tr>
                  <th>No</th>
                  <th>Kelas</th>
                  <th>Jurusan</th>
                  <th style="width: 100px">Tahun Ajaran</th>
                  <th>Aksi</th>
               </tr>
            </thead>
            <tbody>
                  <?php 
                     $q = isset($_GET['q']) ? $_GET['q'] : '';
                     $sql = "
                     SELECT 
                     kelas.kode_kelas, kelas.tingkat as nama_kelas, 
                     kelas.tahun_ajaran,
                     kelas.tingkat,
                     kelas.jurusan,
                     kelas.kelas,
                     jadwal.id_jadwal
                     from jadwal 
                     inner join kelas on jadwal.kode_kelas = kelas.kode_kelas
                     inner join mengajar on jadwal.kode_mengajar = mengajar.kode_mengajar
                     inner join guru on mengajar.id_guru = guru.id_guru
                     where mengajar.id_guru = '$id_guru'
                           AND kelas.tahun_ajaran like '%$config_tahun_ajaran_aktif%'
                           AND (kelas.tingkat like '%$q%' OR kelas.jurusan like '%$q%'  OR CONCAT(kelas.tingkat, ' ', kelas.jurusan, ' ', kelas.kelas) like '%$q%')
                     
                     ";
                     $query_kelas =mysqli_query($koneksi, $sql);
                     $countData = mysqli_num_rows($query_kelas);
                     $no = 1;
                     while ($result_kelas = mysqli_fetch_array($query_kelas)) {
                        $kode_kelas = $result_kelas['kode_kelas'];
                        $nama_kelas = $result_kelas['tingkat'] ." ".$result_kelas['jurusan']." ".$result_kelas['kelas'];
                        $jurusan = $result_kelas['jurusan'];
                        $tahun_ajaran = $result_kelas['tahun_ajaran'];
                        $id_jadwal = $result_kelas['id_jadwal'];
                  ?>
               <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $nama_kelas ?></td>
                  <td><?= $jurusan ?></td>
                  <td><?= $tahun_ajaran ?></td>
                  <td>
                        <a href="index.php?page=kelola_kehadiran_siswa_mapel_lihat&id_jadwal=<?= $id_jadwal ?>" class="btn btn-info btn-sm"
                            data-toggle="tooltip" data-placement="top" title="Lihat Untuk Kelola Kehadiran"><i class="fa fa-book"></i> Lihat Kehadiran </a>
                  </td>
                
               </tr>
               <?php } ?>
               <?php 
                  if ($countData == 0) {
                     echo "<tr><td colspan='7' class='text-center'>Data tidak ditemukan</td></tr>";
                  }
               ?>
            </tbody>
         </table>
      
      </div>
      
   </div>
</section>