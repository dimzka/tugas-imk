<?php 
    if(isset($_GET['id_jadwal'])){
        $id_guru = $_SESSION['id'];
        $id_jadwal = $_GET['id_jadwal'];
        $query = mysqli_query($koneksi, "
        SELECT kelas.tingkat, kelas.jurusan, 
        kelas.kode_kelas,
        kelas.tahun_ajaran, kelas.kelas,
        kelas.kode_kelas as kode_kelas 
        FROM jadwal 
        INNER JOIN kelas ON jadwal.kode_kelas = kelas.kode_kelas 
         inner join mengajar on jadwal.kode_mengajar = mengajar.kode_mengajar
        WHERE jadwal.id_jadwal = '$id_jadwal' AND mengajar.id_guru = '$id_guru'");
        $data = mysqli_fetch_array($query);
        if($data == null){
            echo "<script>
                window.location.href='index.php?page=kelola_kelas&error=5';
            </script>";  
        }
        $nama = $data['tingkat']." ".$data['jurusan']." ".$data['kelas']." - ".$data['tahun_ajaran'];
        $kode_kelas = $data['kode_kelas'];
    }else{
        echo "<script>
            window.location.href='index.php?page=kelola_kelas&error=5';
        </script>";
    }

    if(isset($_POST['submit'])) {
      $errors = [];
      $tanggal = isset($_POST['tanggal']) ? $_POST['tanggal'] : '';
     
      if(empty($tanggal)) {
         $errors[] = "Tanggal tidak boleh kosong";
      // panjang materi tidak boleh lebih dari 30 dan jenis_materi hanya bisa I dan K
      } else if (mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kehadiransiswamapel WHERE id_jadwal='$id_jadwal' AND tanggal='$tanggal'")) > 0) {
         $errors[] = "Kehadiran pada tanggal tersebut sudah ada";
      }
      if(count($errors) > 0){
         $_SESSION['errors'] = $errors;
       } else {
         $query = mysqli_query($koneksi, "SELECT siswa.nis FROM kelassiswa INNER JOIN siswa ON kelassiswa.nis=siswa.nis WHERE kelassiswa.kode_kelas='$kode_kelas'");
         $kelas_siswa = mysqli_query($koneksi, "SELECT siswa.nama, siswa.nis,  siswa.jenis_kelamin, kelassiswa.kode_kelas FROM kelassiswa INNER JOIN siswa ON kelassiswa.nis=siswa.nis WHERE kelassiswa.kode_kelas='$kode_kelas' ORDER BY siswa.nama ASC");
         $arrayKelasSiswa = mysqli_fetch_all($kelas_siswa, MYSQLI_ASSOC);
         $countData = mysqli_num_rows($query);
         foreach ($arrayKelasSiswa as $result){
            $nis = $result['nis'];
            $keterangan = isset($_POST['keterangan'.$nis]) ? $_POST['keterangan'.$nis] : '';
            $query = mysqli_query($koneksi, "INSERT INTO kehadiransiswamapel (id_jadwal, nis, tanggal, keterangan) VALUES ('$id_jadwal', '$nis', '$tanggal', '$keterangan')");
         }
         $_SESSION['success'] = "Absensi berhasil ditambahkan";
         echo "<script>
            window.location.href='index.php?page=kelola_kehadiran_siswa_mapel_lihat&id_jadwal=$id_jadwal&success=1';
         </script>";
       }
    }

?>
<section class="content-header">
   <h1>
      Kelola Tambah Kehadiran Siswa
      <small>SMK Negeri 11 Garut</small>
   </h1>
</section>
<section class="content">
   <form class="box" action="index.php?page=kelola_kehadiran_siswa_mapel_tambah&id_jadwal=<?php echo $id_jadwal; ?>" method="POST">
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
         <div class="box-body table-responsive">
         <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>">
        </div>
         <table class="table table-bordered table-striped">
            <thead>
               <tr>
                  <th  style="vertical-align : middle;text-align:center; width: 5px;" >No</th>
                  <th  style="vertical-align : middle;text-align:center;  width: 10px;" >NIS</th>
                  <th  style="vertical-align : middle;text-align:center; width: 200px;" >Nama Siswa</th>
                  <th style="text-align: center; vertical-align: middle; width: 50px;">JK</th>
                  <th class="text-center" style=" width: 200px;">Keterangan</th>
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
                  <td style="font-weight: bold; max-width: 14px;"><?= $result['nis'] ?></td>
                  <td>
                      <?= $result['nama'] ?>
                  </td>
                  <td >
                      <?= $result['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?>
                  </td>
                  <td>
                    <select name="keterangan<?= $result['nis'] ?>" class="form-control" required>
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
         <br />
         <br />

            <a href="index.php?page=kelola_kehadiran_siswa_mapel_lihat&id_jadwal=<?= $id_jadwal ?>" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
   </form>
</section>