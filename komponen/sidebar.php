<?php $menu = isset($_GET['menu']) ? $_GET['menu'] : 'profile_pt'; ?>
<div class="sidebar">
    <h4>⚙️ Menu CRUD Pengelola</h4>
    <ul>
        <li><a href="dashboard.php?menu=profile_pt" class="<?=$menu=='profile_pt'?'active':''?>">🛠️ Anggota 1: Edit Profil Utama</a></li>
        <li><a href="dashboard.php?menu=berita" class="<?=$menu=='berita'?'active':''?>">📰 Anggota 2: Manage Berita</a></li>
        <li><a href="dashboard.php?menu=bus" class="<?=$menu=='bus'?'active':''?>">🚌 Anggota 3: Manage Armada Bus</a></li>
        <li><a href="dashboard.php?menu=rute" class="<?=$menu=='rute'?'active':''?>">🗺️ Anggota 4: Manage Jalur Rute</a></li>
        <li><a href="dashboard.php?menu=testimoni" class="<?=$menu=='testimoni'?'active':''?>">⭐ Anggota 5: Manage Testimoni</a></li>
        
        <li style="margin-top: 40px; border-top: 1px solid #34495e; padding-top: 15px;">
            <a href="logout.php" class="btn-red" style="color: white; text-align: center;" onclick="return confirm('Yakin ingin keluar sistem?')">🚪 Logout</a>
        </li>
    </ul>
</div>