<?php
// === PROSES LOGIKA DATABASE (TAMBAH, EDIT, HAPUS) ===

// 1. Proses Tambah Data
if (isset($_POST['simpan_berita'])) {
    // Menggunakan mysqli_real_escape_string untuk mencegah error jika ada tanda kutip pada inputan
    $judul   = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $isi     = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);

    $query_tambah = "INSERT INTO tabel_berita (judul, isi, tanggal) VALUES ('$judul', '$isi', '$tanggal')";
    $simpan = mysqli_query($koneksi, $query_tambah) or die("Error Tambah: " . mysqli_error($koneksi));

    if ($simpan) {
        echo "<script>alert('Berita baru berhasil dipublikasikan!'); window.location='dashboard.php?menu=berita';</script>";
    }
}

// 2. Proses Update/Edit Data
if (isset($_POST['update_berita'])) {
    $judul   = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $isi     = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);

    // Variabel $id diasumsikan sudah ditangkap dari URL di file dashboard.php
    $query_update = "UPDATE tabel_berita SET judul='$judul', isi='$isi', tanggal='$tanggal' WHERE id_berita='$id'";
    $update = mysqli_query($koneksi, $query_update) or die("Error Update: " . mysqli_error($koneksi));

    if ($update) {
        echo "<script>alert('Data berita berhasil diperbarui!'); window.location='dashboard.php?menu=berita';</script>";
    }
}

// 3. Proses Hapus Data
if ($aksi === 'hapus' && isset($_GET['id'])) {
    $id_hapus = $_GET['id'];
    $query_hapus = "DELETE FROM tabel_berita WHERE id_berita='$id_hapus'";
    $hapus = mysqli_query($koneksi, $query_hapus) or die("Error Hapus: " . mysqli_error($koneksi));

    if ($hapus) {
        echo "<script>alert('Berita berhasil dihapus!'); window.location='dashboard.php?menu=berita';</script>";
    }
}
// ====================================================
?>

