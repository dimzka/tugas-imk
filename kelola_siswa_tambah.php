<?php
    $tahun_ajaran = date('Y');
    $tahun_ajaran = substr($tahun_ajaran, 2, 2);
    $tahun_ajaran_next = $tahun_ajaran + 1;
    $tahunAjaran = $tahun_ajaran."".$tahun_ajaran_next;
    $angkaPertama = 100000;
    $queryTotalSiswaDitahunAjaran = mysqli_query($koneksi, "SELECT COUNT(nis) AS total FROM siswa WHERE nis LIKE '$tahunAjaran%'");
    $angkaTotalSiswaDitahunAjaran = mysqli_fetch_assoc($queryTotalSiswaDitahunAjaran);
    $angkaTotalSiswaDitahunAjaran = $angkaTotalSiswaDitahunAjaran['total'] + 1;
    $nis = $tahunAjaran."".substr($angkaPertama, 0, 6 - strlen($angkaTotalSiswaDitahunAjaran)).$angkaTotalSiswaDitahunAjaran;
    if(isset($_POST['submit'])){
        $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
        $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
        $errors = [];
        if($nis == null || $nama == null || $jenis_kelamin == null){
            $errors[] = "Semua kolom harus diisi";
        } else if(strlen($nis) != 10){
            $errors[] = "NIS harus 10 digit";
        } else if(strlen($nama) < 3){
            $errors[] = "Nama minimal 3 karakter";
        } else if(strlen($nama) > 60){
            $errors[] = "Nama maksimal 60 karakter";
        } else if(!preg_match("/^[a-zA-Z ]*$/", $nama)){
            $errors[] = "Nama hanya boleh huruf";
        } else if($jenis_kelamin != 'L' && $jenis_kelamin != 'P'){
            $errors[] = "Jenis kelamin tidak valid";
        } else if(mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis = '$nis'")) > 0){
            $errors[] = "NIS $nis sudah terdaftar";
        } else {
            $query = mysqli_query($koneksi, "INSERT INTO siswa (nis, nama, jenis_kelamin) VALUES('$nis', '$nama', '$jenis_kelamin')");
            if($query){
                echo "<script>
                    window.location.href='index.php?page=kelola_siswa_tambah&success=1';
                </script>";
            }else{
                echo "<script>
                    window.location.href='index.php?page=kelola_siswa_tambah&error=1';
                </script>";
            }
        }
        if(count($errors) > 0){
          $_SESSION['errors'] = $errors;
        }
    }
?>
<section class="content-header">
   <h1>
      Tambah Siswa
      <small>SMK Negeri 11 Garut</small>
   </h1>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Tambah Siswa Baru</h3>
            <div class="box-tools pull-right">
              
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <?php 
                        include_once 'errors.php';
                        include_once 'success.php';
                    ?>
                </div>
                <div class="col-md-12 col-lg-8">
                    <form action="index.php?page=kelola_siswa_tambah" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nis">NIS</label>
                                    <input type="number" name="nis" id="nis" value="<?= $nis ?>" class="form-control" placeholder="NIS" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama" required>
                                </div> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    <!-- button -->
                        <button type="submit" name="submit" class="btn btn-primary">
                            <i class="fa fa-save
                            "></i> Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <!-- Tombol kembali -->
            <a href="index.php?page=kelola_siswa" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
            <!-- Tombol simpan -->
        </div>
    </div>
</section>