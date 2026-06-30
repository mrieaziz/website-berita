<?php
error_reporting(0);
include 'koneksi/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Rute & Menu Perjalanan - PO Trans Bus</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; }
        
        header { background-color: #1a252f; color: white; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        header .logo { font-size: 24px; font-weight: bold; color: #3498db; }
        nav a { color: white; text-decoration: none; margin-left: 25px; font-weight: 500; transition: color 0.3s; }
        nav a:hover { color: #3498db; }
        
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        
        .page-header { text-align: center; margin-bottom: 40px; }
        .page-header h1 { color: #1a252f; font-size: 32px; margin-bottom: 10px; }
        .page-header p { color: #7f8c8d; font-size: 16px; }
        
        .filter-section { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 30px; }
        .filter-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .filter-group { display: flex; flex-direction: column; }
        .filter-group label { margin-bottom: 8px; color: #1a252f; font-weight: 600; }
        .filter-group input, .filter-group select { padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; }
        .filter-group input:focus, .filter-group select:focus { outline: none; border-color: #3498db; }
        .filter-btn { background-color: #3498db; color: white; padding: 10px 25px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; transition: background-color 0.3s; height: fit-content; }
        .filter-btn:hover { background-color: #2980b9; }
        
        .routes-table-container { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); overflow-x: auto; }
        .routes-table-container h2 { color: #1a252f; margin-bottom: 20px; }
        
        table { width: 100%; border-collapse: collapse; }
        table th { background-color: #34495e; color: white; padding: 15px; text-align: left; font-weight: 600; }
        table td { padding: 15px; border-bottom: 1px solid #ecf0f1; }
        table tr:hover { background-color: #f8f9fa; }
        
        .route-num { font-weight: bold; color: #3498db; }
        .price { font-weight: bold; color: #27ae60; font-size: 16px; }
        .time { color: #7f8c8d; }
        
        .action-btn { padding: 8px 16px; background-color: #27ae60; color: white; text-decoration: none; border-radius: 4px; display: inline-block; font-size: 13px; font-weight: 600; transition: background-color 0.3s; }
        .action-btn:hover { background-color: #229954; }
        
        .action-btn.disabled { background-color: #bdc3c7; color: #7f8c8d; cursor: not-allowed; }
        .action-btn.disabled:hover { background-color: #bdc3c7; }
        
        .empty-message { text-align: center; padding: 40px; color: #7f8c8d; font-size: 16px; }
        
        .route-card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; border-left: 5px solid #3498db; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: grid; grid-template-columns: 1fr auto; gap: 20px; align-items: center; }
        .route-info h3 { color: #1a252f; margin-bottom: 10px; }
        .route-details { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; }
        .detail-item { }
        .detail-label { color: #7f8c8d; font-size: 12px; font-weight: 600; }
        .detail-value { color: #1a252f; font-weight: bold; font-size: 16px; }
        
        @media (max-width: 768px) {
            header { flex-direction: column; gap: 15px; }
            nav a { margin-left: 15px; }
            .filter-row { grid-template-columns: 1fr; }
            .route-card { grid-template-columns: 1fr; }
            table { font-size: 12px; }
            table th, table td { padding: 10px; }
        }
        
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
                <a href="logout_user.php" style="color: #e74c3c;">🚪 Logout</a>
            <?php else : ?>
                <a href="login_user.php">🔓 Login</a>
                <a href="register.php" style="background-color:#3498db; padding:5px 10px; border-radius:4px;">📝 Daftar</a>
            <?php endif; ?>
        </nav>
    </header>

    <div class="container">
        <div class="page-header">
            <h1>📋 Jadwal Rute & Pemesanan Tiket</h1>
            <p>Lihat semua jadwal perjalanan dan pesan tiket bus Anda sekarang</p>
        </div>

        <div class="routes-table-container">
            <h2>📌 Daftar Semua Rute Perjalanan</h2>
            <table>
                <thead>
                    <tr>
                        <th style="text-align: center;">No</th>
                        <th>Asal</th>
                        <th>Tujuan</th>
                        <th>Waktu Keberangkatan</th>
                        <th>Harga Tiket</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($koneksi, "SELECT * FROM tabel_rute ORDER BY asal ASC");
                    
                    if ($query && mysqli_num_rows($query) > 0) {
                        $no = 1;
                        while($row = mysqli_fetch_array($query)) {
                            echo "<tr>";
                            echo "<td style='text-align: center;'><strong>#" . $no++ . "</strong></td>";
                            echo "<td><strong>" . htmlspecialchars($row['asal'] ?? '') . "</strong></td>";
                            echo "<td><strong>" . htmlspecialchars($row['tujuan'] ?? '') . "</strong></td>";
                            echo "<td class='time'>🕐 " . htmlspecialchars($row['jam'] ?? '') . "</td>";
                            echo "<td class='price'>💰 Rp " . number_format(($row['harga'] ?? 0), 0, ',', '.') . "</td>";
                            
                            if (isset($_SESSION['pelanggan_login'])) {
                                echo "<td style='text-align: center;'><a href='order_tiket.php?id_rute=" . htmlspecialchars($row['id_rute'] ?? '') . "' class='action-btn'>🎫 Pesan</a></td>";
                            } else {
                                echo "<td style='text-align: center;'><a href='login_user.php' class='action-btn disabled' title='Harus login terlebih dahulu'>🔒 Login</a></td>";
                            }
                            
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='empty-message'>Belum ada rute aktif. Jadwal masih kosong.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 40px; padding: 25px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; color: white; text-align: center;">
            <h2 style="margin-bottom: 15px;">Tidak Menemukan Rute yang Dicari?</h2>
            <p style="margin-bottom: 15px;">Hubungi kami untuk informasi lebih lanjut atau pesan custom route sesuai kebutuhan Anda.</p>
            <a href="index.php" style="background-color: white; color: #667eea; padding: 10px 25px; text-decoration: none; border-radius: 4px; font-weight: bold; display: inline-block;">📞 Hubungi Kami</a>
        </div>

    </div>

    <footer>
        <p>&copy; 2026 PO Trans Bus. | Pesan Tiket Bus Premium Aman dan Cepat</p>
    </footer>

</body>
</html>
