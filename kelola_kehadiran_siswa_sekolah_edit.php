<?php 
    if(isset($_GET['kode_kelas']) AND isset($_GET['tanggal'])){
         $kode_kelas = $_GET['kode_kelas'];
         $tanggal = $_GET['tanggal'];
 
        $query = mysqli_query($koneksi, "SELECT * FROM kehadiransiswasekolah WHERE kode_kelas='$kode_kelas' AND tanggal='$tanggal'");
        $data = mysqli_fetch_array($query);
        if($data == null){
            echo "<script>
                window.location.href='index.php?page=kelola_kehadiran_siswa_sekolah_lihat&kode_kelas=$kode_kelas&error=1';
            </script>";  
        }
        $kode_kelas = $data['kode_kelas'];
        $query = mysqli_query($koneksi, "SELECT kelas.tingkat, kelas.jurusan, kelas.tahun_ajaran, kelas.kelas,  kelas.kode_kelas as kode_kelas FROM kelas   WHERE kelas.kode_kelas='$kode_kelas'");
        $data = mysqli_fetch_array($query);
        $nama = $data['tingkat']." ".$data['jurusan']." ".$data['kelas']." - ".$data['tahun_ajaran'];

    }else{
        echo "<script>
            window.location.href='index.php?page=kelola_kehadiran_siswa_sekolah_lihat&kode_kelas=$kode_kelas&error=1';
        </script>";
    }

    if(isset($_POST['submit'])) {
  
        $errors = [];
        $tanggal = $_POST['tanggal'];
        // cek absensi sudah ada atau belum pada tanggal tersebut
        $cek_absensi = mysqli_query($koneksi, "SELECT * FROM kehadiransiswasekolah WHERE tanggal='$tanggal' AND kode_kelas='$kode_kelas'");
        $total_cek_absensi = mysqli_num_rows($cek_absensi);
        if($total_cek_absensi == 0){
         $errors[] = "Kehadiran pada tanggal tersebut belum ada";
        } 
        if(count($errors) > 0){
         $_SESSION['errors'] = $errors;
       } else {
         $id_admin = $_SESSION['id'];
         $query = mysqli_query($koneksi, "SELECT * FROM kelassiswa WHERE kode_kelas='$kode_kelas'");
         while($data = mysqli_fetch_array($query)){
             $nis = $data['nis'];
             $keterangan = $_POST['keterangan'.$nis] == null ? "H" : $_POST['keterangan'.$nis];
             if(mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kehadiransiswasekolah WHERE tanggal='$tanggal' AND nis='$nis'")) > 0){
               $query_update = mysqli_query($koneksi, "UPDATE
               kehadiransiswasekolah SET keterangan='$keterangan' WHERE nis='$nis' AND tanggal='$tanggal' AND kode_kelas='$kode_kelas'");
             }else{
               $query_insert = mysqli_query($koneksi, "INSERT INTO kehadiransiswasekolah (id_admin, nis, kode_kelas, tanggal, keterangan) VALUES ('$id_admin', '$nis', '$kode_kelas', '$tanggal', '$keterangan')");
             }
         }
         $_SESSION['success'] = "Berhasil mengubah kehadiran siswa";
         echo "<script>
             window.location.href='index.php?page=kelola_kehadiran_siswa_sekolah_lihat&kode_kelas=$kode_kelas&success=2';
         </script>";

       }  
    }


?>
<section class="content-header">
   <h1>
      Kelola Edit Kehadiran Siswa
      <small>SMK Negeri 11 Garut</small>
   </h1>
   
</section>
<section class="content">
   <form class="box" action="index.php?page=kelola_kehadiran_siswa_sekolah_edit&kode_kelas=<?php echo $kode_kelas; ?>&tanggal=<?php echo $tanggal; ?>" method="POST">
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
                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo $tanggal; ?>" readonly>
        </div>
         <table class="table table-bordered table-striped">
            <thead>
            <tr>
 
 <th style="vertical-align : middle;text-align:center; width: 5px;" >No</th>
 <th style="vertical-align : middle;text-align:center;  width: 14px;" >NIS</th>
 <th style="vertical-align : middle;text-align:center;" >Nama Siswa</th>
 <th style="text-align: center; vertical-align: middle; ">Jenis Kelamin</th>
 <th  style="text-align: center; vertical-align: middle; ">Keterangan</th>
 </tr>
 <tr>

</thead>
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
                    <select name="keterangan<?php echo $result['nis']; ?>" id="keterangan<?php echo $result['nis']; ?>" class="form-control">
                  
                      <!-- cek -->
                      <?php 
                        $nis = $result['nis'];
                        $cek = mysqli_query($koneksi, "SELECT * FROM kehadiransiswasekolah WHERE nis='$nis' AND tanggal='$tanggal' AND kode_kelas='$kode_kelas'");
                        $data = mysqli_fetch_array($cek);
                        $keterangan = isset($data['keterangan']) ? $data['keterangan'] : '';
                      ?>
                        <option value="" disabled selected>Pilih Keterangan</option>
                        <option value="H" <?= $keterangan == 'H' ? 'selected' : '' ?>>Hadir</option>
                        <option value="S" <?= $keterangan == 'S' ? 'selected' : '' ?>>Sakit</option>
                        <option value="I" <?= $keterangan == 'I' ? 'selected' : '' ?>>Izin</option>
                        <option value="A" <?= $keterangan == 'A' ? 'selected' : '' ?>>Alpa</option>
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
      <button type="submit" name="submit" class="btn btn-primary pull-right">
                <i class="fa fa-save fa-fw"></i> Simpan
            </button>
            <a href="index.php?page=kelola_kehadiran_siswa_sekolah_lihat&kode_kelas=<?= $kode_kelas ?>" class="btn btn-default" style="margin-right: 10px;">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
   </form>
</section>