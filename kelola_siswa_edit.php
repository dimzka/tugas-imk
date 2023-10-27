<?php

    if(isset($_GET['nis'])){
        $nis = $_GET['nis'];
        $query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis='$nis'");
        $data = mysqli_fetch_array($query);
        if($data == null){
            echo "<script>
                window.location.href='index.php?page=kelola_siswa&error=5';
            </script>";  
        }
        $nama = $data['nama'];
        $jenis_kelamin = $data['jenis_kelamin'];
    }else{
        echo "<script>
            window.location.href='index.php?page=kelola_siswa&nis=$nis&error=5';
        </script>";
    }
    if(isset($_POST['submit'])){
        $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
        $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
        $errors = [];
        if($nis ==null || $nama == null || $jenis_kelamin == null){
            $errors[] = "Semua data harus diisi";
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
        } else if(mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis='$nis'")) > 1){
            $errors[] = "NIS sudah terdaftar";
        } else {
            $query = mysqli_query($koneksi, "UPDATE siswa SET nis='$nis', nama='$nama', jenis_kelamin='$jenis_kelamin' WHERE nis='$nis'");
            if($query){
                echo "<script>
                    window.location.href='index.php?page=kelola_siswa&success=2';
                </script>";
            } else {
                $errors[] = "Gagal mengubah data";
            }
        }

        if(count($errors) > 0){
            $_SESSION['errors'] = $errors;
        }
    }
?>
<section class="content-header">
   <h1>
      Edit Siswa
      <small>SMK Negeri 11 Garut</small>
   </h1>
  
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Siswa</h3>
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
                    <form action="index.php?page=kelola_siswa_edit&nis=<?= $nis ?>" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nis">NIS</label>
                                    <input type="number" readonly name="nis" id="nis" value="<?= $nis ?>" class="form-control" placeholder="NIS" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text"
                                        value="<?= $nama ?>" name="nama" id="nama" class="form-control" placeholder="Nama" required>
                                </div> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L"
                                    <?php 
                                        if($jenis_kelamin == 'L'){
                                            echo "selected";
                                        }
                                    ?>
                                >Laki-laki</option>
                                <option value="P"
                                    <?php 
                                        if($jenis_kelamin == 'P'){
                                            echo "selected";
                                        }
                                    ?>
                                >Perempuan</option>
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