<?php 

if(isset($_GET['kode_kelas'])){
    $kode_kelas = $_GET['kode_kelas'];
    $query = mysqli_query($koneksi, "SELECT * from kelas where kode_kelas='$kode_kelas'");
    $data = mysqli_fetch_array($query);
    if($data == null){
        echo "<>
            window.location.href='index.php?page=kelola_jadwal&error=5";
    } 
    $nama = $data['tingkat']."".$data['jurusan']."".$data['kelas']."-".$data['tahun_ajaran'];
    $tingkat = $data['tingkat'];
    $jurusan = $data['jurusan'];
    $kelas = $data['kelas'];
    $tahun_ajaran = $data['tahun_ajaran']; 
}else{
    echo "<script>
        window.location.href='index.php?page=kelola_jadwal&kode_kelas=$kode_kelas&error=5';
    </script>";
}

if(isset($_POST['submit'])) {
    $errors = array();
    $kode_mengajar = isset($_POST['kode_mengajar']) ? $_POST['kode_mengajar'] : [];
    if($kode_mengajar != null) {
        foreach($kode_mengajar as $kode) {
            $query = mysqli_query($koneksi, "SELECT * from mengajar where kode_mengajar='$kode'");
            if(mysqli_num_rows($query) == 0 AND $kode != null) {
                $errors[] = "Kode Mengajar tidak ditemukan";
            } else if (mysqli_num_rows(mysqli_query($koneksi, "SELECT * from jadwal where kode_mengajar='$kode' AND kode_kelas='$kode_kelas'")) > 0) {
                $errors[] = "Kode Mengajar sudah ada di jadwal";
            } else {
                if ($kode != null) {
                    $query = mysqli_query($koneksi, "INSERT INTO jadwal (kode_mengajar, kode_kelas) VALUES ('$kode', '$kode_kelas')");
                }
            }
          
        }
    } else {
        $errors[] = "Pilih mata pelajaran";
    }
 
 
    if (count($errors) == 0) {
        echo "<script>
            window.location.href='index.php?page=kelola_jadwal_daftar&kode_kelas=$kode_kelas&success=1';
        </script>";
    } else {
        $_SESSION['errors'] = $errors;
    }
}
?>
<style>
    .hidden{
        display: none;
    }
</style>


<section class="content-header">
   <h1>
      Daftar Jadwal Kelas
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
                <div class="col-md-12 col-lg-12">
                    <form action="index.php?page=kelola_jadwal_tambah&kode_kelas=<?php echo $kode_kelas; ?>" method="post">
                        <input type="hidden" name="kode_kelas" value="<?php echo $kode_kelas; ?>">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Aksi
                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Centang Lalu, pilih guru yang akan mengajar mata pelajaran tersebut"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $mata_pelajaran = mysqli_query($koneksi, "SELECT matapelajaran.kode_matapelajaran, matapelajaran.nama as nama_matapelajaran FROM matapelajaran where kode_matapelajaran not in (SELECT kode_matapelajaran FROM jadwal inner join mengajar on jadwal.kode_mengajar = mengajar.kode_mengajar where jadwal.kode_kelas='$kode_kelas')");
                                    $no = 1;
                                    while($data = mysqli_fetch_array($mata_pelajaran)){
                                        echo "<tr>
                                            <td>$no</td>
                                            <td>$data[nama_matapelajaran]
                                            <br>
                                            <select name='kode_mengajar[]' id='kode_matapelajaran-$no-guru' class='hidden form-control'>
                                                    <option value=''>Pilih Guru</option>";
                                                    $guru = mysqli_query($koneksi, "SELECT guru.id_guru, guru.nama as nama_guru, mengajar.kode_mengajar as kode_mengajar FROM mengajar inner join guru on mengajar.id_guru = guru.id_guru where mengajar.kode_matapelajaran='$data[kode_matapelajaran]'");
                                                    while($data_guru = mysqli_fetch_array($guru)){
                                                        echo "<option value='$data_guru[kode_mengajar]'>$data_guru[nama_guru]</option>";
                                                    }
                                            echo "</select>
                                            </td>
                                            <td>
                                                <input type='checkbox'id='kode_matapelajaran-$no' onclick='showGuru(`$no`)'>
                                            </td>
                                        </tr>";
                                        $no++;
                                    }

                                    if (mysqli_num_rows($mata_pelajaran) == 0) {
                                        echo "<tr>
                                            <td colspan='3' class='text-center'>Tidak ada mata pelajaran yang tersedia</td>
                                        </tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                            <?php 
                                if(mysqli_num_rows($mata_pelajaran) > 0){
                                  ?>
                    <!-- button -->
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
            <a href="index.php?page=kelola_jadwal_daftar&kode_kelas=<?php echo $kode_kelas; ?>" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</section>

<script>
    function showGuru(no){
        console.log(no);
        var kode_matapelajaran = document.getElementById('kode_matapelajaran-'+no);
        var kode_matapelajaran_guru = document.getElementById('kode_matapelajaran-'+no+'-guru');
        if(kode_matapelajaran.checked == true){
            kode_matapelajaran_guru.classList.remove('hidden');
        }else{
            kode_matapelajaran_guru.classList.add('hidden');
        }
    }
</script>