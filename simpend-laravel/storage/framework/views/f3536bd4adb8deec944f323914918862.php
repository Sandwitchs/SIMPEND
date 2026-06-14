<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title'); ?> | SIMPEND Admin</title>
    <!-- Google Fonts Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: #080d16; 
            color: #e5e7eb; 
            min-height: 100vh; 
            display: flex; 
            position: relative;
            overflow-x: hidden;
        }
        
        .sidebar { 
            width: 260px; 
            background: rgba(11, 17, 30, 0.85); 
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-right: 1px solid rgba(255, 255, 255, 0.06); 
            min-height: 100vh; 
            padding: 32px 20px;
            display: flex;
            flex-direction: column;
            z-index: 10;
        }
        
        .sidebar .brand { 
            font-size: 24px; 
            font-weight: 800; 
            background: linear-gradient(135deg, #10b981, #84cc16);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 40px; 
            text-align: center;
        }
        
        .sidebar a { 
            display: block; 
            color: #9ca3af; 
            text-decoration: none; 
            padding: 12px 16px; 
            border-radius: 12px; 
            margin-bottom: 8px; 
            font-weight: 600;
            font-size: 14px;
            border: 1px solid transparent;
            transition: all 0.2s ease;
        }
        
        .sidebar a:hover, .sidebar a.active { 
            background: rgba(16, 185, 129, 0.08); 
            color: #10b981; 
            border-color: rgba(16, 185, 129, 0.25);
            text-shadow: 0 0 10px rgba(16, 185, 129, 0.15);
        }
        
        .main { 
            flex: 1; 
            padding: 40px; 
            overflow-y: auto;
            position: relative;
            z-index: 5;
        }
        
        .card { 
            background: rgba(17, 24, 39, 0.7); 
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px; 
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5); 
            padding: 32px; 
            margin-bottom: 24px; 
            color: #e5e7eb;
        }
        
        .btn { 
            padding: 10px 22px; 
            border-radius: 10px; 
            border: none; 
            cursor: pointer; 
            font-weight: 700; 
            text-decoration: none; 
            display: inline-block; 
            font-size: 14px;
            transition: all 0.25s ease;
        }
        
        .btn-primary { 
            background: linear-gradient(135deg, #059669, #10b981); 
            color: white; 
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.35);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.5);
            background: linear-gradient(135deg, #047857, #059669);
        }
        
        .btn-success { 
            background: linear-gradient(135deg, #0891b2, #14b8a6); 
            color: white; 
            box-shadow: 0 4px 15px rgba(20, 184, 166, 0.35);
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(20, 184, 166, 0.5);
        }
        
        .btn-danger { 
            background: linear-gradient(135deg, #e11d48, #f43f5e); 
            color: white; 
            box-shadow: 0 4px 15px rgba(244, 63, 94, 0.35);
        }
        
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(244, 63, 94, 0.5);
        }
        
        .btn-sm { 
            padding: 6px 12px; 
            font-size: 12px; 
            border-radius: 8px;
        }
        
        .form-group { 
            margin-bottom: 20px; 
        }
        
        .form-group label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: 700; 
            font-size: 13px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .form-group input, .form-group select, .form-group textarea { 
            width: 100%; 
            padding: 12px; 
            background: rgba(17, 24, 39, 0.5); 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            border-radius: 10px; 
            font-size: 14px; 
            color: white;
            transition: all 0.2s;
            font-family: inherit;
        }
        
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none;
            border-color: #10b981;
            background: rgba(17, 24, 39, 0.8);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
        }
        
        .table { 
            width: 100%; 
            border-collapse: separate; 
            border-spacing: 0;
            margin-top: 16px;
        }
        
        .table th { 
            background: rgba(31, 41, 55, 0.4);
            padding: 16px; 
            text-align: left; 
            font-weight: 700;
            font-size: 13px;
            color: #9ca3af;
            text-transform: uppercase;
            border-bottom: 2px solid rgba(255, 255, 255, 0.08);
        }
        
        .table td { 
            padding: 16px; 
            border-bottom: 1px solid rgba(255, 255, 255, 0.06); 
            color: #e5e7eb;
            font-size: 14px;
        }
        
        .table tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }
        
        .badge { 
            padding: 6px 12px; 
            border-radius: 9999px; 
            font-size: 11px; 
            font-weight: 700; 
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: inline-block;
        }
        
        .badge-pending { 
            background: rgba(245, 158, 11, 0.15); 
            color: #fbbf24; 
            border: 1px solid rgba(245, 158, 11, 0.3);
        }
        
        .badge-disetujui { 
            background: rgba(16, 185, 129, 0.15); 
            color: #34d399; 
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        
        .badge-ditolak { 
            background: rgba(239, 68, 68, 0.15); 
            color: #f87171; 
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        
        .alert { 
            padding: 14px 20px; 
            border-radius: 12px; 
            margin-bottom: 24px; 
            font-size: 14px;
            font-weight: 500;
            border: 1px solid transparent;
        }
        
        .alert-success { 
            background: rgba(16, 185, 129, 0.15); 
            color: #34d399; 
            border-color: rgba(16, 185, 129, 0.25);
        }
        
        .alert-error { 
            background: rgba(239, 68, 68, 0.15); 
            color: #f87171; 
            border-color: rgba(239, 68, 68, 0.25);
        }
        
        .grid-4 { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); 
            gap: 20px; 
            margin-bottom: 24px; 
        }
        
        .stat-card { 
            background: rgba(17, 24, 39, 0.7); 
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 24px; 
            border-radius: 16px; 
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5); 
        }
        
        .stat-card h3 { 
            font-size: 28px; 
            font-weight: 800; 
            margin: 8px 0; 
        }

        a {
            color: #10b981;
            text-decoration: none;
            transition: color 0.2s;
        }

        a:hover {
            color: #34d399;
        }
    </style>
