<?php
if ($aksi == 'hapus' && $id > 0) {
    mysqli_query($koneksi, "DELETE FROM tabel_rute WHERE id_rute=$id");
    echo "<script>window.location='dashboard.php?menu=rute';</script>";
}
if (isset($_POST['simpan_rute'])) {
    // Query INSERT ditambahkan id_bus
    mysqli_query($koneksi, "INSERT INTO tabel_rute (asal, tujuan, harga, jam, id_bus) VALUES ('$_POST[asal]', '$_POST[tujuan]', '$_POST[harga]', '$_POST[jam]', '$_POST[id_bus]')");
    echo "<script>window.location='dashboard.php?menu=rute';</script>";
}
if (isset($_POST['update_rute'])) {
    // Query UPDATE ditambahkan id_bus
    mysqli_query($koneksi, "UPDATE tabel_rute SET asal='$_POST[asal]', tujuan='$_POST[tujuan]', harga='$_POST[harga]', jam='$_POST[jam]', id_bus='$_POST[id_bus]' WHERE id_rute=$id");
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
            <th>Armada Bus</th> <!-- Kolom Baru -->
            <th>Jam</th>
            <th>Tarif Tiket</th>
            <th>Aksi</th>
        </tr>
        <?php 
        // Menggabungkan tabel rute dengan tabel bus
        $q = mysqli_query($koneksi, "SELECT tabel_rute.*, tabel_bus.nama_bus FROM tabel_rute LEFT JOIN tabel_bus ON tabel_rute.id_bus = tabel_bus.id_bus");
        while ($d = mysqli_fetch_array($q)) { ?>
            <tr>
                <td><?= htmlspecialchars($d['asal']) ?></td>
                <td><?= htmlspecialchars($d['tujuan']) ?></td>
                <td><?= htmlspecialchars($d['nama_bus'] ?? 'Belum diatur') ?></td> <!-- Menampilkan Bus -->
                <td class='time'>
                    <?= isset($d['jam']) && !empty($d['jam']) ? htmlspecialchars(date('H:i', strtotime($d['jam']))) : '-' ?>
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
    $d = ['asal' => '', 'tujuan' => '', 'harga' => '', 'jam' => '', 'id_bus' => ''];
    if ($aksi == 'edit')
        $d = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tabel_rute WHERE id_rute=$id"));
    ?>
    <form action="" method="POST">
        <label>Kota Asal Keberangkatan</label><input type="text" name="asal" value="<?= htmlspecialchars($d['asal']) ?>" required>
        <label>Kota Tujuan Akhir</label><input type="text" name="tujuan" value="<?= htmlspecialchars($d['tujuan']) ?>" required>
        
        <!-- DROPDOWN BARU UNTUK PILIH BUS -->
        <label>Pilih Armada Bus</label>
        <select name="id_bus" required style="width: 100%; padding: 8px; margin-bottom: 10px;">
            <option value="">-- Pilih Armada Bus --</option>
            <?php 
            $q_bus = mysqli_query($koneksi, "SELECT * FROM tabel_bus");
            while($bus = mysqli_fetch_array($q_bus)){ 
                $selected = ($d['id_bus'] == $bus['id_bus']) ? 'selected' : '';
                echo "<option value='{$bus['id_bus']}' $selected>{$bus['nama_bus']} ({$bus['kelas']})</option>";
            } 
            ?>
        </select>
        
        <label>Jam Keberangkatan (HH:MM)</label><input type="time" name="jam" value="<?= isset($d['jam']) ? htmlspecialchars($d['jam']) : '' ?>" required>
        <label>Harga Jual Tiket (Rp)</label><input type="number" name="harga" value="<?= htmlspecialchars($d['harga']) ?>" required>
        <button type="submit" name="<?= $aksi == 'tambah' ? 'simpan_rute' : 'update_rute' ?>" class="btn btn-green"
            style="margin-top:15px;">Simpan Rute</button>
    </form>
<?php } ?>