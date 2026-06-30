<?php
session_start();
// Hapus data session pelanggan saja
unset($_SESSION['pelanggan_login']);
unset($_SESSION['id_pelanggan']);
unset($_SESSION['nama_pelanggan']);
header("Location: index.php");
exit;
?>