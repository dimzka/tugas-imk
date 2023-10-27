<?php
    if(isset($_GET['kode_kelas'])){
        $kode_kelas = $_GET['kode_kelas'];
        $query = mysqli_query($koneksi, "SELECT * FROM kelas WHERE kode_kelas = '$kode_kelas'");
        $data = mysqli_fetch_array($query);
        if($data == null){
            echo "<script>
                window.location.href='index.php?page=kelola_kelas&error=5';
            </script>";  
        }
        $tingkat = $data['tingkat'];
        $jurusan = $data['jurusan'];
        $tahun_ajaran = $data['tahun_ajaran'];
        $nama = $data['tingkat'].$data['jurusan'].$data['kelas'];
    }else{
        echo "<script>
            window.location.href='index.php?page=kelola_kelas&error=5';
        </script>";
    }

    if(isset($_POST['submit'])){
        $tahun_ajaran = mysqli_real_escape_string($koneksi, $_POST['tahun_ajaran']);
        $errors = [];
        if(!$tahun_ajaran){
            $errors[] = "Tahun ajaran tidak boleh kosong";
        } else {
            $query = mysqli_query($koneksi, "UPDATE kelas SET tahun_ajaran = '$tahun_ajaran' WHERE kode_kelas = '$kode_kelas'");
            if($query){
                echo "<script>
                    window.location.href='index.php?page=kelola_kelas&success=1';
                </script>";
            }else{
                echo "<script>
                    window.location.href='index.php?page=kelola_kelas_edit&kode_kelas=$kode_kelas&error=1';
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
       Kelola Edit Kelas
      <small>SMK Negeri 11 Garut</small>
   </h1>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Kelas</h3>
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
                    <form action="index.php?page=kelola_kelas_edit&kode_kelas=<?php echo $kode_kelas; ?>" method="POST">
                        <input type="hidden" name="kode_kelas" value="<?php echo $kode_kelas; ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" readonly name="nama" id="nama" class="form-control" placeholder="Nama" value="<?php echo $nama; ?>" readonly>
                                </div> 
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tingkat">Tingkat</label>
                                   <select name="tingkat" id="tingkat" class="form-control" required disabled>
                                        <option value="" disabled>Pilih Tingkat</option>
                                        <option value="X" <?php if($tingkat == "X"){ echo "selected"; } ?>>X</option>
                                        <option value="XI" <?php if($tingkat == "XI"){ echo "selected"; } ?>>XI</option>
                                        <option value="XII <?php if($tingkat == "XII"){ echo "selected"; } ?>">XII</option>
                                    </select>
                                </div> 
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jurusan">Jurusan</label>
                                   <select name="jurusan" id="jurusan" class="form-control" required disabled>
                                        <option value="" disabled>Pilih Jurusan</option>
                                        <?php 
                                             foreach($config_jurusan as $key => $value){
                                                echo "<option value='$key' ".($jurusan == $key ? "selected" : "").">$value</option>";
                                            }
                                        ?>
                                    </select>
                                </div> 
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tahun_ajaran">Tahun Ajaran</label>
                                   <select name="tahun_ajaran" id="tahun_ajaran" class="form-control" required>
                                        <option selected disabled>Pilih Tahun Ajaran</option>
                                        <?php 
                                            $start = date('Y');
                                            $end = 2019;
                                            for($i = $start; $i >= $end; $i--) {
                                                $tahun_ajaran_ = $i."/".$i+1;
                                                echo "<option value='$tahun_ajaran_' ".($tahun_ajaran_ == $tahun_ajaran ? "selected" : "").">$tahun_ajaran_</option>";
                                            }
                                        ?>
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
            <a href="index.php?page=kelola_kelas" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</section>

<script>
    // function getWaliKelas() {
    //     var tahun_ajaran = `<?php echo $tahun_ajaran; ?>`;
    //     var kode_kelas = `<?php echo $kode_kelas; ?>`;
    //     var xhr = new XMLHttpRequest();
    //     xhr.open('POST', 'ajax/kelas.php', true);
    //     xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    //     xhr.send('tahun_ajaran='+tahun_ajaran+'&action=getWaliKelasEdit&kode_kelas='+kode_kelas);
    //     xhr.onreadystatechange = function(){
    //         if(xhr.readyState == 4 && xhr.status == 200){
    //             var data = xhr.responseText;
    //             $('#id_guru').html(data);
    //         }
    //     }
    // }
    
    getWaliKelas();
</script>