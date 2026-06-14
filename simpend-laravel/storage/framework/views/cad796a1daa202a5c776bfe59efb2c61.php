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
        <div><strong>Status Pendakian:</strong> 
            <?php if($pendaftaran->status_pendakian == 'sedang_mendaki' && $pendaftaran->is_overdue): ?>
                <span class="badge badge-ditolak">OVERDUE</span>
            <?php elseif($pendaftaran->status_pendakian == 'sedang_mendaki'): ?>
                <span class="badge badge-pending">SEDANG MENDAKI</span>
            <?php elseif($pendaftaran->status_pendakian == 'selesai'): ?>
                <span class="badge badge-disetujui">SELESAI</span>
            <?php else: ?>
                <span class="badge" style="background: rgba(255, 255, 255, 0.08); color: #d1d5db; border: 1px solid rgba(255, 255, 255, 0.15);">BELUM MENDAKI</span>
            <?php endif; ?>
        </div>
        <div><strong>Waktu Check-In:</strong> <?php echo e($pendaftaran->tanggal_check_in ? date('d/m/Y H:i', strtotime($pendaftaran->tanggal_check_in)) : '-'); ?></div>
        <div><strong>Waktu Check-Out:</strong> <?php echo e($pendaftaran->tanggal_check_out ? date('d/m/Y H:i', strtotime($pendaftaran->tanggal_check_out)) : '-'); ?></div>
    </div>
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

<?php if($pendaftaran->status_verifikasi == 'disetujui' && $pendaftaran->status_pembayaran == 'paid'): ?>
<div class="card" style="margin-bottom: 16px;">
    <h3 style="margin-bottom: 16px;">Operasional Pendakian (Petugas Pos)</h3>
    <?php if($pendaftaran->status_pendakian == 'belum_mendaki'): ?>
        <p style="margin-bottom: 12px;">Pendaki terdaftar dan telah melunasi pembayaran. Silakan klik tombol di bawah saat pendaki memulai pendakian.</p>
        <form method="POST" action="<?php echo e(route('admin.pendaftaran.checkin', $pendaftaran->id)); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-primary">🚀 Mulai Pendakian (Check-In)</button>
        </form>
    <?php elseif($pendaftaran->status_pendakian == 'sedang_mendaki'): ?>
        <p style="margin-bottom: 12px; color: #b45309;">Pendaki sedang berada di atas gunung. Klik tombol di bawah jika pendaki telah kembali dengan selamat.</p>
        <form method="POST" action="<?php echo e(route('admin.pendaftaran.checkout', $pendaftaran->id)); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-success">✅ Selesai Pendakian (Check-Out)</button>
        </form>
    <?php elseif($pendaftaran->status_pendakian == 'selesai'): ?>
        <div class="alert alert-success" style="margin: 0;">
            ✓ Pendakian ini telah selesai. Pendaki Check-In pada <?php echo e(date('d/m/Y H:i', strtotime($pendaftaran->tanggal_check_in))); ?> dan Check-Out pada <?php echo e(date('d/m/Y H:i', strtotime($pendaftaran->tanggal_check_out))); ?>.
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php if($pendaftaran->status_verifikasi == 'pending'): ?>
<div class="card">
    <h3 style="margin-bottom: 16px;">Verifikasi Pendaftaran</h3>
    <form method="POST" action="<?php echo e(route('admin.pendaftaran.status', $pendaftaran->id)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="form-group">
            <label>Status</label>
            <select name="status" id="statusSelect" required>
                <option value="">Pilih Status</option>
                <option value="disetujui">Disetujui</option>
                <option value="ditolak">Ditolak</option>
            </select>
        </div>
        <div class="form-group" id="alasanGroup" style="display: none;">
            <label>Alasan Penolakan</label>
            <textarea name="alasan" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline">Kembali</a>
    </form>
</div>
<?php endif; ?>

<script>
document.getElementById('statusSelect').addEventListener('change', function() {
    document.getElementById('alasanGroup').style.display = this.value === 'ditolak' ? 'block' : 'none';
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SIMPEND\simpend-laravel\resources\views/admin/pendaftaran/show.blade.php ENDPATH**/ ?>