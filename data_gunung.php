<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header("Location: login.php"); exit; }

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Koneksi database untuk Railway (Dengan Debug)
$host = getenv('MYSQLHOST') ?: $_ENV['MYSQLHOST'] ?? '';
$port = getenv('MYSQLPORT') ?: $_ENV['MYSQLPORT'] ?? '';
$user = getenv('MYSQLUSER') ?: $_ENV['MYSQLUSER'] ?? '';
$pass = getenv('MYSQLPASSWORD') ?: $_ENV['MYSQLPASSWORD'] ?? '';
$dbname = getenv('MYSQLDATABASE') ?: $_ENV['MYSQLDATABASE'] ?? '';

$conn = new mysqli($host, $user, $pass, $dbname, $port);
if ($conn->connect_error) {
    die("<b style='color:red'>Koneksi Database Gagal:</b> " . $conn->connect_error);
}

// PROSES TAMBAH DATA
$pesan = "";
if (isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_gunung']);
    $jalur = mysqli_real_escape_string($conn, $_POST['jalur']);
    $kuota = (int)$_POST['kuota'];

    $query = "INSERT INTO gunung (nama_gunung, jalur, kuota_maks) VALUES ('$nama', '$jalur', '$kuota')";
    
    if ($conn->query($query)) {
        header("Location: data_gunung.php?success=1");
        exit;
    } else {
        $pesan = "error";
    }
}

// PROSES HAPUS DATA
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $conn->query("DELETE FROM gunung WHERE id=$id");
    header("Location: data_gunung.php?deleted=1");
    exit;
}

$result = $conn->query("SELECT * FROM gunung ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Gunung | SIM-PEND</title>
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
            <a href="admin.php">
                <span class="nav-icon">📊</span> Dashboard
            </a>
            <a href="data_gunung.php" class="active">
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
            <h1>Manajemen Data Gunung</h1>
            <p>Tambah dan kelola data jalur gunung beserta kuotanya</p>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="info-box success show" style="margin-bottom:20px;">✅ Data gunung berhasil ditambahkan!</div>
        <?php endif; ?>
        <?php if (isset($_GET['deleted'])): ?>
            <div class="info-box success show" style="margin-bottom:20px;">🗑️ Data gunung berhasil dihapus.</div>
        <?php endif; ?>
        <?php if ($pesan == 'error'): ?>
            <div class="info-box error show" style="margin-bottom:20px;">❌ Gagal menambah data: <?= $conn->error ?></div>
        <?php endif; ?>

        <!-- FORM TAMBAH -->
        <div class="card fade-slide-up" style="margin-bottom:24px;">
            <h3 style="font-size:16px; font-weight:700; color:var(--gray-800); margin-bottom:16px;">➕ Tambah Gunung Baru</h3>
            <form method="POST" class="inline-form">
                <div class="form-group">
                    <label>Nama Gunung</label>
                    <input type="text" name="nama_gunung" placeholder="Contoh: Gunung Semeru" required>
                </div>
                <div class="form-group">
                    <label>Jalur</label>
                    <input type="text" name="jalur" placeholder="Contoh: Ranu Pani" required>
                </div>
                <div class="form-group" style="max-width:140px;">
                    <label>Kuota</label>
                    <input type="number" name="kuota" placeholder="50" min="1" required>
                </div>
                <button type="submit" name="tambah" class="btn btn-primary">
                    + Tambah
                </button>
            </form>
        </div>

        <!-- TABLE DATA -->
        <div class="table-wrap fade-slide-up">
            <table>
                <thead>
                    <tr>
                        <th>Nama Gunung</th>
                        <th>Jalur</th>
                        <th>Kuota Maks</th>
                        <th style="width:100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><strong style="color:var(--primary-700);"><?= htmlspecialchars($row['nama_gunung']) ?></strong></td>
                            <td><?= htmlspecialchars($row['jalur']) ?></td>
                            <td>
                                <span style="background:var(--accent-blue-light); color:var(--accent-blue); padding:3px 10px; border-radius:var(--radius-full); font-size:13px; font-weight:600;">
                                    <?= $row['kuota_maks'] ?> orang
                                </span>
                            </td>
                            <td>
                                <a href="data_gunung.php?hapus=<?= $row['id'] ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Yakin ingin menghapus data gunung ini?')">
                                    🗑️ Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="table-empty">🏔️ Belum ada data gunung. Tambahkan data pertama!</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

</body>
</html>