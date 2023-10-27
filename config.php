<?php 
$config_nama_sekolah = "SMK Negeri 11 Garut";
$config_alamat_sekolah = "Jl. Raya Cikalong, Cikalong, Kec. Cikalong, Kabupaten Garut, Jawa Barat 44152";
$config_no_wa = "0896-0000-0000";
$config_tahun_ajaran = date('Y')."/".(date('Y')+1);
$config_tahun_ajaran_aktif = 2022;

$config_jurusan = array (
    'TAV' => 'Teknik Audio Video',
    'TBSM' => 'Teknik Bisnis Sepeda Motor',
    'TKJ' => 'Teknik Komputer dan Jaringan',
    'OTKP' => 'Otomatisasi Tata Kelola Perkantoran',
);

$config_tingkat = array (
    'X' => 'X',
    'XI' => 'XI',
    'XII' => 'XII',
);

function formatTanggalBahasaIndonesia($tanggal){
    $tanggal = date('Y-m-d', strtotime($tanggal));
    $bulan = array (
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function formatWaktuBahasaIndonesia($dateTime){
  $tanggal = date('Y-m-d', strtotime($dateTime));
    $bulan = array (
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0]." ".date('H:i', strtotime($dateTime));

}

