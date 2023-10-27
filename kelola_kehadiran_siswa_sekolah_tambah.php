<?php 
    if(isset($_GET['kode_kelas'])){
        $kode_kelas = $_GET['kode_kelas'];
        $query = mysqli_query($koneksi, "SELECT kelas.tingkat, kelas.jurusan, kelas.tahun_ajaran, kelas.kelas,  kelas.kode_kelas as kode_kelas FROM kelas  WHERE kelas.kode_kelas='$kode_kelas'");
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

    if(isset($_POST['submit'])) {
      $errors = [];
        $tanggal = $_POST['tanggal'];
        $cek_absensi = mysqli_query($koneksi, "SELECT * FROM kehadiransiswasekolah WHERE tanggal='$tanggal' AND kode_kelas='$kode_kelas'");
        $total_cek_absensi = mysqli_num_rows($cek_absensi);
        if($total_cek_absensi > 0){
         $errors[] = "Kehadiran pada tanggal tersebut sudah ada";
        }
        if(count($errors) > 0){
         $_SESSION['errors'] = $errors;
       } else {
        $id_admin = $_SESSION['id'];
        $kelas_siswa = mysqli_query($koneksi, "SELECT siswa.nis FROM kelassiswa INNER JOIN siswa ON kelassiswa.nis=siswa.nis WHERE kelassiswa.kode_kelas='$kode_kelas'");
        $arrayKelasSiswa = mysqli_fetch_all($kelas_siswa, MYSQLI_ASSOC);
        foreach ($arrayKelasSiswa as $result){
            $nis = $result['nis'];
            $keterangan = $_POST['keterangan'.$nis];
            $query = mysqli_query($koneksi, "INSERT INTO kehadiransiswasekolah (id_admin, nis, kode_kelas, tanggal, keterangan) VALUES ('$id_admin', '$nis', '$kode_kelas', '$tanggal', '$keterangan')");
        }
        if($query){
            $_SESSION['success'] = "Kehadir Siswa Berhasil Ditambahkan";
            echo "<script>
                window.location.href='index.php?page=kelola_kehadiran_siswa_sekolah_lihat&kode_kelas=$kode_kelas&success=1';
            </script>";
        }else{
            $_SESSION['errors'] = " Kehadiran Siswa Gagal Ditambahkan";
            echo "<script>
                window.location.href='index.php?page=kelola_kehadiran_siswa_sekolah_tambah&kode_kelas=$kode_kelas';
            </script>";
        }
       }
        
    }

  $total_siswa_query = mysqli_query($koneksi, "SELECT COUNT(*) AS total_siswa FROM kelassiswa WHERE kode_kelas='$kode_kelas'");
  $resultTotalSiswa = mysqli_fetch_array($total_siswa_query);
  $total_kelas_siswa = $resultTotalSiswa['total_siswa'];
?>
<section class="content-header">
   <h1>
      Kelola Tambah Kehadiran Siswa
      <small>SMK Negeri 11 Garut</small>
   </h1>
</section>
<section class="content">
   <form class="box" action="index.php?page=kelola_kehadiran_siswa_sekolah_tambah&kode_kelas=<?php echo $kode_kelas; ?>" method="post">
      <div class="box-header with-border">
         <h3 class="box-title">Daftar Siswa</h3>
      </div>
      <div class="box-body">

         <div class="row" style="margin-bottom: 10px">      
            <div class="col-md-12">
               <?php 
                  include_once 'errors.php';
                  include_once 'success.php';
               ?>
            </div>
         </div>
         <div class="box-body table-responsive" >

         <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>">
        </div>
         <table class="table table-bordered table-striped">
            <thead>
            <tr>
 
               <th style="vertical-align : middle;text-align:center; width: 5px;" >No</th>
               <th style="vertical-align : middle;text-align:center;  width: 14px;" >NIS</th>
               <th style="vertical-align : middle;text-align:center;" >Nama Siswa</th>
               <th style="text-align: center; vertical-align: middle;">Jenis Kelamin</th>
               <th style="text-align: center; vertical-align: middle; ">Keterangan</th>
               </tr>
 
               
            </thead>
            <tbody>
               <?php 
                   $no = 1;
                   $q = isset($_GET['q']) ? $_GET['q'] : '';
                   $query = mysqli_query($koneksi, "SELECT siswa.nis FROM kelassiswa INNER JOIN siswa ON kelassiswa.nis=siswa.nis WHERE kelassiswa.kode_kelas='$kode_kelas' AND (siswa.nama LIKE '%$q%' OR siswa.nis LIKE '%$q%')");
                   $kelas_siswa = mysqli_query($koneksi, "SELECT siswa.nama, siswa.nis,  siswa.jenis_kelamin, kelassiswa.kode_kelas FROM kelassiswa INNER JOIN siswa ON kelassiswa.nis=siswa.nis WHERE kelassiswa.kode_kelas='$kode_kelas' AND (siswa.nama LIKE '%$q%' OR  siswa.nis LIKE '%$q%') ORDER BY siswa.nama ASC");
                   $countData = mysqli_num_rows($query);
                   $arrayKelasSiswa = mysqli_fetch_all($kelas_siswa, MYSQLI_ASSOC);
                   foreach ($arrayKelasSiswa as $result){
      
               ?>
               <tr style = "font-size: 14px; color: #000;  vertical-align: middle;">
                  <td><?= $no++ ?></td>
                  <td style=" font-weight: bold;"><?= $result['nis'] ?></td>
                  <td>
                      <?= $result['nama'] ?>
                  </td>
                  <td>
                      <?= $result['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?>
                  </td>
                  <td>
                    <select name="keterangan<?= $result['nis'] ?>" id="keterangan" class="form-control">
                      <option value="" disabled>Pilih Keterangan</option>
                      <option value="H" selected>Hadir</option>
                      <option value="S">Sakit</option>
                      <option value="I">Izin</option>
                      <option value="A">Alpa</option>
                    </select>
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
            <button type="submit" name="submit" class="btn btn-primary">
                <i class="fa fa-save fa-fw"></i> Simpan
            </button>
            <br>
            <br>
            <a href="index.php?page=kelola_kehadiran_siswa_sekolah_lihat&kode_kelas=<?= $kode_kelas ?>" class="btn btn-default mt-4">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
   </form>
</section>