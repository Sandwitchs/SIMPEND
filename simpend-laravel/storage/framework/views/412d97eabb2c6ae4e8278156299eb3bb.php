<?php $__env->startSection('title', 'Edit Gunung'); ?>

<?php $__env->startSection('content'); ?>
<h1 style="margin-bottom: 24px;">Edit Data Gunung</h1>

<div class="card" style="max-width: 520px;">
    <form method="POST" action="<?php echo e(route('admin.gunung.update', $gunung->id)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="form-group">
            <label>Nama Gunung</label>
            <input type="text" name="nama_gunung" value="<?php echo e($gunung->nama_gunung); ?>" required>
        </div>
        <div class="form-group">
            <label>Jalur</label>
            <input type="text" name="jalur" value="<?php echo e($gunung->jalur); ?>" required>
        </div>
        <div class="form-group">
            <label>Kuota Maks (orang)</label>
            <input type="number" name="kuota_maks" value="<?php echo e($gunung->kuota_maks); ?>" min="1" required>
        </div>
        <div class="form-group">
            <label>Harga Camp Per Orang (Rp)</label>
            <input type="number" name="harga_per_orang" value="<?php echo e($gunung->harga_per_orang); ?>" min="0" required>
        </div>
        <div class="form-group">
            <label>Harga Tektok Per Orang (Rp)</label>
            <input type="number" name="harga_per_orang_tektok" value="<?php echo e($gunung->harga_per_orang_tektok); ?>" min="0" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?php echo e(route('admin.gunung.index')); ?>" class="btn btn-outline">Kembali</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SIMPEND\simpend-laravel\resources\views/admin/gunung/edit.blade.php ENDPATH**/ ?>