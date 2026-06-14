@extends('layouts.admin')

@section('title', 'Edit Gunung')

@section('content')
<h1 style="margin-bottom: 24px;">Edit Data Gunung</h1>

<div class="card" style="max-width: 520px;">
    <form method="POST" action="{{ route('admin.gunung.update', $gunung->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nama Gunung</label>
            <input type="text" name="nama_gunung" value="{{ $gunung->nama_gunung }}" required>
        </div>
        <div class="form-group">
            <label>Jalur</label>
            <input type="text" name="jalur" value="{{ $gunung->jalur }}" required>
        </div>
        <div class="form-group">
            <label>Kuota Maks (orang)</label>
            <input type="number" name="kuota_maks" value="{{ $gunung->kuota_maks }}" min="1" required>
        </div>
        <div class="form-group">
            <label>Harga Camp Per Orang (Rp)</label>
            <input type="number" name="harga_per_orang" value="{{ $gunung->harga_per_orang }}" min="0" required>
        </div>
        <div class="form-group">
            <label>Harga Tektok Per Orang (Rp)</label>
            <input type="number" name="harga_per_orang_tektok" value="{{ $gunung->harga_per_orang_tektok }}" min="0" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.gunung.index') }}" class="btn btn-outline">Kembali</a>
    </form>
</div>
@endsection
