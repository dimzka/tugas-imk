<?php
session_start();
require 'vendor/autoload.php';
require 'koneksi.php';
use Dompdf\Dompdf;

if(isset($_GET['kode_kelas']) AND isset($_GET['start']) AND isset($_GET['end'])){
    $kode_kelas = $_GET['kode_kelas'];

    $query = mysqli_query($koneksi, "SELECT kelas.tingkat, kelas.jurusan, kelas.tahun_ajaran, kelas.kelas, kelas.kode_kelas as kode_kelas FROM kelas  WHERE kelas.kode_kelas='$kode_kelas'");
    
    $data = mysqli_fetch_array($query);

    if($data == null){
        echo "<script>
            window.location.href='index.php?page=kelola_kelas&error=5';
        </script>";  
    }
    $nama = $data['tingkat']." ".$data['jurusan']." ".$data['kelas']." - ".$data['tahun_ajaran'];
    $nama_singkat = $data['tingkat']." ".$data['jurusan']." ".$data['kelas'];

    $query = mysqli_query($koneksi, "SELECT siswa.nama,siswa.nis FROM kelassiswa INNER JOIN siswa ON kelassiswa.nis=siswa.nis WHERE kelassiswa.kode_kelas='$kode_kelas' ORDER BY siswa.nama ASC");
    $id_kehadirans = array();
    $start = date('Y-m-d', strtotime($_GET['start']));
    $end = date('Y-m-d', strtotime($_GET['end']));
  
    $no = 1;
    $html = '<html lang="en"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rekap Absensi Kelas '.$nama_singkat.'</title>
        <style>
        .text-center {
            text-align: center;
          }
          .text-right {
            text-align: right;
          }
          .bottom-right {
            position: absolute;
            bottom: 40px;
            right: 100px;
          }
        </style>
    </head>
    <body>
        <h2 align="center">Rekap  Kehadiran</h2>
        <table>
            <tr>
                <td>Nama Kelas</td>
                <td>:</td>
                <td>'.$nama.'</td>
            </tr>
           

            <tr>
                <td>Periode</td>
                <td>:</td>
                <td>'.formatTanggalBahasaIndonesia($start).' s/d '.formatTanggalBahasaIndonesia($end).'</td>
            </tr>
        </table>
        <br>
        <table border="1" cellpadding="5" cellspacing="0" width="100%">
       
        <thead>
        <tr>
          <th rowspan="2">NO</th>
          <th rowspan="2">NAMA SISWA</th>
          <th style="width: 100px" rowspan="2"></th>
          <th colspan="4">KET</th>
        </tr>
        <tr>
          <th>S</th>
          <th>I</th>
          <th>A</th>
          <th>H</th>
        </tr>
      </thead>
<tbody>';
            while($data = mysqli_fetch_array($query)){
                $totalAlpa = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kehadiransiswasekolah WHERE tanggal BETWEEN '$start' AND '$end' AND nis='$data[nis]' AND keterangan='A' AND kode_kelas='$kode_kelas'"));
                $totalSakit = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kehadiransiswasekolah WHERE tanggal BETWEEN '$start' AND '$end' AND nis='$data[nis]' AND keterangan='S' AND kode_kelas='$kode_kelas'"));
                $totalIzin = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kehadiransiswasekolah WHERE tanggal BETWEEN '$start' AND '$end' AND nis='$data[nis]' AND keterangan='I' AND kode_kelas='$kode_kelas'"));
                $totalHadir = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kehadiransiswasekolah WHERE tanggal BETWEEN '$start' AND '$end' AND nis='$data[nis]' AND keterangan='H' AND kode_kelas='$kode_kelas'"));
                $html .= '<tr>
                    <td class="text-center">'.$no.'</td>
                    <td>'.strtoupper($data['nama']).'</td>
                    <td class="text-center">'.$nama_singkat.'</td>
                    <td class="text-center">'.$totalSakit.'</td>
                    <td class="text-center">'.$totalIzin.'</td>
                    <td class="text-center">'.$totalAlpa.'</td>
                    <td class="text-center">'.$totalHadir.'</td>
                </tr>';
                $no++;
            }
            $html .= '</tbody>
            <tfoot>
            <tr>
                <td colspan="7" class="text-center"> Waktu Download : '.formatWaktuBahasaIndonesia(date('Y-m-d H:i:s')).'</td>

            </tr>
            </tfoot>
            </table>
    </body>
    </html>';
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream('rekap_kelas_'.$nama_singkat.'_'.date('d-m-Y').'.pdf', array("Attachment" => false));
    exit(0);

    
}
 


