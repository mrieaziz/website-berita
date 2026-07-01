<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// MASUKKAN DATA DARI HALAMAN MYSQL DATABASES INFINITYFREE ANDA
$host = "localhost"; // Ganti dengan MySQL Hostname hosting Anda
$user = "root";            // Ganti dengan MySQL Username hosting Anda
$pass = "";           // Ganti dengan password akun hosting Anda
$db   = "websitebus2";     // Ganti dengan Nama Database hosting Anda

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { 
    die("Koneksi database gagal: " . mysqli_connect_error()); 
}
?>