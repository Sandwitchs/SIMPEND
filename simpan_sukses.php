<?php
$id_booking = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
if (empty($id_booking)) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil | SIM-PEND</title>
    <link rel="stylesheet" href="style.css">
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
    <div class="card" style="text-align:center;">
        <div style="font-size:64px; margin-bottom:16px;">🎉</div>
        <h2 style="font-size:24px; font-weight:800; color:var(--gray-900); margin-bottom:8px;">Pendaftaran Berhasil!</h2>
        <p style="color:var(--gray-500); margin-bottom:24px;">Tim pendakian Anda telah terdaftar. Simpan ID Booking berikut:</p>

        <div style="background:linear-gradient(135deg, var(--primary-50), var(--primary-100)); padding:20px; border-radius:var(--radius-lg); margin-bottom:24px; border:2px dashed var(--primary-300);">
            <small style="color:var(--primary-600); font-weight:600; text-transform:uppercase; letter-spacing:1px; font-size:11px;">ID Booking Anda</small>
            <div style="font-size:32px; font-weight:800; color:var(--primary-700); font-family:monospace; letter-spacing:2px; margin-top:6px;">
                <?= $id_booking ?>
            </div>
        </div>

        <div class="info-box show" style="background:var(--accent-amber-light); color:#92400e; border:1px solid #fde68a; text-align:left;">
            ⚠️ <strong>Penting!</strong> Catat atau screenshot ID Booking ini. Anda membutuhkannya untuk mengecek status pendaftaran.
        </div>

        <div style="display:flex; gap:10px; margin-top:24px;">
            <a href="cek_status.php" class="btn btn-primary" style="flex:1;">🔍 Cek Status</a>
            <a href="index.php" class="btn btn-outline" style="flex:1;">📝 Daftar Lagi</a>
        </div>
    </div>
</div>

</body>
</html>
