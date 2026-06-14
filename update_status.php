<?php
session_start();
// Pastikan hanya admin yang bisa mengakses
if (!isset($_SESSION['admin_logged_in'])) { header("Location: login.php"); exit; }

// Koneksi database untuk Railway
$host = getenv('MYSQLHOST');
$port = getenv('MYSQLPORT');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$dbname = getenv('MYSQLDATABASE');

$conn = new mysqli($host, $user, $pass, $dbname, $port);

// Set zona waktu agar jam verifikasi akurat
date_default_timezone_set('Asia/Jakarta');

// Terima dari POST (form modal) atau GET (fallback)
$id = null;
$status = null;
$alasan = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? mysqli_real_escape_string($conn, $_POST['id']) : null;
    $status = isset($_POST['status']) ? mysqli_real_escape_string($conn, $_POST['status']) : null;
    $alasan = isset($_POST['alasan']) ? mysqli_real_escape_string($conn, $_POST['alasan']) : null;
} elseif (isset($_GET['id']) && isset($_GET['status'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $status = mysqli_real_escape_string($conn, $_GET['status']);
    $alasan = isset($_GET['alasan']) ? mysqli_real_escape_string($conn, $_GET['alasan']) : null;
}

if ($id && $status) {
    $waktu_sekarang = date('Y-m-d H:i:s');
    
    // Query Update
    if ($alasan) {
        $sql = "UPDATE pendaftaran SET 
                status_verifikasi = '$status', 
                tanggal_verifikasi = '$waktu_sekarang',
                alasan_penolakan = '$alasan'
                WHERE id = '$id'";
    } else {
        $sql = "UPDATE pendaftaran SET 
                status_verifikasi = '$status', 
                tanggal_verifikasi = '$waktu_sekarang',
                alasan_penolakan = NULL
                WHERE id = '$id'";
    }
            
    if($conn->query($sql)) {
        header("Location: admin.php?status=success");
        exit();
    } else {
        echo "Gagal memperbarui data: " . $conn->error;
    }
} else {
    header("Location: admin.php");
    exit();
}
?>