<?php
error_reporting(0);
require_once __DIR__ . '/koneksi/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PO Trans Bus - Beranda</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; padding: 0; background-color: #f4f6f9; }
        header { background-color: #1a252f; color: white; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; }
        header .logo { font-size: 24px; font-weight: bold; color: #3498db; }
        nav a { color: white; text-decoration: none; margin-left: 20px; font-weight: 500; }
        .hero { background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?q=80&w=1200') no-repeat center center/cover; height: 40vh; display: flex; flex-direction: column; justify-content: center; align-items: center; color: white; text-align: center; }
        .container { max-width: 1100px; margin: 40px auto; padding: 0 20px; }
        .table-responsive { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; }
        table th, table td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        table th { background-color: #34495e; color: white; }
        table tr:hover { background-color: #f1f2f6; }
        .btn-order { padding: 6px 12px; background-color: #e67e22; color: white; text-decoration: none; border-radius: 4px; font-size: 14px; display: inline-block; }
        .btn-order:hover { background-color: #d35400; }
        .btn-lock { padding: 6px 12px; background-color: #7f8c8d; color: #bdc3c7; text-decoration: none; border-radius: 4px; font-size: 14px; cursor: not-allowed; }
        .welcome-msg { background-color: #2ecc71; color: white; padding: 10px 5%; font-size: 14px; text-align: right; }
        footer { background-color: #2c3e50; color: #bdc3c7; text-align: center; padding: 20px; margin-top: 60px; }
        footer a { color: #3498db; text-decoration: none; }
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
                <a href="logout_user.php" style="color: #e74c3c;">🚪 Logout (<?php echo htmlspecialchars($_SESSION['nama_pelanggan'] ?? ''); ?>)</a>
            <?php else : ?>
                <a href="login_user.php">🔓 Login</a>
                <a href="register.php" style="background-color:#3498db; padding:5px 10px; border-radius:4px;">📝 Daftar</a>
            <?php endif; ?>
        </nav>
    </header>

    <?php if (isset($_SESSION['pelanggan_login'])) : ?>
        <div class="welcome-msg">Selamat Datang, <b><?php echo htmlspecialchars($_SESSION['nama_pelanggan'] ?? ''); ?></b>! Anda sekarang bisa memesan tiket bus.</div>
    <?php endif; ?>

    <div class="hero">
        <h1>Selamat Datang di PO Trans Bus</h1>
        <p>Pesan Tiket Bus Premium Aman dan Cepat</p>
    </div>

    <div class="container">
        <div class="table-responsive">
            <h2>Jadwal Rute & Pemesanan Tiket</h2>
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
                        // Mengeksekusi query ke tabel yang benar: tabel_rute
                        $query = mysqli_query($koneksi, "SELECT * FROM tabel_rute ORDER BY asal ASC");
                        
                        if ($query && mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_assoc($query)) {
                                echo "<tr>";
                                // Menggunakan operator ?? '' agar kebal dari error data kosong (NULL)
                                echo "<td>" . htmlspecialchars($row['asal'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['tujuan'] ?? '') . "</td>";
                                echo "<td>" . htmlspecialchars($row['jam'] ?? '') . "</td>";
                                echo "<td>Rp " . number_format(($row['harga'] ?? 0), 0, ',', '.') . "</td>";
                                
                                // Logika tombol aksi pemesanan tiket
                                if (isset($_SESSION['pelanggan_login'])) {
                                    echo "<td><a href='order_tiket.php?id_rute=" . htmlspecialchars($row['id_rute'] ?? '') . "' class='btn-order'>Pesan Tiket</a></td>";
                                } else {
                                    echo "<td><a href='login_user.php' class='btn-lock' title='Harus login terlebih dahulu'>🔒 Login untuk Pesan</a></td>";
                                }
                                
                                echo "</tr>";
                            }
                        } else {
                            // Jika database kosong, tampilkan pesan ini alih-alih error
                            echo "<tr><td colspan='5' style='text-align:center;'>Belum ada rute aktif / Jadwal masih kosong.</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' style='text-align:center;'>Koneksi database belum tersedia. Silakan cek konfigurasi koneksi.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 PO Trans Bus. Pesan Tiket Bus Premium Aman dan Cepat | <small><a href="login.php">🔑 Login Admin</a></small></p>
    </footer>

</body>
</html>