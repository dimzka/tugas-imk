<?php
include 'koneksi.php'; 
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


   session_start();
   if(isset($_SESSION['email'])){
      header("Location: index.php");
   }

 if(isset($_GET['token']) AND isset($_GET['email'])) {
    $token = mysqli_real_escape_string($koneksi,$_GET['token']);
    $email = mysqli_real_escape_string($koneksi,$_GET['email']);
    $sql = mysqli_query($koneksi,"SELECT * FROM admin WHERE email='$email' AND token='$token' AND expiredToken > NOW()") or die(mysqli_error($koneksi));
    if(mysqli_num_rows($sql) == 0){
        $sql = mysqli_query($koneksi,"SELECT * FROM guru WHERE email='$email' AND token='$token' AND expiredToken > NOW()") or die(mysqli_error($koneksi));
        if(mysqli_num_rows($sql) == 0){
            header("Location: login.php");
        }
    }
 } else {
    header("Location: login.php");
 }

if(isset($_POST['submit'])) {
   $password = mysqli_real_escape_string($koneksi,$_POST['password']);
   $password_confirmation =  mysqli_real_escape_string($koneksi,$_POST['password_confirmation']);
   $token = mysqli_real_escape_string($koneksi,$_GET['token']);
  $email = mysqli_real_escape_string($koneksi,$_GET['email']);
   if(!empty($password) AND !empty($password_confirmation)) {
      if($password == $password_confirmation) {
         $password = password_hash($password, PASSWORD_DEFAULT);
         $sql = mysqli_query($koneksi, "SELECT * FROM admin WHERE email='$email' AND token='$token' AND expiredToken > NOW()") or die(mysqli_error($koneksi));
         if(mysqli_num_rows($sql) == 0){
            $sql = mysqli_query($koneksi, "SELECT * FROM guru WHERE email='$email' AND token='$token' AND expiredToken > NOW()") or die(mysqli_error($koneksi));
            if(mysqli_num_rows($sql) == 0){
               header("Location: login.php");
            } else {
               $sql = mysqli_query($koneksi, "UPDATE guru SET password='$password', token ='', expiredToken = null WHERE email='$email'") or die(mysqli_error($koneksi));
               if($sql) {
                  header("Location: login.php?success=7");
               } else {
                  header("Location: login.php?error=8");
               }
            }
         } else {
            $sql = mysqli_query($koneksi, "UPDATE admin SET password='$password', token='', expiredToken ='' WHERE email='$email'") or die(mysqli_error($koneksi));
            if($sql) {
               header("Location: login.php?success=7");
            } else {
               header("Location: login.php?error=8");
            }
         }
         
      } else {
         header("Location: ubahpassword.php?error=7&token=$token&email=$email");
      }
   } else {
      header("Location: ubahpassword.php?error=1&token=$token&email=$email");
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
               <b>Ubah Password</b>
            </p>
            <?php 
               include_once "errors.php";
               include_once "success.php";
            ?>
            <form action="<?= 'ubahpassword.php?token='.$token.'&email='.$email.'' ?>" method="post">
               <div class="form-group has-feedback">
                  <input type="password" name="password" class="form-control" placeholder="Password" required>
                 
               </div>
               <div class="form-group has-feedback">
                  <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
                  
               </div>
               <div class="row">
                  <div class="col-xs-8">
                  </div>
                  <div class="col-xs-4">
                     <button name="submit" type="submit" class="btn btn-primary btn-block btn-flat">
                        <i class="fa fa-edit"></i> Ubah 
                     </button>
                  </div>
               </div>
            </form>
            <a href="login.php">Kembali ke login </a><br>
         </div>
      </div>
      <script src="<?= 'assets/bower_components/jquery/dist/jquery.min.js' ?>" type="text/javascript"></script>
      <script src="<?= 'assets/bower_components/bootstrap/dist/js/bootstrap.min.js' ?>" type="text/javascript"></script>
      <script src="<?= 'assets/plugins/iCheck/icheck.min.js' ?>" type="text/javascript"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js" integrity="sha512-XVz1P4Cymt04puwm5OITPm5gylyyj5vkahvf64T8xlt/ybeTpz4oHqJVIeDtDoF5kSrXMOUmdYewE4JS/4RWAA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
     
        
    </body>
</html>