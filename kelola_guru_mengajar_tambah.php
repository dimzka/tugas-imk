<?php 
    if(isset($_GET['id_guru'])){
        $id_guru = mysqli_real_escape_string($koneksi, $_GET['id_guru']);
        $query = mysqli_query($koneksi, "SELECT * FROM guru WHERE id_guru='$id_guru'");
        if(mysqli_num_rows($query) == 0){
            echo "<script>
                window.location.href='index.php?page=kelola_guru&error=1';
            </script>";
        } else {
            $result = mysqli_fetch_assoc($query);
        }
    } else {
        echo "<script>
            window.location.href='index.php?page=kelola_guru&error=1';
        </script>";
    }

    function ubahAngkaKeHuruf($angka) {
        // jika angka lebih dari 26, maka akan diulang sebanyak2x
        // misal 27 maka aa, 28 maka ab, dst
        $huruf = '';
        $angka = $angka - 1;
        while ($angka >= 0) {
            $huruf = chr($angka % 26 + 65) . $huruf;
            $angka = floor($angka / 26) - 1;
        }
        return $huruf;
    }
  


  if(isset($_POST['submit'])){
    $kode_matapelajaran = isset($_POST['kode_matapelajaran']) ? $_POST['kode_matapelajaran'] : [];
    $errors = [];
    if($kode_matapelajaran == null){
        $errors[] = "Pilih minimal 1 mata pelajaran";
    } else {
        foreach($kode_matapelajaran as $kode){
            $query = mysqli_query($koneksi, "SELECT * FROM matapelajaran WHERE kode_matapelajaran='$kode'");
            if(mysqli_num_rows($query) == 0){
                $errors[] = "Mata pelajaran tidak ada";
                break;
            }

            $query = mysqli_query($koneksi, "SELECT * FROM mengajar WHERE id_guru='$id_guru' AND kode_matapelajaran='$kode'");  
            if(mysqli_num_rows($query) > 0){
                $errors[] = "Mata pelajaran sudah ada";
                break;
            }
        }
      
        if(count($errors) > 0){
            $_SESSION['errors'] = $errors;
        } else {
                foreach($kode_matapelajaran as $kode){
                    $cek_total_guru = mysqli_query($koneksi, "SELECT * FROM mengajar WHERE id_guru = '$id_guru'");
                    $total_guru = mysqli_num_rows($cek_total_guru);
                    $kode_mengajar = $id_guru . ubahAngkaKeHuruf($total_guru + 1);
    
                    $query = mysqli_query($koneksi, "INSERT INTO mengajar (kode_mengajar, id_guru, kode_matapelajaran) VALUES ('$kode_mengajar', '$id_guru', '$kode')");
                }
                if($query){
                    echo "<script>
                        window.location.href='index.php?page=kelola_guru_mengajar&id_guru=$id_guru&success=1';
                    </script>";
                } else {
                    echo "<script>
                        window.location.href='index.php?page=kelola_guru_mengajar&id_guru=$id_guru&error=1';
                    </script>";
                }
        }
    }
}
?>


<section class="content-header">
   <h1>
       Kelola Tambah Guru Mengajar
      <small>SMK Negeri 11 Garut</small>
   </h1>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Tambah Mata Pelajaran</h3>
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
                    <form action="index.php?page=kelola_guru_mengajar_tambah&id_guru=<?php echo $id_guru; ?>" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- table -->
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Pilih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                           $tampilkan_mata_pelajaran = mysqli_query($koneksi, "SELECT * FROM matapelajaran where kode_matapelajaran not in (SELECT kode_matapelajaran FROM mengajar WHERE id_guru = '$id_guru')");
                                            $no = 1;
                                            while($data_mata_pelajaran = mysqli_fetch_array($tampilkan_mata_pelajaran)){
                                                ?>
                                                <tr>
                                                    <td><?php echo $no; ?></td>
                                                    <td><?php echo $data_mata_pelajaran['nama']; ?></td>
                                                    <td>
                                                        <input type="checkbox" name="kode_matapelajaran[]" value="<?php echo $data_mata_pelajaran['kode_matapelajaran']; ?>">
                                                    </td>
                                                </tr>
                                                <?php
                                                $no++;
                                            }
                                            
                                            if(mysqli_num_rows($tampilkan_mata_pelajaran) == 0){
                                                ?>
                                                <tr>
                                                    <td colspan="3" class="text-center">Tidak ada data</td>
                                                </tr>
                                                <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <!-- button -->
                     <?php 
                      if (mysqli_num_rows($tampilkan_mata_pelajaran) > 0) {
                        ?>
                        <button type="submit" name="submit" class="btn btn-primary">
                            <i class="fa fa-save
                            "></i> Simpan
                        </button>
                        <?php
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <a href="index.php?page=kelola_guru_mengajar&id_guru=<?php echo $id_guru; ?>" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</section>

