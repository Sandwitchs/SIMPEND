<?php $__env->startSection('title', 'Tambah Data Orang Hilang'); ?>

<?php $__env->startSection('content'); ?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h1>Tambah Data Orang Hilang</h1>
    <a href="<?php echo e(route('admin.orang-hilang.index')); ?>" class="btn btn-outline">← Kembali</a>
</div>

<div class="card" style="max-width: 700px;">
    <form method="POST" action="<?php echo e(route('admin.orang-hilang.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <div class="form-group">
            <label>Nama Lengkap <span style="color:#dc2626">*</span></label>
            <input type="text" name="nama" value="<?php echo e(old('nama')); ?>" placeholder="Contoh: Budi Santoso" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label>Umur <span style="color:#dc2626">*</span></label>
                <input type="number" name="umur" value="<?php echo e(old('umur')); ?>" min="1" max="120" placeholder="Contoh: 25" required>
            </div>
            <div class="form-group">
                <label>Kontak Keluarga / Pelapor</label>
                <input type="text" name="kontak_keluarga" value="<?php echo e(old('kontak_keluarga')); ?>" placeholder="Contoh: 0812-3456-7890">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label>Lokasi Terakhir Diketahui <span style="color:#dc2626">*</span></label>
                <input type="text" name="lokasi_terakhir" value="<?php echo e(old('lokasi_terakhir')); ?>" placeholder="Contoh: Jalur Ranu Pani, Semeru" required>
            </div>
            <div class="form-group">
                <label>Tanggal Mulai Hilang <span style="color:#dc2626">*</span></label>
                <input type="date" name="tanggal_hilang" value="<?php echo e(old('tanggal_hilang')); ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label>Deskripsi Ciri-ciri / Keterangan Terakhir</label>
            <textarea name="deskripsi_terakhir" rows="4" placeholder="Contoh: Mengenakan jaket merah, bawa carrier 60L, terakhir terlihat di pos 3..."><?php echo e(old('deskripsi_terakhir')); ?></textarea>
        </div>

        <div class="form-group">
            <label>Foto (JPG/PNG, maks 2MB)</label>
            <input type="file" name="foto" accept=".jpg,.jpeg,.png">
        </div>

        <div class="form-group">
            <label>Status Pencarian <span style="color:#dc2626">*</span></label>
            <select name="status" required>
                <option value="belum ditemukan" <?php echo e(old('status') == 'belum ditemukan' ? 'selected' : ''); ?>>Belum Ditemukan</option>
                <option value="ditemukan" <?php echo e(old('status') == 'ditemukan' ? 'selected' : ''); ?>>Ditemukan</option>
            </select>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 8px;">
            <button type="submit" class="btn btn-primary">💾 Simpan Data</button>
            <a href="<?php echo e(route('admin.orang-hilang.index')); ?>" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SIMPEND\simpend-laravel\resources\views/admin/orang_hilang/create.blade.php ENDPATH**/ ?>