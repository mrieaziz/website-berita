<?php
error_reporting(0);
include 'koneksi/koneksi.php';
$profile_pt = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tabel_profile WHERE id=1"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Profile Perusahaan - PO Sarana Ciledug</title>
    <link rel="stylesheet" href="css/style.css?v=20260701">
</head>
<body>

    <header class="site-header">
        <a href="index.php" class="brand">
            <span class="brand-mark">🚌</span>
            <span>
                <strong>PO Sarana Ciledug</strong>
                <small>Bus Lintas Kampus Terpercaya</small>
            </span>
        </a>
        <nav class="top-nav">
            <a href="index.php"> Beranda</a>
            <a href="menu.php"> Jadwal Rute</a>
            <a href="testimoni.php"> Ulasan</a>
            <a href="berita.php"> Berita</a>
            <?php if (isset($_SESSION['pelanggan_login'])) : ?>
                <a href="profile.php" class="active"> Tentang Kami</a>
                <a href="logout_user.php" class="nav-danger"> Logout (<?php echo htmlspecialchars($_SESSION['nama_pelanggan'] ?? ''); ?>)</a>
            <?php else : ?>
                <a href="login_user.php"> Login</a>
                <a href="register.php" class="nav-cta"> Daftar</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="page-main">
        <div class="page-header">
            <h1>🏢 Tentang PO Sarana Ciledug</h1>
            <p>Pelajari lebih lanjut tentang perusahaan kami dan visi misi kami</p>
        </div>

        <div class="about-card">
            <h2> Deskripsi Perusahaan</h2>
            <p><?= nl2br(htmlspecialchars($profile_pt['deskripsi'] ?? '')) ?></p>
            
            <h3> Visi</h3>
            <p>"<?= htmlspecialchars($profile_pt['visi'] ?? '') ?>"</p>
            
            <h3> Misi</h3>
            <p><?= nl2br(htmlspecialchars($profile_pt['misi'] ?? '')) ?></p>
        </div>

        <div class="content-card">
            <h2> Ulasan Pelanggan Kami</h2>
            <div class="card-grid">
                <?php 
                $query = mysqli_query($koneksi, "SELECT * FROM tabel_testimoni");
                
                if ($query && mysqli_num_rows($query) > 0) {
                    while($testi = mysqli_fetch_array($query)) {
                        echo "<div class='testimonial-card'>";
                        echo "<h3>👤 " . htmlspecialchars($testi['nama_user']) . "</h3>";
                        echo "<p class='testimonial-comment'>\"" . htmlspecialchars($testi['komentar']) . "\"</p>";
                        echo "<div class='star-rating'>";
                        for ($i = 0; $i < $testi['rating']; $i++) {
                            echo "⭐";
                        }
                        echo " Rating: " . $testi['rating'] . "/5</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<div style='text-align: center; padding: 40px; color: #64748b; grid-column: 1/-1;'>Belum ada ulasan dari pelanggan.</div>";
                }
                ?>
            </div>
        </div>
    </main>

    <footer class="site-footer">
        <p>&copy; 2026 PO Sarana Ciledug. | Terima kasih telah mengunjungi situs kami.</p>
    </footer>

</body>
</html>