<?php
// Koneksi database untuk Railway (Dengan Debug)
$host = getenv('MYSQLHOST') ?: $_ENV['MYSQLHOST'] ?? '';
$port = getenv('MYSQLPORT') ?: $_ENV['MYSQLPORT'] ?? '';
$user = getenv('MYSQLUSER') ?: $_ENV['MYSQLUSER'] ?? '';
$pass = getenv('MYSQLPASSWORD') ?: $_ENV['MYSQLPASSWORD'] ?? '';
$dbname = getenv('MYSQLDATABASE') ?: $_ENV['MYSQLDATABASE'] ?? '';

// Debug: Tampilkan variabel (hapus setelah berhasil!)
// echo "Host: $host, Port: $port, User: $user, DB: $dbname<br>";

$conn = new mysqli($host, $user, $pass, $dbname, $port);
// Ambil daftar gunung untuk dropdown
$gunung_query = $conn->query("SELECT * FROM gunung ORDER BY nama_gunung ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pendakian | SIM-PEND</title>
    <meta name="description" content="Sistem Informasi Manajemen Pendakian - Daftarkan pendakian Anda secara online.">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<nav class="pub-nav">
    <a href="index.php" class="logo">
        <span class="logo-icon">⛰️</span>
        SIM-PEND
    </a>
    <div class="nav-links">
        <a href="daftar_pendaftaran.php">📋 <span class="nav-text">Daftar ID</span></a>
        <a href="cek_status.php">🔍 <span class="nav-text">Cek Status</span></a>
        <a href="login.php" class="nav-cta">Portal Admin</a>
    </div>
</nav>

<div class="pub-container fade-slide-up">
    <div class="card">
        <div class="card-header">
            <div class="icon-circle">🏔️</div>
            <h2>Pendaftaran Pendakian</h2>
            <p>Isi formulir di bawah untuk mendaftarkan tim pendakian Anda</p>
        </div>

        <form action="simpan_booking.php" method="POST" id="formBooking">
            <div class="form-group">
                <label>Nama Ketua Tim</label>
                <input type="text" name="nama_ketua" placeholder="Masukkan nama lengkap ketua" required>
            </div>

            <div class="form-group">
                <label>Tanggal Pendakian</label>
                <input type="date" name="tanggal_pendakian" id="tgl_input" required>
            </div>

            <div class="form-group">
                <label>Pilih Destinasi & Jalur</label>
                <select name="jalur_pendakian" id="jalur_input" required>
                    <option value="">— Pilih Gunung & Jalur —</option>
                    <?php while($g = $gunung_query->fetch_assoc()): ?>
                        <option value="<?= $g['nama_gunung'] ?> - <?= $g['jalur'] ?>">
                            <?= $g['nama_gunung'] ?> (Jalur <?= $g['jalur'] ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div id="info-kuota" class="info-box"></div>

            <div class="form-group">
                <label>Jumlah Anggota Tim</label>
                <input type="number" name="jumlah_anggota" min="1" max="10" placeholder="Maksimal 10 orang" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-lg" id="btnSubmit">
                🚀 Daftar Sekarang
            </button>
        </form>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#tgl_input, #jalur_input').on('change', function(){
        var tgl = $('#tgl_input').val();
        var jalur = $('#jalur_input').val();

        if(tgl !== "" && jalur !== ""){
            var $box = $('#info-kuota');
            $box.addClass('show').html('<span style="color:var(--gray-500)">⏳ Mengecek kuota...</span>');
            
            $.ajax({
                url: "cek_kuota.php",
                method: "POST",
                data: {tanggal: tgl, jalur: jalur},
                success: function(response){
                    $box.html(response);
                }
            });
        }
    });
});
</script>

</body>
</html>