</head>
<body>
    <!-- Background glowing decorative circles -->
    <div style="position: fixed; width: 45vw; height: 45vw; border-radius: 50%; background: radial-gradient(circle, rgba(16, 185, 129, 0.06) 0%, rgba(0,0,0,0) 70%); top: -15%; left: -10%; z-index: -1; pointer-events: none; filter: blur(60px);"></div>
    <div style="position: fixed; width: 50vw; height: 50vw; border-radius: 50%; background: radial-gradient(circle, rgba(59, 130, 246, 0.04) 0%, rgba(0,0,0,0) 70%); bottom: -20%; right: -10%; z-index: -1; pointer-events: none; filter: blur(70px);"></div>

    <div class="sidebar">
        <div class="brand">⛰️ SIMPEND</div>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">📊 Dashboard</a>
        <a href="<?php echo e(route('admin.gunung.index')); ?>" class="<?php echo e(request()->routeIs('admin.gunung.*') ? 'active' : ''); ?>">🏔️ Data Gunung</a>
        <a href="<?php echo e(route('admin.orang-hilang.index')); ?>" class="<?php echo e(request()->routeIs('admin.orang-hilang.*') ? 'active' : ''); ?>">👤 Orang Hilang</a>
        <a href="<?php echo e(route('admin.blacklist.index')); ?>" class="<?php echo e(request()->routeIs('admin.blacklist.*') ? 'active' : ''); ?>">🚫 Daftar Blacklist</a>
        <a href="<?php echo e(route('admin.manifes')); ?>" class="<?php echo e(request()->routeIs('admin.manifes') ? 'active' : ''); ?>">📋 Cetak Manifes</a>
        
        <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin-top: auto;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-danger btn-sm" style="width: 100%;">🚪 Logout</button>
        </form>
    </div>
    
    <div class="main">
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="alert alert-error">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($error); ?><br>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\SIMPEND\simpend-laravel\resources\views/layouts/admin.blade.php ENDPATH**/ ?>