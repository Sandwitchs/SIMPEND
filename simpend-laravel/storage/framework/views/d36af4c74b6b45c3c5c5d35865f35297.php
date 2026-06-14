<?php $__env->startSection('title', 'Daftar Orang Hilang'); ?>

<?php $__env->startSection('content'); ?>

<div style="margin-bottom: 24px;">
    <h1 style="font-size: 28px; font-weight: 800; color: #1f2937; margin-bottom: 8px;">
        🔍 Daftar Orang Hilang di Area Pendakian
    </h1>
    <p style="color: #6b7280; font-size: 15px;">
        Informasi ini dipublikasikan untuk membantu proses pencarian. Jika Anda memiliki informasi, segera hubungi kontak keluarga atau pihak berwenang setempat.
    </p>
</div>

<?php if($orangHilang->isEmpty()): ?>
    <div class="card" style="text-align: center; padding: 64px 24px; color: #6b7280;">
        <div style="font-size: 64px; margin-bottom: 16px;">✅</div>
        <h2 style="font-size: 20px; font-weight: 700; color: #1f2937; margin-bottom: 8px;">Tidak Ada Laporan Orang Hilang</h2>
        <p>Saat ini tidak ada laporan orang hilang yang aktif di area pendakian.</p>
    </div>
<?php else: ?>
    
    <?php
        $belumDitemukan = $orangHilang->where('status', 'belum ditemukan')->count();
        $ditemukan = $orangHilang->where('status', 'ditemukan')->count();
    ?>
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 28px;">
        <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid #2563eb;">
            <div style="font-size: 13px; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total Laporan</div>
            <div style="font-size: 32px; font-weight: 800; color: #1f2937; margin-top: 4px;"><?php echo e($orangHilang->count()); ?></div>
        </div>
        <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid #dc2626;">
            <div style="font-size: 13px; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Belum Ditemukan</div>
            <div style="font-size: 32px; font-weight: 800; color: #dc2626; margin-top: 4px;"><?php echo e($belumDitemukan); ?></div>
        </div>
        <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid #059669;">
            <div style="font-size: 13px; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Sudah Ditemukan</div>
            <div style="font-size: 32px; font-weight: 800; color: #059669; margin-top: 4px;"><?php echo e($ditemukan); ?></div>
        </div>
    </div>

    
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px;">
        <?php $__currentLoopData = $orangHilang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oh): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden;
                    border: 2px solid <?php echo e($oh->status == 'belum ditemukan' ? '#fecaca' : '#bbf7d0'); ?>;">

            
            <?php if($oh->foto): ?>
                <img src="<?php echo e(Storage::url($oh->foto)); ?>" alt="Foto <?php echo e($oh->nama); ?>"
                     style="width: 100%; height: 220px; object-fit: cover;">
            <?php else: ?>
                <div style="width: 100%; height: 220px; background: #f3f4f6; display: flex; align-items: center; justify-content: center; font-size: 80px; color: #d1d5db;">
                    👤
                </div>
            <?php endif; ?>

            
            <div style="padding: 4px 16px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;
                        background: <?php echo e($oh->status == 'belum ditemukan' ? '#fee2e2' : '#d1fae5'); ?>;
                        color: <?php echo e($oh->status == 'belum ditemukan' ? '#991b1b' : '#065f46'); ?>;">
                <?php echo e($oh->status == 'belum ditemukan' ? '🔴 BELUM DITEMUKAN' : '✅ SUDAH DITEMUKAN'); ?>

            </div>

            
            <div style="padding: 20px;">
                <h2 style="font-size: 20px; font-weight: 800; color: #1f2937; margin-bottom: 12px;">
                    <?php echo e($oh->nama); ?>

                </h2>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; font-size: 14px; margin-bottom: 14px;">
                    <div>
                        <span style="color: #9ca3af; font-size: 11px; font-weight: 600; text-transform: uppercase;">Umur</span>
                        <div style="color: #1f2937; font-weight: 600;"><?php echo e($oh->umur); ?> tahun</div>
                    </div>
                    <div>
                        <span style="color: #9ca3af; font-size: 11px; font-weight: 600; text-transform: uppercase;">Tanggal Hilang</span>
                        <div style="color: #1f2937; font-weight: 600;"><?php echo e($oh->tanggal_hilang->format('d M Y')); ?></div>
                    </div>
                </div>
                <div style="margin-bottom: 12px;">
                    <span style="color: #9ca3af; font-size: 11px; font-weight: 600; text-transform: uppercase;">Lokasi Terakhir</span>
                    <div style="color: #1f2937; font-weight: 600; font-size: 14px;">📍 <?php echo e($oh->lokasi_terakhir); ?></div>
                </div>
                <?php if($oh->deskripsi_terakhir): ?>
                <div style="background: #f9fafb; border-radius: 8px; padding: 12px; font-size: 13px; color: #4b5563; margin-bottom: 14px; line-height: 1.5;">
                    <strong style="font-size: 11px; text-transform: uppercase; color: #9ca3af; display: block; margin-bottom: 4px;">Keterangan:</strong>
                    <?php echo e($oh->deskripsi_terakhir); ?>

                </div>
                <?php endif; ?>
                <?php if($oh->kontak_keluarga): ?>
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 10px 14px; font-size: 13px;">
                    <span style="font-weight: 700; color: #1e40af;">📞 Kontak Keluarga: </span>
                    <span style="color: #1e40af;"><?php echo e($oh->kontak_keluarga); ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>

<div style="margin-top: 32px; background: #fef3c7; border: 1px solid #fde68a; border-radius: 12px; padding: 20px;">
    <strong style="color: #92400e;">⚠️ Penting:</strong>
    <span style="color: #92400e; font-size: 14px;">
        Jika Anda melihat atau menemukan orang yang tercantum di atas, segera hubungi kontak keluarga yang tertera
        atau hubungi Basarnas di <strong>115</strong> / Posko SAR terdekat.
    </span>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SIMPEND\simpend-laravel\resources\views/orang_hilang/index.blade.php ENDPATH**/ ?>