<?php
include 'koneksi/koneksi.php';

$pesan = "";

if (isset($_POST['login'])) {
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM tabel_pelanggan WHERE email='$email'");
    if (mysqli_num_rows($query) === 1) {
        $data_user = mysqli_fetch_assoc($query);
        
        // Verifikasi kesesuaian password terenkripsi
        if (password_verify($password, $data_user['password'])) {
            // Set session khusus pelanggan
            $_SESSION['pelanggan_login'] = true;
            $_SESSION['id_pelanggan']    = $data_user['id_pelanggan'];
            $_SESSION['nama_pelanggan']  = $data_user['nama_lengkap'];
            
            header("Location: index.php");
            exit;
        } else {
            $pesan = "<div style='color:red; text-align:center;'>Password salah!</div>";
        }
    } else {
        $pesan = "<div style='color:red; text-align:center;'>Email tidak terdaftar!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Penumpang</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 350px; }
        .card h2 { text-align: center; color: #2c3e50; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; color: #555; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn { width: 100%; padding: 10px; background-color: #2ecc71; border: none; color: white; border-radius: 4px; font-size: 16px; cursor: pointer; }
        .btn:hover { background-color: #27ae60; }
        .links { text-align: center; margin-top: 15px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Login Penumpang</h2>
        <?php echo $pesan; ?>
        <form action="" method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="login" class="btn"> Masuk</button>
        </form>
        <div class="links">
            Belum punya akun? <a href="register.php">Registrasi di sini</a>
        </div>
    </div>
</body>
</html>