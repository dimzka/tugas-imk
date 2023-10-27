
<section class="content-header">
   <h1>
      Kelola Jadwal
      <small>SMK Negeri 11 Garut</small>
   </h1>
</section>
<section class="content">
   <div class="box">
      <div class="box-header with-border">
         <h3 class="box-title">Daftar Kelas</h3>
        
      </div>
      <div class="box-body">
         <div class="row" style="margin-bottom: 10px">
            <div class="col-md-12">
               <?php 
                  include_once 'errors.php';
                  include_once 'success.php';
               ?>
            </div>
            <div class="col-md-3 col-md-offset-3">
               <form action="index.php" method="get">
                  <div class="input-group">
                     <input type="hidden" name="page" value="kelola_jadwal">
                     <input type="hidden" name="q" value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>">
                     <input type="hidden" name="tahun_ajaran" value="<?= isset($_GET['tahun_ajaran']) ? $_GET['tahun_ajaran'] : '' ?>">
                     <select name="jurusan" class="form-control" onchange="this.form.submit()">
                        <option value="">Pilih Jurusan</option>
                        <?php 
                           $jurusan = mysqli_query($koneksi, "SELECT DISTINCT jurusan FROM kelas order by jurusan DESC");
                           while ($resultJurusan = mysqli_fetch_array($jurusan)) {
                              $selected = isset($_GET['jurusan']) && $_GET['jurusan'] == $resultJurusan['jurusan'] ? 'selected' : '';
                              echo '<option value="'.$resultJurusan['jurusan'].'" '.$selected.'>'.$resultJurusan['jurusan'].'</option>';
                           }
                        ?>
                     </select>
                     <span class="input-group-btn">
                        <button type="submit" 
                        class="btn btn-primary btn-flat"><i class="fa fa-search"></i></button>
                     </span>
                  </div>
               </form>
            </div>
            <div class="col-md-3">
               <form action="index.php?page=kelola_jadwal&q=<?= isset($_GET['q']) ? $_GET['q'] : '' ?>&halaman=<?= isset($_GET['halaman']) ? $_GET['halaman'] : '' ?>" method="get">
                  <div class="input-group">
                     <input type="hidden" name="page" value="kelola_jadwal">
                     <input type="hidden" name="q" value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>">
                     <input type="hidden" name="jurusan" value="<?= isset($_GET['jurusan']) ? $_GET['jurusan'] : '' ?>">
                     <!-- select -->
                     <select name="tahun_ajaran" class="form-control" onchange="this.form.submit()">
                        <option value="">Pilih Tahun Ajaran</option>
                        <?php 
                           $tahun_ajaran = mysqli_query($koneksi, "SELECT DISTINCT tahun_ajaran FROM kelas order by tahun_ajaran DESC");
                           while ($resultTahunAjaran = mysqli_fetch_array($tahun_ajaran)) {
                              $selected = isset($_GET['tahun_ajaran']) && $_GET['tahun_ajaran'] == $resultTahunAjaran['tahun_ajaran'] ? 'selected' : '';
                              echo '<option value="'.$resultTahunAjaran['tahun_ajaran'].'" '.$selected.'>'.$resultTahunAjaran['tahun_ajaran'].'</option>';
                           }
                        ?>
                     </select>
                     <span class="input-group-btn">
                        <button type="submit" 
        
                        class="btn btn-primary btn-flat"><i class="fa fa-search"></i></button>
                     </span>
                  </div>
               </form>
            </div>
 
            <!-- search -->
            <div class="col-md-3">
               <form action="index.php?page=kelola_jadwal&q=<?= isset($_GET['q']) ? $_GET['q'] : '' ?>&halaman=<?= isset($_GET['halaman']) ? $_GET['halaman'] : '' ?>" method="get">
                  <div class="input-group">
                        <input type="hidden" name="page" value="kelola_jadwal">
                  
                        <input type="hidden" name="jurusan" value="<?= isset($_GET['jurusan']) ? $_GET['jurusan'] : '' ?>">
                        <input type="hidden" name="tahun_ajaran" value="<?= isset($_GET['tahun_ajaran']) ? $_GET['tahun_ajaran'] : '' ?>">
                        
                     <input type="text"  data-toggle="tooltip" data-placement="top" data-original-title="
                        Untuk mencari kelas, masukkan nama kelas, jurusan, atau wali kelas."
                         name="q" class="form-control" placeholder="Cari Kelas" value="<?= isset($_GET['q']) ? $_GET['q'] : '' ?>">
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
                  <th>Kelas</th>
                  <th>Jurusan</th>
                  <th style="width: 100px">Tahun Ajaran</th>
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
                  $tahun_ajaran = isset($_GET['tahun_ajaran']) ? $_GET['tahun_ajaran'] : '';
                  $jurusan = isset($_GET['jurusan']) ? $_GET['jurusan'] : '';
                  $prev = $page - 1;
                  $next = $page + 1;
                  
                  if ($tahun_ajaran != '' && $jurusan != '') {
                     $kelas = mysqli_query($koneksi, "SELECT kelas.* FROM kelas WHERE  kelas.tahun_ajaran = '$tahun_ajaran' AND kelas.jurusan = '$jurusan' AND (kelas.tingkat LIKE '%$q%' OR kelas.jurusan LIKE '%$q%' OR kelas.tahun_ajaran LIKE '%$q%'  OR CONCAT(kelas.tingkat, ' ', kelas.jurusan, ' ', kelas.kelas) LIKE '%$q%') ORDER BY kelas.tahun_ajaran DESC, kelas.tingkat DESC LIMIT $start, $limit");
                     $query = mysqli_query($koneksi, "SELECT kelas.* FROM kelas WHERE  kelas.tahun_ajaran = '$tahun_ajaran' AND kelas.jurusan = '$jurusan' AND (kelas.tingkat LIKE '%$q%' OR kelas.jurusan LIKE '%$q%' OR kelas.tahun_ajaran LIKE '%$q%'  OR CONCAT(kelas.tingkat, ' ', kelas.jurusan, ' ', kelas.kelas) LIKE '%$q%') ORDER BY kelas.tahun_ajaran DESC, kelas.tingkat DESC");
                  } else if ($tahun_ajaran != '') {
                     $kelas = mysqli_query($koneksi, "SELECT kelas.* FROM kelas WHERE  kelas.tahun_ajaran = '$tahun_ajaran' AND (kelas.tingkat LIKE '%$q%' OR kelas.jurusan LIKE '%$q%' OR kelas.tahun_ajaran LIKE '%$q%'  OR CONCAT(kelas.tingkat, ' ', kelas.jurusan, ' ', kelas.kelas) LIKE '%$q%') ORDER BY kelas.tahun_ajaran DESC, kelas.tingkat DESC LIMIT $start, $limit");
                     $query = mysqli_query($koneksi, "SELECT kelas.* FROM kelas WHERE  kelas.tahun_ajaran = '$tahun_ajaran' AND (kelas.tingkat LIKE '%$q%' OR kelas.jurusan LIKE '%$q%' OR kelas.tahun_ajaran LIKE '%$q%'  OR CONCAT(kelas.tingkat, ' ', kelas.jurusan, ' ', kelas.kelas) LIKE '%$q%') ORDER BY kelas.tahun_ajaran DESC, kelas.tingkat DESC");
                  } else if ($jurusan != '') {
                     $kelas = mysqli_query($koneksi, "SELECT kelas.* FROM kelas WHERE  kelas.jurusan = '$jurusan' AND (kelas.tingkat LIKE '%$q%' OR kelas.jurusan LIKE '%$q%' OR kelas.tahun_ajaran LIKE '%$q%'  OR CONCAT(kelas.tingkat, ' ', kelas.jurusan, ' ', kelas.kelas) LIKE '%$q%') ORDER BY kelas.tahun_ajaran DESC, kelas.tingkat DESC LIMIT $start, $limit");
                     $query = mysqli_query($koneksi, "SELECT kelas.* FROM kelas WHERE kelas.jurusan = '$jurusan' AND (kelas.tingkat LIKE '%$q%' OR kelas.jurusan LIKE '%$q%' OR kelas.tahun_ajaran LIKE '%$q%'  OR CONCAT(kelas.tingkat, ' ', kelas.jurusan, ' ', kelas.kelas) LIKE '%$q%') ORDER BY kelas.tahun_ajaran DESC, kelas.tingkat DESC");
                  } else {
                     $kelas = mysqli_query($koneksi, "SELECT kelas.* FROM kelas WHERE (kelas.tingkat LIKE '%$q%' OR kelas.jurusan LIKE '%$q%' OR kelas.tahun_ajaran LIKE '%$q%'  OR CONCAT(kelas.tingkat, ' ', kelas.jurusan, ' ', kelas.kelas) LIKE '%$q%') ORDER BY kelas.tahun_ajaran DESC, kelas.tingkat DESC LIMIT $start, $limit"); 
                     $query = mysqli_query($koneksi, "SELECT kelas.* FROM kelas WHERE (kelas.tingkat LIKE '%$q%' OR kelas.jurusan LIKE '%$q%' OR kelas.tahun_ajaran LIKE '%$q%'  OR CONCAT(kelas.tingkat, ' ', kelas.jurusan, ' ', kelas.kelas) LIKE '%$q%') ORDER BY kelas.tahun_ajaran DESC, kelas.tingkat DESC");
                  }
                  $total = mysqli_num_rows($query);
                  $arrayKelas = mysqli_fetch_all($kelas, MYSQLI_ASSOC);

                  $countData = $total;
                  $total = ceil($countData / $limit);
                  $no = $start + 1;
                    
                foreach ($arrayKelas as $result) {
            ?>
               <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $result['tingkat'] ?> <?= $result['jurusan'] ?> <?= $result['kelas'] ?></td>
                  <td><?= $result['jurusan'] ?></td>
                  <td><?= $result['tahun_ajaran'] ?></td>
                  <td>
                        <a href="index.php?page=kelola_jadwal_daftar&kode_kelas=<?= $result['kode_kelas'] ?>" class="btn btn-info btn-sm"
                            data-toggle="tooltip" data-placement="top" title="Kelola Jadwal"><i class="fa fa-calendar"></i> Jadwal</a>
                  </td>
               </tr>
               <?php } ?>
               <?php 
                  if ($countData == 0) {
               ?>
               <tr>
               <td colspan="7" class="text-center">Data tidak ditemukan</td>
               </tr>
               <?php } ?>

            </tbody>
         </table>
         <?php 
               if ($countData > 1) {
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
                        <a href="index.php?page=kelola_jadwal&halaman=<?= $prev ?>&q=<?= isset($_GET['q']) ? $_GET['q'] : '' ?>&jurusan=<?= isset($_GET['jurusan']) ? $_GET['jurusan'] : '' ?>&tahun_ajaran=<?= isset($_GET['tahun_ajaran']) ? $_GET['tahun_ajaran'] : '' ?>"
                           <span aria-hidden="true">&laquo;</span>
                        </a>
                     </li>
                     <?php } ?>
                     <?php for ($i=1; $i <= $total; $i++) { ?>
                      <li
                        <?php if ($page == $i) { ?>
                           class="active"
                        <?php } ?>

                      ><a href="index.php?page=kelola_jadwal&halaman=<?= $i ?>&q=<?= isset($_GET['q']) ? $_GET['q'] : '' ?>&jurusan=<?= isset($_GET['jurusan']) ? $_GET['jurusan'] : '' ?>&tahun_ajaran=<?= isset($_GET['tahun_ajaran']) ? $_GET['tahun_ajaran'] : '' ?>"
                           data-toggle="tooltip" data-placement="top"
                           title="Halaman <?= $i ?>"
                      ><?= $i ?></a></li>
                     <?php } ?>
                     <?php 
                        if ($page < $total) {
                     ?>
                     <li>
                        <a href="index.php?page=kelola_jadwal&halaman=<?= $next ?>&q=<?= isset($_GET['q']) ? $_GET['q'] : '' ?>&jurusan=<?= isset($_GET['jurusan']) ? $_GET['jurusan'] : '' ?>&tahun_ajaran=<?= isset($_GET['tahun_ajaran']) ? $_GET['tahun_ajaran'] : '' ?>"
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