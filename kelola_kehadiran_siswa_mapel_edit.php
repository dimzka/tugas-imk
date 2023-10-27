<?php 
         if(isset($_GET['id_jadwal']) AND isset($_GET['tanggal'])){
            $id_jadwal = $_GET['id_jadwal'];
            $tanggal = $_GET['tanggal'];

            $query = mysqli_query($koneksi, "SELECT * FROM kehadiransiswamapel WHERE id_jadwal='$id_jadwal' AND tanggal='$tanggal'");
            $data = mysqli_fetch_array($query);
            if($data == null){
               echo "<script>
                  window.location.href='index.php?page=kelola_kehadiran_siswa_mapel_lihat&id_jadwal=".$_GET['id_jadwal']."&error=5';
               </script>";  
            }
      
            $id_jadwal = $data['id_jadwal'];
            $id_guru = $_SESSION['id'];
            $query = mysqli_query($koneksi, "
            SELECT kelas.tingkat, kelas.jurusan, 
            kelas.kode_kelas,
            kelas.tahun_ajaran, kelas.kelas,
             kelas.kode_kelas as kode_kelas 
            FROM jadwal 
            INNER JOIN kelas ON jadwal.kode_kelas = kelas.kode_kelas  
            INNER JOIN mengajar ON jadwal.kode_mengajar = mengajar.kode_mengajar
            WHERE jadwal.id_jadwal = '$id_jadwal' AND mengajar.id_guru = '$id_guru'");
            $data = mysqli_fetch_array($query);
            if($data == null){
                echo "<script>
                    window.location.href='index.php?page=kelola_kehadiran_siswa_mapel_lihat&id_jadwal=".$_GET['id_jadwal']."&error=5';
                </script>";  
            }
            $nama = $data['tingkat']." ".$data['jurusan']." ".$data['kelas']." - ".$data['tahun_ajaran'];
            $kode_kelas = $data['kode_kelas'];
           
      }else{
            echo "<script>
               window.location.href='index.php?page=kelola_kehadiran_siswa_mapel_lihat&id_jadwal=".$_GET['id_jadwal']."&error=5';
            </script>";
      }

    if(isset($_POST['submit'])) {
      $errors = [];
      $tanggal = isset($_POST['tanggal']) ? $_POST['tanggal'] : '';

      if(empty($tanggal)) {
         $errors[] = "Semua field harus diisi";
      } 
      if(count($errors) > 0){
         $_SESSION['errors'] = $errors;
       } else {
            $list_siswa = mysqli_query($koneksi, "SELECT * FROM kelassiswa WHERE kode_kelas='$kode_kelas'");
            while($data = mysqli_fetch_array($list_siswa)){
               $nis = $data['nis'];
               $keterangan = isset($_POST['keterangan'.$nis]) ? $_POST['keterangan'.$nis] : '';
               if(mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kehadiransiswamapel WHERE id_jadwal='$id_jadwal' AND tanggal='$tanggal' AND nis='$nis'")) == 0){
                  mysqli_query($koneksi, "INSERT INTO kehadiransiswamapel (id_jadwal, tanggal, nis, keterangan) VALUES ('$id_jadwal', '$tanggal', '$nis', '$keterangan')");
               }else{
                  mysqli_query($koneksi, "UPDATE kehadiransiswamapel SET keterangan = '$keterangan' WHERE id_jadwal='$id_jadwal' AND tanggal='$tanggal' AND nis='$nis'");
               }
            }
            $_SESSION['success'] = "Data berhasil diubah";
            echo "<script>
               window.location.href='index.php?page=kelola_kehadiran_siswa_mapel_lihat&id_jadwal=".$_GET['id_jadwal']."&success=2';
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
   <form class="box" action="index.php?page=kelola_kehadiran_siswa_mapel_edit&id_jadwal=<?= $id_jadwal ?>&tanggal=<?= $tanggal ?>" method="POST">
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
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= $tanggal ?>">
        </div>
         <table class="table table-bordered table-striped">
            <thead>
               <tr>
                  <th width="5%" style="text-align: center; vertical-align: middle;">No</th>
                  <th width="7%" style="text-align: center; vertical-align: middle;">NIS</th>
                  <th width="15%" style="text-align: center; vertical-align: middle;">Nama</th>
                  <th width="5%" style="text-align: center; vertical-align: middle;">JK</th>
                  <th width="10%" style="text-align: center; vertical-align: middle;">Keterangan</th>
               </tr>
            </thead>
            <tbody>
               <?php 
                  $no = 1;
                  $query = mysqli_query($koneksi, "SELECT siswa.nis FROM kelassiswa INNER JOIN siswa ON kelassiswa.nis=siswa.nis WHERE kelassiswa.kode_kelas='$kode_kelas'");
                  $kelas_siswa = mysqli_query($koneksi, "SELECT siswa.nama, siswa.nis,  siswa.jenis_kelamin, kelassiswa.kode_kelas FROM kelassiswa INNER JOIN siswa ON kelassiswa.nis=siswa.nis WHERE kelassiswa.kode_kelas='$kode_kelas' ORDER BY siswa.nama ASC");
                  $arrayKelasSiswa = mysqli_fetch_all($kelas_siswa, MYSQLI_ASSOC);
                  $countData = mysqli_num_rows($query);
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
                  <?php 
                     $kehadiran_cek = mysqli_query($koneksi, "SELECT * FROM kehadiransiswamapel WHERE nis='$result[nis]' AND id_jadwal = '$id_jadwal' AND tanggal = '$tanggal'");
                     $kehadiran = mysqli_fetch_assoc($kehadiran_cek);
                     $keterangan = isset($kehadiran['keterangan']) ? $kehadiran['keterangan'] : '';
              
                     ?>
                  <td>
                    <select name="keterangan<?= $result['nis'] ?>" id="keterangan<?= $result['nis'] ?>" class="form-control">
                      <option value="" <?= $keterangan == '' ? 'selected' : '' ?>>Pilih Keterangan</option>
                      <option value="H" <?= $keterangan == 'H' ? 'selected' : '' ?>>Hadir</option>
                      <option value="I" <?= $keterangan == 'I' ? 'selected' : '' ?>>Izin</option>
                      <option value="S" <?= $keterangan == 'S' ? 'selected' : '' ?>>Sakit</option>
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
      <button type="submit" name="submit" class="btn btn-primary">
                <i class="fa fa-save fa-fw"></i> Simpan
            </button>
            <br>
            <br>
            <a href="index.php?page=kelola_kehadiran_siswa_mapel_lihat&id_jadwal=<?= $id_jadwal ?>" class="btn btn-default" style="margin-right: 5px;">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
   </form>
</section>