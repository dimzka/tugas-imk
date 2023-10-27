<?php 


if($_SESSION['level'] == "admin") {
   $menus = [
      [
         "name" => "Master Data",
         "icon" => "fa fa-dashboard",
         "type" => "header"
      ],
      [
         "name" => "Dashboard",
         "icon" => "fa fa-dashboard",
         "url" => "dashboard",
      ],
      [
         "name" => "Kelola Siswa",
         "icon" => "fa fa-users",
         "url" => "kelola_siswa"
      ],
      [
         "name" => "Kelola Guru",
         "icon" => "fa fa-user",
         "url" => "kelola_guru"
      ],
      [
         "name" => "Kelola Mata Pelajaran",
         "icon" => "fa fa-book",
         "url" => "kelola_mata_pelajaran"
      ],
      [
         "name" => "Kelola Kelas",
         "icon" => "fa fa-building",
         "url" => "kelola_kelas",
      ],
      [
         "name" => "Kelola Jadwal",
         "icon" => "fa fa-calendar",
         "url" => "kelola_jadwal"
      ],
      // [
      //    "name" => "Absen",
      //    "type" => "header"
      // ],
      // [
      //    "name" => "Kelola Absen Siswa",
      //    "icon" => "fa fa-book",
      //    "url" => "kelola_kehadiran_siswa_sekolah"
      // ],
      [
         "name" => "Informasi",
         "type" => "header"
      ],
      [
         "name" => "Bantuan",
         "icon" => "fa fa-question-circle",
         "url" => "bantuan"
      ],
   ];
} else if($_SESSION['level'] == 'staff') {
      $menus = [

        
         [
            "name" => "Staff",
            "type" => "header"
         ],
         [
            "name" => "Dashboard",
            "icon" => "fa fa-dashboard",
            "url" => "dashboard",
         ],
         [
            "name" => "Kelola Kehadiran Siswa",
            "icon" => "fa fa-book",
            "url" => "kelola_kehadiran_siswa_sekolah"
         ],
         [
            "name" => "Informasi",
            "type" => "header"
         ],
         [
            "name" => "Bantuan",
            "icon" => "fa fa-question-circle",
            "url" => "bantuan"
         ],
        
      ];
} else {

      $menus = [
         [
            "name" => "Guru",
            "icon" => "fa fa-dashboard",
            "type" => "header"
         ],
         [
            "name" => "Dashboard",
            "icon" => "fa fa-dashboard",
            "url" => "dashboard",
         ],
         [
            "name" => "Kelola Kehadiran Siswa",
            "icon" => "fa fa-book",
            "url" => "kelola_kehadiran_siswa_mapel"
         ],
         [
            "name" => "Informasi",
            "type" => "header"
         ],
         [
            "name" => "Bantuan",
            "icon" => "fa fa-question-circle",
            "url" => "bantuan"
         ],
      ];
   }


?>
<aside class="main-sidebar">
            <section class="sidebar">
               <div class="user-panel">
                  <div class="pull-left image">
                     <img src="<?= $_SESSION['jenis_kelamin'] == "L"? "https://thumbs.dreamstime.com/b/elegant-man-business-suit-badge-man-business-avatar-profile-picture-vector-illustration-isolated-elegant-man-business-107918671.jpg": "https://thumbs.dreamstime.com/b/elegant-pretty-woman-business-suit-badge-woman-business-avatar-profile-picture-vector-illustration-isolated-elegant-pretty-107918847.jpg" ?>" class="img-circle" alt="User Image">
                  </div>
                  <div class="pull-left info">
                     <p><?= $_SESSION['name'] ?></p>
                     <a href="#"><i class="fa fa-circle text-success"></i> <?php if($_SESSION['level'] == 'admin') { echo "Admin"; } else if($_SESSION['level'] == 'staff') { echo "Staff"; } else { echo "Guru"; } ?></a>
                  </div>
               </div>
                <hr>
               <ul class="sidebar-menu" data-widget="tree">
    
                  <?php foreach($menus as $menu): ?>
                     <?php if(isset($menu['type']) && $menu['type'] == "header"): ?>
                        <li class="header"><?= $menu['name'] ?></li>
                     <?php else: ?>
                        <li class="<?= isset($menu['children']) ? 'treeview' : '' ?> 

                        <?php 
                           $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
                        if($page == $menu['url'] || $page == $menu['url'].'_tambah' || $page == $menu['url'].'_edit'): ?>
                           active
                        <?php endif; ?>


                        ">

                           <a href="index.php?page=<?= $menu['url'] ?>">
                              <i class="<?= $menu['icon'] ?>"></i> <span><?= $menu['name'] ?></span>
                              <?php if(isset($menu['children'])): ?>
                                 <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                 </span>
                              <?php endif; ?>
                           </a>
                           <?php if(isset($menu['children'])): ?>
                              <ul class="treeview-menu">
                                 <?php foreach($menu['children'] as $child): ?>
                                    <li><a href="index.php?page=<?= $child['url'] ?>"><i class="<?= $child['icon'] ?>"></i> <?= $child['name'] ?></a></li>
                                 <?php endforeach; ?>
                              </ul>
                           <?php endif; ?>
                        </li>
                     <?php endif; ?>
                  <?php endforeach; ?>
                </ul>
            </section>
         </aside>