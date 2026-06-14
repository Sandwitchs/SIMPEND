<?php $__env->startSection('title', 'Dashboard Pendaki'); ?>

<?php $__env->startSection('content'); ?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h1>Dashboard Pendaki</h1>
    <a href="<?php echo e(route('pendaki.pendaftaran.create')); ?>" class="btn btn-primary">+ Daftar Pendakian Baru</a>
</div>

<div class="card">
    <h2 style="margin-bottom: 16px;">Riwayat Pendaftaran</h2>
    <?php if($pendaftaran->count() > 0): ?>
    <table class="table">
        <thead>
            <tr>
                <th>ID Booking</th>
                <th>Gunung & Jalur</th>
                <th>Tanggal Pendakian</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $pendaftaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><strong><?php echo e($p->id_booking); ?></strong></td>
                <td><?php echo e($p->gunung->nama_gunung); ?> (<?php echo e($p->gunung->jalur); ?>)</td>
                <td><?php echo e(date('d/m/Y', strtotime($p->tanggal_pendakian))); ?></td>
                <td><span class="badge badge-<?php echo e($p->status_verifikasi); ?>"><?php echo e(strtoupper($p->status_verifikasi)); ?></span></td>
                <td>
                    <a href="<?php echo e(route('pendaki.pendaftaran.show', $p->id)); ?>" class="btn btn-primary btn-sm">Detail</a>
                    <?php if($p->status_verifikasi == 'pending'): ?>
                    <a href="<?php echo e(route('pendaki.pendaftaran.edit', $p->id)); ?>" class="btn btn-success btn-sm">Edit</a>
                    <form method="POST" action="<?php echo e(route('pendaki.pendaftaran.cancel', $p->id)); ?>" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin membatalkan?')">Batal</button>
                    </form>
                    <?php endif; ?>
                    <?php if($p->status_verifikasi == 'disetujui'): ?>
                    <a href="<?php echo e(route('pendaki.pendaftaran.cetak', $p->id)); ?>" class="btn btn-success btn-sm" target="_blank">Cetak</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php else: ?>
    <p>Belum ada pendaftaran. <a href="<?php echo e(route('pendaki.pendaftaran.create')); ?>">Daftar sekarang</a>!</p>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SIMPEND\simpend-laravel\resources\views/pendaki/dashboard.blade.php ENDPATH**/ ?>