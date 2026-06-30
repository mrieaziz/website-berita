<?php
error_reporting(0);
include 'koneksi/koneksi.php';

// 1. PASTIKAN PENGGUNA SUDAH LOGIN
if (!isset($_SESSION['pelanggan_login'])) {
    echo "<script>alert('Silakan login terlebih dahulu untuk memesan tiket!'); window.location='login_user.php';</script>";
    exit;
}

// 2. AMBIL DATA RUTE BERDASARKAN ID DARI URL
$id_rute = $_GET['id_rute'] ?? '';
if (empty($id_rute)) {
    echo "<script>alert('Rute tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}

$query_rute = mysqli_query($koneksi, "SELECT * FROM tabel_rute WHERE id_rute = '$id_rute'");
$data_rute = mysqli_fetch_assoc($query_rute);

// 3. PROSES KETIKA TOMBOL "BUAT PESANAN" DITEKAN
$pesan_sukses = "";
if (isset($_POST['buat_pesanan'])) {
    $id_pelanggan = $_SESSION['id_pelanggan']; // Didapat dari session saat login
    $tanggal_berangkat = $_POST['tanggal_berangkat'];
    $jumlah_kursi = (int)$_POST['jumlah_kursi'];
    
    // Hitung total harga otomatis (Harga tiket x Jumlah kursi)
    $harga_satuan = $data_rute['harga'];
    $total_harga = $harga_satuan * $jumlah_kursi;

    // Simpan ke database tabel_pesanan
    $insert = mysqli_query($koneksi, "INSERT INTO tabel_pesanan (id_pelanggan, id_rute, tanggal_berangkat, jumlah_kursi, total_harga) 
                                      VALUES ('$id_pelanggan', '$id_rute', '$tanggal_berangkat', '$jumlah_kursi', '$total_harga')");
    
    if ($insert) {
        $pesan_sukses = "<div class='alert-success'>Berhasil! Tiket Anda telah dipesan. Total Tagihan: Rp " . number_format($total_harga, 0, ',', '.') . "</div>";
    } else {
        $pesan_sukses = "<div class='alert-danger'>Gagal membuat pesanan. Silakan coba lagi.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Pemesanan Tiket - PO Trans Bus</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; margin: 0; padding: 0; }
        header { background-color: #1a252f; color: white; padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; }
        header a { color: white; text-decoration: none; font-weight: bold; }
        .container { max-width: 600px; margin: 50px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #2c3e50; margin-top: 0; }
        .info-rute { background-color: #ecf0f1; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 5px solid #3498db; }
        .info-rute p { margin: 5px 0; color: #34495e; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { width: 100%; padding: 12px; background-color: #e67e22; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; font-weight: bold; margin-top: 10px;}
        .btn-submit:hover { background-color: #d35400; }
        .btn-back { display: block; text-align: center; margin-top: 15px; color: #7f8c8d; text-decoration: none; }
        .alert-success { background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 4px; text-align: center; border: 1px solid #c3e6cb; }
        .alert-danger { background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 4px; text-align: center; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

    <header>
        <div class="logo">PO Trans Bus - Pemesanan</div>
        <a href="index.php">← Kembali ke Beranda</a>
    </header>

    <div class="container">
        <h2>Detail Pemesanan Tiket</h2>
        
        <?php echo $pesan_sukses; ?>

        <div class="info-rute">
            <p><b>Asal:</b> <?php echo htmlspecialchars($data_rute['asal'] ?? ''); ?></p>
            <p><b>Tujuan:</b> <?php echo htmlspecialchars($data_rute['tujuan'] ?? ''); ?></p>
            <p><b>Jam Berangkat:</b> <?php echo htmlspecialchars($data_rute['jam'] ?? ''); ?></p>
            <p><b>Harga per Tiket:</b> Rp <?php echo number_format(($data_rute['harga'] ?? 0), 0, ',', '.'); ?></p>
        </div>

        <form action="" method="POST">
            <div class="form-group">
                <label>Nama Pemesan</label>
                <input type="text" value="<?php echo htmlspecialchars($_SESSION['nama_pelanggan'] ?? ''); ?>" readonly style="background-color: #e9ecef;">
            </div>
            
            <div class="form-group">
                <label>Pilih Tanggal Keberangkatan</label>
                <input type="date" name="tanggal_berangkat" required min="<?php echo date('Y-m-d'); ?>">
            </div>
            
            <div class="form-group">
                <label>Jumlah Kursi</label>
                <input type="number" name="jumlah_kursi" min="1" max="10" value="1" required>
            </div>
            
            <button type="submit" name="buat_pesanan" class="btn-submit">Selesaikan Pemesanan</button>
        </form>
        
        <a href="index.php" class="btn-back">Batalkan & Kembali</a>
    </div>

</body>
</html>