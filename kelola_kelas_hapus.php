<?php

    if(isset($_GET['kode_kelas'])){
        $kode_kelas = $_GET['kode_kelas'];
        $query = mysqli_query($koneksi, "SELECT * FROM kelas WHERE kode_kelas='$kode_kelas'");
        $data = mysqli_fetch_array($query);
        if($data == null){
            echo "<>
                window.location.href='index.php?page=kelola_kelas&error=5";
        } else {
            $query = mysqli_query($koneksi, "DELETE FROM kelas WHERE kode_kelas='$kode_kelas'");
            if($query){
                echo "<script>
                    window.location.href='index.php?page=kelola_kelas&success=3';
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