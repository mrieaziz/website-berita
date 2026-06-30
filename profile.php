<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profile Perusahaan</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'komponen/navbar.php'; ?>
    <div class="container">
        <div class="card" style="border-top: 5px solid #ffcc00; padding: 30px;">
            <h2>Tentang Perusahaan</h2>
            <p><?= nl2br($profile_pt['deskripsi']) ?></p>
            <hr>
            <h3>Visi</h3><p><i>" <?= $profile_pt['visi'] ?> "</i></p>
            <h3>Misi</h3><p><?= nl2br($profile_pt['misi']) ?></p>
        </div>
        
        <h2 style="margin-top: 40px;">Ulasan Pelanggan</h2>
        <div class="card-grid">
            <?php $q = mysqli_query($koneksi, "SELECT * FROM tabel_testimoni");
            while($t = mysqli_fetch_array($q)) { ?>
                <div class="card" style="border-top:4px solid #2ecc71;">
                    <h4>👤 <?= $t['nama_user'] ?></h4>
                    <p>"<?=$t['komentar']?>"</p>
                    <p style="color:#f1c40f;">⭐ Rating: <?=$t['rating']?>/5</p>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="footer">&copy; 2026 <?= $profile_pt['nama_pt'] ?>. All Rights Reserved.</div>
</body>
</html>