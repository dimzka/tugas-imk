<section class="content-header">
   <h1>
      Kelola Guru
      <small>SMK Negeri 11 Garut</small>
   </h1>
</section>
<section class="content">
   <div class="box">
      <div class="box-header with-border">
         <h3 class="box-title">Daftar Guru</h3>
         <div class="box-tools pull-right">
            <a href="index.php?page=kelola_guru_tambah" class="btn btn-primary btn-sm" title="Tambah Guru"

               data-toggle="tooltip" data-placement="top" data-original-title="
               Tambah Guru Baru
               " style="margin-right: 5px;">

               <i class="fa fa-plus"></i>&nbsp; Tambah Guru
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
            <!-- search -->
            <div class="col-md-4 col-md-offset-8">
               <form action="index.php?page=kelola_guru&q=<?= isset($_GET['q']) ? $_GET['q'] : '' ?>&halaman=<?= isset($_GET['halaman']) ? $_GET['halaman'] : '' ?>" method="get">
                  <div class="input-group">
                     <input type="hidden" name="page" value="kelola_guru">
                     <input type="text"  data-toggle="tooltip" data-placement="top" data-original-title="
                        Untuk mencari guru, bisa menggunakan nip, nama, atau email"
                         name="q" class="form-control" placeholder="Cari Guru" value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>">
                     <span class="input-group-btn">
                        <button type="submit" 
        
                        class="btn btn-primary btn-flat"><i class="fa fa-search"></i></button>
                     </span>
                  </div>
               </form>
            </div>
         </div>
         <div class="box-body table-responsive">
         <table class="table table-bordered table-striped">
            <thead>
               <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>NIP</th>
                  <th>Jenis Kelamin</th>
                  <th>Aksi</th>
               </tr>
            </thead>
            <tbody>
               <?php 
                  $no = 1;
                  $limit = 10;
                  $page = isset($_GET['halaman']) ? $_GET['halaman'] : 1;
                  $start = ($page>1) ? ($page * $limit) - $limit : 0;
                  $q = isset($_GET['q']) ? $_GET['q'] : '';
                  $prev = $page - 1;
                  $next = $page + 1;
                  if ($q != '') {
                     $query = mysqli_query($koneksi, "SELECT * FROM guru WHERE id_guru LIKE '%$q%' OR nama LIKE '%$q%' OR email LIKE '%$q%' OR nip LIKE '%$q%'");
                     $guru = mysqli_query($koneksi, "SELECT * FROM guru WHERE id_guru LIKE '%$q%' OR  nama LIKE '%$q%' OR email LIKE '%$q%' OR nip LIKE '%$q%' ORDER BY id_guru DESC limit $start, $limit");
                  } else {
                     $query = mysqli_query($koneksi, "SELECT * FROM guru");
                     $guru = mysqli_query($koneksi, "SELECT * FROM guru ORDER BY id_guru DESC limit $start, $limit");
                  }
                  $countData = mysqli_num_rows($query);
                  $total = ceil($countData / $limit);

                  $no = $start + 1;
                  while($result = mysqli_fetch_array($guru)){
      
               ?>
               <tr>
                  <td><?= $no++ ?></td>
                  <td><?= ucwords($result['nama']) ?></td>
                  <td><?= $result['email'] ?></td>
                  <td><?php 
                         if($result['nip'] == ''){
                           echo "<span class='label label-danger'>Belum Diisi</span>";
                         } else {
                           echo $result['nip'];
                         }
                  ?></td>
                  <td>
                     <?php 
                        if ($result['jenis_kelamin'] == 'L') {
                           echo "<i class='fa fa-mars'></i> Laki Laki";
                        } else {
                           echo "<i class='fa fa-venus'></i> Perempuan";
                        }
                     ?>
                  </td>
                  <td>
                     <a href="index.php?page=kelola_guru_edit&id_guru=<?= $result['id_guru'] ?>"
             
                        data-toggle="tooltip" data-placement="top" 
                     class="btn btn-warning btn-sm" title="Edit Guru">
                        <i class="fa fa-edit
                        "></i>
                     </a>
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
                        window.location.href='index.php?page=kelola_guru_hapus&id_guru=<?= $result['id_guru'] ?>'
                     })"

               
                        data-toggle="tooltip" data-placement="top"
                     
                     class="btn btn-danger btn-sm" title="Hapus Guru">
                        <i class="fa fa-trash"></i>
                     </a>
                     <a href="index.php?page=kelola_guru_mengajar&id_guru=<?= $result['id_guru'] ?>"
                           data-toggle="tooltip" data-placement="top" 
                        class="btn btn-info btn-sm" title="Kelola Mengajar">
                           <i class="fa fa-book"></i> Kelola Mengajar
                     </a>
                  </td>
               </tr>
               <?php } ?>
               <?php 
                  if ($countData == 0) {
               ?>
               <tr>
                  <td colspan="5" align="center">Data Tidak Ditemukan</td>
               </tr>
               <?php } ?>

            </tbody>
         </table>
            <?php 
               if ($countData > 0) {
            ?>
             <div class="row">
            <div class="col-md-12">
               <nav aria-label="Page navigation">
                  <ul class="pagination
                  ">
                     <?php 
                        if ($page > 1) {
                     ?>
                     <li>
                        <a href="index.php?page=kelola_guru&halaman=<?= $prev ?>&q=<?= isset($_GET['q']) ? $_GET['q'] : '' ?>" aria-label="Previous">
                           <span aria-hidden="true">&laquo;</span>
                        </a>
                     </li>
                     <?php } ?>
                     <?php for ($i=1; $i <= $total; $i++) { ?>
                      <li
                        <?php if ($page == $i) { ?>
                           class="active"
                        <?php } ?>

                      ><a href="index.php?page=kelola_guru&halaman=<?= $i ?>&q=<?= isset($_GET['q']) ? $_GET['q'] : '' ?>"
                           data-toggle="tooltip" data-placement="top"
                           title="Halaman <?= $i ?>"
                      ><?= $i ?></a></li>
                     <?php } ?>
                     <?php 
                        if ($page < $total) {
                     ?>
                     <li>
                        <a href="index.php?page=kelola_guru&halaman=<?= $next ?>&q=<?= isset($_GET['q']) ? $_GET['q'] : '' ?>"
                           data-toggle="tooltip" data-placement="top"
                           title="Halaman <?= $next ?>"
                        aria-label="Next">
                           <span aria-hidden="true">&raquo;</span>
                        </a>
                     </li>
                     <?php 
                        }
                     ?>
                  </ul>
               </nav>
               <div class="pull-right">
                  <p>Halaman <?= $page ?> dari <?= $total ?></p>
               </div>
            </div>
        
</div> 
      </div>
            <?php } ?>

      </div>
   </div>
</section>