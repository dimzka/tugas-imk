<?php
include 'koneksi.php'; 
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


   session_start();
   if(isset($_SESSION['email'])){
      header("Location: index.php");
   }
   function sendEmail($email,$token) {
      $mail = new PHPMailer(true);
      try {
         $mail->SMTPDebug = 0;									
         $mail->isSMTP();											
         $mail->Host	 = 'mail.warungtehusi.com';					
         $mail->SMTPAuth = true;							
         $mail->Username = 'noreply@warungtehusi.com';				
         $mail->Password = 'eAGTGqQzpXrM';						
         $mail->SMTPSecure = 'tsl';							
         $mail->Port	 = 25;

         $mail->setFrom('noreply@warungtehusi.com', 'SMK 11 Negeri Garut');		
         $mail->addAddress($email);
         
         $mail->isHTML(true);								
         $mail->Subject = 'Reset Password';
         $mail->Body = 'Klik link berikut untuk mereset password anda: <a href="http://imk.pengembang.my.id/ubahpassword.php?email='.$email.'&token='.$token.'">http://imk.pengembang.my.id/ubahpassword.php?email='.$email.'&token='.$token.'</a>';
         $mail->send();
         return true;
      } catch (Exception $e) {
         return false;
      }
   }
if(isset($_POST['submit'])) {
   $email = mysqli_real_escape_string($koneksi,$_POST['email']);
   $level =  mysqli_real_escape_string($koneksi,$_POST['level']);
   if(!empty($email) AND !empty($level)){
      if($level == "guru"){
         $check = mysqli_query($koneksi,"SELECT * FROM guru WHERE email = '$email'");
         if(mysqli_num_rows($check) > 0){
            $row = mysqli_fetch_assoc($check);
            $token = md5("guru".$row['id_guru'].rand(1,1000));
            $token = substr($token, 0, 30);
            if(sendEmail($email,$token)){
               $update = mysqli_query($koneksi,"UPDATE guru SET token = '$token', expiredToken = DATE_ADD(NOW(), INTERVAL 10 MINUTE) WHERE email = '$email'");
               header("Location: lupapassword.php?success=6");
            } else {
               header("Location: lupapassword.php?error=6");
            }
         } else {
            header("Location: lupapassword.php?error=5");
         }
      } else {
         $check = mysqli_query($koneksi,"SELECT * FROM admin WHERE email = '$email' and role = '$level'");
         if(mysqli_num_rows($check) > 0){
            $row = mysqli_fetch_assoc($check);
            $token = $row['token'];
            $token = md5("admin".$row['id_admin'].rand(1,1000));
            $token = substr($token, 0, 30);
            if(sendEmail($email,$token)){
               $update = mysqli_query($koneksi,"UPDATE admin SET token = '$token', expiredToken = DATE_ADD(NOW(), INTERVAL 10 MINUTE) WHERE email = '$email'");

               header("Location: lupapassword.php?success=6");
            } else {
               header("Location: lupapassword.php?error=6");
            }
         } else {
            header("Location: lupapassword.php?error=5");
         }
      }
      
   } else {
      header("Location: lupapassword.php?error=1");
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
               <b>Lupa Password</b>
            </p>
            <?php 
               include_once "errors.php";
               include_once "success.php";
            ?>
            <form action="<?= 'lupapassword.php' ?>" method="post">
               <div class="form-group has-feedback">
                  <input type="email" name="email" class="form-control" placeholder="Email" required>
                  <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
               </div>
               <div class="form-group has-feedback">
                  <select class="form-control" name="level">
                     <option value="">Pilih Hak Akses</option>
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
                        <i class="fa fa-sign-in"></i> Reset
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