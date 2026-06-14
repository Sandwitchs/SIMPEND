<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
<div style="min-height: 70vh; display: flex; align-items: center; justify-content: center; position: relative;">
    <!-- Circular glow backdrop specific to login card -->
    <div style="position: absolute; width: 300px; height: 300px; border-radius: 50%; background: radial-gradient(circle, rgba(16, 185, 129, 0.12) 0%, rgba(0,0,0,0) 70%); top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1; pointer-events: none; filter: blur(40px);"></div>

    <div class="card" style="width: 100%; max-width: 440px; position: relative; z-index: 2; border: 1px solid rgba(255, 255, 255, 0.1); box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);">
        <div style="text-align: center; margin-bottom: 32px;">
            <div style="font-size: 48px; margin-bottom: 12px;">⛰️</div>
            <h2 style="font-size: 24px; font-weight: 800; background: linear-gradient(135deg, #ffffff, #9ca3af); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 8px;">Login SIMPEND</h2>
            <p style="color: #9ca3af; font-size: 14px;">Masukkan akun Anda untuk akses pendaftaran</p>
        </div>
        
        <form method="POST" action="<?php echo e(route('login.post')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="contoh@domain.com" required autocomplete="email" autofocus>
            </div>
            <div class="form-group" style="margin-bottom: 24px;">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required autocomplete="current-password">
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 15px; font-weight: 700; margin-top: 8px;">🚪 Masuk Sekarang</button>
        </form>
        
        <div style="text-align: center; margin-top: 24px; border-top: 1px solid rgba(255, 255, 255, 0.06); padding-top: 20px; font-size: 14px; color: #9ca3af;">
            Belum punya akun? <a href="<?php echo e(route('register')); ?>" style="color: #10b981; font-weight: 700; text-decoration: none;">Daftar Sekarang</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SIMPEND\simpend-laravel\resources\views/auth/login.blade.php ENDPATH**/ ?>