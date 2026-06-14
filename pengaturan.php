<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header("Location: login.php"); exit; }

// Koneksi database untuk Railway (Dengan Debug)
$host = getenv('MYSQLHOST') ?: $_ENV['MYSQLHOST'] ?? getenv('MYSQL_HOST') ?: $_ENV['MYSQL_HOST'] ?? '';
$port = (int)(getenv('MYSQLPORT') ?: $_ENV['MYSQLPORT'] ?? getenv('MYSQL_PORT') ?: $_ENV['MYSQL_PORT'] ?? 3306);
$user = getenv('MYSQLUSER') ?: $_ENV['MYSQLUSER'] ?? getenv('MYSQL_USER') ?: $_ENV['MYSQL_USER'] ?? '';
$pass = getenv('MYSQLPASSWORD') ?: $_ENV['MYSQLPASSWORD'] ?? getenv('MYSQL_PASSWORD') ?: $_ENV['MYSQL_PASSWORD'] ?? '';
$dbname = getenv('MYSQLDATABASE') ?: $_ENV['MYSQLDATABASE'] ?? getenv('MYSQL_DATABASE') ?: $_ENV['MYSQL_DATABASE'] ?? '';

$conn = new mysqli($host, $user, $pass, $dbname, $port);
$pesan = "";

if (isset($_POST['update_password'])) {
    // Mendukung kedua session key untuk kompatibilitas
    $user_admin = $_SESSION['admin_username'] ?? $_SESSION['username'] ?? '';
    $pass_lama = mysqli_real_escape_string($conn, $_POST['pass_lama']);
    $pass_baru = mysqli_real_escape_string($conn, $_POST['pass_baru']);
    $konfirmasi = $_POST['konfirmasi'];

    // Cek password lama di tabel users_admin (konsisten dengan proses_login.php)
    $query = $conn->query("SELECT * FROM users_admin WHERE username='$user_admin' AND password='$pass_lama'");
    
    if ($query->num_rows > 0) {
        if ($pass_baru === $konfirmasi) {
            $pass_baru_escaped = mysqli_real_escape_string($conn, $pass_baru);
            $conn->query("UPDATE users_admin SET password='$pass_baru_escaped' WHERE username='$user_admin'");
            $pesan = "success";
        } else {
            $pesan = "mismatch";
        }
    } else {
        $pesan = "wrong_old";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Admin | SIM-PEND</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="admin-layout">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">⛰️</div>
            <div>
                <h2>SIM-PEND</h2>
                <small>Admin Panel</small>
            </div>
        </div>
        <nav class="sidebar-nav">
            <a href="admin.php">
                <span class="nav-icon">📊</span> Dashboard
            </a>
            <a href="data_gunung.php">
                <span class="nav-icon">🏔️</span> Data Gunung
            </a>
            <a href="pengaturan.php" class="active">
                <span class="nav-icon">⚙️</span> Pengaturan
            </a>
            <div class="nav-spacer"></div>
            <a href="logout.php" class="nav-logout">
                <span class="nav-icon">🚪</span> Logout
            </a>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="admin-main">
        <div class="page-header">
            <h1>Pengaturan Akun</h1>
            <p>Kelola keamanan akun admin Anda</p>
        </div>

        <div class="card fade-slide-up" style="max-width:460px;">
            <h3 style="font-size:16px; font-weight:700; color:var(--gray-800); margin-bottom:6px;">🔒 Ubah Password</h3>
            <p style="color:var(--gray-500); font-size:13px; margin-bottom:20px;">Pastikan password baru Anda cukup kuat dan mudah diingat</p>

            <?php if ($pesan == 'success'): ?>
                <div class="info-box success show" style="margin-bottom:18px;">✅ Password berhasil diperbarui!</div>
            <?php elseif ($pesan == 'mismatch'): ?>
                <div class="info-box error show" style="margin-bottom:18px;">❌ Konfirmasi password baru tidak cocok.</div>
            <?php elseif ($pesan == 'wrong_old'): ?>
                <div class="info-box error show" style="margin-bottom:18px;">❌ Password lama salah.</div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Password Lama</label>
                    <input type="password" name="pass_lama" placeholder="Masukkan password saat ini" required>
                </div>
                
                <div class="form-group">
                    <label>Password Baru</label>
                    <input type="password" name="pass_baru" placeholder="Masukkan password baru" required>
                </div>
                
                <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="konfirmasi" placeholder="Ulangi password baru" required>
                </div>
                
                <button type="submit" name="update_password" class="btn btn-primary btn-block btn-lg">
                    💾 Simpan Perubahan
                </button>
            </form>
        </div>
    </main>
</div>

</body>
</html>