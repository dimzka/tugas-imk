<?php

    if(isset($_GET['id_guru'])){
        $id_guru = $_GET['id_guru'];
        $query = mysqli_query($koneksi, "SELECT * FROM guru WHERE id_guru='$id_guru'");
        $data = mysqli_fetch_array($query);
        if($data == null){
            echo "<>
                window.location.href='index.php?page=kelola_guru&error=5";
        } else {
            $query = mysqli_query($koneksi, "DELETE FROM guru WHERE id_guru='$id_guru'");
            if($query){
                echo "<script>
                    window.location.href='index.php?page=kelola_guru&success=3';
                </script>";
            }else{
                echo "<script>
                    window.location.href='index.php?page=kelola_guru&error=5';
                </script>";
            }
        }

    }else{
        echo "<script>
            window.location.href='index.php?page=kelola_guru&id_guru=$id_guru&error=5';
        </script>";
    }