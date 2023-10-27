<?php
include 'koneksi.php'; 
// start session
   session_start();
   if(isset($_SESSION['email'])){
      header("Location: index.php");
   }
if(isset($_POST['submit'])) {
   $email = mysqli_real_escape_string($koneksi,$_POST['email']);
   $password = mysqli_real_escape_string($koneksi,$_POST['password']);
   $level =   mysqli_real_escape_string($koneksi,$_POST['level']);
   if(!empty($email) AND !empty($password) AND !empty($level)){
      if($level == "guru"){
         $sql = mysqli_query($koneksi,"SELECT * FROM guru WHERE email='$email' limit 1") or die(mysqli_error($koneksi));
         if(mysqli_num_rows($sql) > 0){
            $data = mysqli_fetch_assoc($sql);
            if(password_verify($password, $data['password'])){
               $_SESSION['login'] = true;
               $_SESSION['id'] = $data['id_guru'];
               $_SESSION['name'] = $data['nama'];
               $_SESSION['level'] = 'guru';
               $_SESSION['jenis_kelamin'] = $data['jenis_kelamin'];
               header("Location: login.php?success=4");
               exit();
            } else {
               header("Location: login.php?error=2");
            }
         }else{
            header("Location: login.php?error=2");
         }
       }else if($level == "staff"){
         $sql = mysqli_query($koneksi,"SELECT * FROM admin WHERE email='$email' AND role = 'staff' limit 1") or die(mysqli_error($koneksi));

         if(mysqli_num_rows($sql) == 1){
            $data = mysqli_fetch_assoc($sql);
            if (password_verify($password, $data['password'])) {
               $_SESSION['login'] = true;
               $_SESSION['id'] = $data['id_admin'];
               $_SESSION['name'] = $data['nama'];
               $_SESSION['level'] = 'staff';
               $_SESSION['jenis_kelamin'] =  "L";
               header("Location: login.php?success=4");
               exit();
            } else {
               header("Location: login.php?error=2");
            }
         }else{
            header("Location: login.php?error=2");
         }
      } else {
         $sql = mysqli_query($koneksi,"SELECT * FROM admin WHERE email='$email' AND role = 'admin' limit 1") or die(mysqli_error($koneksi));
         if(mysqli_num_rows($sql) == 1){
            $data = mysqli_fetch_assoc($sql);
            if (password_verify($password, $data['password'])) {
               $_SESSION['login'] = true;
               $_SESSION['id'] = $data['id_admin'];
               $_SESSION['name'] = $data['nama'];
               $_SESSION['level'] = 'admin';
               $_SESSION['jenis_kelamin'] =  "L";
               header("Location: login.php?success=4");
               exit();
            } else {
               header("Location: login.php?error=2");
            }
         }else{
            header("Location: login.php?error=2");
         }
      }
   } else {
      header("Location: login.php?error=1");
   }
}
?>


<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Masuk | SMK Negeri 11 Garut</title>
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <link rel="stylesheet" href="<?= 'assets/bower_components/bootstrap/dist/css/bootstrap.min.css' ?>">
      <link rel="stylesheet" href="<?= 'assets/bower_components/font-awesome/css/font-awesome.min.css' ?>">
      <link rel="stylesheet" href="<?= 'assets/bower_components/Ionicons/css/ionicons.min.css' ?>">
      <link rel="stylesheet" href="<?= 'assets/dist/css/AdminLTE.min.css' ?>">
      <link rel="stylesheet" href="<?= 'assets/plugins/iCheck/square/blue.css' ?>">
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" integrity="sha512-f8gN/IhfI+0E9Fc/LKtjVq4ywfhYAVeMGKsECzDUHcFJ5teVwvKTqizm+5a84FINhfrgdvjX8hEJbem2io1iTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
   <body class="hold-transition login-page">
      <div class="login-box">
         <div class="login-logo">
               <img src="https://www.smkn11garut.sch.id/wp-content/uploads/2020/02/logo-smkn11garut.png"
               alt="Logo SMK Negeri 11 Garut">
            </div>
         <div class="login-box-body">
          
            <p class="login-box-msg">
                Masuk untuk memulai sesi Anda
            </p>
            <?php 
               include_once "errors.php";
               include_once "success.php";
            ?>
            <form action="<?= 'login.php' ?>" method="post">
               <div class="form-group has-feedback">
                  <input type="text" name="email" class="form-control" placeholder="Email">
               </div>
               <div class="form-group has-feedback">
                  <input type="password" name="password" class="form-control" placeholder="Password">
               </div>
               <div class="form-group has-feedback">
                  <select class="form-control" name="level">
                     <option value="0">Pilih Hak Akses</option>
                     <option value="admin">Admin</option>
                     <option value="staff">Staff</option>
                     <option value="guru">Guru</option>
                  </select>
               </div>
               <div class="row">
                  <div class="col-xs-8">
                  </div>
                  <div class="col-xs-4">
                     <button name="submit" type="submit" class="btn btn-primary btn-block btn-flat">
                        <i class="fa fa-sign-in"></i> Masuk
                     </button>
                  </div>
               </div>
            </form>
            <a href="lupapassword.php">Lupa password ?</a><br>
         </div>
      </div>
      <script src="<?= 'assets/bower_components/jquery/dist/jquery.min.js' ?>" type="text/javascript"></script>
      <script src="<?= 'assets/bower_components/bootstrap/dist/js/bootstrap.min.js' ?>" type="text/javascript"></script>
      <script src="<?= 'assets/plugins/iCheck/icheck.min.js' ?>" type="text/javascript"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js" integrity="sha512-XVz1P4Cymt04puwm5OITPm5gylyyj5vkahvf64T8xlt/ybeTpz4oHqJVIeDtDoF5kSrXMOUmdYewE4JS/4RWAA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
     
        
    </body>
</html>