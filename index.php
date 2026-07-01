<?php
error_reporting(0);
require_once __DIR__ . '/koneksi/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>PO Trans Bus - Beranda</title>
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
            <a href="index.php" class="active">🏠 Beranda</a>
            <a href="menu.php">📋 Jadwal Rute</a>
            <a href="testimoni.php">⭐ Ulasan</a>
            <a href="berita.php">📰 Berita</a>
            <?php if (isset($_SESSION['pelanggan_login'])) : ?>
                <a href="profile.php">👤 Profil</a>
                <a href="logout_user.php" class="nav-danger">🚪 Logout (<?php echo htmlspecialchars($_SESSION['nama_pelanggan'] ?? ''); ?>)</a>
            <?php else : ?>
                <a href="login_user.php">🔓 Login</a>
                <a href="register.php" class="nav-cta">📝 Daftar</a>
            <?php endif; ?>
        </nav>
    </header>

    <?php if (isset($_SESSION['pelanggan_login'])) : ?>
        <div class="welcome-msg">Welcome Back, <b><?php echo htmlspecialchars($_SESSION['nama_pelanggan'] ?? ''); ?></b>! Kamu Bisa Memesan Tiket Nya Disini.</div>
    <?php endif; ?>

    <main class="page-main">
        <section class="hero-section">
            <div class="hero-content">
                <span class="hero-badge">✨ Layanan tiket bus terpercaya</span>
                <h1>Pesan tiket bus favorit Anda dengan cepat, nyaman, dan aman.</h1>
                <p>Jelajahi rute pilihan, pilih jadwal yang tepat, dan rasakan perjalanan yang lebih nyaman bersama PO Trans Bus.</p>
                <div class="hero-actions">
                    <a href="menu.php" class="btn btn-primary">Lihat Jadwal</a>
                    <?php if (isset($_SESSION['pelanggan_login'])) : ?>
                        <a href="profile.php" class="btn btn-secondary">Lihat Profil</a>
                    <?php else : ?>
                        <a href="register.php" class="btn btn-secondary">Buat Akun</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="hero-card">
                <h3>Kenapa Memilih Kami?</h3>
                <ul>
                    <li>✅ Jadwal lengkap dan terupdate</li>
                    <li>✅ Pemesanan mudah dan cepat</li>
                    <li>✅ Bus bersih, aman, dan nyaman</li>
                    <li>✅ Layanan pelanggan responsif</li>
                </ul>
            </div>
        </section>

        <section class="stats-section">
            <div class="stat-card">
                <strong>24/7</strong>
                <span>Pemesanan mudah</span>
            </div>
            <div class="stat-card">
                <strong>100+</strong>
                <span>Rute tersedia</span>
            </div>
            <div class="stat-card">
                <strong>4.9/5</strong>
                <span>Kepuasan penumpang</span>
            </div>
        </section>

        <section class="info-grid">
            <article class="info-card">
                <h3>🎯 Fokus layanan</h3>
                <p>Menyediakan pengalaman perjalanan bus yang praktis untuk kebutuhan harian maupun perjalanan jarak jauh.</p>
            </article>
            <article class="info-card">
                <h3>🧭 Rute terlengkap</h3>
                <p>Beragam pilihan rute dengan jadwal yang jelas dan harga yang transparan untuk semua kebutuhan.</p>
            </article>
            <article class="info-card">
                <h3>💬 Dukungan pelanggan</h3>
                <p>Tim kami siap membantu Anda dalam memilih jadwal terbaik dan menyelesaikan kebutuhan pemesanan.</p>
            </article>
        </section>

        <section class="content-card">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Jadwal dan Pemesanan</p>
                    <h2>Jadwal Rute & Pemesanan Tiket</h2>
                </div>
                <a href="menu.php" class="text-link">Lihat semua rute</a>
            </div>
            <div class="table-shell">
                <table>
                    <thead>
                        <tr>
                            <th>Asal</th>
                            <th>Tujuan</th>
                            <th>Keberangkatan</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($koneksi) {
                            $query = mysqli_query($koneksi, "SELECT * FROM tabel_rute ORDER BY asal ASC");
                            
                            if ($query && mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['asal'] ?? '') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['tujuan'] ?? '') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['jam'] ?? '') . "</td>";
                                    echo "<td>Rp " . number_format(($row['harga'] ?? 0), 0, ',', '.') . "</td>";
                                    
                                    if (isset($_SESSION['pelanggan_login'])) {
                                        echo "<td><a href='order_tiket.php?id_rute=" . htmlspecialchars($row['id_rute'] ?? '') . "' class='btn-order'>Pesan Tiket</a></td>";
                                    } else {
                                        echo "<td><a href='login_user.php' class='btn-lock' title='Harus login terlebih dahulu'>🔒 Login untuk Pesan</a></td>";
                                    }
                                    
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='empty-state'>Belum ada rute aktif / Jadwal masih kosong.</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='empty-state'>Koneksi database belum tersedia. Silakan cek konfigurasi koneksi.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <p>&copy; 2026 Web Programming UAS From Kelompok Goksssss</p>
        <p><a href="login.php"> Login Sebagai Admin</a></p>
    </footer>
</body>
</html>