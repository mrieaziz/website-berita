<?php
include 'koneksi/koneksi.php';

// Pastikan session_start() sudah dipanggil, biasanya di dalam koneksi.php
// Jika belum, uncomment baris di bawah ini:
// session_start();

if (isset($_SESSION['login'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if (isset($_POST['btn_login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, md5($_POST['password']));

    $query = mysqli_query($koneksi, "SELECT * FROM tabel_user WHERE username='$username' AND password='$password'");
    if (mysqli_num_rows($query) > 0) {
        $r = mysqli_fetch_assoc($query);
        $_SESSION['login']        = true;
        $_SESSION['username']     = $r['username'];
        $_SESSION['nama_lengkap'] = $r['nama_lengkap'];
        
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div style="display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px;">
        
        <div class="form-container" style="width: 100%; max-width: 420px; text-align: center;">
            
            <h3 style="color: #0f172a; font-size: 1.5rem; margin-top: 0;">Login Admin</h3>
            <p style="color: #64748b; margin-bottom: 24px;">Silakan masuk untuk mengelola sistem.</p>

            <?php if (!empty($error)) { ?>
                <div style="background: #fee2e2; color: #b91c1c; padding: 14px; border-radius: 12px; margin-bottom: 20px; font-size: 0.95rem;">
                    <?php echo $error; ?>
                </div>
            <?php } ?>

            <form action="" method="POST" style="text-align: left;">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" type="text" name="username" required placeholder="Masukkan username">
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required placeholder="Masukkan password">
                </div>
                
                <button type="submit" name="btn_login" class="btn-submit" style="margin-top: 10px;">Masuk</button>
            </form>

            <p style="margin-top: 28px; font-size: 0.95rem;">
                <a href="index.php" class="text-link">← Kembali ke halaman utama</a>
            </p>
        </div>
        
    </div>
</body>
</html>