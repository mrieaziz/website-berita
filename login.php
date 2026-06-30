<?php
include 'koneksi/koneksi.php';

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
        $_SESSION['nama_lengkap']  = $r['nama_lengkap'];
        
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
    <title>Login Admin</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .login-wrapper { height: 100vh; display: flex; justify-content: center; align-items: center; background: #2c3e50; }
        .login-box { background: white; padding: 40px; border-radius: 8px; width: 350px; }
        .login-box h2 { text-align: center; color: #004d99; margin-bottom: 20px;}
        .alert-error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; text-align: center; margin-bottom: 15px;}
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-box">
            <h2>Sign In Admin</h2>
            <?php if (!empty($error)) { echo "<div class='alert-error'>$error</div>"; } ?>
            <form action="" method="POST" style="border:none; padding:0;">
                <label>Username</label><input type="text" name="username" required>
                <label>Password</label><input type="password" name="password" required>
                <button type="submit" name="btn_login" class="btn" style="width:100%; background:#004d99; margin-top:20px; padding:10px;">Masuk</button>
                <a href="index.php" style="display:block; text-align:center; margin-top:15px; color:gray; font-size:13px;">← Kembali</a>
            </form>
        </div>
    </div>
</body>
</html>