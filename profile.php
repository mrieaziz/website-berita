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
    <title>Profile Perusahaan - PO Trans Bus</title>
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
        
        .about-card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-top: 5px solid #3498db; margin-bottom: 40px; }
        .about-card h2 { color: #1a252f; margin-bottom: 20px; }
        .about-card h3 { color: #1a252f; margin-top: 25px; margin-bottom: 10px; }
        .about-card p { color: #555; line-height: 1.8; font-size: 15px; }
        
        .testimonials-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .testimonial-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-top: 4px solid #2ecc71; }
        .testimonial-card h4 { color: #1a252f; margin-bottom: 10px; }
        .testimonial-card p { color: #555; line-height: 1.6; }
        
        .empty-message { text-align: center; padding: 40px; color: #7f8c8d; font-size: 16px; }
        
        footer { background-color: #2c3e50; color: #bdc3c7; text-align: center; padding: 20px; margin-top: 60px; }
        footer a { color: #3498db; text-decoration: none; }
        
        @media (max-width: 768px) {
            header { flex-direction: column; gap: 15px; }
            nav a { margin-left: 15px; }
            .testimonials-grid { grid-template-columns: 1fr; }
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
            <h1>🏢 Tentang PO Trans Bus</h1>
            <p>Pelajari lebih lanjut tentang perusahaan kami dan visi misi kami</p>
        </div>

        <div class="about-card">
            <h2>📋 Deskripsi Perusahaan</h2>
            <p><?= nl2br(htmlspecialchars($profile_pt['deskripsi'] ?? '')) ?></p>
            
            <h3>🎯 Visi</h3>
            <p>"<?= htmlspecialchars($profile_pt['visi'] ?? '') ?>"</p>
            
            <h3>💼 Misi</h3>
            <p><?= nl2br(htmlspecialchars($profile_pt['misi'] ?? '')) ?></p>
        </div>

        <h2 style="color: #1a252f; margin-bottom: 30px;">⭐ Ulasan Pelanggan Kami</h2>
        <div class="testimonials-grid">
            <?php 
            $query = mysqli_query($koneksi, "SELECT * FROM tabel_testimoni");
            
            if ($query && mysqli_num_rows($query) > 0) {
                while($testi = mysqli_fetch_array($query)) {
                    echo "<div class='testimonial-card'>";
                    echo "<h4>👤 " . htmlspecialchars($testi['nama_user']) . "</h4>";
                    echo "<p>\"" . htmlspecialchars($testi['komentar']) . "\"</p>";
                    echo "<p style='color:#f39c12; margin-top: 10px;'>";
                    for ($i = 0; $i < $testi['rating']; $i++) {
                        echo "⭐";
                    }
                    echo " Rating: " . $testi['rating'] . "/5</p>";
                    echo "</div>";
                }
            } else {
                echo "<div class='empty-message' style='grid-column: 1/-1;'>Belum ada ulasan dari pelanggan.</div>";
            }
            ?>
        </div>

    </div>

    <footer>
        <p>&copy; 2026 PO Trans Bus. | Terima kasih telah mempercayai kami untuk perjalanan Anda.</p>
    </footer>

</body>
</html>