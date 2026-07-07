<?php
error_reporting(0);
include 'koneksi/koneksi.php';
$activePage = 'menu';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Rute & Menu Perjalanan - PO Trans Bus</title>
    <link rel="stylesheet" href="css/style.css?v=20260701">
</head>

<body>
    <?php include 'komponen/header.php'; ?>
    <main class="page-main">
        <section class="page-header">
            <h1>Jadwal Rute & Pemesanan Tiket</h1>
            <p>Lihat semua jadwal perjalanan dan pesan tiket bus Anda sekarang</p>
        </section>
        <section class="content-card">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Rute Lengkap</p>
                    <h2>Daftar Semua Rute Perjalanan</h2>
                </div>
            </div>
            <div class="table-shell">
                <table>
                    <thead>
                        <tr>
                            <th style="text-align: center;">No</th>
                            <th>Asal</th>
                            <th>Tujuan</th>
                            <th>Armada Bus</th> <!-- Kolom Baru -->
                            <th>Waktu Keberangkatan</th>
                            <th>Harga Tiket</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query diubah menggunakan JOIN untuk mengambil data dari tabel_bus
                        $query = mysqli_query($koneksi, "
                            SELECT tabel_rute.*, tabel_bus.nama_bus, tabel_bus.kelas 
                            FROM tabel_rute 
                            LEFT JOIN tabel_bus ON tabel_rute.id_bus = tabel_bus.id_bus 
                            ORDER BY tabel_rute.asal ASC
                        ");

                        if ($query && mysqli_num_rows($query) > 0) {
                            $no = 1;
                            while ($row = mysqli_fetch_array($query)) {
                                echo "<tr>";
                                echo "<td style='text-align: center;'><strong>#" . $no++ . "</strong></td>";
                                echo "<td><strong>" . htmlspecialchars($row['asal'] ?? '') . "</strong></td>";
                                echo "<td><strong>" . htmlspecialchars($row['tujuan'] ?? '') . "</strong></td>";
                                
                                // Menampilkan nama bus dan kelasnya
                                $nama_armada = (isset($row['nama_bus']) && !empty($row['nama_bus'])) ? $row['nama_bus'] . ' (' . $row['kelas'] . ')' : '- Belum diatur -';
                                echo "<td>" . htmlspecialchars($nama_armada) . "</td>";

                                $waktu_berangkat = (isset($row['jam']) && !empty($row['jam'])) ? date('H:i', strtotime($row['jam'])) : '-';
                                echo "<td class='time'>" . htmlspecialchars($waktu_berangkat) . "</td>";
                                
                                echo "<td class='price'>Rp " . number_format(($row['harga'] ?? 0), 0, ',', '.') . "</td>";
                                if (isset($_SESSION['pelanggan_login'])) {
                                    echo "<td style='text-align: center;'><a href='order_tiket.php?id_rute=" . htmlspecialchars($row['id_rute'] ?? '') . "' class='action-btn'>🎫 Pesan</a></td>";
                                } else {
                                    echo "<td style='text-align: center;'><a href='login_user.php' class='action-btn disabled' title='Harus login terlebih dahulu'>🔒 Login</a></td>";
                                }
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='empty-state'>Belum ada rute aktif. Jadwal masih kosong.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="section-block" style="margin-top: 40px;">
            <h2>Tidak Menemukan Rute yang Dicari?</h2>
            <p>Hubungi kami untuk informasi lebih lanjut atau pesan custom route sesuai kebutuhan Anda.</p>
            <a href="index.php" class="btn btn-secondary">Hubungi Kami</a>
        </section>
    </main>
    <?php include 'komponen/footer.php'; ?>
</body>

</html>