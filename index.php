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
    <title>PO Sarana Ciledug - Beranda</title>
    <link rel="stylesheet" href="css/style.css?v=20260701">

    <style>
        /* 1. Background utama dengan overlay tipis agar bis tetap terang */
        .hero-section {
            background-image: linear-gradient(135deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url('img/bus1.jpg');
            animation: heroBgSlideIndonesia 16s infinite ease-in-out;
            background-size: cover;
            background-position: center;
        }

        /* 2. Mematikan lapisan biru bawaan */
        .hero-section::before {
            display: none !important;
        }

        /* 3. TRIK UTAMA: Memberikan efek "kaca gelap" ke KEDUA kotak (Kiri & Kanan) */
        .hero-content,
        .hero-card {
            background: rgba(15, 23, 42, 0.75) !important;
            padding: 35px !important;
            border-radius: 24px !important;
            backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
            color: #ffffff !important;
        }

        .hero-content h1,
        .hero-content p,
        .hero-card h3 {
            text-shadow: none !important;
        }

        /* Animasi 3 gambar bis */
        @keyframes heroBgSlideIndonesia {
            0%, 100% {
                background-image: linear-gradient(135deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url('img/bus1.jpg');
            }
            33% {
                background-image: linear-gradient(135deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url('img/bus2.jpg');
            }
            66% {
                background-image: linear-gradient(135deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url('img/bus3.jpg');
            }
        }
    </style>
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
            <a href="index.php" class="active"> Beranda</a>
            <a href="menu.php"> Jadwal Rute</a>
            <a href="testimoni.php"> Ulasan</a>
            <a href="berita.php"> Berita</a>
            <?php if (isset($_SESSION['pelanggan_login'])): ?>
                <a href="profile.php"> Tentang Kami</a>
                <a href="logout_user.php" class="nav-danger"> Logout
                    (<?php echo htmlspecialchars($_SESSION['nama_pelanggan'] ?? ''); ?>)</a>
            <?php else: ?>
                <a href="login_user.php"> Login</a>
                <a href="register.php" class="nav-cta"> Daftar</a>
            <?php endif; ?>
        </nav>
    </header>

    <?php if (isset($_SESSION['pelanggan_login'])): ?>
        <div class="welcome-msg">Welcome Back, <b><?php echo htmlspecialchars($_SESSION['nama_pelanggan'] ?? ''); ?></b>!
            Kamu Bisa Memesan Tiket Nya Disini.</div>
    <?php endif; ?>

    <main class="page-main">
        <section class="hero-section">
            <div class="hero-content">
                <span class="hero-badge"> Layanan tiket bus terpercaya</span>
                <h1>Pesan tiket bus favorit Anda dengan cepat, nyaman, dan aman.</h1>
                <p>Jelajahi rute pilihan, pilih jadwal yang tepat, dan rasakan perjalanan yang lebih nyaman bersama PO
                    Trans Bus.</p>
                <div class="hero-actions">
                    <a href="menu.php" class="btn btn-primary">Lihat Jadwal</a>
                    <?php if (isset($_SESSION['pelanggan_login'])): ?>
                        <a href="profile.php" class="btn btn-secondary">Lihat Profil</a>
                    <?php else: ?>
                        <a href="register.php" class="btn btn-secondary">Buat Akun</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="hero-card">
                <h3>Kenapa Memilih Kami?</h3>
                <ul>
                    <li> Jadwal lengkap dan terupdate</li>
                    <li> Pemesanan mudah dan cepat</li>
                    <li> Bus bersih, aman, dan nyaman</li>
                    <li> Layanan pelanggan responsif</li>
                </ul>
            </div>
        </section>

        <section class="stats-section">
            <div class="stat-card">
                <strong>24/7</strong>
                <span>Pemesanan mudah</span>
            </div>
            <div class="stat-card">
                <strong>10+</strong>
                <span>Rute tersedia</span>
            </div>
            <div class="stat-card">
                <strong>4.9/5</strong>
                <span>Kepuasan penumpang</span>
            </div>
        </section>

        <section class="info-grid">
            <article class="info-card">
                <h3> Fokus layanan</h3>
                <p>Menyediakan pengalaman perjalanan bus yang praktis untuk kebutuhan harian maupun perjalanan jarak
                    jauh.</p>
            </article>
            <article class="info-card">
                <h3> Rute terlengkap</h3>
                <p>Beragam pilihan rute dengan jadwal yang jelas dan harga yang transparan untuk semua kebutuhan.</p>
            </article>
            <article class="info-card">
                <h3> Dukungan pelanggan</h3>
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
                            <th>Armada Bus</th> <th>Keberangkatan</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($koneksi) {
                            // Query diubah menggunakan JOIN persis seperti di menu.php
                            $query = mysqli_query($koneksi, "
                                SELECT tabel_rute.*, tabel_bus.nama_bus, tabel_bus.kelas 
                                FROM tabel_rute 
                                LEFT JOIN tabel_bus ON tabel_rute.id_bus = tabel_bus.id_bus 
                                ORDER BY tabel_rute.asal ASC
                            ");

                            if ($query && mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['asal'] ?? '') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['tujuan'] ?? '') . "</td>";
                                    
                                    // Menampilkan data nama bus dan kelasnya
                                    $nama_armada = (isset($row['nama_bus']) && !empty($row['nama_bus'])) ? $row['nama_bus'] . ' (' . $row['kelas'] . ')' : '- Belum diatur -';
                                    echo "<td>" . htmlspecialchars($nama_armada) . "</td>";

                                    $waktu_berangkat = (isset($row['jam']) && !empty($row['jam'])) ? date('H:i', strtotime($row['jam'])) : '-';
                                    echo "<td class='time'>" . htmlspecialchars($waktu_berangkat) . "</td>";
                                    
                                    echo "<td>Rp " . number_format(($row['harga'] ?? 0), 0, ',', '.') . "</td>";

                                    if (isset($_SESSION['pelanggan_login'])) {
                                        echo "<td><a href='order_tiket.php?id_rute=" . htmlspecialchars($row['id_rute'] ?? '') . "' class='btn-order'>Pesan Tiket</a></td>";
                                    } else {
                                        echo "<td><a href='login_user.php' class='btn-lock' title='Harus login terlebih dahulu'>🔒 Login untuk Pesan</a></td>";
                                    }

                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='empty-state'>Belum ada rute aktif / Jadwal masih kosong.</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='empty-state'>Koneksi database belum tersedia. Silakan cek konfigurasi koneksi.</td></tr>";
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