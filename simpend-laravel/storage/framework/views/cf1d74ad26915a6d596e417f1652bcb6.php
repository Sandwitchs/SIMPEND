<?php $__env->startSection('title', 'Tambah Blacklist'); ?>

<?php $__env->startSection('content'); ?>
<h1 style="margin-bottom: 24px;">Tambah Pendaki ke Blacklist</h1>

<div class="card" style="max-width: 520px;">
    <form method="POST" action="<?php echo e(route('admin.blacklist.store')); ?>">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" value="<?php echo e(old('nama')); ?>" required>
        </div>
        <div class="form-group">
            <label>No. KTP</label>
            <input type="text" name="no_ktp" value="<?php echo e(old('no_ktp')); ?>" placeholder="Contoh: 3201xxxxxxxxxxxx" required>
        </div>
        <div class="form-group">
            <label>Alasan Blacklist</label>
            <textarea name="alasan" rows="4" required><?php echo e(old('alasan')); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?php echo e(route('admin.blacklist.index')); ?>" class="btn btn-outline">Kembali</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SIMPEND\simpend-laravel\resources\views/admin/blacklist/create.blade.php ENDPATH**/ ?>