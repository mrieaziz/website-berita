<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// MASUKKAN DATA DARI HALAMAN MYSQL DATABASES INFINITYFREE ANDA
$host = "localhost";          // Ganti dengan MySQL Hostname hosting Anda
$user = "root";               // Ganti dengan MySQL Username hosting Anda
$pass = "";                   // Ganti dengan password akun hosting Anda
$db   = "website_berita1";    // Ganti dengan Nama Database hosting Anda

$koneksi = @mysqli_connect($host, $user, $pass, $db);

if ($koneksi) {
    mysqli_set_charset($koneksi, 'utf8mb4');
} else {
    error_log('Koneksi database gagal: ' . mysqli_connect_error());
}
?>