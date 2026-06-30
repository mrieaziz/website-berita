<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beranda - PO Transport</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'komponen/navbar.php'; ?>
    <div class="container">
        <div class="hero">
            <h1>Selamat Datang di <?= $profile_pt['nama_pt'] ?></h1>
            <p><?= $profile_pt['visi'] ?></p>
        </div>
        <h2>Armada Bus Pilihan Anda</h2>
        <div class="card-grid">
            <?php $q = mysqli_query($koneksi, "SELECT * FROM tabel_bus");
            while($b = mysqli_fetch_array($q)) { ?>
                <div class="card">
                    <h3>🤖 <?= $b['nama_bus'] ?></h3>
                    <p><b>Kelas Layanan:</b> <?= $b['kelas'] ?></p>
                    <p><b>Kapasitas Tersedia:</b> <?= $b['kapasitas'] ?> Kursi</p>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="footer">&copy; 2026 <?= $profile_pt['nama_pt'] ?>. All Rights Reserved.</div>
</body>
</html>