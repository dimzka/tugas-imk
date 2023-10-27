<?php
session_start();
require 'vendor/autoload.php';
require 'koneksi.php';
use Dompdf\Dompdf;

if(isset($_GET['id_jadwal']) AND isset($_GET['start']) AND isset($_GET['end'])){
    $id_jadwal = $_GET['id_jadwal'];
    $id_guru = $_SESSION['id'];
    $query = mysqli_query($koneksi, "SELECT kelas.tingkat, kelas.jurusan, kelas.tahun_ajaran, kelas.kelas, matapelajaran.nama as nama_matapelajaran, guru.nama as nama_guru, guru.nip as nip_guru, kelas.kode_kelas as kode_kelas FROM jadwal INNER JOIN kelas ON jadwal.kode_kelas=kelas.kode_kelas inner join mengajar on jadwal.kode_mengajar=mengajar.kode_mengajar inner join guru on mengajar.id_guru=guru.id_guru inner join matapelajaran on mengajar.kode_matapelajaran=matapelajaran.kode_matapelajaran WHERE jadwal.id_jadwal='$id_jadwal' AND mengajar.id_guru='$id_guru'");
    
    $data = mysqli_fetch_array($query);

    if($data == null){
        echo "<script>
            window.location.href='index.php?page=kelola_kelas&error=5';
        </script>";  
    }
    $nama = $data['tingkat']." ".$data['jurusan']." ".$data['kelas']." - ".$data['tahun_ajaran'];
    $kode_kelas = $data['kode_kelas'];
    $nama_singkat = $data['tingkat']." ".$data['jurusan']." ".$data['kelas'];

    $nama_guru = $data['nama_guru'];
    $nip_guru = $data['nip_guru'];
    $mata_pelajaran = $data['nama_matapelajaran'];
    $query = mysqli_query($koneksi, "SELECT siswa.nama,siswa.nis FROM kelassiswa INNER JOIN siswa ON kelassiswa.nis=siswa.nis WHERE kelassiswa.kode_kelas='$kode_kelas' ORDER BY siswa.nama ASC");
    $id_kehadirans = array();
    $start = date('Y-m-d', strtotime($_GET['start']));
    $end = date('Y-m-d', strtotime($_GET['end']));
    $no = 1;
    $html = '<html lang="en"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rekap Kehadiran</title>
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
        <h2 align="center">Rekap Kehadiran</h2>
        <table>
            <tr>
                <td>Nama Kelas</td>
                <td>:</td>
                <td>'.$nama.'</td>
            </tr>
            <tr>
                <td>Mata Pelajaran</td>
                <td>:</td>
                <td>'.$mata_pelajaran.'</td>
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
                $totalAlpa = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kehadiransiswamapel WHERE tanggal BETWEEN '$start' AND '$end' AND nis='$data[nis]' AND id_jadwal='$id_jadwal' AND keterangan='A'"));
                $totalSakit = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kehadiransiswamapel WHERE tanggal BETWEEN '$start' AND '$end' AND nis='$data[nis]' AND id_jadwal='$id_jadwal' AND keterangan='S'"));
                $totalIzin = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kehadiransiswamapel WHERE tanggal BETWEEN '$start' AND '$end' AND nis='$data[nis]' AND id_jadwal='$id_jadwal' AND keterangan='I'"));
                $totalHadir = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kehadiransiswamapel WHERE tanggal BETWEEN '$start' AND '$end' AND nis='$data[nis]' AND id_jadwal='$id_jadwal' AND keterangan='H'"));
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
 


