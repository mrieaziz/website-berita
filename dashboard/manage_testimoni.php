<?php
// Pastikan session sudah aktif untuk mengambil nama user login (jika ada)
// session_start(); 

// 1. Aksi Hapus (Ditambahkan hapus file foto lama agar tidak nyampah di folder)
if ($aksi == 'hapus' && $id > 0) {
    $data_lama = mysqli_fetch_array(mysqli_query($koneksi, "SELECT foto FROM tabel_testimoni WHERE id_testi=$id"));
    if(!empty($data_lama['foto']) && file_exists("uploads/".$data_lama['foto'])) {
        unlink("uploads/".$data_lama['foto']);
    }
    mysqli_query($koneksi, "DELETE FROM tabel_testimoni WHERE id_testi=$id");
    echo "<script>window.location='dashboard.php?menu=testimoni';</script>";
}

// 2. Aksi Simpan Baru
if (isset($_POST['simpan_testi'])) {
    $tgl = date('Y-m-d');
    $nama_foto = "";
    
    // Proses Upload Foto jika ada
    if(isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != "") {
        $ekstensi = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $nama_foto = "testi_".time().".".$ekstensi;
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/".$nama_foto);
    }

    // Ditambahkan input kosong (NULL) untuk kolom balasan_admin saat ulasan baru dibuat
    mysqli_query($koneksi, "INSERT INTO tabel_testimoni VALUES (NULL, '$_POST[nama_user]', '$_POST[komentar]', '$_POST[rating]', '$tgl', 'Aktif', '$nama_foto', NULL)");
    echo "<script>window.location='dashboard.php?menu=testimoni';</script>";
}

// 3. Aksi Update/Edit & Balas Admin
if (isset($_POST['update_testi'])) {
    $nama_foto = $_POST['foto_lama'];
    
    // Jika ada upload foto baru
    if(isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != "") {
        $ekstensi = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $nama_foto = "testi_".time().".".$ekstensi;
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/".$nama_foto);
        
        // Hapus foto lama jika ada
        if(!empty($_POST['foto_lama']) && file_exists("uploads/".$_POST['foto_lama'])) {
            unlink("uploads/".$_POST['foto_lama']);
        }
    }

    // Query UPDATE ditambahkan kolom balasan_admin='$_POST[balasan_admin]'
    mysqli_query($koneksi, "UPDATE tabel_testimoni SET nama_user='$_POST[nama_user]', komentar='$_POST[komentar]', rating='$_POST[rating]', status='$_POST[status]', foto='$nama_foto', balasan_admin='$_POST[balasan_admin]' WHERE id_testi=$id");
    echo "<script>window.location='dashboard.php?menu=testimoni';</script>";
}
?>

<h2>Kelola Testimoni & Review Pengguna (Anggota 5)</h2>

