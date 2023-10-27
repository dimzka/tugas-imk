<!-- start session -->
<?php 
session_start();
if(!isset($_SESSION['id'])){
   header("location:login.php");
}

?>
<!-- 
    Nama Dosen Pengampu : Rani Susanto, S.Kom., M.Kom
    Mata Kuliah : Interaksi Manusia dengan Komputer
    Kelas : IF-4/S1/V
    https://www.smkn11garut.sch.id/wp-content/uploads/2020/02/logo-smk-n-11-garut.png
Kelas -->

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistem Pencatatan Kehadiran Siswa | SMK Negeri 11 Garut</title>
  <link rel="shortcut icon" href="https://www.smkn11garut.sch.id/wp-content/uploads/2020/02/logo-smkn11garut-32.png" type="image/x-icon" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
  <!-- Pace style -->
  <link rel="stylesheet" href="assets/plugins/pace/pace.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" integrity="sha512-f8gN/IhfI+0E9Fc/LKtjVq4ywfhYAVeMGKsECzDUHcFJ5teVwvKTqizm+5a84FINhfrgdvjX8hEJbem2io1iTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
      </head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">


  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
   <?php 
        include_once 'koneksi.php';
      include_once 'header.php';
      include_once 'main-sidebar.php';
    ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <?php 
       
            if($_SESSION['level'] == 'admin') {
                switch (isset($_GET['page']) ? $_GET['page'] : '') {
                  case 'dashboard':
                      include_once 'dashboard.php';
                      break;
                  case 'detail_kehadiran_siswa':
                        include_once 'detail_kehadiran_siswa.php';
                        break;
                  case 'kelola_siswa':
                      include_once 'kelola_siswa.php';
                      break;
                  case 'kelola_siswa_tambah':
                      include_once 'kelola_siswa_tambah.php';
                      break;
                  case 'kelola_siswa_edit':
                      include_once 'kelola_siswa_edit.php';
                      break;
                  case 'kelola_siswa_hapus':
                      include_once 'kelola_siswa_hapus.php';
                      break;
                  case 'kelola_guru':
                      include_once 'kelola_guru.php';
                      break;
                  case 'kelola_guru_tambah':
                      include_once 'kelola_guru_tambah.php';
                      break;
                  case 'kelola_guru_edit':
                      include_once 'kelola_guru_edit.php';
                      break;
                  case 'kelola_guru_hapus':
                      include_once 'kelola_guru_hapus.php';
                      break;
                  case 'kelola_kurikulum':
                        include_once 'kelola_kurikulum.php';
                        break;
                  case 'kelola_kurikulum_tambah':
                        include_once 'kelola_kurikulum_tambah.php';
                        break;
                  case 'kelola_kurikulum_edit':
                        include_once 'kelola_kurikulum_edit.php';
                        break;
                  case 'kelola_kurikulum_hapus':
                        include_once 'kelola_kurikulum_hapus.php';
                        break;
                  case 'kelola_mata_pelajaran':
                        include_once 'kelola_mata_pelajaran.php';
                        break;
                  case 'kelola_mata_pelajaran_tambah':
                        include_once 'kelola_mata_pelajaran_tambah.php';
                        break;
                  case 'kelola_mata_pelajaran_edit':
                        include_once 'kelola_mata_pelajaran_edit.php';
                        break;
                  case 'kelola_mata_pelajaran_hapus':
                        include_once 'kelola_mata_pelajaran_hapus.php';
                        break;
                  case 'kelola_guru_mengajar':
                        include_once 'kelola_guru_mengajar.php';
                        break;
                  case 'kelola_guru_mengajar_tambah':
                        include_once 'kelola_guru_mengajar_tambah.php';
                        break;
                  case 'kelola_guru_mengajar_hapus':
                        include_once 'kelola_guru_mengajar_hapus.php';
                        break;
                  case 'kelola_kelas':
                        include_once 'kelola_kelas.php';
                        break;
                  case 'kelola_kelas_tambah':
                        include_once 'kelola_kelas_tambah.php';
                        break;
                  case 'kelola_kelas_edit':
                        include_once 'kelola_kelas_edit.php';
                        break;
                  case 'kelola_kelas_hapus':
                        include_once 'kelola_kelas_hapus.php';
                        break;
                  case 'kelola_kelas_siswa':
                        include_once 'kelola_kelas_siswa.php';
                        break;
                  case 'kelola_kelas_siswa_tambah':
                        include_once 'kelola_kelas_siswa_tambah.php';
                        break;
                  case 'kelola_kelas_siswa_hapus':
                        include_once 'kelola_kelas_siswa_hapus.php';
                        break;
                  case 'kelola_jadwal':
                        include_once 'kelola_jadwal.php';
                        break;
                  case 'kelola_jadwal_daftar':
                        include_once 'kelola_jadwal_daftar.php';
                        break;
                  case 'kelola_jadwal_tambah':
                        include_once 'kelola_jadwal_tambah.php';
                        break;
                  case 'kelola_jadwal_hapus':
                        include_once 'kelola_jadwal_hapus.php';
                        break;
                  case 'download_rekap_sekolah':
                        include_once 'download_rekap_sekolah.php';
                        break;
                  case 'bantuan':
                        include_once 'bantuan.php';
                        break;
                  default:
                      include_once 'dashboard.php';
                      break;
              }
             }else if($_SESSION['level'] == 'staff') {
                  switch (isset($_GET['page']) ? $_GET['page'] : '') {
                    case 'dashboard':
                        include_once 'dashboard_staff.php';
                        break;
                    case 'kelola_kehadiran_siswa_sekolah':
                          include_once 'kelola_kehadiran_siswa_sekolah.php';
                          break;
                    case 'kelola_kehadiran_siswa_sekolah_lihat':
                          include_once 'kelola_kehadiran_siswa_sekolah_lihat.php';
                          break;
                    case 'kelola_kehadiran_siswa_sekolah_tambah':
                          include_once 'kelola_kehadiran_siswa_sekolah_tambah.php';
                          break;
                    case 'kelola_kehadiran_siswa_sekolah_edit':
                          include_once 'kelola_kehadiran_siswa_sekolah_edit.php';
                          break;
                    case 'kelola_kehadiran_siswa_sekolah_hapus':
                          include_once 'kelola_kehadiran_siswa_sekolah_hapus.php';
                          break;
                    case 'download_rekap_sekolah':
                          include_once 'download_rekap_sekolah.php';
                          break;
                    case 'bantuan':
                              include_once 'bantuan.php';
                              break;
                    default:
                        include_once 'dashboard_staff.php';
                        break;
                }
              
            } else {
                  switch (isset($_GET['page']) ? $_GET['page'] : '') {
                    case 'dashboard':
                        include_once 'dashboard_guru.php';
                        break;
                    case 'kelola_kehadiran_siswa_mapel':
                        include_once 'kelola_kehadiran_siswa_mapel.php';
                        break;
                    case 'kelola_kehadiran_siswa_mapel_lihat':
                        include_once 'kelola_kehadiran_siswa_mapel_lihat.php';
                        break;
                    case 'kelola_kehadiran_siswa_mapel_tambah':
                        include_once 'kelola_kehadiran_siswa_mapel_tambah.php';
                        break;
                    case 'kelola_kehadiran_siswa_mapel_edit':
                        include_once 'kelola_kehadiran_siswa_mapel_edit.php';
                        break;
                    case 'kelola_kehadiran_siswa_mapel_hapus':
                        include_once 'kelola_kehadiran_siswa_mapel_hapus.php';
                        break;
                    case 'kelola_kehadiran_walikelas':
                        include_once 'kelola_kehadiran_walikelas.php';
                        break;
                        case 'bantuan':
                              include_once 'bantuan.php';
                              break;
                    default:
                        include_once 'dashboard_guru.php';
                        break;
                }
            }
        ?>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2022-2023 <a href="https://www.smkn11garut.sch.id/">SMKN 11 Garut</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
 
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
      
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- PACE -->
<script src="assets/bower_components/PACE/pace.min.js"></script>
<!-- SlimScroll -->
<script src="assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="assets/bower_components/fastclick/lib/fastclick.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="assets/dist/js/demo.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js" integrity="sha512-XVz1P4Cymt04puwm5OITPm5gylyyj5vkahvf64T8xlt/ybeTpz4oHqJVIeDtDoF5kSrXMOUmdYewE4JS/4RWAA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- page script -->
<script type="text/javascript">
     
//   jika ada nama input rangedate
   $('input[name="rangedate"]').daterangepicker({
      
   });

  // To make Pace works on Ajax calls
  $(document).ajaxStart(function () {
    Pace.restart()
  })

</script>
</body>
</html>
