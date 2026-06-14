@extends('layouts.admin')

@section('title', 'Edit Blacklist')

@section('content')
<h1 style="margin-bottom: 24px;">Edit Data Blacklist</h1>

<div class="card" style="max-width: 520px;">
    <form method="POST" action="{{ route('admin.blacklist.update', $blacklist->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" value="{{ old('nama', $blacklist->nama) }}" required>
        </div>
        <div class="form-group">
            <label>No. KTP</label>
            <input type="text" name="no_ktp" value="{{ old('no_ktp', $blacklist->no_ktp) }}" required>
        </div>
        <div class="form-group">
            <label>Alasan Blacklist</label>
            <textarea name="alasan" rows="4" required>{{ old('alasan', $blacklist->alasan) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.blacklist.index') }}" class="btn btn-outline">Kembali</a>
    </form>
</div>
@endsection
