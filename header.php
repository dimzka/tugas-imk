<header class="main-header">
            <a href="<?= '#'?>" class="logo">
            <span class="logo-mini"><b>S</b>MK</span>
            <span class="logo-lg"><b>SMKN</b>11</span>
            </a>
            <nav class="navbar navbar-static-top">
               <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </a>
               <div class="navbar-custom-menu">
                  <ul class="nav navbar-nav">
                  
                     <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= $_SESSION['jenis_kelamin'] == "L" ? "https://thumbs.dreamstime.com/b/elegant-man-business-suit-badge-man-business-avatar-profile-picture-vector-illustration-isolated-elegant-man-business-107918671.jpg": "https://thumbs.dreamstime.com/b/elegant-pretty-woman-business-suit-badge-woman-business-avatar-profile-picture-vector-illustration-isolated-elegant-pretty-107918847.jpg" ?>" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?= $_SESSION['name'] ?></span>
                        </a>
                        <ul class="dropdown-menu">
                           <li class="user-header">
                              <img src="<?= $_SESSION['jenis_kelamin'] == "L"? "https://thumbs.dreamstime.com/b/elegant-man-business-suit-badge-man-business-avatar-profile-picture-vector-illustration-isolated-elegant-man-business-107918671.jpg": "https://thumbs.dreamstime.com/b/elegant-pretty-woman-business-suit-badge-woman-business-avatar-profile-picture-vector-illustration-isolated-elegant-pretty-107918847.jpg" ?>" class="img-circle" alt="User Image">
                              <p>
                             
                                  <?=  $_SESSION['name'] ?>
                                 <small> <?= $_SESSION['level'] ?></small>
                              </p>
                           </li>
                           <li class="user-footer">
                              <div class="pull-right">
                                 <a href="logout.php" class="btn btn-default btn-flat">Keluar</a>
                              </div>
                           </li>
                        </ul>
                     </li>
                     <li>
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                     </li>
                  </ul>
               </div>
            </nav>
    </header>