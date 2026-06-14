<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header("Location: login.php"); exit; }

// Koneksi database untuk Railway (Dengan Debug)
$host = getenv('MYSQLHOST') ?: $_ENV['MYSQLHOST'] ?? '';
$port = (int)(getenv('MYSQLPORT') ?: $_ENV['MYSQLPORT'] ?? 3306);
$user = getenv('MYSQLUSER') ?: $_ENV['MYSQLUSER'] ?? '';
$pass = getenv('MYSQLPASSWORD') ?: $_ENV['MYSQLPASSWORD'] ?? '';
$dbname = getenv('MYSQLDATABASE') ?: $_ENV['MYSQLDATABASE'] ?? '';

$conn = new mysqli($host, $user, $pass, $dbname, $port);

// Mendukung kedua session key untuk kompatibilitas
$username = $_SESSION['admin_username'] ?? $_SESSION['username'] ?? '';
$old_pass = mysqli_real_escape_string($conn, $_POST['old_password']);
$new_pass = mysqli_real_escape_string($conn, $_POST['new_password']);
$conf_pass = $_POST['confirm_password'];

// Cek apakah password lama benar (gunakan tabel users_admin yang konsisten)
$query = $conn->query("SELECT * FROM users_admin WHERE username='$username' AND password='$old_pass'");

if ($query->num_rows > 0) {
    if ($new_pass === $conf_pass) {
        $new_pass_escaped = mysqli_real_escape_string($conn, $new_pass);
        $conn->query("UPDATE users_admin SET password='$new_pass_escaped' WHERE username='$username'");
        echo "<script>alert('Password berhasil diganti!'); window.location='pengaturan.php';</script>";
    } else {
        echo "<script>alert('Konfirmasi password baru tidak cocok!'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Password lama salah!'); window.history.back();</script>";
}
?>