<?php $__env->startSection('title', 'Daftar Blacklist'); ?>

<?php $__env->startSection('content'); ?>
<h1 style="margin-bottom: 24px;">Manajemen Daftar Hitam (Blacklist)</h1>

<a href="<?php echo e(route('admin.blacklist.create')); ?>" class="btn btn-primary" style="margin-bottom: 16px;">+ Tambah Blacklist</a>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>No. KTP</th>
                <th>Alasan</th>
                <th>Tanggal Blacklist</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $blacklist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><strong><?php echo e($b->nama); ?></strong></td>
                <td><?php echo e($b->no_ktp); ?></td>
                <td><?php echo e($b->alasan); ?></td>
                <td><?php echo e($b->created_at->format('d/m/Y')); ?></td>
                <td>
                    <a href="<?php echo e(route('admin.blacklist.edit', $b->id)); ?>" class="btn btn-primary btn-sm">Edit</a>
                    <form method="POST" action="<?php echo e(route('admin.blacklist.destroy', $b->id)); ?>" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus dari blacklist?')">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="5" style="text-align: center; color: #6b7280; padding: 24px;">Tidak ada data pendaki yang di-blacklist.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SIMPEND\simpend-laravel\resources\views/admin/blacklist/index.blade.php ENDPATH**/ ?>