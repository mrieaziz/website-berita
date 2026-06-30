<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
<<<<<<< HEAD
// MASUKKAN DATA DARI HALAMAN MYSQL DATABASES INFINITYFREE ANDA
$host = "localhost"; // Ganti dengan MySQL Hostname hosting Anda
$user = "root";            // Ganti dengan MySQL Username hosting Anda
$pass = "";           // Ganti dengan password akun hosting Anda
$db   = "db_tiket_bus";     // Ganti dengan Nama Database hosting Anda
=======

$host = "localhost"; 
$user = "root"; 
$pass = ""; 
$db   = "website_berita";
>>>>>>> 4095e11b89833ed25fe552f7a4a2794bbab4c68d

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { 
    die("Koneksi database gagal: " . mysqli_connect_error()); 
}
?>