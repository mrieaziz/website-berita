<?php
// === PROSES LOGIKA DATABASE (TAMBAH, EDIT, HAPUS) ===

// 1. Proses Tambah Data
if (isset($_POST['simpan_berita'])) {
    // Menggunakan mysqli_real_escape_string untuk mencegah error jika ada tanda kutip pada inputan
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $isi = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);

    $query_tambah = "INSERT INTO tabel_berita (judul, isi, tanggal) VALUES ('$judul', '$isi', '$tanggal')";
    $simpan = mysqli_query($koneksi, $query_tambah) or die("Error Tambah: " . mysqli_error($koneksi));

    if ($simpan) {
        echo "<script>alert('Berita baru berhasil dipublikasikan!'); window.location='dashboard.php?menu=berita';</script>";
    }
}

// 2. Proses Update/Edit Data
if (isset($_POST['update_berita'])) {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $isi = mysqli_real_escape_string($koneksi, $_POST['isi']);
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
// 4. Proses Bulk Delete (multiple)
if (isset($_POST['bulk_delete']) && !empty($_POST['selected'])) {
    $ids = $_POST['selected'];
    $ids_sanitized = array_map(function ($v) use ($koneksi) {
        return (int) $v;
    }, $ids);
    $ids_list = implode(',', $ids_sanitized);
    if (!empty($ids_list)) {
        $q = "DELETE FROM tabel_berita WHERE id_berita IN ($ids_list)";
        mysqli_query($koneksi, $q) or die('Error Bulk Delete: ' . mysqli_error($koneksi));
        echo "<script>alert('Berita terpilih berhasil dihapus.'); window.location='dashboard.php?menu=berita';</script>";
    }
}
// 5. Proses Seed Data Contoh (via tombol di UI)
if (isset($_POST['seed_berita'])) {
    $beritas = [
        ['judul' => 'Penyesuaian Jadwal Menjelang Libur Nasional', 'isi' => 'Sehubungan dengan momen libur nasional mendatang, PO Trans Bus menyesuaikan jadwal keberangkatan agar penumpang tetap nyaman. Harap cek jadwal terbaru melalui menu Rute.', 'tanggal' => '2026-07-01'],
        ['judul' => 'Kampanye Kebersihan Armada', 'isi' => 'Semua armada kami menjalani protokol kebersihan ekstra setiap hari. Penumpang diminta untuk tetap menjaga kebersihan selama perjalanan demi kenyamanan bersama.', 'tanggal' => '2026-06-20'],
        ['judul' => 'Promo Tiket Persahabatan', 'isi' => 'Dapatkan diskon khusus 15% untuk pemesanan kelompok 4 orang ke atas selama periode promo. Syarat dan ketentuan berlaku.', 'tanggal' => '2026-05-15']
    ];
    $inserted = 0;
    foreach ($beritas as $b) {
        $judul = mysqli_real_escape_string($koneksi, $b['judul']);
        $tanggal = mysqli_real_escape_string($koneksi, $b['tanggal']);
        $isi = mysqli_real_escape_string($koneksi, $b['isi']);
        $check = mysqli_query($koneksi, "SELECT id_berita FROM tabel_berita WHERE judul='$judul' AND tanggal='$tanggal'");
        if (!$check || mysqli_num_rows($check) == 0) {
            mysqli_query($koneksi, "INSERT INTO tabel_berita (judul, isi, tanggal) VALUES ('$judul', '$isi', '$tanggal')") or die('Error insert: ' . mysqli_error($koneksi));
            $inserted++;
        }
    }
    echo "<script>alert('Seed selesai. Ditambahkan: $inserted berita.'); window.location='dashboard.php?menu=berita';</script>";
}
// ====================================================
?>

<div class="admin-interface-wrapper">
    <div class="admin-page-header">
        <h2>✨ Kelola Info Berita Perusahaan</h2>
        <p class="admin-page-subtitle">Manajemen publikasi artikel, pengumuman operasional, dan info rute armada bus.
        </p>
    </div>

    <?php
    // Mengatur alur tampilan halaman dengan styling UI modern
    switch ($aksi) {
        case 'tampil':
            ?>
            <div class="action-bar-container"
                style="display:flex; gap:12px; align-items:center; justify-content:space-between; flex-wrap:wrap;">
                <div style="display:flex; gap:12px; align-items:center;">
                    <a href="dashboard.php?menu=berita&aksi=tambah" class="btn-modern btn-add-new">
                        <span class="btn-icon">＋</span> Buat Berita Baru
                    </a>
                    <form method="POST" style="display:inline-block; margin-left:8px;">
                        <button type="submit" name="seed_berita" class="btn-modern" style="background:#3b82f6; color:white;">Isi
                            Data Contoh</button>
                    </form>
                    <div>
                        <input type="text" id="search-input" placeholder="Cari judul atau tanggal..."
                            style="padding:8px 10px; border-radius:8px; border:1px solid #cbd5e0;">
                    </div>
                </div>
                <div style="display:flex; gap:8px; align-items:center;">
                    <form id="bulk-action-form" method="POST" onsubmit="return confirm('Hapus semua berita terpilih?');">
                        <input type="hidden" name="bulk_delete" value="1">
                        <button type="submit" class="btn-modern" style="background:#ef4444; color:white;">Hapus
                            Terpilih</button>
                    </form>
                    <button id="preview-btn" class="btn-modern" style="background:#f59e0b; color:white;">Preview
                        Terpilih</button>
                </div>
            </div>

            <div class="table-responsive-wrapper">
                <table class="table-modern-ui" id="berita-table">
                    <thead>
                        <tr>
                            <th style="width:48px; text-align:center;"><input type="checkbox" id="select-all"></th>
                            <th>Judul Artikel / Pengumuman</th>
                            <th style="width:180px;">Tanggal Rilis</th>
                            <th style="width:220px; text-align: center;">Aksi Pengelola</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ambil_data = mysqli_query($koneksi, "SELECT * FROM tabel_berita ORDER BY id_berita DESC");
                        if (mysqli_num_rows($ambil_data) > 0) {
                            while ($row = mysqli_fetch_assoc($ambil_data)) {
                                ?>
                                <tr data-isi="<?php echo htmlspecialchars($row['isi']); ?>"
                                    data-judul="<?php echo htmlspecialchars($row['judul']); ?>"
                                    data-tanggal="<?php echo htmlspecialchars($row['tanggal']); ?>">
                                    <td style="text-align:center;"><input type="checkbox" class="row-select" name="selected[]"
                                            form="bulk-action-form" value="<?php echo $row['id_berita']; ?>"></td>
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
                                            <a href="dashboard.php?menu=berita&aksi=edit&id=<?php echo $row['id_berita']; ?>"
                                                class="btn-table-action btn-edit-ui">Edit</a>
                                            <a href="dashboard.php?menu=berita&aksi=hapus&id=<?php echo $row['id_berita']; ?>"
                                                class="btn-table-action btn-delete-ui"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">Hapus</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="4" style="text-align:center; padding: 40px; color:#a0aec0;">Belum ada berita yang diterbitkan.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Modal Preview -->
            <div id="preview-modal"
                style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
                <div
                    style="background:#fff; max-width:800px; width:90%; border-radius:12px; padding:20px; box-shadow:0 10px 30px rgba(0,0,0,0.2);">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                        <h3 id="modal-judul" style="margin:0;"></h3>
                        <button id="close-modal"
                            style="background:#ef4444; color:#fff; border:none; padding:6px 10px; border-radius:6px; cursor:pointer;">Tutup</button>
                    </div>
                    <div id="modal-tanggal" style="color:#718096; margin-bottom:10px;"></div>
                    <div id="modal-isi" style="white-space:pre-wrap; color:#2d3748;"></div>
                </div>
            </div>
            <?php
            break;

        case 'tambah':
        case 'edit':
            $data_berita = ['judul' => '', 'isi' => '', 'tanggal' => ''];
            if ($aksi === 'edit') {
                $query_edit = mysqli_query($koneksi, "SELECT * FROM tabel_berita WHERE id_berita = $id");
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
                        <input type="text" name="judul" value="<?php echo htmlspecialchars($data_berita['judul']); ?>"
                            placeholder="Contoh: Jadwal Operasional Bus Menjelang Libur Nasional" required>
                    </div>

                    <div class="form-group-block">
                        <label>Isi Konten Berita</label>
                        <textarea name="isi" rows="8"
                            placeholder="Tulis rincian informasi atau pengumuman secara detail di sini..."
                            required><?php echo htmlspecialchars($data_berita['isi']); ?></textarea>
                    </div>

                    <div class="form-group-block short-width">
                        <label>Tanggal Publikasi</label>
                        <input type="date" name="tanggal" value="<?php echo htmlspecialchars($data_berita['tanggal']); ?>"
                            required>
                    </div>

                    <div class="form-action-footer">
                        <button type="submit" name="<?php echo $nama_tombol; ?>" class="btn-modern btn-submit-form">Simpan Data
                            Berita</button>
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
<script>
    // Client-side search filter
    document.addEventListener('DOMContentLoaded', function () {
        var search = document.getElementById('search-input');
        var table = document.getElementById('berita-table');
        if (search && table) {
            search.addEventListener('input', function () {
                var q = this.value.toLowerCase();
                var rows = table.querySelectorAll('tbody tr');
                rows.forEach(function (r) {
                    var judul = (r.querySelector('.td-title-cell strong') || { innerText: '' }).innerText.toLowerCase();
                    var tanggal = (r.querySelector('.td-date-cell') || { innerText: '' }).innerText.toLowerCase();
                    if (judul.indexOf(q) !== -1 || tanggal.indexOf(q) !== -1) {
                        r.style.display = '';
                    } else {
                        r.style.display = 'none';
                    }
                });
            });
        }

        // Select all
        var selectAll = document.getElementById('select-all');
        if (selectAll) {
            selectAll.addEventListener('change', function () {
                var checked = this.checked;
                document.querySelectorAll('.row-select').forEach(function (cb) { cb.checked = checked; });
            });
        }

        // Preview modal
        var previewBtn = document.getElementById('preview-btn');
        var modal = document.getElementById('preview-modal');
        var closeBtn = document.getElementById('close-modal');
        if (previewBtn) {
            previewBtn.addEventListener('click', function () {
                var checked = document.querySelectorAll('.row-select:checked');
                if (!checked || checked.length === 0) { alert('Silakan pilih satu berita untuk preview.'); return; }
                var first = checked[0];
                var tr = first.closest('tr');
                if (!tr) return;
                document.getElementById('modal-judul').innerText = tr.getAttribute('data-judul') || '';
                document.getElementById('modal-tanggal').innerText = tr.getAttribute('data-tanggal') || '';
                document.getElementById('modal-isi').innerText = tr.getAttribute('data-isi') || '';
                modal.style.display = 'flex';
            });
        }
        if (closeBtn) closeBtn.addEventListener('click', function () { modal.style.display = 'none'; });
        if (modal) modal.addEventListener('click', function (e) { if (e.target === modal) modal.style.display = 'none'; });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') modal && (modal.style.display = 'none'); });
    });
</script>