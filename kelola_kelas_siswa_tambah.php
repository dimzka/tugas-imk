<?php 
    if(isset($_GET['kode_kelas'])){
        $kode_kelas = $_GET['kode_kelas'];
        $query = mysqli_query($koneksi, "SELECT kelas.tingkat, kelas.jurusan, kelas.tahun_ajaran, kelas.kelas, kelas.kode_kelas as kode_kelas FROM kelas WHERE kelas.kode_kelas='$kode_kelas'");
        $data = mysqli_fetch_array($query);
        if($data == null){
            echo "<script>
                window.location.href='index.php?page=kelola_kelas&error=5';
            </script>";  
        }
        $nama = $data['tingkat']." ".$data['jurusan']." ".$data['kelas']." - ".$data['tahun_ajaran'];
        $jurusan = $data['jurusan'];
        $tahun_ajaran = $data['tahun_ajaran'];
    }else{
        echo "<script>
            window.location.href='index.php?page=kelola_kelas&error=5';
        </script>";
    }


  if(isset($_POST['submit'])){
    $nis = isset($_POST['nis']) ? $_POST['nis'] : [];
    $errors = [];
    if($nis == null){
        $errors[] = "Pilih siswa";
    } else {
        foreach($nis as $id){
            $id = mysqli_real_escape_string($koneksi, $id);
            if(!is_numeric($id)){
                $errors[] = "Nis harus berupa angka";
            } else if (mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis='$id'")) == 0){
                $errors[] = "Siswa dengan nis $id tidak ditemukan";
            } else {
                $query = mysqli_query($koneksi, "SELECT * from kelassiswa WHERE nis='$id' AND kode_kelas='$kode_kelas'");
                if(mysqli_num_rows($query) > 0){
                    $errors[] = "Siswa dengan nis $id sudah ada di kelas ini";
                } 
            }
        }
        if(count($errors) > 0){
            $_SESSION['errors'] = $errors;
        } else {
                foreach($nis as $id){
                    $query = mysqli_query($koneksi, "INSERT INTO kelassiswa (nis, kode_kelas) VALUES ('$id', '$kode_kelas')");
                }
                if($query){
                    echo "<script>
                        window.location.href='index.php?page=kelola_kelas_siswa&kode_kelas=$kode_kelas&success=1';
                    </script>";
                } else{
                    echo "<script>
                        window.location.href='index.php?page=kelola_kelas_siswa&kode_kelas=$kode_kelas&error=1';
                    </script>";
                }
        }
    }
}
?>


<section class="content-header">
   <h1>
       Kelola Tambah Kelas Siswa
      <small>SMK Negeri 11 Garut</small>
   </h1>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar Siswa</h3>
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
                    <form action="index.php?page=kelola_kelas_siswa_tambah&kode_kelas=<?php echo $kode_kelas; ?>" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" id="nama" readonly class="form-control" placeholder="Nama" value="<?php echo $nama; ?>" required>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- table -->
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIS</th>
                                            <th>Siswa</th>
                                            <th>JK</th>
                                            <th>Pilih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $pecahTahunAjaran = explode("/", $tahun_ajaran);
                                            $tahunAJaranAwal = substr($pecahTahunAjaran[0], 2, 2);
                                            $tahunAjaranAkhir = substr($pecahTahunAjaran[1], 2, 2);
                                            $nisAwal = $tahunAJaranAwal.$tahunAjaranAkhir;
                                            
                                            $query = mysqli_query($koneksi,"
                                                SELECT * FROM siswa 
                                                WHERE nis NOT IN(SELECT nis from kelassiswa WHERE kode_kelas='$kode_kelas') AND left(nis, 4) <='$nisAwal' 
                                                AND nis NOT IN (SELECT nis from kelassiswa WHERE kode_kelas IN (SELECT kode_kelas FROM kelas WHERE tahun_ajaran ='$tahun_ajaran'))
                                                AND nis NOT IN (SELECT nis from kelassiswa WHERE kode_kelas IN (SELECT kode_kelas FROM kelas WHERE  jurusan!='$jurusan'))
                                                ORDER BY siswa.nama ASC
                                            ");
                                            $total = mysqli_num_rows($query);
                                            if($total == 0){
                                                echo "<tr>
                                                    <td colspan='2' class='text-center'>Tidak ada siswa yang bisa ditambahkan</td>
                                                </tr>";
                                            } else {
                                                $i= 1;
                                                while($data = mysqli_fetch_array($query)){
                                                    $nis = $data['nis'];
                                                    $nama_siswa = $data['nama'];
                                                    $jk = $data['jenis_kelamin'];
                                                    echo "<tr>
                                                        <td>$i</td>
                                                        <td>$nis</td>
                                                        <td>$nama_siswa</td>
                                                        <td>".($jk == 'L' ? 'Laki-laki' : 'Perempuan')."</td>
                                                        <td>
                                                            <input type='checkbox' name='nis[]' value='$nis'>
                                                        </td>";
                                                    $i++;
                                                }
                                            }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3"></th>
                                            <th>
                                               Laki Laki : <span class="badge bg-yellow" id="total_laki">0</span>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="3"></th>
                                            <th>
                                             Perempuan : <span class="badge bg-info" id="total_perempuan">0</span>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">Total Siswa Ditambahkan</th>
                                            <th>
                                               Total : <span class="badge bg-green" id="total">0</span>
                                            </th>
                                        </tr>

                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    <!-- button -->
                     <?php 
                      if ($total > 0) {
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
            <a href="index.php?page=kelola_kelas_siswa&kode_kelas=<?php echo $kode_kelas; ?>" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</section>

<script>
    // jika checkbox di klik
    document.querySelectorAll('input[type=checkbox]').forEach(item => {
        
        item.addEventListener('change', event => {
            var total = document.querySelectorAll('input[type=checkbox]:checked').length;
            document.getElementById('total').innerHTML = total;
            var totalChecked = document.querySelectorAll('input[type=checkbox]:checked');
            var totalLaki = 0;
            var totalPerempuan = 0;
            totalChecked.forEach(item => {
                var jk = item.parentElement.parentElement.children[3].innerHTML;
                if(jk == 'Laki-laki'){
                    totalLaki++;
                } else {
                    totalPerempuan++;
                }
            })
            document.getElementById('total_laki').innerHTML = totalLaki;
            document.getElementById('total_perempuan').innerHTML = totalPerempuan;
    
        })
    })
</script>