<?php

    if(isset($_GET['id_guru']) AND isset($_GET['kode_mengajar'])){
        $id_guru = $_GET['id_guru'];
        $kode_mengajar = $_GET['kode_mengajar'];
        $query = mysqli_query($koneksi, "SELECT * FROM mengajar WHERE kode_mengajar='$kode_mengajar'");
        $data = mysqli_fetch_array($query);
        if($data == null){
            echo "<>
                window.location.href='index.php?page=kelola_guru_mengajar&id_guru=$id_guru&error=5";
        } else {
            $query = mysqli_query($koneksi, "DELETE FROM mengajar WHERE kode_mengajar='$kode_mengajar'");
            if($query){
                echo "<script>
                    window.location.href='index.php?page=kelola_guru_mengajar&id_guru=$id_guru&success=3';
                </script>";
            }else{
                echo "<script>
                    window.location.href='index.php?page=kelola_guru_mengajar&id_guru=$id_guru&error=5';
                </script>";
            }
        }

    }else{
        echo "<script>
            window.location.href='index.php?page=kelola_guru&error=5';
        </script>";
    }