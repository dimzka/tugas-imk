<?php

    if(isset($_GET['kode_kelas']) AND isset($_GET['nis'])){
        $kode_kelas = $_GET['kode_kelas'];
        $nis = $_GET['nis'];
        $query = mysqli_query($koneksi, "SELECT * from kelassiswa WHERE kode_kelas='$kode_kelas' AND nis='$nis'");
        $data = mysqli_fetch_array($query);
        if($data == null){
            echo "<>
                window.location.href='index.php?page=kelola_kelas&error=5";
        } else {
            $query = mysqli_query($koneksi, "DELETE FROM kelassiswa WHERE kode_kelas='$kode_kelas' AND nis='$nis'");
            if($query){
                echo "<script>
                    window.location.href='index.php?page=kelola_kelas_siswa&success=3&kode_kelas=$kode_kelas';
                </script>";
            }else{
                echo "<script>
                    window.location.href='index.php?page=kelola_kelas&error=5';
                </script>";
            }
        }

    }else{
        echo "<script>
            window.location.href='index.php?page=kelola_kelas&kode_kelas=$kode_kelas&error=5';
        </script>";
    }