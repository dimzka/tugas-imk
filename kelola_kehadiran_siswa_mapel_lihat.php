<?php 
if(isset($_GET['id_jadwal'])){
    $id_jadwal = $_GET['id_jadwal'];
    $id_guru = $_SESSION['id'];
    $query = mysqli_query($koneksi, "SELECT * FROM jadwal WHERE id_jadwal='$id_jadwal'");
    $data = mysqli_fetch_array($query);
    if($data == null){
        echo "<script>
            window.location.href='index.php?page=kelola_kelas&error=5';
        </script>";  
    }
    $detail = mysqli_query($koneksi, "
    SELECT kelas.kode_kelas, kelas.tingkat,
    guru.nama as nama_guru,
    kelas.tahun_ajaran,
    kelas.kelas,
    kelas.jurusan,
    matapelajaran.nama as nama_mapel
    from jadwal
    inner join kelas on jadwal.kode_kelas = kelas.kode_kelas
    inner join mengajar on jadwal.kode_mengajar = mengajar.kode_mengajar
    inner join guru on mengajar.id_guru = guru.id_guru
    inner join matapelajaran on mengajar.kode_matapelajaran = matapelajaran.kode_matapelajaran
    where jadwal.id_jadwal = '$id_jadwal'
    GROUP BY kode_kelas
    ");
    $data_detail = mysqli_fetch_array($detail);
    $kelas = $data_detail['tingkat']." ".$data_detail['jurusan']." ".$data_detail['kelas']. " - ".$data_detail['tahun_ajaran'];
    $tahun_ajaran = $data_detail['tahun_ajaran'];
    $nama_mapel = $data_detail['nama_mapel'];
    $jurusan = $data_detail['jurusan'];
    $kode_kelas = $data_detail['kode_kelas'];
    $query_tanggal_awal = mysqli_query($koneksi, "SELECT tanggal FROM kehadiransiswamapel WHERE id_jadwal='$id_jadwal' ORDER BY tanggal ASC LIMIT 1");
    if(mysqli_num_rows($query_tanggal_awal) == 0){
        $tanggal_awal = date('m/d/Y');
    }else{
        $result_tanggal_awal = mysqli_fetch_array($query_tanggal_awal);
        $tanggal_awal = $result_tanggal_awal['tanggal'];
        $tanggal_awal = date('m/d/Y', strtotime($tanggal_awal));
    }

}else{
    echo "<script>
        window.location.href='index.php?page=kelola_kelas&error=5';
    </script>";
}

?>

<section class="content-header">
   <h1>
      Kelola Kehadiran Siswa
      <small>SMK Negeri 11 Garut</small>
   </h1>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Daftar Siswa</h3>
            <div class="box-tools pull-right">
                <a href="index.php?page=kelola_kehadiran_siswa_mapel_tambah&id_jadwal=<?= $id_jadwal ?>" class="btn btn-primary btn-sm"
                data-toggle="tooltip" data-placement="top" data-original-title="
                Tambah Kehadiran Siswa
                " style="margin-right: 5px;">

                <i class="fa fa-plus"></i>&nbsp;  Tambah Kehadiran Siswa
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="row" style="margin-bottom: 10px">
            <div class="col-md-12">
               <?php 
                  include_once 'errors.php';
                  include_once 'success.php';
               ?>
            </div>
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <h4><i class="icon fa fa-info"></i> Informasi</h4>
                        <p>
                            Kelas : <b><?= $kelas ?></b><br>
                            Mata Pelajaran: <b><?= $nama_mapel ?></b><br>
                        </p>
                    </div>
                </div>
                <div class="col-md-12" style="margin-bottom:10px;">
                <b>Keterangan : </b>
                <ul style="margin-top:10px">
                    <li style="display: flex"> 
                            <div style="background-color: #00a65a; color: white; text-align: center; width:20px; height:20px; margin-right:10px;">
                            <i class="fa fa-check" style="cursor: pointer;" data-toggle="tooltip" data-placement="bottom" data-original-title=""></i>
                        </div>
                        <p>Siswa/i <b>Hadir</b></p>
                    </li>
                    <li style="display: flex"> 
                            <div style="background-color: #00c0ef; color: white; text-align: center; width:20px; height:20px; margin-right:10px;">
                            <i class="fa fa-plane" style="cursor: pointer;" data-toggle="tooltip" data-placement="bottom" data-original-title=""></i>
                                </div>
                                <p>Siswa/i <b>Izin</b></p>
                    </li>
                    <li style="display: flex"> 
                            <div style="background-color: #f39c12; color: white; text-align: center; width:20px; height:20px; margin-right:10px;">
                            <i class="fa fa-bed" style="cursor: pointer;" data-toggle="tooltip" data-placement="bottom" data-original-title=""></i>
                                </div>
                                <p>Siswa/i <b>Sakit</b></p>
                    </li>
                    <li style="display: flex"> 
                            <div style="background-color: #dd4b39; color: white; text-align: center; width:20px; height:20px; margin-right:10px;">
                            <i class="fa fa-times" style="cursor: pointer;" data-toggle="tooltip" data-placement="bottom" data-original-title=""></i>
                                </div>
                                <p>Siswa/i <b>Alpa / Tidak Hadir</b></p>
                    </li>
                 
                </ul>
            </div>
                <div class="col-md-8 off-set-4-md"  style="margin-bottom: 10px">
               <form action="download_rekap_sekolah.php?page=download_rekap_sekolah&kode_kelas=<?= $kode_kelas ?>" method="get">
       
                   <!-- input date only month and year -->
                     <!-- input with icon download -->
                     <div class="form-group" style="margin-bottom: 0px;">
                        <label for="rangedate">Download Rekap kehadiran</label>
                        <div class="input-group">
                           <!-- input name="rangedate" -->
                           <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                           <input type="text" class="form-control pull-right" name="rangedate" id="rangedate" placeholder="Pilih tanggal awal dan akhir" value="<?= $tanggal_awal ?> - <?= date('m/t/Y') ?>">



                           <span class="input-group-btn">
                              <button type="button" onclick="downloadRekap()" class="btn btn-primary btn-flat"><i class="fa fa-download"></i>
                               Unduh Rekap kehadiran
                           </button>
                           </span>
                        </div>
                     </div>

               </form>
            </div>
                <div class="col-md-12 table-responsive">
                            <table class="table table-bordered table-striped">
                        <thead>
                        <?php 
                            $i= 1;
                            $kehadiran = mysqli_query($koneksi, "SELECT id_kehadiran,tanggal FROM kehadiransiswamapel inner join jadwal on kehadiransiswamapel.id_jadwal = jadwal.id_jadwal INNER JOIN mengajar on jadwal.kode_mengajar = mengajar.kode_mengajar where jadwal.id_jadwal = '$id_jadwal' AND mengajar.id_guru = '$id_guru' GROUP BY tanggal  ORDER BY tanggal ASC");
                            $totalkehadiran = mysqli_num_rows($kehadiran);
                    ?>
                        <tr>
                            <th rowspan="2" style="vertical-align : middle;text-align:center; width: 5px;" >No</th>
                            <th rowspan="2" style="vertical-align : middle;text-align:center;  width: 10px;" >NIS</th>
                            <th rowspan="2" style="vertical-align : middle;text-align:center; width: 200px;" >Nama Siswa</th>
                            <th rowspan="1" colspan="<?= $totalkehadiran ?> style="text-align: center;" class="text-center">Kehadiran</th>
                            <th rowspan="2" style="vertical-align : middle;text-align:center; width: 10px;">Persentase</th>
                        </tr>
                        <tr>
                            <?php 
                                while($datakehadiran = mysqli_fetch_array($kehadiran)){
                                    $tanggal = formatTanggalBahasaIndonesia($datakehadiran['tanggal']);
                               
                            echo "<th style='text-align: center; max-width: 10px;'
                             
                            >
                                <span data-toggle='tooltip' data-placement='bottom' data-original-title='
                                $tanggal 
                                ' style='cursor: pointer;'>
                                    $i
                                </span>
                            </th>";
                            $i++;
                                    
                                }
                            ?>

                        </tr>
                        </thead>
                        <tbody>
                            <?php
                           
                                $no = 1;
                                    $query = mysqli_query($koneksi, "SELECT siswa.nis as nis, siswa.nama as nama FROM siswa INNER JOIN kelassiswa ON siswa.nis = kelassiswa.nis WHERE kelassiswa.kode_kelas='$kode_kelas' ORDER BY siswa.nama ASC");
                                    while($result = mysqli_fetch_array($query)){
                                        $persentase = 0;
                                        $total = 0;
                                        $nis = $result['nis'];
                                        $nama_siswa = $result['nama'];
                                        $kehadiran = mysqli_query($koneksi, "SELECT id_kehadiran,tanggal FROM kehadiransiswamapel inner join jadwal on kehadiransiswamapel.id_jadwal = jadwal.id_jadwal INNER JOIN mengajar on jadwal.kode_mengajar = mengajar.kode_mengajar where jadwal.id_jadwal = '$id_jadwal' AND mengajar.id_guru = '$id_guru' GROUP BY tanggal  ORDER BY tanggal ASC");
            
                                    ?>
                                    <tr >
                                    <td style = "font-size: 14px; font-weight: bold; color: #000; align-content: center; text-align: center; vertical-align: middle;"><?= $no++ ?></td>
                                    <td style = "font-size: 14px; font-weight: bold; color: #000;"><?= $result['nis'] ?></td>
                                    <td style = "font-size: 14px;"><?= $result['nama'] ?></td>
                                        <!-- while kehadiran -->
                                        <?php 
                                            while($datakehadiran = mysqli_fetch_array($kehadiran)){
                                                $tanggal = $datakehadiran['tanggal'];
                                                $kehadiran_siswa = mysqli_query($koneksi, "SELECT * FROM kehadiransiswamapel WHERE tanggal = '$tanggal' AND nis = '$nis' AND id_jadwal = '$id_jadwal'");
                                                $datakehadiranSiswa = mysqli_fetch_array($kehadiran_siswa);
                                            
                                    
                                                if (isset($datakehadiranSiswa['keterangan']) && $datakehadiranSiswa['keterangan'] == 'H') {
                                                    echo "<td style='background-color: #00a65a; color: white; text-align: center;'>
                                                       <i class='fa fa-check'
                                               
                                                       ></i>
                                                    </td>";
                                                    $persentase += 1;
                                                 } else if (isset($datakehadiranSiswa['keterangan']) && $datakehadiranSiswa['keterangan'] == 'S') {
                                                    echo "<td style='background-color: #f39c12; color: white; text-align: center;'>
                                                       
                                                       <i class='fa fa-bed'
                                                    ></i>
                        
                                                    </td>";
                                                 } else if (isset($datakehadiranSiswa['keterangan']) && $datakehadiranSiswa['keterangan'] == 'I') {
                                                    echo "<td style='background-color: #00c0ef; color: white; text-align: center; text-align: center;'>
                                                       <i class='fa fa-plane'
                                                      >
                                                       </i>
                                                    </td>";
                                                 } else if (isset($datakehadiranSiswa['keterangan']) && $datakehadiranSiswa['keterangan'] == 'A') {
                                                    echo "<td style='background-color: #dd4b39; color: white; text-align: center;'>
                                                       <i class='fa fa-times'
                                                      
                                                       ></i>
                                                    </td>";
                                                 } else {
                                                    echo "<td></td>";
                                                 }
                                                 $total += 1;
                                            }
                                            ?>
                                             <?php 
                           if($total == 0) {
                              echo '<td colspan="2" align="center">Data Tidak Ditemukan</td>';
                           } else {
                              $persentase = ($persentase / $total) * 100;

                              echo '<td align="center">'.number_format($persentase, 2).'%</td>';
                           }
                        ?>
                                
                                    </tr>

                                    <?php 
                                    }

                                    if (mysqli_num_rows($query) == 0) {
                                        echo '<tr><td colspan="4" align="center">Data Tidak Ditemukan</td></tr>';
                                    }

                                    ?>
                       
                             
                                 
                       </tbody>
                       <tfooter>
              
                     
                     <?php 
                     $i= 1;
                     $kehadiran = mysqli_query($koneksi, "SELECT id_kehadiran,tanggal FROM kehadiransiswamapel inner join jadwal on kehadiransiswamapel.id_jadwal = jadwal.id_jadwal where kehadiransiswamapel.id_jadwal = '$id_jadwal' group by tanggal");
                         $totalkehadiran = mysqli_num_rows($kehadiran);
                         ?>
                    <tr>
                       <th rowspan="2" width="5%" style="text-align: center; vertical-align: middle;"></th>
                       <th rowspan="2" width="7%" style="text-align: center; vertical-align: middle;"></th>
                       <th rowspan="2" width="20%" style="text-align: center;"></th>
                       <th colspan="<?= $totalkehadiran ?>" style="text-align: center;"></th>
                       <th rowspan="2" max-width="10px" style="text-align: center; vertical-align: middle;"></th>
                    </tr>
                    <tr>
                    <?php
                  
                        while($datakehadiran = mysqli_fetch_array($kehadiran)){
                         
                            echo "<th style='text-align: center; max-width: 10px;'
                             
                            >
                        
                              <a href='index.php?page=kelola_kehadiran_siswa_mapel_edit&tanggal=$datakehadiran[tanggal]&id_jadwal=$id_jadwal' class='btn btn-warning btn-xs' data-toggle='tooltip' data-placement='bottom' data-original-title='Edit kehadiran Siswa'><i class='fa fa-edit
                              '></i></a>
                              <a 
                              onclick='hapuskehadiran(`index.php?page=kelola_kehadiran_siswa_mapel_hapus&tanggal=$datakehadiran[tanggal]&id_jadwal=$id_jadwal`)'
                                class='btn btn-danger btn-xs' data-toggle='tooltip' data-placement='bottom' data-original-title='Hapus kehadiran Siswa'><i class='fa fa-trash'></i>
                             </a>
                            </th>";
                            $i++;
                        }
                    ?>
                    

               </tr>  
                           <tr>
                               <td colspan="<?= $totalkehadiran + 4; ?>">
                                   <a href="index.php?page=kelola_kehadiran_siswa_mapel" class="btn btn-default btn-sm">
                                       <i class="fa fa-arrow-left"></i>&nbsp; Kembali
                                   </a>
                               </td>
                           </tr>
                        </tfooter>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
   function downloadRekap() {
      var id_jadwal = '<?php echo $id_jadwal; ?>';
      var range = document.getElementById('rangedate').value;
      // pecah 2 tanggal
      var tanggal = range.split(' - ');
      var tanggal_awal = tanggal[0];
      var tanggal_akhir = tanggal[1];
      window.open('download_rekap_guru.php?id_jadwal='+id_jadwal+'&start='+tanggal_awal+'&end='+tanggal_akhir, '_blank');
   }
   function hapuskehadiran(url) {
      swal({
                        title: 'Apakah Anda Yakin?',
                        text: 'Anda akan menghapus data ini!',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Tidak, Batalkan!',
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger',
                        buttonsStyling: false
                     }, function(){
                        window.location.href=url;
                     });
   }
</script>