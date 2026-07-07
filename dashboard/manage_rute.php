<?php
if ($aksi == 'hapus' && $id > 0) {
    mysqli_query($koneksi, "DELETE FROM tabel_rute WHERE id_rute=$id");
    echo "<script>window.location='dashboard.php?menu=rute';</script>";
}
if (isset($_POST['simpan_rute'])) {
    // Pastikan kolom `jam` ada pada tabel_rute di database sebelum menyimpan
    mysqli_query($koneksi, "INSERT INTO tabel_rute (asal, tujuan, harga, jam) VALUES ('$_POST[asal]', '$_POST[tujuan]', '$_POST[harga]', '$_POST[jam]')");
    echo "<script>window.location='dashboard.php?menu=rute';</script>";
}
if (isset($_POST['update_rute'])) {
    mysqli_query($koneksi, "UPDATE tabel_rute SET asal='$_POST[asal]', tujuan='$_POST[tujuan]', harga='$_POST[harga]', jam='$_POST[jam]' WHERE id_rute=$id");
    echo "<script>window.location='dashboard.php?menu=rute';</script>";
}
?>
<h2>Kelola Jalur Lintasan Trayek & Harga (Anggota 4)</h2>
<?php if ($aksi == 'tampil') { ?>
    <a href="dashboard.php?menu=rute&aksi=tambah" class="btn btn-green">+ Daftarkan Lintasan Rute</a>
    <table>
        <tr>
            <th>Asal</th>
            <th>Tujuan</th>
            <th>Jam</th>
            <th>Tarif Tiket</th>
            <th>Aksi</th>
        </tr>
        <?php $q = mysqli_query($koneksi, "SELECT * FROM tabel_rute");
        while ($d = mysqli_fetch_array($q)) { ?>
            <tr>
                <td><?= $d['asal'] ?></td>
                <td><?= $d['tujuan'] ?></td>
                <td class='time'>
                    <?= htmlspecialchars($d['jam'] ? date('H:i', strtotime($d['jam'])) : '') ?>
                </td>
                <td>Rp <?= number_format($d['harga']) ?></td>
                <td>
                    <a href="dashboard.php?menu=rute&aksi=edit&id=<?= $d['id_rute'] ?>" class="btn btn-yellow">Edit</a>
                    <a href="dashboard.php?menu=rute&aksi=hapus&id=<?= $d['id_rute'] ?>" class="btn btn-red"
                        onclick="return confirm('Hapus?')">Hapus</a>
                </td>
            </tr><?php } ?>
    </table>
<?php } else {
    $d = ['asal' => '', 'tujuan' => '', 'harga' => '', 'jam' => ''];
    if ($aksi == 'edit')
        $d = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tabel_rute WHERE id_rute=$id"));
    ?>
    <form action="" method="POST">
        <label>Kota Asal Keberangkatan</label><input type="text" name="asal" value="<?= $d['asal'] ?>" required>
        <label>Kota Tujuan Akhir</label><input type="text" name="tujuan" value="<?= $d['tujuan'] ?>" required>
        <label>Jam Keberangkatan (HH:MM)</label><input type="time" name="jam" value="<?= $d['jam'] ?>" required>
        <label>Harga Jual Tiket (Rp)</label><input type="number" name="harga" value="<?= $d['harga'] ?>" required>
        <button type="submit" name="<?= $aksi == 'tambah' ? 'simpan_rute' : 'update_rute' ?>" class="btn btn-green"
            style="margin-top:15px;">Simpan Rute</button>
    </form>
<?php } ?>