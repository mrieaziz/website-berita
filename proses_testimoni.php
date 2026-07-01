<?php
include 'koneksi/koneksi.php';

// Validasi bahwa user telah login
if (!isset($_SESSION['pelanggan_login'])) {
    header("Location: login_user.php");
    exit;
}

// Cek apakah form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama_user = mysqli_real_escape_string($koneksi, $_POST['nama_user']);
    $komentar = mysqli_real_escape_string($koneksi, $_POST['komentar']);
    $rating = intval($_POST['rating']);
    $tgl = date('Y-m-d');
    $status = 'Pending';
    
    // Validasi data
    if (empty($nama_user) || empty($komentar) || $rating < 1 || $rating > 5) {
        header("Location: testimoni.php?status=error");
        exit;
    }
    
    // Insert data ke database
    $query = "INSERT INTO tabel_testimoni (nama_user, komentar, rating, tgl, status, foto, balasan_admin) VALUES ('$nama_user', '$komentar', $rating, '$tgl', '$status', '', NULL)";
    
    if (mysqli_query($koneksi, $query)) {
        // Redirect ke halaman testimoni dengan status berhasil
        header("Location: testimoni.php?status=success");
        exit;
    } else {
        // Redirect dengan status error
        header("Location: testimoni.php?status=error");
        exit;
    }
} else {
    // Jika tidak ada form submission, redirect ke testimoni
    header("Location: testimoni.php");
    exit;
}
?>
