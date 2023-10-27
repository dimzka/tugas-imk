<?php

    if(isset($_GET['nis'])){
        $nis = $_GET['nis'];
        $query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis='$nis'");
        $data = mysqli_fetch_array($query);
        if($data == null){
            echo "<script>
                window.location.href='index.php?page=kelola_siswa&error=5';
            </script>";  
        }
        $nama = $data['nama'];
        $jenis_kelamin = $data['jenis_kelamin'];
        // cek siswa ini masuk kekelas mana
        $query_kelas = mysqli_query($koneksi, "SELECT * FROM kelassiswa INNER JOIN kelas ON kelassiswa.kode_kelas=kelas.kode_kelas WHERE nis='$nis'");
    }else{
        echo "<script>
            window.location.href='index.php?page=kelola_siswa&nis=$nis&error=5';
        </script>";
    }
    $get_bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('Y-m');
    $bulan = date('m', strtotime($get_bulan));
    $tahun = date('Y', strtotime($get_bulan));
?>
<section class="content-header">
   <h1>
       Detail Kehadiran Siswa
      <small>SMK Negeri 11 Garut</small>
   </h1>
</section>
<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Siswa</h3>
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
                <div class="col-md-4">
                    <form action="index.php?page=detail_kehadiran_siswa&nis=<?= $nis ?>" method="get">
                        <!-- tampilkan berdasarkan bulan dan tahun -->
                        <!-- input date only month and year -->
                            <div class="form-group" style="margin-bottom: 0px;">
                                <label for="bulan">Bulan</label>
                                <input type="month" name="bulan" id="bulan" class="form-control" value="<?php echo $get_bulan; ?>"
                                onchange="this.form.submit()">
                            </div>  
                    </form>
                </div>
            </div>
            <div class="row">
            <div class="box-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        
                            <?php 
                            $i= 1;
                                $absensiSekolah = mysqli_query($koneksi, "SELECT * FROM kehadiransiswasekolah WHERE kode_kelas='$kode_kelas' AND tanggal LIKE '$tahun-$bulan%' GROUP BY tanggal");
                                $totalKehadiran = mysqli_num_rows($absensiSekolah);
                                ?>
                        <tr>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center; width: 5px;" >No</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;  width: 10px;" >NIS</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center; width: 200px;" >Nama Siswa</th>
                                        <th rowspan="1" colspan="<?= $totalKehadiran ?> style="text-align: center;" class="text-center">Kehadiran</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center; width: 10px;">Persentase</th>
                        </tr>
                        <tr>
                                <?php
                                    while($dataKehadiranSekolah = mysqli_fetch_array($absensiSekolah)){
                                        $tanggal = $dataKehadiranSekolah['tanggal'];
                                        echo "<th style='text-align: center; max-width: 10px;'
                                        
                                        >
                                            <span data-toggle='tooltip' data-placement='bottom' data-original-title='Tanggal $tanggal' style='cursor: pointer;'>
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
                            $limit = 100;
                            $page = isset($_GET['halaman']) ? $_GET['halaman'] : 1;
                            $start = ($page>1) ? ($page * $limit) - $limit : 0;
                            $q = isset($_GET['q']) ? $_GET['q'] : '';
                            $prev = $page - 1;
                            $next = $page + 1;
                            $query = mysqli_query($koneksi, "SELECT siswa.nis FROM kelassiswa INNER JOIN siswa ON kelassiswa.nis=siswa.nis WHERE kelassiswa.kode_kelas='$kode_kelas' AND (siswa.nama LIKE '%$q%' OR siswa.nis LIKE '%$q%')");
                            $kelas_siswa = mysqli_query($koneksi, "SELECT siswa.nama, siswa.nis, kelassiswa.kode_kelas FROM kelassiswa INNER JOIN siswa ON kelassiswa.nis=siswa.nis WHERE kelassiswa.kode_kelas='$kode_kelas' AND (siswa.nama LIKE '%$q%' OR  siswa.nis LIKE '%$q%') LIMIT $start, $limit");
                            
                            $countData = mysqli_num_rows($query);
                            $total = ceil($countData / $limit);
                            $arrayKelasSiswa = mysqli_fetch_all($kelas_siswa, MYSQLI_ASSOC);
                            usort($arrayKelasSiswa, function($a, $b) {
                                return $a['nama'] <=> $b['nama'];
                            });

                            $arrayKelasSiswa = array_filter($arrayKelasSiswa, function($siswa) use ($q){
                                return strpos(strtolower($siswa['nis'].' '.$siswa['nama']), strtolower($q)) !== false;            
                            });

                            $no = $start + 1;
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
                                $absensiSekolah = mysqli_query($koneksi, "SELECT * FROM kehadiransiswasekolah WHERE kode_kelas='$kode_kelas' AND tanggal LIKE '$tahun-$bulan%' GROUP BY tanggal");
                                while ($dataKehadiranSekolah = mysqli_fetch_array($absensiSekolah)) {
                                    $tanggal = $dataKehadiranSekolah['tanggal'];
                                    $absensi = mysqli_query($koneksi, "SELECT * FROM kehadiransiswasekolahdetail WHERE id_kehadiran = '$dataKehadiranSekolah[id_kehadiran]' AND nis = '$result[nis]'");
                                    $dataKehadiran = mysqli_fetch_array($absensi);
                                    $keterangan_tambahan = $dataKehadiran['keterangan_tambahan'] ? $dataKehadiran['keterangan_tambahan'] : 'Tidak ada keterangan tambahan';
                                    if ($dataKehadiran['keterangan'] == 'H') {
                                        echo "<td style='background-color: #00a65a; color: white; text-align: center;'>
                                        <i class='fa fa-check'
                                            style='cursor: pointer;'
                                            data-toggle='tooltip' data-placement='bottom' data-original-title='$keterangan_tambahan'
                                        ></i>
                                        </td>";
                                        $persentase += 1;
                                    } else if ($dataKehadiran['keterangan'] == 'S') {
                                        echo "<td style='background-color: #f39c12; color: white; text-align: center;'>
                                        
                                        <i class='fa fa-bed'
                                            style='cursor: pointer;'
                                        data-toggle='tooltip' data-placement='bottom' data-original-title='$keterangan_tambahan'></i>

                                        </td>";
                                    } else if ($dataKehadiran['keterangan'] == 'I') {
                                        echo "<td style='background-color: #00c0ef; color: white; text-align: center; text-align: center;'>
                                        <i class='fa fa-plane'
                                            style='cursor: pointer;'
                                            data-toggle='tooltip' data-placement='bottom' data-original-title='$keterangan_tambahan'>
                                        </i>
                                        </td>";
                                    } else if ($dataKehadiran['keterangan'] == 'A') {
                                        echo "<td style='background-color: #dd4b39; color: white; text-align: center;'>
                                        <i class='fa fa-times'
                                            style='cursor: pointer;'
                                            data-toggle='tooltip' data-placement='bottom' data-original-title='$keterangan_tambahan'
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
                        
                        </tfooter>
                    </table>
            </div>
        </div>
        <div class="box-footer">
            <!-- Tombol kembali -->
            <a href="index.php?page=kelola_siswa" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
            <!-- Tombol simpan -->
        </div>
    </div>
</section>