<?php 
    $id_guru = $_SESSION['id'];
    $diantara = explode("/", $config_tahun_ajaran);
    $tahun_ajaran_awal = $diantara[0];
    $tahun_ajaran_akhir = $diantara[1];
    $query = mysqli_query($koneksi, "SELECT Count(DISTINCT(kelas.kode_kelas)) as total_kelas FROM jadwal inner join kelas on kelas.kode_kelas=jadwal.kode_kelas INNER join mengajar on mengajar.kode_mengajar=jadwal.kode_mengajar WHERE kelas.tahun_ajaran like '%$config_tahun_ajaran_aktif%' AND mengajar.id_guru='$id_guru'");
    $data = mysqli_fetch_array($query);
    $total_kelas = $data['total_kelas'];
    $query_siswa = mysqli_query($koneksi, "SELECT Count(DISTINCT(siswa.nis)) as total_siswa FROM jadwal inner join kelas on kelas.kode_kelas=jadwal.kode_kelas inner join kelassiswa on kelassiswa.kode_kelas=kelas.kode_kelas inner join siswa on siswa.nis=kelassiswa.nis INNER join mengajar on mengajar.kode_mengajar=jadwal.kode_mengajar WHERE kelas.tahun_ajaran like '%$config_tahun_ajaran_aktif%' AND mengajar.id_guru='$id_guru'");
    $data_siswa = mysqli_fetch_array($query_siswa);
    $total_siswa = $data_siswa['total_siswa'];
?>
   <section class="content-header">
      <h1>
         Dashboard
         <small>SMK Negeri 11 Garut</small>
      </h1>
   </section>
   <section class="content">
   <div class="row">
        <div class="col-xs-6">
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
      
        <div class="col-xs-6">
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

      </div>
   </section>
