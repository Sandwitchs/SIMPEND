<?php $__env->startSection('title', 'Detail Pendaftaran'); ?>

<?php $__env->startSection('content'); ?>
<h1 style="margin-bottom: 24px;">Detail Pendaftaran <?php echo e($pendaftaran->id_booking); ?></h1>

<div class="card" style="margin-bottom: 16px;">
    <h3 style="margin-bottom: 16px;">Informasi Pendaftaran</h3>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
        <div><strong>Nama Ketua:</strong> <?php echo e($pendaftaran->nama_ketua); ?></div>
        <div><strong>Tanggal Pendakian:</strong> <?php echo e(date('d/m/Y', strtotime($pendaftaran->tanggal_pendakian))); ?></div>
        <div><strong>Gunung & Jalur:</strong> <?php echo e($pendaftaran->gunung->nama_gunung); ?> (<?php echo e($pendaftaran->gunung->jalur); ?>)</div>
        <div><strong>Jumlah Anggota:</strong> <?php echo e($pendaftaran->jumlah_anggota); ?></div>
        <div><strong>Jenis Pendakian:</strong> <?php echo e(strtoupper($pendaftaran->jenis_pendakian)); ?></div>
        <div><strong>Total Harga:</strong> Rp <?php echo e(number_format($pendaftaran->total_harga, 0, ',', '.')); ?></div>
        <div><strong>Status Verifikasi:</strong> <span class="badge badge-<?php echo e($pendaftaran->status_verifikasi); ?>"><?php echo e(strtoupper($pendaftaran->status_verifikasi)); ?></span></div>
        <div><strong>Status Pembayaran:</strong> 
            <?php if($pendaftaran->status_pembayaran == 'paid'): ?>
                <span class="badge badge-disetujui">LUNAS</span>
            <?php elseif($pendaftaran->status_pembayaran == 'pending'): ?>
                <span class="badge badge-pending">MENUNGGU PEMBAYARAN</span>
            <?php elseif($pendaftaran->status_pembayaran == 'failed'): ?>
                <span class="badge badge-ditolak">GAGAL</span>
            <?php elseif($pendaftaran->status_pembayaran == 'expired'): ?>
                <span class="badge badge-ditolak">KADALUARSA</span>
            <?php endif; ?>
        </div>
        <div><strong>Waktu Daftar:</strong> <?php echo e($pendaftaran->created_at->format('d/m/Y H:i')); ?></div>
    </div>
    <?php if($pendaftaran->alasan_penolakan): ?>
    <div style="margin-top: 16px; background: #fee2e2; padding: 16px; border-radius: 8px;">
        <strong>Alasan Penolakan:</strong><br>
        <?php echo e($pendaftaran->alasan_penolakan); ?>

    </div>
    <?php endif; ?>
    <div style="margin-top: 16px;">
        <strong>Dokumen KTP:</strong> <a href="<?php echo e(route('document.secure', ['type' => 'ktp', 'id' => $pendaftaran->id])); ?>" target="_blank">Lihat Dokumen</a><br>
        <strong>Dokumen Sehat:</strong> <a href="<?php echo e(route('document.secure', ['type' => 'sehat', 'id' => $pendaftaran->id])); ?>" target="_blank">Lihat Dokumen</a>
    </div>
</div>

<div class="card" style="margin-bottom: 16px;">
    <h3 style="margin-bottom: 16px;">Daftar Anggota</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>No. KTP</th>
                <th>Usia</th>
                <th>No. HP</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $pendaftaran->anggota; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($a->nama); ?></td>
                <td><?php echo e($a->no_ktp); ?></td>
                <td><?php echo e($a->usia); ?></td>
                <td><?php echo e($a->no_hp); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<div style="display: flex; gap: 8px; flex-wrap: wrap;">
    <a href="<?php echo e(route('pendaki.dashboard')); ?>" class="btn btn-outline">← Kembali ke Dashboard</a>
    <?php if($pendaftaran->status_pembayaran == 'pending'): ?>
    <a href="<?php echo e(route('pendaki.pendaftaran.payment', $pendaftaran->id)); ?>" class="btn btn-success">💳 Bayar Sekarang</a>
    <form method="POST" action="<?php echo e(route('pendaki.pendaftaran.payment.check', $pendaftaran->id)); ?>" style="display: inline;">
        <?php echo csrf_field(); ?>
        <button type="submit" class="btn btn-primary">🔄 Cek Status Pembayaran</button>
    </form>
    <?php endif; ?>
    <?php if($pendaftaran->status_verifikasi == 'pending'): ?>
    <a href="<?php echo e(route('pendaki.pendaftaran.edit', $pendaftaran->id)); ?>" class="btn btn-primary">Edit Pendaftaran</a>
    <form method="POST" action="<?php echo e(route('pendaki.pendaftaran.cancel', $pendaftaran->id)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin membatalkan?')">Batalkan Pendaftaran</button>
    </form>
    <?php endif; ?>
    <?php if($pendaftaran->status_verifikasi == 'disetujui' && $pendaftaran->status_pembayaran == 'paid'): ?>
    <a href="<?php echo e(route('pendaki.pendaftaran.cetak', $pendaftaran->id)); ?>" class="btn btn-success" target="_blank">🖨️ Cetak Bukti Pendaftaran</a>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SIMPEND\simpend-laravel\resources\views/pendaki/pendaftaran/show.blade.php ENDPATH**/ ?>