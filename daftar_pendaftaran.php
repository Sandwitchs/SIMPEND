<?php
// Koneksi database untuk Railway (Dengan Debug)
$host = getenv('MYSQLHOST') ?: $_ENV['MYSQLHOST'] ?? '';
$port = (int)(getenv('MYSQLPORT') ?: $_ENV['MYSQLPORT'] ?? 3306);
$user = getenv('MYSQLUSER') ?: $_ENV['MYSQLUSER'] ?? '';
$pass = getenv('MYSQLPASSWORD') ?: $_ENV['MYSQLPASSWORD'] ?? '';
$dbname = getenv('MYSQLDATABASE') ?: $_ENV['MYSQLDATABASE'] ?? '';

$conn = new mysqli($host, $user, $pass, $dbname, $port);

// Ambil semua data pendaftaran yang terbaru
$query = $conn->query("SELECT id_booking, nama_ketua, status_verifikasi, created_at, tanggal_verifikasi FROM pendaftaran ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar ID Pendaftaran | SIM-PEND</title>
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
        <a href="cek_status.php">🔍 <span class="nav-text">Cek Status</span></a>
        <a href="login.php" class="nav-cta">Portal Admin</a>
    </div>
</nav>

<div class="pub-container-wide fade-slide-up">
    <a href="index.php" class="back-link">← Kembali ke Form Pendaftaran</a>

    <div class="card" style="padding:0; overflow:hidden;">
        <div style="padding:28px 36px 20px;">
            <div class="card-header" style="margin-bottom:0;">
                <div class="icon-circle">📋</div>
                <h2>Daftar ID Pendaftaran</h2>
                <p>Semua pendaftaran pendakian yang masuk</p>
            </div>
        </div>

        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:linear-gradient(135deg, var(--primary-600), var(--primary-700));">
                    <th style="padding:14px 24px; color:white; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.8px; text-align:left;">ID Booking</th>
                    <th style="padding:14px 24px; color:white; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.8px; text-align:left;">Nama Ketua</th>
                    <th style="padding:14px 24px; color:white; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.8px; text-align:left;">Tanggal Daftar</th>
                    <th style="padding:14px 24px; color:white; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.8px; text-align:left;">Status</th>
                    <th style="padding:14px 24px; color:white; font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:0.8px; text-align:left;">Waktu Verifikasi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($query->num_rows > 0): ?>
                    <?php while($row = $query->fetch_assoc()): ?>
                    <tr style="transition:all 0.2s; border-bottom:1px solid var(--gray-100);">
                        <td style="padding:14px 24px;">
                            <span style="background:var(--accent-blue-light); color:var(--accent-blue); padding:4px 10px; border-radius:var(--radius-sm); font-weight:700; font-family:monospace; font-size:13px;">
                                <?= $row['id_booking'] ?>
                            </span>
                        </td>
                        <td style="padding:14px 24px; font-size:14px; color:var(--gray-700);">
                            <?= htmlspecialchars($row['nama_ketua']) ?>
                        </td>
                        <td style="padding:14px 24px; font-size:13px; color:var(--gray-400);">
                            <?= !empty($row['created_at']) ? date('d M Y', strtotime($row['created_at'])) : '-' ?>
                        </td>
                        <td style="padding:14px 24px;">
                            <span class="badge badge-<?= strtolower($row['status_verifikasi']) ?>">
                                <?= strtoupper($row['status_verifikasi']) ?>
                            </span>
                        </td>
                        <td style="padding:14px 24px; font-size:13px; color:var(--gray-500);">
                            <?= (!empty($row['tanggal_verifikasi']) && $row['tanggal_verifikasi'] != '0000-00-00 00:00:00') ? date('d M Y, H:i', strtotime($row['tanggal_verifikasi'])) : '-' ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="table-empty">📭 Belum ada pendaftaran.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>