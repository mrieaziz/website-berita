<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
include 'koneksi/koneksi.php'; 

// Jika admin belum login, kembalikan ke halaman login
if (!isset($_SESSION['admin_login']) && !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// ==========================================
// KODE BARU: PROSES UPDATE STATUS PESANAN
// ==========================================
if (isset($_POST['update_status'])) {
    $id_pesanan_update = $_POST['id_pesanan'];
    $status_baru = $_POST['status_baru'];
    
    $update_query = mysqli_query($koneksi, "UPDATE tabel_pesanan SET status_pesanan = '$status_baru' WHERE id_pesanan = '$id_pesanan_update'");
    
    if ($update_query) {
        echo "<script>alert('Status pesanan berhasil diperbarui menjadi $status_baru!'); window.location='manage_pesanan.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui status!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pesanan Tiket - Admin PO Trans Bus</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 1200px; margin: auto; }
        h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table th, table td { padding: 12px; text-align: left; border: 1px solid #ddd; font-size: 14px; }
        table th { background-color: #34495e; color: white; }
        table tr:nth-child(even) { background-color: #f9f9f9; }
        table tr:hover { background-color: #f1f2f6; }
        
        /* Pewarnaan Status Dinamis */
        .badge { padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; color: white; display: inline-block; }
        .bg-warning { background-color: #f39c12; } /* Kuning: Menunggu */
        .bg-success { background-color: #2ecc71; } /* Hijau: Lunas */
        .bg-danger { background-color: #e74c3c; }  /* Merah: Batal */
        
        .btn-back { display: inline-block; margin-bottom: 20px; padding: 10px 15px; background-color: #7f8c8d; color: white; text-decoration: none; border-radius: 4px; }
        
        /* Desain form update di dalam tabel */
        .form-update { display: flex; gap: 5px; }
        .form-update select { padding: 5px; border: 1px solid #ccc; border-radius: 3px; }
        .form-update button { padding: 5px 10px; background-color: #3498db; color: white; border: none; border-radius: 3px; cursor: pointer; }
        .form-update button:hover { background-color: #2980b9; }
    </style>
</head>
<body>

    <div class="container">
        <a href="dashboard.php" class="btn-back">← Kembali ke Dashboard</a>
        <h2>Daftar Pesanan Tiket Masuk</h2>
        
        <table>
            <thead>
                <tr>
                    <th>No. Order</th>
                    <th>Waktu Pesan</th>
                    <th>Nama Penumpang</th>
                    <th>Rute (Asal - Tujuan)</th>
                    <th>Tgl Berangkat</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi (Ubah Status)</th> </tr>
            </thead>
            <tbody>
                <?php
                if (isset($koneksi)) {
                    $query = "SELECT p.id_pesanan, p.waktu_pesan, p.tanggal_berangkat, p.jumlah_kursi, p.total_harga, p.status_pesanan,
                                     pl.nama_lengkap, 
                                     r.asal, r.tujuan 
                              FROM tabel_pesanan p
                              JOIN tabel_pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
                              JOIN tabel_rute r ON p.id_rute = r.id_rute
                              ORDER BY p.waktu_pesan DESC"; 
                              
                    $result = mysqli_query($koneksi, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            
                            // Logika Pewarnaan Label Status
                            $status = htmlspecialchars($row['status_pesanan'] ?? '');
                            $warna_badge = "bg-warning"; // Default kuning
                            if ($status == "Lunas") $warna_badge = "bg-success";
                            if ($status == "Batal") $warna_badge = "bg-danger";

                            echo "<tr>";
                            echo "<td>#ORD-" . htmlspecialchars($row['id_pesanan'] ?? '') . "</td>";
                            echo "<td>" . date('d-m-Y H:i', strtotime($row['waktu_pesan'])) . "</td>";
                            echo "<td><b>" . htmlspecialchars($row['nama_lengkap'] ?? '') . "</b></td>";
                            echo "<td>" . htmlspecialchars($row['asal'] ?? '') . " ➔ " . htmlspecialchars($row['tujuan'] ?? '') . "</td>";
                            echo "<td>" . date('d M Y', strtotime($row['tanggal_berangkat'])) . "</td>";
                            echo "<td>Rp " . number_format($row['total_harga'] ?? 0, 0, ',', '.') . "</td>";
                            
                            // Menampilkan Status dengan warna yang sesuai
                            echo "<td><span class='badge $warna_badge'>$status</span></td>";
                            
                            // KODE BARU: Form untuk Admin mengubah status
                            echo "<td>
                                    <form action='' method='POST' class='form-update'>
                                        <input type='hidden' name='id_pesanan' value='" . htmlspecialchars($row['id_pesanan']) . "'>
                                        <select name='status_baru'>
                                            <option value='Menunggu Pembayaran' " . ($status == 'Menunggu Pembayaran' ? 'selected' : '') . ">Menunggu Pembayaran</option>
                                            <option value='Lunas' " . ($status == 'Lunas' ? 'selected' : '') . ">Lunas</option>
                                            <option value='Batal' " . ($status == 'Batal' ? 'selected' : '') . ">Batal</option>
                                        </select>
                                        <button type='submit' name='update_status'>Simpan</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' style='text-align:center;'>Belum ada pesanan tiket yang masuk.</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' style='text-align:center; color:red;'>Gagal terhubung ke database.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>