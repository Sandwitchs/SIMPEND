@extends('layouts.admin')

@section('title', 'Edit Data Orang Hilang')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h1>Edit Data Orang Hilang</h1>
    <a href="{{ route('admin.orang-hilang.index') }}" class="btn btn-outline">← Kembali</a>
</div>

<div class="card" style="max-width: 700px;">
    <form method="POST" action="{{ route('admin.orang-hilang.update', $orangHilang->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Lengkap <span style="color:#dc2626">*</span></label>
            <input type="text" name="nama" value="{{ old('nama', $orangHilang->nama) }}" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label>Umur <span style="color:#dc2626">*</span></label>
                <input type="number" name="umur" value="{{ old('umur', $orangHilang->umur) }}" min="1" max="120" required>
            </div>
            <div class="form-group">
                <label>Kontak Keluarga / Pelapor</label>
                <input type="text" name="kontak_keluarga" value="{{ old('kontak_keluarga', $orangHilang->kontak_keluarga) }}" placeholder="Contoh: 0812-3456-7890">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label>Lokasi Terakhir Diketahui <span style="color:#dc2626">*</span></label>
                <input type="text" name="lokasi_terakhir" value="{{ old('lokasi_terakhir', $orangHilang->lokasi_terakhir) }}" required>
            </div>
            <div class="form-group">
                <label>Tanggal Mulai Hilang <span style="color:#dc2626">*</span></label>
                <input type="date" name="tanggal_hilang" value="{{ old('tanggal_hilang', $orangHilang->tanggal_hilang->format('Y-m-d')) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label>Deskripsi Ciri-ciri / Keterangan Terakhir</label>
            <textarea name="deskripsi_terakhir" rows="4">{{ old('deskripsi_terakhir', $orangHilang->deskripsi_terakhir) }}</textarea>
        </div>

        <div class="form-group">
            <label>Foto (Kosongkan jika tidak ingin mengubah)</label>
            @if($orangHilang->foto)
                <div style="margin-bottom: 10px;">
                    <img src="{{ Storage::url($orangHilang->foto) }}" alt="Foto {{ $orangHilang->nama }}"
                         style="width: 120px; height: 140px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb;">
                    <p style="font-size: 12px; color: #6b7280; margin-top: 4px;">Foto saat ini</p>
                </div>
            @endif
            <input type="file" name="foto" accept=".jpg,.jpeg,.png">
        </div>

        <div class="form-group">
            <label>Status Pencarian <span style="color:#dc2626">*</span></label>
            <select name="status" required>
                <option value="belum ditemukan" {{ old('status', $orangHilang->status) == 'belum ditemukan' ? 'selected' : '' }}>Belum Ditemukan</option>
                <option value="ditemukan" {{ old('status', $orangHilang->status) == 'ditemukan' ? 'selected' : '' }}>✅ Ditemukan</option>
            </select>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 8px;">
            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
            <a href="{{ route('admin.orang-hilang.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
