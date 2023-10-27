<?php
    if(isset($_GET['kode_matapelajaran'])){
        $kode_matapelajaran = $_GET['kode_matapelajaran'];
        $query = mysqli_query($koneksi, "SELECT * from matapelajaran WHERE kode_matapelajaran='$kode_matapelajaran'");
        $data = mysqli_fetch_array($query);
        if($data == null){
            echo "<script>
                window.location.href='index.php?page=kelola_mata_pelajaran&error=5';
            </script>";  
        }
        $nama = $data['nama'];
    }else{
        echo "<script>
            window.location.href='index.php?page=kelola_mata_pelajaran&error=5';
        </script>";
    }
    if(isset($_POST['submit'])){
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
        $errors = [];
        if(strlen($nama) < 3){
            $errors[] = "Nama minimal 3 karakter";
        } else if(strlen($nama) > 60){
            $errors[] = "Nama maksimal 60 karakter";
        } else if(mysqli_num_rows(mysqli_query($koneksi, "SELECT * from matapelajaran WHERE nama='$nama' AND kode_matapelajaran!='$kode_matapelajaran'")) > 0){
            $errors[] = "Mata pelajaran sudah ada";
        } else {
            
            $query = mysqli_query($koneksi, "UPDATE matapelajaran SET nama='$nama'WHERE kode_matapelajaran='$kode_matapelajaran'");
            if($query){
                echo "<script>
                    window.location.href='index.php?page=kelola_mata_pelajaran&success=1';
                </script>";
            }else{
                echo "<script>
                    window.location.href='index.php?page=kelola_mata_pelajaran_edit&kode_matapelajaran=$kode_matapelajaran&error=1';
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
      Edit Mata Pelajaran
      <small>SMK Negeri 11 Garut</small>
   </h1>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Mata Pelajaran</h3>
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
                    <form action="index.php?page=kelola_mata_pelajaran_edit&kode_matapelajaran=<?php echo $kode_matapelajaran; ?>" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama" value="<?php echo $nama; ?>" required>
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