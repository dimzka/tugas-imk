<?php

    if(isset($_GET['kode_matapelajaran'])){
        $kode_matapelajaran = $_GET['kode_matapelajaran'];
        $query = mysqli_query($koneksi, "SELECT * FROM matapelajaran WHERE kode_matapelajaran='$kode_matapelajaran'");
        $data = mysqli_fetch_array($query);
        if($data == null){
            echo "<>
                window.location.href='index.php?page=kelola_mata_pelajaran&error=5";
        } else {
            $query = mysqli_query($koneksi, "DELETE FROM matapelajaran WHERE kode_matapelajaran='$kode_matapelajaran'");
            if($query){
                echo "<script>
                    window.location.href='index.php?page=kelola_mata_pelajaran&success=3';
                </script>";
            }else{
                echo "<script>
                    window.location.href='index.php?page=kelola_mata_pelajaran&error=5';
                </script>";
            }
        }

    }else{
        echo "<script>
            window.location.href='index.php?page=kelola_mata_pelajaran&kode_matapelajaran=$kode_matapelajaran&error=5';
        </script>";
    }