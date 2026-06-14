<?php $__env->startSection('title', 'Notifikasi Saya'); ?>

<?php $__env->startSection('content'); ?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h1>Pemberitahuan / Notifikasi</h1>
    <?php if(Auth::user()->unreadNotifications->count() > 0): ?>
    <form method="POST" action="<?php echo e(route('pendaki.notifications.readAll')); ?>">
        <?php echo csrf_field(); ?>
        <button type="submit" class="btn btn-outline btn-sm">✓ Tandai Semua Terbaca</button>
    </form>
    <?php endif; ?>
</div>

<div class="card">
    <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div style="padding: 16px; border-bottom: 1px solid #e5e7eb; display: flex; align-items: start; gap: 12px; background: <?php echo e($notification->unread() ? '#eff6ff' : 'white'); ?>;">
            <div style="font-size: 20px;">
                <?php if($notification->data['type'] == 'disetujui' || $notification->data['type'] == 'check_out'): ?>
                    🟢
                <?php elseif($notification->data['type'] == 'ditolak'): ?>
                    🔴
                <?php else: ?>
                    🔵
                <?php endif; ?>
            </div>
            <div style="flex: 1;">
                <div style="font-weight: <?php echo e($notification->unread() ? '700' : 'normal'); ?>; color: #1f2937;">
                    <?php echo e($notification->data['message']); ?>

                </div>
                <div style="font-size: 12px; color: #6b7280; margin-top: 4px; display: flex; justify-content: space-between; align-items: center;">
                    <span><?php echo e($notification->created_at->diffForHumans()); ?> (<?php echo e($notification->created_at->format('d/m/Y H:i')); ?>)</span>
                    <a href="<?php echo e(route('pendaki.pendaftaran.show', $notification->data['pendaftaran_id'])); ?>" style="color: #2563eb; text-decoration: none; font-weight: 600;">Lihat Detail Booking →</a>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div style="text-align: center; color: #6b7280; padding: 32px;">
            Belum ada notifikasi untuk Anda.
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SIMPEND\simpend-laravel\resources\views/pendaki/notifications.blade.php ENDPATH**/ ?>