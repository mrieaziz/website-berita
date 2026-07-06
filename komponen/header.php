<?php
$activePage = $activePage ?? basename($_SERVER['PHP_SELF'], '.php');
?>
<header class="site-header">
    <a href="index.php" class="brand">
        <span class="brand-mark">🚌</span>
        <span>
            <strong>PO Sarana Ciledug</strong>
            <small>Bus Lintas Kampus Terpercaya</small>
        </span>
    </a>
    <nav class="top-nav">
        <a href="index.php" class="<?= $activePage === 'index' ? 'active' : '' ?>">Beranda</a>
        <a href="menu.php" class="<?= $activePage === 'menu' ? 'active' : '' ?>">Jadwal Rute</a>
        <a href="testimoni.php" class="<?= $activePage === 'testimoni' ? 'active' : '' ?>">Ulasan</a>
        <a href="berita.php" class="<?= $activePage === 'berita' ? 'active' : '' ?>">Berita</a>
        <?php if (isset($_SESSION['pelanggan_login'])) : ?>
            <a href="profile.php" class="<?= $activePage === 'profile' ? 'active' : '' ?>">Tentang Kami</a>
            <a href="logout_user.php" class="nav-danger">Logout (<?= htmlspecialchars($_SESSION['nama_pelanggan'] ?? '') ?>)</a>
        <?php else : ?>
            <a href="login_user.php" class="<?= $activePage === 'login' ? 'active' : '' ?>">Login</a>
            <a href="register.php" class="nav-cta">Daftar</a>
        <?php endif; ?>
    </nav>
</header>
