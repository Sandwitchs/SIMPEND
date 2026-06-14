<?php
session_start();
// Koneksi database untuk Railway
$host = getenv('MYSQLHOST');
$port = getenv('MYSQLPORT');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$dbname = getenv('MYSQLDATABASE');

$conn = new mysqli($host, $user, $pass, $dbname, $port);

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Cek di tabel users_admin
$query = $conn->query("SELECT * FROM users_admin WHERE username='$username' AND password='$password'");

if ($query->num_rows > 0) {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['admin_username'] = $username; // Kompatibilitas dengan pengaturan.php
    header("Location: admin.php");
    exit;
} else {
    header("Location: login.php?error=1");
    exit;
}
?>