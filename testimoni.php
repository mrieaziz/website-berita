<?php
error_reporting(0);
include 'koneksi/koneksi.php';
$activePage = 'testimoni';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan & Review Pengguna - PO Sarana Ciledug</title>
    <link rel="stylesheet" href="css/style.css?v=20260701">
</head>
<body>
    <?php include 'komponen/header.php'; ?>
    <main class="page-main">
        <section class="page-header">
            <h1>Ulasan & Review Pengguna</h1>
            <p>Baca pengalaman perjalanan teman-teman kami dengan PO Sarana Ciledug</p>
        </section>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'success') : ?>
            <div class="success-message">Terima kasih! Ulasan Anda telah ditambahkan dan sedang ditinjau oleh admin.</div>
        <?php endif; ?>

        <?php if (isset($_SESSION['pelanggan_login'])) : ?>
            <section class="add-review-section">
                <h2>Bagikan Pengalaman Anda!</h2>
                <p>Ceritakan kepada calon penumpang lain tentang pengalaman perjalanan Anda bersama kami.</p>
                <a href="#form-review" class="btn-add-review">Tulis Review Anda</a>
            </section>
        <?php endif; ?>

        <section class="card-grid testimonials-grid">
            <?php 
            $query = mysqli_query($koneksi, "SELECT * FROM tabel_testimoni WHERE status='Aktif' OR status IS NULL OR status='' ORDER BY id_testi DESC");
            if ($query && mysqli_num_rows($query) > 0) {
                while($testi = mysqli_fetch_array($query)) {
                    echo "<article class='testimonial-card'>";
                    echo "<h3>👤 " . htmlspecialchars($testi['nama_user']) . "</h3>";
                    echo "<div class='star-rating'>";
                    for ($i = 0; $i < $testi['rating']; $i++) {
                        echo "⭐";
                    }
                    echo "</div>";
                    echo "<p class='testimonial-comment'>\"" . htmlspecialchars($testi['komentar']) . "\"</p>";
                    echo "<div class='testimonial-date'>Rating: " . (int)$testi['rating'] . "/5</div>";
                    if (!empty($testi['balasan_admin'])) {
                        echo "<div class='admin-reply'><strong>Balasan Admin</strong>" . htmlspecialchars($testi['balasan_admin']) . "</div>";
                    }
                    echo "</article>";
                }
            } else {
                echo "<div class='empty-state' style='grid-column: 1/-1;'>Belum ada ulasan. Jadilah yang pertama memberikan review! 🎉</div>";
            }
            ?>
        </section>

        <?php if (isset($_SESSION['pelanggan_login'])) : ?>
            <section class="form-container" id="form-review">
                <h3>Tulis Ulasan Anda</h3>
                <form action="proses_testimoni.php" method="POST">
                    <div class="form-group">
                        <label for="nama_user">Nama Lengkap</label>
                        <input type="text" id="nama_user" name="nama_user" value="<?= htmlspecialchars($_SESSION['nama_pelanggan'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="komentar">Ulasan / Komentar</label>
                        <textarea id="komentar" name="komentar" placeholder="Ceritakan pengalaman perjalanan Anda..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="rating">Beri Rating Bintang</label>
                        <select id="rating" name="rating" required>
                            <option value="">-- Pilih Rating --</option>
                            <option value="5">⭐⭐⭐⭐⭐ Sangat Memuaskan (5/5)</option>
                            <option value="4">⭐⭐⭐⭐ Memuaskan (4/5)</option>
                            <option value="3">⭐⭐⭐ Cukup (3/5)</option>
                            <option value="2">⭐⭐ Kurang Memuaskan (2/5)</option>
                            <option value="1">⭐ Tidak Memuaskan (1/5)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-submit">Kirim Ulasan</button>
                </form>
            </section>
        <?php else : ?>
            <section class="section-block">
                <p>Anda harus <a href="login_user.php">login</a> untuk memberikan ulasan dan review.</p>
            </section>
        <?php endif; ?>
    </main>
    <?php include 'komponen/footer.php'; ?>
</body>
</html>
