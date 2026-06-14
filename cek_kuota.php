<?php
// Koneksi database untuk Railway (Dengan Debug)
$host = getenv('MYSQLHOST') ?: $_ENV['MYSQLHOST'] ?? '';
$port = getenv('MYSQLPORT') ?: $_ENV['MYSQLPORT'] ?? '';
$user = getenv('MYSQLUSER') ?: $_ENV['MYSQLUSER'] ?? '';
$pass = getenv('MYSQLPASSWORD') ?: $_ENV['MYSQLPASSWORD'] ?? '';
$dbname = getenv('MYSQLDATABASE') ?: $_ENV['MYSQLDATABASE'] ?? '';

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if(isset($_POST['tanggal']) && isset($_POST['jalur'])){
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $jalur = mysqli_real_escape_string($conn, $_POST['jalur']);

    // Pecah string "Gunung Gede - Cibodas" untuk ambil nama gunung
    $pecah = explode(" - ", $jalur);
    $nama_gunung = mysqli_real_escape_string($conn, $pecah[0]);
    
    // Cek kolom kuota_maks (sesuai dengan data_gunung.php)
    $g_query = $conn->query("SELECT kuota_maks FROM gunung WHERE nama_gunung = '$nama_gunung'");
    $g_data = $g_query->fetch_assoc();
    $max = $g_data['kuota_maks'] ?? 50; // Default 50 jika tidak diatur

    // Hitung jumlah pendaki yang sudah DISETUJUI di tanggal & jalur tersebut
    $p_query = $conn->query("SELECT SUM(jumlah_anggota) as total FROM pendaftaran 
                             WHERE jalur_pendakian = '$jalur' 
                             AND tanggal_pendakian = '$tanggal' 
                             AND status_verifikasi = 'disetujui'");
    $p_data = $p_query->fetch_assoc();
    $terisi = $p_data['total'] ?? 0;

    $sisa = $max - $terisi;

    if($sisa <= 0){
        echo "<span style='color:#991b1b; font-weight:600;'>❌ Kuota Penuh! Silakan pilih tanggal lain.</span>";
        echo "<script>$('#btnSubmit').prop('disabled', true).css({'opacity':'0.5','cursor':'not-allowed'});</script>";
    } else {
        echo "<span style='color:#065f46; font-weight:600;'>✅ Sisa Kuota: <strong>$sisa</strong> dari $max orang</span>";
        echo "<script>$('#btnSubmit').prop('disabled', false).css({'opacity':'1','cursor':'pointer'});</script>";
    }
}
?>