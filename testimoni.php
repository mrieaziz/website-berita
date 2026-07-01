<?php
error_reporting(0);
include 'koneksi/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan & Review Pengguna - PO Trans Bus</title>
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
        
        .testimonials-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px; margin-bottom: 40px; }
        
        .testimonial-card { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.3s, box-shadow 0.3s; }
        .testimonial-card:hover { transform: translateY(-5px); box-shadow: 0 8px 12px rgba(0,0,0,0.15); }
        
        .star-rating { font-size: 18px; color: #f39c12; margin: 10px 0; }
        .testimonial-name { font-weight: bold; color: #1a252f; font-size: 16px; margin-bottom: 5px; }
        .testimonial-comment { color: #555; line-height: 1.6; font-size: 14px; margin: 15px 0; }
        .testimonial-date { font-size: 12px; color: #bdc3c7; }
        .admin-reply { margin-top: 12px; padding: 10px 12px; background: #f8f9fa; border-left: 3px solid #2ecc71; border-radius: 6px; font-size: 13px; color: #2c3e50; }
        .admin-reply strong { display: block; margin-bottom: 4px; color: #27ae60; }
        
        .add-review-section { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 40px; border-radius: 12px; text-align: center; margin-bottom: 40px; }
        .add-review-section h2 { margin-bottom: 15px; }
        .add-review-section p { margin-bottom: 20px; font-size: 14px; }
        
        .btn-add-review { background-color: white; color: #667eea; padding: 12px 30px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block; transition: all 0.3s; }
        .btn-add-review:hover { background-color: #f0f0f0; transform: scale(1.05); }
        
        .form-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 40px; max-width: 600px; margin-left: auto; margin-right: auto; }
        .form-container h3 { color: #1a252f; margin-bottom: 25px; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #1a252f; font-weight: 600; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-family: 'Segoe UI', sans-serif; font-size: 14px; }
        .form-group textarea { resize: vertical; min-height: 120px; }
        .form-group input:focus, .form-group textarea:focus, .form-group select:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        
        .btn-submit { background-color: #667eea; color: white; padding: 12px 30px; border: none; border-radius: 6px; font-weight: bold; font-size: 16px; cursor: pointer; transition: background-color 0.3s; width: 100%; }
        .btn-submit:hover { background-color: #5568d3; }
        
        .empty-message { text-align: center; padding: 40px; color: #7f8c8d; font-size: 16px; }
        
        footer { background-color: #2c3e50; color: #bdc3c7; text-align: center; padding: 20px; margin-top: 60px; }
        footer a { color: #3498db; text-decoration: none; }
        
        .success-message { background-color: #2ecc71; color: white; padding: 15px; border-radius: 6px; margin-bottom: 20px; text-align: center; }
        
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
            <h1>⭐ Ulasan & Review Pengguna</h1>
            <p>Baca pengalaman perjalanan teman-teman kami dengan PO Trans Bus</p>
        </div>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'success') : ?>
            <div class="success-message">✅ Terima kasih! Ulasan Anda telah ditambahkan dan sedang ditinjau oleh admin.</div>
        <?php endif; ?>

        <?php if (isset($_SESSION['pelanggan_login'])) : ?>
            <div class="add-review-section">
                <h2>Bagikan Pengalaman Anda!</h2>
                <p>Ceritakan kepada calon penumpang lain tentang pengalaman perjalanan Anda bersama kami.</p>
                <a href="#form-review" class="btn-add-review">✍️ Tulis Review Anda</a>
            </div>
        <?php endif; ?>

        <div class="testimonials-grid">
            <?php 
            $query = mysqli_query($koneksi, "SELECT * FROM tabel_testimoni WHERE status='Aktif' OR status IS NULL OR status='' ORDER BY id_testi DESC");
            
            if ($query && mysqli_num_rows($query) > 0) {
                while($testi = mysqli_fetch_array($query)) {
                    echo "<div class='testimonial-card'>";
                    echo "<div class='testimonial-name'>👤 " . htmlspecialchars($testi['nama_user']) . "</div>";
                    echo "<div class='star-rating'>";
                    for ($i = 0; $i < $testi['rating']; $i++) {
                        echo "⭐ ";
                    }
                    echo "</div>";
                    echo "<div class='testimonial-comment'>\"" . htmlspecialchars($testi['komentar']) . "\"</div>";
                    echo "<div class='testimonial-date'>Rating: " . $testi['rating'] . "/5 bintang</div>";
                    if (!empty($testi['balasan_admin'])) {
                        echo "<div class='admin-reply'><strong>Balasan Admin</strong>" . htmlspecialchars($testi['balasan_admin']) . "</div>";
                    }
                    echo "</div>";
                }
            } else {
                echo "<div class='empty-message' style='grid-column: 1/-1;'>Belum ada ulasan. Jadilah yang pertama memberikan review! 🎉</div>";
            }
            ?>
        </div>

        <?php if (isset($_SESSION['pelanggan_login'])) : ?>
            <div class="form-container" id="form-review">
                <h3>✍️ Tulis Ulasan Anda</h3>
                <form action="proses_testimoni.php" method="POST">
                    <div class="form-group">
                        <label for="nama_user">Nama Lengkap</label>
                        <input type="text" id="nama_user" name="nama_user" value="<?php echo htmlspecialchars($_SESSION['nama_pelanggan'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="komentar">Ulasan / Komentar</label>
                        <textarea id="komentar" name="komentar" placeholder="Ceritakan pengalaman perjalanan Anda..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="rating">Beri Rating Bintang</label>
                        <select id="rating" name="rating" required>
                            <option value="">-- Pilih Rating --</option>
                            <option value="5">⭐⭐⭐⭐⭐ Sangat Memuaskan (5/5)</option>
                            <option value="4">⭐⭐⭐⭐ Memuaskan (4/5)</option>
                            <option value="3">⭐⭐⭐ Cukup (3/5)</option>
                            <option value="2">⭐⭐ Kurang Memuaskan (2/5)</option>
                            <option value="1">⭐ Tidak Memuaskan (1/5)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-submit">📤 Kirim Ulasan</button>
                </form>
            </div>
        <?php else : ?>
            <div style="background: #ecf0f1; padding: 30px; border-radius: 8px; text-align: center; margin-bottom: 40px;">
                <p style="color: #7f8c8d; font-size: 16px;">Anda harus <a href="login_user.php" style="color: #667eea; font-weight: bold;">login</a> untuk memberikan ulasan dan review.</p>
            </div>
        <?php endif; ?>

    </div>

    <footer>
        <p>&copy; 2026 PO Trans Bus. | Terima kasih telah mempercayai kami untuk perjalanan Anda.</p>
    </footer>

</body>
</html>
