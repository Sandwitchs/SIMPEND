<?php
// Koneksi database untuk Railway
$host = getenv('MYSQLHOST');
$port = getenv('MYSQLPORT');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$dbname = getenv('MYSQLDATABASE');

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama    = mysqli_real_escape_string($conn, $_POST['nama_ketua']);
    $jalur   = mysqli_real_escape_string($conn, $_POST['jalur_pendakian']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal_pendakian']);
    $anggota = (int)$_POST['jumlah_anggota'];

    // Generate ID Booking Random (Contoh: PEND-5432)
    $id_booking = "PEND-" . rand(1000, 9999);

    $sql = "INSERT INTO pendaftaran (id_booking, nama_ketua, jalur_pendakian, tanggal_pendakian, jumlah_anggota, status_verifikasi) 
            VALUES ('$id_booking', '$nama', '$jalur', '$tanggal', '$anggota', 'pending')";

    if ($conn->query($sql)) {
        // Redirect dengan ID booking sebagai parameter
        header("Location: simpan_sukses.php?id=" . urlencode($id_booking));
        exit;
    } else {
        echo "<script>alert('Terjadi kesalahan: " . addslashes($conn->error) . "'); window.history.back();</script>";
    }
}
?>