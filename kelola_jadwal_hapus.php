<?php

    if(isset($_GET['id_jadwal']) && isset($_GET['kode_kelas'])){
        $id_jadwal = $_GET['id_jadwal'];
        $kode_kelas = $_GET['kode_kelas'];
        $query = mysqli_query($koneksi, "SELECT * FROM jadwal WHERE id_jadwal='$id_jadwal'");
        $data = mysqli_fetch_array($query);
        if($data == null){
            echo "<>
            window.location.href='index.php?page=kelola_jadwal_daftar&kode_kelas=$kode_kelas&error=5";
        } else {
            $query = mysqli_query($koneksi, "DELETE FROM jadwal WHERE id_jadwal='$id_jadwal'");
            if($query){
                echo "<script>
                    window.location.href='index.php?page=kelola_jadwal_daftar&kode_kelas=$kode_kelas&success=3';
                </script>";
            }else{
                echo "<script>
                    window.location.href='index.php?page=kelola_jadwal_daftar&kode_kelas=$kode_kelas&error=5';
                </script>";
            }
        }

    }else{
        echo "<script>
            window.location.href='index.php?page=kelola_jadwal_daftar&kode_kelas=$kode_kelas&error=5';
        </script>";
    }