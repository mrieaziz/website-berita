<?php
include 'koneksi/koneksi.php';

$pesan = "";

if (isset($_POST['register'])) {
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $telepon  = mysqli_real_escape_string($koneksi, $_POST['no_telepon']);
    $password = $_POST['password'];

    // Enkripsi password agar aman di database
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah email sudah terdaftar
    $cek_email = mysqli_query($koneksi, "SELECT * FROM tabel_pelanggan WHERE email='$email'");
    if (mysqli_num_rows($cek_email) > 0) {
        $pesan = "<div style='color:red; text-align:center;'>Email sudah terdaftar! Silakan gunakan email lain.</div>";
    } else {
        // Simpan ke database
        $insert = mysqli_query($koneksi, "INSERT INTO tabel_pelanggan (nama_lengkap, email, password, no_telepon) VALUES ('$nama', '$email', '$password_hashed', '$telepon')");
        
        if ($insert) {
            $pesan = "<div style='color:green; text-align:center;'>Registrasi Berhasil! Silakan <a href='login_user.php'>Login disini</a>.</div>";
        } else {
            $pesan = "<div style='color:red; text-align:center;'>Registrasi Gagal, terjadi kesalahan sistem.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Akun Penumpang</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 350px; }
        .card h2 { text-align: center; color: #2c3e50; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; color: #555; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn { width: 100%; padding: 10px; background-color: #3498db; border: none; color: white; border-radius: 4px; font-size: 16px; cursor: pointer; }
        .btn:hover { background-color: #2980b9; }
        .links { text-align: center; margin-top: 15px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Daftar Akun Baru</h2>
        <?php echo $pesan; ?>
        <form action="" method="POST">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>No. Telepon / WhatsApp</label>
                <input type="text" name="no_telepon" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="register" class="btn">Daftar Sekarang</button>
        </form>
        <div class="links">
            Sudah punya akun? <a href="login_user.php">Login di sini</a>
        </div>
    </div>
</body>
</html>