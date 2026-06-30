<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Berita & Info Terbaru</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'komponen/navbar.php'; ?>
    <div class="container">
        <h2>Berita & Pengumuman Terbaru</h2>
        <div class="card-grid">
            <?php $q = mysqli_query($koneksi, "SELECT * FROM tabel_berita ORDER BY id_berita DESC");
            while($br = mysqli_fetch_array($q)) { ?>
                <div class="card">
                    <h3>📰 <?= $br['judul'] ?></h3>
                    <small style="color:gray;">Diposting pada: <?= $br['tanggal'] ?></small>
                    <p><?= nl2br($br['isi']) ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="footer">&copy; 2026 <?= $profile_pt['nama_pt'] ?>. All Rights Reserved.</div>
</body>
</html>