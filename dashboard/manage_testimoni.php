<?php
if ($aksi == 'hapus' && $id > 0) {
    mysqli_query($koneksi, "DELETE FROM tabel_testimoni WHERE id_testi=$id");
    echo "<script>window.location='dashboard.php?menu=testimoni';</script>";
}
if (isset($_POST['simpan_testi'])) {
    mysqli_query($koneksi, "INSERT INTO tabel_testimoni VALUES (NULL, '$_POST[nama_user]', '$_POST[komentar]', '$_POST[rating]')");
    echo "<script>window.location='dashboard.php?menu=testimoni';</script>";
}
if (isset($_POST['update_testi'])) {
    mysqli_query($koneksi, "UPDATE tabel_testimoni SET nama_user='$_POST[nama_user]', komentar='$_POST[komentar]', rating='$_POST[rating]' WHERE id_testi=$id");
    echo "<script>window.location='dashboard.php?menu=testimoni';</script>";
}
?>
<h2>Kelola Testimoni & Review Pengguna (Anggota 5)</h2>
<?php if ($aksi == 'tampil') { ?>
    <a href="dashboard.php?menu=testimoni&aksi=tambah" class="btn btn-green">+ Beri Review Baru</a>
    <table>
        <tr><th>Nama Penumpang</th><th>Ulasan / Komentar</th><th>Rating</th><th>Aksi</th></tr>
        <?php $q = mysqli_query($koneksi, "SELECT * FROM tabel_testimoni"); while($d=mysqli_fetch_array($q)){ ?>
        <tr><td><?=$d['nama_user']?></td><td><?=$d['komentar']?></td><td>⭐ <?=$d['rating']?>/5</td><td>
            <a href="dashboard.php?menu=testimoni&aksi=edit&id=<?=$d['id_testi']?>" class="btn btn-yellow">Edit</a>
            <a href="dashboard.php?menu=testimoni&aksi=hapus&id=<?=$d['id_testi']?>" class="btn btn-red" onclick="return confirm('Hapus?')">Hapus</a>
        </td></tr><?php } ?>
    </table>
<?php } else {
    $d = ['nama_user'=>'', 'komentar'=>'', 'rating'=>'5'];
    if ($aksi=='edit') $d = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tabel_testimoni WHERE id_testi=$id"));
?>
    <form action="" method="POST">
        <label>Nama Lengkap Pelanggan</label><input type="text" name="nama_user" value="<?=$d['nama_user']?>" required>
        <label>Review Komentar</label><textarea name="komentar" rows="4" required><?=$d['komentar']?></textarea>
        <label>Beri Nilai Bintang</label><select name="rating"><option value="5" <?=$d['rating']=='5'?'selected':''?>>⭐⭐⭐⭐⭐</option><option value="4" <?=$d['rating']=='4'?'selected':''?>>⭐⭐⭐⭐</option><option value="3" <?=$d['rating']=='3'?'selected':''?>>⭐⭐⭐</option></select>
        <button type="submit" name="<?=$aksi=='tambah'?'simpan_testi':'update_testi'?>" class="btn btn-green" style="margin-top:15px;">Simpan Ulasan</button>
    </form>
<?php } ?>