<?php 
    include_once '../koneksi.php';
function generateKelas($tingkat, $jurusan, $tahun_ajaran) {
    global $koneksi;
    $sql = "SELECT * FROM kelas WHERE tingkat = '$tingkat' AND jurusan = '$jurusan' AND tahun_ajaran = '$tahun_ajaran'";
    $result = mysqli_query($koneksi, $sql);
    $total_kelas = mysqli_num_rows($result);
    $kelasBaru = $total_kelas + 1;
    return "$tingkat".$jurusan."".$kelasBaru;
}


if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'generateKelas':
            if(isset($_POST['tingkat']) && isset($_POST['jurusan']) && isset($_POST['tahun_ajaran'])) {
                $tingkat = $_POST['tingkat'];
                $jurusan = $_POST['jurusan'];
                $tahun_ajaran = $_POST['tahun_ajaran'];
                $kelas = generateKelas($tingkat, $jurusan, $tahun_ajaran);
                echo $kelas;
            } else {
                echo "-";
            }
        break;
        case 'getWaliKelas':
            if(isset($_POST['tahun_ajaran'])) {
                $tahun_ajaran = $_POST['tahun_ajaran'];
                // cek guru yang belum menjadi wali kelas di tahun ajaran ini
                $sql = "SELECT * FROM guru WHERE id_guru NOT IN (SELECT id_guru FROM kelas WHERE tahun_ajaran = '$tahun_ajaran')";
                $result = mysqli_query($koneksi, $sql);
                $total_guru = mysqli_num_rows($result);
                if ($total_guru > 0) {
                    echo "<option value=''>Pilih Wali Kelas</option>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='".$row['id_guru']."'>".$row['nama']."</option>";
                    }
                } else {
                    echo "<option value=''>Tidak ada guru yang tersedia</option>";
                }
            } else {
                echo "<option value=''>Tidak ada guru yang tersedia</option>";
            }
        break;
        // case 'getWaliKelasEdit':
        //     if(isset($_POST['tahun_ajaran']) && isset($_POST['kode_kelas'])) {
        //         $tahun_ajaran = $_POST['tahun_ajaran'];
        //         $kode_kelas = $_POST['kode_kelas'];
        //         // cek guru yang belum menjadi wali kelas di tahun ajaran ini
        //         $sql = "SELECT * FROM guru WHERE id_guru NOT IN (SELECT id_guru FROM kelas WHERE tahun_ajaran = '$tahun_ajaran' AND kode_kelas != '$kode_kelas')";
        //         $result = mysqli_query($koneksi, $sql);
        //         $total_guru = mysqli_num_rows($result);
        //         if ($total_guru > 0) {
        //             echo "<option value=''>Pilih Wali Kelas</option>";
        //             while ($row = mysqli_fetch_assoc($result)) {
        //                 echo "<option value='".$row['id_guru']."'>".$row['nama']."</option>";
        //             }
        //         } else {
        //             echo "<option value=''>Tidak ada guru yang tersedia</option>";
        //         }
        //     } else {
        //         echo "<option value=''>Tidak ada guru yang tersedia</option>";
        //     }
        // break;
        default :
            echo "-";
        break;
    }
}
?>


