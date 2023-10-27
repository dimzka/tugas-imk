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

        $query_tanggal_awal = mysqli_query($koneksi, "SELECT tanggal FROM kehadiransiswasekolah WHERE kode_kelas='$kode_kelas' ORDER BY tanggal ASC LIMIT 1");
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
  $get_bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m');
  $bulan = date('m', strtotime($get_bulan));
  $tahun = date('Y', strtotime($get_bulan));
  $total_siswa_query = mysqli_query($koneksi, "SELECT COUNT(*) AS total_siswa FROM kelassiswa WHERE kode_kelas='$kode_kelas'");
  $resultTotalSiswa = mysqli_fetch_array($total_siswa_query);
  $total_kelas_siswa = $resultTotalSiswa['total_siswa'];
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
            <a href="index.php?page=kelola_kehadiran_siswa_sekolah_tambah&kode_kelas=<?= $kode_kelas ?>" class="btn btn-primary btn-sm"


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
               <div class="alert alert-info">
                  <h4><i class="icon fa fa-info"></i> Informasi</h4>
                  <p>
                     Kelas : <b><?= $nama ?></b><br>
                     Total Siswa: <?= number_format($total_kelas_siswa) ?>
                  </p>
               </div>
            </div>
            <div class="col-md-12">
               <?php 
                  include_once 'errors.php';
                  include_once 'success.php';
               ?>
            </div>
            
            <!-- search -->
            <div class="col-md-8">
               <form action="download_rekap_sekolah.php?page=download_rekap_sekolah&kode_kelas=<?= $kode_kelas ?>" method="get">
                  <input type="hidden" name="page" value="kelola_kehadiran_siswa_sekolah_lihat">
                  <input type="hidden" name="kode_kelas" value="<?= $kode_kelas ?>">
                   <!-- input date only month and year -->
                     <!-- input with icon download -->
                     <div class="form-group" style="margin-bottom: 0px;">
                        <label for="rangedate">Download Rekap Kehadiran</label>
                        <div class="input-group">
                           <!-- input name="rangedate" -->
                           <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                           <input type="text" class="form-control pull-right" name="rangedate" id="rangedate" placeholder="Pilih tanggal awal dan akhir" value="<?= $tanggal_awal ?> - <?= date('m/t/Y') ?>">
                           <span class="input-group-btn">
                              <button type="button" onclick="downloadRekap()" class="btn btn-primary btn-flat"><i class="fa fa-download"></i>
                               Unduh Rekap Kehadiran
                           </button>
                           </span>
                           </span>
                        </div>
                     </div>
               </form>
            </div>
            <div class="col-md-4 ">
               <form action="index.php?page=kelola_kehadiran_siswa_sekolah_lihat&kode_kelas=<?= $kode_kelas ?>" method="get">
                  <input type="hidden" name="page" value="kelola_kehadiran_siswa_sekolah_lihat">
                  <input type="hidden" name="kode_kelas" value="<?= $kode_kelas ?>">
                 <!-- tampilkan berdasarkan bulan dan tahun -->
                   <!-- input date only month and year -->
                     <div class="form-group" style="margin-bottom: 0px;">
                        <label for="bulan">Bulan</label>
                        <input type="month" name="bulan" id="bulan" class="form-control" value="<?php echo $get_bulan; ?>"
                           onchange="this.form.submit()">
                     </div>  
               </form>
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
         </div>
         
         <div class="box-body table-responsive">
         <table class="table table-bordered table-striped">
         <thead>
            
            <?php 
            $i= 1;
                $absensiSekolah = mysqli_query($koneksi, "SELECT * FROM kehadiransiswasekolah WHERE kode_kelas='$kode_kelas' AND tanggal LIKE '$tahun-$bulan%' GROUP BY tanggal ORDER BY tanggal ASC");
                $totalKehadiran = mysqli_num_rows($absensiSekolah);
                ?>
           <tr>
                        <th rowspan="2" style="vertical-align : middle;text-align:center; width: 5px;" >No</th>
                        <th rowspan="2" style="vertical-align : middle;text-align:center;  width: 10px;" >NIS</th>
                        <th rowspan="2" style="vertical-align : middle;text-align:center; width: 200px;" >Nama Siswa</th>
                        <th rowspan="1" colspan="<?= $totalKehadiran ?>" style="text-align: center;" class="text-center">Kehadiran</th>
                        <th rowspan="2" style="vertical-align : middle;text-align:center; width: 10px;">Persentase</th>
           </tr>
           <tr>
                <?php
                    while($dataKehadiranSekolah = mysqli_fetch_array($absensiSekolah)){
                        $tanggal = formatTanggalBahasaIndonesia($dataKehadiranSekolah['tanggal']);
                        echo "<th style='text-align: center; max-width: 10px;'
                         
                        >
                            <span data-toggle='tooltip' data-placement='bottom' style='cursor: pointer;' data-original-title='Tanggal $tanggal' >
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
                  $q = isset($_GET['q']) ? $_GET['q'] : '';
                  $query = mysqli_query($koneksi, "SELECT siswa.nis FROM kelassiswa INNER JOIN siswa ON kelassiswa.nis=siswa.nis WHERE kelassiswa.kode_kelas='$kode_kelas' AND (siswa.nama LIKE '%$q%' OR siswa.nis LIKE '%$q%')");
                  $kelas_siswa = mysqli_query($koneksi, "SELECT siswa.nama, siswa.nis, kelassiswa.kode_kelas FROM kelassiswa INNER JOIN siswa ON kelassiswa.nis=siswa.nis WHERE kelassiswa.kode_kelas='$kode_kelas' AND (siswa.nama LIKE '%$q%' OR  siswa.nis LIKE '%$q%') ORDER BY siswa.nama ASC");
                
                  $countData = mysqli_num_rows($query);
                  $arrayKelasSiswa = mysqli_fetch_all($kelas_siswa, MYSQLI_ASSOC);

                    foreach ($arrayKelasSiswa as $result){
      
               ?>
               <tr >
                  <td style = "font-size: 14px; font-weight: bold; color: #000; align-content: center; text-align: center; vertical-align: middle;"><?= $no++ ?></td>
                  <td style = "font-size: 14px; font-weight: bold; color: #000; align-content: center; text-align: center; vertical-align: middle;"><?= $result['nis'] ?></td>
                  <td>
                    <?php 
                    // $nama_potongan =jika lebih dari 20 karakter maka potong
                    if($totalKehadiran > 20) {
                        $nama_potongan = strlen($result['nama']) > 10 ? substr($result['nama'], 0, 10).'...' : $result['nama'];
                    } else {
                        $nama_potongan = $result['nama'];
                    }
                    ?>
                    <?php 
                    if($totalKehadiran > 20) {
                        ?>
                    <a href="#" data-toggle="tooltip" data-placement="top" data-original-title="<?= $result['nama'] ?>"><?= $nama_potongan ?></a>
                    <?php
                    } else {
                        ?>
                    <?= $nama_potongan ?>
                    <?php
                    }
                    ?>
                  </td>
                  <?php 
                      $persentase = 0;
                      $total = 0;
                      $absensiSekolah = mysqli_query($koneksi, "SELECT * FROM kehadiransiswasekolah WHERE kode_kelas='$kode_kelas' AND tanggal LIKE '$tahun-$bulan%' GROUP BY tanggal ORDER BY tanggal ASC");
                      while ($dataKehadiranSekolah = mysqli_fetch_array($absensiSekolah)) {
                        $tanggal = $dataKehadiranSekolah['tanggal'];
                        $absensi = mysqli_query($koneksi, "SELECT * FROM kehadiransiswasekolah WHERE kode_kelas='$kode_kelas' AND tanggal='$tanggal' AND nis='$result[nis]'");
                        $dataKehadiran = mysqli_fetch_array($absensi);

                        $keterangan_tambahan = isset($dataKehadiran['keterangan_tambahan']) ? $dataKehadiran['keterangan_tambahan'] : '';
                        if (isset($dataKehadiran['keterangan']) && $dataKehadiran['keterangan'] == 'H') {
                            echo "<td style='background-color: #00a65a; color: white; text-align: center;'>
                               <i class='fa fa-check'
                                
                                 
                               ></i>
                            </td>";
                            $persentase += 1;
                         } else if (isset($dataKehadiran['keterangan']) && $dataKehadiran['keterangan'] == 'S') {
                            echo "<td style='background-color: #f39c12; color: white; text-align: center;'>
                               
                               <i class='fa fa-bed'
                                
                               ></i>

                            </td>";
                         } else if (isset($dataKehadiran['keterangan']) && $dataKehadiran['keterangan'] == 'I') {
                            echo "<td style='background-color: #00c0ef; color: white; text-align: center; text-align: center;'>
                               <i class='fa fa-plane'
                                
                                 >
                               </i>
                            </td>";
                         } else if (isset($dataKehadiran['keterangan']) && $dataKehadiran['keterangan'] == 'A') {
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
               <?php } ?>
               <?php 
                  if ($countData == 0) {
               ?>
               <tr>
                  <td colspan="5" align="center">Data Tidak Ditemukan</td>
               </tr>
               <?php } ?>

            </tbody>
            <tfooter>
                     
                <?php 
                $i= 1;
                    $absensiSekolah = mysqli_query($koneksi, "SELECT * FROM kehadiransiswasekolah WHERE kode_kelas='$kode_kelas' AND tanggal LIKE '$tahun-$bulan%' GROUP BY tanggal ORDER BY tanggal ASC");
                    $totalKehadiran = mysqli_num_rows($absensiSekolah);
                    ?>
               <tr>
                  <th rowspan="2" width="5%" style="text-align: center; vertical-align: middle;"></th>
                  <th rowspan="2" width="7%" style="text-align: center; vertical-align: middle;"></th>
                  <th rowspan="2" width="20%" style="text-align: center;"></th>
                  <th colspan="<?= $totalKehadiran ?>" style="text-align: center;"></th>
                  <th rowspan="2" max-width="10px" style="text-align: center; vertical-align: middle;"></th>
               </tr>
               <tr>
                    <?php
                        while($dataKehadiranSekolah = mysqli_fetch_array($absensiSekolah)){
                            $tanggal = formatTanggalBahasaIndonesia($dataKehadiranSekolah['tanggal']);
                            echo "<th style='text-align: center; max-width: 10px;'
                             
                            >
                        
                              <a href='index.php?page=kelola_kehadiran_siswa_sekolah_edit&kode_kelas=$kode_kelas&tanggal=$dataKehadiranSekolah[tanggal]' class='btn btn-warning btn-xs' data-toggle='tooltip' data-placement='bottom' data-original-title='Edit Kehadiran Siswa'><i class='fa fa-edit
                              '></i></a>
                              <a 
                               onclick='hapusKehadiran(`index.php?page=kelola_kehadiran_siswa_sekolah_hapus&kode_kelas=$kode_kelas&tanggal=$dataKehadiranSekolah[tanggal]`)'
                                 class='btn btn-danger btn-xs' data-toggle='tooltip' data-placement='bottom' data-original-title='Hapus Kehadiran Siswa'><i class='fa fa-trash'></i>
                              </a>
                            </th>";
                            $i++;
                        }
                    ?>
               </tr>
            </tfooter>
         </table>
      </div>
      <div class="box-footer">
            <a href="index.php?page=kelola_kehadiran_siswa_sekolah" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
   </div>
</section>

<script>
   function downloadRekap() {
      var kode_kelas = `<?= $kode_kelas ?>`;
      var range = document.getElementById('rangedate').value;
      // pecah 2 tanggal
      var tanggal = range.split(' - ');
      var tanggal_awal = tanggal[0];
      var tanggal_akhir = tanggal[1];
      // klik tombol download
      // window.location.href = ';
      // stay di halaman ini tetapi klik tombol download
      window.open('download_rekap_sekolah.php?kode_kelas='+kode_kelas+'&start='+tanggal_awal+'&end='+tanggal_akhir, '_blank');
   }
   function hapusKehadiran(url) {
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