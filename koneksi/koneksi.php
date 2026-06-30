<?php
// Memulai session secara global untuk fitur login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost"; 
$user = "root"; 
$pass = ""; 
$db   = "websitebus";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { 
    die("Koneksi database gagal: " . mysqli_connect_error()); 
}
?>