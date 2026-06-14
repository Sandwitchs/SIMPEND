<?php $__env->startSection('title', 'Register'); ?>

<?php $__env->startSection('content'); ?>
<div style="min-height: 75vh; display: flex; align-items: center; justify-content: center; position: relative;">
    <!-- Circular glow backdrop specific to register card -->
    <div style="position: absolute; width: 320px; height: 320px; border-radius: 50%; background: radial-gradient(circle, rgba(16, 185, 129, 0.12) 0%, rgba(0,0,0,0) 70%); top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1; pointer-events: none; filter: blur(40px);"></div>

    <div class="card" style="width: 100%; max-width: 460px; position: relative; z-index: 2; border: 1px solid rgba(255, 255, 255, 0.1); box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6); margin: 40px auto;">
        <div style="text-align: center; margin-bottom: 28px;">
            <div style="font-size: 40px; margin-bottom: 8px;">⛰️</div>
            <h2 style="font-size: 22px; font-weight: 800; background: linear-gradient(135deg, #ffffff, #9ca3af); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 6px;">Daftar Akun Baru</h2>
            <p style="color: #9ca3af; font-size: 13px;">Registrasi akun pendaki untuk melakukan booking</p>
        </div>
        
        <form method="POST" action="<?php echo e(route('register.post')); ?>">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" value="<?php echo e(old('name')); ?>" placeholder="Nama Lengkap sesuai KTP" required autocomplete="name" autofocus>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="contoh@domain.com" required autocomplete="email">
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Minimal 6 karakter" required autocomplete="new-password">
            </div>
            
            <div class="form-group" style="margin-bottom: 24px;">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password" required autocomplete="new-password">
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 15px; font-weight: 700;">📝 Daftar Sekarang</button>
        </form>
        
        <div style="text-align: center; margin-top: 24px; border-top: 1px solid rgba(255, 255, 255, 0.06); padding-top: 20px; font-size: 14px; color: #9ca3af;">
            Sudah punya akun? <a href="<?php echo e(route('login')); ?>" style="color: #10b981; font-weight: 700; text-decoration: none;">Login</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SIMPEND\simpend-laravel\resources\views/auth/register.blade.php ENDPATH**/ ?>