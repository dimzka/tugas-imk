<?php 
if(isset($_GET['kode_kelas'])){
    $kode_kelas = $_GET['kode_kelas'];
    $query = mysqli_query($koneksi, "SELECT * from kelas where kode_kelas='$kode_kelas'");
    $data = mysqli_fetch_array($query);
    if($data == null){
        echo "<>
            window.location.href='index.php?page=kelola_jadwal&error=5";
    } 
    $nama = $data['tingkat']."".$data['jurusan']."".$data['kelas']."-".$data['tahun_ajaran'];
    $tingkat = $data['tingkat'];
    $jurusan = $data['jurusan'];
    $kelas = $data['kelas'];
    $tahun_ajaran = $data['tahun_ajaran'];
}else{
    echo "<script>
        window.location.href='index.php?page=kelola_jadwal&kode_kelas=$kode_kelas&error=5';
    </script>";
}
  
?>
<section class="content-header">
   <h1>
      Daftar Jadwal Kelas
      <small>SMK Negeri 11 Garut</small>
   </h1>
</section>
<section class="content">
   <div class="box">
      <div class="box-header with-border">
         <h3 class="box-title">Daftar Jadwal Kelas</h3>
         <div class="box-tools pull-right">
            <a href="index.php?page=kelola_jadwal_tambah&kode_kelas=<?= $kode_kelas?>" class="btn btn-primary btn-sm" title=" Tambah Mata Pelajaran"

               data-toggle="tooltip" data-placement="top" data-original-title="
               Tambah Mata Pelajaran
               " style="margin-right: 5px;">

               <i class="fa fa-plus"></i>&nbsp; Tambah Mata Pelajaran
            </a>
         </div>
      </div>
      <div class="box-body">
         <div class="row" style="margin-bottom: 10px">
            <div class="col-md-12">
               <?php 
                  include_once 'errors.php';
                  include_once 'success.php';
               ?>
            </div>
            <div class="col-md-3">
               <form action="index.php" method="get">
                
               </form>
            </div>
            <div class="col-md-3">
               <form action="index.php?page=kelola_jadwal&q=<?= isset($_GET['q']) ? $_GET['q'] : '' ?>&halaman=<?= isset($_GET['halaman']) ? $_GET['halaman'] : '' ?>" method="get">
               
               </form>
            </div>
         </div>
         <div class="box-body table-responsive">
         <table class="table table-bordered table-striped">
            <thead>
               <tr>
                  <th>No</th>
                  <th>Mata Pelajaran</th>
                  <th>Guru</th>
                  <th>Aksi</th>
               </tr>
            </thead>
            <tbody>
               <?php 
                  $no = 1;
                  $query = "SELECT jadwal.id_jadwal, matapelajaran.nama as nama_matapelajaran, guru.nama as nama_guru, guru.nip from jadwal inner join mengajar on jadwal.kode_mengajar = mengajar.kode_mengajar inner join matapelajaran on mengajar.kode_matapelajaran = matapelajaran.kode_matapelajaran inner join guru on mengajar.id_guru = guru.id_guru where jadwal.kode_kelas = '$kode_kelas' group by jadwal.kode_mengajar";
                  $arrayJadwal = mysqli_query($koneksi, $query);
                    while ($result = mysqli_fetch_array($arrayJadwal)) {
            ?>
               <tr>
                  <td><?= $no++ ?></td>
                    <td><?= $result['nama_matapelajaran'] ?></td>
                    <td><?= $result['nama_guru'] ?> (<?= $result['nip'] == '' ? '-' : $result['nip'] ?>)</td>
                  <td>
                     <a 
                     onclick="return swal({
                        title: 'Apakah Anda Yakin?',
                        text: 'Anda akan menghapus data ini!',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Tidak, Batalkan!',
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger',
                        buttonsStyling: false
                     }, function(){
                        window.location.href='index.php?page=kelola_jadwal_hapus&id_jadwal=<?= $result['id_jadwal'] ?>&kode_kelas=<?= $kode_kelas ?>'
                     })"

               
                        data-toggle="tooltip" data-placement="top"
                     
                     class="btn btn-danger btn-sm" title="Hapus Mata Pelajaran">
                        <i class="fa fa-trash"></i>
                     </a>
                  </td>
                  </td>
               </tr>
               <?php } ?>
               <?php 
                  if (mysqli_num_rows($arrayJadwal) == 0) {
               ?>
               <tr>
                  <td colspan="5" align="center">Data Tidak Ditemukan</td>
               </tr>
               <?php } ?>

            </tbody>
         </table>
      </div>
   </div>
</section>