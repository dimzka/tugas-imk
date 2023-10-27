<?php
    if(isset($_POST['submit'])){
        $nip = mysqli_real_escape_string($koneksi, $_POST['nip']);
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
        $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
        $email = mysqli_real_escape_string($koneksi, $_POST['email']);
        $password = mysqli_real_escape_string($koneksi, $_POST['password']);
        $errors = [];
        if($nama == null || $jenis_kelamin == null || $username == null || $password == null){
            $errors[] = "Semua kolom harus diisi";
        } else if(strlen($nip) != 18 AND $nip != null){
            $errors[] = "NIP harus 18 digit";
        } else if(strlen($nama) < 3){
            $errors[] = "Nama minimal 3 karakter";
        } else if(strlen($nama) > 60){
            $errors[] = "Nama maksimal 60 karakter";
        // } else if(!preg_match("/^[a-zA-Z ]*$/", $nama)){
        //     $errors[] = "Nama hanya boleh huruf";
        } else if($jenis_kelamin != 'L' && $jenis_kelamin != 'P'){
            $errors[] = "Jenis kelamin tidak valid";
        } else if(mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM guru WHERE nip = '$nip'")) > 0 AND $nip != null){
            $errors[] = "NIP sudah terdaftar";
        } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[] = "Email tidak valid";
        } else if(mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM guru WHERE email = '$email'")) > 0){
            $errors[] = "Email sudah terdaftar";
        } else if(strlen($password) < 5){
            $errors[] = "Password minimal 5 karakter";
        } else if(strlen($password) > 20){
            $errors[] = "Password maksimal 20 karakter";
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $query = mysqli_query($koneksi, "INSERT INTO guru (nip, nama, jenis_kelamin, password, email) VALUES ('$nip', '$nama', '$jenis_kelamin', '$password', '$email')");
            if($query){
                echo "<script>
                    window.location.href='index.php?page=kelola_guru_tambah&success=1';
                </script>";
            }else{
                echo "<script>
                    window.location.href='index.php?page=kelola_guru_tambah&error=1';
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
      Tambah Guru
      <small>SMK Negeri 11 Garut</small>
   </h1>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Tambah Guru Baru</h3>
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
                    <form action="index.php?page=kelola_guru_tambah" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nis">Nomor Induk Pegawai <small>(NIP) Opsional</small></label>
                                    <input type="number" name="nip" id="nip" class="form-control" placeholder="NIP">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama" required>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                                </div> 
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
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
            <a href="index.php?page=kelola_guru" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
            <!-- Tombol simpan -->
        </div>
    </div>
</section>