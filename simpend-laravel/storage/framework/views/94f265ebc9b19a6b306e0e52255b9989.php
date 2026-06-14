<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }
    .stat-card-premium {
        background: rgba(17, 24, 39, 0.75);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
        padding: 22px;
        position: relative;
        overflow: hidden;
        border-left: 4px solid rgba(255, 255, 255, 0.15);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px 0 rgba(0, 0, 0, 0.5);
    }
    .stat-card-premium.revenue { border-left-color: #10b981; }
    .stat-card-premium.active-climbers { border-left-color: #3b82f6; }
    .stat-card-premium.blacklist { border-left-color: #ef4444; }
    .stat-card-premium.total { border-left-color: #9ca3af; }
    .stat-card-premium.pending { border-left-color: #f59e0b; }
    .stat-card-premium.approved { border-left-color: #10b981; }
    .stat-card-premium.rejected { border-left-color: #ef4444; }
    
    .stat-card-premium .label {
        font-size: 11px;
        color: #9ca3af;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .stat-card-premium .value {
        font-size: 26px;
        font-weight: 800;
        color: #ffffff;
        margin-top: 8px;
    }
    .charts-container {
        display: grid;
        grid-template-columns: 3fr 2fr;
        gap: 20px;
        margin-bottom: 24px;
    }
    @media (max-width: 1024px) {
        .charts-container {
            grid-template-columns: 1fr;
        }
    }
    .chart-card {
        background: rgba(17, 24, 39, 0.75);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
        padding: 24px;
    }
    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        padding-bottom: 12px;
    }
    .chart-title {
        font-size: 16px;
        font-weight: 700;
        color: #ffffff;
    }
    .table-container {
        overflow-x: auto;
    }
    
    h1 {
        background: linear-gradient(135deg, #ffffff, #9ca3af);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>

<h1 style="margin-bottom: 24px; font-weight: 800; font-size: 28px;">📊 Dashboard Admin</h1>

<!-- Baris 1: Ringkasan Utama & Finansial -->
<div class="stats-container">
    <div class="stat-card-premium revenue">
        <div class="label">💰 Total Pendapatan (Lunas)</div>
        <div class="value" style="background: linear-gradient(135deg, #10b981, #34d399); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            Rp <?php echo e(number_format($total_pendapatan, 0, ',', '.')); ?>

        </div>
    </div>
    <div class="stat-card-premium active-climbers">
        <div class="label">⛰️ Sedang Mendaki</div>
        <div class="value"><?php echo e($sedang_mendaki); ?> <span style="font-size: 14px; font-weight: 500; color: #9ca3af;">Kelompok</span></div>
    </div>
    <div class="stat-card-premium blacklist">
        <div class="label">🚫 Total Blacklist</div>
        <div class="value"><?php echo e($total_blacklist); ?> <span style="font-size: 14px; font-weight: 500; color: #9ca3af;">NIK</span></div>
    </div>
</div>

<!-- Baris 2: Detail Pendaftaran -->
<div class="stats-container" style="margin-bottom: 32px;">
    <div class="stat-card-premium total">
        <div class="label">📝 Total Pendaftaran</div>
        <div class="value"><?php echo e($total); ?></div>
    </div>
    <div class="stat-card-premium pending">
        <div class="label">⏳ Menunggu Verifikasi</div>
        <div class="value" style="color: #fbbf24;"><?php echo e($pending); ?></div>
    </div>
    <div class="stat-card-premium approved">
        <div class="label">✅ Disetujui</div>
        <div class="value" style="color: #34d399;"><?php echo e($disetujui); ?></div>
    </div>
    <div class="stat-card-premium rejected">
        <div class="label">❌ Ditolak</div>
        <div class="value" style="color: #f87171;"><?php echo e($ditolak); ?></div>
    </div>
</div>

<!-- Baris 3: Grafik Statistik (Chart.js) -->
<div class="charts-container">
    <div class="chart-card">
        <div class="chart-header">
            <div class="chart-title">📈 Tren Pendaftaran Bulanan</div>
            <span style="font-size: 12px; background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3); padding: 4px 10px; border-radius: 9999px; font-weight: 600;">12 Bulan Terakhir</span>
        </div>
        <div style="height: 300px; position: relative;">
            <canvas id="chartBulanan"></canvas>
        </div>
    </div>
    
    <div class="chart-card">
        <div class="chart-header">
            <div class="chart-title">🏔️ 5 Gunung Terfavorit</div>
            <span style="font-size: 12px; background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); padding: 4px 10px; border-radius: 9999px; font-weight: 600;">Pendaftaran Disetujui</span>
        </div>
        <div style="height: 300px; position: relative; display: flex; justify-content: center; align-items: center;">
            <canvas id="chartGunung"></canvas>
        </div>
    </div>
</div>

<!-- Baris 4: Tabel Pendaftaran Terbaru -->
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="font-size: 18px; font-weight: 700; color: #ffffff;">Daftar Pendaftaran Terbaru</h2>
        <span style="font-size: 13px; color: #9ca3af;">Menampilkan semua riwayat</span>
    </div>
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID Booking</th>
                    <th>Nama Ketua</th>
                    <th>Gunung & Jalur</th>
                    <th>Tanggal Pendakian</th>
                    <th>Status Verifikasi</th>
                    <th>Status Pendakian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $pendaftaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><strong><?php echo e($p->id_booking); ?></strong></td>
                    <td><?php echo e($p->nama_ketua); ?></td>
                    <td><?php echo e($p->gunung->nama_gunung); ?> (<?php echo e($p->gunung->jalur); ?>)</td>
                    <td><?php echo e(date('d/m/Y', strtotime($p->tanggal_pendakian))); ?></td>
                    <td>
                        <span class="badge badge-<?php echo e($p->status_verifikasi); ?>">
                            <?php echo e(strtoupper($p->status_verifikasi)); ?>

                        </span>
                    </td>
                    <td>
                        <?php if($p->status_pendakian == 'belum_mendaki'): ?>
                            <span class="badge" style="background: rgba(255, 255, 255, 0.08); color: #d1d5db; border: 1px solid rgba(255, 255, 255, 0.15);">Belum Mendaki</span>
                        <?php elseif($p->status_pendakian == 'sedang_mendaki'): ?>
                            <span class="badge" style="background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3);">Sedang Mendaki</span>
                        <?php elseif($p->status_pendakian == 'selesai'): ?>
                            <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3);">Selesai</span>
                        <?php elseif($p->is_overdue): ?>
                            <span class="badge" style="background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3);">Overdue</span>
                        <?php else: ?>
                            <span class="badge" style="background: rgba(255, 255, 255, 0.08); color: #d1d5db;"><?php echo e($p->status_pendakian); ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo e(route('admin.pendaftaran.show', $p->id)); ?>" class="btn btn-primary btn-sm">Detail</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Load Chart.js dari CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Data Bulanan
        const labelBulan = <?php echo json_encode($labelBulan, 15, 512) ?>;
        const dataBulan = <?php echo json_encode($dataBulan, 15, 512) ?>;
        
        // Data Gunung
        const labelGunung = <?php echo json_encode($labelGunung, 15, 512) ?>;
        const dataGunung = <?php echo json_encode($dataGunung, 15, 512) ?>;
        
        // Render Chart Bulanan
        const ctxBulan = document.getElementById('chartBulanan').getContext('2d');
        new Chart(ctxBulan, {
            type: 'bar',
            data: {
                labels: labelBulan.length > 0 ? labelBulan : ['Belum ada data'],
                datasets: [{
                    label: 'Jumlah Pendaftaran',
                    data: dataBulan.length > 0 ? dataBulan : [0],
                    backgroundColor: 'rgba(16, 185, 129, 0.8)',
                    borderColor: 'rgb(16, 185, 129)',
                    borderWidth: 1.5,
                    borderRadius: 6,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleColor: '#ffffff',
                        bodyColor: '#e5e7eb',
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            color: '#9ca3af'
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#9ca3af'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
        
        // Render Chart Gunung
        const ctxGunung = document.getElementById('chartGunung').getContext('2d');
        new Chart(ctxGunung, {
            type: 'doughnut',
            data: {
                labels: labelGunung.length > 0 ? labelGunung : ['Belum ada data'],
                datasets: [{
                    data: dataGunung.length > 0 ? dataGunung : [0],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.85)',
                        'rgba(59, 130, 246, 0.85)',
                        'rgba(245, 158, 11, 0.85)',
                        'rgba(239, 68, 68, 0.85)',
                        'rgba(139, 92, 246, 0.85)'
                    ],
                    borderColor: '#0b111e',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 15,
                            color: '#9ca3af',
                            font: {
                                size: 11,
                                family: "'Plus Jakarta Sans', sans-serif"
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleColor: '#ffffff',
                        bodyColor: '#e5e7eb',
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1
                    }
                },
                cutout: '65%'
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SIMPEND\simpend-laravel\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>