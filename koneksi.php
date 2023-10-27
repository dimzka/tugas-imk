<?php
include_once 'config.php';
$username ="root";
$password ="";
$server ="localhost";
$database ="imk_super_clear";
$koneksi = mysqli_connect($server,$username,$password,$database)or die(mysqli_error($koneksi));