<?php if ($aksi == 'tampil') { 
    // Hitung Ringkasan Statistik
    $total_res = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total, AVG(rating) as rata_rata FROM tabel_testimoni"));
    $rating_rata = round($total_res['rata_rata'], 1);
?>
    <!-- Widget Statistik Singkat -->
    <div style="display: flex; gap: 15px; margin-bottom: 20px;">
        <div style="flex: 1; background: #f8f9fa; padding: 15px; border-left: 5px solid #007bff; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <span style="font-size: 12px; color: #6c757d; font-weight: bold; text-transform: uppercase;">Total Review</span>
            <h3 style="margin: 5px 0 0 0; font-size: 24px; color: #333;"><?=$total_res['total']?> ulasan</h3>
        </div>
        <div style="flex: 1; background: #f8f9fa; padding: 15px; border-left: 5px solid #ffc107; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <span style="font-size: 12px; color: #6c757d; font-weight: bold; text-transform: uppercase;">Rata-rata Rating</span>
            <h3 style="margin: 5px 0 0 0; font-size: 24px; color: #333;">⭐ <?=$rating_rata > 0 ? $rating_rata : '0'?> <small style="font-size:14px; color:#777;">/ 5</small></h3>
        </div>
    </div>

    <div style="margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center;">
        <a href="dashboard.php?menu=testimoni&aksi=tambah" class="btn btn-green">+ Beri Review Baru</a>
    </div>
    
    <table>
        <tr>
            <th>Nama Penumpang</th>
            <th>Ulasan / Komentar</th>
            <th>Rating</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
        <?php 
        $q = mysqli_query($koneksi, "SELECT * FROM tabel_testimoni ORDER BY id_testi DESC"); 
        if(mysqli_num_rows($q) == 0) {
            echo "<tr><td colspan='5' style='text-align:center; padding:20px; color:#aaa;'>Belum ada testimoni masuk.</td></tr>";
        }
        while($d = mysqli_fetch_array($q)){ 
        ?>
        <tr>
            <td><strong><?=$d['nama_user']?></strong></td>
            <td>
                <em>"<?=$d['komentar']?>"</em>
                
                <!-- COBA LIHAT DISINI: Menampilkan Balasan Admin jika sudah dibalas -->
                <?php if(!empty($d['balasan_admin'])) { ?>
                    <div style="margin-top: 8px; padding: 8px; background: #e9ecef; border-left: 3px solid #28a745; border-radius: 4px; font-size: 13px;">
                        <strong>Balasan Admin:</strong> <span><?=$d['balasan_admin']?></span>
                    </div>
                <?php } else { ?>
                    <div style="margin-top: 5px;">
                        <small style="color: #dc3545; font-style: italic;">Belum dibalas</small>
                    </div>
                <?php } ?>
            </td>
            <td>
                <span style="color: #ffc107;">
                    <?=str_repeat('⭐', $d['rating'])?>
                </span> 
                <small>(<?=$d['rating']?>/5)</small>
            </td>
            <td>
                <small style="color: #666; font-weight: bold;"><?=date('d M Y', strtotime($d['tgl']))?></small>
            </td>
            <td>
                <!-- Tombol Edit diubah teksnya jadi Edit / Balas agar informatif bagi admin -->
                <a href="dashboard.php?menu=testimoni&aksi=edit&id=<?=$d['id_testi']?>" class="btn btn-yellow">Edit / Balas</a>
                <a href="dashboard.php?menu=testimoni&aksi=hapus&id=<?=$d['id_testi']?>" class="btn btn-red" onclick="return confirm('Hapus testimoni dari <?=$d['nama_user']?>?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
    
<?php } else {
    // Default values untuk form tambah
    $session_nama = isset($_SESSION['nama_lengkap']) ? $_SESSION['nama_lengkap'] : (isset($_SESSION['username']) ? $_SESSION['username'] : '');
    $d = ['nama_user'=>$session_nama, 'komentar'=>'', 'rating'=>'5', 'status'=>'Aktif', 'foto'=>'', 'balasan_admin'=>''];
    
    if ($aksi == 'edit') {
        $d = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tabel_testimoni WHERE id_testi=$id"));
    }
?>
    <!-- Form Tambah & Edit -->
    <form action="" method="POST" enctype="multipart/form-data">
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

        <label>Foto Profil / Lampiran Bukti</label>
        <?php if($aksi == 'edit' && !empty($d['foto']) && file_exists("uploads/".$d['foto'])) { ?>
            <div style="margin-bottom: 10px;">
                <img src="uploads/<?=$d['foto']?>" style="width: 60px; height: 60px; border-radius: 4px; object-fit: cover; display: block; margin-bottom: 5px;">
                <small style="color: #666;">Foto saat ini (biarkan jika tidak ingin diganti)</small>
            </div>
        <?php } ?>
        <input type="file" name="foto" accept="image/*">
        <input type="hidden" name="foto_lama" value="<?=$d['foto']?>">

        <!-- FITUR UTAMA: Form Input Balasan Admin (Hanya muncul ketika mode EDIT) -->
        <?php if ($aksi == 'edit') { ?>
            <div style="margin-top: 15px; padding: 15px; background: #f1f3f5; border-radius: 6px; border: 1px solid #ced4da;">
                <label style="font-weight: bold; color: #28a745; display: block; margin-bottom: 5px;">💬 Tulis Balasan Admin</label>
                <textarea name="balasan_admin" rows="3" placeholder="Terima kasih atas ulasannya! Kami akan terus meningkatkan kualitas..." style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc; font-family: inherit; resize: vertical;"><?=$d['balasan_admin']?></textarea>
            </div>

            <label style="margin-top:10px; display:block;">Status Tampilan</label>
            <select name="status">
                <option value="Aktif" <?=$d['status']=='Aktif'?'selected':''?>>Aktif (Tampilkan)</option>
                <option value="Pending" <?=$d['status']=='Pending'?'selected':''?>>Pending (Sembunyikan)</option>
            </select>
        <?php } else { ?>
            <!-- Jika tambah data baru, set balasan_admin jadi string kosong otomatis -->
            <input type="hidden" name="balasan_admin" value="">
            <input type="hidden" name="status" value="Aktif">
        <?php } ?>

        <button type="submit" name="<?=$aksi=='tambah'?'simpan_testi':'update_testi'?>" class="btn btn-green" style="margin-top:15px;">Simpan Ulasan</button>
        <a href="dashboard.php?menu=testimoni" class="btn" style="margin-top:15px; background:#ccc; color:#333; text-decoration:none; padding:6px 12px; border-radius:4px; display:inline-block;">Kembali</a>
    </form>
<?php } ?>