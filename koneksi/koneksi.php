<?php
// Tampilkan error jika ada (agar tidak blank putih lagi)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$user = "root";
$pass = "";
// Ganti nama database di bawah ini sesuai kesepakatan kelompokmu
// Apakah "websitebus2" atau "db_beritas" (harus sama persis dengan di phpMyAdmin)
$db   = "db_berita_bus"; 

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>