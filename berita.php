<?php
error_reporting(0);
include 'koneksi/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita & Info Terbaru - PO Trans Bus</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; }
        
        header { background-color: #1a252f; color: white; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        header .logo { font-size: 24px; font-weight: bold; color: #3498db; }
        nav a { color: white; text-decoration: none; margin-left: 25px; font-weight: 500; transition: color 0.3s; }
        nav a:hover { color: #3498db; }
        
        .container { max-width: 1100px; margin: 40px auto; padding: 0 20px; }
        
        .page-header { text-align: center; margin-bottom: 40px; }
        .page-header h1 { color: #1a252f; font-size: 32px; margin-bottom: 10px; }
        .page-header p { color: #7f8c8d; font-size: 16px; }
        
        .news-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px; margin-bottom: 40px; }
        
        .news-card { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.3s, box-shadow 0.3s; border-top: 4px solid #3498db; }
        .news-card:hover { transform: translateY(-5px); box-shadow: 0 8px 12px rgba(0,0,0,0.15); }
        
        .news-title { font-size: 18px; font-weight: bold; color: #1a252f; margin-bottom: 10px; }
        .news-date { font-size: 12px; color: #bdc3c7; margin-bottom: 15px; }
        .news-content { color: #555; line-height: 1.6; font-size: 14px; }
        
        .empty-message { text-align: center; padding: 40px; color: #7f8c8d; font-size: 16px; }
        
        footer { background-color: #2c3e50; color: #bdc3c7; text-align: center; padding: 20px; margin-top: 60px; }
        footer a { color: #3498db; text-decoration: none; }
        
        @media (max-width: 768px) {
            header { flex-direction: column; gap: 15px; }
            nav a { margin-left: 15px; }
            .news-grid { grid-template-columns: 1fr; }
            .page-header h1 { font-size: 24px; }
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">PO Trans Bus</div>
        <nav>
            <a href="index.php">🏠 Beranda</a>
            <a href="menu.php">📋 Jadwal Rute</a>
            <a href="testimoni.php">⭐ Ulasan</a>
            <a href="berita.php">📰 Berita</a>
            <?php if (isset($_SESSION['pelanggan_login'])) : ?>
                <a href="profile.php">👤 Profil</a>
                <a href="logout_user.php" style="color: #e74c3c;">🚪 Logout</a>
            <?php else : ?>
                <a href="login_user.php">🔓 Login</a>
                <a href="register.php" style="background-color:#3498db; padding:5px 10px; border-radius:4px;">📝 Daftar</a>
            <?php endif; ?>
        </nav>
    </header>

    <div class="container">
        <div class="page-header">
            <h1>📰 Berita & Pengumuman Terbaru</h1>
            <p>Dapatkan informasi terkini tentang PO Trans Bus dan layanan kami</p>
        </div>

        <div class="news-grid">
            <?php 
            $query = mysqli_query($koneksi, "SELECT * FROM tabel_berita ORDER BY id_berita DESC");
            
            if ($query && mysqli_num_rows($query) > 0) {
                while($berita = mysqli_fetch_array($query)) {
                    echo "<div class='news-card'>";
                    echo "<div class='news-title'>📰 " . htmlspecialchars($berita['judul']) . "</div>";
                    echo "<div class='news-date'>📅 Diposting pada: " . htmlspecialchars($berita['tanggal']) . "</div>";
                    echo "<div class='news-content'>" . htmlspecialchars(substr($berita['isi'], 0, 150)) . "...</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='empty-message' style='grid-column: 1/-1;'>Belum ada berita atau pengumuman. Silahkan kembali lagi nanti.</div>";
            }
            ?>
        </div>

    </div>

    <footer>
        <p>&copy; 2026 PO Trans Bus. | Terima kasih telah mempercayai kami untuk perjalanan Anda.</p>
    </footer>

</body>
</html>