<?php
if ($aksi == 'hapus' && $id > 0) {
    mysqli_query($koneksi, "DELETE FROM tabel_bus WHERE id_bus=$id");
    echo "<script>window.location='dashboard.php?menu=bus';</script>";
}
if (isset($_POST['simpan_bus'])) {
    mysqli_query($koneksi, "INSERT INTO tabel_bus VALUES (NULL, '$_POST[nama_bus]', '$_POST[kelas]', '$_POST[kapasitas]')");
    echo "<script>window.location='dashboard.php?menu=bus';</script>";
}
if (isset($_POST['update_bus'])) {
    mysqli_query($koneksi, "UPDATE tabel_bus SET nama_bus='$_POST[nama_bus]', kelas='$_POST[kelas]', kapasitas='$_POST[kapasitas]' WHERE id_bus=$id");
    echo "<script>window.location='dashboard.php?menu=bus';</script>";
}
?>
<h2>Kelola Armada Kendaraan Bus</h2>
<?php if ($aksi == 'tampil') { ?>
    <a href="dashboard.php?menu=bus&aksi=tambah" class="btn btn-green">+ Daftarkan Bus</a>
    <table>
        <tr>
            <th style="text-align: center;">No</th>
            <th>Nama Bus</th>
            <th style="text-align: center;">Kelas</th>
            <th style="text-align: center;">Kapasitas</th>
            <th style="text-align: center;">Aksi</th>
        </tr>
        <?php $q = mysqli_query($koneksi, "SELECT * FROM tabel_bus");
        $no = 1;
        while ($d = mysqli_fetch_array($q)) { ?>
            <tr>
                <td style="text-align: center;"><?= $no++ ?></td>
                <td><?= $d['nama_bus'] ?></td>
                <td style="text-align: center;"><?= $d['kelas'] ?></td>
                <td style="text-align: center;"><?= $d['kapasitas'] ?> Kursi</td>
                <td style="text-align: center;">
                    <a href="dashboard.php?menu=bus&aksi=edit&id=<?= $d['id_bus'] ?>" class="btn btn-yellow"
                        style="margin-right: 8px;">Edit</a>
                    <a href="dashboard.php?menu=bus&aksi=hapus&id=<?= $d['id_bus'] ?>" class="btn btn-red"
                        onclick="return confirm('Hapus?')">Hapus</a>
                </td>
            </tr><?php } ?>
    </table>
<?php } else {
    $d = ['nama_bus' => '', 'kelas' => 'Ekonomi', 'kapasitas' => ''];
    if ($aksi == 'edit')
        $d = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tabel_bus WHERE id_bus=$id"));
    ?>
    <form action="" method="POST">
        <label>Nama Armada Bus</label><input type="text" name="nama_bus" value="<?= $d['nama_bus'] ?>" required>
        <label>Kelas Layanan</label>
        <select name="kelas">
            <option value="Ekonomi" <?= $d['kelas'] == 'Ekonomi' ? 'selected' : '' ?>>Ekonomi</option>
            <option value="Bisnis" <?= $d['kelas'] == 'Bisnis' ? 'selected' : '' ?>>Bisnis</option>
            <option value="Eksekutif" <?= $d['kelas'] == 'Eksekutif' ? 'selected' : '' ?>>Eksekutif</option>
        </select>
        <label>Kapasitas</label><input type="number" name="kapasitas" value="<?= $d['kapasitas'] ?>" required>
        <button type="submit" name="<?= $aksi == 'tambah' ? 'simpan_bus' : 'update_bus' ?>" class="btn btn-green"
            style="margin-top:15px;">Simpan</button>
    </form>
<?php } ?>