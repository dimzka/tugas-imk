<?php
    if(isset($_POST['submit'])){
        $tingkat = mysqli_real_escape_string($koneksi, $_POST['tingkat']);
        $jurusan = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
        $tahun_ajaran = mysqli_real_escape_string($koneksi, $_POST['tahun_ajaran']);
        $sql = "SELECT * FROM kelas WHERE tingkat = '$tingkat' AND jurusan = '$jurusan' AND tahun_ajaran = '$tahun_ajaran'";
        $result = mysqli_query($koneksi, $sql);
        $total_kelas = mysqli_num_rows($result);
        $kelasBaru = $total_kelas + 1;
        $errors = [];
        if(empty($tingkat) || empty($jurusan) || empty($tahun_ajaran)){
            $errors[] = "Semua field harus diisi";
        // jurusan hanya boleh diisi dengan $config_jurusan key => value
        } else if(!array_key_exists($jurusan, $config_jurusan)){
            $errors[] = "Jurusan tidak valid";
        } else if(!array_key_exists($tingkat, $config_tingkat)){
            $errors[] = "Tingkat tidak valid";
        } else if(!preg_match("/^[0-9]{4}\/[0-9]{4}$/", $tahun_ajaran)){
            $errors[] = "Tahun ajaran tidak valid";
        } else if(mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kelas WHERE tingkat='$tingkat' AND jurusan='$jurusan' AND kelas = '$kelasBaru' AND tahun_ajaran='$tahun_ajaran'")) > 0){
            $errors[] = "Kelas sudah ada";
        } else {
          
            $kode_kelas = $tingkat."".$jurusan."".$kelasBaru."".$tahun_ajaran;
            $query = mysqli_query($koneksi, "INSERT INTO kelas(kode_kelas, tingkat, kelas, jurusan, tahun_ajaran) VALUES('$kode_kelas', '$tingkat', '$kelasBaru', '$jurusan', '$tahun_ajaran')");
            if($query){
    
                echo "<script>
                    window.location.href='index.php?page=kelola_kelas_tambah&success=1';
                </script>";
            }else{
                echo "<script>
                    window.location.href='index.php?page=kelola_kelas_tambah&error=1';
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
       Kelola Tambah Kelas
      <small>SMK Negeri 11 Garut</small>
   </h1>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Tambah Kelas Baru</h3>
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
                    <form action="index.php?page=kelola_kelas_tambah" method="post">
                        <input type="hidden" name="id_kelas" value="<?php echo $id_kelas; ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" readonly name="nama" id="nama" class="form-control" placeholder="Nama" required>
                                </div> 
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tingkat">Tingkat</label>
                                   <select name="tingkat" id="tingkat" class="form-control" required>
                                        <option value="" selected disabled>Pilih Tingkat</option>
                                        <option value="X">X</option>
                                        <option value="XI">XI</option>
                                        <option value="XII">XII</option>
                                    </select>
                                </div> 
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jurusan">Jurusan</label>
                                   <select name="jurusan" id="jurusan" class="form-control" required>
                                        <option value="" disabled>Pilih Jurusan</option>
                                        <?php 
                                             foreach($config_jurusan as $key => $value){
                                                echo "<option value='$key'>$value</option>";
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
                                                $tahun_ajaran = $i."/".$i+1;
                                                echo "<option value='$tahun_ajaran'>$tahun_ajaran</option>";
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
    function getKelas(){
        var tahun_ajaran = $('#tahun_ajaran').val();
        var jurusan = $('#jurusan').val();
        var tingkat = $('#tingkat').val();

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'ajax/kelas.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('tahun_ajaran='+tahun_ajaran+'&jurusan='+jurusan+'&tingkat='+tingkat+'&action=generateKelas');
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                var data = xhr.responseText;
                $('#nama').val(data);
            }
        }
    }

    function getWaliKelas() {
        var tahun_ajaran = $('#tahun_ajaran').val();
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'ajax/kelas.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('tahun_ajaran='+tahun_ajaran+'&action=getWaliKelas');
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                var data = xhr.responseText;
                $('#id_guru').html(data);
            }
        }
    }
    
    document.getElementById('tahun_ajaran').addEventListener('change', getKelas);
    document.getElementById('jurusan').addEventListener('change', getKelas);
    document.getElementById('tingkat').addEventListener('change', getKelas);
    document.getElementById('tahun_ajaran').addEventListener('change', getWaliKelas);
    getKelas();
</script>