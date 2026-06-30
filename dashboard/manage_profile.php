<?php
if (isset($_POST['update_profile'])) {
    mysqli_query($koneksi, "UPDATE tabel_profile SET nama_pt='$_POST[nama_pt]', visi='$_POST[visi]', misi='$_POST[misi]', deskripsi='$_POST[deskripsi]' WHERE id=1");
    echo "<script>window.location='dashboard.php?menu=profile_pt';</script>";
}
$data_pt = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tabel_profile WHERE id=1"));
?>
<h2>Edit Informasi Company Profile</h2>
<form action="" method="POST">
    <label>Nama Perusahaan Otobus (PO)</label><input type="text" name="nama_pt" value="<?=$data_pt['nama_pt']?>" required>
    <label>Visi Perusahaan</label><textarea name="visi" rows="3" required><?=$data_pt['visi']?></textarea>
    <label>Misi Perusahaan</label><textarea name="misi" rows="4" required><?=$data_pt['misi']?></textarea>
    <label>Deskripsi Profil Singkat</label><textarea name="deskripsi" rows="5" required><?=$data_pt['deskripsi']?></textarea>
    <button type="submit" name="update_profile" class="btn btn-green" style="margin-top:15px;">Update Perubahan</button>
</form>