<div class="admin-interface-wrapper">
    <div class="admin-page-header">
        <h2>✨ Kelola Info Berita Perusahaan</h2>
        <p class="admin-page-subtitle">Manajemen publikasi artikel, pengumuman operasional, dan info rute armada bus.</p>
    </div>

    <?php 
    // Mengatur alur tampilan halaman dengan styling UI modern
    switch ($aksi) {
        case 'tampil': 
            ?>
            <div class="action-bar-container">
                <a href="dashboard.php?menu=berita&aksi=tambah" class="btn-modern btn-add-new">
                    <span class="btn-icon">＋</span> Buat Berita Baru
                </a>
            </div>
            
            <div class="table-responsive-wrapper">
                <table class="table-modern-ui">
                    <thead>
                        <tr>
                            <th width="55%">Judul Artikel / Pengumuman</th>
                            <th width="25%">Tanggal Rilis</th>
                            <th width="20%" style="text-align: center;">Aksi Pengelola</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $ambil_data = mysqli_query($koneksi, "SELECT * FROM tabel_berita ORDER BY id_berita DESC"); 
                        if (mysqli_num_rows($ambil_data) > 0) {
                            while ($row = mysqli_fetch_assoc($ambil_data)) { 
                            ?>
                            <tr>
                                <td class="td-title-cell">
                                    <div class="title-wrapper">
                                        <span class="title-badge-dot"></span>
                                        <strong><?php echo htmlspecialchars($row['judul']); ?></strong>
                                    </div>
                                </td>
                                <td class="td-date-cell">
                                    <span class="calendar-mini-icon">📅</span> 
                                    <?php echo date('d M Y', strtotime($row['tanggal'])); ?>
                                </td>
                                <td style="text-align: center;">
                                    <div class="action-button-group">
                                        <a href="dashboard.php?menu=berita&aksi=edit&id=<?php echo $row['id_berita']; ?>" class="btn-table-action btn-edit-ui">Edit</a>
                                        <a href="dashboard.php?menu=berita&aksi=hapus&id=<?php echo $row['id_berita']; ?>" class="btn-table-action btn-delete-ui" onclick="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                            <?php 
                            }
                        } else {
                            echo '<tr><td colspan="3" style="text-align:center; padding: 40px; color:#a0aec0;">Belum ada berita yang diterbitkan.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
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
            $form_title = ($aksi === 'tambah') ? 'Buat Artikel Baru' : 'Perbarui Artikel';
            ?>
            
            <div class="form-container-card">
                <div class="form-card-header">
                    <h3>🛠️ <?php echo $form_title; ?></h3>
                    <p>Isi formulir di bawah ini dengan lengkap untuk mempublikasikan informasi terbaru.</p>
                </div>
                
                <form action="" method="POST" class="form-modern-style">
                    <div class="form-group-block">
                        <label>Judul Pengumuman</label>
                        <input type="text" name="judul" value="<?php echo htmlspecialchars($data_berita['judul']); ?>" placeholder="Contoh: Jadwal Operasional Bus Menjelang Libur Nasional" required>
                    </div>
                    
                    <div class="form-group-block">
                        <label>Isi Konten Berita</label>
                        <textarea name="isi" rows="8" placeholder="Tulis rincian informasi atau pengumuman secara detail di sini..." required><?php echo htmlspecialchars($data_berita['isi']); ?></textarea>
                    </div>
                    
                    <div class="form-group-block short-width">
                        <label>Tanggal Publikasi</label>
                        <input type="date" name="tanggal" value="<?php echo htmlspecialchars($data_berita['tanggal']); ?>" required>
                    </div>
                    
                    <div class="form-action-footer">
                        <button type="submit" name="<?php echo $nama_tombol; ?>" class="btn-modern btn-submit-form">Simpan Data Berita</button>
                        <a href="dashboard.php?menu=berita" class="btn-modern btn-cancel-form">Kembali</a>
                    </div>
                </form>
            </div>
            <?php 
            break;
    } 
    ?>
</div>
<style>
    .admin-interface-wrapper {
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        color: #2d3748;
        padding: 5px;
    }

    .admin-page-header {
        margin-bottom: 25px;
    }

    .admin-page-header h2 {
        font-size: 1.6rem;
        color: #1a202c;
        margin: 0 0 6px 0;
        font-weight: 700;
    }

    .admin-page-subtitle {
        color: #718096;
        margin: 0;
        font-size: 0.95rem;
    }

    .action-bar-container {
        margin-bottom: 20px;
    }

    /* Modifikasi Tombol */
    .btn-modern {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease-in-out;
        border: none;
        cursor: pointer;
    }

    .btn-add-new {
        background-color: #10b981;
        color: white;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);
    }

    .btn-add-new:hover {
        background-color: #059669;
        transform: translateY(-1px);
    }

    .btn-icon {
        margin-right: 6px;
        font-size: 1.1rem;
        line-height: 1;
    }

    /* Desain Tabel Premium Clean */
    .table-responsive-wrapper {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .table-modern-ui {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 0.95rem;
    }

    .table-modern-ui th {
        background-color: #f8fafc;
        color: #4a5568;
        padding: 16px 20px;
        font-weight: 600;
        border-bottom: 2px solid #edf2f7;
        text-transform: uppercase;
        font-size: 0.78rem;
        letter-spacing: 0.5px;
    }

    .table-modern-ui td {
        padding: 16px 20px;
        border-bottom: 1px solid #edf2f7;
        color: #4a5568;
        vertical-align: middle;
    }

    .table-modern-ui tr:last-child td {
        border-bottom: none;
    }

    .table-modern-ui tr:hover td {
        background-color: #f8fafc;
    }

    .title-wrapper {
        display: flex;
        align-items: center;
    }

    .title-badge-dot {
        width: 8px;
        height: 8px;
        background-color: #3182ce;
        border-radius: 50%;
        margin-right: 12px;
        display: inline-block;
        flex-shrink: 0;
    }

    .td-title-cell strong {
        color: #2d3748;
        font-weight: 600;
    }

    .calendar-mini-icon {
        margin-right: 4px;
        opacity: 0.8;
    }

    /* Tombol Aksi di Dalam Tabel */
    .action-button-group {
        display: inline-flex;
        gap: 8px;
    }

    .btn-table-action {
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-edit-ui {
        background-color: #fef3c7;
        color: #d97706;
    }

    .btn-edit-ui:hover {
        background-color: #fde68a;
        color: #b45309;
    }

    .btn-delete-ui {
        background-color: #fee2e2;
        color: #dc2626;
    }

    .btn-delete-ui:hover {
        background-color: #fecaca;
        color: #b91c1c;
    }

    /* Tampilan Form Card Yang Mewah */
    .form-container-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        overflow: hidden;
        max-width: 850px;
    }

    .form-card-header {
        padding: 20px 25px;
        background-color: #f8fafc;
        border-bottom: 1px solid #edf2f7;
    }

    .form-card-header h3 {
        margin: 0 0 4px 0;
        font-size: 1.2rem;
        color: #1a202c;
    }

    .form-card-header p {
        margin: 0;
        color: #718096;
        font-size: 0.88rem;
    }

    .form-modern-style {
        padding: 25px;
    }

    .form-group-block {
        margin-bottom: 20px;
    }

    .form-group-block.short-width {
        max-width: 250px;
    }

    .form-group-block label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #4a5568;
        font-size: 0.9rem;
    }

    .form-modern-style input[type="text"],
    .form-modern-style input[type="date"],
    .form-modern-style textarea {
        width: 100%;
        padding: 11px 14px;
        border-radius: 8px;
        border: 1px solid #cbd5e0;
        background-color: #fff;
        color: #2d3748;
        font-size: 0.95rem;
        font-family: inherit;
        box-sizing: border-box;
        transition: all 0.2s ease;
    }

    .form-modern-style input[type="text"]:focus,
    .form-modern-style input[type="date"]:focus,
    .form-modern-style textarea:focus {
        outline: none;
        border-color: #3182ce;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15);
    }

    .form-action-footer {
        display: flex;
        gap: 12px;
        margin-top: 30px;
        border-top: 1px solid #edf2f7;
        padding-top: 20px;
    }

    .btn-submit-form {
        background-color: #3182ce;
        color: white;
        box-shadow: 0 4px 10px rgba(49, 130, 206, 0.2);
    }

    .btn-submit-form:hover {
        background-color: #2b6cb0;
    }

    .btn-cancel-form {
        background-color: #e2e8f0;
        color: #4a5568;
    }

    .btn-cancel-form:hover {
        background-color: #cbd5e1;
    }
</style>