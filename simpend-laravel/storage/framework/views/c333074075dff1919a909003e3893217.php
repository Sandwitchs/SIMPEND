<?php $__env->startSection('title', 'Daftar Pendakian'); ?>

<?php $__env->startSection('content'); ?>
<h1 style="margin-bottom: 24px;">Daftar Pendakian Baru</h1>

<div class="card">
    <form method="POST" action="<?php echo e(route('pendaki.pendaftaran.store')); ?>" enctype="multipart/form-data" id="formPendaftaran">
        <?php echo csrf_field(); ?>
        
        <h3 style="margin-bottom: 16px;">1. Informasi Pendakian</h3>
        <div class="form-group">
            <label>Pilih Gunung & Jalur</label>
            <select name="gunung_id" id="gunungSelect" required>
                <option value="">-- Pilih Gunung & Jalur --</option>
                <?php $__currentLoopData = $gunung; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($g->id); ?>"><?php echo e($g->nama_gunung); ?> (<?php echo e($g->jalur); ?>) - Camp: Rp <?php echo e(number_format($g->harga_per_orang, 0, ',', '.')); ?> / Tektok: Rp <?php echo e(number_format($g->harga_per_orang_tektok, 0, ',', '.')); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group">
            <label>Tanggal Pendakian</label>
            <input type="date" name="tanggal_pendakian" id="tanggalInput" required>
        </div>
        <div id="kuotaInfo" style="margin-bottom: 16px;"></div>
        
        <div class="form-group">
            <label>Nama Ketua Tim</label>
            <input type="text" name="nama_ketua" required>
        </div>
        <div class="form-group">
            <label>Jumlah Anggota (termasuk ketua, maks 10)</label>
            <input type="number" name="jumlah_anggota" id="jumlahAnggota" min="1" max="10" required>
        </div>
        
        <div class="form-group">
            <label>Jenis Pendakian</label>
            <select name="jenis_pendakian" required>
                <option value="camp" <?php echo e(old('jenis_pendakian') == 'camp' ? 'selected' : ''); ?>>Camp (Bermalam)</option>
                <option value="tektok" <?php echo e(old('jenis_pendakian') == 'tektok' ? 'selected' : ''); ?>>Tektok (Langsung Turun)</option>
            </select>
        </div>

        <h3 style="margin: 24px 0 16px;">2. Upload Dokumen</h3>
        <div class="form-group">
            <label>Dokumen KTP Ketua</label>
            <input type="file" name="dokumen_ktp" accept=".pdf,.jpg,.jpeg,.png" required>
        </div>
        <div class="form-group">
            <label>Surat Keterangan Sehat</label>
            <input type="file" name="dokumen_sehat" accept=".pdf,.jpg,.jpeg,.png" required>
        </div>

        <h3 style="margin: 24px 0 16px;">3. Data Anggota</h3>
        <div id="anggotaContainer"></div>

        <div style="margin-top: 24px;">
            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" disabled>Daftar Pendakian</button>
            <a href="<?php echo e(route('pendaki.dashboard')); ?>" class="btn btn-outline">Kembali</a>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function generateAnggotaFields() {
    const jumlah = parseInt($('#jumlahAnggota').val()) || 0;
    const container = $('#anggotaContainer');
    container.empty();
    
    for (let i = 1; i <= jumlah; i++) {
        const isKetua = i === 1;
        container.append(`
            <div style="background: #f9fafb; padding: 16px; border-radius: 8px; margin-bottom: 16px;">
                <h4 style="margin-bottom: 12px;">Anggota ${i} ${isKetua ? '(Ketua)' : ''}</h4>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="anggota[${i-1}][nama]" required>
                </div>
                <div class="form-group">
                    <label>No. KTP</label>
                    <input type="text" name="anggota[${i-1}][no_ktp]" required>
                </div>
                <div class="form-group">
                    <label>Usia</label>
                    <input type="number" name="anggota[${i-1}][usia]" min="5" required>
                </div>
                <div class="form-group">
                    <label>No. HP</label>
                    <input type="text" name="anggota[${i-1}][no_hp]" required>
                </div>
            </div>
        `);
    }
}

function cekKuota() {
    const gunungId = $('#gunungSelect').val();
    const tanggal = $('#tanggalInput').val();
    
    if (gunungId && tanggal) {
        $.post('<?php echo e(route("pendaki.cek-kuota")); ?>', {
            _token: '<?php echo e(csrf_token()); ?>',
            gunung_id: gunungId,
            tanggal: tanggal
        }, function(data) {
            const sisa = data.sisa;
            const max = data.max;
            let html = '';
            let disabled = true;
            
            if (sisa > 0) {
                html = `<div class="alert alert-success">✅ Sisa Kuota: ${sisa} dari ${max} orang</div>`;
                disabled = false;
            } else {
                html = `<div class="alert alert-error">❌ Kuota Penuh! Silakan pilih tanggal lain.</div>`;
                disabled = true;
            }
            
            $('#kuotaInfo').html(html);
            $('#submitBtn').prop('disabled', disabled);
        });
    }
}

$('#jumlahAnggota').on('change', generateAnggotaFields);
$('#gunungSelect, #tanggalInput').on('change', cekKuota);
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SIMPEND\simpend-laravel\resources\views/pendaki/pendaftaran/create.blade.php ENDPATH**/ ?>