<?php
if ($aksi == 'hapus' && $id > 0) {
    mysqli_query($koneksi, "DELETE FROM tabel_berita WHERE id_berita=$id");
    echo "<script>window.location='dashboard.php?menu=berita';</script>";
}
if (isset($_POST['simpan_berita'])) {
    mysqli_query($koneksi, "INSERT INTO tabel_berita VALUES (NULL, '$_POST[judul]', '$_POST[isi]', '$_POST[tanggal]')");
    echo "<script>window.location='dashboard.php?menu=berita';</script>";
}
if (isset($_POST['update_berita'])) {
    mysqli_query($koneksi, "UPDATE tabel_berita SET judul='$_POST[judul]', isi='$_POST[isi]', tanggal='$_POST[tanggal]' WHERE id_berita=$id");
    echo "<script>window.location='dashboard.php?menu=berita';</script>";
}
?>
<h2>Kelola Info Berita Perusahaan</h2>
<?php if ($aksi == 'tampil') { ?>
    <a href="dashboard.php?menu=berita&aksi=tambah" class="btn btn-green">+ Buat Berita Baru</a>
    <table>
        <tr><th>Judul Artikel</th><th>Tanggal</th><th>Aksi</th></tr>
        <?php $q = mysqli_query($koneksi, "SELECT * FROM tabel_berita"); while($d=mysqli_fetch_array($q)){ ?>
        <tr><td><?=$d['judul']?></td><td><?=$d['tanggal']?></td><td>
            <a href="dashboard.php?menu=berita&aksi=edit&id=<?=$d['id_berita']?>" class="btn btn-yellow">Edit</a>
            <a href="dashboard.php?menu=berita&aksi=hapus&id=<?=$d['id_berita']?>" class="btn btn-red" onclick="return confirm('Hapus?')">Hapus</a>
        </td></tr><?php } ?>
    </table>
<?php } else { 
    $d = ['judul'=>'', 'isi'=>'', 'tanggal'=>''];
    if ($aksi=='edit') $d = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tabel_berita WHERE id_berita=$id"));
?>
    <form action="" method="POST">
        <label>Judul Pengumuman</label><input type="text" name="judul" value="<?=$d['judul']?>" required>
        <label>Isi Konten Berita</label><textarea name="isi" rows="6" required><?=$d['isi']?></textarea>
        <label>Tanggal Publikasi</label><input type="date" name="tanggal" value="<?=$d['tanggal']?>" required>
        <button type="submit" name="<?=$aksi=='tambah'?'simpan_berita':'update_berita'?>" class="btn btn-green" style="margin-top:15px;">Simpan</button>
    </form>
<?php } ?>