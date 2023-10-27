<?php
    if(isset($_POST['submit'])){
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
        $errors = [];
        if(strlen($nama) < 3){
            $errors[] = "Nama minimal 3 karakter";
        } else if(strlen($nama) > 60){
            $errors[] = "Nama maksimal 60 karakter";
        } else if(mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM matapelajaran WHERE nama='$nama'")) > 0){
            $errors[] = "Mata pelajaran sudah ada";
        } else {
            // kode_mata pelajaran diambil dari nama setiap kata mata pelajaran diambil dari huruf pertama
            $kode_matapelajaran = "";
            $nama_matapelajaran = explode(" ", $nama);
            foreach($nama_matapelajaran as $nm){
                $kode_matapelajaran .= $nm[0];
            }
            $total = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM matapelajaran WHERE kode_matapelajaran LIKE '$kode_matapelajaran%'"));
            $query = mysqli_query($koneksi, "INSERT INTO matapelajaran (kode_matapelajaran,nama) VALUES ('$kode_matapelajaran','$nama')");
            if($query){
                echo "<script>
                    window.location.href='index.php?page=kelola_mata_pelajaran_tambah&success=1';
                </script>";
            }else{
                echo "<script>
                    window.location.href='index.php?page=kelola_mata_pelajaran_tambah&error=1';
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
      Tambah Mata Pelajaran
      <small>SMK Negeri 11 Garut</small>
   </h1>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Tambah Mata Pelajaran Baru</h3>
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
                    <form action="index.php?page=kelola_mata_pelajaran_tambah" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama" required>
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
            <a href="index.php?page=kelola_mata_pelajaran" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
            <!-- Tombol simpan -->
        </div>
    </div>
</section>