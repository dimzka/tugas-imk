<?php 
    if(isset($_GET['tanggal']) && isset($_GET['kode_kelas'])){
        $tanggal = $_GET['tanggal'];
        $kode_kelas = $_GET['kode_kelas'];
        $query = mysqli_query($koneksi, "SELECT * FROM kehadiransiswasekolah WHERE tanggal='$tanggal' AND kode_kelas='$kode_kelas'");
        $data = mysqli_fetch_array($query);
        if($data == null){
            echo "<script>
                window.location.href='index.php?page=kelola_kehadiran_siswa_sekolah_lihat&kode_kelas=$kode_kelas&error=4';
            </script>";  
        }
    
        $query = mysqli_query($koneksi, "DELETE FROM kehadiransiswasekolah WHERE tanggal='$tanggal' AND kode_kelas='$kode_kelas'");
        if($query){
            echo "<script>
                window.location.href='index.php?page=kelola_kehadiran_siswa_sekolah_lihat&kode_kelas=$kode_kelas&success=3';
            </script>";
        }else{
            echo "<script>
                window.location.href='index.php?page=kelola_kehadiran_siswa_sekolah_lihat&kode_kelas=$kode_kelas&error=3';
            </script>";
        }
        
    }else{
        echo "<script>
            window.location.href='index.php?page=kelola_kehadiran_siswa_sekolah_lihat&kode_kelas=$kode_kelas&error=3';
        </script>";
    }
?>