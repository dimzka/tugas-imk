<?php 
    if(isset($_GET['tanggal']) && isset($_GET['id_jadwal'])){
        $tanggal = $_GET['tanggal'];
        $id_jadwal = $_GET['id_jadwal'];
        $id_guru = $_SESSION['id'];
        $check = mysqli_query($koneksi, "SELECT * FROM kehadiransiswamapel inner join jadwal on kehadiransiswamapel.id_jadwal=jadwal.id_jadwal inner join mengajar on jadwal.kode_mengajar=mengajar.kode_mengajar WHERE kehadiransiswamapel.tanggal='$tanggal' AND kehadiransiswamapel.id_jadwal='$id_jadwal' AND mengajar.id_guru='$id_guru'");
        $data = mysqli_fetch_array($check);
        if($data == null){
            echo "<script>
                window.location.href='index.php?page=kelola_kehadiran_siswa_mapel_lihat&id_jadwal=".$_GET['id_jadwal']."&error=5';
            </script>";  
        }
        if(mysqli_num_rows($check) > 0){
            $query = mysqli_query($koneksi, "DELETE FROM kehadiransiswamapel WHERE tanggal='$tanggal' AND id_jadwal='$id_jadwal'");
            echo "<script>
                window.location.href='index.php?page=kelola_kehadiran_siswa_mapel_lihat&id_jadwal=".$_GET['id_jadwal']."&success=3';
            </script>";
        }else{
            echo "<script>
                window.location.href='index.php?page=kelola_kehadiran_siswa_mapel_lihat&id_jadwal=".$_GET['id_jadwal']."&error=5';
            </script>";
        }
        
    }else{
        echo "<script>
            window.location.href='index.php?page=kelola_kehadiran_siswa_mapel_lihat&id_jadwal=".$_GET['id_jadwal']."&error=5';
        </script>";
    }
?>