@extends('layouts.admin')

@section('title', 'Tambah Blacklist')

@section('content')
<h1 style="margin-bottom: 24px;">Tambah Pendaki ke Blacklist</h1>

<div class="card" style="max-width: 520px;">
    <form method="POST" action="{{ route('admin.blacklist.store') }}">
        @csrf
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" value="{{ old('nama') }}" required>
        </div>
        <div class="form-group">
            <label>No. KTP</label>
            <input type="text" name="no_ktp" value="{{ old('no_ktp') }}" placeholder="Contoh: 3201xxxxxxxxxxxx" required>
        </div>
        <div class="form-group">
            <label>Alasan Blacklist</label>
            <textarea name="alasan" rows="4" required>{{ old('alasan') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.blacklist.index') }}" class="btn btn-outline">Kembali</a>
    </form>
</div>
@endsection
