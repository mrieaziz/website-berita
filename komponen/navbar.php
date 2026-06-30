<?php
include 'koneksi/koneksi.php';
$profile_pt = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tabel_profile WHERE id=1"));
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="navbar">
    <div class="logo">🚌 <?= $profile_pt['nama_pt'] ?></div>
    <ul>
        <li><a href="index.php" class="<?= $current_page=='index.php'?'active':'' ?>">Beranda</a></li>
        <li><a href="profile.php" class="<?= $current_page=='profile.php'?'active':'' ?>">Profile Perusahaan</a></li>
        <li><a href="berita.php" class="<?= $current_page=='berita.php'?'active':'' ?>">Berita & Info</a></li>
        
        <li>
            <?php if(isset($_SESSION['login'])) { ?>
                <a href="dashboard.php" class="btn-dash <?= $current_page=='dashboard.php'?'active':'' ?>">⚙️ Dashboard (<?= $_SESSION['nama_lengkap'] ?>)</a>
            <?php } else { ?>
                <a href="login.php" class="btn-dash">🔑 Login Admin</a>
            <?php } ?>
        </li>
    </ul>
</div>