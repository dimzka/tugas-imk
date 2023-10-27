<?php 
  $total_siswa_query = mysqli_query($koneksi, "SELECT COUNT(nis) AS total_siswa FROM siswa");
  $resultTotalSiswa = mysqli_fetch_array($total_siswa_query);
  $total_siswa = $resultTotalSiswa['total_siswa'];
  $total_guru_query = mysqli_query($koneksi, "SELECT COUNT(nip) AS total_guru FROM guru");
  $resultTotalGuru = mysqli_fetch_array($total_guru_query);
  $total_guru = $resultTotalGuru['total_guru'];
  $total_kelas_query = mysqli_query($koneksi, "SELECT COUNT(kode_kelas) AS total_kelas FROM kelas");
  $resultTotalKelas = mysqli_fetch_array($total_kelas_query);
  $total_kelas = $resultTotalKelas['total_kelas'];
  $total_mapel_query = mysqli_query($koneksi, "SELECT COUNT(kode_matapelajaran) AS total_mapel FROM matapelajaran");
  $resultTotalMapel = mysqli_fetch_array($total_mapel_query);
  $total_mapel = $resultTotalMapel['total_mapel'];

?>
   <section class="content-header">
      <h1>
         Dashboard
         <small>SMK Negeri 11 Garut</small>
      </h1>
     
   </section>
   <section class="content">
   <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?= number_format($total_siswa) ?></h3>

              <p>Total Siswa</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>

          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?= number_format($total_guru) ?></h3>

              <p>Total Guru
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
    
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?= number_format($total_kelas) ?></h3>

              <p>Total Kelas</p>
            </div>
            <div class="icon">
              <i class="fa fa-building"></i>
            </div>
        
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?= number_format($total_mapel) ?></h3>

              <p>Total Mata Pelajaran</p>
            </div>
            <div class="icon">
              <i class="fa fa-book"></i>
            </div>
        
          </div>
        </div>
        <!-- ./col -->
      </div>
   </section>
