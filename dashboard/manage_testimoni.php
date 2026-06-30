<?php
// 1. Aksi Hapus
if ($aksi == 'hapus' && $id > 0) {
    mysqli_query($koneksi, "DELETE FROM tabel_testimoni WHERE id_testi=$id");
    echo "<script>window.location='dashboard.php?menu=testimoni';</script>";
}

// 2. Aksi Simpan Baru (Ditambahkan default status 'Aktif' dan tanggal hari ini)
if (isset($_POST['simpan_testi'])) {
    $tgl = date('Y-m-d');
    mysqli_query($koneksi, "INSERT INTO tabel_testimoni VALUES (NULL, '$_POST[nama_user]', '$_POST[komentar]', '$_POST[rating]', '$tgl', 'Aktif')");
    echo "<script>window.location='dashboard.php?menu=testimoni';</script>";
}

// 3. Aksi Update/Edit (Bisa edit status juga)
if (isset($_POST['update_testi'])) {
    mysqli_query($koneksi, "UPDATE tabel_testimoni SET nama_user='$_POST[nama_user]', komentar='$_POST[komentar]', rating='$_POST[rating]', status='$_POST[status]' WHERE id_testi=$id");
    echo "<script>window.location='dashboard.php?menu=testimoni';</script>";
}
?>

<h2>Kelola Testimoni & Review Pengguna (Anggota 5)</h2>

<?php if ($aksi == 'tampil') { ?>
    <div style="margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center;">
        <a href="dashboard.php?menu=testimoni&aksi=tambah" class="btn btn-green">+ Beri Review Baru</a>
    </div>
    
    <table>
        <tr>
            <th>Tanggal</th>
            <th>Nama Penumpang</th>
            <th>Ulasan / Komentar</th>
            <th>Rating</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php 
        $q = mysqli_query($koneksi, "SELECT * FROM tabel_testimoni ORDER BY id_testi DESC"); 
        while($d = mysqli_fetch_array($q)){ 
            // Variasi warna badge status
            $badge_color = ($d['status'] == 'Aktif') ? '#28a745' : '#dc3545';
            // Format tanggal Indonesia sederhana
            $tanggal_tampil = isset($d['tanggal']) ? date('d-m-Y', strtotime($d['tanggal'])) : '-';
        ?>
        <tr>
            <td><small><?=$tanggal_tampil?></small></td>
            <td><strong><?=$d['nama_user']?></strong></td>
            <td><em>"<?=$d['komentar']?>"</em></td>
            <td>
                <span style="color: #ffc107;">
                    <?=str_repeat('⭐', $d['rating'])?>
                </span> 
                <small>(<?=$d['rating']?>/5)</small>
            </td>
            <td>
                <span style="background: <?=$badge_color?>; color: white; padding: 2px 8px; border-radius: 4px; font-size: 11px;">
                    <?=$d['status'] ?? 'Aktif'?>
                </span>
            </td>
            <td>
                <a href="dashboard.php?menu=testimoni&aksi=edit&id=<?=$d['id_testi']?>" class="btn btn-yellow">Edit</a>
                <a href="dashboard.php?menu=testimoni&aksi=hapus&id=<?=$d['id_testi']?>" class="btn btn-red" onclick="return confirm('Hapus testimoni dari <?=$d['nama_user']?>?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>

<?php } else {
    // Default values untuk form tambah
    $d = ['nama_user'=>'', 'komentar'=>'', 'rating'=>'5', 'status'=>'Aktif'];
    if ($aksi == 'edit') {
        $d = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tabel_testimoni WHERE id_testi=$id"));
    }
?>
    <form action="" method="POST">
        <label>Nama Lengkap Pelanggan</label>
        <input type="text" name="nama_user" value="<?=$d['nama_user']?>" placeholder="Contoh: Andi Wijaya" required>
        
        <label>Review Komentar</label>
        <textarea name="komentar" rows="4" placeholder="Tulis ulasan perjalanan di sini..." required><?=$d['komentar']?></textarea>
        
        <label>Beri Nilai Bintang</label>
        <select name="rating">
            <?php for($i=5; $i>=1; $i--) { ?>
                <option value="<?=$i?>" <?=$d['rating']==$i?'selected':''?>><?=str_repeat('⭐', $i)?> (<?=$i?> Bintang)</option>
            <?php } ?>
        </select>

        <?php if ($aksi == 'edit') { ?>
            <label>Status Tampilan</label>
            <select name="status">
                <option value="Aktif" <?=$d['status']=='Aktif'?'selected':''?>>Aktif (Tampilkan)</option>
                <option value="Pending" <?=$d['status']=='Pending'?'selected':''?>>Pending (Sembunyikan)</option>
            </select>
        <?php } else { ?>
            <input type="hidden" name="status" value="Aktif">
        <?php } ?>

        <button type="submit" name="<?=$aksi=='tambah'?'simpan_testi':'update_testi'?>" class="btn btn-green" style="margin-top:15px;">Simpan Ulasan</button>
        <a href="dashboard.php?menu=testimoni" class="btn" style="margin-top:15px; background:#ccc; color:#333; text-decoration:none; padding:6px 12px; border-radius:4px; display:inline-block;">Kembali</a>
    </form>
<?php } ?>