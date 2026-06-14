<?php
session_start();
// Cek login
if (!isset($_SESSION['admin_logged_in'])) { 
    header("Location: login.php"); 
    exit; 
}

$conn = new mysqli("localhost", "root", "", "simpend_db");

// Ambil data pendaftaran terbaru
$pendaftaran = $conn->query("SELECT * FROM pendaftaran ORDER BY id DESC");
$total = $pendaftaran->num_rows;

// Hitung statistik
$pending_count = $conn->query("SELECT id FROM pendaftaran WHERE status_verifikasi='pending'")->num_rows;
$disetujui_count = $conn->query("SELECT id FROM pendaftaran WHERE status_verifikasi='disetujui'")->num_rows;
$ditolak_count = $conn->query("SELECT id FROM pendaftaran WHERE status_verifikasi='ditolak'")->num_rows;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | SIM-PEND</title>
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
            <a href="admin.php" class="active">
                <span class="nav-icon">📊</span> Dashboard
            </a>
            <a href="data_gunung.php">
                <span class="nav-icon">🏔️</span> Data Gunung
            </a>
            <a href="pengaturan.php">
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
            <h1>Dashboard</h1>
            <p>Kelola dan pantau semua pendaftaran pendakian</p>
        </div>

        <!-- STAT CARDS -->
        <div class="stat-grid fade-slide-up">
            <div class="stat-card">
                <div class="stat-icon green">📋</div>
                <div class="stat-info">
                    <h4>Total Pendaftaran</h4>
                    <div class="stat-value"><?= $total ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon amber">⏳</div>
                <div class="stat-info">
                    <h4>Menunggu Verifikasi</h4>
                    <div class="stat-value"><?= $pending_count ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue">✅</div>
                <div class="stat-info">
                    <h4>Disetujui</h4>
                    <div class="stat-value"><?= $disetujui_count ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon red">❌</div>
                <div class="stat-info">
                    <h4>Ditolak</h4>
                    <div class="stat-value"><?= $ditolak_count ?></div>
                </div>
            </div>
        </div>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <div class="info-box success show" id="toastSuccess" style="margin-bottom:20px;">
                ✅ Status pendaftaran berhasil diperbarui!
            </div>
        <?php endif; ?>

        <!-- DATA TABLE -->
        <div class="table-wrap fade-slide-up">
            <table>
                <thead>
                    <tr>
                        <th>ID Booking</th>
                        <th>Nama Ketua</th>
                        <th>Jalur</th>
                        <th>Waktu Daftar</th>
                        <th>Status</th>
                        <th>Waktu Verif</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($total > 0): ?>
                        <?php while($row = $pendaftaran->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <strong style="color: var(--primary-700); font-family: monospace;">
                                    <?= $row['id_booking'] ?>
                                </strong>
                            </td>
                            <td><?= htmlspecialchars($row['nama_ketua']) ?></td>
                            <td><span style="font-size:13px; color:var(--gray-500);"><?= htmlspecialchars($row['jalur_pendakian']) ?></span></td>
                            <td>
                                <span style="font-size:13px; color:var(--gray-500);">
                                    <?= !empty($row['created_at']) ? date('d/m/y H:i', strtotime($row['created_at'])) : '-' ?>
                                </span>
                            </td>
                            <td>
                                <?php $st = strtoupper($row['status_verifikasi']); ?>
                                <span class="badge badge-<?= strtolower($row['status_verifikasi']) ?>">
                                    <?= $st ?>
                                </span>
                            </td>
                            <td>
                                <span style="color: var(--gray-400); font-size: 13px;">
                                    <?= (!empty($row['tanggal_verifikasi']) && $row['tanggal_verifikasi'] != '0000-00-00 00:00:00') 
                                        ? date('d/m/y H:i', strtotime($row['tanggal_verifikasi'])) 
                                        : 'Belum diproses' ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($st == 'PENDING'): ?>
                                    <button onclick="setujuiPendaftaran(<?= $row['id'] ?>, '<?= htmlspecialchars($row['nama_ketua']) ?>')" 
                                            class="btn btn-success btn-sm">✓ Setuju</button>
                                    
                                    <button onclick="tolakDenganAlasan(<?= $row['id'] ?>, '<?= htmlspecialchars($row['nama_ketua']) ?>')" 
                                            class="btn btn-danger btn-sm" style="margin-left:4px;">✕ Tolak</button>
                                <?php else: ?>
                                    <span style="color: var(--gray-300); font-style: italic; font-size: 12px;">Selesai</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="table-empty">📭 Belum ada data pendaftaran masuk.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<!-- MODAL SETUJU -->
<div class="modal-overlay" id="modalSetuju" style="display:none;">
    <div class="modal-box">
        <h3>✅ Setujui Pendaftaran</h3>
        <p style="color:var(--gray-500); font-size:14px; margin-bottom:16px;">
            Apakah Anda yakin ingin menyetujui pendaftaran atas nama <strong id="namaSetuju"></strong>?
        </p>
        <div class="modal-actions">
            <button class="btn btn-outline" onclick="tutupModalSetuju()">Batal</button>
            <form id="formSetuju" method="POST" action="update_status.php" style="display:inline;">
                <input type="hidden" name="id" id="idSetuju" value="">
                <input type="hidden" name="status" value="disetujui">
                <button type="submit" class="btn btn-success">Ya, Setujui</button>
            </form>
        </div>
    </div>
</div>

<!-- MODAL TOLAK -->
<div class="modal-overlay" id="modalTolak" style="display:none;">
    <div class="modal-box">
        <h3>❌ Tolak Pendaftaran</h3>
        <p style="color:var(--gray-500); font-size:14px; margin-bottom:16px;">
            Masukkan alasan penolakan untuk <strong id="namaTolak"></strong>:
        </p>
        <div class="form-group" style="margin-bottom:0;">
            <textarea id="alasanInput" rows="3" placeholder="Tulis alasan penolakan..." 
                style="width:100%; padding:11px 14px; border:1.5px solid var(--gray-200); border-radius:var(--radius-md); font-family:inherit; font-size:14px; resize:vertical; outline:none;"></textarea>
        </div>
        <div class="modal-actions">
            <button class="btn btn-outline" onclick="tutupModalTolak()">Batal</button>
            <form id="formTolak" method="POST" action="update_status.php" style="display:inline;">
                <input type="hidden" name="id" id="idTolak" value="">
                <input type="hidden" name="status" value="ditolak">
                <input type="hidden" name="alasan" id="alasanHidden" value="">
                <button type="submit" class="btn btn-danger" onclick="return validasiTolak()">Tolak Pendaftaran</button>
            </form>
        </div>
    </div>
</div>

<script>
    // ===== SETUJU =====
    function setujuiPendaftaran(id, nama) {
        document.getElementById('idSetuju').value = id;
        document.getElementById('namaSetuju').textContent = nama;
        document.getElementById('modalSetuju').style.display = 'flex';
    }

    function tutupModalSetuju() {
        document.getElementById('modalSetuju').style.display = 'none';
    }

    // ===== TOLAK =====
    function tolakDenganAlasan(id, nama) {
        document.getElementById('idTolak').value = id;
        document.getElementById('namaTolak').textContent = nama;
        document.getElementById('alasanInput').value = '';
        document.getElementById('modalTolak').style.display = 'flex';
    }

    function tutupModalTolak() {
        document.getElementById('modalTolak').style.display = 'none';
    }

    function validasiTolak() {
        const alasan = document.getElementById('alasanInput').value.trim();
        if (alasan === '') {
            alert('Alasan penolakan tidak boleh kosong!');
            return false;
        }
        document.getElementById('alasanHidden').value = alasan;
        return true;
    }

    // Klik overlay untuk tutup modal
    document.getElementById('modalSetuju').addEventListener('click', function(e) {
        if (e.target === this) tutupModalSetuju();
    });
    document.getElementById('modalTolak').addEventListener('click', function(e) {
        if (e.target === this) tutupModalTolak();
    });

    // Auto-hide toast
    const toast = document.getElementById('toastSuccess');
    if (toast) {
        setTimeout(() => { toast.style.opacity = '0'; toast.style.transition = 'opacity 0.5s'; }, 3000);
        setTimeout(() => { toast.style.display = 'none'; }, 3500);
    }
</script>

</body>
</html>