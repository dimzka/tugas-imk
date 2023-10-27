
<section class="content-header">
   <h1>
      Kelola Mata Pelajaran
      <small>SMK Negeri 11 Garut</small>
   </h1>
</section>
<section class="content">
   <div class="box">
      <div class="box-header with-border">
         <h3 class="box-title">Daftar Mata Pelajaran</h3>
         <div class="box-tools pull-right">
            <a href="index.php?page=kelola_mata_pelajaran_tambah" class="btn btn-primary btn-sm" title="Tambah Mata Pelajaran"

               data-toggle="tooltip" data-placement="top" data-original-title="
               Tambah Mata Pelajaran Baru
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
           
            <!-- search -->
            <div class="col-md-4 col-md-offset-8">
               <form action="index.php?page=kelola_mata_pelajaran&q=<?= isset($_GET['q']) ? $_GET['q'] : '' ?>&halaman=<?= isset($_GET['halaman']) ? $_GET['halaman'] : '' ?>" method="get">
                  <div class="input-group">
                     <input type="hidden" name="page" value="kelola_mata_pelajaran">
                  
                     <input type="text"  data-toggle="tooltip" data-placement="top" data-original-title="
                        Untuk mencari nama mata pelajaran"
                         name="q" class="form-control" placeholder="Cari Mata Pelajaran" value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>">
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
                  if ($q != ''){
                     $query = mysqli_query($koneksi, "SELECT * from matapelajaran WHERE kode_matapelajaran LIKE '%$q%' OR nama LIKE '%$q%'");
                     $mata_pelajaran = mysqli_query($koneksi, "SELECT * from matapelajaran WHERE kode_matapelajaran LIKE '%$q%' OR nama LIKE '%$q%' ORDER BY kode_matapelajaran DESC limit $start, $limit");
                  } else {
                     $query = mysqli_query($koneksi, "SELECT * from matapelajaran");
                     $mata_pelajaran = mysqli_query($koneksi, "SELECT * FROM matapelajaran  ORDER BY kode_matapelajaran DESC limit $start, $limit");
                  }
                  $countData = mysqli_num_rows($query);
                  $total = ceil($countData / $limit);

                  $no = $start + 1;
                  while($result = mysqli_fetch_array($mata_pelajaran)){
                 

               ?>
               <tr>
                  <td><?= $no++ ?></td>
                  <td><?= ucfirst($result['nama']) ?></td>
                  <td>
                     <a href="index.php?page=kelola_mata_pelajaran_edit&kode_matapelajaran=<?= $result['kode_matapelajaran'] ?>"
             
                        data-toggle="tooltip" data-placement="top" 
                     class="btn btn-warning btn-sm" title="Edit Mata Pelajaran">
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
                        window.location.href='index.php?page=kelola_mata_pelajaran_hapus&kode_matapelajaran=<?= $result['kode_matapelajaran'] ?>'
                     })"

               
                        data-toggle="tooltip" data-placement="top"
                     
                     class="btn btn-danger btn-sm" title="Hapus Mata Pelajaran">
                        <i class="fa fa-trash"></i>
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
                        <a href="index.php?page=kelola_mata_pelajaran&halaman=<?= $prev ?>&q=<?= isset($_GET['q']) ? $_GET['q'] : '' ?>" aria-label="Previous">
                           <span aria-hidden="true">&laquo;</span>
                        </a>
                     </li>
                     <?php } ?>
                     <?php for ($i=1; $i <= $total; $i++) { ?>
                      <li
                        <?php if ($page == $i) { ?>
                           class="active"
                        <?php } ?>

                      ><a href="index.php?page=kelola_mata_pelajaran&halaman=<?= $i ?>&q=<?= isset($_GET['q']) ? $_GET['q'] : '' ?>"
                           data-toggle="tooltip" data-placement="top"
                           title="Halaman <?= $i ?>"
                      ><?= $i ?></a></li>
                     <?php } ?>
                     <?php 
                        if ($page < $total) {
                     ?>
                     <li>
                        <a href="index.php?page=kelola_mata_pelajaran&halaman=<?= $next ?>&q=<?= isset($_GET['q']) ? $_GET['q'] : '' ?>"
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