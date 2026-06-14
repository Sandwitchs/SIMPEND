<?php
$conn = new mysqli("localhost", "root", "", "simpend_db");
$hasil = null;

if (isset($_POST['cari'])) {
    $id_cari = mysqli_real_escape_string($conn, $_POST['id_booking']);
    $query = $conn->query("SELECT * FROM pendaftaran WHERE id_booking = '$id_cari'");
    $hasil = $query->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Pendakian | SIM-PEND</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="pub-nav">
    <a href="index.php" class="logo">
        <span class="logo-icon">⛰️</span>
        SIM-PEND
    </a>
    <div class="nav-links">
        <a href="index.php">📝 <span class="nav-text">Daftar</span></a>
        <a href="daftar_pendaftaran.php">📋 <span class="nav-text">Daftar ID</span></a>
        <a href="login.php" class="nav-cta">Portal Admin</a>
    </div>
</nav>

<div class="pub-container fade-slide-up">
    <div class="card">
        <div class="card-header">
            <div class="icon-circle">🔍</div>
            <h2>Cek Status Pendakian</h2>
            <p>Masukkan ID Booking untuk melihat status pendaftaran Anda</p>
        </div>

        <form method="POST">
            <div class="form-group" style="display:flex; gap:8px;">
                <input type="text" name="id_booking" placeholder="Contoh: PEND-1234" required
                       style="flex:1;" value="<?= isset($_POST['id_booking']) ? htmlspecialchars($_POST['id_booking']) : '' ?>">
                <button type="submit" name="cari" class="btn btn-primary" style="white-space:nowrap;">
                    🔍 Cek
                </button>
            </div>
        </form>

        <?php if ($hasil): ?>
            <?php 
                $status = strtolower($hasil['status_verifikasi']);
                $class_status = "result-" . $status;
                $status_label = strtoupper($status);
                $status_emoji = $status == 'disetujui' ? '✅' : ($status == 'ditolak' ? '❌' : '⏳');
            ?>
            
            <div class="result-box <?= $class_status ?>">
                <h3><?= $status_emoji ?> ID Booking: <?= htmlspecialchars($hasil['id_booking']) ?></h3>
                
                <div style="margin-top:8px;">
                    <span class="detail-label">Nama Ketua:</span>
                    <span class="detail-value"><?= htmlspecialchars($hasil['nama_ketua']) ?></span>
                </div>
                
                <div>
                    <span class="detail-label">Jalur:</span>
                    <span class="detail-value"><?= htmlspecialchars($hasil['jalur_pendakian']) ?></span>
                </div>
                
                <div>
                    <span class="detail-label">Waktu Daftar:</span>
                    <span class="detail-value"><?= !empty($hasil['created_at']) ? date('d M Y, H:i', strtotime($hasil['created_at'])) : '-' ?></span>
                </div>
                
                <div>
                    <span class="detail-label">Status:</span>
                    <span class="badge badge-<?= $status ?>"><?= $status_label ?></span>
                </div>
                
                <div>
                    <span class="detail-label">Diverifikasi:</span>
                    <span class="detail-value">
                        <?= (!empty($hasil['tanggal_verifikasi']) && $hasil['tanggal_verifikasi'] != '0000-00-00 00:00:00')
                            ? date('d M Y, H:i', strtotime($hasil['tanggal_verifikasi']))
                            : 'Belum diproses' ?>
                    </span>
                </div>

                <?php if ($status == 'ditolak' && !empty($hasil['alasan_penolakan'])): ?>
                    <div class="rejection-reason">
                        📝 Alasan Penolakan:<br>
                        "<?= htmlspecialchars($hasil['alasan_penolakan']) ?>"
                    </div>
                <?php endif; ?>
            </div>

        <?php elseif (isset($_POST['cari'])): ?>
            <div class="info-box error show" style="margin-top:20px;">
                ❌ ID Booking tidak ditemukan! Pastikan ID yang Anda masukkan benar.
            </div>
        <?php endif; ?>
    </div>

    <div style="text-align:center; margin-top:20px;">
        <a href="index.php" class="back-link">← Kembali ke Pendaftaran</a>
    </div>
</div>

</body>
</html>