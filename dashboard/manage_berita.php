<?php
// Mengubah penanganan aksi menggunakan blok switch agar lebih rapi dan berbeda
if (!empty($aksi)) {
    switch ($aksi) {
        case 'hapus':
            if ($id > 0) {
                mysqli_query($koneksi, "DELETE FROM tabel_berita WHERE id_berita = $id");
                header("Location: dashboard.php?menu=berita");
                exit;
            }
            break;
    }
}

// Menangani request method POST (Simpan & Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul_input   = $_POST['judul'];
    $isi_input     = $_POST['isi'];
    $tanggal_input = $_POST['tanggal'];

    if (isset($_POST['simpan_berita'])) {
        mysqli_query($koneksi, "INSERT INTO tabel_berita VALUES (NULL, '$judul_input', '$isi_input', '$tanggal_input')");
    } elseif (isset($_POST['update_berita'])) {
        mysqli_query($koneksi, "UPDATE tabel_berita SET judul='$judul_input', isi='$isi_input', tanggal='$tanggal_input' WHERE id_berita = $id");
    }
    
    header("Location: dashboard.php?menu=berita");
    exit;
}
?>

<h2>Kelola Info Berita Perusahaan</h2>

<?php 
// Mengatur alur tampilan halaman
switch ($aksi) {
    case 'tampil': 
        ?>
        <a href="dashboard.php?menu=berita&aksi=tambah" class="btn btn-green">+ Buat Berita Baru</a>
        <table>
            <thead>
                <tr>
                    <th>Judul Artikel</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $ambil_data = mysqli_query($koneksi, "SELECT * FROM tabel_berita ORDER BY id_berita DESC"); 
                while ($row = mysqli_fetch_assoc($ambil_data)) { 
                ?>
                <tr>
                    <td><?php echo $row['judul']; ?></td>
                    <td><?php echo $row['tanggal']; ?></td>
                    <td>
                        <a href="dashboard.php?menu=berita&aksi=edit&id=<?php echo $row['id_berita']; ?>" class="btn btn-yellow">Edit</a>
                        <a href="dashboard.php?menu=berita&aksi=hapus&id=<?php echo $row['id_berita']; ?>" class="btn btn-red" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php 
        break;

    case 'tambah':
    case 'edit':
        $data_berita = ['judul' => '', 'isi' => '', 'tanggal' => ''];
        if ($aksi === 'edit') {
            $query_edit  = mysqli_query($koneksi, "SELECT * FROM tabel_berita WHERE id_berita = $id");
            $data_berita = mysqli_fetch_assoc($query_edit);
        }
        $nama_tombol = ($aksi === 'tambah') ? 'simpan_berita' : 'update_berita';
        ?>
        <form action="" method="POST">
            <label>Judul Pengumuman</label>
            <input type="text" name="judul" value="<?php echo $data_berita['judul']; ?>" required>
            
            <label>Isi Konten Berita</label>
            <textarea name="isi" rows="6" required><?php echo $data_berita['isi']; ?></textarea>
            
            <label>Tanggal Publikasi</label>
            <input type="date" name="tanggal" value="<?php echo $data_berita['tanggal']; ?>" required>
            
            <button type="submit" name="<?php echo $nama_tombol; ?>" class="btn btn-green" style="margin-top:15px;">Simpan Data</button>
        </form>
        <?php 
        break;
} 
?>