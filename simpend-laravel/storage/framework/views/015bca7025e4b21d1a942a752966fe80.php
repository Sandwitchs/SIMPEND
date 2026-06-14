<?php $__env->startSection('title', 'Daftar Orang Hilang'); ?>

<?php $__env->startSection('content'); ?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h1>Manajemen Orang Hilang</h1>
    <a href="<?php echo e(route('admin.orang-hilang.create')); ?>" class="btn btn-primary">+ Tambah Data</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Umur</th>
                <th>Lokasi Terakhir</th>
                <th>Tanggal Hilang</th>
                <th>Kontak Keluarga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $orangHilang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oh): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><strong><?php echo e($oh->nama); ?></strong></td>
                <td><?php echo e($oh->umur); ?> th</td>
                <td><?php echo e($oh->lokasi_terakhir); ?></td>
                <td><?php echo e($oh->tanggal_hilang->format('d/m/Y')); ?></td>
                <td><?php echo e($oh->kontak_keluarga ?? '-'); ?></td>
                <td>
                    <?php if($oh->status == 'belum ditemukan'): ?>
                        <span class="badge badge-pending">BELUM DITEMUKAN</span>
                    <?php else: ?>
                        <span class="badge badge-disetujui">DITEMUKAN</span>
                    <?php endif; ?>
                </td>
                <td style="display: flex; gap: 6px;">
                    <a href="<?php echo e(route('admin.orang-hilang.edit', $oh->id)); ?>" class="btn btn-primary btn-sm">Edit</a>
                    <form method="POST" action="<?php echo e(route('admin.orang-hilang.destroy', $oh->id)); ?>" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" style="text-align: center; color: #6b7280; padding: 32px;">
                    👤 Belum ada data orang hilang.
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SIMPEND\simpend-laravel\resources\views/admin/orang_hilang/index.blade.php ENDPATH**/ ?>