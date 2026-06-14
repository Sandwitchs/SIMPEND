<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | SIM-PEND</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">

<div class="login-card">
    <div class="card-header">
        <div class="icon-circle">⛰️</div>
        <h2>SIM-PEND Admin</h2>
        <p>Sistem Informasi Manajemen Pendakian</p>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="info-box error show" style="margin-bottom:18px;">
            ❌ Username atau password salah!
        </div>
    <?php endif; ?>

    <form action="proses_login.php" method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Masukkan username" required autofocus>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block btn-lg" style="margin-top:6px;">
            Masuk ke Dashboard
        </button>
    </form>

    <div style="text-align:center; margin-top:20px;">
        <a href="index.php" class="back-link" style="justify-content:center;">← Kembali ke Halaman Utama</a>
    </div>
</div>

</body>
</html>