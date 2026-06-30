<?php
include 'koneksi/koneksi.php';

// Proteksi Halaman: Jika belum login, tendang ke form login.php
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$menu = isset($_GET['menu']) ? $_GET['menu'] : 'profile_pt';
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'tampil';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Management</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include 'komponen/navbar.php'; ?>

    <div class="dash-wrapper">
        <?php include 'komponen/sidebar.php'; ?>

        <div class="dash-content">
            <?php
            if ($menu == 'profile_pt') {
                include 'dashboard/manage_profile.php';
            } elseif ($menu == 'berita') {
                include 'dashboard/manage_berita.php';
            } elseif ($menu == 'bus') {
                include 'dashboard/manage_bus.php';
            } elseif ($menu == 'rute') {
                include 'dashboard/manage_rute.php';
            } elseif ($menu == 'testimoni') {
                include 'dashboard/manage_testimoni.php';
            }
            ?>
        </div>
    </div>
</body>

</html>