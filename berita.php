<?php
error_reporting(0);
include 'koneksi/koneksi.php';
$activePage = 'berita';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita & Info Terbaru - PO Sarana Ciledug</title>
    <link rel="stylesheet" href="css/style.css?v=20260701">
</head>
<body>
    <?php include 'komponen/header.php'; ?>

    <main class="page-main">
        <!-- 1. Header Halaman Tetap di Atas -->
        <section class="page-header page-header--alt">
            <p class="eyebrow">Berita & Pengumuman</p>
            <h1>Update Terbaru untuk Perjalanan Anda</h1>
            <p>Informasi rute, promo, dan pengumuman penting dari PO Sarana Ciledug agar perjalanan Anda selalu lancar.</p>
        </section>

        <!-- 2. DAFTAR BERITA DIPINDAHKAN KE ATAS (Langsung terlihat setelah header) -->
        <section class="card-grid news-grid">
            <?php 
            $query = mysqli_query($koneksi, "SELECT * FROM tabel_berita ORDER BY id_berita DESC");
            
            if ($query && mysqli_num_rows($query) > 0) {
                while($berita = mysqli_fetch_array($query)) {
                    echo "<article class='news-card'>";
                    echo "<div class='news-card-meta'>";
                    echo "<span class='news-badge'>Info</span>";
                    echo "<span class='news-date'>" . htmlspecialchars($berita['tanggal']) . "</span>";
                    echo "</div>";
                    echo "<h3>" . htmlspecialchars($berita['judul']) . "</h3>";
                    echo "<p class='news-content'>" . nl2br(htmlspecialchars(substr($berita['isi'], 0, 200))) . "...</p>";
                    echo "</article>";
                }
            } else {
                echo "<div class='empty-state' style='grid-column: 1/-1;'>Belum ada berita atau pengumuman. Silahkan kembali lagi nanti.</div>";
            }
            ?>
        </section>

        <!-- 3. BANNER AJAKAN / HERO DIPINDAHKAN KE BAWAH SEBAGAI PENUTUP -->
        <section class="news-hero">
            <div>
                <h2>Info Terbaru Setiap Hari</h2>
                <p>Temukan berita penting tentang jadwal, layanan, dan promo yang mendukung perjalanan Anda.</p>
            </div>
            <a href="menu.php" class="btn btn-primary">Lihat Jadwal Rute</a>
        </section>
    </main>

    <?php include 'komponen/footer.php'; ?>
</body>
</html>