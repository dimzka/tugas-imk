<?php

    if(isset($_GET['nis'])){
        $nis = $_GET['nis'];
        $query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis='$nis'");
        $data = mysqli_fetch_array($query);
        if($data == null){
            echo "<>
                window.location.href='index.php?page=kelola_siswa&error=5";
        } else {
            $query = mysqli_query($koneksi, "DELETE FROM siswa WHERE nis='$nis'");
            if($query){
                echo "<script>
                    window.location.href='index.php?page=kelola_siswa&success=3';
                </script>";
            }else{
                echo "<script>
                    window.location.href='index.php?page=kelola_siswa&error=5';
                </script>";
            }
        }

    }else{
        echo "<script>
            window.location.href='index.php?page=kelola_siswa&nis=$nis&error=5';
        </script>";
    }