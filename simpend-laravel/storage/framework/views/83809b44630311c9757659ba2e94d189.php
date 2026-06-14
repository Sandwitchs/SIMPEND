<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pendaftaran - <?php echo e($pendaftaran->id_booking); ?></title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Segoe UI', sans-serif; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #1f2937; padding-bottom: 20px; }
        .header h1 { font-size: 28px; color: #1f2937; }
        .header p { color: #6b7280; margin-top: 8px; }
        .card { border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 24px; }
        .section-title { font-size: 18px; font-weight: 700; color: #1f2937; margin-bottom: 16px; border-bottom: 1px solid #e5e7eb; padding-bottom: 8px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
        .grid-item { margin-bottom: 8px; }
        .grid-item strong { color: #374151; }
        .table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .table th, .table td { border: 1px solid #e5e7eb; padding: 10px; text-align: left; }
        .table th { background: #f9fafb; font-weight: 700; }
        .footer { text-align: center; margin-top: 40px; color: #6b7280; font-size: 12px; }
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 9999px; font-size: 12px; font-weight: 700; background: #d1fae5; color: #065f46; }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⛰️ SIMPEND</h1>
            <p>Sistem Informasi Manajemen Pendaftaran Pendakian</p>
        </div>

        <div class="card">
            <div class="section-title">BUKTI PENDAFTARAN PENDAKIAN</div>
            <div class="grid">
                <div class="grid-item"><strong>ID Booking:</strong> <?php echo e($pendaftaran->id_booking); ?></div>
                <div class="grid-item"><strong>Status:</strong> <span class="status-badge">DISETUJUI</span></div>
                <div class="grid-item"><strong>Nama Ketua:</strong> <?php echo e($pendaftaran->nama_ketua); ?></div>
                <div class="grid-item"><strong>Tanggal Pendaftaran:</strong> <?php echo e($pendaftaran->created_at->format('d/m/Y H:i')); ?></div>
                <div class="grid-item"><strong>Gunung:</strong> <?php echo e($pendaftaran->gunung->nama_gunung); ?></div>
                <div class="grid-item"><strong>Jalur:</strong> <?php echo e($pendaftaran->gunung->jalur); ?></div>
                <div class="grid-item"><strong>Tanggal Pendakian:</strong> <?php echo e(date('d/m/Y', strtotime($pendaftaran->tanggal_pendakian))); ?></div>
                <div class="grid-item"><strong>Jumlah Anggota:</strong> <?php echo e($pendaftaran->jumlah_anggota); ?> orang</div>
            </div>
        </div>

        <div class="card">
            <div class="section-title">DAFTAR ANGGOTA</div>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>No. KTP</th>
                        <th>Usia</th>
                        <th>No. HP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $pendaftaran->anggota; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($i+1); ?></td>
                        <td><?php echo e($a->nama); ?></td>
                        <td><?php echo e($a->no_ktp); ?></td>
                        <td><?php echo e($a->usia); ?></td>
                        <td><?php echo e($a->no_hp); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div class="card" style="text-align: center;">
            <p style="margin-bottom: 16px;">Bukti pendaftaran ini sah dan dapat digunakan sebagai bukti pendaftaran yang telah diverifikasi.</p>
            <p style="color: #6b7280; font-size: 12px;">Harap bawa bukti ini saat melakukan pendakian.</p>
        </div>

        <div class="footer">
            <p class="no-print" style="margin-bottom: 16px;">
                <button onclick="window.print()" class="btn btn-primary no-print" style="padding: 10px 24px; background: #2563eb; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">🖨️ Cetak Bukti</button>
                <a href="<?php echo e(route('pendaki.pendaftaran.show', $pendaftaran->id)); ?>" class="no-print" style="margin-left: 12px; color: #2563eb; text-decoration: none;">← Kembali</a>
            </p>
            © 2026 SIMPEND - Semua Hak Dilindungi
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\SIMPEND\simpend-laravel\resources\views/pendaki/pendaftaran/cetak.blade.php ENDPATH**/ ?>