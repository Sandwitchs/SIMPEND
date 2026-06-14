<?php $__env->startSection('title', 'Data Gunung'); ?>

<?php $__env->startSection('content'); ?>
<h1 style="margin-bottom: 24px;">Manajemen Data Gunung</h1>

<a href="<?php echo e(route('admin.gunung.create')); ?>" class="btn btn-primary" style="margin-bottom: 16px;">+ Tambah Gunung</a>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Nama Gunung</th>
                <th>Jalur</th>
                <th>Kuota Maks</th>
                <th>Harga Camp</th>
                <th>Harga Tektok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $gunung; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><strong><?php echo e($g->nama_gunung); ?></strong></td>
                <td><?php echo e($g->jalur); ?></td>
                <td><?php echo e($g->kuota_maks); ?> orang</td>
                <td>Rp <?php echo e(number_format($g->harga_per_orang, 0, ',', '.')); ?></td>
                <td>Rp <?php echo e(number_format($g->harga_per_orang_tektok, 0, ',', '.')); ?></td>
                <td>
                    <a href="<?php echo e(route('admin.gunung.edit', $g->id)); ?>" class="btn btn-primary btn-sm">Edit</a>
                    <form method="POST" action="<?php echo e(route('admin.gunung.destroy', $g->id)); ?>" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SIMPEND\simpend-laravel\resources\views/admin/gunung/index.blade.php ENDPATH**/ ?>